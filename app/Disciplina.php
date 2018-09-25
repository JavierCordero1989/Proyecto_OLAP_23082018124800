<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $table = 'tbl_disciplinas';

    protected $fillable = [
        'codigo',
        'descriptivo',
        'id_area'
    ];
}
