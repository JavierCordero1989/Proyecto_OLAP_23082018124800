<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CitaCalendario extends Model
{
    protected $table = 'tbl_calendario_de_citas';

    protected $fillable = [
        'fecha_hora',
        'numero_contacto',
        'observacion',
        'id_encuestador',
        'id_entrevista'
    ];

    public function getFecha() {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->fecha_hora)->format('Y-m-d');
    }

    /** 
     * Este scope permite filtrar la lista de citas hechas por un encuestador, para que se puedan mostrar
     * en el calendario de la aplicación.
     * @param $id_encuestador ID del encuestador que hizo la solicitud
     * @return $listaDeCitas Lista con las citas hechas por el encuestador
     */
    public function scopeCitasDeEncuestador($query, $id_encuestador) {
        return $query->where('id_encuestador', $id_encuestador);
    }
}
