@extends('layouts.app')

@section('title', 'Mis entrevistas') 

@section('content')
    <section class="content-header">
        <h1>
            Datos de la entrevista
        </h1>
    </section>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($entrevista, ['route' => ['encuestador.actualizar-entrevista', $entrevista->id], 'method' => 'patch']) !!}

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
                            <a href="{!! $entrevista->link_encuesta !!}" target="_blank"><i class="fas fa-eye"></i> Abrir enlace </a>
                            {{-- {!! Form::text('link_encuesta', null, ['class' => 'form-control', 'disabled']) !!} --}}
                        </div>

                        <!-- Campo del sexo -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('sexo', 'Sexo:') !!}
                            {!! Form::text('sexo', null, ['class' => 'form-control', 'disabled']) !!}
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
                            {!! Form::text('disciplina', $entrevista->disciplina->nombre, ['class' => 'form-control', 'disabled']) !!}
                        </div>

                        <!-- Campo del area -->
                        <div class="form-group col-sm-4 {{--col-sm-offset-3--}}">
                            {!! Form::label('area', 'Área:') !!}
                            {!! Form::text('area', $entrevista->area->nombre, ['class' => 'form-control', 'disabled']) !!}
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

                        <!-- Campo para el select de los estados -->
                        <div class="form-group col-sm-4">
                            {!! Form::label('estados', 'Estados:') !!}
                            {!! Form::select('estados', $estados, null, ['class' => 'form-control', 'placeholder'=>'Elija un estado']) !!}
                        </div>

                        <!-- Campo para la información de los contactos -->
                        <div class="form-group col-sm-4">
                            {!! Form::label('info_de_contacto', 'Información de contacto') !!}
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
                                        <li><a href="{!! route('encuestadores.agregar-contacto', $entrevista->id ) !!}">Agregar contacto</a></li>
                                    </ul>

                                    <!-- Se agregan los modales mediante un foreach -->
                                    @foreach($entrevista->contactos as $contacto) 
                                        @include('modals.modal_info_contacto')
                                    @endforeach
                            </div>
                        </div>

                        <!-- Campo para los botones -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary col-sm-4']) !!}
                            <a href="{!! route('encuestador.mis-entrevistas', Auth::user()->id) !!}" class="btn btn-default col-sm-4 col-sm-offset-4">Cancelar</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection