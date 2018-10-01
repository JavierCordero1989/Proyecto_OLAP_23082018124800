<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\ObservacionesGraduado;
use App\DatosCarreraGraduado;
use Illuminate\Http\Request;
use App\TiposDatosCarrera;
use App\EncuestaGraduado;
use App\ContactoGraduado;
use App\DetalleContacto;
use App\Asignacion;
use App\Disciplina;
use Carbon\Carbon;
use App\Area;
use App\User;
use Flash;
use DB;

class EncuestaGraduadoController extends Controller
{
    public function index() {
        $encuestas = EncuestaGraduado::listaDeGraduados()->orderBy('id', 'ASC')->paginate(25);

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
        $id_carrera =       TiposDatosCarrera::carrera()->first();
        $id_universidad =   TiposDatosCarrera::universidad()->first();
        $id_grado =         TiposDatosCarrera::grado()->first();
        // $id_disciplina =    TiposDatosCarrera::disciplina()->first();
        // $id_area =          TiposDatosCarrera::area()->first();
        $id_agrupacion =    TiposDatosCarrera::agrupacion()->first();
        $id_sector =        TiposDatosCarrera::sector()->first();

        $carreras =      DatosCarreraGraduado::where('id_tipo', $id_carrera->id)     ->pluck('nombre', 'id');
        $universidades = DatosCarreraGraduado::where('id_tipo', $id_universidad->id) ->pluck('nombre', 'id');
        $grados =        DatosCarreraGraduado::where('id_tipo', $id_grado->id)       ->pluck('nombre', 'id');
        // $disciplinas =   DatosCarreraGraduado::where('id_tipo', $id_disciplina->id)  ->pluck('nombre', 'id');
        $disciplinas =   Disciplina::pluck('descriptivo', 'id')->all();
        // $areas =         DatosCarreraGraduado::where('id_tipo', $id_area->id)        ->pluck('nombre', 'id');
        $areas =         Area::pluck('descriptivo', 'id')->all();
        $agrupaciones =  DatosCarreraGraduado::where('id_tipo', $id_agrupacion->id)  ->pluck('nombre', 'id');
        $sectores =      DatosCarreraGraduado::where('id_tipo', $id_sector->id)      ->pluck('nombre', 'id');

        $datos_carrera = [
            'carreras' => $carreras,
            'universidades' => $universidades,
            'grados' => $grados,
            'disciplinas' => $disciplinas,
            'areas' => $areas,
            'agrupaciones' => $agrupaciones,
            'sectores' => $sectores
        ];

        return view('encuestadores.lista-filtro-encuestas', 
            compact('id_supervisor', 'id_encuestador', 'datos_carrera'));
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
        $encuestador = User::find($id_encuestador);

        return view('encuestadores.tabla-encuestas-asignadas', compact('listaDeEncuestas', 'encuestador'));
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

        if(!is_null($input['agrupacion'])) {
            $resultado->where('codigo_agrupacion', $input['agrupacion']);
        }

        if(!is_null($input['sector'])) {
            $resultado->where('codigo_sector', $input['sector']);
        }

        $encuestasNoAsignadas = $resultado->get();

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

    public function remover_encuestas_a_encuestador($id_entrevista, $id_encuestador) {
        $entrevista = EncuestaGraduado::find($id_entrevista);
        $quito_entrevista = $entrevista->desasignarEntrevista();
        
        if($quito_entrevista) {
            Flash::success('Se ha eliminado la entrevista de este encuestador');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador));
        }
        else {
            Flash::error('No se ha podido eliminar la entrevista de este encuestador');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador));
        }
    }

    public function realizar_entrevista($id_entrevista) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', Auth::user()->id));
        }
        
        $estados = DB::table('tbl_estados_encuestas')->get()->pluck('estado', 'id');

        return view('encuestadores.realizar-entrevista', compact('entrevista', 'estados'));
    }

    public function agregar_contacto($id_entrevista) {
        return view('encuestadores.agregar-contacto-entrevista')->with('id_entrevista', $id_entrevista);
    }

    public function actualizar_entrevista($id_entrevista, Request $request) {
        // dd($request->all());

        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', Auth::user()->id));
        }

        //Cambiar el estado de la entrevista por el del request
        $cambio_estado = $entrevista->cambiarEstadoDeEncuesta($request->estados);

        if(!$cambio_estado) {
            Flash::error('No se ha podido cambiar el estado de la entrevista');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        //si no existen observaciones, agregarla, de lo contrario modificar la existente.
        $observaciones_entrevista = $entrevista->observaciones;

        if(sizeof($observaciones_entrevista) == 0) {
            //Agregar la observación
            $nueva_observacion = ObservacionesGraduado::create([
                'id_graduado' => $entrevista->id,
                'id_usuario' => Auth::user()->id,
                'observacion' => $request->observacion,
                'created_at' => Carbon::now()
            ]);
        }
        else {
            //Modificar la existente
            $observacion_existente = ObservacionesGraduado::where('id_graduado', $entrevista->id)->first();
            $observacion_existente->observacion = $request->observacion;
            $observacion_existente->updated_at = Carbon::now();
            $cambio_observacion = $observacion_existente->save();

            if(!$cambio_observacion) {
                Flash::error('No se ha podido agregar la observación a la entrevista');
                return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
            }
        }

        Flash::success('Se han guardado correctamente los cambios');
        return redirect(route('asignar-encuestas.lista-encuestas-asignadas', Auth::user()->id));
    }

    public function agregar_detalle_contacto($id_contacto, $id_entrevista) {
        return view('encuestador.agregar-detalle-contacto', compact('id_contacto', 'id_entrevista'));
    }

    public function borrar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $detalle->deleted_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha eliminado.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function editar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        return view('encuestadores.editar-detalle-contacto', compact('detalle', 'id_entrevista'));
    }

    public function editar_contacto_entrevista($id_contacto, $id_entrevista) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        return view('encuestadores.modificar-contacto-entrevista', compact('contacto', 'id_entrevista'));
    }

    public function guardar_contacto($id_entrevista, $id_supervisor, Request $request) {
        
        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            'parentezco'                => $request->parentezco,
            'id_graduado'               => $id_entrevista,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function guardar_detalle_contacto($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $contacto->agregarDetalle($request->contacto, $request->observacion);

        Flash::success('Se ha agregado información al contacto correctamente.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function actualizar_detalle_contacto($id_detalle_contacto, $id_entrevista, Request $request) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $detalle->contacto = $request->contacto;
        $detalle->observacion = $request->observacion;
        $detalle->updated_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha modificado correctamente.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function actualizar_contacto_entrevista($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $contacto->identificacion_referencia = $request->identificacion_referencia;
        $contacto->nombre_referencia = $request->nombre_referencia;
        $contacto->parentezco = $request->parentezco;
        $contacto->updated_at = Carbon::now();
        $contacto->save();

        Flash::success('El contacto ha sido actualizado correctamente.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }
}