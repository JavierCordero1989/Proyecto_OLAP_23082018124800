<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EncuestaGraduado as Entrevista;
use Flash;
use Carbon\Carbon;

class CalendarioDeCitasController extends Controller
{
    private $vista_agendar_cita;

    public function __construct() {
        $this->vista_agendar_cita = 'calendario-de-citas.agendar-cita-entrevista';
    }

    public function agendar_cita_a_entrevista($entrevista) {
        // $entrevista_cita = Entrevista::find($entrevista);

        // if(empty($entrevista_cita)) {
        //     Flash::error();
        //     return redirect(route('asignar-encuestas.realizar-entrevista', $entrevista));
        // }

        return view($this->vista_agendar_cita, compact('entrevista'));
    }

    public function guardar_cita_de_entrevista($entrevista, Request $request) {
        // $entrevista_cita = Entrevista::find($entrevista);

        // if(empty($entrevista_cita)) {
        //     Flash::error();
        //     return redirect(route('asignar-encuestas.realizar-entrevista', $entrevista));
        // }
        /* Convierte la fecha obtenida en un formato valido para mysql */
        $fecha = Carbon::createFromFormat('d/m/Y', $request->fecha_de_cita)->format('Y-m-d');

        dd($entrevista, $request->all(), $fecha, $request->hora_de_cita);
    }
}
