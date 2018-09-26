<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Disciplina;
use DB;
use App\Universidad;

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

            $msj;
            $universidades;

            switch($request->check_id) {
                case 1: // TODOS
                    $msj = 'Seleccionó todos';
                    $universidades = Universidad::where('id_tipo', 2)->get();
                break;

                case 2: // PÚBLICO
                    $msj = 'Seleccionó público';

                    $universidades = Universidad::obtenerPublicas()->get();

                break;

                case 3: // PRIVADO
                    $msj = 'Seleccionó privado';

                    $universidades = Universidad::obtenerPrivadas()->get();
                break;
            }
            return response()->json(array('msj'=>$msj, 'uni'=>$universidades), 200);
        }
    }
}
