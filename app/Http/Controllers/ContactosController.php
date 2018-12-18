<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactoGraduado;
use Flash;
use App\EncuestaGraduado;

class ContactosController extends Controller
{
    public function agregar_contacto_get($id_encuesta, $id_contacto) {
        $entrevista = EncuestaGraduado::find($id_encuesta);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto que seleccionó.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }

        return view('contactos.editar-contacto')->with('contacto', $contacto);
    }
}
