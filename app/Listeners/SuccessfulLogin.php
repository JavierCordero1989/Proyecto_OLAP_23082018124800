<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class SuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        DB::table('tbl_bitacora_de_cambios')
            ->insert([
                'transaccion' => 'S',
                'tabla' => 'users', 
                'id_registro_afectado' => $event->user->id,
                'dato_original' => '',
                'dato_nuevo' => 'El usuario '.$event->user->name.' ha iniciado sesión.',
                'fecha_hora_transaccion' => \Carbon\Carbon::now(),
                'id_usuario' => $event->user->id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
    }
}
