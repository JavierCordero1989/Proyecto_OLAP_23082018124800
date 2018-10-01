<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\Disciplina;
use DB;
use App\Universidad;
use Illuminate\Support\Collection;
use App\EncuestaGraduado as Entrevista;

class ReportesController extends Controller
{
    public function index() {
        return view('reportes.index');
    }

    public function filtro_reportes() {
        $disciplinas = Disciplina::all();
        $areas = Area::all();

        return view('reportes.filtro_reportes');
    }

    public function filtrar_encuestas_para_reporte(Request $request) {
        $sectores = $request->sector;
        $universidades = $request->universidades;
        $disciplinas = $request->disciplinas;

        // Se seleccionó todos los sectores
        if($sectores[0] == "1") {
            $encuestas = Entrevista::whereIn('codigo_sector', [1,2]);
            
        }
        else {
            //Sector público
            if($sectores[0] == "2") {
                $encuestas = Entrevista::where('codigo_sector', 1);
            }
            //Sector privado
            if($sectores[0] == "3") {
                $encuestas = Entrevista::where('codigo_sector', 2);
            }
        }

        // Filtra por universidades seleccionadas
        $encuestas = Entrevista::whereIn('codigo_universidad', $universidades);

        $ids_disciplinas = [];

        foreach ($disciplinas as $disciplina) {
            $area = Area::buscarPorDescriptivo($disciplina)->first();

            if(empty($area)) {
                $objeto_disciplina = Disciplina::buscarPorCodigo($disciplina)->first();
                if(!in_array($objeto_disciplina->id, $ids_disciplinas)) {
                    $ids_disciplinas[] = $objeto_disciplina->id;
                }
            }
            else {
                $encontrados = $area->disciplinas->pluck('id')->all();

                foreach($encontrados as $dato) {
                    $ids_disciplinas[] = $dato;
                }
            }
        }

        $encuestas = Entrevista::whereIn('codigo_disciplina', $ids_disciplinas)->get();
        
        // dd('Disciplinas', $ids_disciplinas);
        dd('Encuestas', $encuestas);
        dd($sectores, $universidades, $disciplinas);

        return view('reportes.reporte_filtrado');
    }

    public function traer_universidades_por_sector(Request $request) {
        if($request->ajax()) {
            $mensaje = '';
            $universidades = [];

            if(sizeof($request->valores) == 0) {
                $mensaje = 'No se ha seleccionado nada';
            }
            else if(sizeof($request->valores) == 1) {
                if($request->valores[0] == '2') {
                    $mensaje = 'Se seleccionó un valor - 2';
                    $universidades = Universidad::obtenerPublicas()->get();
                }
                if($request->valores[0] == '3') {
                    $mensaje = 'Se seleccionó un valor - 3';
                    $universidades = Universidad::obtenerPrivadas()->get();
                }
                
            }
            else if(sizeof($request->valores) == 3) {
                $mensaje = 'Se seleccionó todo';
                $universidades = Universidad::allData()->all();
            }
            else {
                $mensaje = 'PASÓ ALGO MALO';
            }
            
            // Se traen todas las áreas de la base de datos
            // $areas = Area::all();
            $areas = Area::select('id', 'codigo', 'descriptivo')->get();
            $disciplinas = [];

            //Se recorren todas las áreas obtenidas para guardar las disciplinas de cada área.
            foreach ($areas as $area) {
                $disciplinas[$area->descriptivo] = $area->disciplinas;
            }

            $datos_respuesta = [
                'mensaje'=>$mensaje,
                'datos_obtenidos'=>$universidades,
                'disciplinas'=>$disciplinas
            ];

            return response()->json($datos_respuesta);
        }
    }

    private function etiquetasAreas($areas) {
        $etiquetas = [];

        foreach ($areas as $cod_area) {
            $obj_area = Area::find($cod_area);
            $etiquetas[] = $obj_area->descriptivo;
        }

        return $etiquetas;
    }

    private function etiquetasDisciplinas($disciplinas) {
        $etiquetas = [];

        foreach ($disciplinas as $cod_disciplina) {
            $obj_disciplina = Disciplina::buscarPorCodigo($cod_disciplina)->first();
            $etiquetas[] = $obj_disciplina->descriptivo;
        }

        return $etiquetas;
    }
}
