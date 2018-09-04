<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosCarreraGraduado;
use Flash;

class DisciplinasController extends Controller
{
    public function index() {
        $disciplinas = DatosCarreraGraduado::porDisciplina()->get();

        return view('disciplinas.index')->with('disciplinas', $disciplinas);
    }

    public function create() {
        return view('disciplinas.create');
    }

    public function store(Request $request) {
        $id_tipo = \App\TiposDatosCarrera::disciplina()->first()->id;

        $input = $request->all();

        $nueva_disciplina = DatosCarreraGraduado::create([
            'codigo' => $input['codigo'],
            'nombre' => $input['nombre'],
            'id_tipo' => $id_tipo
        ]);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado la disciplina satisfactoriamente.');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('disciplinas.index'));
    }

    public function show($id) {
        $disciplina = DatosCarreraGraduado::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrada');
            return redirect(route('disciplinas.index'));
        }

        return view('disciplinas.show', compact('disciplina'));
    }

    public function edit($id) {
        $disciplina = DatosCarreraGraduado::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrada');
            return redirect(route('disciplinas.index'));
        }

        return view('disciplinas.edit', compact('disciplina'));
    }

    public function update($id, Request $request) {
        $disciplina = DatosCarreraGraduado::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrado');
            return redirect(route('disciplinas.index'));
        }

        $disciplina->codigo = $request->codigo;
        $disciplina->nombre = $request->nombre;
        $disciplina->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado la disciplina satisfactoriamente.');
        return redirect(route('disciplinas.index'));
    }

    public function destroy($id) {
        $disciplina = DatosCarreraGraduado::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrado');
            return redirect(route('disciplinas.index'));
        }

        /* VALIDA QUE la disciplina NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($disciplina->graduadoDisciplina) > 0) {
            Flash::error('No es posible eliminar esta disciplina debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('disciplinas.index'));
        }
        
        /** Se borra el objeto encontrado */
        $disciplina->deleted_at = \Carbon\Carbon::now();
        $disciplina->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado la disciplina '.$disciplina->nombre.' correctamente.');
        return redirect(route('disciplinas.index'));
    }
}
