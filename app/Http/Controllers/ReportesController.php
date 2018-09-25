<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosCarreraGraduado as Tipo;

class ReportesController extends Controller
{
    public function index() {
        return view('reportes.index');
    }

    public function filtro_reportes() {
        $disciplinas = Tipo::porDisciplina()->get();
        $areas = Tipo::porArea()->get();

        return view('reportes.filtro_reportes', compact('disciplinas', 'areas'));
    }

    public function filtrar_encuestas_para_reporte(Request $request) {
        dd($request->all());
    }
}
