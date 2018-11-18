@extends('layouts.app')

@section('title', "Nueva cita")

@section('css')
    {{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' /> --}}
    <link rel="stylesheet" href="{!! asset('fullcalendar/css/fullcalendar.min.css') !!}">
    {{-- <link rel="stylesheet" href="{!! asset('fullcalendar/css/fullcalendar.print.min.css') !!}"> --}}
    <link rel="stylesheet" href="{{ asset('datePicker/css/bootstrap-datepicker3.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('form-helper/css/bootstrap-formhelpers.min.css') }}">
@endsection

@section('content')

    <div class="content">
        <!-- Mensaje flash dependiendo el tipo de accion -->
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="row">
            <!-- Caja para colocar un formulario para agendar cita -->
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Agregar cita</h3>
                    </div>
                    <div class="box-body">

                    </div>
                </div>

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Hola</h3>
                    </div>
                    <div class="box-body">
                        
                    </div>
                </div>
            </div>
            <!-- Caja para el calendario -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
            @include('components.modal-cambiar-estado-cita')
            @include('components.modal-agregar-nueva-cita')
        </div>

    </div>

@endsection

@section('scripts')
    <!-- Scripts para la caja de la hora en el modal -->
    <script src="{{asset('datePicker/js/bootstrap-datepicker.js')}}"></script>
    <!-- Archivo para el idioma -->
    <script src="{{asset('datePicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Para prueba -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('form-helper/js/bootstrap-formhelpers.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var caracteres_maximos = 200;
            $('#caracteres_restantes').html(caracteres_maximos + ' caracteres restantes');

            $('#observacion_de_cita').on('keyup', function() {
                var tamannio_texto = $(this).val().length;
                var restantes = caracteres_maximos - tamannio_texto;

                $('#caracteres_restantes').html(restantes + ' caracteres restantes');
            });
        });
    </script>

    <!-- Scripts para el calendario -->

    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script> --}}
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script> --}}
    <script src="{!! asset('fullcalendar/js/moment.min.js') !!}"></script>
    <script src="{!! asset('fullcalendar/js/fullcalendar.min.js') !!}"></script>
    {{-- <script src="{!! asset('fullcalendar/js/locale/es.js') !!}"></script> --}}
    <script src="{!! asset('fullcalendar/js/locale-all.js') !!}"></script>
    <script src="{!! asset('js/funciones_varias.js') !!}"></script>
    <script>
        let evento;

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
                });
            }

            $('#calendar').fullCalendar({
                locale: 'es',
                firstDay: 0, // (Domingo)
                events : array_citas,
                hiddenDays: [0],
                selectable: true, // permite seleccionar el dia
                header: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                eventClick: function(event) {
                    
                    let url = "{{ route('cambiar-estado-de-cita', [':date', ':user']) }}";
                    url = url.replace(':date', event.id);
                    url = url.replace(':user', '{{ Auth::user()->id }}');

                    $('#modal-cambiar-estado-cita').modal('show');
                    $('#modal-cambiar-estado-cita').find('#numero_contacto_cita').text(getCita(citas, event.id).numero_contacto);
                    $('#modal-cambiar-estado-cita').find('#observacion_contacto_cita').text(getCita(citas, event.id).observacion);
                    $('#modal-cambiar-estado-cita').find('#form_cambiar_estado').attr('action', url);
                },
                select: function(start, end, event) {
                    let fechaSeleccionada = start.format();
                    fechaSeleccionada = fechaSeleccionada.length <= 10 ? fechaSeleccionada : fechaSeleccionada.concat('Z');

                    let fechaActual = new Date(); // Obtiene la fecha actual
                    fechaActual = convertUTCDateToLocalDate(fechaActual);
                    let otraFecha = new Date(fechaSeleccionada); // Obtiene la fecha seleccionada en el calendario

                    console.log(fechaSeleccionada, otraFecha);

                    if(otraFecha.getTime() < fechaActual.getTime()) {
                        alert('La fecha seleccionada es anterior al día de hoy.\n\nPor favor, seleccione el día de hoy o un día posterior.');
                    }
                    else {
                        
                        $('#modal-nueva-cita').find('[name=fecha_seleccionada]').attr('value', fechaSeleccionada);
                        $('#modal-nueva-cita').find('[name=usuario]').attr('value', '{{ Auth::user()->id}}');
                        $('#modal-nueva-cita').modal('show');
                    }
                }
            })
        });

        function getCita(array, id_cita) {
            return array[id_cita-1];
        }

        $('#form-agregar-cita').submit(function(evento){
            evento.preventDefault();

            if($('[name="numero_contacto"]').val().length == 0) {
                alert('Debe ingresar un número de teléfono');
                return;
            }

            if($('[name="observacion_de_cita"]').val().length == 0) {
                alert('Ingrese texto para la observación.\n\nEs importante para conocer el motivo de la cita.');
                return;
            }

            this.submit();
        });
    </script>
@endsection