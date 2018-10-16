<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Flash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class EncuestadoresController extends Controller
{
    /** Metodo index que carga la vista de inicio con los datos de la base de datos. */
    public function index() {
        /** Hacer una seleccion de todos los elementos de la BD para llevarlos a la
         *  vista de index.
         */
        /** Para que no obtenga los usuarios que han sido dados de baja */
        $usuarios = User::whereNull('deleted_at')->get();

        $lista_encuestadores = [];

        /** Se guardan todos los que son encuestadores dentro del array para llevarlos a la vista */
        foreach($usuarios as $encuestador) {
            if($encuestador->hasRole('Encuestador')) {
                array_push($lista_encuestadores, $encuestador);
            }
        }
        /** Se regresa a la vista de index en la carpeta deseada, con los datos obtenidos 
         *  desde la base de datos.
          */
        return view('encuestadores.index', compact('lista_encuestadores'));
    }

    /** Metodo create, que carga la vista con los campos para ingresar los datos necesarios
     *  para guardar un nuevo registro.
     */
    public function create() {
        /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
        return view('encuestadores.create');
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

        // Se verifica que el código ingresado no exista
        $usuario_consultado = User::findByUserCode($input['user_code'])->first();

        if(!empty($usuario_consultado)) {
            Flash::error('El código que registró ya existe para otro usuario.');
            return redirect(route('encuestadores.index'));
        }

        // Se verifica que el correo ingresado no exista.
        $usuario_consultado = User::findByEmail($input['email'])->first();

        if(!empty($usuario_consultado)) {
            Flash::error('El email que registró ya existe para otro usuario.');
            return redirect(route('encuestadores.index'));
        }

        // Si no existe ni el código ni el correo en otro usuario, se guarda en la base de datos.
        $nuevo_encuestador = User::create([
            'user_code' => $input['user_code'],
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password'])
        ]);

        $nuevo_encuestador->assignRole('Encuestador');

        /** Mensaje de exito que se carga en la vista. */
        Flash::success('Se ha guardado el encuestador');
        /** Se direcciona a la ruta del index, para volver a cargar los datos. */
        return redirect(route('encuestadores.index'));
    } //Fin de la funcion store.

    /** Metodo show, que muestra los datos de un objeto que posea el ID asociado por 
     * parametros.
     */
    public function show($id) {
        /** se obtiene el objeto que corresponda al ID */
        $encuestador = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('Encuestador no encontrado');
            return redirect(route('encuestadores.index'));
        }
        /** Si el objeto contiene informacion se muestra la vista show con los datos obtenidos del objeto. */
        return view('encuestadores.show', compact('encuestador'));
    } //Fin de la funcion show

    /** Metodo edit, que obtiene los datos de un objeto mediante su ID, para luego cargar
     * la vista edit con los datos obtenidos.
     */
    public function edit($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $encuestador = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('Encuestador no encontrado');
            return redirect(route('encuestadores.index'));
        }

        /** Si el objeto contiene informacion se muestra la vista edit con los datos obtenidos del objeto,
         * esto para poder ver los datos que contiene, y asi poder modificarlos.
         */
        return view('encuestadores.edit', compact('encuestador'));
    } //Fin de la funcion edit

    /** Metodo update, que permite modificar los datos de un objeto con el ID que se pasa
     *  por parametros, modificandolo con los datos del Request.
     */
    public function update($id, Request $request) {
        // $validar_encuestador_repetido = User::where('user_code', $request->user_code)->first();

        // if(!is_null($validar_encuestador_repetido)) {
        //     Flash::error('Intenta ingresar un código que ya está registrado para otro encuestador.<br>Intente de nuevo.');
        //     return redirect(route('encuestadores.edit', $id));
        //     // return redirect(route('encuestadores.edit', $id))->withErrors(['user_code'=>'Intenta ingresar un código que ya está registrado para otro encuestador.<br>Intente de nuevo.']);
        // }

        /** Se obtiene el objeto que corresponda al ID */
        $encuestador = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('No se ha encontrado el encuestador');
            return redirect(route('encuestadores.index'));
        }

        if($request->password == null) {
            /** Se modifican los datos del objeto enontrado con los datos del Request */
            $encuestador->user_code = $request->user_code;
            $encuestador->name = $request->name;
            $encuestador->email = $request->email;
            $encuestador->save();
        }
        else {
            /** Se modifican los datos del objeto enontrado con los datos del Request */
            $encuestador->user_code = $request->user_code;
            $encuestador->name = $request->name;
            $encuestador->email = $request->email;
            $encuestador->password = bcrypt($request->password);
            $encuestador->save();
        }

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha modificado con exito');
        return redirect(route('encuestadores.index'));
    } //Fin de la funcion update

    public function destroy($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $encuestador = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('No se ha encontrado el encuestador');
            return redirect(route('encuestadores.index'));
        }

        /* VALIDA QUE EL ENCUESTADOR NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($encuestador->asignacionesEncuestador) > 0) {
            Flash::error('No es posible eliminar este encuestador debido a que posee entrevistas asignadas.<br>Debe quitarlas o asignarlas a algún encuestador disponible antes.');
            return redirect(route('encuestadores.index'));
        }

        /** Se borra el objeto encontrado */
        $encuestador->deleted_at = Carbon::now();
        $encuestador->save();

        /** Se genera un mensaje de exito y se redirige a la ruta index */
        Flash::success('Se ha eliminado el encuestador '.$encuestador->name.' correctamente.');
        return redirect(route('encuestadores.index'));
    } //Fin de la funcion destroy

    public function cambiar_contrasennia($id_encuestador) {
        $encuestador = User::find($id_encuestador);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('Encuestador no encontrado');
            return redirect(url('home'));
        }

        return view('encuestadores.cambiar-contrasennia')->with('encuestador', $encuestador);
    }

    public function actualizar_contrasennia($id_encuestador, Request $request) {
        $encuestador = User::find($id_encuestador);

        if(Hash::check($request->old_password, $encuestador->password)) {
            $encuestador->password = bcrypt($request->password1);
            $encuestador->save();

            return redirect(url('home'));
        }
        else {
            Flash::error('Su contraseña actual no coincide con la registrada.');
            return redirect(route('encuestadores.cambiar-contrasennia', $id_encuestador));
        }

        dd($id_encuestador, $request->all());
    }

    public function lista_de_encuestas($id){
        $id_encuestador = $id;

        $listaDeEncuestas = \App\EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_encuestador)->get();

        $id_encuestador = $id_encuestador;

        return view('encuestadores.lista-de-encuestas', compact('listaDeEncuestas', 'id_encuestador'));
    }

    public function agregarContacto($id_encuesta) {
        return view('encuestadores.agregar-contacto')->with('id_encuesta', $id_encuesta);
    }

    public function guardarContacto($id_encuesta, $id_encuestador, Request $request) {
        $id_encuesta = $id_encuesta;
        $id_encuestador = $id_encuestador;
        
        $contacto = \App\ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            // 'informacion_contacto'      => $request->informacion_contacto,
            // 'observacion_contacto'      => $request->observacion_contacto,
            'parentezco'                => $request->parentezco,
            'id_graduado'               => $id_encuesta,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('encuestadores.lista-de-encuestas', $id_encuestador));
    }

    public function editarContacto($id_contacto) {
        $contacto = \App\ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        return view('encuestadores.modificar-contacto')->with('contacto', $contacto);
    }

    public function actualizarContacto($id_contacto, Request $request) {
        $contacto = \App\ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        $contacto->identificacion_referencia = $request->identificacion_referencia;
        $contacto->nombre_referencia = $request->nombre_referencia;
        $contacto->parentezco = $request->parentezco;
        $contacto->updated_at = Carbon::now();
        $contacto->save();

        Flash::success('El contacto ha sido actualizado correctamente.');
        return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
    }
}
