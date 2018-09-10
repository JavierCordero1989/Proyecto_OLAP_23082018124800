<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleContacto extends Model
{
    protected $table = 'tbl_detalle_contacto';

    protected $fillable = [
        'contacto',
        'observacion',
        'id_contacto_graduado'
    ];
}
