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
        //Se realiza una consulta para obtener el ultimo registro del usuario que esta logueado
        $id_registro = DB::table('log_users_login')
            ->select(DB::RAW('max(id) as ID_LOG'))
            ->where('user_id', $event->user->id)
            ->first();

        //Se actualiza la tabla en base al ID obtenido
        DB::table('log_users_login')
            ->where('id', $id_registro->ID_LOG)
            ->update(['cierre_sesion' => \Carbon\Carbon::now()]);
    }
}
