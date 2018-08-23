<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EncuestaGraduado;
use Flash;

class EncuestaGraduadoController extends Controller
{
    public function index() {
        $encuestas = EncuestaGraduado::listaDeGraduados()->get();

        return view('encuestas_graduados.index', compact('encuestas'));
    }

    public function asignar($id_encuestador, $id_supervisor) {
        return "El ID del encuestador es el ".$id_encuestador.", y el ID del supervisor es el ".$id_supervisor;
    }
}