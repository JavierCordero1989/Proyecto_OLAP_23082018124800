<?php

use Illuminate\Database\Seeder;
use App\EncuestaGraduado;
use App\DatosCarreraGraduado;
use App\TiposDatosCarrera;
use Faker\Factory;

class EncuestaGraduadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('es_ES');

        $carrera = TiposDatosCarrera::where('nombre', 'CARRERA')->first();
        $universidad = TiposDatosCarrera::where('nombre', 'UNIVERSIDAD')->first();
        $grado = TiposDatosCarrera::where('nombre', 'GRADO')->first();
        $disciplina = TiposDatosCarrera::where('nombre', 'DISCIPLINA')->first();
        $area = TiposDatosCarrera::where('nombre', 'AREA')->first();
        $agrupacion = TiposDatosCarrera::where('nombre', 'AGRUPACION')->first();
        $sector = TiposDatosCarrera::where('nombre', 'SECTOR')->first();

        $carreras = DatosCarreraGraduado::where('id_tipo', $carrera->id)->pluck('id')->all();
        $universidades = DatosCarreraGraduado::where('id_tipo', $universidad->id)->pluck('id')->all();
        $grados = DatosCarreraGraduado::where('id_tipo', $grado->id)->pluck('id')->all();
        $disciplinas = DatosCarreraGraduado::where('id_tipo', $disciplina->id)->pluck('id')->all();
        $areas = DatosCarreraGraduado::where('id_tipo', $area->id)->pluck('id')->all();
        $agrupaciones = DatosCarreraGraduado::where('id_tipo', $agrupacion->id)->pluck('id')->all();
        $sectores = DatosCarreraGraduado::where('id_tipo', $sector->id)->pluck('id')->all();

        $id_estado = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        for($i=0; $i<400; $i++) {
            $encuesta = EncuestaGraduado::create([
                'identificacion_graduado'   => $faker->numerify('# - ### - ###'),
                'token'                     => $faker->uuid,
                'nombre_completo'           => $faker->name,
                'annio_graduacion'          => $faker->numberBetween($min = 2012, $max = 2015),
                'link_encuesta'             => $faker->url,
                'sexo'                      => $faker->randomElement(['M', 'F']),
                'codigo_carrera'            => $faker->randomElement($carreras),
                'codigo_universidad'        => $faker->randomElement($universidades),
                'codigo_grado'              => $faker->randomElement($grados),
                'codigo_disciplina'         => $faker->randomElement($disciplinas),
                'codigo_area'               => $faker->randomElement($areas),
                'codigo_agrupacion'         => $faker->randomElement($agrupaciones),
                'codigo_sector'             => $faker->randomElement($sectores),
                'tipo_de_caso'              => 'Muestra'
            ]);

            $encuesta->asignarEstado($id_estado->id);
        }
    }
}
