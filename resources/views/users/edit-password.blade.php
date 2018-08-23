@extends('layouts.app')

@section('title', "Cambiar contraseña de usuario")

@section('content')
    <section class="content-header">
        <h1>
            Contraseña del usuario {!! $user->name !!}
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                    {!! Form::model($user, ['route' => ['users.update_password', $user->id], 'method' => 'patch', 'id'=>'form-edit-password', 'onsubmit'=>'return validar_claves()']) !!}

                        <div class="form-group col-sm-6">
                            {!! Form::label('new_password', 'Nueva contraseña:') !!}
                            {!! Form::password('new_password', ['class'=>'form-control', 'required']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('confirm_password', 'Confirma la contraseña:') !!}
                            {!! Form::password('confirm_password', ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary', 'id'=>'btn-submit']) !!}
                            <a href="{!! route('users.index') !!}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
   <!-- Script para comprobar que las contraseñas sean identicas -->
    <script type="text/javascript">
        var pass1, pass2;
                
        // pass1.onchange = pass2.onkeyup = coincidirContrasenias;
        
        // function coincidirContrasenias() {
        //     if(pass1.value !== pass2.value) {
        //         pass2.setCustomValidity('Las contraseñas no coinciden');
        //     }
        //     else {
        //         pass2.setCustomValidity('');
        //     }
        // }

        function validar_claves() {
            pass1 = document.getElementById('new_password');
            pass2 = document.getElementById('confirm_password');

            var espacios = false;
            var cont = 0;
            
            while (!espacios && (cont < pass1.value.length)) {
                if (pass1.value.charAt(cont) == " ") {
                    espacios = true;
                }
                cont++;
            }
            
            if (espacios) {
                alert ("La contraseña no puede contener espacios en blanco");
                return false;
            }

            if (pass1.value.length == 0 || pass2.value.length == 0) {
                alert("Los campos de la contraseña no pueden quedar vacios");
                return false;
            }

            if (pass1.value != pass2.value) {
                alert("Las contraseñas deben de coincidir");
                return false;
            } else {
                return true; 
            }
        }
    </script>
@endsection