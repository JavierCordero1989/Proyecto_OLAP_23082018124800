<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactoGraduado;
use App\EncuestaGraduado;
use App\DetalleContacto;
use Carbon\Carbon;
use Flash;
use DB;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class ContactosController extends Controller
{
    /**
     * @param $id_encuesta ID de la encuesta a la que pertenece el contacto.
     * @param $id_contacto ID del contacto a editar.
     * @return View Vista con los del contacto encontrada por el ID.
     * 
     * Permite mostrar la vista para editar un contacto, y actualizar la información
     * de dicho contacto.
     */
    public function editar_contacto_get($id_encuesta, $id_contacto) {
        $entrevista = EncuestaGraduado::find($id_encuesta);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto que seleccionó.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }

        return view('contactos.editar-contacto')->with('contacto', $contacto)->with('entrevista', $entrevista);
    } // Cierre de la función editar_contacto_get.

    /**
     * @param $id_encuesta ID de la encuesta a la que pertenece el contacto.
     * @param $id_contacto ID del contacto a editar.
     * @param $request Datos nuevos del contacto que se ha editado.
     * 
     * Actualiza los datos del contacto con la información brindada por el formulario.
     */
    public function editar_contacto_post($id_encuesta, $id_contacto, Request $request) {
        $entrevista = EncuestaGraduado::find($id_encuesta);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto que seleccionó.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }

        try {
            DB::beginTransaction();

            $temp = $contacto;

            if(isset($request->identificacion_referencia)) {
                $contacto->identificacion_referencia = $request->identificacion_referencia;
            }
            if(isset($request->nombre_referencia)) {
                $contacto->nombre_referencia = $request->nombre_referencia;
            }
            if(isset($request->parentezco)) {
                $contacto->parentezco = $request->parentezco;
            }
    
            $actualizo = $contacto->save();
    
            if($actualizo) {
                // Guardar el registro en la bitacora
                $bitacora = [
                    'transaccion'            =>'U',
                    'tabla'                  =>'tbl_contactos_graduados',
                    'id_registro_afectado'   =>$contacto->id,
                    'dato_original'          =>$temp->__toString(),
                    'dato_nuevo'             =>$contacto->__toString(),
                    'fecha_hora_transaccion' =>Carbon::now(),
                    'id_usuario'             =>Auth::user()->user_code,
                    'created_at'             =>Carbon::now()
                ];
        
                DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

                DB::commit();

                Flash::success('La información ha sido actualizada correctamente.');
                return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
            }
            else {
                DB::rollback();

                Flash::warning('Ha ocurrido un error y no se ha podido actualizar la información. Revise su conexión a internet o contacte al administrador');
                return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
            }
        }
        catch(\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: editar_contacto_post().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }
    } // Cierre de la función editar_contacto_post.

    /**
     * @param $id_entrevista ID de la entrevista a la que se le va  asignar el contacto.
     * 
     * Muestra la vista con los espacios necesarios de los datos a guardar para el contacto nuevo de la entrevista.
     * Verifica antes que la entrevista existe mediante el ID recibido por parámetros.
     */
    public function guardar_contacto_get($id_entrevista) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        return view('contactos.agregar-contacto')->with('entrevista', $entrevista);
    } // Cierre de la función guardar_contacto_get.

    /**
     * @param $id_entrevista ID de la entrevista a la que se le va  asignar el contacto.
     * @param $request Datos agregados del formulario.
     * 
     * Agrega el contacto a los registros de la base de datos, a la entrevista recibida por ID.
     */
    public function guardar_contacto_post($id_entrevista, Request $request) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        /* TRY-CATCH PARA EVITAR ERRORES AL GUARDAR EN LA BASE DE DATOS. */
        try {
            DB::beginTransaction();

            $data = [
                'identificacion_referencia' => $request->identificacion_referencia,
                'nombre_referencia'         => $request->nombre_referencia,
                'parentezco'                => $request->parentezco,
                'id_graduado'               => $entrevista->id
            ];

            $contacto = ContactoGraduado::create($data);

            $data = [
                'contacto'             => $request->informacion_contacto,
                'observacion'          => $request->observacion_contacto,
                'estado'               => 'F',
                'id_contacto_graduado' => $contacto->id
            ];

            $detalle = DetalleContacto::create($data);

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

            Flash::success('Se ha agregado la información correctamente.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $id_entrevista));
        }
        catch(\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: guardar_contacto_post().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestas-graduados.administrar-contactos-get', $id_entrevista));
        }
    } // Cierre de la función guardar_contacto_post.

    /**
     * @param $id_entrevista ID de la encuesta a la que pertenece el contacto.
     * @param $id_contacto   ID del contacto a editar.
     * @return View Vista con los del contacto encontrada por el ID.
     * 
     * Permite mostrar la vista para agregar un contacto, y actualizar la información
     * de dicho contacto.
     */
    public function guardar_detalle_contacto_get($id_entrevista, $id_contacto) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto que seleccionó.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }

        return view('contactos.agregar-detalle-contacto', compact('entrevista', 'contacto'));
    } // Cierre de la función guardar_detalle_contacto_get.

    /**
     * @param $id_entrevista ID de la entrevista a la que pertenece el contacto.
     * @param $id_contacto   ID del contacto al cual se le agrega el detalle.
     * @param $request       Datos del formulario a guardar.
     * 
     * Guarda el detalle del contacto con los datos proporcionados por el formulario de la vista.
     */
    public function guardar_detalle_contacto_post($id_entrevista, $id_contacto, Request $request) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto que seleccionó.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }

        try {
            DB::beginTransaction();
        
            $data = [
                'contacto'             => $request->contacto,
                'observacion'          => $request->observacion,
                'estado'               => 'F',
                'id_contacto_graduado' => $contacto->id
            ];
    
            $detalle = DetalleContacto::create($data);

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
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

            Flash::success('Se ha agregado la información correctamente.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $id_entrevista));
        }
        catch(\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: guardar_detalle_contacto_post().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestas-graduados.administrar-contactos-get', $id_entrevista));
        }
    } // Cierre de la función guardar_detalle_contacto_post.

    /**
     * @param $id_entrevista ID de la entrevista a la que le pertence el contacto.
     * @param $id_detalle    ID del detalle que se desea modificar.
     * 
     * Muestra la vista para editar los datos encontrados del detalle del contacto.
     */
    public function editar_detalle_contacto_get($id_entrevista, $id_detalle) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        $detalle = DetalleContacto::find($id_detalle);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el contacto que seleccionó.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }

        return view('contactos.editar-detalle-contacto', compact('entrevista', 'detalle'));
    } // Cierre de la función editar_detalle_contacto_get.

    /**
     * @param $id_entrevista ID de la entrevista a la que pertenece el contacto.
     * @param $id_detalle    ID del detalle del contacto a editar.
     * @param $request       Información proveniente del formulario.
     * 
     * Actualiza la información del detalle del contacto, modificando los datos que se enviaron por el formulario.
     */
    public function editar_detalle_contacto_post($id_entrevista, $id_detalle, Request $request) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista.');
            return redirect(route('encuestas-graduados.index'));
        }

        $detalle = DetalleContacto::find($id_detalle);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el contacto que seleccionó.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $entrevista->id));
        }

        try {
            DB::beginTransaction();
        
            $temp = $detalle;

            /* se actualiza el registro de detalle encontrado. */
            $detalle->contacto = $request->contacto;
            $detalle->observacion = $request->observacion;
            $detalle->estado = $request->estado;
            $detalle->save();

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_detalle_contacto',
                'id_registro_afectado'   =>$detalle->id,
                'dato_original'          =>$temp->__toString(),
                'dato_nuevo'             =>$detalle->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('Se ha actualizado la información correctamente.');
            return redirect(route('encuestas-graduados.administrar-contactos-get', $id_entrevista));
        }
        catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: editar_detalle_contacto_post().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestas-graduados.administrar-contactos-get', $id_entrevista));
        }
    } // Cierre de la función editar_detalle_contacto_post.
}
