<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory;

class SupervisoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('es_ES');

        for($i=0; $i<3; $i++) {
            $codigo = $faker->numerify('######');
            $nombre = $faker->name;
            $email = Str::slug($nombre);

            $user = \App\User::create([
                'user_code' => $codigo,
                'name' => $nombre,
                'email' => $email.'@conare.ac.cr',
                'password' => bcrypt('secret')
            ]);

            $user->assignRole('Supervisor 1');
        }

        for($i=0; $i<2; $i++) {
            $codigo = $faker->numerify('######');
            $nombre = $faker->name;
            $email = Str::slug($nombre);

            $user = \App\User::create([
                'user_code' => $codigo,
                'name' => $nombre,
                'email' => $email.'@conare.ac.cr',
                'password' => bcrypt('secret')
            ]);

            $user->assignRole('Supervisor 2');
        }
    }
}
