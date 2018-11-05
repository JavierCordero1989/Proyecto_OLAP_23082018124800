<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Universidad;
use App\Disciplina;
use App\Agrupacion;
use Carbon\Carbon;
use App\Carrera;
use App\Sector;
use App\Grado;
use App\Area;
use Flash;
use DB;

/*
 * Impide que el servidor genere un error debido al tiempo
 * de espera seteado de 60 segundos.
*/ 
set_time_limit(300);

class ExportImportExcelController extends Controller
{
    private $casos_duplicados = [];
    private $carreras_no_encontradas = [];
    private $universidades_no_encontradas = [];
    private $grados_no_encontrados = [];
    private $disciplinas_no_encontradas = [];
    private $areas_no_encontradas = [];
    private $agrupaciones_no_encontradas = [];
    private $sectores_no_encontrados = [];
    private $data_file = [];
    private $entrevistas_guardadas = 0;
    private $id_estado;

    public function __construct() {
        $this->id_estado = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();
        $this->id_estado = $this->id_estado->id;
    }

    public function create() {
        return view('excel.create');
    }

    public function exportar_a_excel() {
        //Se deben tomar los datos que se quieren exportar al archivo excel
        $data = Model::all();

        /** Si no existen datos almacenados, se devuelve un mensaje de error. */
        if(empty($data)) {
            Flash::error('mensaje de error');
            return redirect(route('ruta_a_dirigir'));
        }

        //Se crea el archivo de excel
        Excel::create('nombre del archivo', function($excel) use($data){
            //Se crea una hoja del libro de excel
            $excel->sheet('nombre de la hoja', function($excel) use($data) {
                //Se insertan los datos en la hoja con el metodo with o fromArray
                /* Parametros:
                1: datos a guardar,
                2: valores del encabezado de la columna,
                3: celda de inicio,
                4: comparacionn estricta de los valores del encabezado,
                5: impresion de los encabezados */
                $sheet->with($data, null, 'A1', false, false);
            });
            /** Se descarga el archivo a la extension deseada, xlsx, xls */
        })->download('xlsx');

        Flash::success('mensaje de exito');
        return redirect(route('ruta_a_dirigir'));
    }// Fin de la funcion exportar_a_excel

    protected function guardar_a_base_de_datos(Request $request) {
        $archivo = $request->file('archivo_nuevo');

        /** El método load permite cargar el archivo definido como primer parámetro */
        Excel::load($archivo, function ($reader) {

            //Se inicia un contador en cero para saber cuantas entrevistas son subidas
            $contador_entrevistas = 0;

            //Se guardan estas variables para conocer las variables de la muestra
            $universidad = 0;
            $grado = 0;
            $disciplina = 0;
            $tipo_de_caso = 0;

            /**
             * $reader->get() nos permite obtener todas las filas de nuestro archivo
             */
            foreach ($reader->get() as $key => $row) {

                $identificacion_graduado = $row['identificacion'];
                $nombre_completo         = $row['nombre'];
                $annio_graduacion        = $row['ano_de_graduacion'];
                $link_encuesta           = $row['link_de_encuesta'];
                $sexo                    = $row['sexo'];
                $token                   = $row['token'];
                $codigo_carrera          = $row['codigo_carrera'];
                $codigo_universidad      = $row['codigo_universidad'];
                $codigo_grado            = $row['codigo_grado'];
                $codigo_disciplina       = $row['codigo_disciplina'];
                $codigo_area             = $row['codigo_area'];
                $codigo_agrupacion       = $row['codigo_agrupacion'];
                $codigo_sector           = $row['codigo_sector'];
                $tipo_de_caso            = $row['tipo_de_caso'];
                $created_at              = Carbon::now();

                //Se busca el duplicado por el token
                $entrevista_duplicada = $this->buscarTokenDuplicado($token);

                //Si la entrevista obtenida no es nula, quiere decir que existe un registro con el token 
                if(!empty($entrevista_duplicada)) {
                    //Guardar el evento generado por esta acción.
                    array_push($this->casos_duplicados, ('El caso con el token <b>'.$token.'</b> ya se encuentra registrado.'));
                    continue;
                }

                /* Se busca la carrera por código y así comprobar su existencia */
                $carrera_buscada = $this->buscarCarreraPorCodigo($codigo_carrera);

                /* Si la carrera obtenida está vacía, quiere decir que el código ingresado no 
                corresponde a ningun dato en la BD. */
                if(empty($carrera_buscada)) {
                    array_push($this->carreras_no_encontradas, ('Carrera no encontrada con el código <b>'.$codigo_carrera.'</b> para el caso con token '.$token));
                    continue;
                }
                else {
                    //Se guarda el ID para pasarlo a la BD
                    $codigo_carrera = $carrera_buscada->id;
                }

                /* Se busca la universidad por código y así poder comprobar su existencia. */
                $universidad_buscada = $this->buscarUniversidadPorCodigo($codigo_universidad);

                /* Si la universidad obtenida está vacía, quiere decir que el código ingresado no
                corresponde a ningun dato en la BD. */
                if(empty($universidad_buscada)) {
                    array_push($this->universidades_no_encontradas, ('Universidad no encontrada con el código <b>'.$codigo_universidad.'</b> para el caso con token '.$token));
                    continue;
                }
                else {
                    $codigo_universidad = $universidad_buscada->id;
                }

                /* Se busca el grado por el código y así poder comprobar su existencia */
                $grado_buscado = $this->buscarGradoPorCodigo($codigo_grado);

                /* Si el grado obtenido está vacío, quiere decir que el código ingresado no
                corresponde a ningun dato en la BD. */
                if(empty($grado_buscado)) {
                    array_push($this->grados_no_encontrados, ('Grado no encontrado con el código <b>'.$codigo_grado.'</b> para el caso con token '.$token));
                    continue;
                }
                else {
                    $codigo_grado = $grado_buscado->id;
                }

                /* Se busca la disciplina por el código y así poder comprobar su existencia */
                $disciplina_buscada = $this->buscarDisciplinaPorCodigo($codigo_disciplina);

                /* Si la disciplina obtenida está vacía, quiere decir que el código ingresado no
                corresponde a ningun dato en la BD. */
                if(empty($disciplina_buscada)) {
                    array_push($this->disciplinas_no_encontradas, ('Disciplina no encontrada con el código <b>'.$codigo_disciplina.'</b> para el caso con token '.$token));
                    continue;
                }
                else {
                    $codigo_disciplina = $disciplina_buscada->id;
                }

                /* Se busca el área por el código y así poder comprobar su existencia */
                $area_buscada = $this->buscarAreaPorCodigo($codigo_area);

                /* Si el área obtenida está vacía, quiere decir que el código ingresado no
                corresponde a ningun dato en la BD. */
                if(empty($area_buscada)) {
                    array_push($this->areas_no_encontradas, ('Área no encontrada con el código <b>'.$codigo_area.'</b> para el caso con token '.$token));
                    continue;
                }
                else {
                    $codigo_area = $area_buscada->id;
                }

                /* Se busca la agrupcación por el código y así poder comprobar su existencia */
                $agrupación_buscada = $this->buscarAgrupacionPorCodigo($codigo_agrupacion);

                /* Si la agrupación obtenida está vacía, quiere decir que el código ingresado no
                corresponde a ningun dato en la BD. */
                if(empty($agrupación_buscada)) {
                    array_push($this->agrupaciones_no_encontradas, ('Agrupación no encontrada con el código <b>'.$codigo_agrupacion.'</b> para el caso con token '.$token));
                    continue;
                }
                else {
                    $codigo_agrupacion = $agrupación_buscada->id;
                }

                /* Se busca el sector por el código y así poder comprobar su existencia */
                $sector_buscado = $this->buscarSectorPorCodigo($codigo_sector);

                /* Si el sector obtenido está vacío, quiere decir que el código ingresado no
                corresponde a ningun dato en la BD. */
                if(empty($sector_buscado)) {
                    array_push($this->sectores_no_encontrados, ('Sector no encontrado con el código <b>'.$codigo_sector.'</b> para el caso con token '.$token));
                    continue;
                }
                else {
                    $codigo_sector = $sector_buscado->id;
                }      

                /* SI TODAS LAS VALIDACIONES HAN SALIDO BIEN HASTA ESTE PUNTO, SE PROCEDE A GUARDAR EL REGISTRO
                EN LA BASE DE DATOS. */
                $data = [
                    'identificacion_graduado' => $identificacion_graduado,
                    'nombre_completo'         => $nombre_completo,
                    'annio_graduacion'        => $annio_graduacion,
                    'link_encuesta'           => $link_encuesta,
                    'sexo'                    => $sexo,
                    'token'                   => $token,
                    'codigo_carrera'          => $codigo_carrera,
                    'codigo_universidad'      => $codigo_universidad,
                    'codigo_grado'            => $codigo_grado,
                    'codigo_disciplina'       => $codigo_disciplina,
                    'codigo_area'             => $codigo_area,
                    'codigo_agrupacion'       => $codigo_agrupacion,
                    'codigo_sector'           => $codigo_sector,
                    'tipo_de_caso'            => $tipo_de_caso,
                    'created_at'              => $created_at
                ];

                /* Una vez obtenido los datos de la fila procedemos a registrarlos */
                if(!empty($data)){
                    // Entrevista::create($data);
                    array_push($this->data_file, $data);
                    $contador_entrevistas++; //Se incrementa para guardarlo como total de casos
                }
            }

            $this->entrevistas_guardadas = $contador_entrevistas;

            /* Se crea un array con los datos que contendrá el reporte */
            $data_reporte = [
                'codigo_disciplina'  => $codigo_disciplina,
                'codigo_grado'       => $codigo_grado,
                'codigo_universidad' => $codigo_universidad,
                'tipo_de_caso'       => $tipo_de_caso,
                'total_casos'        => $contador_entrevistas,
                'created_at'         => $created_at
            ];

            /* Se guarda el reporte en la tabla con los datos recién subidos desde Excel a la BD. */
            if(!empty($data_reporte)) {
                // DB::table('tbl_reportes_entrevistas')->insert($data_reporte);
            }
        });
    }

    public function importar_desde_excel(Request $request) {

        // sleep(2);

        /** Si viene un archivo en el request
         * 'archivo_nuevo' => es el nombre del campo que tiene el formulario
         * en la página html.
         */
        if($request->hasFile('archivo_nuevo')) {
            //Llama a la función para guardar desde el excel a la BD
            self::guardar_a_base_de_datos($request);

            $reporte = $this->obtenerReporteArchivo();
            $data_file = $this->data_file;

            /* Cuando el arreglo de reporte tenga solo un dato, es porque solo se almacenó
            la variable de contador de entrevistas guardadas, por lo que no será
            necesario enviar alguna alerta. */
            if(sizeof($reporte) == 1) {
                foreach($data_file as $data ) {
                    $entrevista = Entrevista::create($data);
                    $entrevista->asignarEstado($this->id_estado);
                }

                Flash::success('El archivo se ha guardado correctamente en la Base de Datos');
                return redirect(route('encuestas-graduados.index'));
            }
            /* Cuando el arreglo tiene mas de un dato, quiere decir que hubo errores al leer los datos del
            archivo de excel, por lo que deben ser mostrados en una vista que indique todo los sucedido. */
            else {
                return view('excel.informe-de-errores', compact('reporte', 'data_file'));
            }

            Flash::success('El archivo se ha guardado correctamente en la Base de Datos');
            return redirect(route('encuestas-graduados.index'));
        }
        else {
            Flash::success('No ha enviado un archivo');
            return redirect(route('home'));
        }
    }// Fin de la funcion importar_desde_excel

    /* Guardará todos los registros que el usuario decida salvar después de recibir la notificación.
    Se recibe un arreglo con los datos en forma de arreglo de cada entrevista, serializados desde
    el formulario, y el se deserealizaran para guardarlos en la BD. */
    public function guardarRegistrosAceptados(Request $request) {
        $data = $request->data_file; //Se obtienen los datos serealizados

        foreach($data as $item) {
            //Se deserealiza cada dato y se guarda en la BD
            $entrevista = Entrevista::create(unserialize($item));
            $entrevista->asignarEstado($this->id_estado);

            Flash::success('Se han guardado las encuestas aceptadas.');
            return redirect(route('encuestas-graduados.index'));
        }
    }

    /* Busca mediante el token, que una entrevista esté o no duplicada, para verificar dicha información y 
    dar un reporte al final de la carga del archivo. */
    private function buscarTokenDuplicado($token) {
        $entrevista = Entrevista::where('token', $token)->first();
        return $entrevista;
    }

    private function buscarCarreraPorCodigo($codigo_carrera) {
        $carrera = Carrera::buscarPorCodigo($codigo_carrera)->first();
        return $carrera;
    }

    private function buscarUniversidadPorCodigo($codigo_universidad) {
        $universidad = Universidad::buscarPorCodigo($codigo_universidad)->first();
        return $universidad;
    }

    private function buscarGradoPorCodigo($codigo_grado) {
        $grado = Grado::buscarPorCodigo($codigo_grado)->first();
        return $grado;
    }

    private function buscarDisciplinaPorCodigo($codigo_disciplina) {
        $disciplina = Disciplina::buscarPorCodigo($codigo_disciplina)->first();
        return $disciplina;
    }

    private function buscarAreaPorCodigo($codigo_area) {
        $area = Area::buscarPorCodigo($codigo_area)->first();
        return $area;
    }

    private function buscarAgrupacionPorCodigo($codigo_agrupacion) {
        $agrupacion = Agrupacion::buscarPorCodigo($codigo_agrupacion)->first();
        return $agrupacion;
    }

    private function buscarSectorPorCodigo($codigo_sector) {
        $sector = Sector::buscarPorCodigo($codigo_sector)->first();
        return $sector;
    }

    private function obtenerReporteArchivo() {
        $reporte = [];
        $encabezados_panel = [];

        if(sizeof($this->casos_duplicados) > 0) {
            // $reporte['casos_duplicados'] = $this->casos_duplicados;
            $reporte[] = $this->casos_duplicados;
            array_push($encabezados_panel, 'Casos duplicados');
        }

        if(sizeof($this->carreras_no_encontradas) > 0) {
            // $reporte['carreras_no_encontradas'] = $this->carreras_no_encontradas;
            $reporte[] = $this->carreras_no_encontradas;
            array_push($encabezados_panel, 'Carreras');
        }

        if(sizeof($this->universidades_no_encontradas) > 0) {
            // $reporte['universidades_no_encontradas'] = $this->universidades_no_encontradas;
            $reporte[] = $this->universidades_no_encontradas;
            array_push($encabezados_panel, 'Universidades');
        }

        if(sizeof($this->grados_no_encontrados) > 0) {
            // $reporte['grados_no_encontrados'] = $this->grados_no_encontrados;
            $reporte[] = $this->grados_no_encontrados;
            array_push($encabezados_panel, 'Grados');
        }

        if(sizeof($this->disciplinas_no_encontradas) > 0) {
            // $reporte['disciplinas_no_encontradas'] = $this->disciplinas_no_encontradas;
            $reporte[] = $this->disciplinas_no_encontradas;
            array_push($encabezados_panel, 'Disciplinas');
        }

        if(sizeof($this->areas_no_encontradas) > 0) {
            // $reporte['areas_no_encontrada'] = $this->areas_no_encontradas;
            $reporte[] = $this->areas_no_encontradas;
            array_push($encabezados_panel, 'Áreas');
        }

        if(sizeof($this->agrupaciones_no_encontradas) > 0) {
            // $reporte['agrupaciones_no_encontradas'] = $this->agrupaciones_no_encontradas;
            $reporte[] = $this->agrupaciones_no_encontradas;
            array_push($encabezados_panel, 'Agrupaciones');
        }

        if(sizeof($this->sectores_no_encontrados) > 0) {
            // $reporte['sectores_no_encontrados'] = $this->sectores_no_encontrados;
            $reporte[] = $this->sectores_no_encontrados;
            array_push($encabezados_panel, 'Sectores');
        }

        $reporte['total_entrevistas_guardadas'] = ('El total de casos aptos para guardarse es de <b>'.$this->entrevistas_guardadas.'</b> entrevistas');
        
        if(sizeof($reporte) > 1) {
            $reporte['encabezados_panel'] = $encabezados_panel;
        }
        
        return $reporte;
    }
}
