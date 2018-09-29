<?php

use Illuminate\Database\Seeder;
use App\TiposDatosCarrera;
use App\DatosCarreraGraduado;
use App\Sector;
use App\Universidad;
use App\Grado;
use App\Carrera;
use App\Agrupacion;

class DatosCarreraGraduadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            'CARRERA', 
            'UNIVERSIDAD', 
            'GRADO',
            'AGRUPACION', 
            'SECTOR'
        ];

        foreach($tipos as $tipo) {
            $tipo_carrera = Tiposdatoscarrera::create([
                'nombre' => $tipo
            ]);
        }

        //Se crean los sectores PÚBLICO y PRIVADO
        $nuevo_sector = Sector::create([
            'codigo'  =>'1',
            'nombre'  =>'Público',
            'id_tipo' => 5
        ]);
        $nuevo_sector = Sector::create([
            'codigo'  =>'2',
            'nombre'  =>'Privado',
            'id_tipo' => 5
        ]);

        //Se crean las universidades PÚBLICAS y PRIVADAS
        $universidades = [
            '1'=>'Universidad de Costa Rica',
            '2'=>'Universidad Nacional',
            '3'=>'Tecnológico de Costa Rica',
            '4'=>'Universidad Estatal a Distancia',
            '5'=>'Universidad Técnica Nacional'
        ];

        foreach($universidades as $clave => $valor) {
            $universidad = Universidad::create([
                'codigo'  =>$clave,
                'nombre'  =>$valor,
                'id_tipo' => 2
            ]);
        }

        //Se crean los grados DIPLOMADO, BACHILLER, LICENCIATURA
        $grados = [
            '1'=>'Diplomado',
            '2'=>'Bachiller',
            '3'=>'Licenciatura'
        ];

        foreach($grados as $clave => $valor) {
            $grado = Grado::create([
                'codigo'  =>$clave,
                'nombre'  =>$valor,
                'id_tipo' => 3
            ]);
        }

        //Se crean las carreras
        $faker = Faker\Factory::create();
        $carreras =[];

        for($i=0; $i<200; $i++) {
            $carreras[] =$faker->sentence;
        }

        foreach($carreras as $clave => $valor) {
            $nueva_carrera = Carrera::create([
                'codigo'  =>$clave,
                'nombre'  =>$valor,
                'id_tipo' => 1
            ]);
        }

        //Se crean las agrupaciones
        $agrupaciones = [
            '1'=>'UCR',
            '2'=>'UNED',
            ''=>'UTN',
            '4'=>'TEC',
            '5'=>'UNA',
            '6'=>'PRIVADO'
        ];

        foreach ($agrupaciones as $clave => $valor) {
            $agrupacion = Agrupacion::create([
                'codigo'  =>$clave,
                'nombre'  =>$valor,
                'id_tipo' => 4
            ]);
        }

        // /** Selecciona el ID de los tipos */
        // $ids_tipos_datos_carrera = TiposDatosCarrera::pluck('id')->all();

        // /** Crea el faker para generar datos de prueba */
        // $faker = Faker\Factory::create('es_ES');

        // /** Creacion de grados, areas y disciplinas */
        // for($i=0; $i<400; $i++) {
        //     $datos = DatosCarreraGraduado::create([
        //         'codigo' => $faker->numerify('##########'),
        //         'nombre' => $faker->sentence,
        //         'id_tipo' => $faker->randomElement($ids_tipos_datos_carrera)
        //     ]);
        // }
    }
}
