<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Str;

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
            $extension = $faker->numerify('####-####');
            $mobile = $faker->numerify('####-####');
            $nombre = $faker->name;
            $email = Str::slug($nombre);

            $user = \App\User::create([
                'user_code' => $codigo,
                'extension'=>$extension,
                'mobile'=>$mobile,
                'name' => $nombre,
                'email' => $email.'@conare.ac.cr',
                'password' => bcrypt('secret')
            ]);

            $user->assignRole('Encuestador');
        }
    }
}