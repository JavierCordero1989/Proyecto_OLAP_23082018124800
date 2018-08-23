<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Flash; //Para las notificaciones de error en las vistas.

class PermissionsController extends Controller
{
    /** Metodo index que carga la vista de inicio con los datos de la base de datos. */
    public function index() {
        /** Hacer una seleccion de todos los elementos de la BD para llevarlos a la
         *  vista de index.
         */
        $permisos = Permission::all();
        // $permisos = Permission::orderBy('id', 'asc')->paginate(15);

        /** Se regresa a la vista de index en la carpeta deseada, con los datos obtenidos 
         *  desde la base de datos.
          */
        return view('permisos.index', compact('permisos'));
    } //Fin de la funcion index

    /** Metodo create, que carga la vista con los campos para ingresar los datos necesarios
     *  para guardar un nuevo registro.
     */
    public function create() {
        /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
        return view('permisos.create');
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

        $nuevo_permiso = Permission::create([
            'name' => $input['name'],
            'guard_name' => $input['guard_name']
        ]);

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado el permiso');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('permisos.index'));
    } //Fin de la funcion store.

    /** Metodo show, que muestra los datos de un objeto que posea el ID asociado por 
     * parametros.
     */
    public function show($id) {
        /** se obtiene el objeto que corresponda al ID */
        $permiso = Permission::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($permiso)) {
            Flash::error('Permiso no encontrado');
            return redirect(route('permisos.index'));
        }
        /** Si el objeto contiene informacion se muestra la vista show con los datos obtenidos del objeto. */
        return view('permisos.show', compact('permiso'));
    } //Fin de la funcion show

    /** Metodo edit, que obtiene los datos de un objeto mediante su ID, para luego cargar
     * la vista edit con los datos obtenidos.
     */
    public function edit($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $permiso = Permission::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($permiso)) {
            Flash::error('Permiso no encontrado');
            return redirect(route('permisos.index'));
        }

        /** Si el objeto contiene informacion se muestra la vista edit con los datos obtenidos del objeto,
         * esto para poder ver los datos que contiene, y asi poder modificarlos.
         */
        return view('permisos.edit', compact('permiso'));
    } //Fin de la funcion edit

    /** Metodo update, que permite modificar los datos de un objeto con el ID que se pasa
     *  por parametros, modificandolo con los datos del Request.
     */
    public function update($id, Request $request) {
        /** Se obtiene el objeto que corresponda al ID */
        $permiso = Permission::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($permiso)) {
            Flash::error('No se ha encontrado el permiso');
            return redirect(route('permisos.index'));
        }

        /** Se modifican los datos del objeto enontrado con los datos del Request */
        $permiso->name = $request->name;
        $permiso->guard_name = $request->guard_name;
        $permiso->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado con exito');
        return redirect(route('permisos.index'));
    } //Fin de la funcion update

    public function destroy($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $permiso = Permission::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($permiso)) {
            Flash::error('No se ha encontrado el permiso');
            return redirect(route('permisos.index'));
        }

        /** Se borra el objeto encontrado */
        $permiso->delete();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado el permiso correctamente.');
        return redirect(route('permisos.index'));
    } //Fin de la funcion destroy
}
