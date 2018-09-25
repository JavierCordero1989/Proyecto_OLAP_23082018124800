@extends('layouts.app')

@section('title', "Nueva cita")

@section('css')
    {{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' /> --}}
    <link rel="stylesheet" href="{!! asset('fullcalendar/css/fullcalendar.min.css') !!}">
    {{-- <link rel="stylesheet" href="{!! asset('fullcalendar/css/fullcalendar.print.min.css') !!}"> --}}
@endsection

@section('content')

    <div class="content">
        <!-- Mensaje flash dependiendo el tipo de accion -->
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div id='calendar' class="col-xs-12"></div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <!-- Scripts para el calendario -->
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script> --}}
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script> --}}
    <script src="{!! asset('fullcalendar/js/moment.min.js') !!}"></script>
    <script src="{!! asset('fullcalendar/js/fullcalendar.min.js') !!}"></script>
    {{-- <script src="{!! asset('fullcalendar/js/locale/es.js') !!}"></script> --}}
    <script src="{!! asset('fullcalendar/js/locale-all.js') !!}"></script>
    <script>
        $(document).ready(function() {
            
            $('#calendar').fullCalendar({
                locale: 'es',
                firstDay: 0, // (Domingo)
                
                events : [
                    @foreach($citas as $cita)
                    {
                        title : '{{ $cita->observacion }}',
                        start : '{{ $cita->fecha_hora }}',
                        end: '{{ $cita->fecha_hora }}',
                    },
                    @endforeach
                ]
            })
        });
    </script>
@endsection