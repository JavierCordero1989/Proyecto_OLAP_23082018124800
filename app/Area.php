<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Disciplina;

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
}
