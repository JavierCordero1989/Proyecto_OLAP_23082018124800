<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Area;
use App\EncuestaGraduado;

class Disciplina extends Model
{
    protected $table = 'tbl_disciplinas';

    protected $fillable = [
        'codigo',
        'descriptivo',
        'id_area'
    ];

    public function area() {
        return $this->hasOne(Area::class, 'id', 'id_area');
    }

    /** Query para buscar una disciplina por código */
    public function scopeBuscarPorCodigo($query, $codigo) {
        return $query->where('codigo', $codigo);
    }

    /** Query para buscar una disciplina por descriptivo */
    public function scopeBuscarPorDescriptivo($query, $descriptivo) {
        return $query->where('descriptivo', 'like', '%'.$descriptivo.'%');
    }

    public function entrevistas() {
        return $this->hasMany(EncuestaGraduado::class, 'codigo_disciplina');
    }
}
