<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\EncuestaGraduado;
use Flash;
use DB;

class EncuestadorController extends Controller
{
    public function mis_entrevistas($id_encuestador) {
        //cargar la lista de entrevistas del encuestador.
        $mis_entrevistas = EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_encuestador)->get();

        return view('vistas-encuestador.lista-encuestas', compact('mis_entrevistas'));
    }

    public function realizar_entrevista($id_entrevista) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
        }

        $estados = DB::table('tbl_estados_encuestas')->get()->pluck('estado', 'id');

        return view('vistas-encuestador.realizar-entrevista', compact('entrevista', 'estados'));
    }

    public function actualizar_entrevista($id_entrevista, Request $request) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
        }

        dd($request->all());
    }
}
