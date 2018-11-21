<div id="modal-nueva-cita" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Agregar nuevo evento</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-left: 20px">
                    <!-- 'route' => 'cambiar-estado-de-cita' -->
                    {!! Form::open(['route'=>'agendar-cita-desde-calendario', 'id'=>'form-agregar-cita']) !!}
                        <div class="col-xs-12">
                            {!! Form::hidden('fecha_seleccionada', '') !!}
                            {!! Form::hidden('usuario', '') !!}
                            
                            {{-- <div class="form-group">
                                {!! Form::label('hora_de_cita', 'Hora de la cita:') !!}
                                <div class="bfh-timepicker" data-name="hora_de_cita" data-mode="12h"></div>
                            </div> --}}

                            <div class="form-group">
                                <label for="timepicker" class="control-label col-xs-4">Hora: </label>
                                <input type="text" class="form-control datepick" name="timepicker" id="timepicker" readonly>
                            </div>

                            <div class="form-group">
                                {!! Form::label('numero_contacto', 'Número para contactar') !!}
                                {!! Form::text('numero_contacto', null, ['class'=>'form-control bfh-phone', 'data-format'=> 'dddd-dddd', 'placeholder'=>'9999-9999']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('observacion_de_cita', 'Observación de la cita:') !!}
                                {!! Form::textarea('observacion_de_cita', null, ['class'=>'form-control', 'maxlength'=>'200', 'cols'=>200, 'rows'=>4]) !!}
                                <div id="caracteres_restantes"></div>
                            </div>

                            <!-- Submit Field -->
                            <div class="form-group">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>