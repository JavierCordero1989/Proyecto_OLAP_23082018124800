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
                    @include('components.modal-cambiar-estado-cita')
                    @include('components.modal-agregar-nueva-cita')
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
            let citas = <?php echo $citas; ?>;
            let array_citas = [];

            for(let index in citas) {
                let color = "";
                //#3c8dbc => azul
                //#e81919 => rojo
                //#37ca36 => verde
                
                if(citas[index].estado == 'P') { color = "#3c8dbc"; }
                else { color = "#37ca36"; }

                array_citas.push({
                    id: citas[index].id,
                    title : citas[index].observacion,
                    start : citas[index].fecha_hora,
                    end: citas[index].fecha_hora,
                    backgroundColor: color,
                    borderColor: color,
                    // url: '{{ route("cambiar-estado-de-cita", "<script>citas[index].id</script>" ) }}'
                });
            }

            $('#calendar').fullCalendar({
                locale: 'es',
                firstDay: 0, // (Domingo)
                events : array_citas,
                hiddenDays: [0,6],
                selectable: true, // permite seleccionar el dia
                header: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function(event) {
                    let url = "{{ route('cambiar-estado-de-cita', ':date') }}";
                    url = url.replace(':date', event.id);
                    // url = url.replace(':user', '{{ Auth::user()->id }}');

                    console.log(event);
                    $('#modal-cambiar-estado-cita').modal('show');
                    $('#modal-cambiar-estado-cita').find('#form_cambiar_estado').attr('action', url);
                },
                select: function(start, end) {
                    // Aqui se debe abrir otro modal, que permita ingresar datos para una nueva cita
                    $('#modal-nueva-cita').modal('show');
                }
            })
        });
    </script>
@endsection