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

    public function scopePorCarrera($query) {
        $id_tipo = TiposDatosCarrera::carrera()->first();

        return $query->where('id_tipo', $id_tipo->id);
    }

    public function scopePorUniversidad($query) {
        $id_tipo = TiposDatosCarrera::universidad()->first();

        return $query->where('id_tipo', $id_tipo->id);
    }

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

    public function tipo() {
        return $this->hasOne(TiposDatosCarrera::class, 'id', 'id_tipo');
    }

    public function graduado() {
        return $this->hasMany(EncuestaGraduado::class, 'id');
    }
}
