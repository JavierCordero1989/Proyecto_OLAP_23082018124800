<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class EncuestadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolEncuestador = Role::create([
            'name' => 'Encuestador',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for($i=0; $i<20; $i++) {
            $user = \App\User::create([
                'user_code' => ($i+1),
                'name' => 'Encuestador #'.($i+1),
                'email' => 'encuestador'.($i+1).'@conare.ac.cr',
                'password' => bcrypt('secret')
            ]);

            $user->assignRole('Encuestador');
        }
    }
}