<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
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
            return redirect(url('/login'));
        }
    }

    //Saca todas las solicitudes de cambio de contraseña que estén pendientes.
    public function obtener_solicitudes_de_cambio(Request $request) {
        if($request->ajax()) {
            //Obtiene todos los registros que tienen de estado NR
            $cambios_pendientes = DB::table('password_resets')->where('estado', 'NR')->get();

            //Array con los datos 
            $data = [
                'count' => sizeof($cambios_pendientes),
                'datos' => $cambios_pendientes
            ];

            //Devuelve la respuesta al ajax
            return response()->json($data);
        }
    }

    public function cambiar_contrasennia_usuario($correo_usuario) {
        $user = User::findByEmail($correo_usuario)->first();

        if(empty($user)) {
            
        }

        dd($user);
    }
}
