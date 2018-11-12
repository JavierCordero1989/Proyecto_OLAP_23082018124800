<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Flash;
use DB;

class SupervisoresController extends Controller
{
    /** Metodo index que carga la vista de inicio con los datos de la base de datos. */
    public function index() {
        /** Hacer una seleccion de todos los elementos de la BD para llevarlos a la
         *  vista de index.
         */
        /** Para que no obtenga los usuarios que han sido dados de baja */
        $usuarios = User::role(['Supervisor 1', 'Supervisor 2', 'Super Admin'])->whereNull('deleted_at')->get();

        /** Se regresa a la vista de index en la carpeta deseada, con los datos obtenidos 
         *  desde la base de datos.
          */
        return view('supervisores.index', compact('usuarios'));
    }

    /** Metodo create, que carga la vista con los campos para ingresar los datos necesarios
     *  para guardar un nuevo registro.
     */
    public function create() {
        /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
        return view('supervisores.create');
    } //Fin de la funcion create

    /** Metodo store, que almacena los datos ingresados en los campos de texto obtenidos de 
     *  la vista cargada por el metodo create.
     */
    public function store(Request $request) {
        /** Dos formas de guardar un objeto:
         * 1- Creando una instancia del objeto y seteando los valores con los del Request.
         * 2- Mediante el metodo create de la clase Model, igual obteniendo los datos del Request
         */

        $input = $request->all();

        // Si las validaciones no se disparan, guardar el usuario nuevo en la BD
        $nuevo_supervisor = User::create([
            'user_code' => $input['user_code'],
            'extension'=> $input['extension'],
            'mobile'=>$input['mobile'],
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ]);

        
        $nuevo_supervisor->assignRole($input['role_name']);

        //En la tabla de bitácora se registra el cambio
        $bitacora = [
            'transaccion'            =>'I',
            'tabla'                  =>'users',
            'id_registro_afectado'   =>$nuevo_supervisor->id,
            'dato_original'          =>null,
            'dato_nuevo'             =>('Se ha agregado un nuevo supervisor. ROL:'.$input['role_name']. '. Datos: {'.$input['user_code'].' | '.$input['name'].' | '. $input['email'] .'}'),
            'fecha_hora_transaccion' =>Carbon::now(),
            'id_usuario'             =>Auth::user()->id,
            'created_at'             =>Carbon::now()
        ];

        DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado el supervisor');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('supervisores.index'));
    } //Fin de la funcion store.

    /** Metodo show, que muestra los datos de un objeto que posea el ID asociado por 
     * parametros.
     */
    public function show($id) {
        /** se obtiene el objeto que corresponda al ID */
        $supervisor = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($supervisor)) {
            Flash::error('Supervisor no encontrado');
            return redirect(route('supervisores.index'));
        }
        /** Si el objeto contiene informacion se muestra la vista show con los datos obtenidos del objeto. */
        return view('supervisores.show', compact('supervisor'));
    } //Fin de la funcion show

    /** Metodo edit, que obtiene los datos de un objeto mediante su ID, para luego cargar
     * la vista edit con los datos obtenidos.
     */
    public function edit($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $supervisor = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($supervisor)) {
            Flash::error('Supervisor no encontrado');
            return redirect(route('supervisores.index'));
        }

        /** Si el objeto contiene informacion se muestra la vista edit con los datos obtenidos del objeto,
         * esto para poder ver los datos que contiene, y asi poder modificarlos.
         */
        return view('supervisores.edit', compact('supervisor'));
    } //Fin de la funcion edit

    /** Metodo update, que permite modificar los datos de un objeto con el ID que se pasa
     *  por parametros, modificandolo con los datos del Request.
     */
    public function update($id, Request $request) {
        /** Se obtiene el objeto que corresponda al ID */
        $supervisor = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($supervisor)) {
            Flash::error('No se ha encontrado el supervisor');
            return redirect(route('supervisores.index'));
        }

        $datos_viejos = $supervisor->__toString();
        $rol_viejo = $supervisor->getRoleNames()[0];

        /** Se modifican los datos del objeto enontrado con los datos del Request */
        $supervisor->extension = $request->extension;
        $supervisor->mobile = $request->mobile;
        $supervisor->name = $request->name;
        $supervisor->email = $request->email;
        $supervisor->password = bcrypt($request->password);
        $supervisor->syncRoles($request->role_name);
        $supervisor->save();

        $supervisor->__toString();

        $rol_nuevo = $supervisor->getRoleNames()[0];
        
        //En la tabla de bitácora se registra el cambio
        $bitacora = [
            'transaccion'            =>'U',
            'tabla'                  =>'users',
            'id_registro_afectado'   =>$supervisor->id,
            'dato_original'          =>$datos_viejos.' [role_name: '.$rol_viejo.']',
            'dato_nuevo'             =>$supervisor->__toString().' [role_name: '.$rol_nuevo.']',
            'fecha_hora_transaccion' =>Carbon::now(),
            'id_usuario'             =>Auth::user()->id,
            'created_at'             =>Carbon::now()
        ];

        DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado con exito');
        return redirect(route('supervisores.index'));
    } //Fin de la funcion update

    public function destroy($id) {
        if(Auth::user()->id == $id) {
            Flash::error('No puedes eliminarte a ti mismo.');
            return redirect(route('supervisores.index'));
        }

        /** Se obtiene el objeto que corresponda al ID */
        $supervisor = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($supervisor)) {
            Flash::error('No se ha encontrado el supervisor');
            return redirect(route('supervisores.index'));
        }

        /** Se borra el objeto encontrado */
        $supervisor->deleted_at = Carbon::now();
        $supervisor->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado el supervisor '.$supervisor->name.' correctamente.');
        return redirect(route('supervisores.index'));
    } //Fin de la funcion destroy
}
