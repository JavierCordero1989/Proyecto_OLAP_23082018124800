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
        // ID de cada uno de los graduados almacenados en el sistema.
        $idsGraduados = EncuestaGraduado::pluck('id')->all();

        /** Crea el faker para generar datos de prueba */
        $faker = Faker\Factory::create('es_ES');

        foreach($idsGraduados as $id) {
            $identificacion = $faker->randomElement([$faker->numerify('#-###-###'), '']);
            $nombre = $faker->name;
            $parentezco = $faker->randomElement([$faker->word, '']);
            $id_graduado = $id;

            DB::table('tbl_contactos_graduados')
                ->insert([
                    'identificacion_referencia' => $identificacion,
                    'nombre_referencia'         => $nombre,
                    'parentezco'                => $parentezco,
                    'id_graduado'               => $id_graduado,
                    'created_at'                => \Carbon\Carbon::now()
                ]);

            $recien_ingresado = DB::table('tbl_contactos_graduados')
                ->select('id')
                ->where('identificacion_referencia', $identificacion)
                ->where('nombre_referencia', $nombre)
                ->where('parentezco', $parentezco)
                ->where('id_graduado', $id_graduado)
                ->first();

            DB::table('tbl_detalle_contacto')
                ->insert([
                    'contacto'              => $faker->randomElement([$faker->phoneNumber, $faker->email]),
                    'observacion'           => $faker->randomElement([$faker->sentence, '']),
                    'estado'                => $faker->randomElement(['F', 'E']),
                    'id_contacto_graduado'  => $recien_ingresado->id,
                    'created_at'            => \Carbon\Carbon::now()
                ]);
        }

        // for($i=0; $i<150; $i++) {
        //     $identificacion = $faker->randomElement([$faker->numerify('#-###-###'), '']);
        //     $nombre = $faker->name;
        //     $parentezco = $faker->randomElement([$faker->word, '']);
        //     $id_graduado = $faker->randomElement($idsGraduados);

        //     DB::table('tbl_contactos_graduados')
        //         ->insert([
        //             'identificacion_referencia' => $identificacion,
        //             'nombre_referencia'         => $nombre,
        //             // 'informacion_contacto'      => $faker->randomElement([$faker->phoneNumber, $faker->email]),
        //             // 'observacion_contacto'      => $faker->randomElement([$faker->sentence, '']),
        //             'parentezco'                => $parentezco,
        //             'id_graduado'               => $id_graduado,
        //             'created_at'                => \Carbon\Carbon::now()
        //         ]);

        //     if(($i % 2) == 0) {
        //         $recien_ingresado = DB::table('tbl_contactos_graduados')
        //             ->select('id')
        //             ->where('identificacion_referencia', $identificacion)
        //             ->where('nombre_referencia', $nombre)
        //             ->where('parentezco', $parentezco)
        //             ->where('id_graduado', $id_graduado)
        //             ->first();
                
        //         for($j=0; $j<3; $j++) {
        //             DB::table('tbl_detalle_contacto')
        //                 ->insert([
        //                     'contacto'              => $faker->randomElement([$faker->phoneNumber, $faker->email, '']),
        //                     'observacion'           => $faker->randomElement([$faker->sentence, '']),
        //                     'estado'                => $faker->randomElement(['F', 'E']),
        //                     'id_contacto_graduado'  => $recien_ingresado->id,
        //                     'created_at'            => \Carbon\Carbon::now()
        //                 ]);
        //         }
        //     }
        // }
    }
}
