<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Flash;

class RolesController extends Controller
{
    public function index() {
        $roles = Role::all();

        $table = [];

        foreach($roles as $rol) {
            array_push($table,[
                'Nombre' => [
                    'data' => $rol->name
                ],
                'obj'=>$rol,
                'options'=>[
                    'id' => $rol->id,
                    'show' => 'roles.show',
                    'edit'=>'roles.edit',
                    'delete'=>'roles.destroy'
                ]
            ]);
        }

        return view('roles.index', compact('roles'));
    }

    public function create() {
        return view('roles.create');
    }

    public function store(Request $request) {
        $nuevo_rol = Role::create($request->all());

        Flash::success('Se ha guardado el rol');
        return redirect(route('roles.index'));
    }

    public function show($id) {
        $rol = Role::find($id);

        if(empty($rol)) {
            Flash::error('Rol no encontrado');
            return redirect(route('roles.index'));
        }
        return view('roles.show', compact('rol'));
    }

    public function edit($id) {
        $rol = Role::find($id);

        if(empty($rol)) {
            Flash::error('Rol no encontrado');
            return redirect(route('roles.index'));
        }

        return view('roles.edit', compact('rol'));
    }

    public function update($id, Request $request) {
        $rol = Role::find($id);

        if(empty($rol)) {
            Flash::error('No se ha encontrado el rol');
            return redirect(route('roles.index'));
        }

        $rol->name = $request->name;
        $rol->guard_name = $request->guard_name;
        $rol->save();

        Flash::success('Se ha modificado con exito');
        return redirect(route('roles.index'));
    }

    public function destroy($id) {
        $rol = Role::find($id);

        if(empty($rol)) {
            Flash::error('No se ha encontrado el rol');
            return redirect(route('roles.index'));
        }

        $rol->delete();

        Flash::success('Se ha eliminado el rol correctamente.');
        return redirect(route('roles.index'));
    }
}
