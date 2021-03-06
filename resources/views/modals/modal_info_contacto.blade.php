<div class="modal fade" id="modal-{!! $contacto->id !!}">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- Información del contacto -->
                <h4 class="modal-title">{!! $contacto->identificacion_referencia !!}</h4>
                <h4 class="modal-title">{!! $contacto->nombre_referencia !!}</h4>
                <h4 class="modal-title">{!! $contacto->parentezco !!}</h4>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <section class="content-header">
                    <h1 class="pull-right">
                        <!-- Botón para agregar nueva información al contacto -->
                        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px;" href="{!! route('detalles.create', $contacto->id) !!}">Nueva información</a>
                    </h1>
                </section>
                <div class="content">
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    <div class="box box-primary">
                        <div class="box-body table-responsive">
                            <!-- Tabla -->
                            <table class="table table-hover">
                                <thead>
                                    <th>Contacto</th>
                                    <th>Observación</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                    @foreach($contacto->detalle as $detalle)
                                    
                                        <tr>
                                            <td>{!! $detalle->contacto !!}</td>
                                            <td>{!! $detalle->observacion !!}</td>
                                            <td>
                                                {!! Form::open(['route' => ['detalles.destroy', $detalle->id], 'method' => 'delete']) !!}
                                                    <div class='btn-group'>
                                                        <a href="{!! route('detalles.edit', [$detalle->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                                        {!! Form::button(
                                                            '<i class="glyphicon glyphicon-trash"></i>',
                                                            [
                                                                'type' => 'submit', 
                                                                'class' => 'btn btn-danger btn-xs', 
                                                                'onclick' => "return confirm('¿Está seguro?')"
                                                            ]
                                                        ) !!}
                                                    </div>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                            
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <a href="{!! route('encuestadores.modificar-contacto', $contacto->id) !!}" class="btn btn-primary pull-right">Editar información</a>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>