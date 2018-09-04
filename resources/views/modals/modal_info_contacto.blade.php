<div class="modal fade" id="modal-{!! $contacto->id !!}">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <!-- Encabezado del modal -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Información del contacto</h4>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <p>{!! $contacto->identificacion_referencia !!}&hellip;</p>
                <p>{!! $contacto->nombre_referencia !!}&hellip;</p>
                <p>{!! $contacto->informacion_contacto !!}&hellip;</p>
                <p>{!! $contacto->observacion_contacto !!}&hellip;</p>
            </div>

            <!-- Pie del modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <a href="{!! route('encuestadores.modificar-contacto', Crypt::encrypt($contacto->id)) !!}" class="btn btn-primary pull-right">Editar información</a>
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>