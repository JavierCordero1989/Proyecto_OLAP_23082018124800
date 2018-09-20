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
                    {!! Form::open(['route'=>['calendario.guardar-cita', $entrevista]]) !!}
                        <div class="form-group col-xs-6 col-xs-offset-3">
                                {{-- <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> --}}
                            {!! Form::label('fecha_de_cita', 'Fecha de la cita:') !!}
                            {!! Form::text('fecha_de_cita', \Carbon\Carbon::now()->format('d/m/Y'), ['class'=>'form-control datepicker', 'readonly'=>'readonly']) !!}
                        </div>

                        <div class="form-group col-xs-6 col-xs-offset-3">
                            {!! Form::label('hora_de_cita', 'Hora de la cita:') !!}
                            {!! Form::text('hora_de_cita', \Carbon\Carbon::now()->format('H:i:s'), ['class' => 'timepicker form-control']) !!}
                        </div>

                        <!-- Fecha de parque marino -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('fecha', 'Fecha Inicial:') !!}
                            <div class="bfh-datepicker" data-name="fechaInicial" data-format="y-m-d" data-min="today"></div>
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('hora_alimentacion', 'Hora Alimentacion:') !!}
                            <div class="bfh-timepicker" data-name="hora_alimentacion" data-mode="12h"></div>
                        </div>

                        <div class="form-group col-xs-6 col-xs-offset-3">
                            {!! Form::label('motivo_de_cita', 'Motivo de la cita:') !!}
                            {!! Form::textarea('motivo_de_cita', null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-6 col-sm-offset-3">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary col-sm-4']) !!}
                            <a href="{!! route('asignar-encuestas.realizar-entrevista', $entrevista) !!}" class="btn btn-default col-sm-4 col-sm-offset-4">Cancelar</a>
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
    <script type="text/javascript" src="{{ asset('form-helper/js/bootstrap-formhelpers.js') }}"></script>
    
    <script>
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            startDate: '-1d', // No permite seleccionar los dias en uno menos que el actual
            weekStart: 0, //0 = Domingo
            // todayBtn: true,
            language: "es",
            autoclose: true,
            todayHighlight: true,
        }); 
    </script>

    <script>
        $('.timepicker').datetimepicker({
            format: 'HH:mm:ss'
        });
    </script>
@endsection