<div class="col-xs-6 col-xs-offset-3">
    <!-- Nombre Field -->
    <div class="form-group">
        {!! Form::label('user_code', 'Código de usuario:') !!}
        {!! Form::text('user_code', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <span class="help-block"><strong id="user_code_error" class="text-danger"></strong></span>
    </div>

    <!-- Nombre Field -->
    <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
        <span class="help-block"><strong id="email_error" class="text-danger"></strong></span>
    </div>

    <!-- Password Field -->
    <div class="form-group">
        {!! Form::label('password', 'Contraseña:') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <!-- Supervisor Field -->
    <div class="form-group">
        {!! Form::label('role_name', 'Elija un rol:') !!}
        {!! Form::select('role_name', [''=>'Elija un rol', 'Supervisor 1'=>'Supervisor 1', 'Supervisor 2'=>'Supervisor 2'], null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('supervisores.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>

@section('scripts')
    <!-- Script para verificar codigo de usuario y correo ingresados -->
    <script>
        let codigo_usuario_correcto = false;
        let email_usuario_correcto = false;

        //Caja con el código de usuario
        let caja_codigo_usuario = $('#user_code');

        // Evento para comprobar el código de usuario
        caja_codigo_usuario.on('keyup', function() {
            $.ajax({
                url: '{{ route("findUserByCode") }}',
                data: {codigo_usuario: $(this).val()},
                type: 'GET',
                dataType: 'json',
                success: function(respuesta) {
                    $('#user_code_error').html(respuesta.mensaje);
                    codigo_usuario_correcto = !respuesta.encontrado;
                }
            });
        });

        // Caja para el email del usuario
        let caja_email_usuario = $('#email');

        // Evento para comprobar el correo.
        caja_email_usuario.on('keyup', function() {
            $.ajax({
                url: '{{ route("findUserByEmail") }}',
                data: {email: $(this).val()},
                type: 'GET',
                dataType: 'json',
                success: function(respuesta) {
                    $('#email_error').html(respuesta.mensaje);
                    email_usuario_correcto = !respuesta.encontrado;
                }
            });
        });

        let default_mail = '@conare.ac.cr'; //Variable con correo predeterminado

        // evento cuando se escribe en la caja de texto del nombre
        $('#name').on('keyup', function() {
            let nombre = $(this).val().split(" ", 2); //Se divide la cadena ingresada en dos

            // Si solo hay un nombre
            if(nombre.length == 1) {
                if(nombre[0] == "") {
                    caja_email_usuario.val("");
                }
                else {
                    caja_email_usuario.val(nombre[0].toLowerCase()+default_mail);
                }
            }
            // Si hay dos nombres
            else if(nombre.length == 2) {
                caja_email_usuario.val(nombre[0].substring(0,1).toLowerCase()+nombre[1].toLowerCase()+default_mail);
            }
        });

        // Valida que todos los campos estén completos.
        function validar_formulario() {
            if(!codigo_usuario_correcto) {
                alert('Debes revisar el código de usuario antes de continuar.'); 
                return false;
            }
            else if(!email_usuario_correcto) {
                alert('Debes revisar el email antes de continuar.'); 
                return false;
            }
            else {
                return true;
            }
        }
    </script>
@endsection

{{-- @section('scripts')
    <script src="{!! asset('js/validate-form-user.js') !!}"></script>
@endsection --}}