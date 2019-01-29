<?php
    return [
        'nombre_sistema'             => 'Sistema Automatizado de Encuestas',
        'olap_login'                 =>'img/logo_oficial_olap_transparente.png',
        'conare_login'               => 'img/logo_oficial_conare_transparente.png',
        'shortcut-icon'              => 'img/olap.png',
        'site_title'                 => 'SAE',
        'sidebar_title'              => 'Sistema S.A.E',
        'sidebar_title_min'          => 'S.A.E',
        'login_title'                => 'CONARE - OLaP',
        'img_app'                    => 'img/olap.png',
        'logo_conare'                => 'img/logo_conare.png',
        'imagen_tarjetas'            => 'img/logo_olap.png',
        'texto_olap'                 => 'OLaP',
        'link_olap'                  => 'http://olap.conare.ac.cr/',
        'texto_correo_institucional' => 'Correo Institucional',
        'link_correo_institucional'  => 'https://mail.conare.ac.cr/',
        'texto_conare'               => 'CONARE',
        'link_conare'                => 'https://www.conare.ac.cr/',
        'css' => [
            'link_datatables'     => 'https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css',
            // 'link_datatables'  => asset('css/datatables/dataTables.bootstrap.min.css'),
        ],
        'js' => [
            'link_datatables_1'    => 'https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
            // 'link_datatables_1' => asset('js/datatables/jquery.dataTables.min.js'),
            'link_datatables_2'    => 'https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js',
            // 'link_datatables_2' => asset('js/datatables/dataTables.bootstrap.min.js'),
        ],
        'colores' => [
            'conare' => [
                'azul_oscuro'   => '#003865',
                'azul_claro'    => '#80C6CF',
                'gris'          => '#CCCCCC',
                'verde'         => '#62A60A',
                'naranja'       => '#FF8200'
            ],
            'universidad' => [
                'UCR'   => '#5BC2E7',
                'TEC'   => '#002855',
                'UNA'   => '#E4002B',
                'UNED'  => '#00ADFF',
                'UTN'   => '#00205B'
            ]
        ],
        'iconos_estados' => [
            'NO ASIGNADA'               => 'ion-close-circled',
            'ASIGNADA'                  => 'ion-checkmark-round',
            'RECHAZADA'                 => 'ion-close-round',
            'INCOMPLETA'                => 'ion-android-checkmark-circle',
            'FUERA DEL PAÍS'            => 'ion-plane',
            'ILOCALIZABLE'              => 'ion-sad-outline',
            'FALLECIDO'                 => 'fas fa-ban',
            'EXTRANJERO'                => 'ion-ios-location',
            'CON CITA'                  => 'ion-calendar',
            'MENSAJE'                   => 'ion-android-textsms',
            'LINK AL CORREO'            => 'ion-ios-list-outline',
            'INFORMACIÓN POR CORREO'    => 'ion-email',
            'ENTREVISTA COMPLETA'       => 'ion-android-done-all',
            'RECORDATORIO'              => 'ion-compose',
            'DISCIPLINA NO CORRESPONDE' => 'ion ion-information-circled',
            'TOTAL DE ENTREVISTAS'      => 'ion-earth'
        ],
    ];
?>