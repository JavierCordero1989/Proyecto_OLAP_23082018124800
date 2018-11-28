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
                                        <th>Estado del contacto</th>
                                        <th>Opciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach($contacto->detalle() as $detalle)
                                        
                                            <tr>
                                                <td>{!! $detalle->contacto !!}</td>
                                                <td>{!! $detalle->observacion == '' ? 'NO TIENE' : $detalle->observacion !!}</td>
                                                <td>{!! $detalle->estado == 'F' ? '<i class="fas fa-check-circle" style="color: green;"></i>' : ($detalle->estado == 'E' ? '<i class="fas fa-times-circle" style="color: red;"></i>' : 'INDEFINIDO') !!}</td>
                                                <td>
                                                    {{-- {!! Form::open(['route' => ['encuestador.borrar-detalle-contacto', $detalle->id, $encuesta->id], 'method' => 'delete', 'id'=>'form-eliminar-contacto-entrevista']) !!}
                                                        <div class='btn-group'>
                                                            <a href="{!! route('encuestador.editar-detalle-contacto', [$detalle->id, $encuesta->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                            {!! Form::button(
                                                                '<i class="glyphicon glyphicon-trash"></i>',
                                                                [
                                                                    'type' => 'submit',
                                                                    'class' => 'btn btn-danger btn-xs',
                                                                    'form'=>'form-eliminar-contacto-entrevista',
                                                                    'onclick' => "return confirm('¿Está seguro de eliminar este contacto?')"
                                                                ]
                                                            ) !!}
                                                        </div>
                                                    {!! Form::close() !!} --}}
                                                </td>
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