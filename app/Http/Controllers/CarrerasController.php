<?php

namespace App\Http\Controllers;

use App\DatosCarreraGraduado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Flash;
use DB;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class CarrerasController extends Controller
{
    public function index() {
        $carreras = DatosCarreraGraduado::porCarrera()->get();

        return view('carreras.index')->with('carreras', $carreras);
    }

    public function create() {
        return view('carreras.create');
    }

    public function store(Request $request) {

        try {
            DB::beginTransaction();

            $id_tipo = \App\TiposDatosCarrera::carrera()->first()->id;
    
            $input = $request->all();
    
            $nueva_carrera = DatosCarreraGraduado::create([
                'codigo' => $input['codigo'],
                'nombre' => $input['nombre'],
                'id_tipo' => $id_tipo
            ]);
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_datos_carrera_graduado',
                'id_registro_afectado'   =>$nueva_carrera->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>'Carrera nueva agregada: ' . $nueva_carrera->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Mensaje de exito que se carga en la vista. */
            Flash::success('Se ha guardado la carrera satisfactoriamente.');
            /** Se direcciona a la ruta del index, para volver a cargar los datos. */
            return redirect(route('carreras.index'));
        } catch(\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: store().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('carreras.index'));
        }
    }

    public function show($id) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        return view('carreras.show', compact('carrera'));
    }

    public function edit($id) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        return view('carreras.edit', compact('carrera'));
    }

    public function update($id, Request $request) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        try {
            DB::beginTransaction();

            $temp = $carrera;

            $carrera->codigo = $request->codigo;
            $carrera->nombre = $request->nombre;
            $carrera->save();
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_datos_carrera_graduado',
                'id_registro_afectado'   =>$carrera->id,
                'dato_original'          =>$temp->__toString(),
                'dato_nuevo'             =>$carrera->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Se genera un mensaje de exito y se redirige a la ruta index */
            Flash::success('Se ha modificado la carrera satisfactoriamente.');
            return redirect(route('carreras.index'));

        } catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: update().<br>Línea: ';
            $mensaje .= $ex->getLine();
            $mensaje .= '<br><br>Este error se debe al estado de la entrevista que se consultó por token.';

            Flash::error($mensaje);
            return redirect(route('carreras.index'));
        }
    }

    public function destroy($id) {
        $carrera = DatosCarreraGraduado::find($id);

        if(empty($carrera)) {
            Flash::error('Carrera no encontrada');
            return redirect(route('carreras.index'));
        }

        /* VALIDA QUE LA CARRERA NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($carrera->graduadoCarrera) > 0) {
            Flash::error('No es posible eliminar esta carrera debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('carreras.index'));
        }
        
        try {
            DB::beginTransaction();

            /** Se borra el objeto encontrado */
            $carrera->deleted_at = \Carbon\Carbon::now();
            $carrera->save();
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'D',
                'tabla'                  =>'tbl_datos_carrera_graduado',
                'id_registro_afectado'   =>$carrera->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>'La siguiente carrera fue eliminada: '.$carrera->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Se genera un mensaje de exito y se redirige a la ruta index */
            Flash::success('Se ha eliminado la carrera '.$carrera->nombre.' correctamente.');
            return redirect(route('carreras.index'));

        } catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: destroy().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('carreras.index'));
        }
    }
}
