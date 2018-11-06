@extends('layouts.app')

@section('title', 'Inicio') 

@section('css')
    <style>
        .carousel-control {
            width: 0%;
            color: #000;
        }

        .item {
            margin-left: 5%;
            margin-right: 5%;
        }

        .carousel-indicators {
            bottom: -5%;
        }

        .carousel-indicators .active {
            background-color: #000;
            text-shadow: 0 1px 2px rgba(0,0,0,.6);
            opacity: .5;
        }

    </style>
@endsection

@section('content')
    <div class="content">

        <!-- Cuadro para notificaciones -->
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="row">
            <!-- Componentes para mostrar la información por estados, de la información general -->
            @foreach($estados as $key => $value)
                @component('components.info-box')
                    @slot('color_class', 'bg-green')
                    @slot('icon', config('global.iconos_estados.'.$key))
                    @slot('info_text', $key)
                    @slot('data', $value)
                    @if($key == 'TOTAL DE ENTREVISTAS')
                        @slot('percent', '')
                    @else
                        @slot('percent', round(($value / $estados['TOTAL DE ENTREVISTAS']) * 100 , 0) . '%')
                    @endif
                @endcomponent
            @endforeach
        </div>
        
        {{-- <div id="carrusel_datos_home" class="carousel slide" data-ride="carousel">
            <!-- INDICADORES -->
            <ol class="carousel-indicators">
                <li data-target="#carrusel_datos_home" data-slide-to="0" class="active"></li>
                <li data-target="#carrusel_datos_home" data-slide-to="1"></li>
                <li data-target="#carrusel_datos_home" data-slide-to="2"></li>
            </ol>

            <!-- CONTENIDO DEL CARRUSEL -->
            <div class="carousel-inner">
                <div class="item active row">
                    <!-- Componentes para mostrar la información por estados, de la información general -->
                    @foreach($estados as $key => $value)
                            @component('components.info-box')
                                @slot('color_class', 'bg-green')
                                @slot('icon', config('global.iconos_estados.'.$key))
                                @slot('info_text', $key)
                                @slot('data', $value)
                                @if($key == 'TOTAL DE ENTREVISTAS')
                                    @slot('percent', '')
                                @else
                                    @slot('percent', round(($value / $estados['TOTAL DE ENTREVISTAS']) * 100 , 0) . '%')
                                @endif
                            @endcomponent
                    @endforeach
                </div>

                <div class="item row">
                    <!-- Componentes para mostrar la información por estados, de la información general -->
                    @foreach($estados as $key => $value)
                            @component('components.info-box')
                                @slot('color_class', 'bg-blue')
                                @slot('icon', config('global.iconos_estados.'.$key))
                                @slot('info_text', $key)
                                @slot('data', $value)
                                @if($key == 'TOTAL DE ENTREVISTAS')
                                    @slot('percent', '')
                                @else
                                    @slot('percent', round(($value / $estados['TOTAL DE ENTREVISTAS']) * 100 , 0) . '%')
                                @endif
                            @endcomponent
                    @endforeach
                </div>

                <div class="item row">
                    <!-- Componentes para mostrar la información por estados, de la información general -->
                    @foreach($estados as $key => $value)
                            @component('components.info-box')
                                @slot('color_class', 'bg-red')
                                @slot('icon', config('global.iconos_estados.'.$key))
                                @slot('info_text', $key)
                                @slot('data', $value)
                                @if($key == 'TOTAL DE ENTREVISTAS')
                                    @slot('percent', '')
                                @else
                                    @slot('percent', round(($value / $estados['TOTAL DE ENTREVISTAS']) * 100 , 0) . '%')
                                @endif
                            @endcomponent
                    @endforeach
                </div>
            </div>

            <!-- CONTROLES -->
            <a class="left carousel-control" href="#carrusel_datos_home" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Siguiente</span>
            </a>
            <a class="right carousel-control" href="#carrusel_datos_home" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Anterior</span>
            </a>
        </div>         --}}
    </div>
@endsection

@section('scripts')
    <script>
        $('#flash-overlay-modal').modal();
    </script>
@endsection