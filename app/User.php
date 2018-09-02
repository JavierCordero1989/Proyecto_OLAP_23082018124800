<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Asignacion;
use App\ObservacionesGraduado;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_code', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function asignacionesEncuestador() {
        return $this->hasMany(Asignacion::class, 'id_encuestador');
    }

    public function asignacionesSupervisor() {
        return $this->hasMany(Asignacion::class, 'id_supervisor');
    }

    public function observaciones() {
        return $this->hasMany(ObservacionesGraduado::class, 'id_usuario');
    }
}
