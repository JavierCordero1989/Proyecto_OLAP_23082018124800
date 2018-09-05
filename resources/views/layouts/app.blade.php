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

    {{-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_bootstrap')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_fontawesome')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_select2')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app/AdminLTE.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_adminlte')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/_all-skins.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app/_all-skins.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_allskins')}}">
    <link rel="stylesheet" href="{{ asset(config('global.css.link_skin_conare')) }}">
    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app/ionicons.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_ionicons')}}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app/_all.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_all')}}">

    {{-- <link rel="stylesheet" href="{{ asset('css/app/all.css') }}"> --}}
    <link rel="stylesheet" href="{{ config('global.css.link_all_2') }}">
    
    <!-- Estilos con los colores de la paleta de colores del CONARE -->
    <style>
        .btn-info {
            background-color: #003865;
            border-color: #003865;
        }

        .btn-info:focus {
            background-color: #003865;
            border-color: #003865;
        }

        .btn-info:hover {
            background-color: #CCCCCC;
            border-color: #CCCCCC;
            color: #000000;
            transition: 0.5s;
        }

        .btn-primary {
            background-color: #80C6CF;
            border-color: #003865;
            color: #000000;
        }

        .btn-primary:hover {
            background-color: #CCCCCC;
            color: #000000;
            transition: 0.5s;
        }
    </style>
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
            <span class="logo-lg"><b>{{ config('global.sidebar_title') }}</b></span>
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
                                    @if(Auth::user()->hasRole('Super Admin'))
                                        <a href="{!! route('users.edit', [Auth::user()->id]) !!}" class="btn btn-default btn-flat">Perfil</a>
                                    @endif

                                    @if(Auth::user()->hasRole('Encuestador'))
                                        <a href="{!! route('encuestadores.cambiar-contrasennia', [Auth::user()->id]) !!}" class="btn btn-default btn-flat">Cambiar contraseña</a>
                                    @endif

                                    @if(Auth::user()->hasRole('Supervisor'))
                                        <a href="{!! route('users.edit', [Auth::user()->id]) !!}" class="btn btn-default btn-flat">Perfil</a>
                                    @endif
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
        <strong>Copyright © 2018 <a href="{{ config('global.footer_link') }}" target="_blank">{{ config('global.footer_text') }}</a>.</strong> Derechos Reservados.

        {{-- <div class="module deepest">
            <ul class="menu menu-inline">
                <li class="level1"><a href="" class="level1"><span>Inicio</span></a></li>
                <li class="level1"><a href="" class="level1"><span>Correo institucional</span></a></li>
            </ul>
        </div> --}}
    </footer>

</div>


<!-- jQuery 3.1.1 -->
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
{{-- <script src="{{ asset('js/app/jquery.min.js') }}"></script> --}}
<script src="{{ config('global.js.link_jquery') }}"></script>
{{-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
{{-- <script src="{{ asset('js/app/bootstrap.min.js') }}"></script> --}}
<script src="{{ config('global.js.link_bootstrap') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}
{{-- <script src="{{ asset('js/app/select2.min.js') }}"></script> --}}
<script src="{{ config('global.js.link_select2') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script> --}}
{{-- <script src="{{ asset('js/app/icheck.min.js') }}"></script> --}}
<script src="{{ config('global.js.link_icheck') }}"></script>

<!-- AdminLTE App -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js"></script> --}}
{{-- <script src="{{ asset('js/app/app.min.js') }}"></script> --}}
<script src="{{ config('global.js.link_app') }}"></script>

@yield('scripts')
</body>
</html>