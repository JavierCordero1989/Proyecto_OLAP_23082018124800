<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Flash;
use Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /** Metodo index que carga la vista de inicio con los datos de la base de datos. */
    public function index() {
        /** Hacer una seleccion de todos los elementos de la BD para llevarlos a la
         *  vista de index.
         */
        // $users = User::all();
        $users = User::whereNull('deleted_at')->get();

        /** Se regresa a la vista de index en la carpeta deseada, con los datos obtenidos 
         *  desde la base de datos.
          */
        return view('users.index', compact('users'));
    } //Fin de la funcion index

    /** Metodo create, que carga la vista con los campos para ingresar los datos necesarios
     *  para guardar un nuevo registro.
     */
    public function create() {
        /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
        return view('users.create');
    } //Fin de la funcion create

    /** Metodo store, que almacena los datos ingresados en los campos de texto obtenidos de 
     *  la vista cargada por el metodo create.
     */
    public function store(Request $request) {
        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado el usuario');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('users.index'));
    } //Fin de la funcion store.

    /** Metodo show, que muestra los datos de un objeto que posea el ID asociado por 
     * parametros.
     */
    public function show($id) {
        /** se obtiene el objeto que corresponda al ID */
        $user = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($user)) {
            Flash::error('Usuario no encontrado');
            return redirect(route('users.index'));
        }
        /** Si el objeto contiene informacion se muestra la vista show con los datos obtenidos del objeto. */
        return view('users.show', compact('user'));
    } //Fin de la funcion show

    /** Metodo edit, que obtiene los datos de un objeto mediante su ID, para luego cargar
     * la vista edit con los datos obtenidos.
     */
    public function edit($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $user = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($user)) {
            Flash::error('Usuario no encontrado');
            return redirect(route('users.index'));
        }

        /** Si el objeto contiene informacion se muestra la vista edit con los datos obtenidos del objeto,
         * esto para poder ver los datos que contiene, y asi poder modificarlos.
         */
        return view('users.edit', compact('user'));
    } //Fin de la funcion edit

    /** Metodo update, que permite modificar los datos de un objeto con el ID que se pasa
     *  por parametros, modificandolo con los datos del Request.
     */
    public function update($id, Request $request) {
        /** Se obtiene el objeto que corresponda al ID */
        $user = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($user)) {
            Flash::error('No se ha encontrado el usuario');
            return redirect(route('users.index'));
        }

        /** Se modifican los datos del objeto enontrado con los datos del Request */
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado con exito');
        return redirect(route('users.index'));
    } //Fin de la funcion update

    public function destroy($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $user = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($user)) {
            Flash::error('No se ha encontrado el Usuario');
            return redirect(route('users.index'));
        }

        /** Se borra el objeto encontrado */
        $user->deleted_at = Carbon::now();
        $user->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado el usuario '.$user->name.' correctamente.');
        return redirect(route('users.index'));
    } //Fin de la funcion destroy

    /** Metodo que busca al usuario por el ID recibido por parametros, y devuelve los
     * datos del usuario encontrado a la vista respectiva.
     */
    public function edit_name($id) {
        $user = User::find($id);

        if(empty($user)) {
            Flash::error('Usuario no encontrado');
            return redirect(route('users.index'));
        }

        return view('users.edit-name', compact('user'));
    }// Fin de la funcion edit_name.

    /** Metodo o funcion que permite modificar el nombre del usuario, siempre
     * y cuando se encuentre por el ID.
     */
    public function update_name($id, Request $request) {
        $user = User::find($id);

        if(empty($user)) {
            Flash::error('No se ha encontrado el usuario');
            return redirect(route('users.index'));
        }
        
        //Se cambia el nombre antiguo, por el actual y se guardan los cambios.
        $user->name = $request->new_name;
        $user->save();

        Flash::success('El nombre del usuario se ha modificado correctamente');
        return redirect(route('users.index'));
    }// Fin de la funcion update_name

    /** Metodo que busca al usuario por el ID recibido por parametros, y devuelve los
     * datos del usuario encontrado a la vista respectiva.
     */
    public function edit_password($id) {
        $user = User::find($id);

        if(empty($user)) {
            Flash::error('Usuario no encontrado');
            return redirect(route('users.index'));
        }

        return view('users.edit-password', compact('user'));
    }// Fin de la funcion edit_password

    /** Metodo que permite modificar la contraseña del usuario, siempre
     * y cuando se encuentre por el ID.
     */
    public function update_password($id, Request $request) {
        $user = User::find($id);

        if(empty($user)) {
            Flash::error('No se ha encontrado el usuario');
            redirect(route('users.index'));
        }
        
        $user->password = bcrypt($request->new_password);
        $user->save();

        Flash::success('Se ha cambiado la contraseña de forma exitosa');
        return redirect(route('users.index'));
    }// Fin de la funcion update_password

    public function index_table() {
        // Trae todos los registros de los usuarios, excepto el del usuario conectado en el
        // sistema actualmente.
        $users = User::where('id', '<>', Auth::user()->id)->get();

        $table = [];

        foreach($users as $user) {
            array_push($table, [
                'Nombre' => [
                    'data'=>$user->name
                ],
                'E-mail' => [
                    'data'=>$user->email
                ],
                'obj' =>$user,
                'options'=>[
                    'id' => $user->id,
                    'show'=>'users.show',
                    'edit'=>'users.edit',
                    'delete'=>'users.destroy'
                ]
            ]);
        }

        return view('users.index_table')->with('data', $table);
    }
}
