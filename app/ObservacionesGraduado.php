<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EncuestaGraduado;
use App\User;

class ObservacionesGraduado extends Model
{
    protected $table = 'tbl_observaciones_graduado';

    protected $fillable = [
        'id_graduado',
        'id_usuario',
        'observacion'
    ];

    public function encuestas() {
        return $this->hasOne(EncuestaGraduado::class, 'id', 'id_graduado');
    }

    public function usuarios() {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
