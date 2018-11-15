@extends('layouts.app')

@section('title', "Nueva cita")

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css">
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
                    {!! Form::open(['route'=>[$rutas['store'], $datos_a_vista['entrevista'], $datos_a_vista['encuestador']], 'onsubmit'=>'return validar_submit();', 'class'=>'form-horizontal']) !!}
                        
                        <div class="form-group">
                            <label for="datepicker" class="control-label col-xs-4">Fecha: </label>
                            <div class="inputGroupContainer col-xs-6">
                              <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input type="text" class="form-control datepick" name="datepicker" id="datepicker" readonly>
                              </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="timepicker" class="control-label col-xs-4">Hora: </label>
                            <div class="inputGroupContainer col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    <input type="text" class="form-control datepick" name="timepicker" id="timepicker" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('numero_contacto', 'Número para contactar', ['class'=>'control-label col-xs-4']) !!}
                            <div class="inputGroupContainer col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-phone"></i></span>
                                    {!! Form::select('numero_contacto', $datos_a_vista['contactos'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('numero_contacto', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('observacion_de_cita', 'Observación de la cita:', ['class'=>'control-label col-xs-4']) !!}
                            <div class="inputGroupContainer col-xs-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="far fa-eye"></i></span>
                                    {!! Form::textarea('observacion_de_cita', null, ['class'=>'form-control', 'maxlength'=>'200', 'cols'=>200, 'rows'=>4]) !!}
                                </div>
                                <div id="caracteres_restantes"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-4"></label>
                            <div class="col-xs-6">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary col-xs-3']) !!}
                                <a href="{!! route($rutas['back'], $datos_a_vista['entrevista']) !!}" class="btn btn-default col-xs-3 col-xs-offset-1">Cancelar</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/es.js"></script>

    <script>
        $(function() {
            moment.updateLocale("es", {
                week: {
                dow: 0 // 0 => DOMINGO
                }
            });

            $("#datepicker").datetimepicker({
                format: "YYYY-MM-DD",
                ignoreReadonly: true,
                daysOfWeekDisabled: [0],
                minDate: new Date(),
                locale: "es",
                tooltips: {
                selectMonth: "Seleccione el mes"
                /*today: 'Go to today',
                clear: 'Clear selection',
                close: 'Close the picker',
                selectMonth: 'Select Month',
                prevMonth: 'Previous Month',
                nextMonth: 'Next Month',
                selectYear: 'Select Year',
                prevYear: 'Previous Year',
                nextYear: 'Next Year',
                selectDecade: 'Select Decade',
                prevDecade: 'Previous Decade',
                nextDecade: 'Next Decade',
                prevCentury: 'Previous Century',
                nextCentury: 'Next Century'*/
                }
            });

            $("#timepicker").datetimepicker({
                format: "HH:mm",
                ignoreReadonly: true,
                enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
            });
        });
    </script>
    <script>
        // Para el campo de observación, contar caractéres.
        $(document).ready(function() {
            var caracteres_maximos = 200;
            $('#caracteres_restantes').html(caracteres_maximos + ' caracteres restantes');

            $('#observacion_de_cita').on('keyup', function() {
                var tamannio_texto = $(this).val().length;
                var restantes = caracteres_maximos - tamannio_texto;

                $('#caracteres_restantes').html(restantes + ' caracteres restantes');
            });
        });

        function validar_submit() {
            event.preventDefault();

            let fecha = $('[name="datepicker"]').val();
            let hora = $('[name="timepicker"]').val();

            let fecha_seleccionada = fecha + "T" + hora + ":00-06:00";
            let selected_date = moment(fecha_seleccionada);
            let current = moment();

            if (selected_date < current) {
                alert("La fecha que seleccionó es menor a la actual");
                return;
            }

            if (selected_date.hour() == 18 && selected_date.minute() > 0) {
                alert("No está permitido poner citas después de las 06:00 P.M.");
                return;
            }
            
            alert("OK!");
        }
    </script>
@endsection