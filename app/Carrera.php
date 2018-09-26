<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TiposDatosCarrera as Tipo;

class Carrera extends Model
{
    protected $table = 'tbl_datos_carrera_graduado';

    protected $fillable = [
        'codigo',
        'nombre',
        'id_tipo'
    ];

    public function scopeBuscarPorCodigo($query, $codigo) {
        $id_tipo = Tipo::select('id')->where('nombre', 'CARRERA')->first();
        return $query->where('codigo', $codigo)->where('id_tipo', $id_tipo->id);
    }

    public function scopeBuscarPorNombre($query, $nombre) {
        $id_tipo = Tipo::select('id')->where('nombre', 'CARRERA')->first();
        return $query->where('nombre', 'like', '%'.$nombre.'%')->where('id_tipo', $id_tipo->id);
    }

    public function scopeAllData($query) {
        $id_tipo = Tipo::select('id')->where('nombre', 'CARRERA')->first();
        return $query->where('id_tipo', $id_tipo->id)->get();
    }
}
