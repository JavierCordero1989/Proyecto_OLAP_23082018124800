<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EncuestaGraduado;
use App\DetalleContacto;
use DB;
use Carbon\Carbon;

class ContactoGraduado extends Model
{
    protected $table = 'tbl_contactos_graduados';

    protected $fillable = [
        'identificacion_referencia',
        'nombre_referencia',
        'parentezco',
        'id_graduado'
    ];

    public function scopeObtenerContactosGraduado($query, $id_graduado) {
        return $query->where('id_graduado', $id_graduado);
    }

    public function encuestas() {
        return $this->hasOne(EncuestaGraduado::class, 'id', 'id_graduado');
    }

    public function detalle() {
        $id_contacto = $this->id;

        $detalle_contactos = DetalleContacto::where('id_contacto_graduado', $this->id)
            ->whereNull('deleted_at')
            ->get();

        return $detalle_contactos;
    }

    public function agregarDetalle($contacto, $observacion) {
        $detalle = DetalleContacto::create([
            'contacto' => $contacto,
            'observacion' => $observacion,
            'id_contacto_graduado' => $this->id,
            'created_at' => Carbon::now()
        ]);
    }

    /** Este método permite buscar un contacto de un graduado por su identificación o cédula.
     * Se debe utilizar el método first() de Query Builder para poder obtener el registro
     * y poder compararlo con el método empty().
     */
    public function scopeBuscarPorIdentificacion($query, $identificacion) {
        return $query->where('identificacion_referencia', $identificacion);
    }
}
