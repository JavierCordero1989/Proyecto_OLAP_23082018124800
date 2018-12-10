<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Carrera;
use App\Universidad;
use App\Area;
use App\Disciplina;
use Flash;

class CatalogoController extends Controller
{
    public function subir_catalogos() {
        return view('catalogo.subir-catalogos');
    }

    public function cargar_catalogo(Request $request) {
        
        $archivos_subidos = array();

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
                        Area::create($data);
                    }
                }
                $archivos_subidos[] = "Archivo de áreas subido";
            });
        }

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
                        Disciplina::create($data);
                    }
                }
                $archivos_subidos[] = "Archivo de disciplinas subido";
            });
        }

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
                        Universidad::create($data);
                    }
                }
                $archivos_subidos[] = "Archivo de universidades subido";
            });
        }

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
                        Carrera::create($data);
                    }
                }
                $archivos_subidos[] = "Archivo de carreras subido";
            });
        }

        Flash::success('Los archivos han sido subidos');
        return view('catalogo.resumen-subida-catalogo')->with('archivos_subidos', $archivos_subidos);
        // if($request->hasFile('archivo_nuevo')) {
        //     $archivo = $request->file('archivo_nuevo');
        // }
    }
}
