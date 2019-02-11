<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'user_code' => '0001',
            'extension'=>'',
            'mobile'=>'',
            'name' => 'Administrador',
            'email' => 'administrador@conare.ac.cr',
            'password' => bcrypt('administrador')
        ]);

        $user->assignRole('Super Admin');
    }
}
