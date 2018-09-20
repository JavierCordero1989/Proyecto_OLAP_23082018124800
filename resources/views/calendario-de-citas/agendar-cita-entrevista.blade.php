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
                    {!! Form::open(['route'=>[$rutas['store'], $datos_a_vista['entrevista'], $datos_a_vista['encuestador']], 'onsubmit'=>'return validar_submit();']) !!}
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
                            {!! Form::label('observacion_de_cita', 'Observación de la cita:') !!}
                            {!! Form::textarea('observacion_de_cita', null, ['class'=>'form-control', 'maxlength'=>'200', 'cols'=>200, 'rows'=>4]) !!}
                            <div id="caracteres_restantes"></div>
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
    <script>
        $(document).ready(function() {
            var caracteres_maximos = 200;
            $('#caracteres_restantes').html(caracteres_maximos + ' caracteres restantes');

            $('#observacion_de_cita').on('keyup', function() {
                var tamannio_texto = $(this).val().length;
                var restantes = caracteres_maximos - tamannio_texto;

                $('#caracteres_restantes').html(restantes + ' caracteres restantes');
            });
        });

        function validar_submit() {
            // var fecha = $('[name=fecha_de_cita]').val();
            // var hora = $('[name=hora_de_cita]').val();
            var contacto = $('[name=numero_contacto]').val();
            var observacion = $('[name=observacion_de_cita]').val();

            if(contacto.length == 0) {
                alert('Debe ingresar un número de teléfono al cuál contactar.');
                return false;
            }
            else {
                if(observacion.length == 0) {
                    return confirm('¿Desea dejar el campo para la observación vacío?\n\nTome en cuenta que es información vital para la cita que está agendando.');
                }
                else {
                    return true;
                }
            }
        }
    </script>
@endsection