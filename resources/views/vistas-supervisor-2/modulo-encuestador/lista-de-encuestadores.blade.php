@extends('layouts.app')

@section('title', 'Encuestadores') 

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Encuestadores</h1>
        <h1 class="pull-right">
           {{-- <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('supervisor2.crear-nuevo-encuestador') !!}">Agregar nuevo</a> --}}
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="#modal-agregar-nuevo-encuestador" data-toggle="modal" ><i class="fas fa-plus"></i> Nuevo encuestador</a>
           @include('vistas-supervisor-2.modulo-encuestador.modal_agregar_nuevo_encuestador')
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box-header">
            <div class="box-body">
                <section class="content">
                    <div class="row">
                        @foreach($lista_encuestadores as $encuestador)
                            <div class="col-md-6">
                                <div class="box box-primary {{--collapsed-box--}}" >
                                    <!-- Encabezado del cuadro -->
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <span>{!! $encuestador->user_code !!}</span> - {!! $encuestador->name !!}
                                        </h3>
                        
                                        <!-- Botones de la parte superior derecha -->
                                        <div class="box-tools pull-right">  
                                            <div class='btn-group'>
            
                                                <!-- Boton para ver los datos del encuestador -->
                                                <a class="btn btn-default btn-xs" href="#modal-agregar-nuevo-encuestador-{{$encuestador->id}}" data-toggle="modal" ><i class="glyphicon glyphicon-eye-open"></i></a>

                                                @include('vistas-supervisor-2.modulo-encuestador.modal_ver_encuestador')
                                                
                                                {{-- <a href="{!! route('supervisor2.ver-encuestador', [$encuestador->id]) !!}" class='btn btn-default btn-xs'>
                                                    <i class="glyphicon glyphicon-eye-open"></i>
                                                </a> --}}
                    
                                                <!-- Boton para editar los datos del encuestador -->
                                                <a href="{!! route('supervisor2.editar-encuestador', [$encuestador->id]) !!}" class='btn btn-default btn-xs'>
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </a>
            
                                                <!-- Boton para minimizar/maximiar cada cuadro -->
                                                <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                    
                                            </div>
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
                                                <a href="{{ route('supervisor2.asignar-encuestas-a-encuestador', [Auth::user()->id, $encuestador->id ]) }}" class="btn btn-primary btn-sm col-sm-12">
                                                    <i class="fa fa-plus-square"></i> Asignar Encuestas
                                                </a>
                                            </div>
                
                                            <div class="col-xs-5">
                                                <a href="{{ route('supervisor2.encuestas-asignadas-por-encuestador', [$encuestador->id]) }}" class="btn btn-primary btn-sm col-sm-12">
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
                                                <a href="{{ route('supervisor2.graficos-por-estado-de-encuestador', [$encuestador->id]) }}" class="btn btn-primary btn-sm col-sm-12">
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function validar_formulario() {
            var user_code = $('#user_code').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();

            if( user_code=="" || name=="" || email=="" || password=="" ) {
                alert("Debe completar todos los campos del formulario para continuar");
                return false;
            }

            return true;
        }
    </script>
@endsection