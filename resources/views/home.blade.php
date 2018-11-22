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
    <div id="app-vue" class="content">

        <!-- Cuadro para notificaciones -->
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="content">
            <div class="panel-group" id="porEstados">
                @if (Auth::user()->hasRole(['Super Admin', 'Supervisor 1', 'Supervisor 2']))
                    <!-- Panel para las estadisticas por estado -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#porEstados" href="#panel-por-estados">
                                    <i class="fas fa-angle-down"></i>
                                    Por estados
                                </a>
                            </h4>
                        </div>
                        <div id="panel-por-estados" class="panel-collapse collapse">
                            <div class="panel-body" style="background-color: #ecf0f5;">
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
                        </div>
                    </div>
                    <!-- PANEL PARA LOS DATOS DE LOS REPORTES POR AGRUPACIONES, AREAS Y GENERAL -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#porEstados" href="#panel-por-general">
                                    <i class="fas fa-angle-down"></i>
                                    Generales
                                </a>
                            </h4>
                        </div>
                        <div id="panel-por-general" class="panel-collapse collapse">
                            <div class="panel-body" style="background-color: #ecf0f5;">

                                <div class="panel-group" id="porGeneral">
                                    <!-- PANEL PARA EL REPORTE POR AGRUPACIÓN -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#porGeneral" href="#panel-general">
                                                    <i class="fas fa-angle-down"></i>
                                                    Resumen de entrevistas completas vs asignadas
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-general" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <information-box-general v-bind:list="information.general" :color="color"></information-box-general>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- PANEL PARA EL REPORTE POR AREAS -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#porGeneral" href="#panel-areas">
                                                    <i class="fas fa-angle-down"></i>
                                                    Resumen por áreas
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-areas" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <information-box v-bind:list="information.areas" :color="color"></information-box>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- PANEL PARA EL REPORTE POR AGRUPACIONES -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#porGeneral" href="#panel-agrupaciones">
                                                    <i class="fas fa-angle-down"></i>
                                                    Resumen por agrupaciones
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-agrupaciones" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <information-box v-bind:list="information.agrupaciones" :color="color"></information-box>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('js/components-vue/components.js') !!}"></script>
    <script>
        $('#flash-overlay-modal').modal();

        new Vue({
            el: '#app-vue',
            created: function(){
                this.getReporte()
            },
            data: {
                information: [],
                color: "bg-aqua"
            },
            methods: {
                getReporte: function() {
                    let url = '{{ route("home.reporte-general") }}'

                    axios.get(url).then(response=>{
                        this.information = response.data
                    })
                }
            }
        })
    </script>
@endsection