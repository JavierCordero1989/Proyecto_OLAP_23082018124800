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
                'estado' => 'NO ASIGNADA'
                // 'descripcion' => 'La encuesta aún no ha sido asignada a ningún encuestador.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'ASIGNADA'
                // 'descripcion' => 'La encuesta ya ha sido asignada a un encuestador.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'RECHAZADA'
                // 'descripcion' => 'La encuesta fue rechazada por el encuestado.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'INCOMPLETA'
                // 'descripcion' => 'La encuesta aún no ha sido completada por razones varias.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'FUERA DEL PAÍS'
                // 'descripcion' => 'El encuestado se encuentra fuera del país.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'ILOCALIZABLE'
                // 'descripcion' => 'No se ha podido hacer contacto con el encuestado de ninguna forma.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'FALLECIDO'
                // 'descripcion' => 'El encuestador ha fallecido.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'EXTRANJERO'
                // 'descripcion' => 'No sé que significa este estado.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'CON CITA'
                // 'descripcion' => 'Se ha decidido agendar una cita para realizar luego la encuesta.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'MENSAJE'
                // 'descripcion' => 'Se ha dejado un mensaje para que el encuestado se comunique luego.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'LINK AL CORREO'
                // 'descripcion' => 'Se ha enviado el link de la encuesta al correo.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'INFORMACIÓN POR CORREO'
                // 'descripcion' => 'Se ha enviado la información sobre la encuesta al correo del encuestado.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'ENTREVISTA COMPLETA'
                // 'descripcion' => 'La entrevista se ha completado satisfactoriamente.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'OTRO'
                // 'descripcion' => 'un estado para cualquier otro caso.'
            ]);

        DB::table('tbl_estados_encuestas')
            ->insert([
                'estado' => 'DISCIPLINA NO CORRESPONDE'
                // 'descripcion' => 'un estado para cualquier otro caso.'
            ]);
    }
}
