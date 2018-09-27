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
        dd($request->all());
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
                $universidades = Universidad::where('id_tipo', 2)->get();
            }
            else {
                $mensaje = 'PASÓ ALGO MALO';
            }
            
            $areas = Area::select('codigo', 'descriptivo')->get();
            
            $datos_respuesta = [
                'mensaje'=>$mensaje,
                'datos_obtenidos'=>$universidades,
                'areas'=>$areas
            ];

            return response()->json($datos_respuesta);
        }
    }

    public function traer_disciplinas_por_area(Request $request) {
        if($request->ajax()) {
            $mensaje = '';
            $datos = $request->valores;
            $nuevo = [];
            $disciplinas = [];

            $otro_array = [];

            if(sizeof($datos) == 0) {
                $mensaje = 'NINGUNO HA SIDO SELECCIONADO';
            }
            else {
                if($datos[0] == '0') {
                    $mensaje = 'TODOS HA SIDO SELECCIONADO';
                    $disciplinas = Disciplina::select('codigo', 'descriptivo', 'id_area')->get();
                }
                else {
                    $mensaje = 'ALGUNOS HAN SIDO SELECCIONADOS';
                    
                    foreach ($datos as $codigo) {
                        $area = Area::buscarPorCodigo($codigo)->get();
                        $disciplinas[] = $area->disciplinas;
                        $nuevo[] = $codigo;
                    }

                    // $disciplinas = Collection::make($disciplinas);
                }
            }
                
            $respuesta = [
                'mensaje'=>$mensaje,
                'datos'=>$nuevo,
                'disciplinas'=>$disciplinas
            ];

            return response()->json($respuesta);
        }
    }
}
