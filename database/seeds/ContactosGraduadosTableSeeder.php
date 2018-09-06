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
            $identificacion = $faker->randomElement([$faker->numerify('#-###-###'), '']);

            DB::table('tbl_contactos_graduados')
                ->insert([
                    'identificacion_referencia' => $identificacion,
                    'nombre_referencia'         => $faker->name,
                    // 'informacion_contacto'      => $faker->randomElement([$faker->phoneNumber, $faker->email]),
                    // 'observacion_contacto'      => $faker->randomElement([$faker->sentence, '']),
                    'parentezco'                => $faker->randomElement([$faker->word, '']),
                    'id_graduado'               => $faker->randomElement($idsGraduados),
                    'created_at'                => \Carbon\Carbon::now()
                ]);

            if(($i % 2) == 0) {
                $recien_ingresado = DB::table('tbl_contactos_graduados')->select('id')->where('identificacion_referencia', $identificacion)->first();
                
                for($j=0; $j<3; $j++) {
                    DB::table('tbl_detalle_contacto')
                        ->insert([
                            'contacto'              => $faker->randomElement([$faker->phoneNumber, $faker->email, '']),
                            'observacion'           => $faker->randomElement([$faker->sentence, '']),
                            'id_contacto_graduado'  => $recien_ingresado->id,
                            'created_at'            => \Carbon\Carbon::now()
                        ]);
                }
            }
        }
    }
}
