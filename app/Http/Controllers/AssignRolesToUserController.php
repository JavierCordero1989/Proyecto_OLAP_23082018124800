<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Flash;
use Spatie\Permission\Models\Role;

class AssignRolesToUserController extends Controller
{
    /** Metodo create, que carga la vista con los campos para ingresar los datos necesarios
     *  para guardar un nuevo registro.
     */
    public function create() {
        $users = User::pluck('name', 'id'); //Obtiene todos los usuarios de la BD por su ID y nombre
        $roles = Role::all(); //Obtiene todos los roles de la BD

        /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
        return view('user_has_roles.create', compact('users', 'roles'));
    } //Fin de la funcion create

    /** Metodo store, que almacena los datos ingresados en los campos de texto obtenidos de 
     *  la vista cargada por el metodo create.
     */
    public function store(Request $request) {
        $input = $request->all(); //Se obtiene los datos del request de la pagina

        $user = User::find($input['user_id']); //Se busca el usuario por el ID seleccionado en la pagina
        $roles = $input['roles']; //Se obtienen los roles seleccionados por el usuario

        //Se recorren los roles con un foreach para asignarselos al usuario
        foreach($roles as $rol) {
            $_rol = Role::find($rol); //Se obtiene el rol mediante el ID del seleccionado
            $user->assignRole($_rol); //Se asigna el rol seleccionado al usuario
        }

        Flash::success('Se han asignado los roles correctamente');
        /** Se direcciona a la pagina de inicio. */
        return view('home');
    } //Fin de la funcion store.
}
