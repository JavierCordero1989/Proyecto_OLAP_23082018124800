<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use App\CitaCalendario as Cita;
use Illuminate\Http\Request;
use App\User as Usuario;
use Carbon\Carbon;
use Flash;
use DB;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class CalendarioDeCitasController extends Controller
{
    /**variable para guardar la ruta de la vista para agendar cita */
    private $vista_agendar_cita;

    /** constructor de la clase, para iniciar la variable de la ruta para la vista */
    public function __construct() {
        $this->vista_agendar_cita = 'calendario-de-citas.agendar-cita-entrevista';
    }

    /**
     * @param $id_usuario ID del usuario que se desea obtener las citas.
     * Permite obtener las citas del calendario agendadas por medio del ID del usuario, y
     * si el usuario es encuestador, solo mostrará las citas de ese usuario.
     */
    public function ver_calendario($id_usuario) {

        $user = Usuario::find($id_usuario);

        if(empty($user)) {
            Flash::error('No se ha encontrado el usuario');
            return redirect(route('home'));
        }

        $citas;
        
        //Si el usuario es un encuestador, que cargue solo las citas hechas por él.
        if($user->hasRole('Encuestador')) {
            $citas = Cita::citasDeEncuestador($id_usuario)->get();
        }
        else {
            $citas = Cita::all();
        }

        /* se devuelven las citas en formato JSON para cargarlas por la vista */
        return view('calendario-de-citas.calendario')->with('citas', json_encode($citas));
        // return view('calendario-de-citas.calendario', compact('citas'));
    }

    /**
     * @param $encuestador     Encuestador que hace la encuesta
     * @param $mal_encuestador ID para regresar a una vista determinada
     * @param $entrevista      Entrevista a realizarse
     * @param $mal_entrevista  ID para regresar a una vista determinada
     * 
     * Permite agendar una entrevista en el calendario
     */
    public function agendar_cita_a_entrevista($encuestador, $mal_encuestador, $entrevista, $mal_entrevista) {

        /* Busca la entrevista en la base de datos */
        $entrevista_cita = Entrevista::find($entrevista);

        /* Si la entrevista encontrada es un objeto vacio devuelve un error*/
        if(empty($entrevista_cita)) {
            Flash::error('La entrevista que busca no existe');
            return redirect(route(config('calendar-routes.'.$mal_entrevista), $entrevista));
        }

        /* Busca el usuario que hizo la solicitud en la base de datos */
        $usuario = Usuario::find($encuestador);

        /* Si el usuario encontrdo es un objeto vacio devuelve un error */
        if(empty($usuario)) {
            Flash::error('El usuario que hizo la solicitud no existe');
            // return redirect(route($this->validar_ruta_mal_encuestador($mal_encuestador)));
            return redirect(route(config('calendar-routes.'.$mal_encuestador)));
        }

        $contactos_entrevista = array();
        $contactos = $entrevista_cita->contactos;

        foreach($contactos as $contacto) {
            $detalles = $contacto->detalle;
            $resumen_detalle = $detalles->pluck('contacto', 'id');
            foreach($resumen_detalle as $key => $value) {
                $contactos_entrevista[$value] = $value;
            }
        }

        /* Datos esenciales para las rutas */
        $datos_a_vista = [
            'entrevista'  => $entrevista,
            'encuestador' => $encuestador,
            'contactos'   => $contactos_entrevista
        ];

        /* Rutas a usar para las vistas */
        $rutas = [
            'store' => 'calendario.guardar-cita',
            // 'back' => $this->validar_ruta_mala_entrevista($mal_entrevista)
            'back' => config('calendar-routes.'.$mal_entrevista)
        ];

        return view($this->vista_agendar_cita, compact('datos_a_vista', 'rutas'));
    }

    /** 
     * Guarda una cita dentro de la base de datos con la información recibida en el request
     * 
     * @param int $entrevista Es el ID de la entrevista a la cual se desea hacer la cita en la agenda
     * @param Request $request Información obtenida del formulario de HTML
     * @return View Vista con los datos de las acciones acontecidas en el proceso
     */
    public function guardar_cita_de_entrevista($entrevista, $encuestador, Request $request) {

        try {
            DB::beginTransaction();

            $fecha_hora = Carbon::createFromFormat('Y-m-d H:i', ($request->datepicker.' '.$request->timepicker))->format('Y-m-d H:i:s');

            $cita = Cita::create([
                'fecha_hora' => $fecha_hora,
                'numero_contacto' => $request->numero_contacto,
                'observacion' => $request->observacion_de_cita,
                'estado' => 'P',
                'id_encuestador' => $encuestador,
                'id_entrevista' => $entrevista,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_calendario_de_citas',
                'id_registro_afectado'   =>$cita->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>$cita->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);
            
            DB::commit();

            Flash::success('La cita ha sido guardada con éxito.');
            return redirect(route('ver-calendario', $encuestador));

        } catch (\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: guardar_cita_de_entrevista().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('home'));
        }
    }

    public function cambiar_estado_de_cita($id_cita, $encuestador, Request $request) {
        $cita = Cita::find($id_cita);

        if(empty($cita)) {
            Flash::error('La cita que busca no existe.');
            return redirect(route('ver-calendario', $encuestador));
        }

        try {
            DB::beginTransaction();

            $temp = $cita;

            $cita->estado = $request->estado_nuevo;
            $cita->updated_at = Carbon::now();
            $cita->save();
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_calendario_de_citas',
                'id_registro_afectado'   =>$cita->id,
                'dato_original'          =>$temp->__toString(),
                'dato_nuevo'             =>$cita->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('Ha cambiado el estado de la cita');
            return redirect(route('ver-calendario', $encuestador));    
        } catch (\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: cambiar_estado_de_cita().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('home'));
        }
    }

    public function agendar_cita_desde_calendario(Request $request) {

        // dd($request->all());

        try {
            DB::beginTransaction();
    
            $fecha = Carbon::createFromFormat('Y-m-d H:i', ($request->fecha_seleccionada.' '.$request->timepicker))->format('Y-m-d H:i:s');
    
            $data = [
                'fecha_hora'        => $fecha,
                'numero_contacto'   => $request->numero_contacto,
                'observacion'       => $request->observacion_de_cita,
                'estado'            => 'P',
                'id_encuestador'    => $request->usuario,
                'id_entrevista'     => null
            ];
    
            $cita_creada = Cita::create($data);
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_calendario_de_citas',
                'id_registro_afectado'   =>$cita_creada->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>'Cita nueva agregada: ' . $cita_creada->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('La cita ha sido agendada');
            return redirect(route('ver-calendario', $request->usuario));

        } catch (\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: agendar_cita_desde_calendario().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('home'));
        }
    }

    public function obtener_citas_calendario(Request $request) {
        $usuario = Usuario::find($request->id);

        $data = null;

        if(empty($usuario)) {
            $data = [
                'count'=>0,
                'citas'=>[]
            ];

            return $data;
        }

        $citas = null;

        if($usuario->hasRole('Encuestador')) {
            $citas = Cita::listaDePendientes()->where('id_encuestador', $usuario->id)->get();
        }
        else {
            $citas = Cita::listaDePendientes()->get();
        }

        $citas_del_dia = array();

        //Se recorren las citas obtenidas de la BD
        foreach($citas as $cita) {
            // Se compara cada fecha de la cita contra la fecha del día
            if($cita->getFecha() == Carbon::now()->format('Y-m-d')) {
                $cita->setUser();
                $cita->setInterview();
                $citas_del_dia[] = $cita; //Se guarda la cita dentro del array
            }
        }

        // Se crea un nuevo array con los datos que se necesitan en la vista
        $data = [
            'count' => count($citas_del_dia),
            'citas' => $citas_del_dia
        ];

        return $data;
    }

    /** Convierte la fecha obtenida en un formato para guardarlo en MYSQL */
    private function convertir_fecha_mysql($fecha) {
        return Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
    }

    /** Convierte la fecha obtenida en un formato para mostrarlo en un formulario */
    private function convertir_fecha_formulario($fecha) {
        return Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
    }

    /** Convierte la hora obtenida en formato de 12 horas, y lo convierte a 24 horas */
    private function convertir_hora_24($hora_12) {
        return date('H:i:s', strtotime($hora_12));
    }

    /** Convierte la hora obtenida en formato de 24 horas, y lo convierte a 12 horas */
    private function convertir_hora_12($hora_24) {
        return strftime('%I:%M %p', strtotime( $hora_24));
    }

    private function fecha_hora_mysql($fecha, $hora) {
        return $this->convertir_fecha_mysql($fecha).' '.$this->convertir_hora_24($hora);
    }

    private function validar_ruta_mal_encuestador($mal_encuestador) {
        $ruta = '';

        switch ($mal_encuestador) {
            case '0a':
                $ruta = 'supervisores.index';
                break;
            
            default:
                $ruta = 'home';
                break;
        }

        return $ruta;
    }

    private function validar_ruta_mala_entrevista($mala_entrevista) {
        $ruta = '';

        switch ($mala_entrevista) {
            case '0b':
                $ruta = 'asignar-encuestas.realizar-entrevista';
                break;
            
            default:
                $ruta = 'home';
                break;
        }

        return $ruta;
    }

    public function resumen_cita($id) {
        $cita = Cita::find($id);

        if(empty($cita)) {
            Flash::overlay('La cita que busca no se encuentra registrada', 'Error en la búsqueda')->error();
            return redirect(url('home'));
        }

        $encuestador = Usuario::find($cita->id_encuestador);

        $entrevista = null;

        if(!is_null($cita->id_entrevista)) {
            $entrevista = Entrevista::find($cita->id_entrevista);
        }

        $data = [
            'cita' => $cita,
            'encuestador' => $encuestador,
            'entrevista'=>$entrevista
        ];

        return view('calendario-de-citas.resumen-de-cita')->with('data', $data);
    }
}
