<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use App\Area;
use App\Agrupacion;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* se obtienen los reportes generales por estado */
        $reporte = $this->obtenerReportePorEstados();
        /* se agrega un array más con el total de entrevistas */
        $data = array('estado'=>'TOTAL DE ENTREVISTAS', 'total'=>Entrevista::totalDeEncuestas(), 'porcentaje_respuesta'=>0);
        /* el array con los datos será enviado a la vista y renderizado. */
        $reporte[] = $data;

        return view('home', compact('reporte'));
    }

    /* Permite obtener los reportes por área y por agrupación, además de el resultado general de entrevistas*/
    public function reportes_generales() {

        /* Obtiene todos los ids de las áreas junto con su nombre */
        $ids_areas = Area::pluck('descriptivo', 'id');
        $data_areas = array();

        /* Recorre las áreas obtenidas */
        foreach ($ids_areas as $id => $descriptivo) {
            /* Se traen todos los totales por área  */
            $total_area = Entrevista::totalAsignadasPorArea($id)->count();
            /* se obtienen los totales de entrevistas completas, por área. */
            $completas_area = Entrevista::totalCompletasPorArea($id)->count();
            /* se calcula el porcentaje de respuesta, completas entre totales*/
            $porcentaje_area = $this->obtenerPorcentaje($completas_area, $total_area);

            /* Se crea un array con los datos de cada área y se guarda en otro array */
            $data_areas[$descriptivo] = array(
                'asignadas'=>$total_area,
                'completas'=>$completas_area,
                'respuesta'=>$porcentaje_area
            );
        }

        $data_general = array();

        /* Se obtiene el total general de entrevistas */
        $entrevistasAsignadas = Entrevista::totalEntrevistasAsignadas()->count();
        /* se obtiene el total de completas */
        $entrevistasCompletas = Entrevista::totalEntrevistasCompletas()->count();
        /* se calcula el procentaje de respuesta, completas, entre el total. */
        $porcentaje_respuesta_completas = $this->obtenerPorcentaje($entrevistasCompletas, $entrevistasAsignadas);

        $data_general = array(
            'asignadas'=>$entrevistasAsignadas,
            'completas'=>$entrevistasCompletas,
            'respuesta'=>$porcentaje_respuesta_completas
        );

        /* se obtienen todas las agrupaciones por nombre e ID */
        $agrupaciones = Agrupacion::allData()->pluck('nombre', 'id');
        $data_agrupaciones = array();

        /* se recorre el array con las agrupaciones */
        foreach ($agrupaciones as $id => $nombre) {
            /* Se saca el total pro cada agrupacion */
            $total_agrupacion = Entrevista::totalAsignadasPorAgrupacion($id)->count();
            /* se saca el total de completas por cada agrupacion */
            $completas_agrupacion = Entrevista::totalCompletasPorAgrupacion($id)->count();
            /* se saca el porcentaje de respuesta, las completas entre el total. */
            $porcentaje_agrupacion = $this->obtenerPorcentaje($completas_agrupacion, $total_agrupacion);
            
            /* se almacenan los datos en un nuevo array */
            $data_agrupaciones[$nombre] = array(
                'asignadas'=>$total_agrupacion,
                'completas'=>$completas_agrupacion,
                'respuesta'=>$porcentaje_agrupacion
            );
        }

        /* todos los datos obtenidos se guardan en un solo array para enviarlos a la vista. */
        $data = array(
            'general' => $data_general,
            'areas' => $data_areas,
            'agrupaciones' => $data_agrupaciones
        );

        return $data;
    }

    /** Esta función permite calcular el porcentaje de respuesta */
    private function obtenerPorcentaje($asignadas, $completas) {
        if($completas <= 0) {
            return 0;
        }
        else {
            return round( ($asignadas/$completas) * 100, 2 );
        }

    }

    /** Permite obtener los reportes por cada uno de los estados de las entrevistas. */
    private function obtenerReportePorEstados() {
        /* se obtienen los estados por su nombre e ID */
        $estados = DB::table('tbl_estados_encuestas')->orderBy('id')->pluck('estado','id');
        /* se crean dos arrays nuevos para guardar la información */
        $reporte = array();
        $data = array();
        /* se obtiene el total de entrevistas asignadas y el total de encuestas a nivel general. */
        $totalAsignadas = Entrevista::totalEntrevistasAsignadas()->count();
        $totalEncuestas = Entrevista::totalDeEncuestas();
        
        /* se recorre el array de estados */
        foreach ($estados as $key => $value) {
            /* dentro de un array $data, se guarda el estado, el total y el porcentaje de respuesta. */
            $data['estado'] = $value;

            /* Si el estado fuera ASIGNADA, el porcentaje de respuesta se calcula en base a las entrevistas
            asignadas contra el total de encuestas */
            if($value == 'ASIGNADA') {
                $data['total'] = Entrevista::totalEntrevistasAsignadas()->count();
                $data['porcentaje_respuesta'] = $this->obtenerPorcentaje($data['total'], $totalEncuestas);
            }
            /* si el estado es NO ASIGNADA, el porcentaje se calcula del total de encuestas por ese
            estado, entre el total general de encuestas. */
            else if($value == 'NO ASIGNADA') {
                $data['total'] = Entrevista::totalDeEncuestasPorEstado($key)->count();
                $data['porcentaje_respuesta'] = $this->obtenerPorcentaje($data['total'], $totalEncuestas);
            }
            /* de nos ser ninguna de las anteriores, el porcentaje se calculará del total de entrevistas
            por estado, entre el total de asignadas */
            else {
                $data['total'] = Entrevista::totalDeEncuestasPorEstado($key)->count();
                $data['porcentaje_respuesta'] = $this->obtenerPorcentaje($data['total'], $totalAsignadas);
            }
            /* después de los calculos, los datos se guardan en el array de reporte, que será enviado a la vista */
            $reporte[] = $data;
        }
        
        return $reporte;
    } 
}
