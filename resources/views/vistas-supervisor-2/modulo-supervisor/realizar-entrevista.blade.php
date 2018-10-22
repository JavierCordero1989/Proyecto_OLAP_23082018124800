@extends('layouts.app')

@section('title', 'Mis entrevistas') 

@section('content')
    <section class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <!-- Campo para la información de los contactos -->
                <div class="col-sm-12">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle col-sm-12" type="button" id="dropdownEnlacesInfoContacto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fas fa-address-card"></i>
                            <span class="caret"></span>
                            Información de contacto
                        </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownEnlacesInfoContacto">
                                <!-- Se agrega un boton por cada registro de contacto que tenga cada encuesta, mediante un foreach -->
                                @foreach($entrevista->contactos as $contacto)
                                    <li>
                                        <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->nombre_referencia !!}</a>
                                    </li>
                                @endforeach
                                <li><a href="{!! route('supervisor2.agregar-contacto-entrevista', $entrevista->id ) !!}">Agregar contacto</a></li>
                            </ul>

                            <!-- Se agregan los modales mediante un foreach -->
                            @foreach($entrevista->contactos as $contacto) 
                                @include('vistas-supervisor-2.modulo-supervisor.modal_info_de_contacto')
                            @endforeach
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <!-- Botón para agendar cita -->
                <a href="{!! route('calendario.agendar-cita', [Auth::user()->id, '1a', $entrevista->id, '1b']) !!}" class="btn btn-primary btn-sm col-sm-12">
                    <i class="far fa-calendar-plus"></i> Agendar cita
                </a>
            </div>
        </div>
    </section>

    <div class="content">

        <div class="clearfix"></div>
            @include('flash::message')
        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($entrevista, ['route' => ['supervisor2.actualizar-entrevista', $entrevista->id], 'method' => 'patch', 'onsubmit'=>'return revisar_estado();']) !!}

                        <!-- Campo de la Identificación -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('identificacion_graduado', 'Identificación:') !!}
                            {!! Form::text('identificacion_graduado', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del nombre completo -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('nombre_completo', 'Nombre completo:') !!}
                            {!! Form::text('nombre_completo', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del token -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('token', 'Token:') !!}
                            {!! Form::text('token', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del año de graduación -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('annio_graduacion', 'Año de graduación:') !!}
                            {!! Form::text('annio_graduacion', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del link de la encuesta -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('link_encuesta', 'Link para la encuesta:') !!}

                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEnlaceEncuesta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fas fa-link"></i>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownEnlaceEncuesta">
                                    <li>
                                        <a href="{!! $entrevista->link_encuesta !!}" target="_blank"><i class="fas fa-eye"></i> {!! $entrevista->link_encuesta !!} </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Campo del sexo -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('sexo', 'Sexo:') !!}
                            {!! Form::text('sexo', ($entrevista->sexo == 'M' ? 'MASCULINO' : ($entrevista->sexo == 'F' ? 'FEMENINO' : 'INDEFINIDO')), ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo de la carrera -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('carrera', 'Carrera:') !!}
                            {!! Form::text('carrera', $entrevista->carrera->nombre, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo de la universidad -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('universidad', 'Universidad:') !!}
                            {!! Form::text('universidad', $entrevista->universidad->nombre, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                        
                        <!-- Campo del grado -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('grado', 'Grado:') !!}
                            {!! Form::text('grado', $entrevista->grado->nombre, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo de la disciplina -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('disciplina', 'Disciplina:') !!}
                            {!! Form::text('disciplina', $entrevista->disciplina->descriptivo, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del area -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('area', 'Área:') !!}
                            {!! Form::text('area', $entrevista->area->descriptivo, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo de la agrupacion -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('agrupacion', 'Agrupación:') !!}
                            {!! Form::text('agrupacion', $entrevista->agrupacion->nombre, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del sector -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('sector', 'Sector:') !!}
                            {!! Form::text('sector', $entrevista->sector->nombre, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del tipo de caso -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('tipo_de_caso', 'Tipo de caso:') !!}
                            {!! Form::text('tipo_de_caso', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <div class="form-group col-sm-4">
                            {!! Form::label('estados', 'Estados:') !!}
                            {!! Form::select('estados', $estados, $entrevista->estado()->id, ['class' => 'form-control', 'placeholder'=>'Elija un estado']) !!}
                        </div>

                        <!-- Campo del tipo de caso -->
                        <div class="form-group col-sm-12 {{--col-sm-offset-3--}}">
                            {!! Form::label('observacion', 'Observación:') !!}
                            {!! Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => 6]) !!}
                        </div>

                        <!-- Campo para los botones -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary col-sm-4']) !!}
                            <a href="{!! route('supervisor2.encuestas-asignadas-por-supervisor', Auth::user()->id) !!}" class="btn btn-default col-sm-4 col-sm-offset-4">Cancelar</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Script para validar que se elija un estado antes de guardar y que además se consulta si el campo para 
    observaciones está vacío. -->
    <script>
        
        function revisar_estado() {
            var valor_estado = $('#estados').val();

            if(valor_estado == "") {
                alert('Debe seleccionar un estado primero.');
                return false;
            }
            else {
                var campo_observacion = $('#observacion').val();

                if(campo_observacion == "") {
                    return confirm('¿Desea dejar el campo para la observación en blanco?');
                }

                return true;
            }
        }
    </script>
@endsection