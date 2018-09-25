<?php

use Illuminate\Database\Seeder;
use App\Area;
use App\Disciplina;

class AreasDisciplinasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** Crea el faker para generar datos de prueba */
        $faker = Faker\Factory::create('es_ES');

        /* Para guardar los IDS de las areas que se van creando. */
        $ids_areas = [];
        
        /* Se crean 10 areas */
        for($i=0; $i<10; $i++) {
            $nueva_area = Area::create([
                'codigo' => $faker->numerify('##########'),
                'descriptivo' => $faker->sentence
            ]);

            $ids_areas[] = $nueva_area->id;
        }

        /* Se crean 120 disciplinas */
        for($j=0; $j<120; $j++) {
            $nueva_disciplina = Disciplina::create([
                'codigo' => $faker->numerify('##########'),
                'descriptivo' => $faker->sentence,
                'id_area' => $faker->randomElement($ids_areas)
            ]);
        }
    }
}
