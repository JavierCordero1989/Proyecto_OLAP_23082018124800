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
        // Áreas del catálogo de datos de la División de Planificación Interuniversitaria
        $areas = [
            '1'=>'Artes y Letras',
            '2'=>'Ciencias básicas',
            '3'=>'Computación',
            '4'=>'Ciencias Económicas',
            '5'=>'Ciencias Sociales',
            '6'=>'Derecho',
            '7'=>'Educación',
            '8'=>'Recursos Naturales',
            '9'=>'Ingeniería',
            '10'=>'Ciencias de la Salud'
        ];

        /* Se recorre el arreglo con las áreas para guardarlas en la BD */
        foreach($areas as $llave => $valor) {
            $nueva_area = Area::create([
                'codigo'      => $llave,
                'descriptivo' => $valor
            ]);
        }

        // Disciplinas del catálogo de datos de la División de Planificación Interuniversitaria
        $disciplinas = [
            '1' => [
                '10000'=>'Artes y Letras',
                '10001'=>'Artes Dramáticas',
                '10002'=>'Artes Plásticas',
                '10003'=>'Diseño Gráfico',
                '10004'=>'Fotografía',
                '10005'=>'Artesanía',
                '10006'=>'Arte Publicitario',
                '10007'=>'Artes Musicales',
                '10008'=>'Danza',
                '10009'=>'Historia del Arte',
                '10010'=>'Diseño de Interiores',
                '10011'=>'Literatura y Lingüística (Español)',
                '10012'=>'Lenguas',
                '10013'=>'Inglés',
                '10014'=>'Francés',
                '10015'=>'Filosofía',
                '10016'=>'Teología',
                '10018'=>'Producción de Cine y Televisión',
                '10019'=>'Artes Culinarias',
                '10020'=>'Formación General',
                '10022'=>'Museología',
                '10023'=>'Ciencias Cognitivas'
            ],
            '2' => [
                '20001'=>'Ciencias',
                '20002'=>'Biología',
                '20003'=>'Física',
                '20004'=>'Geología',
                '20005'=>'Estadística',
                '20006'=>'Matemática',
                '20007'=>'Meteorología',
                '20008'=>'Química',
                '20009'=>'Laboratorista Químico'
            ],
            '3' => [
                '30001'=>'Administración de Tecnologías de Información',
                '30004'=>'Ciencias de la Computación',
                '30005'=>'Ingeniería de Computadores',
                '30006'=>'Ingeniería del Software',
                '30007'=>'Desarrollo de Software',
                '30008'=>'Ingeniería de Computadores',
                '30009'=>'Informática Empresarial'
            ],
            '4' => [
                '40001'=>'Administración',
                '40002'=>'Administración de Seguros',
                '40003'=>'Administración del Transporte',
                '40004'=>'Comercio Internacional',
                '40005'=>'Administración de Cooperativas',
                '40006'=>'Administración de la Producción',
                '40007'=>'Proveeduría',
                '40008'=>'Administración de Proyectos',
                '40009'=>'Valuación',
                '40010'=>'Administración de Recursos Humanos',
                '40011'=>'Administración Pública',
                '40012'=>'Contaduría',
                '40013'=>'Finanzas',
                '40014'=>'Mercadeo',
                '40015'=>'Administración de Empresas Agropecuarias',
                '40016'=>'Administración de Servicios de Salud',
                '40017'=>'Administración Tributaria',
                '40018'=>'Gestión de Tecnología',
                '40019'=>'Economía',
                '40020'=>'Planificación'
            ],
            '5' => [
                '50000'=>'Ciencias Sociales',
                '50001'=>'Archivísta',
                '50002'=>'Secretario Profesional',
                '50003'=>'Antropología',
                '50004'=>'Comunicación',
                '50005'=>'Periodismo',
                '50006'=>'Publicidad',
                '50007'=>'Relaciones Públicas',
                '50008'=>'Producción Audiovisual',
                '50009'=>'Bibliotecología',
                '50010'=>'Ciencias Políticas',
                '50011'=>'Relaciones Internacionales',
                '50012'=>'Historia',
                '50013'=>'Psicología',
                '50014'=>'Sociología',
                '50015'=>'Gerontología',
                '50016'=>'Estudios Latinoamericanos',
                '50017'=>'Estudios de Género',
                '50018'=>'Farmacodependencia',
                '50019'=>'Criminología',
                '50020'=>'Estudios de Discapacidad',
                '50021'=>'Trabajo Social',
                '50022'=>'Turismo',
            ],
            '6' => [
                '60001'=>'Derecho',
                '60002'=>'Derecho Agrario',
                '60003'=>'Derecho Constitucional',
                '60004'=>'Derechos Humanos',
                '60005'=>'Derecho Empresarial',
                '60006'=>'Derecho Familiar',
                '60008'=>'Derecho Judicial',
                '60009'=>'Derecho Laboral',
                '60010'=>'Derecho Penal',
                '60012'=>'Derecho Público',
                '60013'=>'Derecho Ambiental',
                '60014'=>'Derecho Notarial',
                '60015'=>'Propiedad Intelectual',
                '60016'=>'Resolución de Conflictos',
                '60017'=>'Derecho Internacional'
            ],
            '7' => [
                '70001'=>'Educación Generalista',
                '70002'=>'Docencia',
                '70003'=>'Currículo',
                '70004'=>'Evaluación Educativa',
                '70005'=>'Investigación Educativa',
                '70006'=>'Psicopedagogía',
                '70008'=>'Tecnología Educativa',
                '70009'=>'Educación Preescolar',
                '70010'=>'Educación Preescolar Inglés',
                '70012'=>'Educación Primaria',
                '70013'=>'Educación Primaria Inglés',
                '70015'=>'Enseñanza de Castellano',
                '70016'=>'Enseñanza de Inglés',
                '70017'=>'Enseñanza de Francés',
                '70018'=>'Enseñanza de Ciencias',
                '70019'=>'Enseñanza de Matemática',
                '70020'=>'Enseñanza de Estudios Sociales',
                '70021'=>'Enseñanza de Computación',
                '70022'=>'Orientación',
                '70023'=>'Educación Física',
                '70024'=>'Enseñanza de Artes Plásticas',
                '70025'=>'Enseñanza de Música',
                '70027'=>'Educación para el Hogar',
                '70028'=>'Educación Religiosa',
                '70029'=>'Educación Especial',
                '70030'=>'Artes Industriales',
                '70032'=>'Educación Técnica Agropecuaria y de Recursos Naturales',
                '70033'=>'Educación Técnica',
                '70034'=>'Enseñanza de Filosofía',
                '70035'=>'Enseñanza de Psicología',
                '70036'=>'Enseñanza del Secretariado',
                '70038'=>'Educación Rural',
                '70039'=>'Educación de Adultos',
                '70040'=>'Administración Educativa',
                '70041'=>'Educación Técnica Industrial y de Diseño',
                '70042'=>'Enseñanza de Contabilidad'
            ],
            '8' => [
                '80001'=>'Biotecnología',
                '80002'=>'Fitotecnia',
                '80003'=>'Agronomía General',
                '80004'=>'Economía Agrícola',
                '80005'=>'Ingeniería Agropecuaria Administrativa',
                '80006'=>'Zootecnia',
                '80008'=>'Forestales',
                '80009'=>'Ecología',
                '80010'=>'Geografía',
                '80011'=>'Recursos Marinos',
                '80013'=>'Producción Animal',
                '80014'=>'Manejo de Recursos Hídricos'
            ],
            '9' => [
                '90000'=>'Ingeniería',
                '90001'=>'Arquitectura',
                '90002'=>'Ingeniería Civil',
                '90003'=>'Ingeniería Topográfica',
                '90004'=>'Ingeniería Industrial',
                '90920'=>'Ingeniería Mecatrónica',
                '90921'=>'Ingeniería Mantenimiento Industrial',
                '90005'=>'Ingeniería Mecánica',
                '90006'=>'Ingeniería Eléctrica',
                '90007'=>'Ingeniería Electrónica',
                '90008'=>'Ingeniería Química',
                '90009'=>'Diseño Industrial',
                '90010'=>'Seguridad Laboral',
                '90011'=>'Ingeniería de Materiales',
                '90012'=>'Ingeniería Agrícola',
                '90013'=>'Electromedicina',
                '90015'=>'Ingeniería de Alimentos',
                '90016'=>'Ingeniería Naútica',
                '90018'=>'Ingeniería Ambiental',
                '90019'=>'Ingeniería Agroindustrial'
            ],
            '10' => [
                '100001'=>'Medicina',
                '100003'=>'Biomédica',
                '100004'=>'Nutrición',
                '100005'=>'Optometría',
                '100006'=>'Salud Pública',
                '100007'=>'Terapia Física',
                '100008'=>'Imagenología',
                '100009'=>'Terapia Ocupacional',
                '100010'=>'Terapia Respiratoria',
                '100011'=>'Registros en Salud',
                '100012'=>'Audiología',
                '100015'=>'Radioterapia',
                '100017'=>'Odontología',
                '100018'=>'Farmacia',
                '100019'=>'Microbiología',
                '100020'=>'Enfermería',
                '100030'=>'Veterinaria',
                '100040'=>'Asistente Veterinaria',
                '100041'=>'Asistente de Laboratorio',
                '100042'=>'Emergencias Médicas',
                '100043'=>'Electrografía',
                '100044'=>'Fitoterapia',
                '100045'=>'Disección'
            ]
        ];

        /* Se recorre el arreglo de disciplinas, la cual contiene como clave el área asociada, y como valor,
           un arreglo con las disciplinas pertenecientes a dicha área asociada. Luego se recorre el arreglo con las
           disciplinas por área, para guardarlas en la BD. 
        */
        foreach($disciplinas as $llave => $disciplina) {
            foreach($disciplina as $key => $value) {
                $nueva_disciplina = Disciplina::create([
                    'codigo' => $key,
                    'descriptivo' => $value,
                    'id_area' => $llave
                ]);
            }
        }
    }
}
