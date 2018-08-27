<?php

namespace App\Listeners\Auth;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        // DB:table('tbl_bitacora_de_cambios')
        //     ->insert([
        //         'transaccion' => 'Salida del usuario del sistema',
        //         'tabla' => 'users', 
        //         'id_registro_afectado' => $event->user->id,
        //         'dato_original' => '',
        //         'dato_nuevo' => '',
        //         'fecha_hora_transacción' => \Carbon\Carbon::now(),
        //         'id_usuario' => $event->user->id,
        //         'created_at' => \Carbon\Carbon::now(),
        //         'updated_at' => \Carbon\Carbon::now()
        //     ]);
    }
}
