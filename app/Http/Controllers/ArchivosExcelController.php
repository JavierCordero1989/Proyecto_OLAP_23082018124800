<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\EncuestaGraduado;
use App\ContactoGraduado;
use App\DetalleContacto;
use App\Universidad;
use App\Disciplina;
use App\Agrupacion;
use Carbon\Carbon;
use App\Carrera;
use App\Sector;
use App\Grado;
use App\Area;
use Flash;
use DB;
/*
 * Impide que el servidor genere un error debido al tiempo
 * de espera seteado de 60 segundos.
*/ 
set_time_limit(300);

class ArchivosExcelController extends Controller
{
    private $reporte = array();
    private $registros_totales = 0;
    private $cedula_graduado = '';

    public function subir_archivo_de_contactos(Request $request) {
        if($request->hasFile('archivo_contactos')) {
            $archivo = $request->file('archivo_contactos');

            Excel::load($archivo, function ($reader) {
                foreach ($reader->get() as $key => $row) {

                    echo 'registro' . $key . '<br>';

                    /* se obtiene la cedula de la columna */
                    $identificacion = $row['identificacion'];
                    $this->cedula_graduado = $row['identificacion'];
                    $ids_graduados = $this->buscar_graduado($identificacion);

                    /* si no se encuentra un registro con la cedula obtenida, se salta el registro de informacion. */
                    if(sizeof($ids_graduados) <= 0) {
                        $this->reporte['graduados_no_encontrados'][] = 'El graduado con cédula '.$identificacion.' no ha sido encontrado en los registros.';
                        continue;
                    }

                    /* suma uno a los registros para un conteo. */
                    $this->registros_totales++;

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS RESIDENCIALES ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['residencial_1'])){
                        $contactos[] = $row['residencial_1'];
                    }

                    if($this->verificar_contacto($ids_graduados, $row['residencial_2'])) {
                        $contactos[] = $row['residencial_2'];
                    }

                    if($this->verificar_contacto($ids_graduados, $row['residencial_3'])) {
                        $contactos[] = $row['residencial_3'];
                    }

                    if($this->verificar_contacto($ids_graduados, $row['residencial_4'])) {
                        $contactos[] = $row['residencial_4'];
                    }

                    if($this->verificar_contacto($ids_graduados, $row['residencial_5'])) {
                        $contactos[] = $row['residencial_5'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Residencial',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE TIPO RESIDENCIAL */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS CELULARES ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['celular_1'])){
                        $contactos[] = $row['celular_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_2'])){
                        $contactos[] = $row['celular_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_3'])){
                        $contactos[] = $row['celular_3'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_4'])){
                        $contactos[] = $row['celular_4'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_5'])){
                        $contactos[] = $row['celular_5'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Celular',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE TIPO CELULAR */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['correo_1'])){
                        $contactos[] = $row['correo_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_2'])){
                        $contactos[] = $row['correo_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_3'])){
                        $contactos[] = $row['correo_3'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_4'])){
                        $contactos[] = $row['correo_4'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Correo electrónico',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE TIPO CORREO ELECTRONICO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }
                    
                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DE LA MADRE ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_madre_1'])){
                        $contactos[] = $row['telefono_madre_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_madre_2'])){
                        $contactos[] = $row['telefono_madre_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_madre_1'])){
                        $contactos[] = $row['celular_madre_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_madre_2'])){
                        $contactos[] = $row['celular_madre_2'];
                    }

                    if(sizeof($contactos) > 0) { 
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_madre'],
                            'nombre_referencia' => $row['nombre_madre'],
                            'parentezco' => 'Madre',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LA MADRE */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL PADRE ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_padre_1'])){
                        $contactos[] = $row['telefono_padre_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_padre_2'])){
                        $contactos[] = $row['telefono_padre_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_padre_1'])){
                        $contactos[] = $row['celular_padre_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_padre_2'])){
                        $contactos[] = $row['celular_padre_2'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_padre'],
                            'nombre_referencia' => $row['nombre_padre'],
                            'parentezco' => 'Padre',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL PADRE */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL CONYUGE ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_conyuge_1'])){
                        $contactos[] = $row['telefono_conyuge_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_conyuge_2'])){
                        $contactos[] = $row['telefono_conyuge_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_conyuge_1'])){
                        $contactos[] = $row['celular_conyuge_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_conyuge_2'])){
                        $contactos[] = $row['celular_conyuge_2'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_conyuge'],
                            'nombre_referencia' => $row['nombre_conyuge'],
                            'parentezco' => 'Conyuge',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL CONYUGE */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 1 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_1_a'])){
                        $contactos[] = $row['telefono_hijo_1_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_1_b'])){
                        $contactos[] = $row['telefono_hijo_1_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_1_c'])){
                        $contactos[] = $row['celular_hijo_1_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_1_d'])){
                        $contactos[] = $row['celular_hijo_1_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hijo_1'],
                            'nombre_referencia' => $row['nombre_hijo_1'],
                            'parentezco' => 'Hijo 1',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 2 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_2_a'])){
                        $contactos[] = $row['telefono_hijo_2_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_2_b'])){
                        $contactos[] = $row['telefono_hijo_2_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_2_c'])){
                        $contactos[] = $row['celular_hijo_2_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_2_d'])){
                        $contactos[] = $row['celular_hijo_2_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hijo_2'],
                            'nombre_referencia' => $row['nombre_hijo_2'],
                            'parentezco' => 'Hijo 2',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 3 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_3_a'])){
                        $contactos[] = $row['telefono_hijo_3_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_3_b'])){
                        $contactos[] = $row['telefono_hijo_3_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_3_c'])){
                        $contactos[] = $row['celular_hijo_3_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_3_d'])){
                        $contactos[] = $row['celular_hijo_3_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hijo_3'],
                            'nombre_referencia' => $row['nombre_hijo_3'],
                            'parentezco' => 'Hijo 3',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 4 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_4_a'])){
                        $contactos[] = $row['telefono_hijo_4_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_4_b'])){
                        $contactos[] = $row['telefono_hijo_4_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_4_c'])){
                        $contactos[] = $row['celular_hijo_4_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_4_d'])){
                        $contactos[] = $row['celular_hijo_4_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hijo_4'],
                            'nombre_referencia' => $row['nombre_hijo_4'],
                            'parentezco' => 'Hijo 4',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 5 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_5_a'])){
                        $contactos[] = $row['telefono_hijo_5_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_5_b'])){
                        $contactos[] = $row['telefono_hijo_5_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_5_c'])){
                        $contactos[] = $row['celular_hijo_5_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hijo_5_d'])){
                        $contactos[] = $row['celular_hijo_5_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hijo_5'],
                            'nombre_referencia' => $row['nombre_hijo_5'],
                            'parentezco' => 'Hijo 5',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 1 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_1_a'])){
                        $contactos[] = $row['telefono_hermano_1_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_1_b'])){
                        $contactos[] = $row['telefono_hermano_1_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_1_c'])){
                        $contactos[] = $row['celular_hermano_1_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_1_d'])){
                        $contactos[] = $row['celular_hermano_1_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hermano_1'],
                            'nombre_referencia' => $row['nombre_hermano_1'],
                            'parentezco' => 'Hermano 1',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 2 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_2_a'])){
                        $contactos[] = $row['telefono_hermano_2_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_2_b'])){
                        $contactos[] = $row['telefono_hermano_2_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_2_c'])){
                        $contactos[] = $row['celular_hermano_2_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_2_d'])){
                        $contactos[] = $row['celular_hermano_2_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hermano_2'],
                            'nombre_referencia' => $row['nombre_hermano_2'],
                            'parentezco' => 'Hermano 2',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 3 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_3_a'])){
                        $contactos[] = $row['telefono_hermano_3_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_3_b'])){
                        $contactos[] = $row['telefono_hermano_3_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_3_c'])){
                        $contactos[] = $row['celular_hermano_3_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_3_d'])){
                        $contactos[] = $row['celular_hermano_3_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hermano_3'],
                            'nombre_referencia' => $row['nombre_hermano_3'],
                            'parentezco' => 'Hermano 3',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 4 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_4_a'])){
                        $contactos[] = $row['telefono_hermano_4_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_4_b'])){
                        $contactos[] = $row['telefono_hermano_4_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_4_c'])){
                        $contactos[] = $row['celular_hermano_4_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_4_d'])){
                        $contactos[] = $row['celular_hermano_4_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hermano_4'],
                            'nombre_referencia' => $row['nombre_hermano_4'],
                            'parentezco' => 'Hermano 4',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 5 ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_5_a'])){
                        $contactos[] = $row['telefono_hermano_5_a'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_5_b'])){
                        $contactos[] = $row['telefono_hermano_5_b'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_5_c'])){
                        $contactos[] = $row['celular_hermano_5_c'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['celular_hermano_5_d'])){
                        $contactos[] = $row['celular_hermano_5_d'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => $row['cedula_hermano_5'],
                            'nombre_referencia' => $row['nombre_hermano_5'],
                            'parentezco' => 'Hermano 5',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS DE CONTACTO DE PERFIL ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['correo_p_1'])){
                        $contactos[] = $row['correo_p_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_p_2'])){
                        $contactos[] = $row['correo_p_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_p_3'])){
                        $contactos[] = $row['correo_p_3'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_p_4'])){
                        $contactos[] = $row['correo_p_4'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Correos Perfil',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE PERFIL */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }
                    
                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DEL ARCHIVO DE PERFIL ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_1'])){
                        $contactos[] = $row['telefono_p_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_2'])){
                        $contactos[] = $row['telefono_p_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_3'])){
                        $contactos[] = $row['telefono_p_3'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_4'])){
                        $contactos[] = $row['telefono_p_4'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_5'])){
                        $contactos[] = $row['telefono_p_5'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_6'])){
                        $contactos[] = $row['telefono_p_6'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_7'])){
                        $contactos[] = $row['telefono_p_7'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_8'])){
                        $contactos[] = $row['telefono_p_8'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_p_9'])){
                        $contactos[] = $row['telefono_p_9'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Teléfonos Perfil',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }
                    
                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_1'])){
                        $contactos[] = $row['otro_p_numero_1'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => $row['otro_p_nombre_1'],
                            'parentezco' => 'Teléfono Contacto 1 Perfil',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_2'])){
                        $contactos[] = $row['otro_p_numero_2'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => $row['otro_p_nombre_2'],
                            'parentezco' => 'Teléfono Contacto 2 Perfil',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_3'])){
                        $contactos[] = $row['otro_p_numero_3'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => $row['otro_p_nombre_3'],
                            'parentezco' => 'Teléfono Contacto 2 Perfil',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_4'])){
                        $contactos[] = $row['otro_p_numero_4'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => $row['otro_p_nombre_4'],
                            'parentezco' => 'Teléfono Contacto 2 Perfil',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE COLEGIO ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_colegio_1'])){
                        $contactos[] = $row['telefono_colegio_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_colegio_2'])){
                        $contactos[] = $row['telefono_colegio_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_colegio_3'])){
                        $contactos[] = $row['telefono_colegio_3'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Teléfonos Colegio',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS DE CONTACTO DEL ARCHIVO DE COLEGIO ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['correo_colegio_1'])){
                        $contactos[] = $row['correo_colegio_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_colegio_2'])){
                        $contactos[] = $row['correo_colegio_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_colegio_3'])){
                        $contactos[] = $row['correo_colegio_3'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Correos Colegio',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE ESCUELA ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['telefono_escuela_1'])){
                        $contactos[] = $row['telefono_escuela_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_escuela_2'])){
                        $contactos[] = $row['telefono_escuela_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['telefono_escuela_3'])){
                        $contactos[] = $row['telefono_escuela_3'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Teléfonos Escuela',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS DE CONTACTO DEL ARCHIVO DE ESCUELA ----- */
                    $contactos = array();

                    if($this->verificar_contacto($ids_graduados, $row['correo_escuela_1'])){
                        $contactos[] = $row['correo_escuela_1'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_escuela_2'])){
                        $contactos[] = $row['correo_escuela_2'];
                    }
                    if($this->verificar_contacto($ids_graduados, $row['correo_escuela_3'])){
                        $contactos[] = $row['correo_escuela_3'];
                    }

                    if(sizeof($contactos) > 0) {
                        $contactoGraduado = [
                            'identificacion_referencia' => '',
                            'nombre_referencia' => '',
                            'parentezco' => 'Correos Escuela',
                            'id_graduado' => $ids_graduados[0]
                        ];
    
                        /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
                        $this->guardar_contacto($contactoGraduado ,$contactos);
                    }

                    //FIN DEL ARCHIVO
                }
            });

            $reporte['total_de_registros'] = $this->registros_totales;

            dd($reporte);

            Flash::success('Se ha guardado el archivo de contactos. Abajo verá un reporte de los datos.');
            return view('excel.reporte-archivo-contactos')->with('reporte', $reporte);
        }
    }

    private function buscar_graduado($identificacion) {
        $graduado = EncuestaGraduado::where('identificacion_graduado', $identificacion)->pluck('id');

        return $graduado;
    }

    private function verificar_contacto($ids_graduados, $contacto_excel) {
        $encontrados = DetalleContacto::where('contacto', $contacto_excel)->with('contacto_graduado')->first();
        $guardar = false;

        if(empty($encontrados)) {
            //Guardar el numero.
            $guardar = true;
        }
        else {
            foreach($encontrados as $detalle) {
                // verifica que el ID del graduado encontrado con el contacto, no se encuentre en
                // los IDS enocntrados por la cedula.
                if(in_array($detalle->contacto_graduado->id_graduado, $ids_graduados->toArray())){
                    //guardar un mensaje haciendo constar que el numero ya pertenece a ese graduado.
                    $this->reporte['contactos_ya_registrados'][] = 'El contacto ' . $detalle->contacto . ' ya se encuentra registrado con el graduado con cédula ' . $this->cedula_graduado . '.';
                    $guardar = false;
                }
                else {
                    // guardar un mensaje haciendo constar que el contacto pertenece a otro graduado.
                    $graduado = EncuestaGraduado::find($detalle->contacto_graduado->id_graduado);
                    $this->reporte['contactos_ya_registrados'][] = 'El contacto ' . $detalle->contacto . ' ya se encuentra registrado  con el graduado con cedula ' . $graduado->identificacion_graduado . '.';
                    $guardar = false;
                }
            }
        }

        return $guardar;
    }

    /**
     * Guarda el contacto en la base de datos con los datos suministrados por cada registro en el archivo
     * de excel.
     * @param $contactoGraduado Arreglo con la informacion de contacto.
     * @param $detalle Numeros de contacto que pertenecen al arreglo $contactoGraduado.
     */
    private function guardar_contacto($contactoGraduado, $detalle) {
        $contactoNuevo = ContactoGraduado::create($contactoGraduado);

        foreach($detalle as $contacto) {
            $detalleContactoNuevo = DetalleContacto::create([
                'contacto' => $contacto,
                'observacion' => '',
                'estado' => 'F',
                'id_contacto_graduado' =>$contactoNuevo->id
            ]);
        }
    }
}
