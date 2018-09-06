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
        $tipos = ['CARRERA', 'UNIVERSIDAD', 'GRADO', 'DISCIPLINA', 'AREA', 'AGRUPACION', 'SECTOR'];

        foreach($tipos as $tipo) {
            $tipo_carrera = Tiposdatoscarrera::create([
                'nombre' => $tipo
            ]);
        }

        /** Selecciona el ID de los tipos */
        $ids_tipos_datos_carrera = TiposDatosCarrera::pluck('id')->all();

        /** Crea el faker para generar datos de prueba */
        $faker = Faker\Factory::create('es_ES');

        /** Creacion de grados, areas y disciplinas */
        for($i=0; $i<400; $i++) {
            $datos = DatosCarreraGraduado::create([
                'codigo' => $faker->numerify('##########'),
                'nombre' => $faker->sentence,
                'id_tipo' => $faker->randomElement($ids_tipos_datos_carrera)
            ]);
        }
    }
}
