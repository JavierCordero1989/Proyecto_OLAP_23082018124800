<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;
use App\Area;
use App\Agrupacion;

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
        //Se obtiene la cantidad de entrevistas asignadas
        $total_encuestas_asignadas = Entrevista::totalEntrevistasAsignadas()->count();
        //Se obtiene el total de entrevistas almacenadas
        $total_de_encuestas = Entrevista::totalDeEncuestas();

        $estados_temp = Entrevista::totalesPorEstado()->get();

        $estados = [];

        foreach($estados_temp as $key => $value) {
            $estados[$value->estado] = $value->total;
        }

        $estados['TOTAL DE ENTREVISTAS'] = Entrevista::totalDeEncuestas();

        return view('home', compact('estados'));
    }

    public function reportes_generales() {

        $ids_areas = Area::pluck('descriptivo', 'id');
        $data_areas = array();

        foreach ($ids_areas as $id => $descriptivo) {
            $total_area = Entrevista::totalAsignadasPorArea($id)->count();
            $completas_area = Entrevista::totalCompletasPorArea($id)->count();
            // $porcentaje_area = round(($completas_area / $total_area) * 100, 2);
            $porcentaje_area = $this->obtenerPorcentaje($completas_area, $total_area);

            
            $data_areas[$descriptivo] = array(
                'asignadas'=>$total_area,
                'completas'=>$completas_area,
                'respuesta'=>$porcentaje_area
            );
        }

        $data_general = array();

        $entrevistasAsignadas = Entrevista::totalEntrevistasAsignadas()->count();
        $entrevistasCompletas = Entrevista::totalEntrevistasCompletas()->count();
        // $porcentaje_respuesta_completas = round( ($entrevistasCompletas/$entrevistasAsignadas) * 100, 2 );
        $porcentaje_respuesta_completas = $this->obtenerPorcentaje($entrevistasCompletas, $entrevistasAsignadas);
        //guardar esta mierda en algún lugar

        $data_general = array(
            'asignadas'=>$entrevistasAsignadas,
            'completas'=>$entrevistasCompletas,
            'respuesta'=>$porcentaje_respuesta_completas
        );

        $agrupaciones = Agrupacion::allData()->pluck('nombre', 'id');
        $data_agrupaciones = array();

        foreach ($agrupaciones as $id => $nombre) {
            $total_agrupacion = Entrevista::totalAsignadasPorAgrupacion($id)->count();
            $completas_agrupacion = Entrevista::totalCompletasPorAgrupacion($id)->count();
            $porcentaje_agrupacion = $this->obtenerPorcentaje($completas_agrupacion, $total_agrupacion);
            
            $data_agrupaciones[$nombre] = array(
                'asignadas'=>$total_agrupacion,
                'completas'=>$completas_agrupacion,
                'respuesta'=>$porcentaje_agrupacion
            );
        }

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
}
