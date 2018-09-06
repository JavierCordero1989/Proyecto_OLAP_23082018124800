<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EncuestaGraduado;
use DB;

class ContactoGraduado extends Model
{
    protected $table = 'tbl_contactos_graduados';

    protected $fillable = [
        'identificacion_referencia',
        'nombre_referencia',
        'informacion_contacto',
        'observacion_contacto',
        'id_graduado'
    ];

    public function scopeObtenerContactosGraduado($query, $id_graduado) {
        return $query->where('id_graduado', $id_graduado);
    }

    public function encuestas() {
        return $this->hasOne(EncuestaGraduado::class, 'id', 'id_graduado');
    }

    public function detalle() {
        $id_contacto = $this->id;

        $detalle_contactos = DB::table('tbl_detalle_contacto')->where('id_contacto_graduado', $this->id)->get();

        return $detalle_contactos;
    }
}
