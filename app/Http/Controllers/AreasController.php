<?php

namespace App\Http\Controllers;

use App\DatosCarreraGraduado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Area;
use Flash;
use DB;

/**
 * @author José Javier Cordero León - Estudiante de la Universidad de Costa Rica - 2018
 * @version 1.0
 */
class AreasController extends Controller
{
    /**
     * Obtiene las áreas de la base de datos
     */
    public function axiosAreas() {
        $areas = Area::pluck('descriptivo', 'id');

        return $areas;
    }

    /**
     * Obtiene todas las áreas de la base de datos, para mostrarlas en una página
     */
    public function index() {
        $areas = Area::all();

        return view('areas.index')->with('areas', $areas);
    }

    /**
     * Muestra la vista para agregar una área nueva
     */
    public function create() {
        return view('areas.create');
    }

    /**
     * @param $request Datos enviados por formulario
     * Guarda una nueva área con los datos enviados por el formulario.
     */
    public function store(Request $request) {
        $area = Area::where('codigo', $request->codigo)->wherenull('deleted_at')->first();

        if(!empty($area)) {
            Flash::error('El área que intenta guardar ya existe con el código que ingresó.');
            return redirect(route('areas.index'));
        }

        try {
            /* se inicia una transacion SQL */
            DB::beginTransaction();

            /* se guardar la nueva area */
            $nueva_area = Area::create([
                'codigo' => $request->codigo,
                'descriptivo' => $request->nombre,
                'created_at' => Carbon::now()
            ]);

            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'I',
                'tabla'                  =>'tbl_areas',
                'id_registro_afectado'   =>$area->id,
                'dato_original'          =>null,
                'dato_nuevo'             =>'Se ha agregado una nueva área. data: {'.$area->__toString().'}',
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Mensaje de exito que se carga en la vista. */
            Flash::success('Se ha guardado el área satisfactoriamente.');
            /** Se direcciona a la ruta del index, para volver a cargar los datos. */
            return redirect(route('areas.index'));
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
            return redirect(route('areas.index'));
        }
    }

    /**
     * @param $id Id del area buscada
     * Muestra una vista con los datos del área con el ID
     * pasado por parámetros. 
     */
    public function show($id) {
        $area = Area::find($id);

        // $area = DatosCarreraGraduado::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        return view('areas.show', compact('area'));
    }

    /**
     * @param $id ID del area a modificar la informacion
     * Muestra una vista para modificar los datos del area especificada por el ID.
     */
    public function edit($id) {
        $area = Area::find($id);

        // $area = DatosCarreraGraduado::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        return view('areas.edit', compact('area'));
    }

    /**
     * @param $id      ID del área a modificar
     * @param $request Datos del formulario
     * Modifica los datos de un área especificada por el ID
     */
    public function update($id, Request $request) {
        $area = Area::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        try {
            DB::beginTransaction();

            /* para manetener los datos viejos */
            $old_area = $area;

            /* se modifican los datos del área */
            $area->codigo = $request->codigo;
            $area->descriptivo = $request->nombre;
            $area->updated_at = Carbon::now();
            $area->save();
            
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'U',
                'tabla'                  =>'tbl_areas',
                'id_registro_afectado'   =>$area->id,
                'dato_original'          =>$old_area->__toString(),
                'dato_nuevo'             =>$area->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Se genera un mensaje de exito y se redirige a la ruta index */
            Flash::success('Se ha modificado el área satisfactoriamente.');
            return redirect(route('areas.index'));

        } catch (\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: update().<br>Línea: ';
            $mensaje .= $ex->getLine();
    
            Flash::error($mensaje);
            return redirect(route('areas.index'));
        }
    }

    /**
     * @param $id ID de un área específica
     * Elimina un área seleccionada por el ID que entra en parámetros.
     */
    public function destroy($id) {
        // $area = DatosCarreraGraduado::find($id);
        $area = Area::find($id);

        if(empty($area)) {
            Flash::error('Área no encontrada');
            return redirect(route('areas.index'));
        }

        /* VALIDA QUE el área NO POSEA ENCUESTAS ASIGNADAS ANTES DE ELIMINAR */
        if(sizeof($area->entrevistas) > 0) {
            Flash::error('No es posible eliminar esta área debido a que posee entrevistas que están relacionadas a este dato.');
            return redirect(route('areas.index'));
        }
        
        try {
            DB::beginTransaction();

            /** Se borra el objeto encontrado */
            $area->deleted_at = Carbon::now();
            $area->save();
    
            // Guardar el registro en la bitacora
            $bitacora = [
                'transaccion'            =>'D',
                'tabla'                  =>'tbl_areas',
                'id_registro_afectado'   =>$area->id,
                'dato_original'          =>$old_area->__toString(),
                'dato_nuevo'             =>$area->__toString(),
                'fecha_hora_transaccion' =>Carbon::now(),
                'id_usuario'             =>Auth::user()->user_code,
                'created_at'             =>Carbon::now()
            ];
    
            DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

            DB::commit();

            /** Se genera un mensaje de exito y se redirige a la ruta index */
            Flash::success('Se ha eliminado el área '.$area->nombre.' correctamente.');
            return redirect(route('areas.index'));
            
        } catch (\Exception $ex) {
            DB::rollback();

            $mensaje = 'Comuniquese con el administrador o creador del sistema para el siguiente error: <u>';
            $mensaje .= $ex->getMessage();
            $mensaje .= '</u>.<br>Controlador: ';
            $mensaje .= $ex->getFile();
            $mensaje .= '<br>Función: destroy().<br>Línea: ';
            $mensaje .= $ex->getLine();
    
            Flash::error($mensaje);
            return redirect(route('areas.index'));    
        }
    }
}
