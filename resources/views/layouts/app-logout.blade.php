<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="{{ asset(config('global.shortcut-icon')) }}">
        <title>{{ config('global.site_title') }} - @yield('title')</title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        @include('layouts.links-css')

        <link rel="stylesheet" href="{!! asset('css/estilos-login.css') !!}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('css')
    </head>

    <body class="hold-transition login-page">

        @yield('content')

    </body>

    @include('layouts.links-js')

    <script>
        var imagen_conare = '{!! asset("img/logo_oficial_conare_transparente.png") !!}'
        var imagen_olap = '{!! asset("img/logo_oficial_olap_transparente.png") !!}'
    </script>
    <script src="{!! asset('js/script-login.js') !!}"></script>
    @yield('scripts')
</html>