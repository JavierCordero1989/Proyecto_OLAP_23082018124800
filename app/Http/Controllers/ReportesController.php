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
                $universidades = Universidad::allData()->all();
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
            $disciplinas = [];

            if(sizeof($request->valores) == 0) {
                $mensaje = 'Nada ha sido seleccionado';
            }
            else {
                $disciplinas_seleccionadas = $request->valores;

                foreach($disciplinas_seleccionadas as $disciplina) {
                    $area = Area::buscarPorDescriptivo($disciplina)->first();

                    if(empty($area)) {
                        $disciplinas[] = \App\Disciplina::buscarPorCodigo($disciplina)->first();
                    }
                    else {
                        foreach($area->disciplinas as $disc_por_area) {
                            $datos_encontrados[] = $disc_por_area;
                        }
                    }
                }
            }

            $data = [
                'mensaje' =>$mensaje,
                'disciplinas' => $disciplinas
            ];

            return response()->json(data);
        }
    }
}
