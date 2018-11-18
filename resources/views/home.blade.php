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

        {{-- <information-box v-bind:list="information"></information-box> --}}

    </div>
@endsection

@section('scripts')
    <script src="{!! asset('js/components-vue/components.js') !!}"></script>
    <script>
        $('#flash-overlay-modal').modal();

        // new Vue({
        //     el: '#app-vue',
        //     data: {
        //         information: [
        //             {color:'bg-aqua',title:'titulo 1',text:'texto 1',icon:'ion ion-stats-bars', link: '#'},
        //             {color:'bg-aqua',title:'titulo 2',text:'texto 2',icon:'ion ion-person', link: '#'},
        //             {color:'bg-aqua',title:'titulo 3',text:'texto 3',icon:'ion ion-stats-bars', link: '#'},
        //             {color:'bg-aqua',title:'titulo 4',text:'texto 4',icon:'ion ion-stats-bars', link: '#'},
        //             {color:'bg-aqua',title:'titulo 5',text:'texto 5',icon:'ion ion-stats-bars', link: '#'},
        //             {color:'bg-aqua',title:'titulo 6',text:'texto 6',icon:'ion ion-stats-bars', link: '#'},
        //             {color:'bg-aqua',title:'titulo 7',text:'texto 7',icon:'ion ion-stats-bars', link: '#'},
        //         ]
        //     }
        // })
    </script>
@endsection