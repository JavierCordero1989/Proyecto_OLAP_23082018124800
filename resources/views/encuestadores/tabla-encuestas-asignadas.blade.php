@extends('layouts.app')

@section('title', 'Encuestas sin asignar') 

@section('content')
<div id="app" class="box-header">
        <div class="box-body">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            <div v-show="lista_de_encuestas.length > 0" class="row">
                <div class="form-group">
                    <button v-on:click="collapsePanel" class="btn btn-info" data-toggle="collapse" data-target="#panel-collapse">
                        <span class="fas fa-angle-down" data-toggle="tooltip" title="Pulse para mostrar/ocultar los campos de búsqueda" data-placement="right"></span>
                    </button>
                    <!-- BOTONES DE BUSQUEDA, DESPLIEGUE Y LIMPIEZA -->
                </div>
                <div id="panel-collapse" class="collapse">
                    <div class="form-group col-xs-12">
                        <a href="#" class="btn btn-default pull-left" v-on:click="cleanInputs" data-toggle="tooltip" title="Pulse reestablecer los campos de búsqueda" data-placement="right">
                            <i class="fas fa-brush"></i>
                            Limpiar...
                        </a>
                    </div>
                    <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-3 col-md-offset-0">
                        {!! Form::select('agrupacion', config('options.group_types'), null, ['class'=>'form-control', 'v-model'=>'agrupacion']) !!}
                        {{-- <input type="text" class="form-control" v-model="agrupacion" placeholder="Agrupación..."> --}}
                    </div>
                    <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-3 col-md-offset-0">
                        <input type="text" class="form-control" v-model="area" placeholder="Área...">
                    </div>
                    <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-3 col-md-offset-0">
                        <input type="text" class="form-control" v-model="disciplina" placeholder="Disciplina...">
                    </div>
                    <div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-3 col-md-offset-0">
                        {!! Form::select('grado', config('options.grade_types'), null, ['class'=>'form-control', 'v-model'=>'grado']) !!}
                        {{-- <input type="text" class="form-control" v-model="grado" placeholder="Grado..."> --}}
                    </div>
                </div>
            </div>
            <div v-if="listaFiltro.length <= 0">
                <div class="content">
                    <div class="clearfix"></div>
                        <div class="card-panel">
                            <div class="card-content text-muted text-center">
                                <i class="fas fa-grin-beam-sweat fa-10x"></i>
                                <br>
                                <p class="fa-2x">
                                    No tienes entrevistas asignadas
                                </p>
                            </div>
                        </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div v-else>
                <div class="col-xs-12 text-center">
                    <h3>@{{ encuestador.name }}</h3>
                </div>

                <div v-for="encuesta in listaFiltro" class="col-xs-12 col-md-6">
                    <div class="box box-primary collapsed-box" >
                        <!-- Encabezado del cuadro -->
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                @{{ encuesta.nombre_completo }}
                            </h3>

                            <!-- Botones de la parte superior derecha -->
                            <div class="box-tools pull-right">
                                <div class='btn-group'>
                                    <!-- Boton para minimizar/maximiar cada cuadro -->
                                    <button type="button" class="btn btn-info btn-xs" data-widget="collapse" data-toggle="tooltip" title="Pulse para desplegar la caja" data-placement="left">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Imagen del cuadro -->
                        <div class="box-body">
                            <div class="col-md-12">
                                <p><strong>Cédula:</strong> @{{ encuesta.identificacion_graduado }}</p>
                                <p><strong>Carrera:</strong> @{{ encuesta.codigo_carrera }}</p>
                                <p><strong>Universidad:</strong> @{{ encuesta.codigo_universidad }}</p>
                                <p><strong>Año de graduación:</strong> @{{ encuesta.annio_graduacion }}</p>
                            </div>
                        </div>

                        <!-- Botones del cuadro, parte inferior -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a :href="removeInterviewerInterviews(encuesta.id)" class="btn btn-danger btn-sm col-sm-12">
                                        <i class="fa fa-plus-square"></i> Quitar entrevista
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                    <a :href="'#modal-ver-detalles-de-entrevista-'+encuesta.id" class="btn btn-default btn-sm col-sm-12" data-toggle="modal">
                                        <i class="fa fa-plus-square"></i> Ver detalles
                                    </a>
                                    {{-- @include('modals.modal_ver_detalles_de_entrevista') --}}
                                    <!-- INICIA EL MODAL PARA EL DETALLE DE LA ENCUESTA -->
                                    <div class="modal modal-default fade" :id="'modal-ver-detalles-de-entrevista-'+encuesta.id">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <!-- ENCABEZADO DEL MODAL -->
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Datos detallados de la entrevista</h4>
                                                </div>
                                                <!-- CUERPO DEL MODAL -->
                                                <div class="modal-body">
                                                    <div class="row" style="padding-left: 20px">
                                                        <div class="col-xs-12">
                                                            <div class="col-xs-6">
                                                                {!! Form::label('estado_encuesta', 'Estado actual:') !!}
                                                                <p>@{{ encuesta.estado }}</p>
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
                                                                <a :href="encuesta.link_encuesta" target="_blank">@{{encuesta.link_encuesta}}</a>
                                                            </div>
                                        
                                                            <!-- Sexo del graduado -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('sexo', 'Sexo:') !!}
                                                                <p v-if="encuesta.sexo == 'M'">Hombre</p>
                                                                <p v-else-if="encuesta.sexo == 'F'">Mujer</p>
                                                                <p v-else>Sin Clasificar</p>
                                                            </div>

                                                            <!-- MODAL PARA LA INFORMACIÓN DE CONTACTO -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('info_de_contacto', 'Información de contacto') !!}
                                    
                                                                <p v-if="encuesta.contactos.length <= 0" class="text-danger text-uppercase">
                                                                    Esta entrevista no tiene información de contacto
                                                                </p>
                                                                <div v-else class="dropdown">
                                                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEnlacesInfoContacto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                        <i class="fas fa-address-card"></i>
                                                                        <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownEnlacesInfoContacto">
                                                                        <li v-for="contacto in encuesta.contactos">
                                                                            <a :href="'#modal-'+contacto.id" data-toggle="modal">
                                                                                <i class="fas fa-eye"></i>
                                                                                @{{contacto.nombre_referencia}}
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <!-- INICIA EL MODAL PARA LA INFORMACIÓN DEL DETALLADO DEL CONTACTO -->
                                                                    <div v-for="contacto in encuesta.contactos" class="modal fade" :id="'modal-'+contacto.id">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <!-- encabezado del modal -->
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title">@{{ contacto.identificacion_referencia }}</h4>
                                                                                    <h4 class="modal-title">@{{ contacto.nombre_referencia }}</h4>
                                                                                    <h4 class="modal-title">@{{ contacto.parentezco }}</h4>
                                                                                </div>

                                                                                <!-- cuerpo del modal -->
                                                                                <div class="modal-body">
                                                                                    <div class="content">
                                                                                        <div class="clearfix"></div>
                                                                                        <div class="clearfix"></div>
                                                                                        <div class="box box-primary">
                                                                                            <div class="box-body">
                                                                                                <div class="table-responsive">
                                                                                                    <table class="table table-hover table-striped">
                                                                                                        <thead>
                                                                                                            <th>Contacto</th>
                                                                                                            <th>Observación</th>
                                                                                                            <th>Estado del contacto</th>
                                                                                                            {{-- <th>Opciones</th> --}}
                                                                                                        </thead>
                                                                                                        <tbody>
                                                                                                            <tr v-for="detalle in contacto.detalle">
                                                                                                                <td>@{{ detalle.contacto }}</td>
                                                                                                                <td v-if="detalle.observacion == ''">SIN OBSERVACIÓN</td>
                                                                                                                <td v-else>@{{ detalle.observacion }}</td>
                                                                                                                <td v-if="detalle.estado == 'F'">
                                                                                                                    <i class="fas fa-check-circle" style="color: green;"></i>
                                                                                                                </td>
                                                                                                                <td v-else-if="detalle.estado == 'E'">
                                                                                                                    <i class="fas fa-times-circle" style="color: red;"></i>
                                                                                                                </td>
                                                                                                                <td v-else>
                                                                                                                    INDEFINIDO
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- CIERRE DEL MODAL PARA LA INFORMACIÓN DEL DETALLADO DEL CONTACTO -->
                                                                </div>
                                                            </div>
                                                            <!-- CIERRE DEL MODAL PARA LA INFORMACIÓN DE CONTACTO -->

                                                            <!-- Carrera -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('codigo_carrera', 'Carrera:') !!}
                                                                <p>@{{encuesta.codigo_carrera}}</p>
                                                            </div>
                                        
                                                            <!-- Universidad -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('codigo_universidad', 'Universidad:') !!}
                                                                <p>@{{encuesta.codigo_universidad}}</p>
                                                            </div>
                                        
                                                            <!-- Grado -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('codigo_grado', 'Grado:') !!}
                                                                <p>@{{encuesta.codigo_grado}}</p>
                                                            </div>
                                        
                                                            <!-- Disciplina -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('codigo_disciplina', 'Disciplina:') !!}
                                                                <p>@{{encuesta.codigo_disciplina}}</p>
                                                            </div>
                                        
                                                            <!-- Área -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('codigo_area', 'Área:') !!}
                                                                <p>@{{encuesta.codigo_area}}</p>
                                                            </div>

                                                            <div class="col-xs-6">
                                                                {!! Form::label('codigo_sector', 'Sector:') !!}
                                                                <p>@{{ encuesta.codigo_sector }}</p>
                                                            </div>
                                        
                                                            <!-- Tipo de caso -->
                                                            <div class="col-xs-6">
                                                                {!! Form::label('tipo_de_caso', 'Tipo de caso:') !!}
                                                                <p>@{{ encuesta.tipo_de_caso }}</p>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Volver</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FINALIZA EL MODAL PARA EL DETALLE DE LA ENCUESTA -->
                                </div>

                                <div v-if="isUser" class="col-xs-12" style="margin-top: 15px;">
                                    <a :href="performInterview(encuesta.id)" class="btn btn-primary btn-sm col-xs-6 col-xs-offset-3">
                                        <i class="fa fa-plus-square"></i> Realizar encuesta
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- @include('layouts.datatables_js') --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                agrupacion: '',
                area: '',
                disciplina: '',
                grado: '',
                lista_de_encuestas: '',
                encuestador: '',
                connectedUser: '',
            },
            created: function() {
                this.getList()
                this.getPollster()
                this.connectedUser = '{{Auth::user()->id}}'
            },
            methods: {
                getList: function() {
                    this.lista_de_encuestas = <?php echo json_encode($listaDeEncuestas); ?>
                },
                getPollster: function() {
                    this.encuestador = <?php echo json_encode($encuestador); ?>
                },
                removeInterviewerInterviews: function(id) {
                    let route = '{{ route("asignar-encuestas.remover-encuestas-a-encuestador", [":id", ":encuestador"]) }}'
                    route = route.replace(":id", id)
                    route = route.replace(":encuestador", this.encuestador.id)
                    return route
                },
                isUser: function() {
                    return this.connectedUser == this.encuestador.id
                },
                performInterview: function(id) {
                    let route = '{{ route("asignar-encuestas.realizar-entrevista", ":id") }}'
                    route = route.replace(":id", id)
                    return route
                },
                cleanInputs: function() {
                    this.agrupacion = ''
                    this.area = ''
                    this.disciplina = ''
                    this.grado = ''
                },
                collapsePanel: function(event) {
                    //TODO
                    console.log(event.target);
                }
            },
            computed: {
                listaFiltro: function() {
                    let filtro = this.lista_de_encuestas
                    
                    if(this.agrupacion != '') {
                        filtro = filtro.filter(el => el.codigo_agrupacion.toLowerCase().includes(this.agrupacion.toLowerCase()))
                    }
                    if(this.area != '') {
                        filtro = filtro.filter(el => el.codigo_area.toLowerCase().includes(this.area.toLowerCase()))
                    }
                    if(this.disciplina != '') {
                        filtro = filtro.filter(el => el.codigo_disciplina.toLowerCase().includes(this.disciplina.toLowerCase()))
                    }
                    if(this.grado != '') {
                        filtro = filtro.filter(el => el.codigo_grado.toLowerCase().includes('diplomado') || el.codigo_grado.toLowerCase().includes('profesorado'))
                    }

                    return filtro
                }
            }
        })
    </script>
@endsection