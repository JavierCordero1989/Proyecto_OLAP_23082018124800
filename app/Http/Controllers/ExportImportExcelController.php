<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ContactoGraduado;
use App\DetalleContacto;
use App\Universidad;
use App\Disciplina;
use App\Agrupacion;
use App\Asignacion;
use Carbon\Carbon;
use App\Carrera;
use App\Sector;
use App\Estado;
use App\Grado;
use App\Area;
use App\User;
use Flash;
use DB;
/*
 * Impide que el servidor genere un error debido al tiempo
 * de espera seteado de 60 segundos.
*/ 
set_time_limit(1800);

class ExportImportExcelController extends Controller
{
    /** Guarda los datos del archivo de excel */
    private $array_datos_archivo = array();
    /** Guarda los datos que no se encuentran registrados. */
    private $datos_incorrectos = array();

    private $casos_duplicados = [];
    private $segundas_carreras = [];
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
        $this->id_estado = Estado::where('estado', 'NO ASIGNADA')->first()->id;
        // $this->id_estado = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();
        // $this->id_estado = $this->id_estado->id;
    }

    /**
     * Muestra la vista para subir el archivo de la muestra, pero antes valida que existan
     * áreas, disciplinas, universidades y carreras en la base de datos del sistema, para
     * poder subir el arcivo mencionado. 
     */
    public function create() {
        /* LAS SIGUIENTES VALIDACIONES SON PARA COMPROBAR QUE EL ARCHIVO DE LA MUESTRA, NO SE VA
        A CARGAR SIN HABER CARGADO PRIMERO LOS CATÁLOGOS DE ÁREAS, DISCIPLINAS, UNIVERSIDADES Y CARRERAS.
        */
        $areas = Area::count();
        $disciplinas = Disciplina::count();
        $universidades = Universidad::allData()->count();
        $carreras = Carrera::allData()->count();
        $mensaje = 'Debe cargar los siguientes catálogos para poder cargar el archivo de la muestra:<br>';
        $faltante_datos = false;

        if($areas <= 0) {
            $mensaje .= '- Áreas.<br>';
            $faltante_datos = true;
        }

        if($disciplinas <= 0) {
            $mensaje .= '- Disciplinas.<br>';
            $faltante_datos = true;
        }

        if($universidades <= 0) {
            $mensaje .= '- Universidades.<br>';
            $faltante_datos = true;
        }

        if($carreras <= 0) {
            $mensaje .= '- Carreras.<br>';
            $faltante_datos = true;
        }
        
        if($faltante_datos) {
            Flash::error($mensaje);
            return redirect(route('home'));
        }

        return view('excel.create');
    }

    // public function exportar_a_excel() {
    //     //Se deben tomar los datos que se quieren exportar al archivo excel
    //     $data = Model::all();

    //     /** Si no existen datos almacenados, se devuelve un mensaje de error. */
    //     if(empty($data)) {
    //         Flash::error('mensaje de error');
    //         return redirect(route('ruta_a_dirigir'));
    //     }

    //     //Se crea el archivo de excel
    //     Excel::create('nombre del archivo', function($excel) use($data){
    //         //Se crea una hoja del libro de excel
    //         $excel->sheet('nombre de la hoja', function($excel) use($data) {
    //             //Se insertan los datos en la hoja con el metodo with o fromArray
    //             /* Parametros:
    //             1: datos a guardar,
    //             2: valores del encabezado de la columna,
    //             3: celda de inicio,
    //             4: comparacionn estricta de los valores del encabezado,
    //             5: impresion de los encabezados */
    //             $sheet->with($data, null, 'A1', false, false);
    //         });
    //         /** Se descarga el archivo a la extension deseada, xlsx, xls */
    //     })->download('xlsx');

    //     Flash::success('mensaje de exito');
    //     return redirect(route('ruta_a_dirigir'));
    // }// Fin de la funcion exportar_a_excel

    /**
     * Descarga las encuestas que han sido filtradas, mediante la lista de encuestas general, esto en un
     * archivo de excel en versiòn 97-2003.
     */
    public function exportar_filtro_encuestas_a_excel() {
        //Se deben tomar los datos que se quieren exportar al archivo excel
        $ids_encuestas = session()->get('ids_encuestas_filtradas');
        
        if(isset($ids_encuestas)) {
            // session()->forget('ids_encuestas_filtradas');
            $data = Entrevista::whereIn('id', $ids_encuestas)->get();
            // $data = Model::all();
    
            /** Si no existen datos almacenados, se devuelve un mensaje de error. */
            if(empty($data)) {
                Flash::error('No se han encontrado datos para exportar a Excel.');
                return redirect(route('encuestas-graduados.index'));
            }
    
            $temp_entrevistas = array();
            $nueva_data = array();

            $carrera_codigos = Carrera::allData()->pluck('codigo', 'id');
            $carrera_etiqueta = Carrera::allData()->pluck('nombre', 'id');

            $universidad_codigos = Universidad::allData()->pluck('codigo', 'id');
            $universidad_etiquetas = Universidad::allData()->pluck('nombre', 'id');

            $grado_codigos = Grado::allData()->pluck('codigo', 'id');
            $grado_etiquetas = Grado::allData()->pluck('nombre', 'id');

            $disciplina_codigos = Disciplina::pluck('codigo', 'id');
            $disciplina_etiquetas = Disciplina::pluck('descriptivo', 'id');

            $area_codigos = Area::pluck('codigo', 'id');
            $area_etiquetas = Area::pluck('descriptivo', 'id');

            $agrupacion_codigos = Agrupacion::allData()->pluck('codigo', 'id');
            $agrupacion_etiquetas = Agrupacion::allData()->pluck('nombre', 'id');

            $sector_codigos = Sector::allData()->pluck('codigo', 'id');
            $sector_etiquetas = Sector::allData()->pluck('nombre', 'id');

            $encuesta_estado = Asignacion::pluck('id_estado', 'id_graduado');
            $estados = Estado::pluck('estado', 'id');
            $usuarios = User::pluck('user_code', 'id');

            $asignado_a = Asignacion::pluck('id_encuestador', 'id_graduado');
            $asignado_por = Asignacion::pluck('id_supervisor', 'id_graduado');
            $fecha_estado = Asignacion::pluck('updated_at', 'id_graduado');

            foreach($data as $key => $encuesta) {

                $temp_entrevistas['id'] = $key+1;
                $temp_entrevistas['identificacion'] = $encuesta->identificacion_graduado;
                $temp_entrevistas['token'] = $encuesta->token;
                $temp_entrevistas['nombre']= $encuesta->nombre_completo;
                $temp_entrevistas['año'] = $encuesta->annio_graduacion;
                $temp_entrevistas['link'] = $encuesta->link_encuesta;
                $temp_entrevistas['sexo'] = $encuesta->sexo == 'M' ? "Hombre" : ($encuesta->sexo == 'F' ? "Mujer" : "Sin Clasificar");
                $temp_entrevistas['codigo_carrera'] = $carrera_codigos[$encuesta->codigo_carrera];
                $temp_entrevistas['etiqueta_carrera'] = $carrera_etiqueta[$encuesta->codigo_carrera];
                $temp_entrevistas['codigo_universidad'] = $universidad_codigos[$encuesta->codigo_universidad];
                $temp_entrevistas['etiqueta_universidad'] = $universidad_etiquetas[$encuesta->codigo_universidad];
                $temp_entrevistas['codigo_grado'] = $grado_codigos[$encuesta->codigo_grado];
                $temp_entrevistas['etiqueta_grado'] = $grado_etiquetas[$encuesta->codigo_grado];
                $temp_entrevistas['codigo_disciplina'] = $disciplina_codigos[$encuesta->codigo_disciplina];
                $temp_entrevistas['etiqueta_disciplina'] = $disciplina_etiquetas[$encuesta->codigo_disciplina];
                $temp_entrevistas['codigo_area'] = $area_codigos[$encuesta->codigo_area];
                $temp_entrevistas['etiqueta_area'] = $area_etiquetas[$encuesta->codigo_area];
                $temp_entrevistas['codigo_agrupacion'] = $agrupacion_codigos[$encuesta->codigo_agrupacion];
                $temp_entrevistas['etiqueta_agrupacion'] = $agrupacion_etiquetas[$encuesta->codigo_agrupacion];
                $temp_entrevistas['codigo_sector'] = $sector_codigos[$encuesta->codigo_sector];
                $temp_entrevistas['etiqueta_sector'] = $sector_codigos[$encuesta->codigo_sector];
                $temp_entrevistas['tipo_de_caso'] = $encuesta->tipo_de_caso;
                $temp_entrevistas['asignada_a'] = $asignado_a[$encuesta->id] == "" ? "SIN ASIGNAR" : $usuarios[$asignado_a[$encuesta->id]];
                $temp_entrevistas['asignada_por'] = $asignado_por[$encuesta->id] == "" ? "SIN ASIGNAR" : $usuarios[$asignado_por[$encuesta->id]];
                $temp_entrevistas['estado'] = $estados[$encuesta_estado[$encuesta->id]];
                $temp_entrevistas['fecha_estado'] = $fecha_estado[$encuesta->id];

                $nueva_data[] = $temp_entrevistas;
            }
            $data = $nueva_data;
            
            //Se crea el archivo de excel
            Excel::create('Filtro de Encuestas', function($excel) use($data){
                
                //Se crea una hoja del libro de excel
                $excel->sheet('Encuestas', function($sheet) use($data) {
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
            })->download('xls');
            
            Flash::success('Se ha descargado el archivo correctamente.');
            return redirect(route('encuestas-graduados.index'));
        }
        else {
            Flash::error('No hay datos para exportar el archivo.');
            return redirect(route('encuestas-graduados.index'));
        }
    }// Fin de la funcion exportar_a_excel

    private $token_duplicados = array();
    private $links_duplicados = array();

    protected function guardar_a_base_de_datos(Request $request) {
        /* SE SOLICITA EL ARCHIVO DEL REQUEST */
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

            /* se obtienen los siguientes datos del catálogo, para almacenarlos en
            arreglos, y no consumir tiempo haciendo consultas por cada iteración
            del archivo.  */
            $graduados_token = Entrevista::pluck('token')->toArray();
            $graduados_links = Entrevista::pluck('link_encuesta')->toArray();
            $carreras        = Carrera::allData()->pluck('id', 'codigo');
            $universidades   = Universidad::allData()->pluck('id', 'codigo');
            $grados          = Grado::allData()->pluck('id', 'codigo');
            $disciplinas     = Disciplina::pluck('id', 'codigo');
            $areas           = Area::pluck('id', 'codigo');
            $agrupaciones    = Agrupacion::allData()->pluck('id', 'codigo');
            $sector          = Sector::allData()->pluck('id', 'codigo');

            /**
             * $reader->get() permite obtener todas las filas de nuestro archivo
             */
            foreach ($reader->get() as $key => $row) {

                $data_excel_file = array();
                
                if(in_array($row['token'], $graduados_token)) {
                    if(isset($this->token_duplicados[$row['token']])) {
                        $this->token_duplicados[$row['token']]++;
                    }
                    else {
                        $this->token_duplicados[$row['token']] = 1;
                    }
                    continue;
                }
                else {
                    $graduados_token[] = $row['token'];
                }

                if(in_array($row['link'], $graduados_links)) {
                    if(isset($this->links_duplicados[$row['link']])) {
                        $this->links_duplicados[$row['link']]++;
                    }
                    else {
                        $this->links_duplicados[$row['link']] = 1;
                    }
                    continue;
                }
                else {
                    $graduados_links[] = $row['link'];
                }

                $data_excel_file['identificacion_graduado'] = (string)$row['identificacion'];
                $data_excel_file['nombre_completo'] = $row['nombre'];
                $data_excel_file['annio_graduacion'] = $row['ano'];
                $data_excel_file['link_encuesta'] = $row['link'];
                $data_excel_file['sexo'] = (strtolower($row['sexo']) == 'hombre' ? 'M' : (strtolower($row['sexo']) == 'mujer' ? 'F' : 'SC'));
                $data_excel_file['token'] = $row['token'];

                /* 
                 * LAS SIGUIENTES EXCEPCIONES, CONTROLAN QUE LOS CÓDIGOS PARA LAS CARRERAS, UNIVERSIDADES,
                 * GRADOS, DISCIPLINAS, AREAS, AGRUPACION Y SECTORES, EXISTAN EN LOS REGISTROS DE LA BASE
                 * DE DATOS, ES DECIR, QUE ESTÉN EN EL CATÁLOGO. POR LO QUE AL NO EXISTIR, SE LANZARÁ UNA
                 * EXCEPCIÓN QUE GUARDARÁ UN DATO EN UN ARRAY PARA PASARLO A UNA VISTA Y ASÍ INFORMAR
                 * AL USUARIO QUE CARGA EL ARCHIVO. 
                 */
                try {
                    $data_excel_file['codigo_carrera'] = $carreras[$row['codigo_carrera']];
                }
                catch(\Exception $e) {

                    /* SI EL DATO NO ESTÁ SETEADO, LE COLOCA UNO, DE LO CONTARIO SUMA UNO. */
                    if(!isset($this->datos_incorrectos['carreras'][$row['codigo_carrera']])) {
                        $this->datos_incorrectos['carreras'][$row['codigo_carrera']] = 1;
                    }
                    else {
                        $this->datos_incorrectos['carreras'][$row['codigo_carrera']]++;
                    }
                }
                
                try {
                    $data_excel_file['codigo_universidad'] = $universidades[$row['codigo_universidad']];
                }
                catch(\Exception $ex) {
                    /* SI EL DATO NO ESTÁ SETEADO, LE COLOCA UNO, DE LO CONTARIO SUMA UNO. */
                    if(!isset($this->datos_incorrectos['universidades'][$row['codigo_universidad']])) {
                        $this->datos_incorrectos['universidades'][$row['codigo_universidad']] = 1;
                    }
                    else {
                        $this->datos_incorrectos['universidades'][$row['codigo_universidad']]++;
                    }
                }
                
                try {
                    $data_excel_file['codigo_grado'] = $grados[$row['codigo_grado']];
                }
                catch(\Exception $ex) {
                    /* SI EL DATO NO ESTÁ SETEADO, LE COLOCA UNO, DE LO CONTARIO SUMA UNO. */
                    if(!isset($this->datos_incorrectos['grados'][$row['codigo_grado']])) {
                        $this->datos_incorrectos['grados'][$row['codigo_grado']] = 1;
                    }
                    else {
                        $this->datos_incorrectos['grados'][$row['codigo_grado']]++;
                    }
                }
                
                try {
                    $data_excel_file['codigo_disciplina'] = $disciplinas[$row['codigo_disciplina']];
                }
                catch(\Exception $ex) {
                    /* SI EL DATO NO ESTÁ SETEADO, LE COLOCA UNO, DE LO CONTARIO SUMA UNO. */
                    if(!isset($this->datos_incorrectos['disciplinas'][$row['codigo_disciplina']])) {
                        $this->datos_incorrectos['disciplinas'][$row['codigo_disciplina']] = 1;
                    }
                    else {
                        $this->datos_incorrectos['disciplinas'][$row['codigo_disciplina']]++;
                    }
                }

                try {
                    $data_excel_file['codigo_area'] = $areas[$row['codigo_area']];
                }
                catch(\Exception $ex) {
                    /* SI EL DATO NO ESTÁ SETEADO, LE COLOCA UNO, DE LO CONTARIO SUMA UNO. */
                    if(!isset($this->datos_incorrectos['areas'][$row['codigo_area']])) {
                        $this->datos_incorrectos['areas'][$row['codigo_area']] = 1;
                    }
                    else {
                        $this->datos_incorrectos['areas'][$row['codigo_area']]++;
                    }
                }

                try {
                    $data_excel_file['codigo_agrupacion'] = $agrupaciones[$row['codigo_agrupacion']];
                }
                catch(\Exception $ex) {
                    /* SI EL DATO NO ESTÁ SETEADO, LE COLOCA UNO, DE LO CONTARIO SUMA UNO. */
                    if(!isset($this->datos_incorrectos['agrupaciones'][$row['codigo_agrupacion']])) {
                        $this->datos_incorrectos['agrupaciones'][$row['codigo_agrupacion']] = 1;
                    }
                    else {
                        $this->datos_incorrectos['agrupaciones'][$row['codigo_agrupacion']]++;
                    }
                }

                try {
                    $data_excel_file['codigo_sector'] = $sector[$row['codigo_sector']];
                }
                catch(\Exception $ex) {
                    /* SI EL DATO NO ESTÁ SETEADO, LE COLOCA UNO, DE LO CONTARIO SUMA UNO. */
                    if(!isset($this->datos_incorrectos['sectores'][$row['codigo_sector']])) {
                        $this->datos_incorrectos['sectores'][$row['codigo_sector']] = 1;
                    }
                    else {
                        $this->datos_incorrectos['sectores'][$row['codigo_sector']]++;
                    }
                }
                
                $data_excel_file['tipo_de_caso'] = strtoupper($row['tipo_de_caso']);
                $data_excel_file['created_at'] = Carbon::now();

                $this->array_datos_archivo[] = $data_excel_file;
            } // Este ciclo se repite hasta que los registros del archivo se acaben.
        });
    }

    /**
     * @param $array Arreglo con los datos del archivo de excel de la muestra
     * @return Array Arreglo con los tokens duplicados y la cantidad de veces.
     * 
     * Obtiene un arreglo con clave como el token, y valor la cantidad de veces que
     * el token aparece en el archivo.
     */
    private function buscar_tokens_duplicados($array) {
        
        $tokens = array();

        foreach($array as $key => $value) {
            $tokens[] = (string)$value['token'];
        }

        $repetidos = array_count_values($tokens);

        $temp = array();

        foreach($repetidos as $key => $value) {
            if($value > 1) {
                $temp[$key] = $value; 
            }
        }
        return $temp;
    }

    /**
     * @param $array Arreglo con los datos del archivo de excel de la muestra.
     * @return Array Arreglo con las coincidencias por cedula.
     * 
     * Permite buscar las cedulas del archivo de excel para ver cuales se repiten
     * en mas de una ocasion y obtener un arreglo en donde la clave es la cedula
     * y el valor las repeticiones. 
     */
    private function buscar_segundas_carreras($array) {
        $cedulas = array();

        foreach($array as $key => $data) {
            $cedulas[] = $data['identificacion_graduado'];
        }

        $cedulas = array_count_values($cedulas);
        $temp = array();

        foreach($cedulas as $key=>$data) {
            if($data > 1) {
                $temp[$key] = $data;
            }
        }
        
        return $temp;
    }

    /**
     * @param $array Arreglo con los datos del archivo de la muestra.
     * @return Array Arreglo con los totales por tipo de cada caso.
     * 
     * Permite obtener los totales por cada tipo de caso distinto que haya en el
     * archivo de la muestra, sumandolos para generar un numero por cada uno.
     */
    private function cantidad_por_tipo_de_caso($array) {
        $totales = array();

        foreach($array as $key => $value) {
            if(isset($totales[$value['tipo_de_caso']])) {
                $totales[$value['tipo_de_caso']]++;
            }
            else {
                $totales[$value['tipo_de_caso']] = 1;
            }
        }

        return $totales;
    }

    /**
     * @param $array Arreglo con los datos del archivo de la muestra.
     * @return Array Arreglo con los totales de cada area encontrada en el el archivo de la muestra.
     * 
     * Permite obtener el total de cada area que sea detectada en el archivo de la muestra, haciendo
     * un conteo por cada area.
     */
    private function cantidad_por_area($array) {
        $totales = array();

        $areas = Area::pluck('descriptivo', 'id');

        foreach($array as $key => $value) {
            $nombre = $areas[$value['codigo_area']];

            if(isset($totales[$nombre])) {
                $totales[$nombre]++;
            }
            else {
                $totales[$nombre] = 1;
            }
        }

        return $totales;
    }

    /**
     * @param $array Arreglo con los datos del archivo.
     * @return Array Arreglo con los totales por agrupacion encontrados en el archivo.
     * 
     * Permite Obtener el total de casos por cada agrupacion que se haya detectado en el archivo de
     * la muestra que se carga al sistema.
     */
    private function cantidad_por_agrupacion($array) {
        $totales = array();

        $agrupaciones = Agrupacion::allData()->pluck('nombre', 'id');

        foreach($array as $key => $value) {
            $nombre = $agrupaciones[$value['codigo_agrupacion']];

            if(isset($totales[$nombre])) {
                $totales[$nombre]++;
            }
            else {
                $totales[$nombre] = 1;
            }
        }

        return $totales;
    }

    public function importar_desde_excel(Request $request) {
        /** Si viene un archivo en el request
         * 'archivo_nuevo' => es el nombre del campo que tiene el formulario
         * en la página html.
         */
        if($request->hasFile('archivo_nuevo')) {

            $tiempo_inicio = microtime(true);
            
            /* 
             * LLAMA A LA FUNCION QUE LEE EL ARCHIVO DE EXCEL PARA GUARDAR LOS DATOS
             */
            self::guardar_a_base_de_datos($request);

            /* 
             * SI ALGUNO DE LOS DATOS DE LA CARERRA NO HA SIDO ENCONTRADO POR CODIGO, SE ENVIARA EL REPORTE
             * DE LOS ERRORES A LA VISTA SIN GUARDAR EL ARCHIVO. 
             */
            if( sizeof($this->datos_incorrectos) > 0) {
                Flash::error('Ha ocurrido un error en cuanto a datos faltantes en los registros del sistema. Por favor, revise de nuevo el archivo y corrija los errores que aparecen a continuación.');
                return view('excel.error-carga-archivo')->with('informe', $this->datos_incorrectos);
            }

            $repetidos = $this->buscar_segundas_carreras($this->array_datos_archivo);

            // $tokens = $this->buscar_tokens_duplicados($this->array_datos_archivo);
            $tokens = $this->token_duplicados;

            // dd($tokens);
            $areas = $this->cantidad_por_area($this->array_datos_archivo);

            $agrupaciones = $this->cantidad_por_agrupacion($this->array_datos_archivo);
            $tiempo_fin = microtime(true);

            $report = [
                'tiempo_consumido' => round(($tiempo_fin - $tiempo_inicio),2).' segundos',
                'cedulas_repetidas' => [sizeof($repetidos), $repetidos],
                'tokens_duplicados' => [sizeof($tokens), $tokens],
                'links_duplicados' => [sizeof($this->links_duplicados), $this->links_duplicados],
                'totales_por_area'=> [sizeof($areas), $areas],
                'totales_por_agrupacion' => [sizeof($agrupaciones), $agrupaciones],
                'totales_por_caso' => $this->cantidad_por_tipo_de_caso($this->array_datos_archivo),
                'total_de_casos' => sizeof($this->array_datos_archivo)
            ];

            if($report['total_de_casos'] > 0) {
                session()->put('data_excel', $this->array_datos_archivo);
            }

            return view('excel.confirmacion-muestra')->with('report', $report);
        }
        else {
            Flash::success('No ha enviado un archivo');
            return redirect(route('home'));
        }
    }// Fin de la funcion importar_desde_excel

    private function obtener_indices_tokens_duplicados($array) {
        $posiciones = array();

        $repetidos = $this->buscar_tokens_duplicados($array);

        foreach ($repetidos as $key_1 => $value_1) {
            foreach($array as $key_2 => $value_2) {
                if($key_1 == $value_2['token']) {
                    $posiciones[$key_1][] = $key_2;
                }
            }
        }

        return $posiciones;
    }

    /**
     * @param $respuesta Respuesta del usuario al cargar el archivo de la muestra.
     * 
     * Recibe una respuesta por parte del usuario para guardar o denegar el archivo de 
     * la muestra. Los datos recolectados en el archivo de excel se guardan en una
     * variable de sesión, si el usuario acepta el archivo, los datos se recogen de dicha
     * variable para almacenarlos en la base de datos; si no lo acepta, la variable
     * es olvidada para no consumir espacio.
     */
    public function respuesta_archivo_muestra($respuesta) {
        if(isset($respuesta)){
            if($respuesta == 'SI') {

                $data_file = session()->get('data_excel');
                
                /* ELIMINA LOS TOKENS DUPLICADOS, DEJANDO SOLO UNO */
                $repetidos = $this->obtener_indices_tokens_duplicados($data_file);

                foreach($repetidos as $key => $value) {
                    foreach($value as $key_2 => $value_2){
                        if($key_2 != 0) {
                            unset($data_file[$value_2]);
                        }
                    }
                }
                $data_file = array_values($data_file);

                DB::beginTransaction();
                try {
                    
                    foreach($data_file as $key => $data ) {
                        $entrevista = Entrevista::create($data);
                        $entrevista->asignarEstado($this->id_estado);
                    }
                    
                    // Guardar el registro en la bitacora
                    $bitacora = [
                        'transaccion'            =>'I',
                        'tabla'                  =>'tbl_graduados',
                        'id_registro_afectado'   =>null,
                        'dato_original'          =>null,
                        'dato_nuevo'             =>('El archivo de la muestra ha sido cargado en la base de datos del sistema.'),
                        'fecha_hora_transaccion' =>Carbon::now(),
                        'id_usuario'             =>Auth::user()->id,
                        'created_at'             =>Carbon::now()
                    ];
            
                    DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

                    DB::commit();
                    session()->forget('data_excel');

                    Flash::success('El archivo se ha guardado correctamente en la Base de Datos');
                    return redirect(route('encuestas-graduados.index'));
                }
                catch(\Exception $ex) {
                    DB::rollback();
                    Flash::error('Error en el sistema.<br>Excepcion: '.$ex->getMessage());
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

    /**
     * Muestra la vista para cargar el archivo de contactos en el sistema, pero antes verifica que
     * la muestra haya sido cargada con anterioridad, para poder mostrar dicha vista, de lo contrario,
     * se muestra un error informando al usuario.
     */
    public function createArchivoContactos() {
        $graduados = Entrevista::count();

        if($graduados <= 0) {
            Flash::error('Para poder cargar el archivo de contactos, debe haber cargado el archivo de la muestra con anterioridad.');
            return redirect(route('home'));
        }

        return view('excel.subir-archivo-contactos');
    }

    public function subirArchivoExcelContactos(Request $request) {
        if($request->hasFile('archivo_contactos')) {
            $archivo = $request->file('archivo_contactos');
            
            // $encabezados = config('encabezados_contactos');

            Excel::load($archivo, function ($reader) {

                foreach ($reader->get() as $key => $row) {
                    
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

    private function buscarCedulaGraduado($identificacion_graduado) {
        $entrevista = Entrevista::where('identificacion_graduado', $identificacion_graduado)->first();
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

        if(sizeof($this->segundas_carreras) > 0) {
            $reporte[] = $this->segundas_carreras;
            array_push($encabezados_panel, 'Segundas Carreras');
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
