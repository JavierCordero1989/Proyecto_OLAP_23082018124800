<?php

use Illuminate\Database\Seeder;
use App\EncuestaGraduado;
use App\DatosCarreraGraduado;
use App\TiposDatosCarrera;
use App\Universidad;
use App\Grado;
use App\Area;
use App\Disciplina;
use App\Carrera;
use App\Agrupacion;
use App\Sector;
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

        // $carrera = TiposDatosCarrera::where('nombre', 'CARRERA')->first();
        // $universidad = TiposDatosCarrera::where('nombre', 'UNIVERSIDAD')->first();
        // $grado = TiposDatosCarrera::where('nombre', 'GRADO')->first();
        // $agrupacion = TiposDatosCarrera::where('nombre', 'AGRUPACION')->first();
        $sector = TiposDatosCarrera::where('nombre', 'SECTOR')->first();

        // $carreras = DatosCarreraGraduado::where('id_tipo', $carrera->id)->pluck('id')->all();
        $carreras = Carrera::allData()->pluck('id')->all();
        // $universidades = DatosCarreraGraduado::where('id_tipo', $universidad->id)->pluck('id')->all();
        $universidades = Universidad::allData()->pluck('id')->all();
        // $grados = DatosCarreraGraduado::where('id_tipo', $grado->id)->pluck('id')->all();
        $grados = Grado::allData()->pluck('id')->all();
        // $disciplinas = DatosCarreraGraduado::where('id_tipo', $disciplina->id)->pluck('id')->all();
        // $areas = DatosCarreraGraduado::where('id_tipo', $area->id)->pluck('id')->all();
        $disciplinas = Disciplina::pluck('id')->all();
        $areas = Area::pluck('id')->all();
        // $agrupaciones = DatosCarreraGraduado::where('id_tipo', $agrupacion->id)->pluck('id')->all();
        $agrupaciones = Agrupacion::allData()->pluck('id')->all();
        // $sectores = DatosCarreraGraduado::where('id_tipo', $sector->id)->pluck('id')->all();
        $sector_publico = Sector::publico()->first();
        $sector_privado = Sector::privado()->first();

        $id_estado = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        for($i=0; $i<400; $i++) {
            $universidad = $faker->randomElement($universidades);

            $encuesta = EncuestaGraduado::create([
                'identificacion_graduado'   => $faker->numerify('# - ### - ###'),
                'token'                     => $faker->uuid,
                'nombre_completo'           => $faker->name,
                'annio_graduacion'          => $faker->numberBetween($min = 2012, $max = 2015),
                'link_encuesta'             => $faker->url,
                'sexo'                      => $faker->randomElement(['M', 'F']),
                'codigo_carrera'            => $faker->randomElement($carreras),
                'codigo_universidad'        => $universidad,
                'codigo_grado'              => $faker->randomElement($grados),
                'codigo_disciplina'         => $faker->randomElement($disciplinas),
                'codigo_area'               => $faker->randomElement($areas),
                'codigo_agrupacion'         => $this->obtenerAgrupacion($universidad),
                'codigo_sector'             => $this->esPublica($universidad) ? $sector_publico->id : $sector_privado->id,
                'tipo_de_caso'              => 'Muestra'
            ]);

            $encuesta->asignarEstado($id_estado->id);
        }
    }

    /**
     * Verifica si la universidad pasada por parámetros es pública o no.
     * @param $universidad Universidad a comparar
     * @return $es_publica Verdadero si es pública, falso si es privada
     */
    private function esPublica($universidad) {
        $dato_encontrado = Universidad::buscarPorId($universidad)->first();
        
        $data = [
            'UNIVERSIDAD DE COSTA RICA',
            'UNIVERSIDAD NACIONAL',
            'INSTITUTO TECNOLOGICO DE COSTA RICA',
            'UNIVERSIDAD ESTATAL A DISTANCIA',
            'UNIVERSIDAD TECNICA NACIONAL'
        ];

        $es_publica = false;

        foreach($data as $element) {
            if($element == $dato_encontrado->nombre) {
                $es_publica = true;
            }
        }

        return $es_publica;
    }

    /**
     * Compara la cadena recibida y devuelve la agrupacion a la que pertenece
     * @param $universidad Universidad que será comparada
     * @return $agrupacion Código de la Agrupación a la que pertenece la universidad según su nombre
     */
    private function obtenerAgrupacion($universidad) {
        $dato_encontrado = Universidad::buscarPorId($universidad)->first();
        $dato = '';

        switch ($dato_encontrado->nombre) {
            case 'UNIVERSIDAD DE COSTA RICA':
                $dato = 'UCR';
                break;
            
            case 'UNIVERSIDAD NACIONAL':
                $dato = 'UNA';
                break;
                
            case 'INSTITUTO TECNOLOGICO DE COSTA RICA':
                $dato = 'ITCR';
                break;

            case 'UNIVERSIDAD ESTATAL A DISTANCIA':
                $dato = 'UNED';
                break;

            case 'UNIVERSIDAD TECNICA NACIONAL':
                $dato = 'UTN';
                break;

            default:
                $dato = 'PRIVADO';
        }

        $agrupacion = Agrupacion::buscarPorNombre($dato)->first();
        $id = $agrupacion->id;
        return $id;
    }
}
