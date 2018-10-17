<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EncuestaGraduado as Entrevista;
use App\User as Usuario;
use Flash;
use Carbon\Carbon;
use App\CitaCalendario as Cita;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class CalendarioDeCitasController extends Controller
{
    private $vista_agendar_cita;

    public function __construct() {
        $this->vista_agendar_cita = 'calendario-de-citas.agendar-cita-entrevista';
    }

    public function ver_calendario($id_usuario) {

        $user = Usuario::find($id_usuario);

        if(empty($user)) {
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

        return view('calendario-de-citas.calendario', compact('citas'));
    }

    public function agendar_cita_a_entrevista($encuestador, $mal_encuestador, $entrevista, $mal_entrevista) {

        /* Busca la entrevista en la base de datos */
        $entrevista_cita = Entrevista::find($entrevista);

        /* Si la entrevista encontrada es un objeto vacio devuelve un error*/
        if(empty($entrevista_cita)) {
            Flash::error('La entrevista que busca no existe');
            // return redirect(route($this->validar_ruta_mala_entrevista($mal_entrevista), $entrevista));
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

        /* Datos esenciales para las rutas */
        $datos_a_vista = [
            'entrevista' => $entrevista,
            'encuestador' => $encuestador
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
        // $entrevista_cita = Entrevista::find($entrevista);

        // if(empty($entrevista_cita)) {
        //     Flash::error();
        //     return redirect(route('asignar-encuestas.realizar-entrevista', $entrevista));
        // }

        /* Convierte la fecha obtenida en un formato valido para mysql */
        // $hora = $this->convertir_hora_24($request->hora_de_cita);

        // $datos = [
        //     'ID de encuesta' => $entrevista,
        //     'fecha_sin_convetir' => $request->fecha_de_cita, 
        //     'fecha_convertida' => $this->convertir_fecha_mysql($request->fecha_de_cita),
        //     'hora_12' => $request->hora_de_cita,
        //     'hora_24' => $hora,
        //     'hora_12_conversion' => $this->convertir_hora_12($hora),
        //     'fecha_mysql' => $this->fecha_hora_mysql($request->fecha_de_cita, $request->hora_de_cita),
        //     'fecha_hora' => explode(' ', $this->fecha_hora_mysql($request->fecha_de_cita, $request->hora_de_cita)),
        //     'datos_request' => $request->all()
        // ];

        // $datos_fecha = [
        //     'fecha' => $datos['fecha_hora'][0], 
        //     'hora' => $datos['fecha_hora'][1],
        //     'fecha_form' => $this->convertir_fecha_formulario($datos['fecha_hora'][0]),
        //     'hora_form' => $this->convertir_hora_12($datos['fecha_hora'][1])
        // ];

        // dd($datos, $datos_fecha);

        $cita = Cita::create([
            'fecha_hora' => $this->fecha_hora_mysql($request->fecha_de_cita, $request->hora_de_cita),
            'numero_contacto' => $request->numero_contacto,
            'observacion' => $request->observacion_de_cita,
            'id_encuestador' => $encuestador,
            'id_entrevista' => $entrevista,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Flash::success('La cita ha sido guardada con éxito.');
        return redirect(route('ver-calendario', $encuestador));
    }

    /** Este método permite obtener mediante AJAX las citas del día, para que aparezcan las mismas
     * en la vista principal. Cada vez que la aplicación se refresque, se llama a este método.
     * @param Request $request Datos enviados por la petición AJAX
     * @return response Una respuesta con datos en formato JSON.
     */
    public function obtener_citas_calendario(Request $request) {
        if($request->ajax()) {
            $citas = Cita::all(); //Se obtienen todas las citas de la BD
            $citas_del_dia = []; //Arreglo con las citas que se filtrarán por fecha

            //Se recorren las citas obtenidas de la BD
            foreach($citas as $cita) {
                // Se compara cada fecha de la cita contra la fecha del día
                if($cita->getFecha() == Carbon::now()->format('Y-m-d')) {
                    $citas_del_dia[] = $cita; //Se guarda la fecha dentro del array
                }
            }

            // Se crea un nuevo array con los datos que se necesitan en la vista
            $data = [
                'count' => count($citas_del_dia),
                'citas' => $citas_del_dia
            ];

            //Se regresa la respuesta a la petición AJAX
            return response()->json($data);
        }
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
}
