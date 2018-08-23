<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Flash;

class AssignPermissionsToRolController extends Controller
{
    /** Metodo create, que carga la vista con los campos para ingresar los datos necesarios
     *  para guardar un nuevo registro.
     */
    public function create() {
        $roles = Role::pluck('name', 'id'); //Obtiene todos los roles de la BD por su nombre e ID
        $permissions = Permission::all(); //Obtiene todos los permisos de la BD

        /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
        return view('roles_has_permissions.create', compact('roles', 'permissions'));
    } //Fin de la funcion create

    /** Metodo store, que almacena los datos ingresados en los campos de texto obtenidos de 
     *  la vista cargada por el metodo create.
     */
    public function store(Request $request) {

        $input = $request->all(); //Se obtiene los datos del request de la pagina

        $selectedRole = Role::find($input['rol_name']); //Se busca el rol por el ID seleccionado en la pagina
        $permissions = $input['permissions']; //Se obtienen los permisos seleccionados por el usuario

        //Se recorren los permisos con un foreach para asignarselos al rol
        foreach($permissions as $permission) {
            $permiso = Permission::find($permission); //Se obtiene el permiso mediante el ID del seleccionado
            $selectedRole->givePermissionTo($permiso); //Se asigna el permiso seleccionado al rol
        }

        Flash::success('Se han asignado los permisos correctamente');
        /** Se direcciona a la pagina de inicio. */
        return view('home');
    } //Fin de la funcion store.
}
