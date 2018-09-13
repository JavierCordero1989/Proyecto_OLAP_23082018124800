<div class="modal modal-default fade" id="modal-agregar-nuevo-encuestador">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar nuevo encuestador</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open(['route' => 'supervisor2.almacenar-nuevo-encuestador', 'onsubmit'=>'return validar_formulario();']) !!}

                        <!-- Codigo del usuario Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-sm-12 text-center">
                                {!! Form::label('user_code', 'Código') !!}
                            </div>
                            <div class="col-sm-12">
                                {!! Form::text('user_code', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Nombre Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-xs-12 text-center">
                                {!! Form::label('name', 'Nombre') !!}
                            </div>
                            <div class="col-xs-12">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-xs-12 text-center">
                                {!! Form::label('email', 'Correo electrónico') !!}
                            </div>
                            <div class="col-xs-12">
                                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-xs-12 text-center">
                                {!! Form::label('password', 'Contraseña:') !!}
                            </div>
                            <div class="col-xs-12">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <div class="col-xs-3 col-xs-offset-3">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary col-xs-12']) !!}
                            </div>
                            <div class="col-xs-3">
                                <button type="button" class="btn btn-default col-xs-12 pull-left" data-dismiss="modal">Cancelar</button>
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