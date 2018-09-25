<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Area;

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
}
