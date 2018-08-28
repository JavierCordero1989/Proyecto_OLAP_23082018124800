<?php

use Illuminate\Database\Seeder;
use App\EncuestaGraduado;

class ContactosGraduadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idsGraduados = EncuestaGraduado::pluck('id')->all();

        /** Crea el faker para generar datos de prueba */
        $faker = Faker\Factory::create('es_ES');

        for($i=0; $i<150; $i++) {
            DB::table('tbl_contactos_graduados')
                ->insert([
                    'identificacion_referencia' => $faker->randomElement([$faker->numerify('#-###-###'), '']),
                    'nombre_referencia'         => $faker->name,
                    'informacion_contacto'      => $faker->randomElement([$faker->phoneNumber, $faker->email]),
                    'observacion_contacto'      => $faker->randomElement([$faker->sentence, '']),
                    'id_graduado'               => $faker->randomElement($idsGraduados),
                    'created_at'                => \Carbon\Carbon::now()
                ]);
        }
    }
}
