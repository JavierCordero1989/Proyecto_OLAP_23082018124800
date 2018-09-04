<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosCarreraGraduado;
use Flash;

class CarrerasController extends Controller
{
    public function index() {
        $carreras = DatosCarreraGraduado::porCarrera()->get();

        return view('carreras.index')->with('carreras', $carreras);
    }

    public function create() {
        return view('carreras.create');
    }

    public function store(Request $request) {
        $id_tipo = \App\TiposDatosCarrera::carrera()->first()->id;

        $input = $request->all();

        $nueva_carrera = DatosCarreraGraduado::create([
            'codigo' => $input['codigo'],
            'nombre' => $input['nombre'],
            'id_tipo' => $id_tipo
        ]);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado la carrera satisfactoriamente.');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('carreras.index'));
    }

    public function show($id) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        return view('carreras.show', compact('carrera'));
    }

    public function edit($id) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        return view('carreras.edit', compact('carrera'));
    }

    public function update($id, Request $request) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        $carrera->codigo = $request->codigo;
        $carrera->nombre = $request->nombre;
        $carrera->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado la carrera satisfactoriamente.');
        return redirect(route('carreras.index'));
    }

    public function destroy($id) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        /* VALIDA QUE LA CARRERA NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($carrera->graduadoCarrera) > 0) {
            Flash::error('No es posible eliminar esta carrera debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('carreras.index'));
        }
        
        /** Se borra el objeto encontrado */
        $carrera->deleted_at = \Carbon\Carbon::now();
        $carrera->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado la carrera '.$carrera->nombre.' correctamente.');
        return redirect(route('carreras.index'));
    }
}
