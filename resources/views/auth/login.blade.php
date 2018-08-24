<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- <meta http-equiv="Expires" content="0">

    <meta http-equiv="Last-Modified" content="0">

    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">

    <meta http-equiv="Pragma" content="no-cache"> --}}

    <title>InfyOm Laravel Generator</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app/font-awesome.min.css') }}">

    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app/ionicons.min.css') }}">

    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app/AdminLTE.min.css') }}">

    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/_all-skins.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app/_all-skins.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css"> --}}
    <link rel="stylesheet" href="{{ asset('css/app/_all.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('css/login_form.css') }}">
</head>
<body class="hold-transition login-page">

<div class="container">
    <section id="formHolder">

        <div class="row">

            {{-- BRAND BOX --}}
            <div class="col-sm-6 brand">
                <a href="#" class="logo">OLAP <span>CONARE</span></a>

                <div class="heading">
                    <img class="img-responsive center-block" src="{{ asset('img/logo_conare.png') }}" alt="">
                    {{-- <h2>Laravel 5.4</h2>
                    <p>Inicio de sesión</p> --}}
                </div>

                <div class="success-msg">
                    <p>Bienvenido, ya eres parte de nuestro equipo</p>
                    <a href="#" class="profile">Continuar <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>

            {{-- FORM BOX --}}
            <div class="col-sm-6 form">

                {{-- LOGIN FORM --}}
                <div id="login-form" class="login form-peice">
                    <form action="{{ url('/login') }}" class="login-form" method="post">
                        {!! csrf_field() !!}

                        <div class="form-group {{--has-feedback {{ $errors->has('email') ? ' has-error' : '' }}--}}">
                            <label for="email">Correo electrónico</label>
                            <input type="email" name="email" id="email" value="root@root.com">
                            {{-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> --}}
                            @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{--has-feedback {{ $errors->has('password') ? ' has-error' : '' }}--}}">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" value="root" {{--id="password"--}}>
                            {{-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> --}}
                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="CTA">
                            <input type="submit" value="Ingresar">
                            {{-- <a href="#" class="switch">Registrarme</a> --}}
                        </div>
                    </form>
                </div> <!-- End Login Form-->


                {{-- SIGNIP FORM --}}
                <div id="signup-form" class="signup form-peice switched">
                    <form action="{{ url('/register') }}" class="signup-form" method="post" id="form_registro">
                        {!! csrf_field() !!}

                        <div class="form-group {{--has-feedback{{ $errors->has('name') ? ' has-error' : '' }}--}}">
                            <label for="name">Nombre Completo</label>
                            <input type="text" name="name" {{--id="name"--}} class="name">
                            {{-- <span class="glyphicon glyphicon-user form-control-feedback"></span> --}}
                            <span class="error"></span>
                        </div>

                        <div class="form-group {{--has-feedback{{ $errors->has('email') ? ' has-error' : '' }}--}}">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" {{--id="email"--}} class="email">
                            {{-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> --}}
                            <span id="span_error_mail" class="error"></span>
                        </div>

                        <div class="form-group {{--has-feedback{{ $errors->has('password') ? ' has-error' : '' }}--}}">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" {{--id="password"--}} class="pass">
                            {{-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> --}}
                            <span class="error"></span>
                        </div>

                        <div class="form-group {{--has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}--}}">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" {{--id="passwordCon"--}} class="passConfirm">
                            {{-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> --}}
                            <span class="error"></span>
                        </div>

                        <div class="CTA">
                            <input type="submit" value="Registrarme" {{--id="submit"--}}>
                            <a href="#" class="switch">Ya tengo una cuenta</a>
                        </div>
                    </form>
                </div> <!-- End Signup Form -->
            </div>
        </div>

    </section>

    <footer>
        {{-- <p>
            Form made by: <a href="/login">Original</a>
        </p> --}}
    </footer>
</div>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
<script src="{{ asset('js/app/jquery.min.js') }}"></script>
{{-- <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}
<script src="{{ asset('js/app/bootstrap.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script> --}}
<script src="{{ asset('js/app/icheck.min.js') }}"></script>

<!-- AdminLTE App -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js"></script> --}}
<script src="{{ asset('js/app/app.min.js') }}"></script>
<script src="{{ asset('js/login_form.js') }}"></script>
</body>
</html>
