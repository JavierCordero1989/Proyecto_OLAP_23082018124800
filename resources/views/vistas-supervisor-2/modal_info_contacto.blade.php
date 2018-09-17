<div class="modal fade" id="modal-{!! $contacto->id !!}">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Encabezado del modal -->
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
                <!-- Información del contacto -->
                <h4 class="modal-title">{!! $contacto->identificacion_referencia !!}</h4>
                <h4 class="modal-title">{!! $contacto->nombre_referencia !!}</h4>
                <h4 class="modal-title">{!! $contacto->parentezco !!}</h4>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <div class="content">
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <!-- Tabla -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Contacto</th>
                                        <th>Observación</th>
                                    </thead>
                                    <tbody>
                                        @foreach($contacto->detalle() as $detalle)
                                        
                                            <tr>
                                                <td>{!! $detalle->contacto !!}</td>
                                                <td>{!! $detalle->observacion !!}</td>
                                            </tr>
                                                
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie del modal -->
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
            </div> --}}
        </div>
    <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>