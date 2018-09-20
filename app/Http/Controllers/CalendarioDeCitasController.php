<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EncuestaGraduado as Entrevista;
use App\User as Usuario;
use Flash;
use Carbon\Carbon;

class CalendarioDeCitasController extends Controller
{
    private $vista_agendar_cita;

    public function __construct() {
        $this->vista_agendar_cita = 'calendario-de-citas.agendar-cita-entrevista';
    }

    public function agendar_cita_a_entrevista($encuestador, $mal_encuestador, $entrevista, $mal_entrevista) {

        /* Busca la entrevista en la base de datos */
        $entrevista_cita = Entrevista::find($entrevista);

        /* Si la entrevista encontrada es un objeto vacio devuelve un error*/
        if(empty($entrevista_cita)) {
            Flash::error('La entrevista que busca no existe');
            return redirect(route($this->validar_ruta_mala_entrevista($mal_entrevista), $entrevista));
        }

        /* Busca el usuario que hizo la solicitud en la base de datos */
        $usuario = Usuario::find($encuestador);

        /* Si el usuario encontrdo es un objeto vacio devuelve un error */
        if(empty($usuario)) {
            Flash::error('El usuario que hizo la solicitud no existe');
            return redirect(route($this->validar_ruta_mal_encuestador($mal_encuestador)));
        }

        /* Datos esenciales para las rutas */
        $datos_a_vista = [
            'entrevista' => $entrevista,
            'encuestador' => $encuestador
        ];

        /* Rutas a usar para las vistas */
        $rutas = [
            'store' => 'calendario.guardar-cita',
            'back' => $this->validar_ruta_mala_entrevista($mal_entrevista)
        ];

        return view($this->vista_agendar_cita, compact('datos_a_vista', 'rutas'));
    }

    public function guardar_cita_de_entrevista($entrevista, Request $request) {
        // $entrevista_cita = Entrevista::find($entrevista);

        // if(empty($entrevista_cita)) {
        //     Flash::error();
        //     return redirect(route('asignar-encuestas.realizar-entrevista', $entrevista));
        // }

        /* Convierte la fecha obtenida en un formato valido para mysql */
        $hora = $this->convertir_hora_24($request->hora_de_cita);

        $datos = [
            'ID de encuesta' => $entrevista,
            'fecha_sin_convetir' => $request->fecha_de_cita, 
            'fecha_convertida' => $this->convertir_fecha_mysql($request->fecha_de_cita),
            'hora_12' => $request->hora_de_cita,
            'hora_24' => $hora,
            'hora_12_conversion' => $this->convertir_hora_12($hora),
            'fecha_mysql' => $this->fecha_hora_mysql($request->fecha_de_cita, $request->hora_de_cita),
            'fecha_hora' => explode(' ', $this->fecha_hora_mysql($request->fecha_de_cita, $request->hora_de_cita)),
            'datos_request' => $request->all()
        ];

        $datos_fecha = [
            'fecha' => $datos['fecha_hora'][0], 
            'hora' => $datos['fecha_hora'][1],
            'fecha_form' => $this->convertir_fecha_formulario($datos['fecha_hora'][0]),
            'hora_form' => $this->convertir_hora_12($datos['fecha_hora'][1])
        ];

        dd($datos, $datos_fecha);
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
