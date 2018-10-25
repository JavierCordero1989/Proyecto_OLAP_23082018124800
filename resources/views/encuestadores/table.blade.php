<section class="content">
    <div class="row">
        @foreach($lista_encuestadores as $encuestador)
            <div class="col-md-6">
                <div class="box box-primary collapsed-box" >
                    <!-- Encabezado del cuadro -->
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <span>{!! $encuestador->user_code !!}</span> - {!! $encuestador->name !!}
                        </h3>
      
                        <!-- Botones de la parte superior derecha -->
                        <div class="box-tools pull-right">
                            @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
                                {!! Form::open(['route' => ['encuestadores.destroy', $encuestador->id], 'method' => 'delete']) !!}
                            @endif    
                                <div class='btn-group'>

                                    <!-- Boton para ver los datos del encuestador -->
                                    {{-- <a href="{!! route('encuestadores.show', [$encuestador->id]) !!}" class='btn btn-default btn-xs'>
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a> --}}
                                    
                                    {{-- <a href="#modal-{!! $encuestador->id !!}" data-toggle="modal" class='btn btn-default btn-xs'>
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a> --}}

                                    @component('components.info-encuestador')
                                        @slot('id_modal', 'modal-'.$encuestador->id)
                                        @slot('nombre_encuestador', $encuestador->name)
                                        @slot('codigo_usuario', $encuestador->user_code)
                                        @slot('email', $encuestador->email)
                                        @slot('created_at', $encuestador->created_at)
                                        @slot('updated_at', $encuestador->updated_at)
                                    @endcomponent

                                    {{-- @include('encuestadores.modal-info-encuestador') --}}

                                    <!-- Boton para editar los datos del encuestador -->
                                    {{-- @if (Auth::user()->hasRole('Administrador')) --}}
                                        <a href="{!! route('encuestadores.edit', [$encuestador->id]) !!}" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                    
                                        @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
                                            <!-- Boton para eliminar los datos del encuestador -->
                                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','onclick' => "return confirm('¿Está seguro de querer eliminar?')", 'data-toggle' => 'modal', 'data-target' => '#modal-danger']) !!}
                                        @endif
                                    {{-- @endif --}}

                                    <!-- Boton para minimizar/maximiar cada cuadro -->
                                    <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
      
                                </div>
                            @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
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
                                <a href="{{ route('asignar-encuestas.asignar', [Auth::user()->id, $encuestador->id ]) }}" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="fa fa-plus-square"></i> Asignar Encuestas
                                </a>
                            </div>

                            <div class="col-xs-5">
                                <a href="{{ route('asignar-encuestas.lista-encuestas-asignadas', [$encuestador->id]) }}" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="far fa-eye"></i> Encuestas asignadas
                                </a>
                            </div>

                        </div>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-xs-5 col-xs-offset-1">
                                <a href="#" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="fa fa-eyedropper"></i> Botón 2
                                </a>
                            </div>

                            <div class="col-xs-5">
                                <a href="{{ route('graficos.graficos-por-encuestador', [$encuestador->id]) }}" class="btn btn-primary btn-sm col-sm-12">
                                    <i class="fa fa-area-chart"></i> Ver estadísticas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
      