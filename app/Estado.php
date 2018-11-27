<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'tbl_estados_encuestas';

    protected $fillable = [
        'estado'
    ];

    public function encuestas() {
        return $this->hasMany(EncuestaGraduado::class, '');
    }
}
