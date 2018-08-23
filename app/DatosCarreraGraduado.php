<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TiposDatosCarrera;

class DatosCarreraGraduado extends Model
{
    protected $table = 'tbl_datos_carrera_graduado';

    protected $fillable = [
        'codigo',
        'nombre',
        'id_tipo'
    ];

    public function scopePorGrado($query) {
        $id_tipo = TiposDatosCarrera::grado()->first();

        return $query->where('id_tipo', $id_tipo->id);
    }

    public function scopePorDisciplina($query) {
        $id_tipo = TiposDatosCarrera::disciplina()->first();

        return $query->where('id_tipo', $id_tipo->id);
    }

    public function scopePorArea($query) {
        $id_tipo = TiposDatosCarrera::area()->first();

        return $query->where('id_tipo', $id_tipo->id);
    }
}
