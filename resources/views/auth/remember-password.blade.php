<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{!! config('global.login_title') !!}</title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <!-- Theme style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css">

        <!-- iCheck -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">
        {{-- <link rel="stylesheet" href="{!! asset('css/estilos-login.css') !!}"> --}}
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

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
    </head>

    <body class="hold-transition login-page">

        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><b>CONARE </b>OLaP</a>
            </div>
        
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Ingrese su correo electrónico para realizar la solicitud</p>
        
                {!! Form::open(['route'=>'security.send-password-request']) !!}
                    <div class="form-group has-feedback {{ isset($error) ? ' has-error' : '' }}">
                        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>'Ingrese su correo']) !!}
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if (isset($error))
                            <span class="help-block">
                                <strong>{!! $error !!}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::button('<i class="fa fa-btn fa-envelope"></i> Enviar solicitud', [
                                'type'=>'submit',
                                'class'=>'btn btn-primary pull-right'
                            ]) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
        
            </div>
            <!-- /.login-box-body -->
        </div>


    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js"></script>
    {{-- <script src="{!! asset('js/script-login.js') !!}"></script> --}}
</html>