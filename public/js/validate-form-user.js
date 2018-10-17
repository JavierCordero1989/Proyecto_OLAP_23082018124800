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