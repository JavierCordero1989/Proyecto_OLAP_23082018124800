<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Faker\Factory;

class EncuestadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('es_ES');

        for($i=0; $i<18; $i++) {
            $codigo = $faker->numerify('######');

            $user = \App\User::create([
                'user_code' => $codigo,
                'name' => 'Encuestador #'.$codigo,
                'email' => 'encuestador'.$codigo.'@conare.ac.cr',
                'password' => bcrypt('secret')
            ]);

            $user->assignRole('Encuestador');
        }
    }
}