<div class="modal modal-default fade" id="modal-agregar-nuevo-encuestador-{{$encuestador->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Datos detallados del encuestador</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-left: 20px">
                    {{-- <!-- Id Field --> --}}
                    {{-- <div class="form-group">
                        {!! Form::label('id', 'Id:') !!}
                        <p>{!! $encuestador->id !!}</p>
                    </div> --}}

                    <!-- User code Field -->
                    <div class="form-group">
                        {!! Form::label('user_code', 'Código:') !!}
                        <p>{!! $encuestador->user_code !!}</p>
                    </div>

                    <!-- Nombre Field -->
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre:') !!}
                        <p>{!! $encuestador->name !!}</p>
                    </div>

                    <!-- colocar los roles y permisos -->

                    <!-- Created At Field -->
                    <div class="form-group">
                        {!! Form::label('created_at', 'Creado el:') !!}
                        <p>{!! $encuestador->created_at !!}</p>
                    </div>

                    <!-- Updated At Field -->
                    <div class="form-group">
                        {!! Form::label('updated_at', 'Modificado el:') !!}
                        <p>{!! $encuestador->updated_at !!}</p>
                    </div>

                    <!--Botón para volver a atrás-->
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Volver</button>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>