<table class="table table-condensed table-hover">
    <thead>
        <!-- Encabezados de las columnas -->
        <tr>
            <th>Identificación</th>
            <th>Nombre</th>
            <th>Sexo</th>
            <th>Carrera</th>
            <th>Universidad</th>
            <th>Grado</th>
            <th>Disciplina</th>
            <th>Área</th>
            <th>Tipo de Caso</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="encuesta in lista_encuestas">
            <td>
                <!-- Botón que referencia al modal -->
                <a :href="'#modal-ver-detalles-de-entrevista-'+encuesta.id" data-toggle="modal">@{{encuesta.identificacion_graduado}}</a>

                <!-- Inicio del cuadro modal -->
                <div class="modal modal-default fade" :id="'modal-ver-detalles-de-entrevista-'+encuesta.id">
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
                                            {{-- <p>{!! $encuesta->estado()->estado !!}</p> --}}
                                            <p>PENDIENTE</p>
                                        </div>
                
                                        <!-- Identificación del graduado de la entrevista -->
                                        <div class="col-xs-6">
                                            {!! Form::label('identificacion_graduado', 'Identificación del graduado:') !!}
                                            <p>@{{ encuesta.identificacion_graduado }}</p>
                                        </div>
                
                                        <!-- Nombre completo del graduado -->
                                        <div class="col-xs-6">
                                            {!! Form::label('nombre_completo', 'Nombre completo:') !!}
                                            <p>@{{ encuesta.nombre_completo }}</p>
                                        </div>
                
                                        <!-- Token del graduado -->
                                        <div class="col-xs-6">
                                            {!! Form::label('token', 'Token:') !!}
                                            <p>@{{ encuesta.token }}</p>
                                        </div>
                    
                                        <!-- Año de graduación -->
                                        <div class="col-xs-6">
                                            {!! Form::label('annio_graduacion', 'Año de graduación:') !!}
                                            <p>@{{ encuesta.annio_graduacion }}</p>
                                        </div>
                    
                                        <!-- Link para la encuesta -->
                                        <div class="col-xs-6">
                                            {!! Form::label('link_encuesta', 'Link de la encuesta:') !!}
                                            <a :href="encuesta.link_encuesta" target="_blank">@{{ encuesta.link_encuesta }}</a>
                                        </div>
                    
                                        <!-- Sexo del graduado -->
                                        <div class="col-xs-6">
                                            {!! Form::label('sexo', 'Sexo:') !!}
                                            <p v-if="encuesta.sexo == 'M'">Hombre</p>
                                            <p v-else-if="encuesta.sexo == 'F'">Mujer</p>
                                            <p v-else>Sin clasificar</p>
                                        </div>
                    
                                        <!-- Modal para ver la información de detalle de los contactos que pertenecen a la entrevista -->
                                        {{-- <div class="col-xs-6">
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
                                        </div> --}}
                
                                        <!-- Carrera -->
                                        <div class="col-xs-6">
                                            {!! Form::label('codigo_carrera', 'Carrera:') !!}
                                            <p>@{{ encuesta.codigo_carrera }}</p>
                                        </div>
                    
                                        <!-- Universidad -->
                                        <div class="col-xs-6">
                                            {!! Form::label('codigo_universidad', 'Universidad:') !!}
                                            <p>@{{ encuesta.codigo_universidad }}</p>
                                        </div>
                    
                                        <!-- Grado -->
                                        <div class="col-xs-6">
                                            {!! Form::label('codigo_grado', 'Grado:') !!}
                                            <p>@{{ encuesta.codigo_grado }}</p>
                                        </div>
                    
                                        <!-- Disciplina -->
                                        <div class="col-xs-6">
                                            {!! Form::label('codigo_disciplina', 'Disciplina:') !!}
                                            @{{ encuesta.codigo_disciplina }}
                                        </div>
                    
                                        <!-- Área -->
                                        <div class="col-xs-6">
                                            {!! Form::label('codigo_area', 'Área:') !!}
                                            @{{ encuesta.codigo_area }}
                                        </div>
                    
                                        {{-- <!-- Agrupación -->
                                        <div class="col-xs-6">
                                            {!! Form::label('codigo_agrupacion', 'Agrupación:') !!}
                                            <p>{!! $encuesta->agrupacion->nombre !!}</p>
                                        </div> --}}
                    
                                        <!-- Sector -->
                                        <div class="col-xs-6">
                                            {!! Form::label('codigo_sector', 'Sector:') !!}
                                            @{{ encuesta.codigo_sector }}
                                        </div>
                    
                                        <!-- Tipo de caso -->
                                        <div class="col-xs-6">
                                            {!! Form::label('tipo_de_caso', 'Tipo de caso:') !!}
                                            @{{ encuesta.tipo_de_caso }}
                                        </div>
                    
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
                    </div>
                </div>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>