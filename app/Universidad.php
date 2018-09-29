<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TiposDatosCarrera as Tipo;

class Universidad extends Model
{
    protected $table = 'tbl_datos_carrera_graduado';

    protected $fillable = [
        'codigo',
        'nombre',
        'id_tipo'
    ];

    public function scopeBuscarPorCodigo($query, $codigo) {
        $id_tipo = Tipo::select('id')->where('nombre', 'UNIVERSIDAD')->first();
        return $query->where('codigo', $codigo)->where('id_tipo', $id_tipo->id);
    }

    public function scopeBuscarPorNombre($query, $nombre) {
        $id_tipo = Tipo::select('id')->where('nombre', 'UNIVERSIDAD')->first();
        return $query->where('nombre', 'like', '%'.$nombre.'%')->where('id_tipo', $id_tipo->id);
    }

    public function scopeAllData($query) {
        $id_tipo = Tipo::select('id')->where('nombre', 'UNIVERSIDAD')->first();
        return $query->where('id_tipo', $id_tipo->id)->get();
    }

    public function scopeObtenerPublicas($query) {
        return $query->whereIn('nombre', [
                    'Universidad de Costa Rica',
                    'Universidad Nacional',
                    'Tecnológico de Costa Rica',
                    'Universidad Estatal a Distancia',
                    'Universidad Técnica Nacional'
                ])->where('id_tipo', 2);
    }

    public function scopeObtenerPrivadas($query) {
        return $query->whereNotIn('nombre', [
                    'Universidad de Costa Rica',
                    'Universidad Nacional',
                    'Tecnológico de Costa Rica',
                    'Universidad Estatal a Distancia',
                    'Universidad Técnica Nacional'
                ])->where('id_tipo', 2);
    }
}
