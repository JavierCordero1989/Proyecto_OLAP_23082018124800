<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Universidad;
use App\Disciplina;
use Carbon\Carbon;
use App\Area;
use DB;

class ReportesController extends Controller
{
    public function index() {
        $reporte = [
            'titulo' => 'Cuadro resumen del grado de avance del trabajo de campo de la encuesta de seguimiento de la condición laboral de las personas graduadas 2011-2013 de universidades estatales correspondiente al área de Educación al 24-04-2016',
            'data' => [
                array('ucr'  , 1315, 452,  1767, 683,  430,  1113, 370, 248, 55.5),
                array('una'  , 1197, 660,  1858, 807,  508,  1315, 233, 148, 29.0),
                array('itcr' , 203,  6,    209,  124,  0,    124,  29,  0,   23.4),
                array('uned' , 1318, 990,  2308, 342,  204,  546,  79,  31,  20.1),
                array('utn'  , 524,  0,    524,  197,  0,    197,  3,   0,   1.5)
            ],
            'total'=> array(4557, 2108, 6666, 2153, 1142, 3295, 714, 427, 34.63)
        ];

        $reporte_areas_ucr = [
            'titulo'=> 'Universidad de Costa Rica',
            'fecha' => Carbon::now()->format('d - m - Y'),
            'data' => [
                'Educación' => [
                    array('Total Educación'                 , 1315, 452, 1767, 683, 430, 1113, 370, 248, 55.53, 0), 
                    array('Administración Educativa'        , 0,    79,  79,   0,   79,  79,   0,   47,  59.49, 0),
                    array('Artes Industriales'              , 1,    0,   1,    0,   0,   0,    0,   0,   0.0,   0),
                    array('Docencia'                        , 0,    2,   2,    0,   0,   0,    0,   0,   0.0,   0),
                    array('Educación  Preescolar'           , 126,  56,  182,  30,  56,  86,   10,  34,  51.16, 0),
                    array('Educación Especial'              , 67,   34,  101,  67,  34,  101,  37,  25,  61.39, 0),
                    array('Educación Física'                , 106,  0,   106,  30,  0,   30,   22,  0,   73.33, 0),
                    array('Educación Preescolar Inglés'     , 27,   0,   27,   27,  0,   27,   15,  0,   55.56, 0),
                    array('Educación Primaria'              , 90,   65,  155,  90,  65,  155,  44,  40,  54.19, 0),
                    array('Educación Primaria Inglés'       , 41,   0,   41,   41,  0,   41,   19,  0,   0.0,   0),
                    array('Enseñanza de Castellano'         , 67,   20,  87,   67,  20,  87,   28,  13,  47.13, 0),
                    array('Enseñanza de Estudios Sociales'  , 117,  36,  153,  30,  36,  66,   22,  18,  60.61, 0),
                    array('Enseñanza de Francés'            , 91,   0,   91,   91,  0,   91,   36,  0,   39.56, 0),
                    array('Enseñanza de Inglés'             , 269,  6,   275,  30,  0,   30,   13,  0,   43.33, 0),
                    array('Enseñanza de la Filosofía'       , 13,   0,   13,   0,   0,   0,    0,   0,   0.0,   0),
                    array('Enseñanza de la Música'          , 39,   7,   46,   39,  0,   39,   30,  0,   76.92, 0),
                    array('Enseñanza de la Psicología'      , 10,   0,   10,   0,   0,   0,    0,   0,   0.0,   0),
                    array('Enseñanza de las Artes Plásticas', 13,   0,   13,   0,   0,   0,    0,   0,   0.0,   0),
                    array('Enseñanza de las Ciencias'       , 28,   7,   35,   28,  0,   28,   22,  0,   78.57, 0),
                    array('Enseñanza de Matemática'         , 83,   61,  144,  83,  61,  144,  49,  25,  51.39, 0),
                    array('Orientación'                     , 127,  79,  206,  30,  79,  109,  23,  46,  63.3,  0)
                ],
                'Ciencias Básicas' => [
                    array('Total Ciencias Básicas', 398, 58, 456, 301, 27, 328, 61, 6, 20.43, 0),
                    array('Biología'              , 107, 14, 121, 30,  0,  30,  4,  0, 13.33, 0),
                    array('Estadística'           , 33,  3,  36,  33,  0,  33,  12, 0, 36.36, 0),
                    array('Física'                , 25,  0,  25,  25,  0,  25,  11, 0, 44.0,  0),
                    array('Geología'              , 45,  14, 59,  45,  0,  45,  13, 0, 28.89, 0),
                    array('Laboratorista Químico' , 84,  0,  84,  84,  0,  84,  12, 0, 14.29, 0),
                    array('Matemática'            , 13,  0,  13,  0,   0,  0,   0,  0, 0.0,   0),
                    array('Meteorología'          , 7,   0,  7,   0,   0,  0,   0,  0, 0.0,   0),
                    array('Química'               , 84,  27, 111, 84,  27, 111, 9,  6, 13.51, 0)
                ]
            ],
            'total' => [1713, 510, 2223, 984, 457, 1441, 431, 254, 47.54]
        ];

        $reporte_areas_una = [
            'titulo'=> 'Universidad Nacional',
            'fecha' => Carbon::now()->format('d - m - Y'),
            'data' => [
                'Educación' => [
                    array('Total Educación'                 , 944,  218, 1162, 336, 205, 541,  185, 123, 56.93, 0), 
                    array('Educación  Preescolar'           , 126,  56,  182,  30,  56,  86,   10,  34,  51.16, 0),
                    array('Educación Especial'              , 67,   34,  101,  67,  34,  101,  37,  25,  61.39, 0),
                    array('Educación Física'                , 106,  0,   106,  30,  0,   30,   22,  0,   73.33, 0),
                    array('Enseñanza de Estudios Sociales'  , 117,  36,  153,  30,  36,  66,   22,  18,  60.61, 0),
                    array('Enseñanza de Francés'            , 91,   0,   91,   91,  0,   91,   36,  0,   39.56, 0),
                    array('Enseñanza de Inglés'             , 269,  6,   275,  30,  0,   30,   13,  0,   43.33, 0),
                    array('Enseñanza de la Filosofía'       , 13,   0,   13,   0,   0,   0,    0,   0,   0.0,   0),
                    array('Enseñanza de las Ciencias'       , 28,   7,   35,   28,  0,   28,   22,  0,   78.57, 0),
                    array('Orientación'                     , 127,  79,  206,  30,  79,  109,  23,  46,  63.3,  0)
                ],
                'Ciencias Básicas' => [
                    array('Total Ciencias Básicas', 301, 58, 359, 217, 27, 244, 49, 6, 22.54, 0),
                    array('Biología'              , 107, 14, 121, 30,  0,  30,  4,  0, 13.33, 0),
                    array('Estadística'           , 33,  3,  36,  33,  0,  33,  12, 0, 36.36, 0),
                    array('Física'                , 25,  0,  25,  25,  0,  25,  11, 0, 44.0,  0),
                    array('Geología'              , 45,  14, 59,  45,  0,  45,  13, 0, 28.89, 0),
                    array('Meteorología'          , 7,   0,  7,   0,   0,  0,   0,  0, 0.0,   0),
                    array('Química'               , 84,  27, 111, 84,  27, 111, 9,  6, 13.51, 0)
                ]
            ],
            'total' => [1245, 276, 1521, 553, 232, 785, 234, 129, 46.24]
        ];

        return view('reportes.index')
            ->with('reporte', json_encode($reporte))
            ->with('reporte_areas_ucr', json_encode($reporte_areas_ucr))
            ->with('reporte_areas_una', json_encode($reporte_areas_una));
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
