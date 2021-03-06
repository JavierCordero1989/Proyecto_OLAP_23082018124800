@extends('layouts.app-logout')

@section('title', 'Cambio de contraseña')

@section('css')
    <link rel="stylesheet" href="{!! asset('css/estilos-app.min.css') !!}">    
@endsection

@section('content')
    <div id="logo_1" class="col-xs-6 col-sm-4 caja_de_imagen">
        <img src="{!! asset(config('global.conare_login')) !!}" alt="logo del OLaP" class="imagen">
    </div>

    {{-- <div id="logo_1" class="col-xs-6 col-sm-4 caja_de_imagen">
        <img src="{!! asset(config('global.olap_login')) !!}" alt="logo del OLaP" class="imagen">
    </div> --}}

    {{-- <div class="login-box"> --}}
    <div id="login" class="col-xs-12 col-sm-4 caja-login">
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
                    {{-- @if (isset($error))
                        <span class="help-block">
                            <strong>{!! $error !!}</strong>
                        </span>
                    @endif --}}
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

    <div id="logo_2" class="col-xs-6 col-sm-4 caja_de_imagen">
        <img src="{!! asset(config('global.olap_login')) !!}" alt="logo del CONARE" class="imagen">
    </div>

    @include('components.error-message')

    {{-- <div id="logo_2" class="col-xs-6 col-sm-4 caja_de_imagen">
        <img src="{!! asset(config('global.conare_login')) !!}" alt="logo del CONARE" class="imagen">
    </div> --}}
@endsection

@section('scripts')
    {{-- <script src="{!! asset('js/script-login.js') !!}"></script> --}}
@endsection