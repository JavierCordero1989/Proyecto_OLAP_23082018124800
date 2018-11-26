<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\ContactoGraduado;
use App\DetalleContacto;
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

    /* PARA REPORTE DEL ARCHIVO DE CONTACTOS */
    private $cedulas_graduados_repetidas = array();
    private $graduado_no_existen = array();
    private $numeros_ya_almacenados = array();
    private $data_general_contactos = array();

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
                $sexo                    = ($row['sexo'] == 'M' ? 'M' : ($row['sexo'] == 'F' ? 'F' : 'SC'));
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
            /* SE GUARDAN LOS DATOS DEL EXCEL EN UNA VARIABLE DE SESION*/
            // session(['data_excel' => $data_file]);
            session()->put('data_excel',$data_file);
            
            /* Cuando el arreglo de reporte tenga solo un dato, es porque solo se almacenó
            la variable de contador de entrevistas guardadas, por lo que no será
            necesario enviar alguna alerta. */
            if(sizeof($reporte) == 1) {
                $numeroDeCasos = 0;
                // $total_por_sexo = [
                //     'M'=>0,
                //     'F'=>0,
                //     'SC'=>0,
                // ];

                $total_por_sexo = array();
                $universidades = array();

                foreach($data_file as $data ) {
                    if(isset($total_por_sexo[$data['sexo']])) {
                        $total_por_sexo[$data['sexo']]++;
                    }
                    else {
                        $total_por_sexo[$data['sexo']] = 1;
                    }

                    $numeroDeCasos++;
                }

                $agrupacion = Agrupacion::buscarPorId($data_file[0]['codigo_agrupacion'])->first();
                $area = Area::find($data_file[0]['codigo_area']);
                $disciplina = Disciplina::find($data_file[0]['codigo_disciplina']);

                $report = [
                    'cantidad_de_casos' => $numeroDeCasos,
                    'total_por_sexo'=> $total_por_sexo,
                    'tipo_de_archivo'=>$data_file[0]['tipo_de_caso'],
                    'agrupacion'=>$agrupacion->nombre,
                    'area'=>$area->descriptivo,
                    'disciplina'=>$disciplina->descriptivo
                ];

                // Flash::success('El archivo se ha guardado correctamente en la Base de Datos');
                // return redirect(route('encuestas-graduados.index'));
                return view('excel.confirmacion-muestra')->with('report', $report);
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

    public function respuesta_archivo_muestra($respuesta) {
        if(isset($respuesta)){
            if($respuesta == 'SI') {

                $data_file = session()->get('data_excel');
                
                DB::beginTransaction();
                try {
                    foreach($data_file as $data ) {
                        $entrevista = Entrevista::create($data);
                        $entrevista->asignarEstado($this->id_estado);
                    }

                    DB::commit();

                    Flash::success('El archivo se ha guardado correctamente en la Base de Datos');
                    return redirect(route('encuestas-graduados.index'));
                }
                catch(\Exception $ex) {
                    DB::rollback();
                    Flash::overlay('Error en el sistema', $ex)->error();
                    return redirect(url('home'));
                }
            }
            else if($respuesta == 'NO') {
                session()->forget('data_excel');
                return redirect(url('home'));
            }
            else {
                return back();
            }
        }
        else {
            return back();
        }
    }

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

    public function createArchivoContactos() {
        return view('excel.subir-archivo-contactos');
    }



    public function subirArchivoExcelContactos(Request $request) {
        if($request->hasFile('archivo_contactos')) {
            $archivo = $request->file('archivo_contactos');
            
            // $encabezados = config('encabezados_contactos');

            Excel::load($archivo, function ($reader) {

                foreach ($reader->get() as $key => $row) {
                    // echo $row . "<br><br>";
                    /* ARRAY CON LOS DATOS DE CADA FILA */
                    $info_por_fila = array();

                    /* INFORMACIÓN DE PERFIL */
                    $cedula = $row['identificacion'];

                    $info_por_fila['identificacion_graduado'] = $cedula;
                    $info_por_fila['ids_graduado'] = $this->obtenerIdsPorCedula($cedula);

                    /* se comprueba que el graduado exista en la BD */
                    if(!$this->buscarGraduadoPorCedula($cedula)) {
                        $this->graduado_no_existen[] = 'No existe un graduado con la cédula <b>'.$cedula.'</b> en los registros.';
                        continue;
                    }

                    $info_de_contacto = array();

                    /* RESIDENCIALES DE PERFIL */
                    $residenciales = array();

                    $residenciales[] = $row['residencial_1'];
                    $residenciales[] = $row['residencial_2'];
                    $residenciales[] = $row['residencial_3'];
                    $residenciales[] = $row['residencial_4'];
                    $residenciales[] = $row['residencial_5'];

                    $residenciales = $this->comprobarNumeros($residenciales);

                    if(sizeof($residenciales) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto('', '', 'Residencial', $residenciales);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* CELULARES DE PERFIL */
                    $celulares = array();

                    $celulares[] = $row['celular_1'];
                    $celulares[] = $row['celular_2'];
                    $celulares[] = $row['celular_3'];
                    $celulares[] = $row['celular_4'];
                    $celulares[] = $row['celular_5'];

                    $celulares = $this->comprobarNumeros($celulares);

                    if(sizeof($celulares) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto('', '', 'Celular', $celulares);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }
                    
                    /* CORREOS DE PERFIL */
                    $correos = array();

                    $correos[] = $row['correo_1'];
                    $correos[] = $row['correo_2'];
                    $correos[] = $row['correo_3'];
                    $correos[] = $row['correo_4'];

                    $correos = $this->comprobarNumeros($correos);

                    if(sizeof($correos) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto('', '', 'Correo', $correos);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DE LA MADRE */
                    $info_madre = array();

                    $cedula_madre = $row['cedula_madre'];
                    $nombre_madre = $row['nombre_madre'];
                    $info_madre[] = $row['telefono_madre_1'];
                    $info_madre[] = $row['telefono_madre_2'];
                    $info_madre[] = $row['celular_madre_1'];
                    $info_madre[] = $row['celular_madre_2'];

                    $info_madre = $this->comprobarNumeros($info_madre);

                    if(sizeof($info_madre) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_madre, $nombre_madre, 'Madre', $info_madre);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL PADRE */
                    $info_padre = array();

                    $cedula_padre = $row['cedula_padre'];
                    $nombre_padre = $row['nombre_padre'];
                    $info_padre[] = $row['telefono_padre_1'];
                    $info_padre[] = $row['telefono_padre_2'];
                    $info_padre[] = $row['celular_padre_1'];
                    $info_padre[] = $row['celular_padre_2'];

                    $info_padre = $this->comprobarNumeros($info_padre);

                    if(sizeof($info_padre) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_padre, $nombre_padre, 'Padre', $info_padre);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL CONYUGE */
                    $info_conyuge = array();

                    $cedula_conyuge = $row['cedula_conyuge'];
                    $nombre_conyuge = $row['nombre_conyuge'];
                    $info_conyuge[] = $row['telefono_conyuge_1'];
                    $info_conyuge[] = $row['telefono_conyuge_2'];
                    $info_conyuge[] = $row['celular_conyuge_1'];
                    $info_conyuge[] = $row['celular_conyuge_2'];

                    $info_conyuge = $this->comprobarNumeros($info_conyuge);
                    
                    if(sizeof($info_conyuge) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_conyuge, $nombre_conyuge, 'Conyuge', $info_conyuge);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HIJO 1 */
                    $info_hijo_1 = array();

                    $cedula_hijo_1 = $row['cedula_hijo_1'];
                    $nombre_hijo_1 = $row['nombre_hijo_1'];
                    $info_hijo_1[] = $row['telefono_hijo_1_a'];
                    $info_hijo_1[] = $row['telefono_hijo_1_b'];
                    $info_hijo_1[] = $row['celular_hijo_1_c'];
                    $info_hijo_1[] = $row['celular_hijo_1_d'];

                    $info_hijo_1 = $this->comprobarNumeros($info_hijo_1);

                    if(sizeof($info_hijo_1) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hijo_1, $nombre_hijo_1, 'Hijo', $info_hijo_1);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HIJO 2 */
                    $info_hijo_2 = array();

                    $cedula_hijo_2 = $row['cedula_hijo_2'];
                    $nombre_hijo_2 = $row['nombre_hijo_2'];
                    $info_hijo_2[] = $row['telefono_hijo_2_a'];
                    $info_hijo_2[] = $row['telefono_hijo_2_b'];
                    $info_hijo_2[] = $row['celular_hijo_2_c'];
                    $info_hijo_2[] = $row['celular_hijo_2_d'];

                    $info_hijo_2 = $this->comprobarNumeros($info_hijo_2);

                    if(sizeof($info_hijo_2) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hijo_2, $nombre_hijo_2, 'Hijo', $info_hijo_2);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HIJO 3 */
                    $info_hijo_3 = array();

                    $cedula_hijo_3 = $row['cedula_hijo_3'];
                    $nombre_hijo_3 = $row['nombre_hijo_3'];
                    $info_hijo_3[] = $row['telefono_hijo_3_a'];
                    $info_hijo_3[] = $row['telefono_hijo_3_b'];
                    $info_hijo_3[] = $row['celular_hijo_3_c'];
                    $info_hijo_3[] = $row['celular_hijo_3_d'];

                    $info_hijo_3 = $this->comprobarNumeros($info_hijo_3);

                    if(sizeof($info_hijo_3) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hijo_3, $nombre_hijo_3, 'Hijo', $info_hijo_3);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HIJO 4 */
                    $info_hijo_4 = array();

                    $cedula_hijo_4 = $row['cedula_hijo_4'];
                    $nombre_hijo_4 = $row['nombre_hijo_4'];
                    $info_hijo_4[] = $row['telefono_hijo_4_a'];
                    $info_hijo_4[] = $row['telefono_hijo_4_b'];
                    $info_hijo_4[] = $row['celular_hijo_4_c'];
                    $info_hijo_4[] = $row['celular_hijo_4_d'];

                    $info_hijo_4 = $this->comprobarNumeros($info_hijo_4);

                    if(sizeof($info_hijo_4) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hijo_4, $nombre_hijo_4, 'Hijo', $info_hijo_4);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HIJO 5 */
                    $info_hijo_5 = array();

                    $cedula_hijo_5 = $row['cedula_hijo_5'];
                    $nombre_hijo_5 = $row['nombre_hijo_5'];
                    $info_hijo_5[] = $row['telefono_hijo_5_a'];
                    $info_hijo_5[] = $row['telefono_hijo_5_b'];
                    $info_hijo_5[] = $row['celular_hijo_5_c'];
                    $info_hijo_5[] = $row['celular_hijo_5_d'];

                    $info_hijo_5 = $this->comprobarNumeros($info_hijo_5);

                    if(sizeof($info_hijo_5) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hijo_5, $nombre_hijo_5, 'Hijo', $info_hijo_5);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HERMANO 1 */
                    $info_hermano_1 = array();

                    $cedula_hermano_1 = $row['cedula_hermano_1'];
                    $nombre_hermano_1 = $row['nombre_hermano_1'];
                    $info_hermano_1[] = $row['telefono_hermano_1_a'];
                    $info_hermano_1[] = $row['telefono_hermano_1_b'];
                    $info_hermano_1[] = $row['celular_hermano_1_c'];
                    $info_hermano_1[] = $row['celular_hermano_1_d'];

                    $info_hermano_1 = $this->comprobarNumeros($info_hermano_1);

                    if(sizeof($info_hermano_1) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hermano_1, $nombre_hermano_1, 'Hermano', $info_hermano_1);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HERMANO 2 */
                    $info_hermano_2 = array();

                    $cedula_hermano_2 = $row['cedula_hermano_2'];
                    $nombre_hermano_2 = $row['nombre_hermano_2'];
                    $info_hermano_2[] = $row['telefono_hermano_2_a'];
                    $info_hermano_2[] = $row['telefono_hermano_2_b'];
                    $info_hermano_2[] = $row['celular_hermano_2_c'];
                    $info_hermano_2[] = $row['celular_hermano_2_d'];

                    $info_hermano_2 = $this->comprobarNumeros($info_hermano_2);

                    if(sizeof($info_hermano_2) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hermano_2, $nombre_hermano_2, 'Hermano', $info_hermano_2);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HERMANO 3 */
                    $info_hermano_3 = array();

                    $cedula_hermano_3 = $row['cedula_hermano_3'];
                    $nombre_hermano_3 = $row['nombre_hermano_3'];
                    $info_hermano_3[] = $row['telefono_hermano_3_a'];
                    $info_hermano_3[] = $row['telefono_hermano_3_b'];
                    $info_hermano_3[] = $row['celular_hermano_3_c'];
                    $info_hermano_3[] = $row['celular_hermano_3_d'];

                    $info_hermano_3 = $this->comprobarNumeros($info_hermano_3);

                    if(sizeof($info_hermano_3) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hermano_3, $nombre_hermano_3, 'Hermano', $info_hermano_3);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HERMANO 4 */
                    $info_hermano_4 = array();

                    $cedula_hermano_4 = $row['cedula_hermano_4'];
                    $nombre_hermano_4 = $row['nombre_hermano_4'];
                    $info_hermano_4[] = $row['telefono_hermano_4_a'];
                    $info_hermano_4[] = $row['telefono_hermano_4_b'];
                    $info_hermano_4[] = $row['celular_hermano_4_c'];
                    $info_hermano_4[] = $row['celular_hermano_4_d'];

                    $info_hermano_4 = $this->comprobarNumeros($info_hermano_4);

                    if(sizeof($info_hermano_4) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hermano_4, $nombre_hermano_4, 'Hermano', $info_hermano_4);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* INFORMACIÓN DEL HERMANO 5 */
                    $info_hermano_5 = array();

                    $cedula_hermano_5 = $row['cedula_hermano_5'];
                    $nombre_hermano_5 = $row['nombre_hermano_5'];
                    $info_hermano_5[] = $row['telefono_hermano_5_a'];
                    $info_hermano_5[] = $row['telefono_hermano_5_b'];
                    $info_hermano_5[] = $row['celular_hermano_5_c'];
                    $info_hermano_5[] = $row['celular_hermano_5_d'];

                    $info_hermano_5 = $this->comprobarNumeros($info_hermano_5);

                    if(sizeof($info_hermano_5) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto($cedula_hermano_5, $nombre_hermano_5, 'Padre', $info_hermano_5);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* CORREOS DE PERFIL */
                    $correos_perfil = array();
                    
                    $correos_perfil[] = $row['correo_p_1'];
                    $correos_perfil[] = $row['correo_p_2'];
                    $correos_perfil[] = $row['correo_p_3'];
                    $correos_perfil[] = $row['correo_p_4'];

                    $correos_perfil = $this->comprobarNumeros($correos_perfil);

                    if(sizeof($correos_perfil) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto('', '', 'Correo de perfil', $correos_perfil);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* TELEFONOS DE PERFIL */
                    $telefonos_perfil = array();

                    $telefonos_perfil[] = $row['telefono_p_1'];
                    $telefonos_perfil[] = $row['telefono_p_2'];
                    $telefonos_perfil[] = $row['telefono_p_3'];
                    $telefonos_perfil[] = $row['telefono_p_4'];
                    $telefonos_perfil[] = $row['telefono_p_5'];
                    $telefonos_perfil[] = $row['telefono_p_6'];
                    $telefonos_perfil[] = $row['telefono_p_7'];
                    $telefonos_perfil[] = $row['telefono_p_8'];
                    $telefonos_perfil[] = $row['telefono_p_9'];
                    
                    $telefonos_perfil = $this->comprobarNumeros($telefonos_perfil);

                    if(sizeof($telefonos_perfil) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto('', '', 'Números de perfil', $telefonos_perfil);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    /* TELEFONOS DE COLEGIOS Y ESCUELAS*/
                    $telefonos_otros = array();

                    $nombre_otro = $row['otro_p_nombre_1'];
                    $telefono_otro = $row['otro_p_numero_1'];

                    if(!is_null($telefono_otro)) {
                        $info_de_contacto = $this->llenarArrayContacto($nombre_otro, '', 'Otro', array($telefono_otro));
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }
                    $nombre_otro = $row['otro_p_nombre_2'];
                    $telefono_otro = $row['otro_p_numero_2'];

                    if(!is_null($telefono_otro)) {
                        $info_de_contacto = $this->llenarArrayContacto($nombre_otro, '', 'Otro', array($telefono_otro));
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }
                    $nombre_otro = $row['otro_p_nombre_3'];
                    $telefono_otro = $row['otro_p_numero_3'];

                    if(!is_null($telefono_otro)) {
                        $info_de_contacto = $this->llenarArrayContacto($nombre_otro, '', 'Otro', array($telefono_otro));
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }
                    $nombre_otro = $row['otro_p_nombre_4'];
                    $telefono_otro = $row['otro_p_numero_4'];

                    if(!is_null($telefono_otro)) {
                        $info_de_contacto = $this->llenarArrayContacto($nombre_otro, '', 'Otro', array($telefono_otro));
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    $telefonos_colegios = array();

                    $telefonos_colegios[] = $row['telefono_colegio_1'];
                    $telefonos_colegios[] = $row['telefono_colegio_2'];
                    $telefonos_colegios[] = $row['telefono_colegio_3'];

                    $telefonos_colegios = $this->comprobarNumeros($telefonos_colegios);

                    if(sizeof($telefonos_colegios) > 0) {
                        $info_de_contacto = $this->llenarArrayContacto('', '', 'Escuela/Colegio', $telefonos_colegios);
                        $info_por_fila['contactos'][] = $info_de_contacto;
                    }

                    $this->data_general_contactos[] = $info_por_fila;
                }
            });

            dd($this->data_general_contactos[0]);
        }
        else {
            $error = 'No ha subido ningún archivo.';
            return view('excel.subir-archivo-contactos')->with('error', $error);
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

    private function buscarGraduadoPorCedula($identificacion) {
        $existe = Entrevista::where('identificacion_graduado', $identificacion)->exists();

        return $existe;
    }

    private function obtenerIdsPorCedula($cedula) {
        return Entrevista::where('identificacion_graduado', $cedula)->pluck('id');
    }

    private function obtenerIdGraduadoPorCedula($identificacion) {
        $graduado = Entrevista::where('identificacion_graduado', $identificacion)->pluck('id', 'token');
        $ids = array();

        if(sizeof($graduado > 1)) {
            $mensaje = 'Los casos con token <b>';

            foreach ($graduado as $key => $value) {
                $mensaje .= $key.', ';
                $ids[] = $value;
            }

            $mensaje .= '</b> tendrán la misma información de contacto, para la cédula <b>'.$identificacion.'</b>.';
            
            $this->cedulas_graduados_repetidas[] = $mensaje;
        }
        else {
            foreach ($graduado as $key => $value) {
                $ids[] = $value;
            }
        }

        return $ids;
    }

    private function comprobarNumeros($array) {
        $data = array();

        foreach ($array as $key => $value) {
            if(!is_null($value)) {
                $data[] = $value;
            }
        }

        return $data;
    }

    private function guardarInfoDeContacto($identificacion, $nombre, $parentezco, $id_graduado, $contactos) {

        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $identificacion,
            'nombre_referencia'         => $nombre,
            'parentezco'                => $parentezco,
            'id_graduado'               => $id_graduado
        ]);

        foreach ($contactos as $key => $value) {
            $detalle = DetalleContacto::create([
                'contacto'             =>$value,
                'observacion'          =>'',
                'estado'               => 'F',
                'id_contacto_graduado' => $contacto->id
            ]);
        }
    }

    private function llenarArrayContacto($identificacion_referencia, $nombre_referencia, $parentezco, $contactos) {
        $array = array();
        
        $array['identificacion_referencia'] = $identificacion_referencia;
        $array['nombre_referencia'] = $nombre_referencia;
        $array['parentezco'] = $parentezco;
        $array['contactos'] = $contactos;

        return $array;
    }

    private function dataExampleContactsFile() {
        $cantidad_de_casos = Entrevista::totalDeEncuestas();

        $faker = Factory::create('es_ES');
        $numeros = array();

        for($i=0; $i<$cantidad_de_casos*78; $i++) { 
            $numero = $faker->phoneNumber; 
            while(in_array($numero, $numeros)) { 
                $numero = $faker->phoneNumber; 
            } 
            $numeros[] = $numero; 
        }

        $data_numbers = array_chunk($numeros, $cantidad_de_casos);
    }
}
