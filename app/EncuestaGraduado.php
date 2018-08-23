<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TiposDatosCarrera;
use App\DatosCarreraGraduado;

class EncuestaGraduado extends Model
{
    protected $table = 'tbl_graduados';

    protected $fillable = [
        'identificacion_graduado',
        'token',
        'nombre_completo',
        'annio_graduacion',
        'link_encuesta',
        'sexo',
        'carrera',
        'universidad',
        'codigo_grado',
        'codigo_disciplina',
        'codigo_area',
        'tipo_de_caso'
    ];

    /** Este scope permite encontrar los graduados por nombre de grado. */
    public function scopeListaPorNombreGrado($query, $nombre_grado) {

        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera', 
                        'universidad', 
                        'dcg1.nombre as Grado', 
                        'dcg2.nombre as Disciplina', 
                        'dcg3.nombre as Area'
                    )
            ->join('tbl_datos_carrera_graduado as dcg1', 'dcg1.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as dcg2', 'dcg2.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as dcg3', 'dcg3.id', '=', 'tbl_graduados.codigo_area')
            ->where('dcg1.nombre', $nombre_grado);
    }

    /** Este scope permite encontrar todos los graduados por el codigo de grado. */
    public function scopeListaPorCodigoGrado($query, $codigo_grado) {

        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera', 
                        'universidad', 
                        'dcg1.nombre as Grado', 
                        'dcg2.nombre as Disciplina', 
                        'dcg3.nombre as Area'
                    )
            ->join('tbl_datos_carrera_graduado as dcg1', 'dcg1.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as dcg2', 'dcg2.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as dcg3', 'dcg3.id', '=', 'tbl_graduados.codigo_area')
            ->where('dcg1.codigo', $codigo_grado);
    }

    /** Este scope permite encontrar los graduados por nombre de disciplina. */
    public function scopeListaPorNombreDisciplina($query, $nombre_disciplina) {

        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera', 
                        'universidad', 
                        'dcg1.nombre as Grado', 
                        'dcg2.nombre as Disciplina', 
                        'dcg3.nombre as Area'
                    )
            ->join('tbl_datos_carrera_graduado as dcg1', 'dcg1.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as dcg2', 'dcg2.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as dcg3', 'dcg3.id', '=', 'tbl_graduados.codigo_area')
            ->where('dcg2.nombre', $nombre_disciplina);
    }

    /** Este scope permite encontrar todos los graduados por el codigo de disciplina. */
    public function scopeListaPorCodigoDisciplina($query, $codigo_disciplina) {

        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera', 
                        'universidad', 
                        'dcg1.nombre as Grado', 
                        'dcg2.nombre as Disciplina', 
                        'dcg3.nombre as Area'
                    )
            ->join('tbl_datos_carrera_graduado as dcg1', 'dcg1.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as dcg2', 'dcg2.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as dcg3', 'dcg3.id', '=', 'tbl_graduados.codigo_area')
            ->where('dcg2.codigo', $codigo_disciplina);
    }

    /** Este scope permite encontrar los graduados por nombre de area. */
    public function scopeListaPorNombreArea($query, $nombre_area) {

        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera', 
                        'universidad', 
                        'dcg1.nombre as Grado', 
                        'dcg2.nombre as Disciplina', 
                        'dcg3.nombre as Area'
                    )
            ->join('tbl_datos_carrera_graduado as dcg1', 'dcg1.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as dcg2', 'dcg2.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as dcg3', 'dcg3.id', '=', 'tbl_graduados.codigo_area')
            ->where('dcg3.nombre', $nombre_area);
    }

    /** Este scope permite encontrar todos los graduados por el codigo de area. */
    public function scopeListaPorCodigoArea($query, $codigo_area) {

        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera', 
                        'universidad', 
                        'dcg1.nombre as Grado', 
                        'dcg2.nombre as Disciplina', 
                        'dcg3.nombre as Area'
                    )
            ->join('tbl_datos_carrera_graduado as dcg1', 'dcg1.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as dcg2', 'dcg2.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as dcg3', 'dcg3.id', '=', 'tbl_graduados.codigo_area')
            ->where('dcg3.codigo', $codigo_area);
    }

    public function scopeListaPorIdentificacion($query, $identificacion) {
        return $query->where('identificacion_graduado', $identificacion);
    }

    public function scopeListaPorToken($query, $token) {
        return $query->where('token', $token);
    }

    public function scopeListaPorNombre($query, $nombre) {
        return $query->where('nombre_completo', $nombre)
        ->orWhere('nombre_completo', 'like', '%'.$nombre.'%');
    }

    public function scopeListaPorAnnioGraduacion($query, $annio) {
        return $query->where('annio_graduacion', $annio);
    }

    public function scopeListaPorSexo($query, $sexo) {
        return $query->where('sexo', $sexo);
    }

    public function scopeListaPorCarrera($query, $carrera) {
        return $query->where('carrera', $carrera);
    }

    public function scopeListaPorUniversidad($query, $universidad) {
        return $query->where('universidad', $universidad);
    }

    public function scopeListaPorTipoDeCaso($query, $tipo_de_caso) {
        return $query->where('tipo_de_caso', $tipo_de_caso);
    }

    public function scopeListaDeGraduados($query) {
        return $query
        ->select(
                    'identificacion_graduado', 
                    'token', 
                    'nombre_completo', 
                    'annio_graduacion', 
                    'link_encuesta', 
                    'sexo', 
                    'carrera', 
                    'universidad', 
                    'dcg1.codigo as Grado', 
                    'dcg2.codigo as Disciplina', 
                    'dcg3.codigo as Area'
                )
        ->join('tbl_datos_carrera_graduado as dcg1', 'dcg1.id', '=', 'tbl_graduados.codigo_grado')
        ->join('tbl_datos_carrera_graduado as dcg2', 'dcg2.id', '=', 'tbl_graduados.codigo_disciplina')
        ->join('tbl_datos_carrera_graduado as dcg3', 'dcg3.id', '=', 'tbl_graduados.codigo_area');
    }
}