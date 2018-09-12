<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosCarreraGraduado;
use App\EncuestaGraduado;
use App\Asignacion;
use App\User;
use Flash;
use DB;

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

    // public function crear_nuevo_encuestador() {
    //     /** Se llama a la vista para crear un nuevo registro. No se obtienen datos de la BD. */
    //     return view('vistas-supervisor-2.crear-nuevo-encuestador');
    // }

    public function almacenar_nuevo_encuestador(Request $request) {
        /** Dos formas de guardar un objeto:
         * 1- Creando una instancia del objeto y seteando los valores con los del Request.
         * 2- Mediante el metodo create de la clase Model, igual obteniendo los datos del Request
         */

        $input = $request->all();

        $validar_codigo_encuestador = User::where('user_code', $input['user_code'])->first();

        if(!is_null($validar_codigo_encuestador)) {
            Flash::error('El código que ingresó para el encuestador ya se encuestra asignado a alguien más.<br>Por favor, verifique de nuevo.');
            return redirect(route('supervisor2.lista-de-encuestadores'));
        }

        $validar_correo_repetido = User::where('email', $request->email)->first();

        if(!is_null($validar_correo_repetido)) {
            Flash::error('Intenta ingresar un email que ya está registrado para otro encuestador.<br>Intente de nuevo.');
            return redirect(route('supervisor2.lista-de-encuestadores'));
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

    // public function ver_encuestador($id) {
    //     /** se obtiene el objeto que corresponda al ID */
    //     $encuestador = User::find($id);

    //     /** Si el objeto obtenido esta vacio, se envia un mensaje de error y se redirige a la ruta index */
    //     if(empty($encuestador)) {
    //         Flash::error('Encuestador no encontrado');
    //         return redirect(route('supervisor2.lista-de-encuestadores'));
    //     }
    //     /** Si el objeto contiene informacion se muestra la vista show con los datos obtenidos del objeto. */
    //     return view('vistas-supervisor-2.ver-encuestador', compact('encuestador'));
    // }

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

    /** Permite obtenet todas las encuestas que tienen por estado NO ASIGNADA, mediante los filtros
     * que el usuario haya agregado en la vista.
     */
    public function filtrar_muestra_de_entrevistas_a_asignar($id_supervisor, $id_encuestador, Request $request) {
        $input = $request->all();

        $resultado = EncuestaGraduado::listaDeEncuestasSinAsignar();

        if(!is_null($input['carrera'])) {
            $resultado->where('codigo_carrera', $input['carrera']);
        }

        if(!is_null($input['universidad'])) {
            $resultado->where('codigo_universidad', $input['universidad']);
        }

        if(!is_null($input['grado'])) {
            $resultado->where('codigo_grado', $input['grado']);
        }

        if(!is_null($input['disciplina'])) {
            $resultado->where('codigo_disciplina', $input['disciplina']);
        }

        if(!is_null($input['area'])) {
            $resultado->where('codigo_area', $input['area']);
        }

        $encuestasNoAsignadas = $resultado->get();

        return view('vistas-supervisor-2.tabla-de-encuestas-filtradas', compact('encuestasNoAsignadas', 'id_supervisor', 'id_encuestador'));
    }

    // public function remover_encuestas_a_encuestador($id_encuestador, Request $request) {

    //     $encuestasAsignadas = Asignacion::where('id_encuestador', $id_encuestador)->get();
    //     $id_no_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

    //     foreach($encuestasAsignadas as $encuesta) {
    //         // echo 'Encuesta: '.$encuesta->id.'<br>';
    //         foreach($request->encuestas as $id_desasignada) {
    //             if($encuesta->id_graduado == $id_desasignada) {
    //                 $encuesta->id_encuestador = null;
    //                 $encuesta->id_supervisor = null;
    //                 $encuesta->id_estado = $id_no_asignada->id;
    //                 $encuesta->updated_at = \Carbon\Carbon::now();
    //                 $encuesta->save();
    //             }
    //         }
    //     }

    //     Flash::success('Se han eliminado las encuestas de este encuestador');
    //     return redirect(route('supervisor2.encuestas-asignadas-por-encuestador', $id_encuestador));
    // }

    public function remover_encuestas_a_encuestador($id_entrevista, $id_encuestador) {
        $entrevista = EncuestaGraduado::find($id_entrevista);
        $quito_entrevista = $entrevista->desasignarEntrevista();
        
        if($quito_entrevista) {
            Flash::success('Se ha eliminado la entrevista de este encuestador');
            return redirect(route('supervisor2.encuestas-asignadas-por-encuestador', $id_encuestador));
        }
        else {
            Flash::error('No se ha podido eliminar la entrevista de este encuestador');
            return redirect(route('supervisor2.encuestas-asignadas-por-encuestador', $id_encuestador));
        }
    }

    /** Recibe las encuestas seleccionadas por la persona que realiza la asignacion, y realiza algunas
     * validaciones. Primero comprueba que el supervisor que realizó la asignación exista en la base de datos,
     * luego que el encuestador también exista. Después busca los estados NO ASIGNADA y ASIGNADA para 
     * cambiar el estado de las encuestas de uno a otra.
     */
    public function crear_nueva_asignacion($id_supervisor, $id_encuestador, Request $request) {

        /** Se obtiene el supervisor por el ID */
        $supervisor = User::find($id_supervisor);

        /** Si el supervisor no se encuentra en la BD */
        if(empty($supervisor)) {
            Flash::error('El supervisor con el ID '.$id_supervisor.' no existe');
            return redirect(route('supervisor2.lista-de-encuestadores'));
        }

        /** Se obtiene el encuestador por el ID */
        $encuestador = User::find($id_encuestador);

        /** Si el encuestador no se encuentra en la BD */
        if(empty($encuestador)) {
            Flash::error('El encuestador con el ID '.$id_encuestador.' no existe');
            return redirect(route('supervisor2.lista-de-encuestadores'));
        }

        /** Se consulta si el estado 'NO ASIGNADA' existe en la base de datos */
        $id_estado_sin_asignar = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        /** Mensaje en caso de que el estado NO ASIGNADA no exista */
        if(is_null($id_estado_sin_asignar)) {
            Flash::error('El estado \"NO ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('supervisor2.lista-de-encuestadores'));
        }

        /** Se consulta si el estado 'ASIGNADA' existe en la base de datos */
        $id_estado_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'ASIGNADA')->first();

        /** Mensaje en caso de que el estado ASIGNADA no exista */
        if(is_null($id_estado_asignada)) {
            Flash::error('El estado \"ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('supervisor2.lista-de-encuestadores'));
        }

        $encuestas_no_encontradas = [];

        /** Se hace una busqueda de la encuesta */
        foreach($request->encuestas as $id_graduado) {
            $registro_encuesta = EncuestaGraduado::find($id_graduado);

            if(empty($registro_encuesta)) {
                array_push($encuestas_no_encontradas, $id_graduado);
            }

            $update = $registro_encuesta->asignarEncuesta($id_supervisor, $id_encuestador, $id_estado_sin_asignar->id, $id_estado_asignada->id);
        }

        if(sizeof($encuestas_no_encontradas) <= 0) {
            Flash::success('Se han asignado las encuestas correctamente.');
        }
        else {
            Flash::warning('Algunas encuestas no han sido asignadas: '.$encuestas_no_encontradas);
        }

        return redirect(route('supervisor2.lista-de-encuestadores'));
    }



    public function graficos_por_estado_de_encuestador($id_encuestador) {
        return view('vistas-supervisor-2.graficos-por-encuestador');
    }



}
