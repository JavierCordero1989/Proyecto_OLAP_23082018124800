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
                        <div class="col-md-6">
                            <p><u>Estado actual:</u> {!! $encuesta->estado()->estado !!}</p>
                        </div>

                        <!-- Identificación del graduado de la entrevista -->
                        <div class="col-md-6">
                            <p><u>Identificación del graduado:</u> {!! $encuesta->identificacion_graduado !!}</p>
                        </div>

                        <!-- Nombre completo del graduado -->
                        <div class="col-md-6">
                            <p><u>Nombre completo:</u> {!! $encuesta->nombre_completo !!}</p>
                        </div>

                        <!-- Token del graduado -->
                        <div class="col-md-6">
                            <p><u>Token:</u> {!! $encuesta->token !!}</p>
                        </div>
    
                        <!-- Año de graduación -->
                        <div class="col-md-6">
                            <p><u>Año de graduación:</u>{!! $encuesta->annio_graduacion !!}</p>
                        </div>
    
                        <!-- Link para la encuesta -->
                        <div class="col-md-6">
                            <p><u>Link de la encuesta:</u> <a href="{!! $encuesta->link_encuesta !!}" target="_blank">{!! $encuesta->link_encuesta !!}</a></p>
                        </div>
    
                        <!-- Sexo del graduado -->
                        <div class="col-md-6">
                            <p><u>Sexo:</u> {!! $encuesta->sexo == 'M' ? 'Hombre' : ($encuesta->sexo == 'F' ? 'Mujer' : 'Sin Clasificar') !!}</p>
                        </div>
    
                        <!-- Modal para ver la información de detalle de los contactos que pertenecen a la entrevista -->
                        <div class="col-md-6">
                            <p><u>Información de contacto:</u>
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
                                                    @if ($contacto->nombre_referencia != "")
                                                        <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->nombre_referencia !!}</a>
                                                    @else
                                                        <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->parentezco !!}</a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                        <!-- Se agregan los modales mediante un foreach -->
                                        @foreach($encuesta->contactos as $contacto) 
                                            @include('modals.modal_info_de_contacto')
                                        @endforeach
                                    </div>
                                @endif
                            </p>
                        </div>

                        <!-- Carrera -->
                        <div class="col-md-6">
                            <p><u>Carrera:</u> {!! $encuesta->carrera->nombre !!}</p>
                        </div>
    
                        <!-- Universidad -->
                        <div class="col-md-6">
                            <p><u>Universidad:</u> {!! $encuesta->universidad->nombre !!}</p>
                        </div>
    
                        <!-- Grado -->
                        <div class="col-md-6">
                            <p><u>Grado:</u> {!! $encuesta->grado->nombre !!}</p>
                        </div>
    
                        <!-- Disciplina -->
                        <div class="col-md-6">
                            <p><u>Disciplina</u> {!! $encuesta->disciplina->descriptivo !!}</p>
                        </div>
    
                        <!-- Área -->
                        <div class="col-md-6">
                            <p><u>Área</u> {!! $encuesta->area->descriptivo !!}</p>
                        </div>
    
                        {{-- <!-- Agrupación -->
                        <div class="col-md-6">
                            {!! Form::label('codigo_agrupacion', 'Agrupación:') !!}
                            <p>{!! $encuesta->agrupacion->nombre !!}</p>
                        </div> --}}
    
                        <!-- Sector -->
                        <div class="col-md-6">
                            <p><u>Sector:</u> {!! $encuesta->sector->nombre !!}</p>
                        </div>
    
                        <!-- Tipo de caso -->
                        <div class="col-md-6">
                            <p><u>Tipo de caso:</u> {!! $encuesta->tipo_de_caso !!}</p>
                        </div>
    
                        <!-- Indicador de otras carreras -->
                        @if (!is_null($encuesta->otrasCarreras()))
                            <div class="col-md-6">
                                @php
                                    $ids = '';
                                    $otras = $encuesta->otrasCarreras();

                                    for($i=0; $i<sizeof($otras); $i++) {
                                        if($i >= sizeof($otras)-1) {
                                            $ids .= $otras[$i];
                                        }
                                        else {
                                            $ids .= $otras[$i].'-';
                                        }
                                    }
                                @endphp

                                <p><u>Este usuario posee otras carreras:</u> <a href="{!! route('encuestas-graduados.otras-carreras', $ids) !!}">Ir a las entrevistas</a></p>

                                {{-- <p>{!! $encuesta->otrasCarreras() !!}</p> <!-- TODO --> --}}
                            </div>
                        @endif
                        {{-- <!-- Created At Field -->
                        <div class="col-md-6">
                            {!! Form::label('created_at', 'Creado el:') !!}
                            <p>{!! $encuesta->created_at !!}</p>
                        </div>
    
                        <!-- Updated At Field -->
                        <div class="col-md-6">
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