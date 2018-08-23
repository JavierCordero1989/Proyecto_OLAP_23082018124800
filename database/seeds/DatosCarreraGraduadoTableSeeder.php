<?php

use Illuminate\Database\Seeder;
use App\TiposDatosCarrera;
use App\DatosCarreraGraduado;

class DatosCarreraGraduadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Creacion de los tipos */
        $tipo1 = TiposDatosCarrera::create([
            'nombre' => 'Grado'
        ]);

        $tipo2 = TiposDatosCarrera::create([
            'nombre' => 'Disciplina'
        ]);

        $tipo3 = TiposDatosCarrera::create([
            'nombre' => 'Área'
        ]);

        /** Selecciona el ID de los tipos */
        $tipos = TiposDatosCarrera::pluck('id')->all();

        /** Crea el faker para generar datos de prueba */
        $faker = Faker\Factory::create('es_ES');

        /** Creacion de grados, areas y disciplinas */
        for($i=0; $i<100; $i++) {
            $datos = DatosCarreraGraduado::create([
                'codigo' => $faker->numerify('CD####'),
                'nombre' => $faker->sentence,
                'id_tipo' => $faker->randomElement($tipos)
            ]);
        }
    }
}
