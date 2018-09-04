<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosCarreraGraduado;
use Flash;

class UniversidadesController extends Controller
{
    public function index() {
        $universidades = DatosCarreraGraduado::porUniversidad()->get();

        return view('universidades.index')->with('universidades', $universidades);
    }

    public function create() {
        return view('universidades.create');
    }

    public function store(Request $request) {
        $id_tipo = \App\TiposDatosCarrera::universidad()->first()->id;

        $input = $request->all();

        $nueva_universidad = DatosCarreraGraduado::create([
            'codigo' => $input['codigo'],
            'nombre' => $input['nombre'],
            'id_tipo' => $id_tipo
        ]);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado la universidad satisfactoriamente.');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('universidades.index'));
    }

    public function show($id) {
        $universidad = DatosCarreraGraduado::find($id);

        if(empty($universidad)) {
            Flash::error('Universidad no encontrada');
            return redirect(route('universidades.index'));
        }

        return view('universidades.show', compact('universidad'));
    }

    public function edit($id) {
        $universidad = DatosCarreraGraduado::find($id);

        if(empty($universidad)) {
            Flash::error('Universidad no encontrada');
            return redirect(route('universidades.index'));
        }

        return view('universidades.edit', compact('universidad'));
    }

    public function update($id, Request $request) {
        $universidad = DatosCarreraGraduado::find($id);

        if(empty($universidad)) {
            Flash::error('Universidad no encontrada');
            return redirect(route('universidades.index'));
        }

        $universidad->codigo = $request->codigo;
        $universidad->nombre = $request->nombre;
        $universidad->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado la universidad satisfactoriamente.');
        return redirect(route('universidades.index'));
    }

    public function destroy($id) {
        $universidad = DatosCarreraGraduado::find($id);

        if(empty($universidad)) {
            Flash::error('Universidad no encontrada');
            return redirect(route('universidades.index'));
        }

        /* VALIDA QUE LA UNIVERSIDAD NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($universidad->graduadoUniversidad) > 0) {
            Flash::error('No es posible eliminar esta universidad debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('universidades.index'));
        }
        
        /** Se borra el objeto encontrado */
        $universidad->deleted_at = \Carbon\Carbon::now();
        $universidad->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado la universidad '.$universidad->nombre.' correctamente.');
        return redirect(route('universidades.index'));
    }
}
