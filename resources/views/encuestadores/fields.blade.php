<div class="col-xs-6 col-xs-offset-3">
<!-- Codigo del usuario Field -->
    <div class="form-group">
        {!! Form::label('user_code', 'Código:') !!}
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
        {{-- {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password']) !!} --}}
        {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('encuestadores.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
    
</div>

@section('scripts')
    <script>
        let permitir_formulario = false;

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
                    permitir_formulario = !respuesta.encontrado;
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
                    permitir_formulario = !respuesta.encontrado;
                }
            });
        });

        // Valida que todos los campos estén completos.
        function validar_formulario() {
            if(!permitir_formulario) { alert('Debes revisar el código de usuario o el email antes de continuar.'); }
            return permitir_formulario;
        }
    </script>
@endsection