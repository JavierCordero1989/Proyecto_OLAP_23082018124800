<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Flash;
use DB;
use Carbon\Carbon;
use App\EncuestaGraduado as Entrevista;
/*
 * Impide que el servidor genere un error debido al tiempo
 * de espera seteado de 60 segundos.
*/ 
set_time_limit(300);

class ExportImportExcelController extends Controller
{
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

            $contador_entrevistas = 0;

            $universidad;
            $grado;
            $disciplina;
            $tipo_de_caso;

            // echo '<table border>';
            // echo '<thead>';
            // echo '<th>Identificacion</th>';
            // echo '<th>Nombre</th>';
            // echo '<th>Año de graduación</th>';
            // echo '<th>Link de encuesta</th>';
            // echo '<th>Sexo</th>';
            // echo '<th>Token</th>';
            // echo '<th>Codigo Carrera</th>';
            // echo '<th>Codigo Universidad</th>';
            // echo '<th>Codigo Grado</th>';
            // echo '<th>Codigo Disciplina</th>';
            // echo '<th>Codigo Area</th>';
            // echo '<th>Codigo Agrupacion</th>';
            // echo '<th>Codigo Sector</th>';
            // echo '<th>Codigo Tipo de Caso</th>';
            // echo '<th>Fecha</th>';
            // echo '</thead>';
            // echo '<tbody>';
            /**
             * $reader->get() nos permite obtener todas las filas de nuestro archivo
             */
            foreach ($reader->get() as $key => $row) {

                if($key == 0) {
                    $universidad = $row['codigo_universidad'];
                    $grado = $row['codigo_grado'];
                    $disciplina = $row['codigo_disciplina'];
                    $tipo_de_caso = $row['tipo_de_caso'];
                }

                $data = [
                    'identificacion_graduado' => $row['identificacion'],
                    'nombre_completo'         => $row['nombre'],
                    'annio_graduacion'        => $row['ano_de_graduacion'],
                    'link_encuesta'           => $row['link_de_encuesta'],
                    'sexo'                    => $row['sexo'],
                    'token'                   => $row['token'],
                    'codigo_carrera'          => $row['codigo_carrera'],
                    'codigo_universidad'      => $row['codigo_universidad'],
                    'codigo_grado'            => $row['codigo_grado'],
                    'codigo_disciplina'       => $row['codigo_disciplina'],
                    'codigo_area'             => $row['codigo_area'],
                    'codigo_agrupacion'       => $row['codigo_agrupacion'],
                    'codigo_sector'           => $row['codigo_sector'],
                    'tipo_de_caso'            => $row['tipo_de_caso'],
                    'created_at'              => Carbon::now()
                ];

                $contador_entrevistas++; //Se incrementa para guardarlo como total de casos

                // $this->tabla($data);

                // /* Una vez obtenido los datos de la fila procedemos a registrarlos */
                if(!empty($data)){
                    Entrevista::create($data);
                }
            }

            /* Se crea un array con los datos que contendrá el reporte */
            $data_reporte = [
                'codigo_disciplina'  => $disciplina,
                'codigo_grado'       => $grado,
                'codigo_universidad' => $universidad,
                'tipo_de_caso'       => $tipo_de_caso,
                'total_casos'        => $contador_entrevistas,
                'created_at'         => Carbon::now()
            ];

            /* Se guarda el reporte en la tabla con los datos recién subidos desde Excel a la BD. */
            if(!empty($data_reporte)) {
                DB::table('tbl_reportes_entrevistas')->insert($data_reporte);
            }

            // echo '</tbody></table>';
            // echo '<h1>'.$contador_entrevistas.'</h1>';
        });
    }

    public function importar_desde_excel(Request $request) {

        // sleep(2);

        /** Si viene un archivo en el request
         * 'archivo_nuevo' => es el nombre del campo que tiene el formulario
         * en la página html.
         */
        if($request->hasFile('archivo_nuevo')) {
          
            if($request->ajax()){
                dd('ES UNA PETICION AJAX');
                guardar_a_base_de_datos($request);
                return response()->json('Se han guardado los registros en la base de datos');
            }
            else {
                self::guardar_a_base_de_datos($request);

                Flash::success('El archivo se ha guardado correctamente en la Base de Datos');
                return redirect(route('encuestas-graduados.index'));
            }
        }
        else {
            if($request->ajax()) {
                return response()->json('No ha enviado un archivo');
            }
            else {
                Flash::success('No ha enviado un archivo');
                return redirect(route('ruta a dirigir'));
            }
        }
    }// Fin de la funcion importar_desde_excel

    private function tabla($array) {
        $fila = '<tr>';
        foreach($array as $element) {
            $fila .= '<td>';
            $fila .= $element;
            $fila .= '</td>';
        }

        $fila .= '</tr>';

        echo $fila;
    }
}
