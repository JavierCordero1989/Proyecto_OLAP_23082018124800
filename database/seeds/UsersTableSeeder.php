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
            'extension'=>'2441-3669',
            'mobile'=>'85147100',
            'name' => 'Super Admin',
            'email' => 'root@root.com',
            'password' => bcrypt('root')
        ]);

        $user->assignRole('Super Admin');
    }
}
