<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'tbl_usuarios';

    protected $fillable = [
        'nombre_completo',
        'correo_electronico',
        'contrasennia'
    ];

    protected $hidden = [
        'contrasennia'
    ];
}
