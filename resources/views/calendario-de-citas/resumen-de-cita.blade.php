@extends('layouts.app')

@section('title', 'Resumen de cita')

@section('content')
    <div class="content">
            @php
                $col_label = 'col-md-4';
                $col_input = 'col-md-6';
                $fecha = \Carbon\Carbon::parse($data['cita']->fecha_hora);
            @endphp
            <h3 class="text-center">
                Resumen de la cita
            </h3>
            <div class="clearfix"></div>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body with-border">
                        {!! Form::open(['class'=>'form-horizontal']) !!}
                            <fieldset>
                                <div class="form-group">
                                    <label for="" class="control-label {{$col_label}}">Fecha: </label>
                                    <div class="{{ $col_input }} inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                            </span>
                                            {!! Form::text('fecha', $fecha->format('Y-m-d'), ['class'=>'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label {{$col_label}}">Hora: </label>
                                    <div class="{{ $col_input }} inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-time"></i>
                                            </span>
                                            {!! Form::text('hora', $fecha->format('H:i'), ['class'=>'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- contacto -->
                                <div class="form-group">
                                    <label for="" class="control-label {{$col_label}}">Contacto: </label>
                                    <div class="{{ $col_input }} inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-phone-alt"></i>
                                            </span>
                                            {!! Form::text('contacto', $data['cita']->numero_contacto, ['class'=>'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- observacion -->
                                <div class="form-group">
                                    <label for="" class="control-label {{$col_label}}">Observación: </label>
                                    <div class="{{ $col_input }} inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </span>
                                            {!! Form::textarea('observacion', $data['cita']->observacion, ['class'=>'form-control', 'readonly', 'maxlength'=>'200', 'cols'=>200, 'rows'=>4]) !!}
                                        </div>
                                    </div>
                                </div>

                                <!-- estado -->
                                {!! Form::hidden('estado', $data['cita']->estado) !!}

                                <!-- encuestador -->
                                <div class="form-group">
                                    <label for="" class="control-label {{$col_label}}">Usuario que concertó la cita: </label>
                                    <div class="{{ $col_input }} inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-user"></i>
                                            </span>
                                            {!! Form::text('encuestador', $data['encuestador']->name, ['class'=>'form-control', 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>

                                @if (!is_null($data['entrevista']))
                                    <!-- entrevista -->
                                    <div class="form-group">
                                        <label for="" class="control-label {{$col_label}}">Persona a contactar: </label>
                                        <div class="{{ $col_input }} inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-list-alt"></i>
                                                </span>
                                                {!! Form::text('entrevista', $data['entrevista']->nombre_completo, ['class'=>'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- entrevista -->
                                    <div class="form-group">
                                        <label for="" class="control-label {{$col_label}}"></label>
                                        <div class="{{ $col_input }} inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="glyphicon glyphicon-info-sign"></i>
                                                </span>
                                                {!! Form::text('entrevista', 'Este es un recordatorio para una entrevista', ['class'=>'form-control', 'readonly']) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- botón de volver -->
                                <div class="form-group">
                                    <label for="" class="control-label {{$col_label}}"></label>
                                    <div class="{{ $col_input }} inputGroupContainer">
                                        <div class="input-group">
                                            <a href="{!! route('ver-calendario', $data['encuestador']->id) !!}" class="btn btn-default">
                                                <i class="glyphicon glyphicon-arrow-left"></i>
                                                Volver
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
    </div>
@endsection