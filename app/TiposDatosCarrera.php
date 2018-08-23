<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiposDatosCarrera extends Model
{
    protected $table = 'tbl_tipos_datos_carrera';

    protected $fillable = [
        'nombre'
    ];

    public function scopeGrado($query) {
        return $query->where('nombre', 'Grado');
    }

    public function scopeDisciplina($query) {
        return $query->where('nombre', 'Disciplina');
    }

    public function scopeArea($query) {
        return $query->where('nombre', 'Area');
    }
}
