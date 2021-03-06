<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Universidad;
use App\Disciplina;
use Carbon\Carbon;
use App\Carrera;
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
class CatalogoController extends Controller
{
    private $archivos_subidos = array();
    private $contadores = array();

    public function subir_catalogos() {
        return view('catalogo.subir-catalogos');
    }

    public function cargar_catalogo(Request $request) {
        try {
            DB::beginTransaction();
            /* COMPROBAR QUE VIENE UN ARCHIVO DE AREAS */
            if(isset($request->catalogo_areas)) {
                $archivo = $request->file('catalogo_areas');

                /** El método load permite cargar el archivo definido como primer parámetro */
                Excel::load($archivo, function ($reader) {
                    $areas = Area::pluck('codigo')->toArray();

                    foreach ($reader->get() as $key => $row) {
                        if($row->cod_area_olap == "" || $row->nombre_area_olap == "") {
                            continue;
                        }

                        if(in_array($row->cod_area_olap, $areas)) {
                            continue;
                        }

                        $data = [
                            'codigo' => $row->cod_area_olap,
                            'descriptivo' => $row->nombre_area_olap
                        ];

                        if(!empty($data)) {
                            // para llevar un conteo de cunatas áreas se guardan.
                            if(isset($this->contadores['areas'])) {
                                $this->contadores['areas']++;
                            }
                            else {
                                $this->contadores['areas'] = 1;
                            }

                            Area::create($data);
                        }
                    }
                    $this->archivos_subidos[] = "Archivo de áreas cargado.";
                });

                // Guardar el registro en la bitacora
                $bitacora = [
                    'transaccion'            =>'I',
                    'tabla'                  =>'tbl_areas',
                    'id_registro_afectado'   =>null,
                    'dato_original'          =>null,
                    'dato_nuevo'             =>('El archivo del catálogo de áreas ha sido cargado en la base de datos del sistema.'),
                    'fecha_hora_transaccion' =>Carbon::now(),
                    'id_usuario'             =>Auth::user()->id,
                    'created_at'             =>Carbon::now()
                ];
        
                DB::table('tbl_bitacora_de_cambios')->insert($bitacora);
            }

            /* COMPROBAR QUE VIENE UN ARCHIVO DE DISCIPLINAS */
            if(isset($request->catalogo_disciplinas)) {
                $archivo = $request->file('catalogo_disciplinas');

                /** El método load permite cargar el archivo definido como primer parámetro */
                Excel::load($archivo, function ($reader) {
                    $disciplinas = Disciplina::pluck('codigo')->toArray();

                    foreach ($reader->get() as $key => $row) {
                        
                        if($row->cod_disciplina_olap == "" || $row->nombre_disciplina_olap == "" || $row->cod_area_olap == "") {
                            continue;
                        }

                        if(in_array($row->cod_disciplina_olap, $disciplinas)) {
                            continue;
                        }

                        $data = [
                            'codigo' => $row->cod_disciplina_olap,
                            'descriptivo' => $row->nombre_disciplina_olap,
                            'id_area' => $row->cod_area_olap
                        ];

                        if(!empty($data)) {
                            // para llevar un conteo de cuantas disciplinas se guardan.
                            if(isset($this->contadores['disciplinas'])) {
                                $this->contadores['disciplinas']++;
                            }
                            else {
                                $this->contadores['disciplinas'] = 1;
                            }

                            Disciplina::create($data);
                        }
                    }
                    $this->archivos_subidos[] = "Archivo de disciplinas cargado.";
                });

                // Guardar el registro en la bitacora
                $bitacora = [
                    'transaccion'            =>'I',
                    'tabla'                  =>'tbl_disciplinas',
                    'id_registro_afectado'   =>null,
                    'dato_original'          =>null,
                    'dato_nuevo'             =>('El archivo del catálogo de disciplinas ha sido cargado en la base de datos del sistema.'),
                    'fecha_hora_transaccion' =>Carbon::now(),
                    'id_usuario'             =>Auth::user()->id,
                    'created_at'             =>Carbon::now()
                ];
        
                DB::table('tbl_bitacora_de_cambios')->insert($bitacora);
            }

            /* COMPROBAR QUE VIENE UN ARCHIVO DE UNIVERSIDADES */
            if(isset($request->catalogo_universidades)) {
                $archivo = $request->file('catalogo_universidades');

                /** El método load permite cargar el archivo definido como primer parámetro */
                Excel::load($archivo, function ($reader) {
                    $universidades = Universidad::allData()->pluck('codigo')->toArray();

                    foreach ($reader->get() as $key => $row) {
                        if($row->id_universidad == "" || $row->nombre_universidad == "") {
                            continue;
                        }

                        if(in_array($row->id_universidad, $universidades)) {
                            continue;
                        }

                        $data = [
                            'codigo' => $row->id_universidad,
                            'nombre' => $row->nombre_universidad,
                            'id_tipo' => 2 // 2 corresponde a Universidad
                        ];

                        if(!empty($data)) {
                            // para llevar un conteo de cuantas universidades se guardan.
                            if(isset($this->contadores['universidades'])) {
                                $this->contadores['universidades']++;
                            }
                            else {
                                $this->contadores['universidades'] = 1;
                            }

                            Universidad::create($data);
                        }
                    }
                    $this->archivos_subidos[] = "Archivo de universidades cargado.";
                });

                // Guardar el registro en la bitacora
                $bitacora = [
                    'transaccion'            =>'I',
                    'tabla'                  =>'tbl_datos_carrera_graduado',
                    'id_registro_afectado'   =>null,
                    'dato_original'          =>null,
                    'dato_nuevo'             =>('El archivo del catálogo de universidades ha sido cargado en la base de datos del sistema.'),
                    'fecha_hora_transaccion' =>Carbon::now(),
                    'id_usuario'             =>Auth::user()->id,
                    'created_at'             =>Carbon::now()
                ];
        
                DB::table('tbl_bitacora_de_cambios')->insert($bitacora);
            }

            /* COMPROBAR QUE VIENE UN ARCHIVO DE CARRERAS */
            if(isset($request->catalogo_carreras)) {
                $archivo = $request->file('catalogo_carreras');

                /** El método load permite cargar el archivo definido como primer parámetro */
                Excel::load($archivo, function ($reader) {
                    $carreras = Carrera::allData()->pluck('codigo')->toArray();

                    foreach ($reader->get() as $key => $row) {
                        if($row->cod_carrera_conare == "" || $row->nombre_carrera_universidad_conare == "") {
                            continue;
                        }

                        if(in_array($row->cod_carrera_conare, $carreras)) {
                            continue;
                        }

                        $data = [
                            'codigo' => $row->cod_carrera_conare,
                            'nombre' => $row->nombre_carrera_universidad_conare,
                            'id_tipo' => 1 // 1 corresponde a Carrera
                        ];

                        if(!empty($data)) {
                            // para llevar un conteo de cuantas carreras se guardan.
                            if(isset($this->contadores['carreras'])) {
                                $this->contadores['carreras']++;
                            }
                            else {
                                $this->contadores['carreras'] = 1;
                            }

                            Carrera::create($data);
                        }
                    }
                    $this->archivos_subidos[] = "Archivo de carreras cargado.";
                });

                // Guardar el registro en la bitacora
                $bitacora = [
                    'transaccion'            =>'I',
                    'tabla'                  =>'tbl_datos_carrera_graduado',
                    'id_registro_afectado'   =>null,
                    'dato_original'          =>null,
                    'dato_nuevo'             =>('El archivo del catálogo de carreras ha sido cargado en la base de datos del sistema.'),
                    'fecha_hora_transaccion' =>Carbon::now(),
                    'id_usuario'             =>Auth::user()->id,
                    'created_at'             =>Carbon::now()
                ];
        
                DB::table('tbl_bitacora_de_cambios')->insert($bitacora);
            }
            DB::commit();

            Flash::success('Los archivos han sido subidos');
            return view('catalogo.resumen-subida-catalogo')
                ->with('archivos_subidos', $this->archivos_subidos)
                ->with('contadores', $this->contadores);
        }
        catch(\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: cargar_catalogo().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return view('catalogo.subir-catalogos');
        }
    }
}
