<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficosController extends Controller
{
    public function graficosPorEstado() {
        return view('graficas.graficos-por-estado');
    }

    public function graficosPorEstadoEncuestador($id_encuestador) {
        return view('encuestadores.graficos');
    }
}
