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
        $rolSupervisor = Role::create([
            'name' => 'Supervisor',
            'guard_name' => 'web',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        for($i=0; $i<20; $i++) {
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
