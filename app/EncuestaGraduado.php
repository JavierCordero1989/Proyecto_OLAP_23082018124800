<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TiposDatosCarrera;
use App\DatosCarreraGraduado;
use App\ContactoGraduado;
use App\ObservacionesGraduado;
use Carbon\Carbon;
use DB;

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
        'codigo_carrera',
        'codigo_universidad',
        'codigo_grado',
        'codigo_disciplina',
        'codigo_area',
        'codigo_agrupacion',
        'codigo_sector',
        'tipo_de_caso'
    ];

    /*  __________________________________________________________________________
     *  Las siguientes funciones obtienen la lista de las encuestas, filtradas por 
     *  grados, disciplinas y áreas, según el nombre o el código de cada una.
     *  _________________________________________________________________________
     */

    /** Este scope permite encontrar los graduados por nombre de carrera. */
    public function scopeListaPorNombreCarrera($query, $nombre_carrera) {
        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('carrera.nombre', $nombre_carrera);
    }

    /** Este scope permite encontrar todos los graduados por el codigo de carrera. */
    public function scopeListaPorCodigoCarrera($query, $codigo_carrera) {
        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('carrera.codigo', $codigo_carrera);
    }

    /** Este scope permite encontrar los graduados por nombre de universidad. */
    public function scopeListaPorNombreUniversidad($query, $nombre_universidad) {
        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('universidad.nombre', $nombre_universidad);
    }

    /** Este scope permite encontrar todos los graduados por el codigo de universidad. */
    public function scopeListaPorCodigoUniversidad($query, $codigo_universidad) {
        return $query
            ->select(
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('universidad.codigo', $codigo_universidad);
    }

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
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('grado.nombre', $nombre_grado);
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
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('grado.codigo', $codigo_grado);
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
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('disciplina.nombre', $nombre_disciplina);
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
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('disciplina.codigo', $codigo_disciplina);
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
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('area.nombre', $nombre_area);
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
                        'carrera.nombre as Carrera', 
                        'universidad.nombre as Universidad', 
                        'grado.nombre as Grado', 
                        'disciplina.nombre as Disciplina', 
                        'area.nombre as Area',
                        'tipo_de_caso'
                    )
            ->join('tbl_datos_carrera_graduado as carrera', 'carrera.id', '=', 'tbl_graduados.codigo_carrera')
            ->join('tbl_datos_carrera_graduado as universidad', 'universidad.id', '=', 'tbl_graduados.codigo_universidad')
            ->join('tbl_datos_carrera_graduado as grado', 'grado.id', '=', 'tbl_graduados.codigo_grado')
            ->join('tbl_datos_carrera_graduado as disciplina', 'disciplina.id', '=', 'tbl_graduados.codigo_disciplina')
            ->join('tbl_datos_carrera_graduado as area', 'area.id', '=', 'tbl_graduados.codigo_area')
            ->where('area.codigo', $codigo_area);
    }
    /* _________________________________________________________________________________________
     * Finaliza la declaración de las funciones para obtener los datos por carrera, universidad,
     * grado, disciplina y área.
     * _________________________________________________________________________________________
     */

    /*
     * __________________________________________________________________________
     * Las siguientes funciones filtran las encuestas por diferentes atributos,
     * por cédula, token, nombre, año de graduación, sexo y tipo del caso
     * __________________________________________________________________________
     */
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

    public function scopeListaPorTipoDeCaso($query, $tipo_de_caso) {
        return $query->where('tipo_de_caso', $tipo_de_caso);
    }
    /* _______________________________________________________________________________________________
     * Finaliza la lista de filtros por cédula, token, nombre, año de graduación, sexo y tipo del caso
     * _______________________________________________________________________________________________
     */


    /** Este query permite obtener la lista de todas las encuestas de la base de datos de 
     * la tabla tbl_graduados. 
     */
    public function scopeListaDeGraduados($query) {
        return $query
        ->select(
                    'tbl_graduados.id',
                    'identificacion_graduado', 
                    'token', 
                    'nombre_completo', 
                    'annio_graduacion', 
                    'link_encuesta', 
                    'sexo', 
                    'codigo_carrera', 
                    'codigo_universidad', 
                    'codigo_grado', 
                    'codigo_disciplina', 
                    'codigo_area',
                    'codigo_agrupacion',
                    'codigo_sector',
                    'tipo_de_caso',
                    'created_at',
                    'updated_at'
        );
    }

    /** Coloca la encuesta seleccionada en un estado de no asignada */
    public function asignarEstado($id_estado) {
        return DB::table('tbl_asignaciones')->insert([
            'id_graduado' => $this->id,
            'id_estado' => $id_estado,
            'created_at' => \Carbon\Carbon::now()
        ]);
    }

    /** Este método permite asignar una encuesta a un encuestador, registrando así los datos
     * del encuestador y del supervisor que hizo la asignación.
     */
    public function asignarEncuesta($id_supervisor, $id_encuestador, $id_no_asignada, $id_asignada) {
        $result = DB::table('tbl_asignaciones')
            ->where('id_graduado', $this->id)
            ->where('id_estado', $id_no_asignada)
            ->update([
                'id_encuestador'=>$id_encuestador, 
                'id_supervisor'=>$id_supervisor,
                'id_estado'=>$id_asignada,
                'updated_at'=>\Carbon\Carbon::now()
                ]);

        return true;
    }

    /** Mostrara la lista de encuestas que no han sido asignadas */
    public function scopeListaDeEncuestasSinAsignar($query) {
        $id_estado_sin_asignar = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        return $query
            ->select(
                        'tbl_graduados.id',
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'codigo_carrera', 
                        'codigo_universidad', 
                        'codigo_grado', 
                        'codigo_disciplina', 
                        'codigo_area',
                        'codigo_agrupacion',
                        'codigo_sector',
                        'tipo_de_caso'
                    )
            ->join('tbl_asignaciones as a', 'a.id_graduado', '=', 'tbl_graduados.id')
            ->where('a.id_estado', $id_estado_sin_asignar->id);
    }

    /** Obtiene los registros de las encuestas que han sido asignadas a un encuestador mediante
     * su código.
     */
    public function scopeListaEncuestasAsignadasEncuestador($query, $id_encuestador) {
        $id_estado_asignado = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'ENTREVISTA COMPLETA')->first();

                return $query
            ->select(
                        'tbl_graduados.id',
                        'identificacion_graduado', 
                        'token', 
                        'nombre_completo', 
                        'annio_graduacion', 
                        'link_encuesta', 
                        'sexo', 
                        'codigo_carrera', 
                        'codigo_universidad', 
                        'codigo_grado', 
                        'codigo_disciplina', 
                        'codigo_area',
                        'codigo_agrupacion',
                        'codigo_sector', 
                        'tipo_de_caso',
                        'tbl_graduados.created_at',
                        'tbl_graduados.updated_at'
                    )
            ->join('tbl_asignaciones as a', 'a.id_graduado', '=', 'tbl_graduados.id')
            ->where('a.id_estado', '<>', $id_estado_asignado->id)
            ->where('a.id_encuestador', '=', $id_encuestador);
    }

    public function listaDeContactos() {
        return ContactoGraduado::obtenerContactosGraduado($this->id)->get();
    }

    public function contactos() {
        return $this->hasMany(ContactoGraduado::class, 'id_graduado');
    }   

    public function observaciones() {
        return $this->hasMany(ObservacionesGraduado::class, 'id_graduado');
    }

    public function carrera() {
        return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_carrera');
    }

    public function universidad() {
        return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_universidad');
    }

    public function grado() {
        return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_grado');
    }

    public function disciplina() {
        return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_disciplina');
    }

    public function area() {
        return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_area');
    }

    public function agrupacion() {
        return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_agrupacion');
    }

    public function sector() {
        return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_sector');
    }

    public function estado() {
        $estado_encuesta = DB::table('tbl_estados_encuestas as ee')->select('ee.id','ee.estado')->join('tbl_asignaciones as a', 'a.id_estado', '=', 'ee.id')->where('a.id_graduado', $this->id)->first();

        return $estado_encuesta;
    }

    public function desasignarEntrevista() {
        $id_no_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        $asignacion = Asignacion::where('id_graduado', $this->id)->first();
        $asignacion->id_encuestador = null;
        $asignacion->id_supervisor = null;
        $asignacion->id_estado = $id_no_asignada->id;
        $asignacion->updated_at = Carbon::now();

        return $asignacion->save();
    }

    public function cambiarEstadoDeEncuesta($id_estado_nuevo) {
        $asignacion = Asignacion::where('id_graduado', $this->id)->first();
        $asignacion->id_estado = $id_estado_nuevo;
        $asignacion->updated_at = Carbon::now();
        
        return $asignacion->save();
    }

    /** Obtiene el total de encuestas, por cada estado */
    public function scopeTotalesPorEstado($query){
        return $query->select('e.estado', DB::RAW('COUNT(*) as total'))
            ->leftJoin('tbl_asignaciones as a', 'a.id_graduado', '=', 'tbl_graduados.id')
            ->leftJoin('tbl_estados_encuestas as e', 'e.id', '=', 'a.id_estado')
            ->groupBy('e.estado');
    }

    /** Obtiene el total de encuestas por cada uno de los códigos que se le indiquen por el parámetro $filtro
     * Dichos parámetros pueden ser codigo_carrera, codigo_universidad, etc.
     */
    public function scopeTotalDeEntrevistasPor($query, $filtro){
        return $query->select('d.nombre', DB::RAW('COUNT(*) as total'))
            ->join('tbl_datos_carrera_graduado as d', 'd.id', '=', 'tbl_graduados.'.$filtro)
            ->join('tbl_tipos_datos_carrera as t', 't.id', '=', 'd.id_tipo')
            ->groupBy('d.nombre');
    }

    /** Obtiene el total de entrevistas por estado, es decir, por ejemplo, por cada carrera obtiene cuantas
     * encuestas han sido asignadas, cuantas incompletas, etc. Así mismo se puede filtrar por universidad, por grado, 
     * por disciplina, por agrupación o sector.
     */
    public function scopeTotalPorEstadoPor($query, $filtro){
        return $query->select('d.nombre', 'e.estado', DB::RAW('COUNT(*) AS Total'))
            ->leftJoin('tbl_asignaciones as a', 'a.id_graduado', '=', 'tbl_graduados.id')
            ->leftJoin('tbl_estados_encuestas as e', 'e.id', '=', 'a.id_estado')
            ->join('tbl_datos_carrera_graduado as d', 'd.id', '=', 'tbl_graduados.'.$filtro)
            ->groupBy('tbl_graduados.'.$filtro, 'e.estado');
    }

    /** El resultado de esta función se puede ver sin necesidad del método get() de las consultas.
     * Obtiene el total de encuestas almacenadas en la BD
     */
    public function scopeTotalDeEncuestas($query) {
        return $query->count('*');
    }

    
    // public function scope($query){
    //     return $query;
    // }
}