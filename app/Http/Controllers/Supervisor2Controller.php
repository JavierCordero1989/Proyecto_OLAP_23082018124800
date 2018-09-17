<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DatosCarreraGraduado;
use App\EncuestaGraduado;
use App\Asignacion;
use App\TiposDatosCarrera;
use App\ContactoGraduado;
use App\DetalleContacto;
use App\ObservacionesGraduado;
use App\User;
use Carbon\Carbon;
use Flash;
use DB;

class Supervisor2Controller extends Controller
{
    public function lista_general_de_entrevistas() {
        $entrevistas = EncuestaGraduado::listaDeGraduados()->orderBy('id', 'ASC')->paginate(25);

        $id_carrera =       TiposDatosCarrera::carrera()->first();
        $id_universidad =   TiposDatosCarrera::universidad()->first();
        $id_grado =         TiposDatosCarrera::grado()->first();
        $id_disciplina =    TiposDatosCarrera::disciplina()->first();
        $id_area =          TiposDatosCarrera::area()->first();
        $id_agrupacion =    TiposDatosCarrera::agrupacion()->first();
        $id_sector =        TiposDatosCarrera::sector()->first();

        $carreras =      DatosCarreraGraduado::where('id_tipo', $id_carrera->id)     ->pluck('nombre', 'id');
        $universidades = DatosCarreraGraduado::where('id_tipo', $id_universidad->id) ->pluck('nombre', 'id');
        $grados =        DatosCarreraGraduado::where('id_tipo', $id_grado->id)       ->pluck('nombre', 'id');
        $disciplinas =   DatosCarreraGraduado::where('id_tipo', $id_disciplina->id)  ->pluck('nombre', 'id');
        $areas =         DatosCarreraGraduado::where('id_tipo', $id_area->id)        ->pluck('nombre', 'id');
        $agrupaciones =  DatosCarreraGraduado::where('id_tipo', $id_agrupacion->id)  ->pluck('nombre', 'id');
        $sectores =      DatosCarreraGraduado::where('id_tipo', $id_sector->id)      ->pluck('nombre', 'id');

        $datos_carreras = [
            'carreras'      => $carreras,
            'universidades' => $universidades,
            'grados'        => $grados,
            'disciplinas'   => $disciplinas,
            'areas'         => $areas,
            'agrupaciones'  => $agrupaciones,
            'sectores'      => $sectores
        ];

        return view('vistas-supervisor-2.lista-general-de-entrevistas', compact('entrevistas', 'datos_carreras'));
    }

    public function estadisticas_generales() {
        return view('vistas-supervisor-2.estadisticas-generales');
    }

    /*__________________________________________________________________________________________________________*/
    /*                                                                                                          */
    /* La siguiente lista de métodos pertenece al módulo para encuestadores que el supervisor 2                 */
    /* podrá ver, con el cuál podrá ver la lista de encuestadores, modificar sus datos, agregar                 */
    /* nuevos encuestadores, asignarles entrevistas, quitarselas, ver reportes de datos, entre otras funciones. */
    /*__________________________________________________________________________________________________________*/


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
        return view('vistas-supervisor-2.modulo-encuestador.lista-de-encuestadores', compact('lista_encuestadores'));
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
        return view('vistas-supervisor-2.modulo-encuestador.editar-encuestador', compact('encuestador'));
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
        $id_carrera =       TiposDatosCarrera::carrera()->first();
        $id_universidad =   TiposDatosCarrera::universidad()->first();
        $id_grado =         TiposDatosCarrera::grado()->first();
        $id_disciplina =    TiposDatosCarrera::disciplina()->first();
        $id_area =          TiposDatosCarrera::area()->first();
        $id_agrupacion =    TiposDatosCarrera::agrupacion()->first();
        $id_sector =        TiposDatosCarrera::sector()->first();

        $carreras =      DatosCarreraGraduado::where('id_tipo', $id_carrera->id)     ->pluck('nombre', 'id');
        $universidades = DatosCarreraGraduado::where('id_tipo', $id_universidad->id) ->pluck('nombre', 'id');
        $grados =        DatosCarreraGraduado::where('id_tipo', $id_grado->id)       ->pluck('nombre', 'id');
        $disciplinas =   DatosCarreraGraduado::where('id_tipo', $id_disciplina->id)  ->pluck('nombre', 'id');
        $areas =         DatosCarreraGraduado::where('id_tipo', $id_area->id)        ->pluck('nombre', 'id');
        $agrupaciones =  DatosCarreraGraduado::where('id_tipo', $id_agrupacion->id)  ->pluck('nombre', 'id');
        $sectores =      DatosCarreraGraduado::where('id_tipo', $id_sector->id)      ->pluck('nombre', 'id');

        return view('vistas-supervisor-2.modulo-encuestador.lista-filtro-de-encuestas', 
            compact('id_supervisor', 'id_encuestador','carreras', 'universidades', 'grados', 'disciplinas', 'areas', 'agrupaciones', 'sectores'));
    }

    public function encuestas_asignadas_por_encuestador($id_encuestador) {
        $listaDeEncuestas = EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_encuestador)->get();
        $encuestador = User::find($id_encuestador);
        return view('vistas-supervisor-2.modulo-encuestador.tabla-de-encuestas-asignadas-encuestador', compact('listaDeEncuestas', 'encuestador'));
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

        if(!is_null($input['agrupacion'])) {
            $resultado->where('codigo_agrupacion', $input['agrupacion']);
        }

        if(!is_null($input['sector'])) {
            $resultado->where('codigo_sector', $input['sector']);
        }

        $encuestasNoAsignadas = $resultado->get();

        return view('vistas-supervisor-2.modulo-encuestador.tabla-de-encuestas-filtradas', compact('encuestasNoAsignadas', 'id_supervisor', 'id_encuestador'));
    }

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
        return view('vistas-supervisor-2.modulo-encuestador.graficos-por-encuestador');
    }

    /*______________________________________________________________________________________________________*/
    /*                                                                                                      */
    /* La siguiente lista de métodos pertenece a la parte para administrar la información con respecto      */
    /* a los supervisores, tales como sus encuestas, como asignarlas y quitarlas, para realizarlas,         */
    /* modificar los datos, entre otras funciones.                                                          */
    /*______________________________________________________________________________________________________*/

    /** Metodo index que carga la vista de inicio con los datos de la base de datos. */
    public function lista_de_supervisores() {
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
        return view('vistas-supervisor-2.modulo-supervisor.lista-de-supervisores', compact('lista_supervisores'));
    }

    /** Obtiene todos los datos existentes por carrera, universidad, grado, disciplina y area,
     * para poder mostrarlos en un combobox para que el encargado de asignar asl encuestas
     * pueda seleccionar todos los filtros adecuados.
    */
    public function asignar_encuestas_a_supervisor($id_supervisor, $id_supervisor_asignado) {
        $id_carrera =       TiposDatosCarrera::carrera()->first();
        $id_universidad =   TiposDatosCarrera::universidad()->first();
        $id_grado =         TiposDatosCarrera::grado()->first();
        $id_disciplina =    TiposDatosCarrera::disciplina()->first();
        $id_area =          TiposDatosCarrera::area()->first();
        $id_agrupacion =    TiposDatosCarrera::agrupacion()->first();
        $id_sector =        TiposDatosCarrera::sector()->first();

        $carreras =      DatosCarreraGraduado::where('id_tipo', $id_carrera->id)     ->pluck('nombre', 'id');
        $universidades = DatosCarreraGraduado::where('id_tipo', $id_universidad->id) ->pluck('nombre', 'id');
        $grados =        DatosCarreraGraduado::where('id_tipo', $id_grado->id)       ->pluck('nombre', 'id');
        $disciplinas =   DatosCarreraGraduado::where('id_tipo', $id_disciplina->id)  ->pluck('nombre', 'id');
        $areas =         DatosCarreraGraduado::where('id_tipo', $id_area->id)        ->pluck('nombre', 'id');
        $agrupaciones =  DatosCarreraGraduado::where('id_tipo', $id_agrupacion->id)  ->pluck('nombre', 'id');
        $sectores =      DatosCarreraGraduado::where('id_tipo', $id_sector->id)      ->pluck('nombre', 'id');

        return view('vistas-supervisor-2.modulo-supervisor.lista-filtro-encuestas', 
            compact(
                'id_supervisor', 
                'id_supervisor_asignado',
                'carreras', 
                'universidades', 
                'grados', 
                'disciplinas', 
                'areas', 
                'agrupaciones', 
                'sectores'
            )
        );
    }

    public function encuestas_asignadas_por_supervisor($id_supervisor) {
        $listaDeEncuestas = EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_supervisor)->get();
        $supervisor = User::find($id_supervisor);

        return view('vistas-supervisor-2.modulo-supervisor.tabla-de-encuestas-asignadas-supervisor', compact('listaDeEncuestas', 'supervisor'));
    }

    /** Permite obtenet todas las encuestas que tienen por estado NO ASIGNADA, mediante los filtros
     * que el usuario haya agregado en la vista.
     */
    public function filtrar_muestra_de_entrevistas_a_asignar_a_supervisor($id_supervisor, $id_supervisor_asignado, Request $request) {
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

        if(!is_null($input['agrupacion'])) {
            $resultado->where('codigo_agrupacion', $input['agrupacion']);
        }
        
        if(!is_null($input['sector'])) {
            $resultado->where('codigo_sector', $input['sector']);
        }

        $encuestasNoAsignadas = $resultado->get();

        return view('vistas-supervisor-2.modulo-supervisor.tabla-de-encuestas-filtradas', compact('encuestasNoAsignadas', 'id_supervisor', 'id_supervisor_asignado'));
    }

    public function remover_encuestas_a_supervisor($id_entrevista, $id_supervisor) {
        $entrevista = EncuestaGraduado::find($id_entrevista);
        $quito_entrevista = $entrevista->desasignarEntrevista();
        
        if($quito_entrevista) {
            Flash::success('Se ha eliminado la entrevista de este supervisor');
            return redirect(route('supervisor2.encuestas-asignadas-por-supervisor', $id_supervisor));
        }
        else {
            Flash::error('No se ha podido eliminar la entrevista de este supervisor');
            return redirect(route('supervisor2.encuestas-asignadas-por-supervisor', $id_supervisor));
        }
    }

    /** Recibe las encuestas seleccionadas por la persona que realiza la asignacion, y realiza algunas
     * validaciones. Primero comprueba que el supervisor que realizó la asignación exista en la base de datos,
     * luego que el encuestador también exista. Después busca los estados NO ASIGNADA y ASIGNADA para 
     * cambiar el estado de las encuestas de uno a otra.
     */
    public function crear_nueva_asignacion_a_supervisor($id_supervisor, $id_supervisor_asignado, Request $request) {

        /** Se obtiene el supervisor por el ID */
        $supervisor = User::find($id_supervisor);

        /** Si el supervisor no se encuentra en la BD */
        if(empty($supervisor)) {
            Flash::error('El supervisor con el ID '.$id_supervisor.' no existe');
            return redirect(route('supervisor2.lista-de-supervisores'));
        }

        /** Se obtiene el encuestador por el ID */
        $supervisor_asignado = User::find($id_supervisor_asignado);

        /** Si el supervisor asignado no se encuentra en la BD */
        if(empty($supervisor_asignado)) {
            Flash::error('El supervisor asignado con el ID '.$id_supervisor_asignado.' no existe');
            return redirect(route('supervisor2.lista-de-supervisores'));
        }

        /** Se consulta si el estado 'NO ASIGNADA' existe en la base de datos */
        $id_estado_sin_asignar = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        /** Mensaje en caso de que el estado NO ASIGNADA no exista */
        if(is_null($id_estado_sin_asignar)) {
            Flash::error('El estado \"NO ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('supervisor2.lista-de-supervisores'));
        }

        /** Se consulta si el estado 'ASIGNADA' existe en la base de datos */
        $id_estado_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'ASIGNADA')->first();

        /** Mensaje en caso de que el estado ASIGNADA no exista */
        if(is_null($id_estado_asignada)) {
            Flash::error('El estado \"ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('supervisor2.lista-de-supervisores'));
        }

        $encuestas_no_encontradas = [];

        /** Se hace una busqueda de la encuesta */
        foreach($request->encuestas as $id_graduado) {
            $registro_encuesta = EncuestaGraduado::find($id_graduado);

            if(empty($registro_encuesta)) {
                array_push($encuestas_no_encontradas, $id_graduado);
            }

            $update = $registro_encuesta->asignarEncuesta($id_supervisor, $id_supervisor_asignado, $id_estado_sin_asignar->id, $id_estado_asignada->id);
        }

        if(sizeof($encuestas_no_encontradas) <= 0) {
            Flash::success('Se han asignado las encuestas correctamente.');
        }
        else {
            Flash::warning('Algunas encuestas no han sido asignadas: '.$encuestas_no_encontradas);
        }

        return redirect(route('supervisor2.lista-de-supervisores'));
    }

    public function graficos_por_estado_de_supervisor($id_supervisor) {
        return view('vistas-supervisor-2.modulo-supervisor.graficos-por-supervisor');
    }

    public function realizar_entrevista($id_entrevista) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('supervisor2.encuestas-asignadas-por-supervisor', Auth::user()->id));
        }
        
        $estados = DB::table('tbl_estados_encuestas')->get()->pluck('estado', 'id');

        return view('vistas-supervisor-2.modulo-supervisor.realizar-entrevista', compact('entrevista', 'estados'));
    }

    public function agregar_contacto($id_entrevista) {
        return view('vistas-supervisor-2.modulo-supervisor.agregar-contacto-entrevista')->with('id_entrevista', $id_entrevista);
    }

    public function actualizar_entrevista($id_entrevista, Request $request) {
        // dd($request->all());

        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('supervisor2.encuestas-asignadas-por-supervisor', Auth::user()->id));
        }

        //Cambiar el estado de la entrevista por el del request
        $cambio_estado = $entrevista->cambiarEstadoDeEncuesta($request->estados);

        if(!$cambio_estado) {
            Flash::error('No se ha podido cambiar el estado de la entrevista');
            return redirect(route('supervisor2.encuestas-asignadas-por-supervisor', $id_entrevista));
        }

        //si no existen observaciones, agregarla, de lo contrario modificar la existente.
        $observaciones_entrevista = $entrevista->observaciones;

        if(sizeof($observaciones_entrevista) == 0) {
            //Agregar la observación
            $nueva_observacion = ObservacionesGraduado::create([
                'id_graduado' => $entrevista->id,
                'id_usuario' => Auth::user()->id,
                'observacion' => $request->observacion,
                'created_at' => Carbon::now()
            ]);
        }
        else {
            //Modificar la existente
            $observacion_existente = ObservacionesGraduado::where('id_graduado', $entrevista->id)->first();
            $observacion_existente->observacion = $request->observacion;
            $observacion_existente->updated_at = Carbon::now();
            $cambio_observacion = $observacion_existente->save();

            if(!$cambio_observacion) {
                Flash::error('No se ha podido agregar la observación a la entrevista');
                return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
            }
        }

        Flash::success('Se han guardado correctamente los cambios');
        return redirect(route('supervisor2.encuestas-asignadas-por-supervisor', Auth::user()->id));
    }

    public function guardar_contacto($id_entrevista, $id_supervisor, Request $request) {
        
        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            'parentezco'                => $request->parentezco,
            'id_graduado'               => $id_entrevista,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
    }

    public function agregar_detalle_contacto($id_contacto, $id_entrevista) {
        return view('vistas-supervisor-2.modulo-supervisor.agregar-detalle-contacto', compact('id_contacto', 'id_entrevista'));
    }

    public function borrar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
        }

        $detalle->deleted_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha eliminado.');
        return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
    }

    public function editar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
        }

        return view('vistas-supervisor-2.modulo-supervisor.editar-detalle-contacto', compact('detalle', 'id_entrevista'));
    }

    public function editar_contacto_entrevista($id_contacto, $id_entrevista) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
        }

        return view('vistas-supervisor-2.modulo-supervisor.modificar-contacto-entrevista', compact('contacto', 'id_entrevista'));
    }

    public function guardar_detalle_contacto($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto.');
            return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
        }

        $contacto->agregarDetalle($request->contacto, $request->observacion);

        Flash::success('Se ha agregado información al contacto correctamente.');
        return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
    }

    public function actualizar_detalle_contacto($id_detalle_contacto, $id_entrevista, Request $request) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
        }

        $detalle->contacto = $request->contacto;
        $detalle->observacion = $request->observacion;
        $detalle->updated_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha modificado correctamente.');
        return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
    }

    public function actualizar_contacto_entrevista($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
        }

        $contacto->identificacion_referencia = $request->identificacion_referencia;
        $contacto->nombre_referencia = $request->nombre_referencia;
        $contacto->parentezco = $request->parentezco;
        $contacto->updated_at = Carbon::now();
        $contacto->save();

        Flash::success('El contacto ha sido actualizado correctamente.');
        return redirect(route('supervisor2.realizar-entrevista', $id_entrevista));
    }

    public function agregar_nuevo_caso_entrevista(Request $request) {

        
        $nueva_encuesta = EncuestaGraduado::create([
            'identificacion_graduado'   => $request->identificacion_graduado,
            'token'                     => $request->token,
            'nombre_completo'           => $request->nombre_completo,
            'annio_graduacion'          => $request->annio_graduacion,
            'link_encuesta'             => $request->link_encuesta,
            'sexo'                      => $request->sexo,
            'codigo_carrera'            => $request->codigo_carrera,
            'codigo_universidad'        => $request->codigo_universidad,
            'codigo_grado'              => $request->codigo_grado,
            'codigo_disciplina'         => $request->codigo_disciplina,
            'codigo_area'               => $request->codigo_area,
            'codigo_agrupacion'         => $request->codigo_agrupacion,
            'codigo_sector'             => $request->codigo_sector,
            'tipo_de_caso'              => $request->tipo_de_caso
        ]);

        if($request->agregar_contacto == 1) {
            return redirect(route('supervisor2.agregar-contacto-nueva-entrevista', $nueva_encuesta->id));
        }
        else {
            Flash::success('Se ha agregado correctamente el nuevo caso de entrevista');
            return redirect(route('supervisor2.lista-general-de-entrevistas'));
        }
    }

    public function agregar_contacto_nueva_entrevista($id_entrevista) {
        return view('vistas-supervisor-2.agregar-contacto-nueva-entrevista')->with('id_entrevista', $id_entrevista);
    }

    public function guardar_contacto_nueva_entrevista($id_entrevista, Request $request) {
        
        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            'parentezco'                => $request->parentezco,
            'id_graduado'               => $id_entrevista,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('supervisor2.lista-general-de-entrevistas'));
    }
}
