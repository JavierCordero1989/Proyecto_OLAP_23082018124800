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
            $codigos_areas = $request->valores;
            $disciplinas = [];

            foreach($codigos_areas as $codigo) {
                $area = Area::buscarPorCodigo($codigo)->first();
                $disciplinas[$area->descriptivo] = Disciplina::select('codigo','descriptivo')->where('id_area', $codigo)->get();
            }

            return response()->json($disciplinas);
        }
    }
}
