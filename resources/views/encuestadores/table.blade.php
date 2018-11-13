<section class="content">
    <div class="row">

        <div v-if="listaFiltro.length == 0" class="content">
            <!-- cuadro que aparece cuando no hay resultados de busqueda -->
            <div class="clearfix"></div>
                <div class="card-panel">
                    <div class="card-content text-muted text-center">
                        <i class="fas fa-grin-beam-sweat fa-10x"></i>
                        <br>
                        <p class="fa-2x">
                            No hay resultados para su búsqueda
                        </p>
                    </div>
                </div>
            <div class="clearfix"></div>
        </div>
            
        <div class="col-xs-12 col-sm-12 col-md-6" v-for="encuestador in listaFiltro">
            
            <div class="box box-primary collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span>@{{encuestador.user_code}}</span> - @{{encuestador.name}}
                    </h3>
                    <!-- Botones de la parte superior derecha -->
                    <div class="box-tools pull-right">
                        @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
                            <form :action="getDeleteRoute(encuestador.id)" method="delete">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                        @endif  
                            
                        <div class="btn-group">
                            <a :href="'#modal-'+encuestador.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>

                            <!-- modal de la info de usuario -->
                            <div class="modal fade" :id="'modal-'+encuestador.id">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" v-text="encuestador.name"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row" style="padding-left: 20px">
                                                <div class="col-xs-12">
                                                    <!-- User code Field -->
                                                    <div class="form-group">
                                                        {!! Form::label('user_code', 'Código:') !!}
                                                        <p v-text="encuestador.user_code"></p>
                                                    </div>
                                                    
                                                    <!-- Extension Field -->
                                                    <div class="form-group">
                                                        {!! Form::label('extension', 'Extensión:') !!}
                                                        <p v-text="encuestador.extension"></p>
                                                    </div>

                                                    <!-- Mobile Number -->
                                                    <div class="form-group">
                                                        {!! Form::label('mobile', 'Celular:') !!}
                                                        <p v-text="encuestador.mobile"></p>
                                                    </div>

                                                    <!-- Nombre Field -->
                                                    <div class="form-group">
                                                        {!! Form::label('email', 'Email:') !!}
                                                        <p v-text="encuestador.email"></p>
                                                    </div>

                                                    <div class="form-group">
                                                        {!! Form::label('created_at', 'Creado el: ') !!}
                                                        <p v-text="encuestador.created_at"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                        <p v-text="encuestador.updated_at"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- termina el modal -->

                            <a :href="getEditRoute(encuestador.id)" class='btn btn-default btn-xs'>
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>
        
                            @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
                                <!-- Boton para eliminar los datos del encuestador -->
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','onclick' => "return confirm('¿Está seguro de querer eliminar?')"]) !!}
                            @endif

                            <!-- Boton para minimizar/maximiar cada cuadro -->
                            <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>

                        </div>

                        @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Cuerpo de cada caja -->
                <div class="box-body">
                    <div class="col-md-12">
                        <img class="card-img-top" data-src="{{ config('global.imagen_tarjetas') }}" alt="logo de OLAP" style="height: 100%; width: 100%; display: block;" src="{{ asset(config('global.imagen_tarjetas')) }}" data-holder-rendered="true">
                    </div>
                </div>

                <!-- botones para acceder a las encuestas -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-1">
                            <a :href="assignInterviews(encuestador.id)" class="btn btn-primary btn-sm col-sm-12">
                                <i class="fa fa-plus-square"></i> Asignar Encuestas
                            </a>
                        </div>

                        <div class="col-xs-5">
                            <a :href="getAssignedInterviewsRoute(encuestador.id)" class="btn btn-primary btn-sm col-sm-12">
                                <i class="far fa-eye"></i> Encuestas asignadas
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Fin del .box-body -->

            </div>
        </div>
    </div>
</section>
      