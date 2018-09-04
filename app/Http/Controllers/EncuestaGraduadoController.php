<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EncuestaGraduado;
use App\User;
use App\DatosCarreraGraduado;
use DB;
use Flash;
use App\Asignacion;
use App\ContactoGraduado;

class EncuestaGraduadoController extends Controller
{
    public function index() {
        $encuestas = EncuestaGraduado::listaDeGraduados()->get();

        return view('encuestas_graduados.index', compact('encuestas'));
    }

    public function agregarContacto($id_encuesta) {
        return view('encuestas_graduados.agregar-contacto')->with('id_encuesta', $id_encuesta);
    }

    public function guardarContacto($id_encuesta, Request $request) {

        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            'informacion_contacto'      => $request->informacion_contacto,
            'observacion_contacto'      => $request->observacion_contacto,
            'id_graduado'               => $id_encuesta,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('encuestas-graduados.index'));
    }

    /** Obtiene todos los datos existentes por carrera, universidad, grado, disciplina y area,
     * para poder mostrarlos en un combobox para que el encargado de asignar asl encuestas
     * pueda seleccionar todos los filtros adecuados.
    */
    public function asignar($id_supervisor, $id_encuestador) {
        // $encuestasNoAsignadas = EncuestaGraduado::listaDeEncuestasSinAsignar()->get();

        $carreras = DatosCarreraGraduado::where('id_tipo', 1)       ->pluck('nombre', 'id');
        $universidades = DatosCarreraGraduado::where('id_tipo', 2)  ->pluck('nombre', 'id');
        $grados = DatosCarreraGraduado::where('id_tipo', 3)         ->pluck('nombre', 'id');
        $disciplinas = DatosCarreraGraduado::where('id_tipo', 4)    ->pluck('nombre', 'id');
        $areas = DatosCarreraGraduado::where('id_tipo', 5)          ->pluck('nombre', 'id');

        return view('encuestadores.lista-filtro-encuestas', 
            compact('id_supervisor', 'id_encuestador','carreras', 'universidades', 'grados', 'disciplinas', 'areas'));
    }

    /** Recibe las encuestas seleccionadas por la persona que realiza la asignacion, y realiza algunas
     * validaciones. Primero comprueba que el supervisor que realizó la asignación exista en la base de datos,
     * luego que el encuestador también exista. Después busca los estados NO ASIGNADA y ASIGNADA para 
     * cambiar el estado de las encuestas de uno a otra.
     */
    public function crearAsignacion($id_supervisor, $id_encuestador, Request $request) {

        /** Se obtiene el supervisor por el ID */
        $supervisor = User::find($id_supervisor);

        /** Si el supervisor no se encuentra en la BD */
        if(empty($supervisor)) {
            Flash::error('El supervisor con el ID '.$id_supervisor.' no existe');
            return redirect(route('encuestadores.index'));
        }

        /** Se obtiene el encuestador por el ID */
        $encuestador = User::find($id_encuestador);

        /** Si el encuestador no se encuentra en la BD */
        if(empty($encuestador)) {
            Flash::error('El encuestador con el ID '.$id_encuestador.' no existe');
            return redirect(route('encuestadores.index'));
        }

        /** Se consulta si el estado 'NO ASIGNADA' existe en la base de datos */
        $id_estado_sin_asignar = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        /** Mensaje en caso de que el estado NO ASIGNADA no exista */
        if(is_null($id_estado_sin_asignar)) {
            Flash::error('El estado \"NO ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('encuestadores.index'));
        }

        /** Se consulta si el estado 'ASIGNADA' existe en la base de datos */
        $id_estado_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'ASIGNADA')->first();

        /** Mensaje en caso de que el estado ASIGNADA no exista */
        if(is_null($id_estado_asignada)) {
            Flash::error('El estado \"ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('encuestadores.index'));
        }

        $encuestas_no_encontradas = [];

        /** Se hace una busqueda de la encuesta */
        foreach($request->encuestas as $id_graduado) {
            $registro_encuesta = EncuestaGraduado::find($id_graduado);

            if(empty($registro_encuesta)) {
                array_push($encuestas_no_encontradas, $id_graduado);
            }

            $update = $registro_encuesta->asignarEncuesta($id_supervisor, $id_encuestador, $id_estado_sin_asignar->id, $id_estado_asignada->id);
        }

        if(sizeof($encuestas_no_encontradas) <= 0) {
            Flash::success('Se han asignado las encuestas correctamente.');
        }
        else {
            Flash::warning('Algunas encuestas no han sido asignadas: '.$encuestas_no_encontradas);
        }

        return redirect(route('encuestadores.index'));
    }

    public function encuestasAsignadasPorEncuestador($id_encuestador) {
        $listaDeEncuestas = EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_encuestador)->get();

        return view('encuestadores.tabla-encuestas-asignadas', compact('listaDeEncuestas', 'id_encuestador'));
    }

    /** Permite obtenet todas las encuestas que tienen por estado NO ASIGNADA, mediante los filtros
     * que el usuario haya agregado en la vista.
     */
    public function filtrar_muestra_a_asignar($id_supervisor, $id_encuestador, Request $request) {
        $input = $request->all();

        $resultado = EncuestaGraduado::listaDeEncuestasSinAsignar();

        if(!is_null($input['carrera'])) {
            $resultado->where('codigo_carrera', $input['carrera']);
        }

        if(!is_null($input['universidad'])) {
            $resultado->where('codigo_universidad', $input['universidad']);
        }

        if(!is_null($input['grado'])) {
            $resultado->where('codigo_grado', $input['grado']);
        }

        if(!is_null($input['disciplina'])) {
            $resultado->where('codigo_disciplina', $input['disciplina']);
        }

        if(!is_null($input['area'])) {
            $resultado->where('codigo_area', $input['area']);
        }

        $encuestasNoAsignadas = $resultado->get();

        // dd($encuestasNoAsignadas);

        return view('encuestadores.tabla-encuestas-no-asignadas', compact('encuestasNoAsignadas', 'id_supervisor', 'id_encuestador'));
    }

    public function removerEncuestas($id_encuestador, Request $request) {

        $encuestasAsignadas = Asignacion::where('id_encuestador', $id_encuestador)->get();
        $id_no_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        foreach($encuestasAsignadas as $encuesta) {
            // echo 'Encuesta: '.$encuesta->id.'<br>';
            foreach($request->encuestas as $id_desasignada) {
                if($encuesta->id_graduado == $id_desasignada) {
                    $encuesta->id_encuestador = null;
                    $encuesta->id_supervisor = null;
                    $encuesta->id_estado = $id_no_asignada->id;
                    $encuesta->updated_at = \Carbon\Carbon::now();
                    $encuesta->save();
                }
            }
        }

        Flash::success('Se han eliminado las encuestas de este encuestador');
        return redirect(route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador));
    }
}