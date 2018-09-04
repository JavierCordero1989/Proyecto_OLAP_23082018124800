@extends('layouts.app')

@section('title', 'Modificar encuestador')

@section('content')
    <section class="content-header">
        <h1>
            Cambio de contraseña
        </h1>
   </section>
   <div class="content">
       {{-- @include('adminlte-templates::common.errors') --}}
       <div class="clearfix"></div>

       @include('flash::message')

       <div class="clearfix"></div>

       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($encuestador, ['route' => ['encuestadores.actualizar-contrasennia', $encuestador->id], 'method' => 'patch', 'onsubmit' => 'return validarDatos();']) !!}
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="password" class="input-lg form-control" name="old_password" id="old_password" placeholder="Contraseña actual" autocomplete="off">
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
                            <input type="submit" class="col-xs-4 btn btn-primary btn-responsive" data-loading-text="Cambiando contraseña..." value="Cambiar contraseña">
                            <a href="{!! url('/home') !!}" class="col-xs-4 col-xs-offset-4 btn btn-default btn-responsive">Cancelar</a>
                        </div>
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
   <script>
        var claveActual = false;
        var longitudCorrecta = false;
        var minuscula = false;
        var mayuscula = false;
        var numero = false;
        var clavesIguales = false;

        function validarDatos() {
            if(longitudCorrecta && minuscula && mayuscula && numero && clavesIguales && claveActual) {
                return true;
            }
            else {
                alert('Debe verificar algunos campos');
                return false;
            }
        }

        $("input[type=password]").keyup(function(){
            var ucase = new RegExp("[A-Z]+");
            var lcase = new RegExp("[a-z]+");
            var num = new RegExp("[0-9]+");
            
            if($('#old_password').val().length >=1) {
                claveActual = true;
            }
            else {
                claveActual = false;
            }

            if($("#password1").val().length >= 8){
                $("#8char").removeClass("glyphicon-remove");
                $("#8char").addClass("glyphicon-ok");
                $("#8char").css("color","#00A41E");
                longitudCorrecta = true;
            }else{
                $("#8char").removeClass("glyphicon-ok");
                $("#8char").addClass("glyphicon-remove");
                $("#8char").css("color","#FF0004");
                longitudCorrecta = false;
            }
            
            if(ucase.test($("#password1").val())){
                $("#ucase").removeClass("glyphicon-remove");
                $("#ucase").addClass("glyphicon-ok");
                $("#ucase").css("color","#00A41E");
                minuscula = true;
            }else{
                $("#ucase").removeClass("glyphicon-ok");
                $("#ucase").addClass("glyphicon-remove");
                $("#ucase").css("color","#FF0004");
                minuscula = false;
            }
            
            if(lcase.test($("#password1").val())){
                $("#lcase").removeClass("glyphicon-remove");
                $("#lcase").addClass("glyphicon-ok");
                $("#lcase").css("color","#00A41E");
                mayuscula = true;
            }else{
                $("#lcase").removeClass("glyphicon-ok");
                $("#lcase").addClass("glyphicon-remove");
                $("#lcase").css("color","#FF0004");
                mayuscula = false;
            }
            
            if(num.test($("#password1").val())){
                $("#num").removeClass("glyphicon-remove");
                $("#num").addClass("glyphicon-ok");
                $("#num").css("color","#00A41E");
                numero = true;
            }else{
                $("#num").removeClass("glyphicon-ok");
                $("#num").addClass("glyphicon-remove");
                $("#num").css("color","#FF0004");
                numero = false;
            }
            
            if($("#password1").val() == $("#password2").val()){
                $("#pwmatch").removeClass("glyphicon-remove");
                $("#pwmatch").addClass("glyphicon-ok");
                $("#pwmatch").css("color","#00A41E");
                clavesIguales = true;
            }else{
                $("#pwmatch").removeClass("glyphicon-ok");
                $("#pwmatch").addClass("glyphicon-remove");
                $("#pwmatch").css("color","#FF0004");
                clavesIguales = false;
            }
        });
   </script>
@endsection