<section class="content">
    <div class="row">
        @foreach($lista_supervisores as $supervisor)
            <div class="col-md-6">
                <div class="box box-primary collapsed-box" >
                    <!-- Encabezado del cuadro -->
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span>{!! $supervisor->user_code !!}</span> - {!! $supervisor->name !!}
                        </h3>
      
                        <!-- Botones de la parte superior derecha -->
                        {{-- <div class="box-tools pull-right">
                            <div class='btn-group'>
                                @if(Auth::user()->hasRole('Super Admin', 'Supervisor 1'))
                                    {!! Form::open(['route' => ['supervisores.destroy', $supervisor->id], 'method' => 'delete']) !!}

                                        <!-- Boton para ver los datos del supervisor -->
                                        <a href="{!! route('supervisores.show', [$supervisor->id]) !!}" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
        
                                        <!-- Boton para editar los datos del supervisor -->
                                        <a href="{!! route('supervisores.edit', [$supervisor->id]) !!}" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                    
                                        <!-- Boton para eliminar los datos del supervisor -->
                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','onclick' => "return confirm('¿Está seguro de querer eliminar?')", 'data-toggle' => 'modal', 'data-target' => '#modal-danger']) !!}

                                    {!! Form::close() !!}
                                @endif

                                <!-- Boton para minimizar/maximiar cada cuadro -->
                                <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>

                            </div>
                        </div> --}}

                        <div class="box-tools pull-right">
                            @if(Auth::user()->hasRole('Super Admin', 'Supervisor 1'))
                                {!! Form::open(['route' => ['supervisores.destroy', $supervisor->id], 'method' => 'delete']) !!}
                            @endif    
                                <div class='btn-group'>

                                    <!-- Boton para ver los datos del encuestador -->
                                    <a href="{!! route('encuestadores.show', [$supervisor->id]) !!}" class='btn btn-default btn-xs'>
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
        
                                    <!-- Boton para editar los datos del encuestador -->
                                    {{-- @if (Auth::user()->hasRole('Administrador')) --}}
                                        <a href="{!! route('encuestadores.edit', [$supervisor->id]) !!}" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                    
                                        @if(Auth::user()->hasRole('Super Admin', 'Supervisor 1'))
                                            <!-- Boton para eliminar los datos del encuestador -->
                                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','onclick' => "return confirm('¿Está seguro de querer eliminar?')", 'data-toggle' => 'modal', 'data-target' => '#modal-danger']) !!}
                                        @endif
                                    {{-- @endif --}}

                                    <!-- Boton para minimizar/maximiar cada cuadro -->
                                    <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                        <i class="fa fa-plus"></i>
                                    </button>
        
                                </div>
                            @if(Auth::user()->hasRole('Super Admin', 'Supervisor 1'))
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>

                    <!-- Imagen del cuadro -->
                    <div class="box-body">
                        <div class="col-md-12">
                            <img class="card-img-top" data-src="{{ config('global.imagen_tarjetas') }}" alt="logo de OLAP" style="height: 100%; width: 100%; display: block;" src="{{ asset(config('global.imagen_tarjetas')) }}" data-holder-rendered="true">
                        </div>
                    </div>

                    <!-- Botones del cuadro, parte inferior -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-5 col-xs-offset-1">
                                <a href="{{ route('asignar-encuestas.asignar', [Auth::user()->id, $supervisor->id ]) }}" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="fa fa-plus-square"></i> Asignar Encuestas
                                </a>
                            </div>

                            <div class="col-xs-5">
                                <a href="{{ route('asignar-encuestas.lista-encuestas-asignadas', [$supervisor->id]) }}" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="far fa-eye"></i> Encuestas asignadas
                                </a>
                            </div>

                        </div>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-xs-5 col-xs-offset-1">
                                <a href="#" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="fa fa-eyedropper"></i> Botón 3
                                </a>
                            </div>

                            <div class="col-xs-5">
                                <a href="#" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="fa fa-area-chart"></i> Botón 4
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
      