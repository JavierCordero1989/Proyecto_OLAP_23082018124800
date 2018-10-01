<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Disciplina;
use App\EncuestaGraduado;

class Area extends Model
{
    protected $table = 'tbl_areas';

    protected $fillable = [
        'codigo',
        'descriptivo'
    ];

    public function disciplinas() {
        return $this->hasMany(Disciplina::class, 'id_area');
    }

    /** Query para buscar un área por código */
    public function scopeBuscarPorCodigo($query, $codigo) {
        return $query->where('codigo', $codigo);
    }

    /** Query para buscar un área por descriptivo */
    public function scopeBuscarPorDescriptivo($query, $descriptivo) {
        return $query->where('descriptivo', 'like', '%'.$descriptivo.'%');
    }

    public function entrevistas() {
        return $this->hasMany(EncuestaGraduado::class, 'codigo_area');
    }
}
