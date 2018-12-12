<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Carrera;
use App\Universidad;
use App\Area;
use App\Disciplina;
use Flash;

/*
 * Impide que el servidor genere un error debido al tiempo
 * de espera seteado de 60 segundos.
*/ 
set_time_limit(300);

class CatalogoController extends Controller
{
    private $archivos_subidos = array();
    private $contadores = array();

    public function subir_catalogos() {
        return view('catalogo.subir-catalogos');
    }

    public function cargar_catalogo(Request $request) {
        /* COMPROBAR QUE VIENE UN ARCHIVO DE AREAS */
        if(isset($request->catalogo_areas)) {
            $archivo = $request->file('catalogo_areas');

            /** El método load permite cargar el archivo definido como primer parámetro */
            Excel::load($archivo, function ($reader) {
                foreach ($reader->get() as $key => $row) {
                    if($row->cod_area_olap == "" || $row->nombre_area_olap == "") {
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
        }

        /* COMPROBAR QUE VIENE UN ARCHIVO DE DISCIPLINAS */
        if(isset($request->catalogo_disciplinas)) {
            $archivo = $request->file('catalogo_disciplinas');



            /** El método load permite cargar el archivo definido como primer parámetro */
            Excel::load($archivo, function ($reader) {
                foreach ($reader->get() as $key => $row) {
                    if($row->cod_disciplina_olap == "" || $row->nombre_disciplina_olap == "" || $row->cod_area_olap == "") {
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
        }

        /* COMPROBAR QUE VIENE UN ARCHIVO DE UNIVERSIDADES */
        if(isset($request->catalogo_universidades)) {
            $archivo = $request->file('catalogo_universidades');

            /** El método load permite cargar el archivo definido como primer parámetro */
            Excel::load($archivo, function ($reader) {
                foreach ($reader->get() as $key => $row) {
                    if($row->id_universidad == "" || $row->nombre_universidad == "") {
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
        }

        /* COMPROBAR QUE VIENE UN ARCHIVO DE CARRERAS */
        if(isset($request->catalogo_carreras)) {
            $archivo = $request->file('catalogo_carreras');

            /** El método load permite cargar el archivo definido como primer parámetro */
            Excel::load($archivo, function ($reader) {
                foreach ($reader->get() as $key => $row) {
                    if($row->cod_carrera_conare == "" || $row->nombre_carrera_universidad_conare == "") {
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
        }

        Flash::success('Los archivos han sido subidos');
        return view('catalogo.resumen-subida-catalogo')
            ->with('archivos_subidos', $this->archivos_subidos)
            ->with('contadores', $this->contadores);
        // if($request->hasFile('archivo_nuevo')) {
        //     $archivo = $request->file('archivo_nuevo');
        // }
    }
}
