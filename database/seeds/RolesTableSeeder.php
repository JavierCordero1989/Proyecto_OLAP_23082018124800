<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nombre para ruta amigable
        $nombreAmigable = 'Administrador general del sistema';
        $slug = Str::slug($nombreAmigable);

        //Rol de administrador
        $role = Role::create([
            'name'              => 'Super Admin',
            'nombre_amigable'   => $nombreAmigable,
            'slug'              => $slug,
            'guard_name'        => 'web',
            'created_at'        => Carbon::now()
        ]);

        //Se le dan todos los permisos
        // $role->givePermissionTo(Permission::all());

        // Nombre para ruta amigable
        $nombreAmigable = 'Supervisor #1 para el sistema';
        $slug = Str::slug($nombreAmigable);

        //Rol de supervisor 1
        $supervisor1 = Role::create([
            'name'              => 'Supervisor 1',
            'nombre_amigable'   => $nombreAmigable,
            'slug'              => $slug,
            'guard_name'        => 'web',
            'created_at'        => Carbon::now()
        ]);
        
        //Se le dan todos los permisos
        // $supervisor1->givePermissionTo(Permission::all());

        // Nombre para ruta amigable
        $nombreAmigable = 'Supervisor #2 para el sistema';
        $slug = Str::slug($nombreAmigable);

        //Rol de supervisor 2
        $supervisor2 = Role::create([
            'name'              => 'Supervisor 2',
            'nombre_amigable'   => $nombreAmigable,
            'slug'              => $slug,
            'guard_name'        => 'web',
            'created_at'        => Carbon::now()
        ]);

        // Nombre para ruta amigable
        $nombreAmigable = 'Encuestador de las entrevistas';
        $slug = Str::slug($nombreAmigable);

        //Rol de encuestador
        $encuestador = Role::create([
            'name'              => 'Encuestador',
            'nombre_amigable'   => $nombreAmigable,
            'slug'              => $slug,
            'guard_name'        => 'web',
            'created_at'        => Carbon::now()
        ]);
    }
}
