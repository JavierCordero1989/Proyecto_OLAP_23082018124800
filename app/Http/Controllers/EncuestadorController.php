<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\EncuestaGraduado;
use App\ContactoGraduado;
use App\DetalleContacto;
use App\ObservacionesGraduado;
use Carbon\Carbon;
use Flash;
use DB;
use Faker\Factory;

class EncuestadorController extends Controller
{
    public function mis_entrevistas($id_encuestador) {
        //cargar la lista de entrevistas del encuestador.
        $mis_entrevistas = EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_encuestador)->get();

        return view('vistas-encuestador.lista-encuestas', compact('mis_entrevistas'));
    }

    public function realizar_entrevista($id_entrevista) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
        }

        // $entrevista->sexo = ($entrevista->sexo == 'M' ? 'MASCULINO' : 'FEMENINO');
        
        $estados = DB::table('tbl_estados_encuestas')->get()->pluck('estado', 'id');

        return view('vistas-encuestador.realizar-entrevista', compact('entrevista', 'estados'));
    }

    public function actualizar_entrevista($id_entrevista, Request $request) {
        // dd($request->all());

        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
        }

        //Cambiar el estado de la entrevista por el del request
        $cambio_estado = $entrevista->cambiarEstadoDeEncuesta($request->estados);

        if(!$cambio_estado) {
            Flash::error('No se ha podido cambiar el estado de la entrevista');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
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
                return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
            }
        }

        Flash::success('Se han guardado correctamente los cambios');
        return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
    }

    public function agregar_contacto($id_entrevista) {
        return view('vistas-encuestador.agregar-contacto-entrevista')->with('id_entrevista', $id_entrevista);
    }

    public function guardar_contacto($id_entrevista, $id_encuestador, Request $request) {
        
        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            'parentezco'                => $request->parentezco,
            'id_graduado'               => $id_entrevista,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
    }

    public function agregar_detalle_contacto($id_contacto, $id_entrevista) {
        return view('vistas-encuestador.agregar-detalle-contacto', compact('id_contacto', 'id_entrevista'));
    }

    public function guardar_detalle_contacto($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }

        $contacto->agregarDetalle($request->contacto, $request->observacion);

        Flash::success('Se ha agregado información al contacto correctamente.');
        return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
    }

    public function editar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }

        return view('vistas-encuestador.editar-detalle-contacto', compact('detalle', 'id_entrevista'));
    }

    public function actualizar_detalle_contacto($id_detalle_contacto, $id_entrevista, Request $request) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }

        $detalle->contacto = $request->contacto;
        $detalle->observacion = $request->observacion;
        $detalle->updated_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha modificado correctamente.');
        return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
    }

    public function borrar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }

        $detalle->deleted_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha eliminado.');
        return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
    }

    public function editar_contacto_entrevista($id_contacto, $id_entrevista) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }

        return view('vistas-encuestador.modificar-contacto-entrevista', compact('contacto', 'id_entrevista'));
    }

    public function actualizar_contacto_entrevista($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }

        $contacto->identificacion_referencia = $request->identificacion_referencia;
        $contacto->nombre_referencia = $request->nombre_referencia;
        $contacto->parentezco = $request->parentezco;
        $contacto->updated_at = Carbon::now();
        $contacto->save();

        Flash::success('El contacto ha sido actualizado correctamente.');
        return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
    }

    public function reportes_de_encuestador($id_encuestador) {
        $datosObtenidos = EncuestaGraduado::totalEntrevistasPorEstadoPorEncuestador($id_encuestador)->get();

        $etiquetas = []; //Arreglo para las etiquetas de los gráficos
        $datos = []; //Arreglo para los datos numéricos para los gráficos
        $colores = []; //Arreglo para los colores de las partes del gráfico
        $faker = Factory::create('es_ES'); //Faker para generar datos aleatorios

        //Recorre la consulta obtenida
        foreach($datosObtenidos as $dato) {
            $etiquetas[] = $dato->ESTADO; //Guarda el estado en el arreglo
            $datos[] = $dato->TOTAL; //Guardar el total en el arreglo
            $colores[] = $faker->hexcolor; //Guarda un color aleatorio
        }

        //Llama la vista y le pasa los datos.
        return view('vistas-encuestador.reportes-encuestador', compact('etiquetas', 'datos', 'colores'));
    }
}
