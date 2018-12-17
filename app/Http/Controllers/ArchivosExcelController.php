<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
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
set_time_limit(600);

class ArchivosExcelController extends Controller
{
    private $reporte = array();
    private $registros_totales = 0;
    private $cedula_graduado = '';

    // public function subir_archivo_de_contactos(Request $request) {
    //     if($request->hasFile('archivo_contactos')) {
    //         $archivo = $request->file('archivo_contactos');

    //         Excel::load($archivo, function ($reader) {
    //             foreach ($reader->get() as $key => $row) {

                    

    //                 /* se obtiene la cedula de la columna */
    //                 $identificacion = $row['identificacion'];
    //                 $this->cedula_graduado = $row['identificacion'];
    //                 $ids_graduados = $this->buscar_graduado($identificacion);

    //                 /* si no se encuentra un registro con la cedula obtenida, se salta el registro de informacion. */
    //                 if(sizeof($ids_graduados) <= 0) {
    //                     $this->reporte['graduados_no_encontrados'][] = 'El graduado con cédula '.$identificacion.' no ha sido encontrado en los registros.';
    //                     continue;
    //                 }

    //                 /* suma uno a los registros para un conteo. */
    //                 $this->registros_totales++;

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS RESIDENCIALES ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['residencial_1'])){
    //                     $contactos[] = $row['residencial_1'];
    //                 }

    //                 if($this->verificar_contacto($ids_graduados, $row['residencial_2'])) {
    //                     $contactos[] = $row['residencial_2'];
    //                 }

    //                 if($this->verificar_contacto($ids_graduados, $row['residencial_3'])) {
    //                     $contactos[] = $row['residencial_3'];
    //                 }

    //                 if($this->verificar_contacto($ids_graduados, $row['residencial_4'])) {
    //                     $contactos[] = $row['residencial_4'];
    //                 }

    //                 if($this->verificar_contacto($ids_graduados, $row['residencial_5'])) {
    //                     $contactos[] = $row['residencial_5'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Residencial',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE TIPO RESIDENCIAL */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS CELULARES ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['celular_1'])){
    //                     $contactos[] = $row['celular_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_2'])){
    //                     $contactos[] = $row['celular_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_3'])){
    //                     $contactos[] = $row['celular_3'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_4'])){
    //                     $contactos[] = $row['celular_4'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_5'])){
    //                     $contactos[] = $row['celular_5'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Celular',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE TIPO CELULAR */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['correo_1'])){
    //                     $contactos[] = $row['correo_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['correo_2'])){
    //                     $contactos[] = $row['correo_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['correo_3'])){
    //                     $contactos[] = $row['correo_3'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['correo_4'])){
    //                     $contactos[] = $row['correo_4'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Correo electrónico',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE TIPO CORREO ELECTRONICO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }
                    
    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DE LA MADRE ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_madre_1'])){
    //                     $contactos[] = $row['telefono_madre_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_madre_2'])){
    //                     $contactos[] = $row['telefono_madre_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_madre_1'])){
    //                     $contactos[] = $row['celular_madre_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_madre_2'])){
    //                     $contactos[] = $row['celular_madre_2'];
    //                 }

    //                 if(sizeof($contactos) > 0) { 
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_madre'],
    //                         'nombre_referencia' => $row['nombre_madre'],
    //                         'parentezco' => 'Madre',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LA MADRE */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL PADRE ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_padre_1'])){
    //                     $contactos[] = $row['telefono_padre_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_padre_2'])){
    //                     $contactos[] = $row['telefono_padre_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_padre_1'])){
    //                     $contactos[] = $row['celular_padre_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_padre_2'])){
    //                     $contactos[] = $row['celular_padre_2'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_padre'],
    //                         'nombre_referencia' => $row['nombre_padre'],
    //                         'parentezco' => 'Padre',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL PADRE */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL CONYUGE ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_conyuge_1'])){
    //                     $contactos[] = $row['telefono_conyuge_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_conyuge_2'])){
    //                     $contactos[] = $row['telefono_conyuge_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_conyuge_1'])){
    //                     $contactos[] = $row['celular_conyuge_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_conyuge_2'])){
    //                     $contactos[] = $row['celular_conyuge_2'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_conyuge'],
    //                         'nombre_referencia' => $row['nombre_conyuge'],
    //                         'parentezco' => 'Conyuge',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL CONYUGE */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 1 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_1_a'])){
    //                     $contactos[] = $row['telefono_hijo_1_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['telefono_hijo_1_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['celular_hijo_1_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['celular_hijo_1_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => ,
    //                         'nombre_referencia' => ,
    //                         'parentezco' => 'Hijo 1',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 2 ----- */
    //                 $contactos = array();

    
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_2_a'])){
    //                     $contactos[] = $row['telefono_hijo_2_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_2_b'])){
    //                     $contactos[] = $row['telefono_hijo_2_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_2_c'])){
    //                     $contactos[] = $row['celular_hijo_2_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_2_d'])){
    //                     $contactos[] = $row['celular_hijo_2_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hijo_2'],
    //                         'nombre_referencia' => $row['nombre_hijo_2'],
    //                         'parentezco' => 'Hijo 2',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 3 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_3_a'])){
    //                     $contactos[] = $row['telefono_hijo_3_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_3_b'])){
    //                     $contactos[] = $row['telefono_hijo_3_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_3_c'])){
    //                     $contactos[] = $row['celular_hijo_3_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_3_d'])){
    //                     $contactos[] = $row['celular_hijo_3_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hijo_3'],
    //                         'nombre_referencia' => $row['nombre_hijo_3'],
    //                         'parentezco' => 'Hijo 3',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 4 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_4_a'])){
    //                     $contactos[] = $row['telefono_hijo_4_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_4_b'])){
    //                     $contactos[] = $row['telefono_hijo_4_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_4_c'])){
    //                     $contactos[] = $row['celular_hijo_4_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_4_d'])){
    //                     $contactos[] = $row['celular_hijo_4_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hijo_4'],
    //                         'nombre_referencia' => $row['nombre_hijo_4'],
    //                         'parentezco' => 'Hijo 4',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HIJO 5 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_5_a'])){
    //                     $contactos[] = $row['telefono_hijo_5_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hijo_5_b'])){
    //                     $contactos[] = $row['telefono_hijo_5_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_5_c'])){
    //                     $contactos[] = $row['celular_hijo_5_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hijo_5_d'])){
    //                     $contactos[] = $row['celular_hijo_5_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hijo_5'],
    //                         'nombre_referencia' => $row['nombre_hijo_5'],
    //                         'parentezco' => 'Hijo 5',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HIJO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 1 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_1_a'])){
    //                     $contactos[] = $row['telefono_hermano_1_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_1_b'])){
    //                     $contactos[] = $row['telefono_hermano_1_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_1_c'])){
    //                     $contactos[] = $row['celular_hermano_1_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_1_d'])){
    //                     $contactos[] = $row['celular_hermano_1_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hermano_1'],
    //                         'nombre_referencia' => $row['nombre_hermano_1'],
    //                         'parentezco' => 'Hermano 1',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 2 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_2_a'])){
    //                     $contactos[] = $row['telefono_hermano_2_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_2_b'])){
    //                     $contactos[] = $row['telefono_hermano_2_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_2_c'])){
    //                     $contactos[] = $row['celular_hermano_2_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_2_d'])){
    //                     $contactos[] = $row['celular_hermano_2_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hermano_2'],
    //                         'nombre_referencia' => $row['nombre_hermano_2'],
    //                         'parentezco' => 'Hermano 2',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 3 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_3_a'])){
    //                     $contactos[] = $row['telefono_hermano_3_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_3_b'])){
    //                     $contactos[] = $row['telefono_hermano_3_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_3_c'])){
    //                     $contactos[] = $row['celular_hermano_3_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_3_d'])){
    //                     $contactos[] = $row['celular_hermano_3_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hermano_3'],
    //                         'nombre_referencia' => $row['nombre_hermano_3'],
    //                         'parentezco' => 'Hermano 3',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 4 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_4_a'])){
    //                     $contactos[] = $row['telefono_hermano_4_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_4_b'])){
    //                     $contactos[] = $row['telefono_hermano_4_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_4_c'])){
    //                     $contactos[] = $row['celular_hermano_4_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_4_d'])){
    //                     $contactos[] = $row['celular_hermano_4_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hermano_4'],
    //                         'nombre_referencia' => $row['nombre_hermano_4'],
    //                         'parentezco' => 'Hermano 4',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS Y CELULARES DEL HERMANO 5 ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_5_a'])){
    //                     $contactos[] = $row['telefono_hermano_5_a'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_hermano_5_b'])){
    //                     $contactos[] = $row['telefono_hermano_5_b'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_5_c'])){
    //                     $contactos[] = $row['celular_hermano_5_c'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['celular_hermano_5_d'])){
    //                     $contactos[] = $row['celular_hermano_5_d'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => $row['cedula_hermano_5'],
    //                         'nombre_referencia' => $row['nombre_hermano_5'],
    //                         'parentezco' => 'Hermano 5',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DEL HERMANO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS DE CONTACTO DE PERFIL ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['correo_p_1'])){
    //                     $contactos[] = $row['correo_p_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['correo_p_2'])){
    //                     $contactos[] = $row['correo_p_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['correo_p_3'])){
    //                     $contactos[] = $row['correo_p_3'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['correo_p_4'])){
    //                     $contactos[] = $row['correo_p_4'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Correos Perfil',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE PERFIL */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }
                    
    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DEL ARCHIVO DE PERFIL ----- */
    //                 $contactos = array();
    
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_1'])){
    //                     $contactos[] = $row['telefono_p_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_2'])){
    //                     $contactos[] = $row['telefono_p_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_3'])){
    //                     $contactos[] = $row['telefono_p_3'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_4'])){
    //                     $contactos[] = $row['telefono_p_4'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_5'])){
    //                     $contactos[] = $row['telefono_p_5'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_6'])){
    //                     $contactos[] = $row['telefono_p_6'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_7'])){
    //                     $contactos[] = $row['telefono_p_7'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_8'])){
    //                     $contactos[] = $row['telefono_p_8'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_p_9'])){
    //                     $contactos[] = $row['telefono_p_9'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Teléfonos Perfil',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }
                    
    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_1'])){
    //                     $contactos[] = $row['otro_p_numero_1'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => $row['otro_p_nombre_1'],
    //                         'parentezco' => 'Teléfono Contacto 1 Perfil',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_2'])){
    //                     $contactos[] = $row['otro_p_numero_2'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => $row['otro_p_nombre_2'],
    //                         'parentezco' => 'Teléfono Contacto 2 Perfil',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_3'])){
    //                     $contactos[] = $row['otro_p_numero_3'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => $row['otro_p_nombre_3'],
    //                         'parentezco' => 'Teléfono Contacto 2 Perfil',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE PERFIL ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['otro_p_numero_4'])){
    //                     $contactos[] = $row['otro_p_numero_4'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => $row['otro_p_nombre_4'],
    //                         'parentezco' => 'Teléfono Contacto 2 Perfil',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE PERFIL */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE COLEGIO ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_colegio_1'])){
    //                     $contactos[] = $row['telefono_colegio_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_colegio_2'])){
    //                     $contactos[] = $row['telefono_colegio_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['telefono_colegio_3'])){
    //                     $contactos[] = $row['telefono_colegio_3'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Teléfonos Colegio',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS TELEFONOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS DE CONTACTO DEL ARCHIVO DE COLEGIO ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, $row['correo_colegio_1'])){
    //                     $contactos[] = $row['correo_colegio_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, $row['correo_colegio_2'])){
    //                     $contactos[] = $row['correo_colegio_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['correo_colegio_3'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Correos Colegio',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS TELEFONOS DE CONTACTO DEL ARCHIVO DE ESCUELA ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['telefono_escuela_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['telefono_escuela_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['telefono_escuela_3'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Teléfonos Escuela',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 /* ----- SE GUARDA LA INFORMACION DE CONTACTO DE LOS CORREOS DE CONTACTO DEL ARCHIVO DE ESCUELA ----- */
    //                 $contactos = array();

    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['correo_escuela_1'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['correo_escuela_2'];
    //                 }
    //                 if($this->verificar_contacto($ids_graduados, )){
    //                     $contactos[] = $row['correo_escuela_3'];
    //                 }

    //                 if(sizeof($contactos) > 0) {
    //                     $contactoGraduado = [
    //                         'identificacion_referencia' => '',
    //                         'nombre_referencia' => '',
    //                         'parentezco' => 'Correos Escuela',
    //                         'id_graduado' => $ids_graduados[0]
    //                     ];
    
    //                     /* SE GUARDA EL CONTACTO DE LA INFORMACION DE LOS CORREOS DEL ARCHIVO DE ESCUELA Y COLEGIO */
    //                     $this->guardar_contacto($contactoGraduado ,$contactos);
    //                 }

    //                 //FIN DEL ARCHIVO
    //             }
    //         });

    //         $reporte['total_de_registros'] = $this->registros_totales;

    //         dd($reporte);

    //         Flash::success('Se ha guardado el archivo de contactos. Abajo verá un reporte de los datos.');
    //         return view('excel.reporte-archivo-contactos')->with('reporte', $reporte);
    //     }
    // }

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


    private $cedulas_sin_coincidencia = array();
    private $contactos_encontrados = array();
    private $total_de_registros = 0;
    private $total_de_contactos = 0;
    private $total_contactos_guardados = 0;
    private $cedulas = array();

    private function limpiar_arreglo_contactos($arreglo_contactos) {
        $temp = array();

        foreach($arreglo_contactos as $contacto) {
            if($contacto != "" && $contacto != null) {
                $temp[] = $contacto;
            }
        }

        return $temp;
    }

    public function subir_archivo_de_contactos(Request $request) {
        if($request->hasFile('archivo_contactos')) {
            $archivo = $request->file('archivo_contactos');

            $inicio = microtime(true);

            Excel::load($archivo, function ($reader) {
                /* Se obtienen todos los numeros de la tabla de detalle */
                $contactosBD = DetalleContacto::pluck('contacto')->toArray();

                DB::beginTransaction();
                try {

                    foreach ($reader->get() as $key => $row) {
                        if(isset($this->cedulas[$row->identificacion])) {
                            $this->cedulas[$row->identificacion]++;
                        }
                        else {
                            $this->cedulas[$row->identificacion] = 1;
                        }

                        $graduado = EncuestaGraduado::where('identificacion_graduado', $row->identificacion)
                            ->whereNull('deleted_at')
                            // ->where('tipo_de_caso', '<>', 'REEMPLAZO')
                            ->with('contactos')
                            ->get();

                        if(empty($graduado)) {
                            $this->cedulas_sin_coincidencia[] = $row->identificacion;
                            continue;
                        }
                        else {
                            /* SE AGREGAN LOS NUMEROS RESIDENCIALES*/
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->residencial_1,
                                    $row->residencial_2,
                                    $row->residencial_3,
                                    $row->residencial_4,
                                    $row->residencial_5
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Residencial'
                                ]
                            );

                            /* SE AGREGAN LOS CELULARES */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->celular_1,
                                    $row->celular_2,
                                    $row->celular_3,
                                    $row->celular_4,
                                    $row->celular_5,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Celular'
                                ]
                            );

                            /* SE AGREGAN LOS CORREOS */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->correo_1,
                                    $row->correo_2,
                                    $row->correo_3,
                                    $row->correo_4,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Correos'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE LA MADRE */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_madre_1,
                                    $row->telefono_madre_2,
                                    $row->celular_madre_1,
                                    $row->celular_madre_2,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_madre,
                                    $row->nombre_madre,
                                    'Madre'
                                ]
                            );
                            
                            /* SE AGREGAN LOS TELEFONOS DEL PADRE */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_padre_1,
                                    $row->telefono_padre_2,
                                    $row->celular_padre_1,
                                    $row->celular_padre_2,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_padre,
                                    $row->nombre_padre,
                                    'Padre'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL CONYUGE */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_conyuge_1,
                                    $row->telefono_conyuge_2,
                                    $row->celular_conyuge_1,
                                    $row->celular_conyuge_2,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_conyuge,
                                    $row->nombre_conyuge,
                                    'Conyuge'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HIJO 1 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hijo_1_a,
                                    $row->telefono_hijo_1_b,
                                    $row->celular_hijo_1_c,
                                    $row->celular_hijo_1_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hijo_1,
                                    $row->nombre_hijo_1,
                                    'Hijo 1'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HIJO 2 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hijo_2_a,
                                    $row->telefono_hijo_2_b,
                                    $row->celular_hijo_2_c,
                                    $row->celular_hijo_2_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hijo_2,
                                    $row->nombre_hijo_2,
                                    'Hijo 2'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HIJO 3 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hijo_3_a,
                                    $row->telefono_hijo_3_b,
                                    $row->celular_hijo_3_c,
                                    $row->celular_hijo_3_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hijo_3,
                                    $row->nombre_hijo_3,
                                    'Hijo 3'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HIJO 4 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hijo_4_a,
                                    $row->telefono_hijo_4_b,
                                    $row->celular_hijo_4_c,
                                    $row->celular_hijo_4_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hijo_4,
                                    $row->nombre_hijo_4,
                                    'Hijo 4'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HIJO 5 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hijo_5_a,
                                    $row->telefono_hijo_5_b,
                                    $row->celular_hijo_5_c,
                                    $row->celular_hijo_5_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hijo_5,
                                    $row->nombre_hijo_5,
                                    'Hijo 5'
                                ]
                            );
                            
                            /* SE AGREGAN LOS TELEFONOS DEL HERMANO 1 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hermano_1_a,
                                    $row->telefono_hermano_1_b,
                                    $row->celular_hermano_1_c,
                                    $row->celular_hermano_1_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hermano_1,
                                    $row->nombre_hermano_1,
                                    'Hermano 1'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HERMANO 2 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hermano_2_a,
                                    $row->telefono_hermano_2_b,
                                    $row->celular_hermano_2_c,
                                    $row->celular_hermano_2_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hermano_2,
                                    $row->nombre_hermano_2,
                                    'Hermano 2'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HERMANO 3 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hermano_3_a,
                                    $row->telefono_hermano_3_b,
                                    $row->celular_hermano_3_c,
                                    $row->celular_hermano_3_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hermano_3,
                                    $row->nombre_hermano_3,
                                    'Hermano 3'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HERMANO 4 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hermano_4_a,
                                    $row->telefono_hermano_4_b,
                                    $row->celular_hermano_4_c,
                                    $row->celular_hermano_4_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hermano_4,
                                    $row->nombre_hermano_4,
                                    'Hermano 4'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DEL HERMANO 5 */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_hermano_5_a,
                                    $row->telefono_hermano_5_b,
                                    $row->celular_hermano_5_c,
                                    $row->celular_hermano_5_d,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    $row->cedula_hermano_5,
                                    $row->nombre_hermano_5,
                                    'Hermano 5'
                                ]
                            );

                            /* SE AGREGAN LOS CORREOS DE PERFIL */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->correo_p_1,
                                    $row->correo_p_2,
                                    $row->correo_p_3,
                                    $row->correo_p_4,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Correos de Perfil'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE PERFIL */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_p_1,
                                    $row->telefono_p_2,
                                    $row->telefono_p_3,
                                    $row->telefono_p_4,
                                    $row->telefono_p_5,
                                    $row->telefono_p_6,
                                    $row->telefono_p_7,
                                    $row->telefono_p_8,
                                    $row->telefono_p_9
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Teléfonos de Perfil'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE CONTACTO DE OTRA PERSONA DEL PERFIL */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->otro_p_numero_1,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    $row->otro_p_nombre_1,
                                    'Perfil Otros 1'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE CONTACTO DE OTRA PERSONA DEL PERFIL */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->otro_p_numero_2,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    $row->otro_p_nombre_2,
                                    'Perfil Otros 2'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE CONTACTO DE OTRA PERSONA DEL PERFIL */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->otro_p_numero_3,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    $row->otro_p_nombre_3,
                                    'Perfil Otros 3'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE CONTACTO DE OTRA PERSONA DEL PERFIL */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->otro_p_numero_4,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    $row->otro_p_nombre_4,
                                    'Perfil Otros 4'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE CONTACTO DEL COLEGIO */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_colegio_1,
                                    $row->telefono_colegio_2,
                                    $row->telefono_colegio_3,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Teléfonos Colegio'
                                ]
                            );

                            /* SE AGREGAN LOS CORREOS DE CONTACTO DEL COLEGIO */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->correo_colegio_1,
                                    $row->correo_colegio_2,
                                    $row->correo_colegio_3,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Correos Colegio'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE CONTACTO DE LA ESCUELA */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->telefono_escuela_1,
                                    $row->telefono_escuela_2,
                                    $row->telefono_escuela_3,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Teléfonos Escuela'
                                ]
                            );

                            /* SE AGREGAN LOS TELEFONOS DE CONTACTO DE LA ESCUELA */
                            $contactosBD = $this->guardar(
                                $this->limpiar_arreglo_contactos([
                                    $row->correo_escuela_1,
                                    $row->correo_escuela_2,
                                    $row->correo_escuela_3,
                                ]),
                                $contactosBD,
                                $graduado,
                                [
                                    '',
                                    '',
                                    'Correos Escuela'
                                ]
                            );
                        } //Fin del else empty($graduado)
                        $this->total_de_registros++;
                    }// Fin del foreach que recorre los registros

                    DB::commit();
                }
                catch(\Exception $ex) {
                    DB::rollback();
                    Flash::error('Error en el sistema.<br>Excepcion: '.$ex->getMessage());
                    return redirect(url('home'));
                }
            });

            if($this->total_contactos_guardados > 0) {
                // Guardar el registro en la bitacora
                $bitacora = [
                    'transaccion'            =>'I',
                    'tabla'                  =>'tbl_contactos_graduados',
                    'id_registro_afectado'   =>null,
                    'dato_original'          =>null,
                    'dato_nuevo'             =>('El archivo de contactos ha sido cargado en la base de datos del sistema.'),
                    'fecha_hora_transaccion' =>Carbon::now(),
                    'id_usuario'             =>Auth::user()->id,
                    'created_at'             =>Carbon::now()
                ];
        
                DB::table('tbl_bitacora_de_cambios')->insert($bitacora);
            }

            $fin = microtime(true);
            // echo 'Total de tiempo: ' . round(($fin - $inicio), 2) . ' segundos<br>';

            $conta_cedula = 0;
            $temp_cedulas_repetidas = array();

            foreach($this->cedulas as $cedula => $veces) {
                if($veces > 1) {
                    $temp_cedulas_repetidas[$cedula] = $veces;
                    $conta_cedula++;
                }
            }

            $this->cedulas = $temp_cedulas_repetidas;

            $informe = [
                'tiempo_invertido' => round(($fin - $inicio),2),
                'registros_cedula_repetida'=>$conta_cedula,
                'cedulas_repetidas' => $this->cedulas,
                'cedulas_sin_coincidencias'=>$this->cedulas_sin_coincidencia,
                'total_de_registros'=>$this->total_de_registros,
                'total_de_contactos'=>$this->total_de_contactos,
                'total_de_guardados'=>$this->total_contactos_guardados,
                'del_contacto'=>$this->contactos_encontrados['del_contacto'],
                'de_otro'=>$this->contactos_encontrados['de_otro']
            ];
            
            // dd($informe);
            Flash::success('El archivo de contactos se ha subido correctamente. Podrá ver un informe de la situación a continuación.');
            return view('excel.informe-carga-contactos')->with('informe', $informe);
        }
    }

    /** 
     * @param $arreglo_contactos    Arreglo con los contactos provenientes del excel.
     * @param $arreglo_contactos_bd Arreglo con los contactos de la base de datos.
     * @param $entrevistas          Entrevistas encontradas que corresponden con la cedula.
     * @param $referencia           Arreglo con los datos de referencia del contacto.
     * 
     * Guarda los contactos pasados por parametros en la base de datos, verificando que los mismos no se encuentren ya almacenados
     * en la base de datos, previamente.
     */
    private function guardar($arreglo_contactos, $arreglo_contactos_bd, $entrevistas, $referencia) {
        /* si el arreglo de contactos trae datos, se procede a realizar el proceso, de lo contrario solo se
        brincara el proceso para seguir con otra llamada.*/
        if(sizeof($arreglo_contactos) > 0) {
            $this->total_de_contactos = $this->total_de_contactos + sizeof($arreglo_contactos); 

            /* arreglo para saber cuales contactos de los que estan en $arreglo_contactos, se encuentran en la BD. */
            $temp_contactos_en_bd = array();
            /* arreglo para guardar los contactos de $arreglo_contactos, que no estan en la BD. */
            $temp_contactos_nuevos = array();
    
            foreach($arreglo_contactos as $contacto) {
                /* Comprueba que cada contacto este en la BD. */
                if(in_array($contacto, $arreglo_contactos_bd)) {
                    /* si el contacto existe en la BD, se guarda en un arreglo temporal */
                    $temp_contactos_en_bd[] = $contacto;
                }
                else {
                    /* comprueba que el contacto no este vacio o nulo. */
                    if($contacto != "" && $contacto != null) {
                        /* si el contacto no existe, se guarda en un arreglo temporal y se actualiza la BD. */
                        $arreglo_contactos_bd[] = $contacto;
                        $temp_contactos_nuevos[] = $contacto;
                    }
                }
            }
    
            /* Si existen contactos que ya estan en la base de datos, se debe verificar que no le pertenezcan a cada una
            de las entrevistas encontradas */
            if(sizeof($temp_contactos_en_bd) > 0) {
                /* Arreglo temporal con los contactos encontrados en cada entrevista */
                $temp_arreglo_contactos_entrevista = array();
    
                foreach($entrevistas as $entrevista) {
                    foreach($entrevista->contactos as $contacto) {
                        foreach($contacto->detalle as $detalle) {
                            /* se guarda cada contacto de las entrevistas, en el arreglo. */
                            $temp_arreglo_contactos_entrevista[] = $detalle->contacto;
                        }
                    }
                }
    
                /* Se recorre el arreglo de contactos del archivo. */
                foreach($arreglo_contactos as $contacto) {
                    if(in_array($contacto, $temp_arreglo_contactos_entrevista)) {
                        /* El contacto, ya le pertenece a las entrevistas encontradas. */
                        $this->contactos_encontrados['del_contacto'][] = $contacto;
                    }
                    else {
                        /* el contacto le pertenece a alguna otra entrevista. */
                        $this->contactos_encontrados['de_otro'][] = $contacto;
                    }
                }
            }
    
            /* los contactos que no existen en la BD se guardan en cada entrevista encontrada */
            if(sizeof($temp_contactos_nuevos) > 0) {
                foreach($entrevistas as $entrevista) {
                    $contacto_nuevo = ContactoGraduado::create([
                        'identificacion_referencia' => $referencia[0],
                        'nombre_referencia' => $referencia[1],
                        'parentezco' => $referencia[2],
                        'id_graduado' => $entrevista->id,
                        'created_at' => Carbon::now()
                    ]);
    
                    foreach($temp_contactos_nuevos as $contacto) {
                        $this->total_contactos_guardados++;
                        $detalle = DetalleContacto::create([
                            'contacto'=>(string)$contacto,
                            'observacion'=>'',
                            'estado'=>'F',
                            'id_contacto_graduado'=>$contacto_nuevo->id,
                            'created_at' => Carbon::now()
                        ]);
                    }
                }
            }
        }

        /* al arreglo con los contactos de la BD, se le agregan todos los numeros nuevos, por
        lo que se devuelve para ser actualizado.*/
        return $arreglo_contactos_bd;
    }
}
