<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="{{ asset(config('global.shortcut-icon')) }}">
    {{-- <title>InfyOm Generator</title> --}}
    <title>{{ config('global.site_title') }} - @yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    @include('layouts.links-css')
    
    @yield('css')
</head>

<body class="skin-conare sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{!! url('/home') !!}" class="logo">
            {{-- <b>Javier Cordero</b> --}}
            <span class="logo-mini"><b>{{ config('global.sidebar_title_min') }}</b></span>
            {{-- <span class="logo-lg"><b>{{ config('global.sidebar_title') }}</b></span> --}}
            <span class="logo-lg"><b>{{ Auth::user()->getRoleNames()[0] }}</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    @if (Auth::user()->hasRole(['Super Admin', 'Supervisor 1', 'Supervisor 2']))
                        <li id="bandera_cambios_contrasennias" class="dropdown notifications-menu hide">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="far fa-flag"></i>
                                <span id="count_cambios" class="label label-danger">x</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li id="title_change_notifications" class="header">Tiene x solicitudes de cambio</li>
                                <li>
                                    <ul id="cambios_lista" class="menu">
                                        <!-- Aqui se colocan las notificaciones en lista -->
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li id="campana_notificaciones" class="dropdown notifications-menu hide">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="far fa-bell"></i>
                            <span id="count_notifications" class="label label-warning">x</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li id="title_count_notifications" class="header">Tiene x notificaciones</li>
                            <li>
                                <ul id="citas_lista" class="menu">
                                    {{-- <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i>
                                            Aqui para notificación
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            {{-- <li class="footer">
                                <a href="#">Ver todas</a>
                            </li> --}}
                        </ul>
                    </li>

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ asset(config('global.img_app')) }}"
                                 class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ asset(config('global.img_app')) }}"
                                     class="img-circle" alt="User Image"/>
                                <p>
                                    {!! Auth::user()->name !!}
                                    <small>Miembro desde {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    {{-- @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1', 'Supervisor 2'])) --}}
                                        <a href="{!! route('users.edit_password', [Auth::user()->id]) !!}" class="btn btn-default btn-flat">Cambiar contraseña</a>
                                    {{-- @endif --}}
                                </div>
                                
                                <div class="pull-right">
                                    <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>

    <!-- Main Footer -->
    <footer class="main-footer" style="max-height: 100px;text-align: center">
        <p class="text-center">
            <strong>Copyright © 2018</strong>
            <a href="{!! config('global.link_correo_institucional') !!}" target="_blank">{!! config('global.texto_correo_institucional') !!}</a>
            &nbsp; | &nbsp;
            <a href="{!! config('global.link_olap') !!}" target="_blank">{!! config('global.texto_olap') !!}</a>
            &nbsp; | &nbsp;
            <a href="{!! config('global.link_conare') !!}" target="_blank">{!! config('global.texto_conare') !!}</a>
        </p>
        {{-- <strong>Copyright © 2018 <a href="{{ config('global.footer_link') }}" target="_blank">{{ config('global.footer_text') }}</a>.</strong> Derechos Reservados. --}}
    </footer>

</div>

@include('layouts.links-js')

<!-- Script para cargar las alertas del calendario en la página principal en cada REFRESH-->
<script>
    $(function() {
        $('[data-toggle="popover"]').popover();
        //Solicitud para los eventos de calendario
        $.ajax({
            url: '{{ route("obtener-citas-calendario") }}',
            type: 'GET',
            cache: false,
            data: {id: '{{ Auth::user()->id }}'},
            dataType: 'json',
            success: function(data) {
                // Si vienen datos, carga la campana con las notificaciones.
                if(data.count > 0) {
                    $('#campana_notificaciones').removeClass('hide');
                    $('#campana_notificaciones').addClass('show');

                    // se coloca el número de notificaciones
                    $('#count_notifications').html(data.count);

                    // se coloca un mensaje con el total de notificaciones
                    $('#title_count_notifications').html('Tiene '+data.count+' notificaciones');

                    // se obtiene la caja que contendrá el menú
                    let menu_notificaciones = $('#citas_lista');

                    // se recorren las citas obtenidas y se agregan al menú
                    for(index in data.citas) {
                        let url = '{{route( "resumen-de-cita", ":id" )}}'
                        url = url.replace(":id", data.citas[index].id)

                        let li = $('<li>').appendTo(menu_notificaciones);
                        let a = $('<a>', { 'href': url }).appendTo(li); //PONERLE UN LINK HACIA ALGÚN LUGAR PARA CAMBIAR EL ESTADO
                        $('<i>', {
                            'class': 'fas fa-caret-right text-aqua'
                        }).appendTo(a);

                        // a.append(' '+data.citas[index].observacion);
                        a.append(' Ir a la cita');
                    }
                }
            }, 
            statusCode: {
                404: function() { alert('Página no encontrada'); },
                500: function() { alert('Error en el servidor'); }
            },
            error: function(xhr, status) {
                console.log('Ha habido un error');
                console.log('Estatus: ' + status);
                console.log('XHR: ', xhr);
            }
        });

        let ruta_cambios = '{{ route("security.get-password-reset-requests") }}';

        //Solicitud para las peticiones de cambio de contraseña
        $.ajax({
            url: ruta_cambios,
            type: 'GET',
            cache: false,
            data: {user_role: '{{ Auth::user()->getRoleNames()[0] }}'},
            dataType: 'json',
            success: cargar_cambios_contrasennias,
            statusCode: {
                404: function() { alert('Página no encontrada'); },
                500: function() { alert('Error en el servidor'); }
            },
            error: function(xhr, status) {
                console.log('Ha habido un error');
                console.log('Estatus: ' + status);
                console.log('XHR: ', xhr);
            }
        });
    });

    function cargar_cambios_contrasennias(data) {
        // console.log(data);
        // Si vienen datos, carga la campana con las notificaciones.
        if(data.count > 0) {
            $('#bandera_cambios_contrasennias').removeClass('hide');
            $('#bandera_cambios_contrasennias').addClass('show');

            // se coloca el número de notificaciones
            $('#count_cambios').html(data.count);

            // se coloca un mensaje con el total de notificaciones
            $('#title_change_notifications').html('Tiene <b>'+data.count+'</b> solicitudes de cambio');

            // se obtiene la caja que contendrá el menú
            let menu_notificaciones = $('#cambios_lista');

            // se recorren las citas obtenidas y se agregan al menú
            for(index in data.datos) {
                //Se crea la URL para cada enlace de cambio de contraseña
                let url = '{{ route("security.change-password", ":email") }}';
                url = url.replace(":email", data.datos[index].email);

                let li = $('<li>').appendTo(menu_notificaciones);
                let a = $('<a>', { 'href': url }).appendTo(li); //PONERLE UN LINK HACIA ALGÚN LUGAR PARA CAMBIAR EL ESTADO
                $('<i>', {
                    'class': 'fas fa-users text-aqua'
                }).appendTo(a);
                a.append(' '+data.datos[index].email);
            }
        }
    }
</script>

@yield('scripts')
</body>
</html>