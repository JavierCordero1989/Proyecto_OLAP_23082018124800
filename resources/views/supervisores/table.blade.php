<section class="content">
    <div class="row">
        @foreach($lista_supervisores as $supervisor)
            <div class="col-md-6">
                <div class="box box-primary collapsed-box" >
                    <!-- Encabezado del cuadro -->
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Código de supervisor: {!! $supervisor->id !!}
                        </h3>
      
                        <!-- Botones de la parte superior derecha -->
                        <div class="box-tools pull-right">
                            {!! Form::open(['route' => ['supervisores.destroy', $supervisor->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>

                                    <!-- Boton para ver los datos del supervisor -->
                                    <a href="{!! route('supervisores.show', [$supervisor->id]) !!}" class='btn btn-default btn-xs'>
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
      
                                    <!-- Boton para editar los datos del supervisor -->
                                    {{-- @if (Auth::user()->hasRole('Administrador')) --}}
                                        <a href="{!! route('supervisores.edit', [$supervisor->id]) !!}" class='btn btn-default btn-xs'>
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>
                    
                                        <!-- Boton para eliminar los datos del supervisor -->
                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','onclick' => "return confirm('¿Está seguro de querer eliminar?')", 'data-toggle' => 'modal', 'data-target' => '#modal-danger']) !!}

                                    {{-- @endif --}}

                                    <!-- Boton para minimizar/maximiar cada cuadro -->
                                    <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                        <i class="fa fa-plus"></i>
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

                            <a href="estanqueEspecies/estanque/{{$supervisor->id}}" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                <i class="fa fa-plus-square"></i> Especies en el estanque
                            </a>

                            <a href="estanqueEspecies/alimentacion/{{$supervisor->id}}" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                <i class="fa fa-spoon"></i> Alimentación del estanque
                            </a>

                            <a href="/estanques/fisico_quimicos/{{$supervisor->id}}" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                <i class="fa fa-eyedropper"></i> Físico-Químico
                            </a>

                            {{-- @if (Auth::user()->hasRole('Administrador')) --}}
                                <a href="estanques/grafico/{{$supervisor->id}}" class="btn btn-info btn-social btn-primary btn-xs col-md-6">
                                    <i class="fa fa-area-chart"></i> Gráficos
                                </a>
                            {{-- @endif --}}
      
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
      