<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EncuestadoresTableSeeder::class);
        $this->call(SupervisoresTableSeeder::class);
        $this->call(DatosCarreraGraduadoTableSeeder::class);
        $this->call(EstadosEncuestasTableSeeder::class);
        $this->call(EncuestaGraduadoTableSeeder::class);
    }
}
