<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Disciplina;

class ReportesController extends Controller
{
    public function index() {
        return view('reportes.index');
    }

    public function filtro_reportes() {
        $disciplinas = Disciplina::all();
        $areas = Area::all();

        return view('reportes.filtro_reportes', compact('areas'))->with('disciplinas', json_encode($disciplinas));
    }

    public function filtrar_encuestas_para_reporte(Request $request) {
        dd($request->all());
    }

    public function traer_universidades_por_sector(Request $request) {
        if($request->ajax()) {

            $msj;

            switch($request->check_id) {
                case 1: // TODOS
                    $msj = 'Seleccionó todos';
                break;

                case 2: // PÚBLICO
                    $msj = 'Seleccionó público';
                break;

                case 3: // PRIVADO
                    $msj = 'Seleccionó privado';
                break;
            }
            return response()->json(array('msj'=>$msj), 200);
        }
    }
}
