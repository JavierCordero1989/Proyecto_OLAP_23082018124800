<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosCarreraGraduado;
use App\EncuestaGraduado;
use App\User;
use Flash;

class Supervisor2Controller extends Controller
{
    public function lista_de_encuestadores() {
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
        return view('vistas-supervisor-2.lista-de-encuestadores', compact('lista_encuestadores'));
    }

    public function crear_nuevo_encuestador() {
        /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
        return view('vistas-supervisor-2.crear-nuevo-encuestador');
    }

    public function almacenar_nuevo_encuestador(Request $request) {
        /** Dos formas de guardar un objeto:
         * 1- Creando una instancia del objeto y seteando los valores con los del Request.
         * 2- Mediante el metodo create de la clase Model, igual obteniendo los datos del Request
         */

        $input = $request->all();

        $validar_codigo_encuestador = User::where('user_code', $input['user_code'])->first();

        if(!is_null($validar_codigo_encuestador)) {
            Flash::error('El código que ingresó para el encuestador ya se encuestra asignado a alguien más.<br>Por favor, verifique de nuevo.');
            return redirect(route('supervisor2.crear-nuevo-encuestador'));
        }

        $validar_correo_repetido = User::where('email', $request->email)->first();

        if(!is_null($validar_correo_repetido)) {
            Flash::error('Intenta ingresar un email que ya está registrado para otro encuestador.<br>Intente de nuevo.');
            return redirect(route('supervisor2.crear-nuevo-encuestador'));
        }

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
        return redirect(route('supervisor2.lista-de-encuestadores'));
    }

    public function ver_encuestador($id) {
        /** se obtiene el objeto que corresponda al ID */
        $encuestador = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('Encuestador no encontrado');
            return redirect(route('supervisor2.lista-de-encuestadores'));
        }
        /** Si el objeto contiene informacion se muestra la vista show con los datos obtenidos del objeto. */
        return view('vistas-supervisor-2.ver-encuestador', compact('encuestador'));
    }

    public function editar_encuestador($id) {
        /** Se obtiene el objeto que corresponda al ID */
        $encuestador = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('Encuestador no encontrado');
            return redirect(route('supervisor2.lista-de-encuestadores'));
        }

        /** Si el objeto contiene informacion se muestra la vista edit con los datos obtenidos del objeto,
         * esto para poder ver los datos que contiene, y asi poder modificarlos.
         */
        return view('vistas-supervisor-2.editar-encuestador', compact('encuestador'));
    }

    public function actualizar_datos_encuestador($id, Request $request) {
        $validar_codigo_repetido = User::where('user_code', $request->user_code)->first();

        if(!is_null($validar_codigo_repetido) && $validar_codigo_repetido->id!=$id) {
            Flash::error('Intenta ingresar un código que ya está registrado para otro encuestador.<br>Intente de nuevo.');
            return redirect(route('supervisor2.editar-encuestador', $id));
            // return redirect(route('encuestadores.edit', $id))->withErrors(['user_code'=>'Intenta ingresar un código que ya está registrado para otro encuestador.<br>Intente de nuevo.']);
        }

        $validar_correo_repetido = User::where('email', $request->email)->first();

        if(!is_null($validar_correo_repetido) && $validar_correo_repetido->id!=$id) {
            Flash::error('Intenta ingresar un email que ya está registrado para otro encuestador.<br>Intente de nuevo.');
            return redirect(route('supervisor2.editar-encuestador', $id));
            // return redirect(route('encuestadores.edit', $id))->withErrors(['user_code'=>'Intenta ingresar un código que ya está registrado para otro encuestador.<br>Intente de nuevo.']);
        }

        /** Se obtiene el objeto que corresponda al ID */
        $encuestador = User::find($id);

        /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
        if(empty($encuestador)) {
            Flash::error('No se ha encontrado el encuestador');
            return redirect(route('supervisor2.lista-de-encuestadores'));
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
        return redirect(route('supervisor2.lista-de-encuestadores'));
    }

    /** Obtiene todos los datos existentes por carrera, universidad, grado, disciplina y area,
     * para poder mostrarlos en un combobox para que el encargado de asignar asl encuestas
     * pueda seleccionar todos los filtros adecuados.
    */
    public function asignar_encuestas_a_encuestador($id_supervisor, $id_encuestador) {
        $carreras = DatosCarreraGraduado::where('id_tipo', 1)       ->pluck('nombre', 'id');
        $universidades = DatosCarreraGraduado::where('id_tipo', 2)  ->pluck('nombre', 'id');
        $grados = DatosCarreraGraduado::where('id_tipo', 3)         ->pluck('nombre', 'id');
        $disciplinas = DatosCarreraGraduado::where('id_tipo', 4)    ->pluck('nombre', 'id');
        $areas = DatosCarreraGraduado::where('id_tipo', 5)          ->pluck('nombre', 'id');

        return view('vistas-supervisor-2.lista-filtro-de-encuestas', 
            compact('id_supervisor', 'id_encuestador','carreras', 'universidades', 'grados', 'disciplinas', 'areas'));
    }

    public function encuestas_asignadas_por_encuestador($id_encuestador) {
        $listaDeEncuestas = EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_encuestador)->get();

        return view('vistas-supervisor-2.tabla-de-encuestas-asignadas-encuestador', compact('listaDeEncuestas', 'id_encuestador'));
    }

    public function graficos_por_estado_de_encuestador($id_encuestador) {
        return view('vistas-supervisor-2.graficos-por-encuestador');
    }

    

}
