<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TiposDatosCarrera;
use App\DatosCarreraGraduado;
use App\ContactoGraduado;
use App\ObservacionesGraduado;
use App\Disciplina;
use App\Area;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;

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
     * la tabla tbl_graduados, que no hayan sido eliminadas. 
     */
    public function scopeListaDeGraduados($query) {
        return $query->whereNull('deleted_at');
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
        $id_estado_sin_asignar = $id_estado_sin_asignar->id;

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
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->where('tbl_asignaciones.id_estado', $id_estado_sin_asignar)
            ->whereNull('tbl_graduados.deleted_at');
    }

    /** Obtiene los registros de las encuestas que han sido asignadas a un encuestador mediante
     * su código.
     */
    public function scopeListaEncuestasAsignadasEncuestador($query, $id_encuestador) {
        /* se garantioza que los estados ENTREVISTA COMPLETA, FALLECIDO y FUERA DEL PAÍS no aparezcan en las entrevistas
        del encuestador */
        $estado_completas = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'ENTREVISTA COMPLETA')->first();
        $estado_completas = $estado_completas->id;

        $estado_fallecido = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'FALLECIDO')->first();
        $estado_fallecido = $estado_fallecido->id;

        $estado_fuera_del_pais = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'FUERA DEL PAÍS')->first();
        $estado_fuera_del_pais = $estado_fuera_del_pais->id;

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
            ->whereNotIn('a.id_estado', [$estado_completas, $estado_fallecido, $estado_fuera_del_pais])
            // ->where('a.id_estado', '<>', $estado_completas)
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
        return $this->hasOne(Disciplina::class, 'id', 'codigo_disciplina');
        // return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_disciplina');
    }

    public function area() {
        // return $this->hasOne(DatosCarreraGraduado::class, 'id', 'codigo_area');
        return $this->hasOne(Area::class, 'id', 'codigo_area');
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

    public function encuestadorAsignado() {
        $asignacion = Asignacion::where('id_graduado', $this->id)->first();

        if(empty($asignacion)) {
            return 'SIN ASIGNAR';
            // return 'asignacion vacia';
        }

        if(is_null($asignacion->id_encuestador)) {
            return 'SIN ASIGNAR';
            // return 'id nulo';
        }

        $usuario = User::find($asignacion->id_encuestador);

        if(empty($usuario)){
            return 'SIN ASIGNAR';
            // return 'usuario vacio';
        }

        return $usuario->user_code;
    }

    public function supervisorAsignado() {
        $asignacion = Asignacion::where('id_graduado', $this->id)->first();

        if(empty($asignacion)) {
            return 'SIN ASIGNAR';
            // return 'asignacion vacia';
        }

        if(is_null($asignacion->id_supervisor)) {
            return 'SIN ASIGNAR';
            // return 'id nulo';
        }

        $usuario = User::find($asignacion->id_supervisor);

        if(empty($usuario)){
            return 'SIN ASIGNAR';
            // return 'usuario vacio';
        }

        return $usuario->user_code;
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

    /** Obtiene el total de las entrevistas asignadas a cada encuestador, por estado, es decir obtiene las encuestas
     * por encuestador, y saca el total de encuestas asignadas, las completas, etc.
     */
    public function scopeTotalEntrevistasPorEstadoPorEncuestador($query, $id_encuestador) {
        return $query->select('u.name as ENCUESTADOR', 'e.estado as ESTADO', DB::RAW('COUNT(*) as TOTAL'))
            ->leftJoin('tbl_asignaciones as a', 'a.id_graduado', '=', 'tbl_graduados.id')
            ->leftJoin('tbl_estados_encuestas as e', 'e.id', '=', 'a.id_estado')
            ->leftJoin('users as u', 'u.id', '=', 'a.id_encuestador')
            ->where('u.id', $id_encuestador)
            ->groupBy('u.name', 'e.estado');
    }

    /** El resultado de esta función se puede ver sin necesidad del método get() de las consultas.
     * Obtiene el total de encuestas almacenadas en la BD
     */
    public function scopeTotalDeEncuestas($query) {
        return $query->whereNull('deleted_at');
    }

    public function getRouteKeyName()
    {
        return $this->token;
    }

    public function changeCodesByNames() {
        $carrer_name = Carrera::buscarPorId($this->codigo_carrera)->first()->nombre;
        $university_name = Universidad::buscarPorId($this->codigo_universidad)->first()->nombre;
        $grade_name = Grado::buscarPorId($this->codigo_grado)->first()->nombre;
        $discipline_name = Disciplina::find($this->codigo_disciplina)->descriptivo;
        $area_name = Area::find($this->codigo_area)->descriptivo;
        $group_name = Agrupacion::buscarPorId($this->codigo_agrupacion)->first()->nombre;
        $sector_name = Sector::buscarPorId($this->codigo_sector)->first()->nombre;

        $this->codigo_carrera = $carrer_name;
        $this->codigo_universidad = $university_name;
        $this->codigo_grado = $grade_name;
        $this->codigo_disciplina = $discipline_name;
        $this->codigo_area = $area_name;
        $this->codigo_agrupacion = $group_name;
        $this->codigo_sector = $sector_name;
    }

    public function scopeContactsAndDetails($query) {
        return $query->select('*')
                     ->join('tbl_contactos_graduados as cg', 'cg.id_graduado', '=', 'tbl_graduados.id')
                     ->join('tbl_detalle_contacto as dc', 'dc.id_contacto_graduado', '=', 'cg.id');
    }

    /* --------------------------------- */
    /* ENTREVISTAS ASIGNADAS             */
    /* --------------------------------- */

    /** Este método obtiene la cuenta de todas las entrevistas que han sido asignadas,es decir, que
     * su estado es diferente de NO ASIGNADA. Se debe usar el método de Eloquent count() para obtener
     * el resultado.
    */
    public function scopeTotalEntrevistasAsignadas($query) {
        //id del estado NO ASIGNADA
        $id_no_asignada = DB::table('tbl_estados_encuestas')->where('estado', 'NO ASIGNADA')->first();
        $id_no_asignada = $id_no_asignada->id;

        //saca todas los id de los graduados, en donde es estado es diferente de NO ASIGNADA
        $estado_no_asignada = Asignacion::where('id_estado', '<>', $id_no_asignada)->pluck('id_graduado');

        // saca las entrevistas, en base a los ids sacados de la línea anterior.
        $entrevistasAsignadas = EncuestaGraduado::whereIn('id', $estado_no_asignada)
                                    ->whereNull('deleted_at');

        return $entrevistasAsignadas;
    }

    /** Este método obtiene la cuenta de todas las entrevistas que han sido completadas, es decir, las
     * que tienen como estado ENTREVISTA COMPLETA. Se debe usar el método de Eloquent count() para obtener
     * el resultado.
    */
    public function scopeTotalEntrevistasCompletas($query) {
        //id del estado ENTREVISTA COMPLETA
        $id_completa = DB::table('tbl_estados_encuestas')->where('estado', 'ENTREVISTA COMPLETA')->first();
        $id_completa = $id_completa->id;

        //saca los id de los graduados, en donde el estado es el de ENTREVISTA COMPLETA
        $estado_completa = Asignacion::where('id_estado', $id_completa)->pluck('id_graduado');

        //saca las entrevistas, en base a los id de las entrevistas completas
        $entrevistasCompletas = EncuestaGraduado::whereIn('id', $estado_completa)
                                    ->whereNull('deleted_at');

        return $entrevistasCompletas;
    }

    /* --------------------------------- */
    /* ENTREVISTAS POR ÁREA              */
    /* --------------------------------- */

    /** Con este método, se obtiene la cantidad de entrevistas ASIGNADAS por área. Se debe usar
     * el método count() de eloquent, para sacar el resultado.
     */
    public function scopeTotalAsignadasPorArea($query, $id_area) {
        //id del estado NO ASIGNADA
        $id_no_asignada = DB::table('tbl_estados_encuestas')->where('estado', 'NO ASIGNADA')->first();
        $id_no_asignada = $id_no_asignada->id;

        //saca todas los id de los graduados, en donde es estado es diferente de NO ASIGNADA
        $entrevistasAsignadas = Asignacion::where('id_estado', '<>', $id_no_asignada)->pluck('id_graduado');

        $entrevistasCount = $query->whereIn('id', $entrevistasAsignadas)
                                    ->where('codigo_area', $id_area)
                                    ->whereNull('deleted_at');

        return $entrevistasCount;
    }

    /** Con este método, se obtiene la cantidad de entrevistas COMPLETAS por área. Se debe usar
     * el método count() de eloquent, para sacar el resultado.
     */
    public function scopeTotalCompletasPorArea($query, $id_area) {
        //id del estado ENTREVISTA COMPLETA
        $id_completa = DB::table('tbl_estados_encuestas')->where('estado', 'ENTREVISTA COMPLETA')->first();
        $id_completa = $id_completa->id;

        //saca los id de los graduados, en donde el estado es el de ENTREVISTA COMPLETA
        $estado_completa = Asignacion::where('id_estado', $id_completa)->pluck('id_graduado');

        $completasPorArea = $query->whereIn('id', $estado_completa)
                                ->where('codigo_area', $id_area)
                                ->whereNull('deleted_at');

        return $completasPorArea;
    }

    /* --------------------------------- */
    /* ENTREVISTAS POR AGRUPACION        */
    /* --------------------------------- */

    /* Esta función va a permitir obtener todas las encuestas asignadas por cada agrupacion que se especifique,
    por el ID. Se debe utilizar el método count() de Eloquent para obtener el resultado. */
    public function scopeTotalAsignadasPorAgrupacion($query, $id_agrupacion) {
        //id del estado NO ASIGNADA
        $id_no_asignada = DB::table('tbl_estados_encuestas')->where('estado', 'NO ASIGNADA')->first();
        $id_no_asignada = $id_no_asignada->id;

        //saca todas los id de los graduados, en donde es estado es diferente de NO ASIGNADA
        $entrevistasAsignadas = Asignacion::where('id_estado', '<>', $id_no_asignada)->pluck('id_graduado');

        //saca todas las entrevistas asignadas por agrupación
        $entrevistasCount = $query->whereIn('id', $entrevistasAsignadas)
                                    ->where('codigo_agrupacion', $id_agrupacion)
                                    ->whereNull('deleted_at');

            return $entrevistasCount;
    }

    /* Esta función va a permitir obtener todas las entrevistas completas por cada agrupacion mediante el
    ID de la misma. Se debe utilizar el método count() de Eloquent para obtener el resultado. */
    public function scopeTotalCompletasPorAgrupacion($query, $id_agrupacion) {
        //id del estado ENTREVISTA COMPLETA
        $id_completa = DB::table('tbl_estados_encuestas')->where('estado', 'ENTREVISTA COMPLETA')->first();
        $id_completa = $id_completa->id;

        //saca los id de los graduados, en donde el estado es el de ENTREVISTA COMPLETA
        $estado_completa = Asignacion::where('id_estado', $id_completa)->pluck('id_graduado');

        //saca todas las entrevistas completas por agrupacion
        $completasPorAgrupacion = $query->whereIn('id', $estado_completa)
                                ->where('codigo_agrupacion', $id_agrupacion)
                                ->whereNull('deleted_at');

        return $completasPorAgrupacion;
    }

    public function scopeTotalDeEncuestasPorEstado($query, $id) {
        $estado_graduado = Asignacion::where('id_estado', $id)->whereNull('deleted_at')->pluck('id_graduado');

        $entrevistas = $query->whereIn('id', $estado_graduado)->whereNull('deleted_at');

        return $entrevistas;
    }

    public function otrasCarreras() {
        $otras = EncuestaGraduado::where('identificacion_graduado', $this->identificacion_graduado)->get();
        $otras_carreras = array();

        foreach($otras as $encuesta) {
            if($encuesta->id != $this->id) {
                $otras_carreras[] = $encuesta->id;
            }
        }

        if(sizeof($otras_carreras) > 0) {
            return $otras_carreras;
        }
        else {
            return null;
        }
    }

    public function scopeTotalPorAreaPorAgrupacion($query, $id_agrupacion, $id_area) {
        return $query
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->join('tbl_estados_encuestas','tbl_estados_encuestas.id','=','tbl_asignaciones.id_estado')
            ->where('codigo_agrupacion', $id_agrupacion)
            ->where('codigo_area', $id_area)
            ->whereNotIn('tbl_estados_encuestas.estado', ['FALLECIDO', 'FUERA DEL PAIS', 'ILOCALIZABLE']);
    }

    public function scopeTotalCompletasPorAreaPorAgrupacion($query, $id_agrupacion, $id_area){
        $estado = Estado::where('estado', 'ENTREVISTA COMPLETA')->first()->id;

        return $query
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->join('tbl_estados_encuestas','tbl_estados_encuestas.id','=','tbl_asignaciones.id_estado')
            ->where('codigo_agrupacion', $id_agrupacion)
            ->where('codigo_area', $id_area)
            ->whereNotIn('tbl_estados_encuestas.estado', ['FALLECIDO', 'FUERA DEL PAIS', 'ILOCALIZABLE'])
            ->where('tbl_asignaciones.id_estado', $estado);
    }
      
        
    public function scopeTotalPorAreaPorAgrupacionPorGrado($query, $id_agrupacion, $id_area, $grado) {
        return $query
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->join('tbl_estados_encuestas','tbl_estados_encuestas.id','=','tbl_asignaciones.id_estado')
            ->where('codigo_agrupacion', $id_agrupacion)
            ->where('codigo_area', $id_area)
            ->whereNotIn('tbl_estados_encuestas.estado', ['FALLECIDO', 'FUERA DEL PAIS', 'ILOCALIZABLE'])
            ->where('codigo_grado', Grado::buscarPorNombre($grado)->first()->id);
    }

    public function scopeTotalCompletasPorAreaPorAgrupacionPorGrado($query, $id_agrupacion, $id_area, $grado) {
        $estado = Estado::where('estado', 'ENTREVISTA COMPLETA')->first()->id;

        return $query
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->join('tbl_estados_encuestas','tbl_estados_encuestas.id','=','tbl_asignaciones.id_estado')
            ->where('codigo_agrupacion', $id_agrupacion)
            ->where('codigo_area', $id_area)
            ->whereNotIn('tbl_estados_encuestas.estado', ['FALLECIDO', 'FUERA DEL PAIS', 'ILOCALIZABLE'])
            ->where('codigo_grado', Grado::buscarPorNombre($grado)->first()->id)
            ->where('tbl_asignaciones.id_estado', $estado);
    }

    public function scopeTotalPorDisciplinaPorAgrupacion($query, $id_agrupacion, $id_disciplina) {
        return $query
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->join('tbl_estados_encuestas','tbl_estados_encuestas.id','=','tbl_asignaciones.id_estado')
            ->where('codigo_agrupacion', $id_agrupacion)
            ->where('codigo_disciplina', $id_disciplina)
            ->whereNotIn('tbl_estados_encuestas.estado', ['FALLECIDO', 'FUERA DEL PAIS', 'ILOCALIZABLE']);
    }

    public function scopeTotalPorDisciplinaPorAgrupacionPorGrado($query, $id_agrupacion, $id_disciplina, $grado) {
        return $query
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->join('tbl_estados_encuestas','tbl_estados_encuestas.id','=','tbl_asignaciones.id_estado')
            ->where('codigo_agrupacion', $id_agrupacion)
            ->where('codigo_disciplina', $id_disciplina)
            ->whereNotIn('tbl_estados_encuestas.estado', ['FALLECIDO', 'FUERA DEL PAIS', 'ILOCALIZABLE'])
            ->where('codigo_grado', Grado::buscarPorNombre($grado)->first()->id);
    }

    public function scopeTotalCompletasPorDisciplinaPorAgrupacionPorGrado($query, $id_agrupacion, $id_disciplina, $grado) {
        $estado = Estado::where('estado', 'ENTREVISTA COMPLETA')->first()->id;

        return $query
            ->join('tbl_asignaciones', 'tbl_asignaciones.id_graduado', '=', 'tbl_graduados.id')
            ->join('tbl_estados_encuestas','tbl_estados_encuestas.id','=','tbl_asignaciones.id_estado')
            ->where('codigo_agrupacion', $id_agrupacion)
            ->where('codigo_disciplina', $id_disciplina)
            ->whereNotIn('tbl_estados_encuestas.estado', ['FALLECIDO', 'FUERA DEL PAIS', 'ILOCALIZABLE'])
            ->where('codigo_grado', Grado::buscarPorNombre($grado)->first()->id)
            ->where('tbl_asignaciones.id_estado', $estado);
    }
}