<div id="modal-cambiar-estado-cita" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Cambiar estado del evento</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-left: 20px">
                    <!-- 'route' => 'cambiar-estado-de-cita' -->
                    {!! Form::open(['id'=>'form_cambiar_estado']) !!}
                        <div class="col-xs-12">
                            <div class="form-group">
                                {!! Form::label('estado_evento', 'Estado:') !!}
                                {!! Form::select('estado_nuevo', [''=>'Seleccione...', 'P'=>'Pendiente', 'L'=>'Lista'], null, ['class' => 'form-control', 'required' => 'required']) !!}
                            </div>

                            <!-- Submit Field -->
                            <div class="form-group">
                                {!! Form::submit('Cambiar', ['class' => 'btn btn-primary']) !!}
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