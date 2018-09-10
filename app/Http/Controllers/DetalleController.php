<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ContactoGraduado;
use App\DetalleContacto;
use Flash;
use Carbon\Carbon;

class DetalleController extends Controller
{
    public function create($id) {
        return view('detalles_contactos.create')->with('id_contacto', $id);
    }

    public function store($id, Request $request) {
        $contacto = ContactoGraduado::find($id);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        $contacto->agregarDetalle($request->contacto, $request->observacion);

        Flash::success('Se ha agregado información al contacto correctamente.');
        return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
    }

    public function edit($id) {
        $detalle = DetalleContacto::find($id);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        return view('detalles_contactos.edit', compact('detalle'));
    }

    public function update($id, Request $request) {
        $detalle = DetalleContacto::find($id);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        $detalle->contacto = $request->contacto;
        $detalle->observacion = $request->observacion;
        $detalle->updated_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha modificado correctamente.');
        return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
    }

    public function destroy($id) {
        $detalle = DetalleContacto::find($id);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        $detalle->deleted_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha eliminado.');
        return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
    }
}
