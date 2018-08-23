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

        $grado = TiposDatosCarrera::where('nombre', 'Grado')->first();
        $disciplina = TiposDatosCarrera::where('nombre', 'Disciplina')->first();
        $area = TiposDatosCarrera::where('nombre', 'Área')->first();

        $grados = DatosCarreraGraduado::where('id_tipo', $grado->id)->pluck('id')->all();
        $disciplinas = DatosCarreraGraduado::where('id_tipo', $disciplina->id)->pluck('id')->all();
        $areas = DatosCarreraGraduado::where('id_tipo', $area->id)->pluck('id')->all();

        $id_estado = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        for($i=0; $i<150; $i++) {
            $encuesta = EncuestaGraduado::create([
                'identificacion_graduado' => $faker->numerify('# - ### - ###'),
                'token' => $faker->uuid,
                'nombre_completo' => $faker->name,
                'annio_graduacion' => $faker->numberBetween($min = 2012, $max = 2015),
                'link_encuesta' => $faker->url,
                'sexo' => $faker->randomElement(['M', 'F']),
                'carrera' => $faker->text($maxNbChars = 49),
                'universidad' => $faker->text($maxNbChars = 49),
                'codigo_grado' => $faker->randomElement($grados),
                'codigo_disciplina' => $faker->randomElement($disciplinas),
                'codigo_area' => $faker->randomElement($areas),
                'tipo_de_caso' => 'Muestra'
            ]);

            $encuesta->asignarEstado($id_estado->id);
        }
    }
}
