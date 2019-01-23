<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\ObservacionesGraduado;
use Illuminate\Http\Request;
use App\EncuestaGraduado;
use App\ContactoGraduado;
use App\DetalleContacto;
use Carbon\Carbon;
use Faker\Factory;
use Flash;
use DB;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
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
        
        $estados = DB::table('tbl_estados_encuestas')->whereNotIn('estado', ['NO ASIGNADA', 'ASIGNADA', 'EXTRANJERO', 'OTRO'])->get()->pluck('estado', 'id');

        return view('vistas-encuestador.realizar-entrevista', compact('entrevista', 'estados'));
    }

    public function actualizar_entrevista($id_entrevista, Request $request) {

        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
        }

        try {
            DB::beginTransaction();

            $temp = $entrevista->__toString();

            //Cambiar el estado de la entrevista por el del request
            $cambio_estado = $entrevista->cambiarEstadoDeEncuesta($request->estados);
    
            if(!$cambio_estado) {
                DB::rollback();

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
                    DB::rollback();

                    Flash::error('No se ha podido agregar la observación a la entrevista');
                    return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
                }
            }
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_graduados',
                'id_registro_afectado'   =>$entrevista->id,
                'dato_original'          =>$temp,
                'dato_nuevo'             =>$entrevista->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('Se han guardado correctamente los cambios');
            return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
        }
        catch(\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: actualizar_entrevista().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestador.mis-entrevistas', Auth::user()->id));
        }
    }

    public function agregar_contacto($id_entrevista) {
        return view('vistas-encuestador.agregar-contacto-entrevista')->with('id_entrevista', $id_entrevista);
    }

    public function guardar_contacto($id_entrevista, $id_encuestador, Request $request) {
        try {
            DB::beginTransaction();

            $contacto = ContactoGraduado::create([
                'identificacion_referencia' => $request->identificacion_referencia,
                'nombre_referencia'         => $request->nombre_referencia,
                'parentezco'                => $request->parentezco,
                'id_graduado'               => $id_entrevista,
                'created_at'                => Carbon::now()
            ]);
    
            $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_contactos_graduados',
                'id_registro_afectado'   =>$contacto->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>$contacto->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('Se ha guardado correctamente la nueva información de contacto.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }
        catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: guardar_contacto().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }
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

        try {
            DB::beginTransaction();

            $temp = $contacto->__toString();

            $contacto->agregarDetalle($request->contacto, $request->observacion);

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_detalle_contacto',
                'id_registro_afectado'   =>$contacto->id,
                'dato_original'          =>$temp,
                'dato_nuevo'             =>$contacto->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('Se ha agregado información al contacto correctamente.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        } catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: guardar_detalle_contacto().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }
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

        try {
            DB::beginTransaction();

            $temp = $detalle->__toString();

            $detalle->contacto = $request->contacto;
            $detalle->observacion = $request->observacion;
            $detalle->updated_at = Carbon::now();
            $detalle->save();

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_detalle_contacto',
                'id_registro_afectado'   =>$detalle->id,
                'dato_original'          =>$temp,
                'dato_nuevo'             =>$detalle->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();
            
            Flash::success('La información del contacto se ha modificado correctamente.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        } catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: actualizar_detalle_contacto().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }
    }

    public function borrar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }

        try {
            DB::beginTransaction();

            $detalle->estado = 'E';
            $detalle->deleted_at = Carbon::now();
            $detalle->save();

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'D',
                'tabla'                  =>'tbl_detalle_contacto',
                'id_registro_afectado'   =>$detalle->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>$detalle->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('La información del contacto se ha eliminado.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        } catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: borrar_detalle_contacto().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }
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

        try {
            DB::beginTransaction();

            $temp = $contacto->__toString();

            $contacto->identificacion_referencia = $request->identificacion_referencia;
            $contacto->nombre_referencia = $request->nombre_referencia;
            $contacto->parentezco = $request->parentezco;
            $contacto->updated_at = Carbon::now();
            $contacto->save();

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_contactos_graduados',
                'id_registro_afectado'   =>$contacto->id,
                'dato_original'          =>$temp,
                'dato_nuevo'             =>$contacto->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('El contacto ha sido actualizado correctamente.');
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        } catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: actualizar_contacto_entrevista().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestador.realizar-entrevista', $id_entrevista));
        }
    }

    public function reportes_de_encuestador($id_encuestador) {
        $datosObtenidos = EncuestaGraduado::totalEntrevistasPorEstadoPorEncuestador($id_encuestador)->get();

        $etiquetas = []; //Arreglo para las etiquetas de los gráficos
        $datos = []; //Arreglo para los datos numéricos para los gráficos
        $colores_conare = config('global.colores.conare');
        $colores = []; //Arreglo para los colores de las partes del gráfico
        $faker = Factory::create('es_ES'); //Faker para generar datos aleatorios

        //Recorre la consulta obtenida
        foreach($datosObtenidos as $dato) {
            $etiquetas[] = $dato->ESTADO; //Guarda el estado en el arreglo
            $datos[] = $dato->TOTAL; //Guardar el total en el arreglo
            $colores[] = $faker->randomElement($colores_conare); //Guarda un color aleatorio
        }

        //Llama la vista y le pasa los datos.
        return view('vistas-encuestador.reportes-encuestador', compact('etiquetas', 'datos', 'colores'));
    }

    public function indicador_otras_carreras($ids) {
        $ids = explode('-', $ids);
        
        $encuestas = EncuestaGraduado::whereIn('id', $ids)->orderBy('identificacion_graduado', 'ASC')->paginate(25);

        return view('vistas-encuestador.lista-entrevistas')->with('encuestas', $encuestas);
    }
}
