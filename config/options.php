<?php
    return [
        'sex_types' => [
            ''=>'- - - SEXO - - -',
            'M'=>'HOMBRE',
            'F'=>'MUJER',
            'SC'=>'SIN CLASIFICAR'
        ],
        'case_types' => [
            '' => '- - - TIPOS DE CASO - - -',
            'CENSO'=>'CENSO',
            'MUESTRA'=>'MUESTRA',
            'REEMPLAZO'=>'REEMPLAZO'
        ],
        'group_types' => [
            '' => '- - - AGRUPACIÓN - - -',
            '1' => 'UCR',
            '4' => 'UNED',
            '58' => 'UTN',
            '2' => 'ITCR',
            '3' => 'UNA',
            '6' => 'PRIVADO'

        ],
        'grade_types' => [
            '' => '- - - GRADOS - - -',
            '3'=>'PREGRADO', // Corresponde a Profesorado y Diplomado, códigos 3 y 2 respectivamente
            '4'=>'BACHILLERATO',
            '5'=>'LICENCIATURA',
        ],
        // 'grade_types_used' => [
        //     'PREGRADO'=>'PREGRADO',
        //     'BACHILLERATO'=>'BACHILLERATO',
        //     'LICENCIATURA'=>'LICENCIATURA',
        // ],
        'survey_estatuses' => [
            '' => '- - - ESTADOS - - -',
            '1' => 'NO ASIGNADA',
            '2' => 'ASIGNADA',
            '3' => 'RECHAZADA',
            '4' => 'INCOMPLETA',
            '5' => 'FUERA DEL PAÍS',
            '6' => 'ILOCALIZABLE',
            '7' => 'FALLECIDO',
            // '8' => 'EXTRANJERO',
            '9' => 'CON CITA',
            '10' =>	'MENSAJE',
            '11' =>	'LINK AL CORREO',
            '12' =>	'INFORMACIÓN POR CORREO',
            '13' =>	'ENTREVISTA COMPLETA',
            '14' =>	'RECORDATORIO',
            '15' =>	'DISCIPLINA NO CORRESPONDE',
        ],
        'survey_estatuses_used' => [
            '' => '- - - ESTADOS - - -',
            '3' => 'RECHAZADA',
            '4' => 'INCOMPLETA',
            '5' => 'FUERA DEL PAÍS',
            '6' => 'ILOCALIZABLE',
            '7' => 'FALLECIDO',
            '9' => 'CON CITA',
            '10' =>	'MENSAJE',
            '11' =>	'LINK AL CORREO',
            '12' =>	'INFORMACIÓN POR CORREO',
            '13' =>	'ENTREVISTA COMPLETA',
            '14' =>	'RECORDATORIO',
            '15' =>	'DISCIPLINA NO CORRESPONDE',
        ],
        'sector_types' => [
            '' => '- - - SELECCIONE - - -',
            '1'=>'PÚBLICO',
            '2'=>'PRIVADO',
        ]
    ];
?>