<?php

namespace App\Http\Controllers;

use App\DatosCarreraGraduado;
use Illuminate\Http\Request;
use App\Disciplina;
use Carbon\Carbon;
use App\Area;
use Flash;
use DB;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class DisciplinasController extends Controller
{
    public function disciplinasPorAreaAxios($id) {

        $areas = Area::whereIn('id', explode(',', $id))->get();

        $disciplinas = array();

        foreach($areas as $area) {
            $array_areas_por_disciplina = array();
            $temp_disciplinas = array();

            foreach ($area->disciplinas as $key => $value) {
                $dis = array();
                $dis['id'] = $value->id;
                $dis['nombre'] = $value->descriptivo;
                $temp_disciplinas[] = $dis;
            }


            $array_areas_por_disciplina[$area->id] = $area->descriptivo;
            $array_areas_por_disciplina['disciplinas'] = $temp_disciplinas;
            // $disciplinas[] = $array_areas_por_disciplina;
            $disciplinas[$area->descriptivo] = $temp_disciplinas;
        }

        // dd($disciplinas);
        return $disciplinas;
    }

    public function index() {
        $disciplinas = Disciplina::all();

        return view('disciplinas.index')->with('disciplinas', $disciplinas);
    }

    public function create() {
        return view('disciplinas.create');
    }

    public function store(Request $request) {
        $disciplina = Disciplina::where('codigo', $request->codigo)->whereNull('deleted_at')->first();

        if(!empty($disciplina)) {
            Flash::error('El código de la disciplina que intenta registrar, ya se encuentra en uso.');
            return redirect(route('disciplinas.index'));
        }

        try {
            DB::beginTransaction();

            // TODO: falta agregar el area a la que pertenece la disciplina
            $disciplina = Disciplina::create([
                'codigo' => $request->codigo,
                'descriptivo' => $request->nombre,
                'id_area' => $request->id_area
            ]);
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_disciplinas',
                'id_registro_afectado'   =>$disciplina->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>$disciplina->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Mensaje de exito que se carga en la vista. */
            Flash::success('Se ha guardado la disciplina satisfactoriamente.');
            /** Se direcciona a la ruta del index, para volver a cargar los datos. */
            return redirect(route('disciplinas.index'));
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
            return redirect(route('disciplinas.index'));
        }
    }

    public function show($id) {
        $disciplina = Disciplina::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrada');
            return redirect(route('disciplinas.index'));
        }

        return view('disciplinas.show', compact('disciplina'));
    }

    public function edit($id) {
        $disciplina = Disciplina::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrada');
            return redirect(route('disciplinas.index'));
        }

        return view('disciplinas.edit', compact('disciplina'));
    }

    public function update($id, Request $request) {
        $disciplina = Disciplina::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrada');
            return redirect(route('disciplinas.index'));
        }

        try {
            DB::beginTransaction();

            $temp = $disciplina;

            //  TODO: falta agregar el area al formulario
            $disciplina->codigo = $request->codigo;
            $disciplina->descriptivo = $request->nombre;
            $disciplina->id_area = $request->id_area;
            $disciplina->updated_at = Carbon::now();
            $disciplina->save();
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_disciplinas',
                'id_registro_afectado'   =>$disciplina->id,
                'dato_original'          =>$temp->__toString(),
                'dato_nuevo'             =>$disciplina->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Se genera un mensaje de exito y se redirige a la ruta index */
            Flash::success('Se ha modificado la disciplina satisfactoriamente.');
            return redirect(route('disciplinas.index'));
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
            return redirect(route('disciplinas.index'));
        }
    }

    public function destroy($id) {
        $disciplina = Disciplina::find($id);

        if(empty($disciplina)) {
            Flash::error('Disciplina no encontrado');
            return redirect(route('disciplinas.index'));
        }

        /* VALIDA QUE la disciplina NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($disciplina->entrevistas) > 0) {
            Flash::error('No es posible eliminar esta disciplina debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('disciplinas.index'));
        }
        
        try {
            DB::beginTransaction();

            /** Se borra el objeto encontrado */
            $disciplina->deleted_at = Carbon::now();
            $disciplina->save();
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'D',
                'tabla'                  =>'tbl_disciplinas',
                'id_registro_afectado'   =>$disciplina->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>$disciplina->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Se genera un mensaje de exito y se redirige a la ruta index */
            Flash::success('Se ha eliminado la disciplina '.$disciplina->nombre.' correctamente.');
            return redirect(route('disciplinas.index'));
        } catch(\Exception $ex) {
            DB::rollback();
            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: destroy().<br>Línea: ';
            $mensaje .= $ex->getLine();

            Flash::error($mensaje);
            return redirect(route('disciplinas.index'));
        }
    }
}
