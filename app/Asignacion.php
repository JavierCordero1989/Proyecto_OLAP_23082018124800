<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EncuestaGraduado;

class Asignacion extends Model
{
    protected $table = 'tbl_asignaciones';

    protected $fillable = [
        'id_graduado',
        'id_encuestador',
        'id_supervisor',
        'id_estado'
    ];

    public function encuestadores() {
        return $this->hasOne(User::class, 'id', 'id_encuestador');
    }

    public function supervisores() {
        return $this->hasOne(User::class, 'id', 'id_supervisor');
    }

    public function entrevista() {
        return $this->hasOne(EncuestaGraduado::class, 'id');
    }
}
