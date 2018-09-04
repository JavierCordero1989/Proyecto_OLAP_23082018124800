<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosCarreraGraduado;
use Flash;

class GradosController extends Controller
{
    public function index() {
        $grados = DatosCarreraGraduado::porGrado()->get();

        return view('grados.index')->with('grados', $grados);
    }

    public function create() {
        return view('grados.create');
    }

    public function store(Request $request) {
        $id_tipo = \App\TiposDatosCarrera::grado()->first()->id;

        $input = $request->all();

        $nuevo_grado = DatosCarreraGraduado::create([
            'codigo' => $input['codigo'],
            'nombre' => $input['nombre'],
            'id_tipo' => $id_tipo
        ]);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado el grado satisfactoriamente.');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('grados.index'));
    }

    public function show($id) {
        $grado = DatosCarreraGraduado::find($id);

        if(empty($grado)) {
            Flash::error('Grado no encontrado');
            return redirect(route('grados.index'));
        }

        return view('grados.show', compact('grado'));
    }

    public function edit($id) {
        $grado = DatosCarreraGraduado::find($id);

        if(empty($grado)) {
            Flash::error('Grado no encontrado');
            return redirect(route('grados.index'));
        }

        return view('grados.edit', compact('grado'));
    }

    public function update($id, Request $request) {
        $grado = DatosCarreraGraduado::find($id);

        if(empty($grado)) {
            Flash::error('Grado no encontrado');
            return redirect(route('grados.index'));
        }

        $grado->codigo = $request->codigo;
        $grado->nombre = $request->nombre;
        $grado->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado el grado satisfactoriamente.');
        return redirect(route('grados.index'));
    }

    public function destroy($id) {
        $grado = DatosCarreraGraduado::find($id);

        if(empty($grado)) {
            Flash::error('Grado no encontrado');
            return redirect(route('grados.index'));
        }

        /* VALIDA QUE EL GRADO NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($grado->graduadoGrado) > 0) {
            Flash::error('No es posible eliminar este grado debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('grados.index'));
        }
        
        /** Se borra el objeto encontrado */
        $grado->deleted_at = \Carbon\Carbon::now();
        $grado->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado el grado '.$grado->nombre.' correctamente.');
        return redirect(route('grados.index'));
    }
}
