<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Flash;
use DB;

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

    public function guardar_a_base_de_datos(Request $request) {
        $archivo = $request->file('archivo_nuevo');
        /** El método load permite cargar el archivo definido como primer parámetro */
        Excel::load($archivo, function ($reader) {
            /**
             * $reader->get() nos permite obtener todas las filas de nuestro archivo
             */
            foreach ($reader->get() as $key => $row) {
                /** campos del archivo excel */
                $data = [
                    //'campo en base de datos' => 'columna de excel'
                    'nombre' => $row['nombre'],
                ];

                /** Una vez obtenido los datos de la fila procedemos a registrarlos */
                if(!empty($data)){
                    DB::table('nombre de la tabla')->insert($data);
                }
            }
        });
    }

    public function importar_desde_excel(Request $request) {

        return response()->json('Ha llegado al controlador');
        /** Si viene un archivo en el request
         * 'archivo_nuevo' => es el nombre del campo que tiene el formulario
         * en la página html.
         */
        if($request->hasFile('archivo_nuevo')) {
            if($request->ajax()){
                guardar_a_base_de_datos($request);
                return response()->json('Se han guardado los registros en la base de datos');
            }
            else {
                guardar_a_base_de_datos($request);

                Flash::sucess('El archivo se ha guardado correctamente en la Base de Datos');
                return redirect(route('ruta a dirigir'));
            }
        }
        else {
            if($request->ajax()) {
                return response()->json('No ha enviado un archivo');
            }
            else {
                Flash::sucess('No ha enviado un archivo');
                return redirect(route('ruta a dirigir'));
            }
        }
    }// Fin de la funcion importar_desde_excel
}
