<?php

use Illuminate\Database\Seeder;

class EstadosEncuestasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'NO ASIGNADA',
                'descripcion' => 'La encuesta aún no ha sido asignada a ningún encuestador.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'ASIGNADA',
                'descripcion' => 'La encuesta ya ha sido asignada a un encuestador.'
            ]);
    }
}
