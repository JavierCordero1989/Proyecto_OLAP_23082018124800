<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Flash;
use DB;

class ResetPasswordController extends Controller
{
    public function anotar_cambio_de_contrasennia() {
        return view('auth.remember-password');
    }

    public function obtener_solicitud_de_cambio(Request $request) {
        
        $input = $request->all(); //datos del request

        //Se obtiene TRUE si el usuario con dicho correo existe, FALSE de lo contrario
        $user = User::where('email', $input['email'])->exists();

        //Si el usuario NO existe, se devuelve con un error especificandolo con un mensaje.
        if(!$user) {
            $error = 'Estas credenciales no coinciden con nuestros registros.';
            return view('auth.remember-password')->with('error', $error);
        }
        else {
            //Si existe, se debe verificar que no exista una solicitud pendiente del mismo usuario.
            $existe_solicitud = DB::table('password_resets')->where('email', $input['email'])->where('estado', 'NR')->first();

            if(!empty($existe_solicitud)) {
                $error = 'Ya ha tramitado una solicitud de cambio, debe esperar la respuesta del supervisor.';
                return view('auth.remember-password')->with('error', $error);
            }
            else {
                //Si existe, se guarda el registro con correo, estado y fecha de la solicitud de cambio de contraseña
                $password_reset = [
                    'email'      =>$input['email'],
                    'estado'     => 'NR',
                    'created_at' =>Carbon::now()
                ];
    
                DB::table('password_resets')->insert($password_reset);
    
                //En la tabla de bitácora se registra el cambio
                $bitacora = [
                    'transaccion'            =>'I',
                    'tabla'                  =>'password_resets',
                    'id_registro_afectado'   =>null,
                    'dato_original'          =>null,
                    'dato_nuevo'             =>('email:'.$password_reset['email'].',created_at:'.$password_reset['created_at']),
                    'fecha_hora_transaccion' =>Carbon::now(),
                    'id_usuario'             =>null,
                    'created_at'             =>Carbon::now()
                ];
    
                DB::table('tbl_bitacora_de_cambios')->insert($bitacora);
    
                //Mensaje de éxito
                return view('auth.change-user-password');
            }
        }
    }

    //Saca todas las solicitudes de cambio de contraseña que estén pendientes.
    public function obtener_solicitudes_de_cambio(Request $request) {
        if($request->ajax()) {
            
            if($request->user_role != 'Encuestador') {
                //Obtiene todos los registros que tienen de estado NR
                $cambios_pendientes = DB::table('password_resets')->where('estado', 'NR')->get();

                //Array con los datos 
                $data = [
                    'count' => sizeof($cambios_pendientes),
                    'datos' => $cambios_pendientes
                ];
            }
            else {
                $data = [
                    'count' => 0,
                    'datos' => []
                ];
            }
            
            //Devuelve la respuesta al ajax
            return response()->json($data);
        }
    }

    /* Recibe el correo por parametros y busca en la tabla 'password_resets' en donde el
    estado sea 'NR', para obtener el ID de dicho regsitro en esa tabla, para asi enviarlo a 
    la vista para restablecer el regsitro. */
    public function cambiar_contrasennia_usuario($correo_usuario) {
        //Se busca el usuario en la BD por su correo
        $user = User::findByEmail($correo_usuario)->first();

        //Si el usuario no existe, se enviara un mensaje de error 
        if(empty($user)) {
            Flash::overlay('El usuario que intentó buscar no coincide con los registros del sistema.', 'Error de usuario');
            return redirect(url('home'));
        }

        //Se busca el registro en la tabla mediante el correo y que no este con estado R, obteniendo el
        //ID unico del registro.
        $registro_solicitud = DB::table('password_resets')
                                ->select('id')
                                ->where('email', $correo_usuario)
                                ->where('estado', 'NR')->first();

        //Si el registro no existe, se enviara un mensaje de error.
        if(empty($registro_solicitud)) {
            Flash::overlay('No hay un registro en el sistema, que coincida con el correo seleccionado.', 'Error en la solicitud')->warning();
            return redirect(url('home'));
        }

        //Se llama a la vista con los datos del usuario encontrado y el ID unico del registro de la
        //solicitud.
        return view('auth.reset-password')->with('user', $user)->with('registro', $registro_solicitud->id);
    }

    public function realizar_cambio_de_contrasennia($id, Request $request) {
        //dd($request->all());
        //Se busca el regsitro en la tabla mediante el ID
        $registro = DB::table('password_resets')->find($id);
        
        //Si no existe el registro, se envia un mensaje de error.
        if(empty($registro)) {
            Flash::overlay('No hay un registro en el sistema, que coincida con el correo seleccionado.', 'Error en la solicitud')->warning();
            return redirect(url('home'));
        }

        $user = User::findByEmail($registro->email)->first();

        /* Si el usuario no se encuentra en los registros de la BD */
        if(empty($user)) {
            Flash::overlay('El usuario que intenta buscar no existe en los registros.');
            return redirect(url('home'));
        }

        //Se obtienen las contraseñas del usuario
        $pass1 = $request->password;
        $pass2 = $request->password_confirm;

        //Si las contraseñas no coinciden se envia un mensaje de error.
        if($pass1 != $pass2) {
            Flash::overlay('De alguna manera las contraseñas no coinciden. No se pudo realizar el cambio', 'Error en las contraseñas')->error();
            return redirect(url('home'));
        }

        /* Se actualiza la contraseña del usuario */
        $user->password = bcrypt($pass1);
        $user->save();

        //Se actualiza el registro en la base de datos, pasando su estado a RESUELTA
        $update = DB::table('password_resets')->where('id', $id)->update(['estado'=>'R']);
 
        /* Registro en la bitacora de cambios */
        DB::table('tbl_bitacora_de_cambios')->insert([
            'transaccion' => 'U',
            'tabla' => 'password_resets',
            'id_registro_afectado' => $registro->id,
            'dato_original' => '{estado: NR}',
            'dato_nuevo' => 'Se ha cambiado la contraseña del usuario '.$user->email.'. Estado en la tabla {estado:R}',
            'fecha_hora_transaccion' => Carbon::now(),
            'id_usuario' => Auth::user()->id,
            'created_at' => Carbon::now()
        ]);

        //Su la variable es igual a 1, el cambio en la BD se hizo correctamente.
        //Si es 0, quiere decir que no funcionó.
        if($update != 1) {
            Flash::overlay('Ha ocurrido un error y no se ha podido actualizar el registro.', 'Error en el servidor')->error();
            return redirect(url('home'));
        }
        else {
            Flash::overlay('La contraseña del usuario ha cambiado.<br>Por favor, notificar de inmediato.', 'Cambio de contraseña exitoso')->success();
            return redirect(url('home'));
        }
    }
}
