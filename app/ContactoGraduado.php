<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EncuestaGraduado;

class ContactoGraduado extends Model
{
    protected $table = 'tbl_contactos_graduados';

    protected $fillable = [
        'identificacion_referencia',
        'nombre_referencia',
        'informacion_contacto',
        'observacion_contacto',
        'id_graduado'
    ];

    public function scopeObtenerContactosGraduado($query, $id_graduado) {
        return $query->where('id_graduado', $id_graduado);
    }

    public function encuestas() {
        return $this->hasOne(EncuestaGraduado::class, 'id', 'id_graduado');
    }
}
