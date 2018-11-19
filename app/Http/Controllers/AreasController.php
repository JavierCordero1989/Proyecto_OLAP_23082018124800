<?php

namespace App\Http\Controllers;

use App\DatosCarreraGraduado;
use Illuminate\Http\Request;
use App\Area;
use Flash;

class AreasController extends Controller
{
    public function axiosAreas() {
        $areas = Area::pluck('descriptivo', 'id');

        return $areas;
    }

    public function index() {
        // $areas = DatosCarreraGraduado::porArea()->get();
        $areas = Area::all();

        return view('areas.index')->with('areas', $areas);
    }

    public function create() {
        return view('areas.create');
    }

    public function store(Request $request) {
        $id_tipo = \App\TiposDatosCarrera::area()->first()->id;

        $input = $request->all();

        $nueva_area = DatosCarreraGraduado::create([
            'codigo' => $input['codigo'],
            'nombre' => $input['nombre'],
            'id_tipo' => $id_tipo
        ]);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado el área satisfactoriamente.');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('areas.index'));
    }

    public function show($id) {
        $area = DatosCarreraGraduado::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        return view('areas.show', compact('area'));
    }

    public function edit($id) {
        $area = DatosCarreraGraduado::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        return view('areas.edit', compact('area'));
    }

    public function update($id, Request $request) {
        $area = DatosCarreraGraduado::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        $area->codigo = $request->codigo;
        $area->nombre = $request->nombre;
        $area->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado el área satisfactoriamente.');
        return redirect(route('areas.index'));
    }

    public function destroy($id) {
        $area = DatosCarreraGraduado::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        /* VALIDA QUE el área NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($area->graduadoArea) > 0) {
            Flash::error('No es posible eliminar esta área debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('areas.index'));
        }
        
        /** Se borra el objeto encontrado */
        $area->deleted_at = \Carbon\Carbon::now();
        $area->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado el área '.$area->nombre.' correctamente.');
        return redirect(route('areas.index'));
    }
}
