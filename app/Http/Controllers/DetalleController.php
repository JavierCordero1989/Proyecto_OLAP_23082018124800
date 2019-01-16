<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\ContactoGraduado;
use App\DetalleContacto;
use Carbon\Carbon;
use Flash;
use DB;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class DetalleController extends Controller
{
    public function create($id) {
        return view('detalles_contactos.create')->with('id_contacto', $id);
    }

    public function store($id, Request $request) {
        $contacto = ContactoGraduado::find($id);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        try {
            DB::beginTransaction();

            $contacto->agregarDetalle($request->contacto, $request->observacion);
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_detalle_contacto',
                'id_registro_afectado'   =>$contacto->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>$contacto->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('Se ha agregado información al contacto correctamente.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }
        catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: store().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }
    }

    public function edit($id) {
        $detalle = DetalleContacto::find($id);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        return view('detalles_contactos.edit', compact('detalle'));
    }

    public function update($id, Request $request) {
        $detalle = DetalleContacto::find($id);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        try {
            DB::beginTransaction();

            $temp = $detalle;

            $detalle->contacto = $request->contacto;
            $detalle->observacion = $request->observacion;
            $detalle->updated_at = Carbon::now();
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
    
            Flash::success('La información del contacto se ha modificado correctamente.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }
        catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: update().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

    }

    public function destroy($id) {
        $detalle = DetalleContacto::find($id);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }

        try {
            DB::beginTransaction();

            $detalle->deleted_at = Carbon::now();
            $detalle->save();
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'D',
                'tabla'                  =>'tbl_detalle_contacto',
                'id_registro_afectado'   =>$detalle->id,
                'dato_original'          =>$detalle->__toString(),
                'dato_nuevo'             =>null,
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            Flash::success('La información del contacto se ha eliminado.');
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }
        catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: destroy().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('encuestadores.lista-de-encuestas', Auth::user()->id));
        }
    }
}
