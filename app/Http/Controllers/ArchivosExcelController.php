<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
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

    public function subir_archivo_de_contactos(Request $request) {
        if($request->hasFile('archivo_contactos')) {
            $archivo = $request->file('archivo_contactos');

            Excel::load($archivo, function ($reader) {
                foreach ($reader->get() as $key => $row) {
                    $identificacion = $row['identificacion'];
                    $ids_graduados = $this->buscar_graduado($identificacion);

                    if(sizeof($ids_graduados) <= 0) {
                        $this->reporte['graduados_no_encontrados'][] = 'El graduado con cédula '.$identificacion.' no ha sido encontrado en los registros.';
                        continue;
                    }

                    $this->verificar_contacto($ids_graduados, $row['residencial_1']);

                    $row['residencial_1'];
                    $row['residencial_2'];
                    $row['residencial_3'];
                    $row['residencial_4'];
                    $row['residencial_5'];

                    $row['celular_1'];
                    $row['celular_2'];
                    $row['celular_3'];
                    $row['celular_4'];
                    $row['celular_5'];

                    $row['correo_1'];
                    $row['correo_2'];
                    $row['correo_3'];
                    $row['correo_4'];

                    $row['cedula_madre'];
                    $row['nombre_madre'];
                    $row['telefono_madre_1'];
                    $row['telefono_madre_2'];
                    $row['celular_madre_1'];
                    $row['celular_madre_2'];

                    $row['cedula_padre'];
                    $row['nombre_padre'];
                    $row['telefono_padre_1'];
                    $row['telefono_padre_2'];
                    $row['celular_padre_1'];
                    $row['celular_padre_2'];

                    $row['cedula_conyuge'];
                    $row['nombre_conyuge'];
                    $row['telefono_conyuge_1'];
                    $row['telefono_conyuge_2'];
                    $row['celular_conyuge_1'];
                    $row['celular_conyuge_2'];

                    $row['cedula_hijo_1'];
                    $row['nombre_hijo_1'];
                    $row['telefono_hijo_1_a'];
                    $row['telefono_hijo_1_b'];
                    $row['celular_hijo_1_c'];
                    $row['celular_hijo_1_d'];

                    $row['cedula_hijo_2'];
                    $row['nombre_hijo_2'];
                    $row['telefono_hijo_2_a'];
                    $row['telefono_hijo_2_b'];
                    $row['celular_hijo_2_c'];
                    $row['celular_hijo_2_d'];

                    $row['cedula_hijo_3'];
                    $row['nombre_hijo_3'];
                    $row['telefono_hijo_3_a'];
                    $row['telefono_hijo_3_b'];
                    $row['celular_hijo_3_c'];
                    $row['celular_hijo_3_d'];

                    $row['cedula_hijo_4'];
                    $row['nombre_hijo_4'];
                    $row['telefono_hijo_4_a'];
                    $row['telefono_hijo_4_b'];
                    $row['celular_hijo_4_c'];
                    $row['celular_hijo_4_d'];

                    $row['cedula_hijo_5'];
                    $row['nombre_hijo_5'];
                    $row['telefono_hijo_5_a'];
                    $row['telefono_hijo_5_b'];
                    $row['celular_hijo_5_c'];
                    $row['celular_hijo_5_d'];

                    $row['cedula_hermano_1'];
                    $row['nombre_hermano_1'];
                    $row['telefono_hermano_1_a'];
                    $row['telefono_hermano_1_b'];
                    $row['celular_hermano_1_c'];
                    $row['celular_hermano_1_d'];

                    $row['cedula_hermano_2'];
                    $row['nombre_hermano_2'];
                    $row['telefono_hermano_2_a'];
                    $row['telefono_hermano_2_b'];
                    $row['celular_hermano_2_c'];
                    $row['celular_hermano_2_d'];

                    $row['cedula_hermano_3'];
                    $row['nombre_hermano_3'];
                    $row['telefono_hermano_3_a'];
                    $row['telefono_hermano_3_b'];
                    $row['celular_hermano_3_c'];
                    $row['celular_hermano_3_d'];

                    $row['cedula_hermano_4'];
                    $row['nombre_hermano_4'];
                    $row['telefono_hermano_4_a'];
                    $row['telefono_hermano_4_b'];
                    $row['celular_hermano_4_c'];
                    $row['celular_hermano_4_d'];

                    $row['cedula_hermano_5'];
                    $row['nombre_hermano_5'];
                    $row['telefono_hermano_5_a'];
                    $row['telefono_hermano_5_b'];
                    $row['celular_hermano_5_c'];
                    $row['celular_hermano_5_d'];

                    $row['correo_p_1'];
                    $row['correo_p_2'];
                    $row['correo_p_3'];
                    $row['correo_p_4'];

                    $row['telefono_p_1'];
                    $row['telefono_p_2'];
                    $row['telefono_p_3'];
                    $row['telefono_p_4'];
                    $row['telefono_p_5'];
                    $row['telefono_p_6'];
                    $row['telefono_p_7'];
                    $row['telefono_p_8'];
                    $row['telefono_p_9'];

                    $row['otro_p_nombre_1'];
                    $row['otro_p_numero_1'];

                    $row['otro_p_nombre_2'];
                    $row['otro_p_numero_2'];

                    $row['otro_p_nombre_3'];
                    $row['otro_p_numero_3'];

                    $row['otro_p_nombre_4'];
                    $row['otro_p_numero_4'];

                    $row['telefono_colegio_1'];
                    $row['telefono_colegio_2'];
                    $row['telefono_colegio_3'];
                    $row['correo_colegio_1'];
                    $row['correo_colegio_2'];
                    $row['correo_colegio_3'];
                    $row['telefono_escuela_1'];
                    $row['telefono_escuela_2'];
                    $row['telefono_escuela_3'];
                    $row['correo_escuela_1'];
                    $row['correo_escuela_2'];
                    $row['correo_escuela_3'];
                }
            });
        }
    }

    private function buscar_graduado($identificacion) {
        $graduado = EncuestaGraduado::where('identificacion_graduado', $identificacion)->pluck('id');

        return $graduado;
    }

    private function verificar_contacto($ids_graduados, $contacto_excel) {
        $encontrados = DetalleContacto::where('contacto', $contacto_excel)->with('contacto_graduado')->get();

        if(sizeof($encontrados) <= 0) {
            //Guardar el numero
        }
        else {
            foreach($encontrados as $detalle) {
                
                in_array($detalle->contacto_graduado->id_graduado, $ids_graduados->toArray());
            }
        }
    }
}
