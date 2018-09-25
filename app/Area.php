<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'tbl_areas';

    protected $fillable = [
        'codigo',
        'descriptivo'
    ];
}
