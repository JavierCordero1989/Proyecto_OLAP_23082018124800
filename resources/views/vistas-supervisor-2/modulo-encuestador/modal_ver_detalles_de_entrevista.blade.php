<div class="modal modal-default fade" id="modal-ver-detalles-de-entrevista-{{$entrevista->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Datos detallados de la entrevista</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-left: 20px">
                    <div class="col-xs-12">
                        <!-- Caja para el estado actual de la encuesta -->
                        <div class="col-xs-6">
                            {!! Form::label('estado_encuesta', 'Estado actual:') !!}
                            <p>{!! $entrevista->estado()->estado !!}</p>
                        </div>

                        <!-- Identificación del graduado de la entrevista -->
                        <div class="col-xs-6">
                            {!! Form::label('identificacion_graduado', 'Identificación del graduado:') !!}
                            <p>{!! $entrevista->identificacion_graduado !!}</p>
                        </div>

                        <!-- Nombre completo del graduado -->
                        <div class="col-xs-6">
                            {!! Form::label('nombre_completo', 'Nombre completo:') !!}
                            <p>{!! $entrevista->nombre_completo !!}</p>
                        </div>

                        <!-- Token del graduado -->
                        <div class="col-xs-6">
                            {!! Form::label('token', 'Token:') !!}
                            <p>{!! $entrevista->token !!}</p>
                        </div>
    
                        <!-- Año de graduación -->
                        <div class="col-xs-6">
                            {!! Form::label('annio_graduacion', 'Año de graduación:') !!}
                            <p>{!! $entrevista->annio_graduacion !!}</p>
                        </div>
    
                        <!-- Link para la encuesta -->
                        <div class="col-xs-6">
                            {!! Form::label('link_encuesta', 'Link de la encuesta:') !!}
                            <a href="{!! $entrevista->link_encuesta !!}" target="_blank">{!! $entrevista->link_encuesta !!}</a>
                        </div>
    
                        <!-- Sexo del graduado -->
                        <div class="col-xs-6">
                            {!! Form::label('sexo', 'Sexo:') !!}
                            <p>{!! $entrevista->sexo !!}</p>
                        </div>
    
                        <!-- Modal para ver la información de detalle de los contactos que pertenecen a la entrevista -->
                        <div class="col-xs-6">
                            {!! Form::label('info_de_contacto', 'Información de contacto') !!}

                            @if(sizeof($entrevista->contactos) <= 0)
                                <p class="text-danger text-uppercase">Esta entrevista no tiene información de contacto</p>
                            @else
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEnlacesInfoContacto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fas fa-address-card"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownEnlacesInfoContacto">
                                        <!-- Se agrega un boton por cada registro de contacto que tenga cada encuesta, mediante un foreach -->
                                        @foreach($entrevista->contactos as $contacto)
                                            <li>
                                                <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->nombre_referencia !!}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- Se agregan los modales mediante un foreach -->
                                    @foreach($entrevista->contactos as $contacto) 
                                        @include('vistas-supervisor-2.modulo-encuestador.modal_info_contacto')
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Carrera -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_carrera', 'Carrera:') !!}
                            <p>{!! $entrevista->carrera->nombre !!}</p>
                        </div>
    
                        <!-- Universidad -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_universidad', 'Universidad:') !!}
                            <p>{!! $entrevista->universidad->nombre !!}</p>
                        </div>
    
                        <!-- Grado -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_grado', 'Grado:') !!}
                            <p>{!! $entrevista->grado->nombre !!}</p>
                        </div>
    
                        <!-- Disciplina -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_disciplina', 'Disciplina:') !!}
                            <p>{!! $entrevista->disciplina->descriptivo !!}</p>
                        </div>
    
                        <!-- Área -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_area', 'Área:') !!}
                            <p>{!! $entrevista->area->descriptivo !!}</p>
                        </div>
    
                        <!-- Agrupación -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_agrupacion', 'Agrupación:') !!}
                            <p>{!! $entrevista->agrupacion->nombre !!}</p>
                        </div>
    
                        <!-- Sector -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_sector', 'Sector:') !!}
                            <p>{!! $entrevista->sector->nombre !!}</p>
                        </div>
    
                        <!-- Tipo de caso -->
                        <div class="col-xs-6">
                            {!! Form::label('tipo_de_caso', 'Tipo de caso:') !!}
                            <p>{!! $entrevista->tipo_de_caso !!}</p>
                        </div>
                    </div>
                    
                    <!--Botón para volver a atrás-->
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Volver</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>