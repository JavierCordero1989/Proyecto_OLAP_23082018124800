<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Flash;
use Carbon\Carbon;

class SupervisoresController extends Controller
{
    /** Metodo index que carga la vista de inicio con los datos de la base de datos. */
    public function index() {
        /** Hacer una seleccion de todos los elementos de la BD para llevarlos a la
         *  vista de index.
         */
        /** Para que no obtenga los usuarios que han sido dados de baja */
        $usuarios = User::whereNull('deleted_at')->get();

        $lista_supervisores = [];

        /** Se guardan todos los que son supervisores dentro del array para llevarlos a la vista */
        foreach($usuarios as $supervisor) {
            if($supervisor->hasRole('Supervisor 1') || $supervisor->hasRole('Supervisor 2')) {
                array_push($lista_supervisores, $supervisor);
            }
        }
        /** Se regresa a la vista de index en la carpeta deseada, con los datos obtenidos 
         *  desde la base de datos.
          */
        return view('supervisores.index', compact('lista_supervisores'));
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

        $nuevo_supervisor = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ]);

        $nuevo_supervisor->assignRole('Supervisor');

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

        /** Se modifican los datos del objeto enontrado con los datos del Request */
        $supervisor->name = $request->name;
        $supervisor->email = $request->email;
        $supervisor->password = bcrypt($request->password);
        $supervisor->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado con exito');
        return redirect(route('supervisores.index'));
    } //Fin de la funcion update

    public function destroy($id) {
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
