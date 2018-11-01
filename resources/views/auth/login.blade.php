@extends('layouts.app-logout')

@section('css')
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

    <link rel="stylesheet" href="{!! asset('css/estilos-login.css') !!}">
@endsection

@section('title', 'Inicio de sesión')

@section('content')
    <div id="logo_1" class="col-xs-6 col-sm-4 caja_de_imagen">
        <img src="{!! asset(config('global.olap_login')) !!}" alt="logo del OLaP" class="imagen">
    </div>

    <div id="login" class="col-xs-12 col-sm-4 caja-login">

        <div class="login-logo">
            <b>{!! config('global.nombre_sistema') !!} </b>
        </div>

        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Inicio de sesión</p>

            <form method="post" action="{{ url('/login') }}">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" {{--value="root@root.com"--}} placeholder="Correo electrónico">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" {{--value="root"--}}>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif

                </div>
                <div class="row">
                    {{-- <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> Recordarme
                            </label>
                        </div>
                    </div> --}}
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <a href="{{ route('security.remember-password') }}">Olvidé mi contraseña</a><br>

        </div>
        <!-- /.login-box-body -->
    </div>

    <div id="logo_2" class="col-xs-6 col-sm-4 caja_de_imagen">
        <img src="{!! asset(config('global.conare_login')) !!}" alt="logo del CONARE" class="imagen">
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('js/script-login.js') !!}"></script>
@endsection
