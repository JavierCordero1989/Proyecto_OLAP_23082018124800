<div class="modal modal-default fade" id="modal-ver-detalles-de-entrevista-{{$encuesta->id}}">
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
                            <p>{!! $encuesta->estado()->estado !!}</p>
                        </div>

                        <!-- Identificación del graduado de la entrevista -->
                        <div class="col-xs-6">
                            {!! Form::label('identificacion_graduado', 'Identificación del graduado:') !!}
                            <p>{!! $encuesta->identificacion_graduado !!}</p>
                        </div>

                        <!-- Nombre completo del graduado -->
                        <div class="col-xs-6">
                            {!! Form::label('nombre_completo', 'Nombre completo:') !!}
                            <p>{!! $encuesta->nombre_completo !!}</p>
                        </div>

                        <!-- Token del graduado -->
                        <div class="col-xs-6">
                            {!! Form::label('token', 'Token:') !!}
                            <p>{!! $encuesta->token !!}</p>
                        </div>
    
                        <!-- Año de graduación -->
                        <div class="col-xs-6">
                            {!! Form::label('annio_graduacion', 'Año de graduación:') !!}
                            <p>{!! $encuesta->annio_graduacion !!}</p>
                        </div>
    
                        <!-- Link para la encuesta -->
                        <div class="col-xs-6">
                            {!! Form::label('link_encuesta', 'Link de la encuesta:') !!}
                            <a href="{!! $encuesta->link_encuesta !!}" target="_blank">{!! $encuesta->link_encuesta !!}</a>
                        </div>
    
                        <!-- Sexo del graduado -->
                        <div class="col-xs-6">
                            {!! Form::label('sexo', 'Sexo:') !!}
                            <p>{!! $encuesta->sexo == 'M' ? 'Hombre' : ($encuesta->sexo == 'F' ? 'Mujer' : 'ND') !!}</p>
                        </div>
    
                        <!-- Modal para ver la información de detalle de los contactos que pertenecen a la entrevista -->
                        <div class="col-xs-6">
                            {!! Form::label('info_de_contacto', 'Información de contacto') !!}

                            @if(sizeof($encuesta->contactos) <= 0)
                                <p class="text-danger text-uppercase">Esta entrevista no tiene información de contacto</p>
                            @else
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEnlacesInfoContacto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fas fa-address-card"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownEnlacesInfoContacto">
                                        <!-- Se agrega un boton por cada registro de contacto que tenga cada encuesta, mediante un foreach -->
                                        @foreach($encuesta->contactos as $contacto)
                                            <li>
                                                <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->nombre_referencia !!}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- Se agregan los modales mediante un foreach -->
                                    @foreach($encuesta->contactos as $contacto) 
                                        @include('modals.modal_info_de_contacto')
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Carrera -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_carrera', 'Carrera:') !!}
                            <p>{!! $encuesta->carrera->nombre !!}</p>
                        </div>
    
                        <!-- Universidad -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_universidad', 'Universidad:') !!}
                            <p>{!! $encuesta->universidad->nombre !!}</p>
                        </div>
    
                        <!-- Grado -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_grado', 'Grado:') !!}
                            <p>{!! $encuesta->grado->nombre !!}</p>
                        </div>
    
                        <!-- Disciplina -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_disciplina', 'Disciplina:') !!}
                            <p>{!! $encuesta->disciplina->descriptivo !!}</p>
                        </div>
    
                        <!-- Área -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_area', 'Área:') !!}
                            <p>{!! $encuesta->area->descriptivo !!}</p>
                        </div>
    
                        {{-- <!-- Agrupación -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_agrupacion', 'Agrupación:') !!}
                            <p>{!! $encuesta->agrupacion->nombre !!}</p>
                        </div> --}}
    
                        <!-- Sector -->
                        <div class="col-xs-6">
                            {!! Form::label('codigo_sector', 'Sector:') !!}
                            <p>{!! $encuesta->sector->nombre !!}</p>
                        </div>
    
                        <!-- Tipo de caso -->
                        <div class="col-xs-6">
                            {!! Form::label('tipo_de_caso', 'Tipo de caso:') !!}
                            <p>{!! $encuesta->tipo_de_caso !!}</p>
                        </div>
    
                        <!-- Indicador de otras carreras -->
                        @if (!is_null($encuesta->otrasCarreras()))
                            {!! Form::label('otras_carreras', 'Este usuario posee otras carreras: ') !!}
                            <p>Combo box here</p>
                        @endif
                        {{-- <!-- Created At Field -->
                        <div class="col-xs-6">
                            {!! Form::label('created_at', 'Creado el:') !!}
                            <p>{!! $encuesta->created_at !!}</p>
                        </div>
    
                        <!-- Updated At Field -->
                        <div class="col-xs-6">
                            {!! Form::label('updated_at', 'Modificado el:') !!}
                            <p>{!! $encuesta->updated_at !!}</p>
                        </div> --}}
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