<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            'permisos.index'            => 'Ver lista de permisos en la BD',
            'permisos.create'           => 'Crear permisos',
            'permisos.store'            => 'Almacenar permisos en la BD',
            'permisos.edit'             => 'Editar datos de permisos',
            'permisos.update'           => 'Actualizar datos de permisos',
            'permisos.destroy'          => 'Eliminar permisos de la BD',
            'permisos.show'             => 'Ver registro de un permiso',
            'roles.index'               => 'Ver lista de roles en la BD',
            'roles.create'              => 'Crear roles',
            'roles.store'               => 'Almacenar roles en la BD',
            'roles.edit'                => 'Editar datos de roles',
            'roles.update'              => 'Actualizar datos de roles',
            'roles.destroy'             => 'Eliminar roles de la BD',
            'roles.show'                => 'Ver registro de un rol',
            'users.index'               => 'Ver lista de usuarios en la BD',
            'users.create'              => 'Crear usuarios',
            'users.store'               => 'Almacenar usuarios en la BD',
            'users.edit'                => 'Editar datos de usuarios',
            'users.update'              => 'Actualizar datos de usuarios',
            'users.destroy'             => 'Eliminar usuarios de la BD',
            'users.show'                => 'Ver registro de un usuario',
            'users.edit_name'           => 'Editar nombre de los usuarios',
            'users.update_name'         => 'Actualizar nombre de los usuarios',
            'users.edit_password'       => 'Editar contraseña de los usuarios',
            'users.update_password'     => 'Actualizar contraseña de los usuarios',
            'users.index_table'         => 'Ver lista de usuarios',
            'permissionsToRol.create'   => 'Dar permisos a un rol',
            'permissionsToRol.store'    => 'Almacenar permisos de un rol',
            'rolesToUser.create'        => 'Dar roles a un usuario',
            'rolesToUser.store'         => 'Almacenar roles de un usuario',
            'excel.create'              => 'Subir archivo muestra de excel a la BD',
        ];

        foreach($permisos as $permiso => $valor) {
            // Nombre para ruta amigable
            $nombreAmigable = $valor;
            $slug = Str::slug($nombreAmigable);

            Permission::create([
                'name'              => $permiso,
                'nombre_amigable'   => $nombreAmigable,
                'slug'              => $slug,
                'guard_name'        => 'web',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }
    }
}
