@extends('layouts.app')

@section('title', "Nueva cita")

@section('css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
        $(document).ready(function() {
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                lang: 'es',
                // put your options and callbacks here
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