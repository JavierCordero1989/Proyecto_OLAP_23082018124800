<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleContacto extends Model
{
    protected $table = 'tbl_detalle_contacto';

    protected $fillable = [
        'contacto',
        'observacion',
        // F => Funcional, E => Eliminado
        'estado',
        'id_contacto_graduado'
    ];

    public function scopeBuscarContacto($query, $contacto) {
        return $query->where('contacto', $contacto);
    }

    public function contacto_graduado() {
        return $this->hasOne(ContactoGraduado::class, 'id', 'id_contacto_graduado');
    }
}
