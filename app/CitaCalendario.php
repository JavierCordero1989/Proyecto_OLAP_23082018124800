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
}
