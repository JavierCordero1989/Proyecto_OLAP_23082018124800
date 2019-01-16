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
set_time_limit(1800);

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class ArchivosExcelController extends Controller
{
    private $reporte = array();
    private $registros_totales = 0;
    private $cedula_graduado = '';


    private $cedulas_sin_coincidencia = array();
    private $contactos_encontrados = array();
    private $total_de_registros = 0;
    private $total_de_contactos = 0;
    private $total_contactos_guardados = 0;
    private $cedulas = array();

    /**
     * @param $arreglo_contactos Arreglo con los telefonos del archivo de Excel.
     * Permite limpiar el arreglo y devolver un arreglo con los datos que no
     * están vacíos dentro del arreglo por parámetro.
     */
    private function limpiar_arreglo_contactos($arreglo_contactos) {
        $temp = array();

        foreach($arreglo_contactos as $contacto) {
            if($contacto != "" && $contacto != null) {
                $temp[] = $contacto;
            }
        }

        return $temp;
    } // fin de la función limpiar_arreglo_contactos

    /**
     * @param $request Datos provenientes del formulario.
     */
    public function subir_archivo_de_contactos(Request $request) {
        /* se consulta si en los datos del formulario, viene un archivo */
        if($request->hasFile('archivo_contactos')) {
            /* se obtiene el archivo de los datos del formulario */
            $archivo = $request->file('archivo_contactos');

            /* solo para obtener el tiempo de ejecución antes de iniciar la ejecución */
            $inicio = microtime(true);

            /* se lee el archivo de Excel con la función load */
            Excel::load($archivo, function ($reader) {
                /* Se obtienen todos los numeros de la tabla de detalle */
                $contactosBD = DetalleContacto::pluck('contacto')->toArray();

                /* se inicia una transacción sql para guardar en la base de datos*/
                DB::beginTransaction();

                /* se abre un try-catch para capturar cualquier excepción que suceda en el proceso */
                try {

                    /* se lee cada fila del archivo de excel */
                    foreach ($reader->get() as $key => $row) {
                        /* si en el campo de cédula hay datos, se acumula en contador,
                        para saber cuales contactos aparecen más de una vez. */
                        if(isset($this->cedulas[$row->identificacion])) {
                            $this->cedulas[$row->identificacion]++;
                        }
                        else {
                            $this->cedulas[$row->identificacion] = 1;
                        }

                        /* se busca el graduado por cédula en la base de datos. */
                        $graduado = EncuestaGraduado::where('identificacion_graduado', $row->identificacion)
                            ->whereNull('deleted_at')
                            // ->where('tipo_de_caso', '<>', 'REEMPLAZO')
                            ->with('contactos')
                            ->get();

                        /* si el contacto no se encuentra por cédula, se salta al siguiente registro
                        del archivo de Excel */
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

                    /* después de leído el archivo, se hace un commit a la
                    base de datos, para asegurar la transacción */
                    DB::commit();
                }
                catch(\Exception $ex) {
                    /* si alguna excepción ocurre, los datos almacenados, serán borrados */
                    DB::rollback();
                    Flash::error('Error en el sistema.<br>Excepcion: '.$ex->getMessage());
                    return redirect(url('home'));
                }
            });

            /* si hay mas de un contacto guardado, se guarda el registro de la acción
            en la bitácora de la base de datos. */
            if($this->total_contactos_guardados > 0) {
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

            /* se captura el tiempo, para saber cuanto tiempo duró el script ejecutandose */
            $fin = microtime(true);

            /* se crea un contador y un array para saber la cantidad de cédulas repetidas */
            $conta_cedula = 0;
            $temp_cedulas_repetidas = array();

            /* se recorren la cédulas guardadas del archivo de Excel */
            foreach($this->cedulas as $cedula => $veces) {
                /* si cada cédula se repite más de una vez, se guarda y se incrementa el contador */
                if($veces > 1) {
                    $temp_cedulas_repetidas[$cedula] = $veces;
                    $conta_cedula++;
                }
            }

            /* se reemplaza el arreglo de cédulas del archivo, por las que se repiten más de 
            una vez */
            $this->cedulas = $temp_cedulas_repetidas;

            /* se crea un arreglo con los datos obtenidos de resumen, para mostrarlos al
            final de recorrido todo el archivo de contactos */
            $informe = [
                'tiempo_invertido' => round(($fin - $inicio),2),
                'registros_cedula_repetida'=>$conta_cedula,
                'cedulas_repetidas' => $this->cedulas,
                'cedulas_sin_coincidencias'=>$this->cedulas_sin_coincidencia,
                'total_de_registros'=>$this->total_de_registros,
                'total_de_contactos'=>$this->total_de_contactos,
                'total_de_guardados'=>$this->total_contactos_guardados
            ];
            
            /* se muestra un mensaje de éxito, y se muestra la vista con el informe del proceso */
            Flash::success('El archivo de contactos se ha subido correctamente. Podrá ver un informe de la situación a continuación.');
            return view('excel.informe-carga-contactos')->with('informe', $informe);
        }
    } // fin de la función subir_archivo_de_contactos

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
    } // fin de la función guardar
}
