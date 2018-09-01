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

<div class="modal modal-warning fade" id="modal-warning">
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
                            <form method="post" id="passwordForm">
                                <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="Nueva contraseña" autocomplete="off">
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
                                <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repita contraseña" autocomplete="off">
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

@section('scripts') 
    <script>
        $("input[type=password]").keyup(function(){
        var ucase = new RegExp("[A-Z]+");
        var lcase = new RegExp("[a-z]+");
        var num = new RegExp("[0-9]+");
        
        if($("#password1").val().length >= 8){
            $("#8char").removeClass("glyphicon-remove");
            $("#8char").addClass("glyphicon-ok");
            $("#8char").css("color","#00A41E");
        }else{
            $("#8char").removeClass("glyphicon-ok");
            $("#8char").addClass("glyphicon-remove");
            $("#8char").css("color","#FF0004");
        }
        
        if(ucase.test($("#password1").val())){
            $("#ucase").removeClass("glyphicon-remove");
            $("#ucase").addClass("glyphicon-ok");
            $("#ucase").css("color","#00A41E");
        }else{
            $("#ucase").removeClass("glyphicon-ok");
            $("#ucase").addClass("glyphicon-remove");
            $("#ucase").css("color","#FF0004");
        }
        
        if(lcase.test($("#password1").val())){
            $("#lcase").removeClass("glyphicon-remove");
            $("#lcase").addClass("glyphicon-ok");
            $("#lcase").css("color","#00A41E");
        }else{
            $("#lcase").removeClass("glyphicon-ok");
            $("#lcase").addClass("glyphicon-remove");
            $("#lcase").css("color","#FF0004");
        }
        
        if(num.test($("#password1").val())){
            $("#num").removeClass("glyphicon-remove");
            $("#num").addClass("glyphicon-ok");
            $("#num").css("color","#00A41E");
        }else{
            $("#num").removeClass("glyphicon-ok");
            $("#num").addClass("glyphicon-remove");
            $("#num").css("color","#FF0004");
        }
        
        if($("#password1").val() == $("#password2").val()){
            $("#pwmatch").removeClass("glyphicon-remove");
            $("#pwmatch").addClass("glyphicon-ok");
            $("#pwmatch").css("color","#00A41E");
        }else{
            $("#pwmatch").removeClass("glyphicon-ok");
            $("#pwmatch").addClass("glyphicon-remove");
            $("#pwmatch").css("color","#FF0004");
        }
    });
    </script>
@endsection