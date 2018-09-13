<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiposDatosCarrera extends Model
{
    protected $table = 'tbl_tipos_datos_carrera';

    protected $fillable = [
        'nombre'
    ];

    public function scopeCarrera($query) {
        return $query->where('nombre', 'CARRERA');
    }

    public function scopeUniversidad($query) {
        return $query->where('nombre', 'UNIVERSIDAD');
    }

    public function scopeGrado($query) {
        return $query->where('nombre', 'GRADO');
    }

    public function scopeDisciplina($query) {
        return $query->where('nombre', 'DISCIPLINA');
    }

    public function scopeArea($query) {
        return $query->where('nombre', 'AREA');
    }

    public function scopeAgrupacion($query) {
        return $query->where('nombre', 'AGRUPACION');
    }

    public function scopeSector($query) {
        return $query->where('nombre', 'SECTOR');
    }

    public function datoCarrera() {
        return $this->hasMany(DatosCarreraGraduado::class, 'id_tipo');
    }
}
