<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function subir_catalogos() {
        return view('catalogo.subir-catalogos');
    }

    public function cargar_catalogo(Request $request) {
        dd($request->all());
        if(isset($request->catalogo_areas)) {

        }

        if(isset($request->catalogo_disciplina)) {

        }

        if(isset($request->catalogo_universidades)) {

        }

        if(isset($request->catalogo_carreras)) {

        }

        if($request->hasFile('archivo_nuevo')) {
            $archivo = $request->file('archivo_nuevo');
        }
    }
}
