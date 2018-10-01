<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Disciplina;
use DB;
use App\Universidad;
use Illuminate\Support\Collection;

class ReportesController extends Controller
{
    public function index() {
        return view('reportes.index');
    }

    public function filtro_reportes() {
        $disciplinas = Disciplina::all();
        $areas = Area::all();

        return view('reportes.filtro_reportes');
    }

    public function filtrar_encuestas_para_reporte(Request $request) {
        $sectores = $request->sector;
        $universidades = $request->universidades;
        $disciplinas = $request->disciplinas;

        dd($sectores, $universidades, $disciplinas);
    }

    public function traer_universidades_por_sector(Request $request) {
        if($request->ajax()) {
            $mensaje = '';
            $universidades = [];

            if(sizeof($request->valores) == 0) {
                $mensaje = 'No se ha seleccionado nada';
            }
            else if(sizeof($request->valores) == 1) {
                if($request->valores[0] == '2') {
                    $mensaje = 'Se seleccionó un valor - 2';
                    $universidades = Universidad::obtenerPublicas()->get();
                }
                if($request->valores[0] == '3') {
                    $mensaje = 'Se seleccionó un valor - 3';
                    $universidades = Universidad::obtenerPrivadas()->get();
                }
                
            }
            else if(sizeof($request->valores) == 3) {
                $mensaje = 'Se seleccionó todo';
                $universidades = Universidad::allData()->all();
            }
            else {
                $mensaje = 'PASÓ ALGO MALO';
            }
            
            // Se traen todas las áreas de la base de datos
            // $areas = Area::all();
            $areas = Area::select('id', 'codigo', 'descriptivo')->get();
            $disciplinas = [];

            //Se recorren todas las áreas obtenidas para guardar las disciplinas de cada área.
            foreach ($areas as $area) {
                $disciplinas[$area->descriptivo] = $area->disciplinas;
            }

            $datos_respuesta = [
                'mensaje'=>$mensaje,
                'datos_obtenidos'=>$universidades,
                'disciplinas'=>$disciplinas
            ];

            return response()->json($datos_respuesta);
        }
    }
}
