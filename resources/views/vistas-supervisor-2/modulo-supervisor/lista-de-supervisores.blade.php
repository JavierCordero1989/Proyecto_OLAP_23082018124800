@extends('layouts.app')

@section('title', 'Supervisores') 

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Supervisores</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box-header">
            <div class="box-body">
                <section class="content">
                    <div class="row">
                        @foreach($lista_supervisores as $supervisor)
                            <div class="col-md-6">
                                <div class="box box-primary" >

                                    <!-- Encabezado del cuadro -->
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <span>{!! $supervisor->user_code !!}</span> - {!! $supervisor->name !!}
                                        </h3>
                      
                                        <!-- Botones de la parte superior derecha -->
                                        <div class="box-tools pull-right">
                                            <div class='btn-group'>  

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
                                                <a href="{{ route('supervisor2.asignar-encuestas-a-supervisor', [Auth::user()->id, $supervisor->id ]) }}" class="btn btn-primary btn-sm col-sm-12">
                                                    <i class="fa fa-plus-square"></i> Asignar Encuestas
                                                </a>
                                            </div>
                
                                            <div class="col-xs-5">
                                                <a href="{{ route('supervisor2.encuestas-asignadas-por-supervisor', [$supervisor->id]) }}" class="btn btn-primary btn-sm col-sm-12">
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
                      
            </div>
        </div>
    </div>
@endsection

