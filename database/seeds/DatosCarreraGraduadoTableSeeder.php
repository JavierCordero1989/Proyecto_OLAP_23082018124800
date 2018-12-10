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
        // $universidades = [
        //     '1'=>'UNIVERSIDAD DE COSTA RICA',
        //     '2'=>'INSTITUTO TECNOLOGICO DE COSTA RICA',
        //     '3'=>'UNIVERSIDAD NACIONAL',
        //     '4'=>'UNIVERSIDAD ESTATAL A DISTANCIA',
        //     '5'=>'UNIVERSIDAD AUTONOMA DE CENTRO AMERICA',
        //     '6'=>'UNIVERSIDAD INTERNACIONAL DE LAS AMERICAS',
        //     '7'=>'UNIVERSIDAD ADVENTISTA DE CENTRO AMERICA',
        //     '8'=>'UNIVERSIDAD LATINOAMERICANA CIENCIA Y TECNOLOGIA',
        //     '9'=>'UNIVERSIDAD PANAMERICANA',
        //     '10'=>'UNIVERSIDAD LATINA DE COSTA RICA',
        //     '11'=>'UNIVERSIDAD INTERAMERICANA DE COSTA RICA',
        //     '12'=>'UNIVERSIDAD CENTRAL COSTARRICENSE',
        //     '13'=>'UNIVERSIDAD HISPANOAMERICANA',
        //     '14'=>'UNIVERSIDAD DE SAN JOSE',
        //     '15'=>'UNIVERSIDAD EVANGELICA DE LAS AMERICAS (NAZARENA)',
        //     '16'=>'UNIVERSIDAD LIBRE DE COSTA RICA',
        //     '17'=>'UNIVERSIDAD CATOLICA ANSELMO LLORENTE Y LA FUENTE',
        //     '18'=>'UNIVERSIDAD DEL DISEÑO',
        //     '19'=>'UNIVERSIDAD VERITAS',
        //     '20'=>'UNIVERSIDAD BRAULIO CARRILLO',
        //     '21'=>'UNIVERSIDAD PARA LA COOPERACION INTERNACIONAL',
        //     '22'=>'UNIVERSIDAD FIDELITAS',
        //     '23'=>'UNIVERSIDAD AUTONOMA DE MONTERREY',
        //     '24'=>'UNIVERSIDAD LA SALLE',
        //     '25'=>'UNIVERSIDAD DE IBEROAMERICA',
        //     '26'=>'UNIVERSIDAD FEDERADA DE COSTA RICA',
        //     '27'=>'UNIVERSIDAD DE CARTAGO FLORENCIO DEL CASTILLO',
        //     '28'=>'UNIVERSIDAD ISAAC NEWTON',
        //     '29'=>'UNIVERSIDAD EN CIENCIAS ADMINISTRATIVAS SAN MARCOS',
        //     '30'=>'UNIVERSIDAD SANTA LUCIA',
        //     '31'=>'UNIVERSIDAD SAN JUAN DE LA CRUZ',
        //     '32'=>'UNIVERSIDAD MAGISTER',
        //     '33'=>'UNIVERSIDAD DEL TURISMO',
        //     '34'=>'UNIVERSIDAD JUAN PABLO II',
        //     '35'=>'UNIVERSIDAD ESCUELA LIBRE DE DERECHO',
        //     '36'=>'UNIVERSIDAD METROPOLITANA CASTRO CARAZO',
        //     '37'=>'UNIVERSIDAD INDEPENDIENTE DE COSTA RICA',
        //     '38'=>'UNIVERSIDAD CENTROAMERICANA DE CIENCIAS EMPRESARIALES',
        //     '39'=>'UNIVERSIDAD BIBLICA LATINOAMERICANA',
        //     '40'=>'UNIVERSIDAD DE LAS CIENCIAS Y EL ARTE DE COSTA RICA',
        //     '41'=>'UNIVERSIDAD AMERICANA',
        //     '42'=>'UNIVERSIDAD INTERNACIONAL SAN ISIDRO LABRADOR',
        //     '43'=>'UNIVERSIDAD EMPRESARIAL DE COSTA RICA',
        //     '44'=>'UNIVERSIDAD DEL VALLE',
        //     '45'=>'UNIVERSIDAD CRISTIANA DEL SUR',
        //     '46'=>'UNIVERSIDAD TECNOLOGICA COSTARRICENSE',
        //     '47'=>'UNIVERSIDAD CONTINENTAL DE LAS CIENCIAS Y LAS ARTES',
        //     '48'=>'UNIVERSIDAD METODISTA',
        //     '49'=>'UNIVERSIDAD PEDAGOGICA',
        //     '50'=>'UNIVERSIDAD DE CIENCIAS MEDICAS (UCIMED)',
        //     '51'=>'UNIVERSIDAD ALMA MATER',
        //     '52'=>'UNIVERSIDAD SANTA PAULA',
        //     '53'=>'UNIVERSIDAD CREATIVA',
        //     '54'=>'COLEGIO UNIVERSITARIO DE RIEGO Y DESARROLLO TROPICAL SE',
        //     '55'=>'UNIVERSIDAD CRISTIANA INTERNACIONAL',
        //     '56'=>'UNIVERSIDAD CENTROAMERICANA DE CIENCIAS SOCIALES',
        //     '57'=>'UNIVERSIDAD DEL DESARROLLO HUMANO',
        //     '58'=>'UNIVERSIDAD TECNICA NACIONAL',
        //     '80'=>'COLEGIO UNIVERSITARIO DE CARTAGO (CUC)',
        //     '81'=>'EARTH',
        //     '82'=>'ECAG',
        //     '83'=>'INSTITUTO NACIONAL DE APRENDIZAJE (INA)',
        //     '88'=>'EXTRANJERO',
        //     '84'=>'ESCUELAS COMERCIALES',
        //     '85'=>'UNIVERSIDAD INVENIO',
        //     '86'=>'UNIVERSIDAD DE LIDERAZGO, EXCELENCIA, AVANCE Y DESARROLLO',
        //     '87'=>'UNIVERSIDAD POLITÉCNICA NACIONAL',
        //     '89'=>'UNIVERSIDAD NEOTROPICAL',
        //     '90'=>'UNIVERSIDAD CENFOTEC',
        //     '91'=>'UNIVERSIDAD LATINA HEREDIA',
        //     '92'=>'UNIVERSIDAD TEOLÓGICA DE AMÉRICA CENTRAL'
        // ];

        // foreach($universidades as $clave => $valor) {
        //     $universidad = Universidad::create([
        //         'codigo'  =>$clave,
        //         'nombre'  =>$valor,
        //         'id_tipo' => 2
        //     ]);
        // }

        //Se crean los grados DIPLOMADO, BACHILLER, LICENCIATURA
        $grados = [
            '2'=>'DIPLOMADO',
            '3'=>'PROFESORADO',
            '4'=>'BACHILLERATO',
            '5'=>'LICENCIATURA'
        ];

        foreach($grados as $clave => $valor) {
            $grado = Grado::create([
                'codigo'  =>$clave,
                'nombre'  =>$valor,
                'id_tipo' => 3
            ]);
        }

        //Se crean las carreras
        // $faker = Faker\Factory::create();
        // $carreras =[];

        // for($i=0; $i<200; $i++) {
        //     $carreras[] = $faker->sentence;
        // }

        // foreach($carreras as $clave => $valor) {
        //     $nueva_carrera = Carrera::create([
        //         'codigo'  =>$clave+1,
        //         'nombre'  =>$valor,
        //         'id_tipo' => 1
        //     ]);
        // }

        //Se crean las agrupaciones
        $agrupaciones = [
            '1'=>'UCR',
            '2'=>'UNED',
            '3'=>'UTN',
            '4'=>'ITCR',
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
