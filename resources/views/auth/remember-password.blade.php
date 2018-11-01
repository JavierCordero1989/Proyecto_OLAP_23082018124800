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
@endsection

@section('title', 'Cambio de contraseña')

@section('content')
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
                            'class'=>'btn btn-primary pull-left'
                        ]) !!}

                        <a href="{!! url('/home') !!}" class="btn btn-default pull-right">
                            <i class="fa fa-btn fa-arrow-circle-left"></i>
                            Volver
                        </a>
                    </div>
                </div>
            {!! Form::close() !!}

        </div>
        <!-- /.login-box-body -->
    </div>
@endsection