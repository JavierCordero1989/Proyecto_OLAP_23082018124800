<a href="#{!! $id_modal !!}" data-toggle="modal" class='btn btn-default btn-xs'>
    <i class="glyphicon glyphicon-eye-open"></i>
</a>

<div class="modal fade" id="{{ $id_modal }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">{{ $nombre_encuestador }}</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-left: 20px">
                        <div class="col-xs-12">
                            <!-- User code Field -->
                            <div class="form-group">
                                {!! Form::label('user_code', 'Código:') !!}
                                <p>{!! $codigo_usuario !!}</p>
                            </div>
                            
                            <!-- Extension Field -->
                            <div class="form-group">
                                {!! Form::label('extension', 'Extensión:') !!}
                                <p>{!! $extension !!}</p>
                            </div>

                            <!-- Mobile Number -->
                            <div class="form-group">
                                {!! Form::label('mobile', 'Celular:') !!}
                                <p>{!! $mobile !!}</p>
                            </div>

                            <!-- Nombre Field -->
                            <div class="form-group">
                                {!! Form::label('email', 'Email:') !!}
                                <p>{!! $email !!}</p>
                            </div>

                            <div class="form-group">
                                {!! Form::label('created_at', 'Creado el: ') !!}
                                <p>{!! $created_at !!}</p>
                            </div>
                            <div class="form-group">
                                {!! Form::label('updated_at', 'Modificado el: ') !!}
                                <p>{!! $updated_at !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>