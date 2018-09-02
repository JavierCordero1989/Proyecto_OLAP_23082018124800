{{-- <div class="modal modal-warning fade" id="modal-warning">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning Modal</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> --}}

<div class="modal modal-warning fade" id="modal-add_contact-info-{!! $encuesta->token !!}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cambio de contraseña</h4>
            </div>
            <div class="modal-body">
                {{-- <div class="container"> --}}
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <!-- Formulario obtenido de: -->
                            <!-- https://bootsnipp.com/snippets/featured/change-password-form-with-validation -->
                            <form method="post" id="passwordForm-{!! $encuesta->token !!}">
                                <input type="password" class="input-lg form-control" name="password1" id="password1-{!! $encuesta->token !!}" placeholder="Nueva contraseña" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 8 Caracteres<br>
                                        <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Una letra mayúscula
                                    </div>
                                    <div class="col-sm-6">
                                        <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Una letra minúscula<br>
                                        <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Un número
                                    </div>
                                </div>
                                <input type="password" class="input-lg form-control" name="password2" id="password2-{!! $encuesta->token !!}" placeholder="Repita contraseña" autocomplete="off">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Coincidencia de contraseñas
                                    </div>
                                </div>
                                <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Cambiando contraseña..." value="Cambiar contraseña">
                            </form>
                        </div><!--/col-sm-6-->
                    </div><!--/row-->
                {{-- </div> --}}
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
            </div> --}}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>