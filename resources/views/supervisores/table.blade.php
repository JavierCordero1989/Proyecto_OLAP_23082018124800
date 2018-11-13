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
    
            <div class="col-xs-12 col-sm-12 col-md-6" v-for="sup in listaFiltro">
                <div class="box box-primary collapsed-box" >
                    <!-- encabezado del cuadro -->
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span>@{{sup.user_code}}</span> - @{{sup.name}}
                        </h3>

                        <div class="box-tools pull-right">
                            @if(Auth::user()->hasRole('Super Admin'))

                                <div v-if="sup.roles[0].name != 'Super Admin'">
                                    <form :action="getDeleteRoute(sup.id)" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <div class="btn-group">
                                            <a :href="'#modal-'+sup.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                        
                                            <!-- modal de la info de usuario -->
                                            <div class="modal fade" :id="'modal-'+sup.id">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title" v-text="sup.name"></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" style="padding-left: 20px">
                                                                <div class="col-xs-12">
                                                                    <!-- User code Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('user_code', 'Código:') !!}
                                                                        <p v-text="sup.user_code"></p>
                                                                    </div>
                                                                    
                                                                    <!-- Extension Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('extension', 'Extensión:') !!}
                                                                        <p v-text="sup.extension"></p>
                                                                    </div>
                
                                                                    <!-- Mobile Number -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('mobile', 'Celular:') !!}
                                                                        <p v-text="sup.mobile"></p>
                                                                    </div>
                
                                                                    <!-- Nombre Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('email', 'Email:') !!}
                                                                        <p v-text="sup.email"></p>
                                                                    </div>
                
                                                                    <div class="form-group">
                                                                        {!! Form::label('created_at', 'Creado el: ') !!}
                                                                        <p v-text="sup.created_at"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                                        <p v-text="sup.updated_at"></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- termina el modal -->

                                            <a :href="getEditRoute(sup.id)" class="btn btn-default btn-xs">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            
                                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro de querer eliminar?')">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>

                                            <!-- Boton para minimizar/maximiar cada cuadro -->
                                            <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div v-else>
                                    <div class="btn-group">
                                        <a :href="'#modal-'+sup.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                    
                                        <!-- modal de la info de usuario -->
                                        <div class="modal fade" :id="'modal-'+sup.id">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" v-text="sup.name"></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row" style="padding-left: 20px">
                                                            <div class="col-xs-12">
                                                                <!-- User code Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('user_code', 'Código:') !!}
                                                                    <p v-text="sup.user_code"></p>
                                                                </div>
                                                                
                                                                <!-- Extension Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('extension', 'Extensión:') !!}
                                                                    <p v-text="sup.extension"></p>
                                                                </div>
            
                                                                <!-- Mobile Number -->
                                                                <div class="form-group">
                                                                    {!! Form::label('mobile', 'Celular:') !!}
                                                                    <p v-text="sup.mobile"></p>
                                                                </div>
            
                                                                <!-- Nombre Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('email', 'Email:') !!}
                                                                    <p v-text="sup.email"></p>
                                                                </div>
            
                                                                <div class="form-group">
                                                                    {!! Form::label('created_at', 'Creado el: ') !!}
                                                                    <p v-text="sup.created_at"></p>
                                                                </div>
                                                                <div class="form-group">
                                                                    {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                                    <p v-text="sup.updated_at"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- termina el modal -->
    
                                        <!-- Boton para minimizar/maximiar cada cuadro -->
                                        <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                

                                {{-- <div v-if="sup.roles[0].name != 'Super Admin' || sup.roles[0].name != 'Supervisor 1'">
                                    <form :action="getDeleteRoute(sup.id)" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
    
                                        <div class="btn-group">
                                            <a :href="'#modal-'+sup.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                        
                                            <!-- modal de la info de usuario -->
                                            <div class="modal fade" :id="'modal-'+sup.id">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title" v-text="sup.name"></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" style="padding-left: 20px">
                                                                <div class="col-xs-12">
                                                                    <!-- User code Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('user_code', 'Código:') !!}
                                                                        <p v-text="sup.user_code"></p>
                                                                    </div>
                                                                    
                                                                    <!-- Extension Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('extension', 'Extensión:') !!}
                                                                        <p v-text="sup.extension"></p>
                                                                    </div>
                
                                                                    <!-- Mobile Number -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('mobile', 'Celular:') !!}
                                                                        <p v-text="sup.mobile"></p>
                                                                    </div>
                
                                                                    <!-- Nombre Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('email', 'Email:') !!}
                                                                        <p v-text="sup.email"></p>
                                                                    </div>
                
                                                                    <div class="form-group">
                                                                        {!! Form::label('created_at', 'Creado el: ') !!}
                                                                        <p v-text="sup.created_at"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                                        <p v-text="sup.updated_at"></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- termina el modal -->
    
                                            @if (Auth::user()->hasRole('Super Admin'))
                                                <a :href="getEditRoute(sup.id)" class="btn btn-default btn-xs" v-if="sup.roles[0].name != 'Super Admin'">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </a>
                                                
                                                <button v-if="sup.roles[0].name != 'Super Admin'" type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro de querer eliminar?')">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            @endif
    
                                            @if (Auth::user()->hasRole('Supervisor 1'))
                                                <a :href="getEditRoute(sup.id)" class="btn btn-default btn-xs" v-if="sup.roles[0].name != 'Super Admin' && sup.roles[0].name != 'Supervisor 1'">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </a>
                                                
                                                <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro de querer eliminar?')" v-if="sup.roles[0].name != 'Super Admin' && sup.roles[0].name != 'Supervisor 1'">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
                                            @endif
    
                                            <!-- Boton para minimizar/maximiar cada cuadro -->
                                            <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div v-else>
                                    <div class="btn-group">
                                        <a :href="'#modal-'+sup.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                    
                                        <!-- modal de la info de usuario -->
                                        <div class="modal fade" :id="'modal-'+sup.id">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" v-text="sup.name"></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row" style="padding-left: 20px">
                                                            <div class="col-xs-12">
                                                                <!-- User code Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('user_code', 'Código:') !!}
                                                                    <p v-text="sup.user_code"></p>
                                                                </div>
                                                                
                                                                <!-- Extension Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('extension', 'Extensión:') !!}
                                                                    <p v-text="sup.extension"></p>
                                                                </div>
            
                                                                <!-- Mobile Number -->
                                                                <div class="form-group">
                                                                    {!! Form::label('mobile', 'Celular:') !!}
                                                                    <p v-text="sup.mobile"></p>
                                                                </div>
            
                                                                <!-- Nombre Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('email', 'Email:') !!}
                                                                    <p v-text="sup.email"></p>
                                                                </div>
            
                                                                <div class="form-group">
                                                                    {!! Form::label('created_at', 'Creado el: ') !!}
                                                                    <p v-text="sup.created_at"></p>
                                                                </div>
                                                                <div class="form-group">
                                                                    {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                                    <p v-text="sup.updated_at"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- termina el modal -->
    
                                        @if (Auth::user()->hasRole('Super Admin'))
                                            <a v-if="sup.roles[0].name != 'Super Admin'" :href="getEditRoute(sup.id)" class="btn btn-default btn-xs">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            
                                            <button v-if="sup.roles[0].name != 'Super Admin'" type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro de querer eliminar?')">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>
                                        @endif
    
                                        @if (Auth::user()->hasRole('Supervisor 1'))
                                            <a v-if="sup.roles[0].name != 'Super Admin' && sup.roles[0].name != 'Supervisor 1'" :href="getEditRoute(sup.id)" class="btn btn-default btn-xs">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            
                                            <button v-if="sup.roles[0].name != 'Super Admin' && sup.roles[0].name != 'Supervisor 1'" type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro de querer eliminar?')">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>
                                        @endif
    
                                        <!-- Boton para minimizar/maximiar cada cuadro -->
                                        <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div> --}}
                            @endif

                            @if (Auth::user()->hasRole('Supervisor 1'))
                                <div v-if="sup.roles[0].name != 'Super Admin' && sup.roles[0].name != 'Supervisor 1'">
                                    <form :action="getDeleteRoute(sup.id)" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <div class="btn-group">
                                            <a :href="'#modal-'+sup.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                        
                                            <!-- modal de la info de usuario -->
                                            <div class="modal fade" :id="'modal-'+sup.id">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h4 class="modal-title" v-text="sup.name"></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row" style="padding-left: 20px">
                                                                <div class="col-xs-12">
                                                                    <!-- User code Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('user_code', 'Código:') !!}
                                                                        <p v-text="sup.user_code"></p>
                                                                    </div>
                                                                    
                                                                    <!-- Extension Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('extension', 'Extensión:') !!}
                                                                        <p v-text="sup.extension"></p>
                                                                    </div>
                
                                                                    <!-- Mobile Number -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('mobile', 'Celular:') !!}
                                                                        <p v-text="sup.mobile"></p>
                                                                    </div>
                
                                                                    <!-- Nombre Field -->
                                                                    <div class="form-group">
                                                                        {!! Form::label('email', 'Email:') !!}
                                                                        <p v-text="sup.email"></p>
                                                                    </div>
                
                                                                    <div class="form-group">
                                                                        {!! Form::label('created_at', 'Creado el: ') !!}
                                                                        <p v-text="sup.created_at"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                                        <p v-text="sup.updated_at"></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- termina el modal -->

                                            <a :href="getEditRoute(sup.id)" class="btn btn-default btn-xs">
                                                <i class="glyphicon glyphicon-edit"></i>
                                            </a>
                                            
                                            <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Está seguro de querer eliminar?')">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </button>

                                            <!-- Boton para minimizar/maximiar cada cuadro -->
                                            <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div v-else>
                                    <div class="btn-group">
                                        <a :href="'#modal-'+sup.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                    
                                        <!-- modal de la info de usuario -->
                                        <div class="modal fade" :id="'modal-'+sup.id">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" v-text="sup.name"></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row" style="padding-left: 20px">
                                                            <div class="col-xs-12">
                                                                <!-- User code Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('user_code', 'Código:') !!}
                                                                    <p v-text="sup.user_code"></p>
                                                                </div>
                                                                
                                                                <!-- Extension Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('extension', 'Extensión:') !!}
                                                                    <p v-text="sup.extension"></p>
                                                                </div>
            
                                                                <!-- Mobile Number -->
                                                                <div class="form-group">
                                                                    {!! Form::label('mobile', 'Celular:') !!}
                                                                    <p v-text="sup.mobile"></p>
                                                                </div>
            
                                                                <!-- Nombre Field -->
                                                                <div class="form-group">
                                                                    {!! Form::label('email', 'Email:') !!}
                                                                    <p v-text="sup.email"></p>
                                                                </div>
            
                                                                <div class="form-group">
                                                                    {!! Form::label('created_at', 'Creado el: ') !!}
                                                                    <p v-text="sup.created_at"></p>
                                                                </div>
                                                                <div class="form-group">
                                                                    {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                                    <p v-text="sup.updated_at"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- termina el modal -->
    
                                        <!-- Boton para minimizar/maximiar cada cuadro -->
                                        <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if (Auth::user()->hasRole('Supervisor 2'))
                                <div class="btn-group">
                                    <a :href="'#modal-'+sup.id" data-toggle="modal" class='btn btn-default btn-xs'>
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                
                                    <!-- modal de la info de usuario -->
                                    <div class="modal fade" :id="'modal-'+sup.id">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title" v-text="sup.name"></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row" style="padding-left: 20px">
                                                        <div class="col-xs-12">
                                                            <!-- User code Field -->
                                                            <div class="form-group">
                                                                {!! Form::label('user_code', 'Código:') !!}
                                                                <p v-text="sup.user_code"></p>
                                                            </div>
                                                            
                                                            <!-- Extension Field -->
                                                            <div class="form-group">
                                                                {!! Form::label('extension', 'Extensión:') !!}
                                                                <p v-text="sup.extension"></p>
                                                            </div>
        
                                                            <!-- Mobile Number -->
                                                            <div class="form-group">
                                                                {!! Form::label('mobile', 'Celular:') !!}
                                                                <p v-text="sup.mobile"></p>
                                                            </div>
        
                                                            <!-- Nombre Field -->
                                                            <div class="form-group">
                                                                {!! Form::label('email', 'Email:') !!}
                                                                <p v-text="sup.email"></p>
                                                            </div>
        
                                                            <div class="form-group">
                                                                {!! Form::label('created_at', 'Creado el: ') !!}
                                                                <p v-text="sup.created_at"></p>
                                                            </div>
                                                            <div class="form-group">
                                                                {!! Form::label('updated_at', 'Modificado el: ') !!}
                                                                <p v-text="sup.updated_at"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- termina el modal -->

                                    <!-- Boton para minimizar/maximiar cada cuadro -->
                                    <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
    
                    <!-- imagen del cuadro -->
                    <div class="box-body">
                        <div class="col-md-12">
                            <img class="card-img-top" data-src="{{ config('global.imagen_tarjetas') }}" alt="logo de OLAP" style="height: 100%; width: 100%; display: block;" src="{{ asset(config('global.imagen_tarjetas')) }}" data-holder-rendered="true">
                        </div>
                    </div>
    
                    <!-- botones de la parte inferior -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <a :href="assignInterviews(sup.id)" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="fa fa-plus-square"></i> Asignar Encuestas
                                </a>
                            </div>
    
                            <div class="col-xs-5">
                                <a :href="getAssignedInterviewsRoute(sup.id)" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="far fa-eye"></i> Encuestas asignadas
                                </a>
                            </div>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
          