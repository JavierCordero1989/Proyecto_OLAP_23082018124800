<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Universidad;
use App\EncuestaGraduado;
use App\Agrupacion;
use App\Disciplina;
use Carbon\Carbon;
use App\Estado;
use App\Grado;
use App\Area;
use DB;

class ReportesController extends Controller
{
    public function vista_filtro_reportes() {
        return view('reportes.opciones-reporte');
    }

    public function generar_reporte(Request $request) {
        $graduados = EncuestaGraduado::whereNull('deleted_at')->get();
        $para_reporte = EncuestaGraduado::whereNull('deleted_at');

        $sector = $request->sector;
        $agrupacion = $request->agrupacion;
        $area = $request->area;
        $disciplina = $request->disciplina;
        
        $reporte = [
            'encuestas'=>$graduados,
            'total_de_encuestas' => sizeof($graduados),
            'sectores_elegidos' => $sector,
            'agrupaciones_elegidas' => $agrupacion,
            'areas_elegidas' => $area,
            'disciplinas_elegidas' => $disciplina
        ];

        if(isset($request->sector)) {
            $sector = $request->sector;
            $para_reporte = $para_reporte->whereIn('codigo_sector', $sector);
        }

        if(isset($request->agrupacion)) {
            $agrupacion = $request->agrupacion;
            $para_reporte = $para_reporte->whereIn('codigo_agrupacion', $agrupacion);
        }

        
        

        return array($reporte);
    }

    /** 
     * Permite obtener un arreglo de datos, con los totales por agrupacion, por area.
     * Obtiene los totales por Pregrado, Bachiller y Licenciatura
     */
    private function agrupacion_por_area($agrupacion, $id_area, $estado) {
        $coleccion = EncuestaGraduado::totalPorAreaPorAgrupacion($agrupacion->id, $id_area)->get();

        $cuenta = $coleccion->count();
        
        /* AQUI SE SACAN LOS TOTALES POR AREA Y POR AGRUPACION, ADEMAS SE SACAN LOS TOTALES POR GRADO */
        $profe = $coleccion->where('codigo_grado', Grado::buscarPorNombre('PROFESORADO')->first()->id);
        $total_agrupacion_profesorado = $profe->count();
        
        $diplo = $coleccion->where('codigo_grado', Grado::buscarPorNombre('DIPLOMADO')->first()->id);
        $total_agrupacion_diplomado = $diplo->count();

        /* SE SACA EL TOTAL POR PROFESORADO Y DIPLOMADO, PARA OBTENER EL DE PREGRADO, QUE ES LA SUMA DE AMBAS. */
        $total_agrupacion_pregrado = $total_agrupacion_profesorado + $total_agrupacion_diplomado;
        
        /* SE SACA EL TOTAL POR BACHILLER */
        $bachi = $coleccion->where('codigo_grado', Grado::buscarPorNombre('BACHILLERATO')->first()->id);
        $total_agrupacion_bachiller = $bachi->count();
        
        /* SE SACA EL TOTAL POR LICENCIATURA */
        $lic = $coleccion->where('codigo_grado', Grado::buscarPorNombre('LICENCIATURA')->first()->id);
        $total_agrupacion_licenciatura = $lic->count();


        /* SUMANDO LOS TRES TOTALES ANTERIORES, SE SACA EL TOTAL POR EL AREA */
        $total_agrupacion = $total_agrupacion_pregrado + $total_agrupacion_bachiller + $total_agrupacion_licenciatura;

        
        $coleccion = $coleccion->where('tbl_asignaciones.id_estado', $estado);

        /* AQUI SE SACAN LOS TOTALES POR AREA Y AGRUPACION, ADEMAS DE LOS TOTALES POR GRADO, PERO SOLO
        DE LAS ENTREVISTAS QUE ESTAN COMPLETAS. */
        $profe = $coleccion->where('codigo_grado', Grado::buscarPorNombre('PROFESORADO')->first()->id);
        $total_completas_profesorado = $profe->count();

        $diplo = $coleccion->where('codigo_grado', Grado::buscarPorNombre('DIPLOMADO')->first()->id);
        $total_completas_diplomado = $diplo->count();
        
        /* SE SACA EL TOTAL POR PROFESORADO Y DIPLOMADO, PARA OBTENER EL DE PREGRADO, QUE ES LA SUMA DE AMBAS. */
        $total_completas_pregrado = $total_completas_profesorado + $total_completas_diplomado;

        /* SE SACA EL TOTAL POR BACHILLER */
        $bachi = $coleccion->where('codigo_grado', Grado::buscarPorNombre('BACHILLERATO')->first()->id);
        $total_completas_bachiller = $bachi->count();
        
        /* SE SACA EL TOTAL POR LICENCIATURA */
        $lic = $coleccion->where('codigo_grado', Grado::buscarPorNombre('LICENCIATURA')->first()->id);
        $total_completas_licenciatura = $lic->count();

        /* SUMANDO LOS TRES TOTALES ANTERIORES, SE SACA EL TOTAL POR EL AREA */
        $total_completas = ($total_completas_pregrado + $total_completas_bachiller + $total_completas_licenciatura);

        return [
            $agrupacion->nombre,
            0, // total por poblacion - pregrado
            0, // total por poblacion - bachiller
            0, // total por poblacion - licenciatura
            0, // total por poblacion - total (pregrado+bachiller+licenciatura)
            $total_agrupacion_pregrado, //total por pregrado (profesorado y diplomado) 
            $total_agrupacion_bachiller, // total por bachiller
            $total_agrupacion_licenciatura, // total por licenciatura
            $total_agrupacion, // total de los tres grados
            $total_completas_pregrado, // total completas pregrado
            $total_completas_bachiller, // total completas bachiller
            $total_completas_licenciatura, // total completas licenciatura
            $total_agrupacion == 0 ? 0 : round( (($total_completas / $total_agrupacion) * 100) , 2)  // porcentaje avance (totalRealizadas / totalMuestra * 100)
        ];
    }

    private function obtenerTotales($array, $length) {
        $arrayTotales = array();

        for($i=1; $i<$length; $i++) {
            $arrayTotales[] = array_sum(array_column($array, $i));
        }

        return $arrayTotales;
    }

    private function disciplinas_por_area_y_agrupacion($id_agrupacion, $disciplina, $estado) {
        $coleccion = EncuestaGraduado::totalPorDisciplinaPorAgrupacion($id_agrupacion, $disciplina->id)->get();

        /* AQUI SE SACAN LOS TOTALES POR AREA Y POR AGRUPACION, ADEMAS SE SACAN LOS TOTALES POR GRADO */
        $profe = $coleccion->where('codigo_grado', Grado::buscarPorNombre('PROFESORADO')->first()->id);
        $total_agrupacion_profesorado = $profe->count();

        $diplo = $coleccion->where('codigo_grado', Grado::buscarPorNombre('DIPLOMADO')->first()->id);
        $total_agrupacion_diplomado = $diplo->count();

        /* SE SACA EL TOTAL POR PROFESORADO Y DIPLOMADO, PARA OBTENER EL DE PREGRADO, QUE ES LA SUMA DE AMBAS. */
        $total_agrupacion_pregrado = $total_agrupacion_profesorado + $total_agrupacion_diplomado;

        /* SE SACA EL TOTAL POR BACHILLER */
        $bachi = $coleccion->where('codigo_grado', Grado::buscarPorNombre('BACHILLERATO')->first()->id);
        $total_agrupacion_bachiller = $bachi->count();

        /* SE SACA EL TOTAL POR LICENCIATURA */
        $lic = $coleccion->where('codigo_grado', Grado::buscarPorNombre('LICENCIATURA')->first()->id);
        $total_agrupacion_licenciatura = $lic->count();

        /* SUMANDO LOS TRES TOTALES ANTERIORES, SE SACA EL TOTAL POR EL AREA */
        $total_agrupacion = $total_agrupacion_pregrado + $total_agrupacion_bachiller + $total_agrupacion_licenciatura;

        $coleccion = $coleccion->where('tbl_asignaciones.id_estado', $estado);

        /* AQUI SE SACAN LOS TOTALES POR AREA Y AGRUPACION, ADEMAS DE LOS TOTALES POR GRADO, PERO SOLO
        DE LAS ENTREVISTAS QUE ESTAN COMPLETAS. */
        $profe = $coleccion->where('codigo_grado', Grado::buscarPorNombre('PROFESORADO')->first()->id);
        $total_completas_profesorado = $profe->count();

        $diplo = $coleccion->where('codigo_grado', Grado::buscarPorNombre('DIPLOMADO')->first()->id);
        $total_completas_diplomado = $diplo->count();
        
        /* SE SACA EL TOTAL POR PROFESORADO Y DIPLOMADO, PARA OBTENER EL DE PREGRADO, QUE ES LA SUMA DE AMBAS. */
        $total_completas_pregrado = $total_completas_profesorado + $total_completas_diplomado;

        /* SE SACA EL TOTAL POR BACHILLER */
        $bachi = $coleccion->where('codigo_grado', Grado::buscarPorNombre('BACHILLERATO')->first()->id);
        $total_completas_bachiller = $bachi->count();

        /* SE SACA EL TOTAL POR LICENCIATURA */
        $lic = $coleccion->where('codigo_grado', Grado::buscarPorNombre('LICENCIATURA')->first()->id);
        $total_completas_licenciatura = $lic->count();

        /* SUMANDO LOS TRES TOTALES ANTERIORES, SE SACA EL TOTAL POR EL AREA */
        $total_completas = ($total_completas_pregrado + $total_completas_bachiller + $total_completas_licenciatura);

        return [
            $disciplina->descriptivo,
            0, // total por poblacion - pregrado
            0, // total por poblacion - bachiller
            0, // total por poblacion - licenciatura
            0, // total por poblacion - total (pregrado+bachiller+licenciatura)
            $total_agrupacion_pregrado, //total por pregrado (profesorado y diplomado) 
            $total_agrupacion_bachiller, // total por bachiller
            $total_agrupacion_licenciatura, // total por licenciatura
            $total_agrupacion, // total de los tres grados
            $total_completas_pregrado, // total completas pregrado
            $total_completas_bachiller, // total completas bachiller
            $total_completas_licenciatura, // total completas licenciatura
            $total_agrupacion == 0 ? 0 : round( (($total_completas / $total_agrupacion) * 100) , 2)  // porcentaje avance (totalRealizadas / totalMuestra * 100)
        ];
    }

    public function index() {

        $estado = Estado::where('estado', 'ENTREVISTA COMPLETA')->first()->id;
        $id_area = Area::buscarPorCodigo(1)->first()->id;
        $agrupacion = Agrupacion::buscarPorNombre('UCR')->first();

        $ucr = $this->agrupacion_por_area(
            $agrupacion,
            $id_area,
            $estado
        );

        $agrupacion = Agrupacion::buscarPorNombre('UNA')->first();

        $una = $this->agrupacion_por_area(
            $agrupacion,
            $id_area,
            $estado
        );

        $agrupacion = Agrupacion::buscarPorNombre('ITCR')->first();

        $itcr = $this->agrupacion_por_area(
            $agrupacion,
            $id_area,
            $estado
        );

        $agrupacion = Agrupacion::buscarPorNombre('UNED')->first();

        $uned = $this->agrupacion_por_area(
            $agrupacion,
            $id_area,
            $estado
        );

        $agrupacion = Agrupacion::buscarPorNombre('UTN')->first();

        $utn = $this->agrupacion_por_area(
            $agrupacion,
            $id_area,
            $estado
        );

        $agrupacion = Agrupacion::buscarPorNombre('PRIVADO')->first();

        $privado = $this->agrupacion_por_area(
            $agrupacion,
            $id_area,
            $estado
        );

        $array_agrupaciones = array($ucr, $una, $itcr, $uned, $utn, $privado);

        $reporte = [
            'titulo' => 'Cuadro resumen del grado de avance del trabajo de campo de la encuesta de seguimiento de la condición laboral de las personas graduadas 2011-2013 de universidades estatales correspondiente al área de Educación al 24-04-2016',
            'data' => $array_agrupaciones,
            'total'=> $this->obtenerTotales($array_agrupaciones, sizeof($array_agrupaciones[0]))
        ];

        // $reporte_areas_ucr = [
        //     'titulo'=> 'Universidad de Costa Rica',
        //     'fecha' => Carbon::now()->format('d - m - Y'),
        //     'data' => [
                
        //     ]
        // ];

        $areas = Area::whereNull('deleted_at')->with('disciplinas')->get();

        // $agrupacion = Agrupacion::buscarPorNombre('UCR')->first();
        // foreach($areas as $area) {
        //     $reporte_areas_ucr['data'][$area->descriptivo] = array();

        //     $disciplinas = $area->disciplinas;

        //     foreach($disciplinas as $disciplina) {
        //         $reporte_areas_ucr['data'][$area->descriptivo][] = $this->disciplinas_por_area_y_agrupacion($agrupacion->id, $disciplina, $estado);
        //     }
        // }

        // $reporte_areas_ucr['data'][$area->descriptivo][] = array();

        $disciplina = Disciplina::find(130);

        $reporte_areas_ucr = [
            'titulo'=> 'Universidad de Costa Rica',
            'fecha' => Carbon::now()->format('d - m - Y'),
            'data' => [
                'Educación' => [
                    array('Total Educación'                 , 1315, 452, 1767, 683, 430, 1113, 370, 248, 55.53, 0), 
                    // array('Administración Educativa'        , 0,    79,  79,   0,   79,  79,   0,   47,  59.49, 0),
                    $this->disciplinas_por_area_y_agrupacion($agrupacion->id, $disciplina, $estado),
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

    //La funcion carga la vista para filtro con los datos de las universidades tanto publicas
    // como privadas, asi como las areas y sus disciplinas
    public function filtro_reportes() {
        $universidades_publicas = Universidad::obtenerPublicas()->get();
        $universidades_privadas = Universidad::obtenerPrivadas()->get();
        $universidades = Universidad::allData();

        $disciplinas = Disciplina::all();
        $areas = Area::all();

        return view('reportes.filtro_reportes',
        compact('universidades_publicas', 'universidades_privadas', 'universidades', 'disciplinas', 'areas'));
    }

    public function filtrar_encuestas_para_reporte(Request $request) {
        $universidades = $request->universidades;
        $disciplinas = $request->areas;
        $mensaje = '';

        if(isset($request->todos_los_sectores)) {
            $mensaje .= 'Todas las universidades han sido seleccionadas';
        }
        if(isset($request->todas_las_areas)) {
            $mensaje .= 'Todas las disciplinas han sido seleccionadas';
        }

        $ids_disciplinas = [];

        foreach($disciplinas as $codigo) {
            $disciplina = Disciplina::buscarPorCodigo($codigo)->first();

            if(!empty($disciplina)) {
                $ids_disciplinas[] = $disciplina->id;
            }
        }

        // $casos_encontrados = [];
        $casos_encontrados = Entrevista::whereIn('codigo_universidad', $universidades)
                                ->whereIn('codigo_disciplina', $ids_disciplinas)
                                ->get();


        dd($casos_encontrados);
        // dd($request->all());

        // return view('reportes.reporte_filtrado');
    }
}
