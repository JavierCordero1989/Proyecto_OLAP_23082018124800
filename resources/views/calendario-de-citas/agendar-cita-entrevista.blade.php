@extends('layouts.app')

@section('title', "Nueva cita")

@section('css')
    <link rel="stylesheet" href="{{ asset('datePicker/css/bootstrap-datepicker3.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('form-helper/css/bootstrap-formhelpers.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('datePicker/css/bootstrap-standalone.css') }}"> --}}
@endsection

@section('content')

    <div class="content">
        <!-- Mensaje flash dependiendo el tipo de accion -->
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route'=>[$rutas['store'], $datos_a_vista['entrevista']]]) !!}
                        <div class="form-group col-xs-6 col-xs-offset-3">
                            {!! Form::label('fecha_de_cita', 'Fecha de la cita:') !!}
                            <div class="bfh-datepicker" data-name="fecha_de_cita" data-format="d-m-y" data-min="today"></div>
                        </div>

                        <div class="form-group col-xs-6 col-xs-offset-3">
                            {!! Form::label('hora_de_cita', 'Hora de la cita:') !!}
                            <div class="bfh-timepicker" data-name="hora_de_cita" data-mode="12h"></div>
                        </div>

                        <div class="form-group col-xs-6 col-xs-offset-3">
                            {!! Form::label('numero_contacto', 'Número para contactar') !!}
                            {!! Form::text('numero_contacto', null, ['class'=>'form-control bfh-phone', 'data-format'=> 'dddd-dddd', 'placeholder'=>'9999-9999']) !!}
                        </div>

                        <div class="form-group col-xs-6 col-xs-offset-3">
                            {!! Form::label('motivo_de_cita', 'Motivo de la cita:') !!}
                            {!! Form::textarea('motivo_de_cita', null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-6 col-sm-offset-3">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary col-sm-4']) !!}
                            <a href="{!! route($rutas['back'], $datos_a_vista['entrevista']) !!}" class="btn btn-default col-sm-4 col-sm-offset-4">Cancelar</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('datePicker/js/bootstrap-datepicker.js')}}"></script>
    <!-- Archivo para el idioma -->
    <script src="{{asset('datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Para prueba -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('form-helper/js/bootstrap-formhelpers.min.js') }}"></script>
@endsection