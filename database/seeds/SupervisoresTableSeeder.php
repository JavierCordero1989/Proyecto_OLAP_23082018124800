<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class SupervisoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ultimo_id = \App\User::all()->last();
        $ultimo_id = intval($ultimo_id->user_code);
        $limite = $ultimo_id + 5;

        for($i=$ultimo_id; $i<$limite; $i++) {
            $user = \App\User::create([
                'user_code' => ($i+1),
                'name' => 'Supervisor #'.($i+1),
                'email' => 'supervisor'.($i+1).'@conare.ac.cr',
                'password' => bcrypt('secret')
            ]);

            $user->assignRole('Supervisor');
        }
    }
}
