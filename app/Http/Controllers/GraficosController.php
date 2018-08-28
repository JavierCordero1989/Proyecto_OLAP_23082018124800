<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraficosController extends Controller
{
    public function graficosPorEstado() {
        return view('graficas.graficos-por-estado');
    }
}
