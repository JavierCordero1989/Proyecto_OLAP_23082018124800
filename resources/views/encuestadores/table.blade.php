<section class="content">
    <div class="row">
        @foreach($lista_encuestadores as $encuestador)
            <div class="col-md-6">
                <div class="box box-primary {{--collapsed-box--}}" >
                    <!-- Encabezado del cuadro -->
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Código de encuestador: {!! $encuestador->user_code !!}
                        </h3>
      
                        <!-- Botones de la parte superior derecha -->
                        <div class="box-tools pull-right">
                            {!! Form::open(['route' => ['encuestadores.destroy', $encuestador->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>

                                    <!-- Boton para ver los datos del encuestador -->
                                    <a href="{!! route('encuestadores.show', [$encuestador->id]) !!}" class='btn btn-default btn-xs'>
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
      
                                    <!-- Boton para editar los datos del encuestador -->
                                    {{-- @if (Auth::user()->hasRole('Administrador')) --}}
                                        <a href="{!! route('encuestadores.edit', [$encuestador->id]) !!}" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                    
                                        <!-- Boton para eliminar los datos del encuestador -->
                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','onclick' => "return confirm('¿Está seguro de querer eliminar?')", 'data-toggle' => 'modal', 'data-target' => '#modal-danger']) !!}

                                    {{-- @endif --}}

                                    <!-- Boton para minimizar/maximiar cada cuadro -->
                                    <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
      
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                    <!-- Imagen del cuadro -->
                    <div class="box-body">
                        <div class="col-md-12">
                            <img class="card-img-top" data-src="img/logo_olap.png" alt="logo de OLAP" style="height: 100%; width: 100%; display: block;" src="{{ asset('img/logo_olap.png') }}" data-holder-rendered="true">
                        </div>
                    </div>

                    <!-- Botones del cuadro, parte inferior -->
                    <div class="box-body">
                        <div class="btn-group col-md-12">

                            {{-- {{ route('asignar-encuestas.asignar', [$encuestador->id, Auth::user()->id]) }} --}}
                            <a href="{{ route('asignar-encuestas.asignar', [Auth::user()->id, $encuestador->id ]) }}" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                <i class="fa fa-plus-square"></i> Asignar Encuestas
                            </a>

                            <a href="#" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                <i class="fa fa-spoon"></i> Botón 1
                            </a>

                            <a href="#" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                <i class="fa fa-eyedropper"></i> Botón 2
                            </a>

                            {{-- @if (Auth::user()->hasRole('Administrador')) --}}
                                <a href="#" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                    <i class="fa fa-area-chart"></i> Botón 3
                                </a>
                            {{-- @endif --}}
      
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
      