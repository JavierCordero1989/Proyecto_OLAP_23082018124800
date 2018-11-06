@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">
@endsection

<div class="col-xs-6 col-xs-offset-3">
<!-- Codigo del usuario Field -->
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

    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('encuestadores.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
    
</div>

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <!-- Script para verificar codigo de usuario y correo ingresados -->
    <script>
        let codigo_usuario_correcto = false;
        let email_usuario_correcto = false;

        //Caja con el código de usuario
        let caja_codigo_usuario = $('#user_code');

        // Evento para comprobar el código de usuario
        // caja_codigo_usuario.on('keyup', function() {
        //     $.ajax({
        //         url: '{{--{{ route("findUserByCode") }}--}}',
        //         data: {codigo_usuario: $(this).val()},
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(respuesta) {
        //             $('#user_code_error').html(respuesta.mensaje);
        //             $('#user_code_error').removeClass('hide');
        //             $('#user_code_error').addClass('show');
        //             codigo_usuario_correcto = !respuesta.encontrado;
        //         }
        //     });
        // });

        // Caja para el email del usuario
        let caja_email_usuario = $('#email');

        // Evento para comprobar el correo.
        // caja_email_usuario.on('keyup', function() {
        //     $.ajax({
        //         url: '{{ route("findUserByEmail") }}',
        //         data: {email: $(this).val()},
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(respuesta) {
        //             $('#email_error').html(respuesta.mensaje);
        //             email_usuario_correcto = !respuesta.encontrado;
        //         }
        //     });
        // });

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
        // function validar_formulario() {
        //     if(!codigo_usuario_correcto) {
        //         alert('Debes revisar el código de usuario antes de continuar.'); 
        //         return false;
        //     }
        //     else if(!email_usuario_correcto) {
        //         alert('Debes revisar el email antes de continuar.'); 
        //         return false;
        //     }
        //     else {
        //         return true;
        //     }
        // }

        $(function() {
            $('#form-crear-nuevo-encuestador').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }, 
                fields: {
                    user_code: {
                        validators: {
                            notEmpty: {
                                message: 'El código del encuestador es requerido.'
                            },
                            callback: {
                                message: 'El código ingresado ya está en uso.',
                                callback: function(value, validator, $field) {
                                    var call = true;

                                    $.ajax({
                                        url: '{{ route("findUserByCode") }}',
                                        data: {codigo_usuario: value},
                                        type: 'GET',
                                        dataType: 'json',
                                        async: false,
                                        success: function(respuesta) {
                                            call = !respuesta.encontrado;
                                        }
                                    });
                                    return call;
                                }
                            }
                        }
                    },
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'El nombre es requerido.'
                            }
                        }
                    },
                    email: {
                        validators: {
                            regexp: {
                                regexp: '',
                                message: 'Correo electrónico con formato no válido'
                            },
                            notEmpty: {
                                message: 'El correo electrónico es requerido.'
                            },
                            callback: {
                                message: 'El correo ingresado ya está en uso.',
                                callback: function(value, validator, $field) {
                                    var call = true;

                                    $.ajax({
                                        url: '{{ route("findUserByEmail") }}',
                                        data: {email: value},
                                        type: 'GET',
                                        dataType: 'json',
                                        async: false,
                                        success: function(respuesta) {
                                            call = !respuesta.encontrado;
                                        }
                                    });

                                    return call;
                                }
                            }
                        }
                    },
                    password: {
                        validators: {
                            regexp: {
                                regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?.-_])[A-Za-z\d@$!%*?.-_]{7,15}$/,
                                message: 'Contraseña con formato no válida.'
                            },
                            notEmpty: {
                                message: 'La contraseña es requerida.'
                            }
                        }
                    }
                }
            })
            .on('success.form.bv', function(e){
                //$('#success_message').slideDown({opacity: "show"}, "slow")
                $('#form_prueba').data('bootstrapValidator').resetForm();
                
                //Previene el submit
                e.preventDefault();
                
                // Obtiene la instancia del formulario
                let $formulario = $(e.target);
                
                //Obtiene la instancia del validador de bootstrap
                let bv = $formulario.data('bootstrapValidator');

                if(!codigo_usuario_correcto) {
                    alert('Debes revisar el código de usuario antes de continuar.'); 
                    return false;
                }
                else if(!email_usuario_correcto) {
                    alert('Debes revisar el email antes de continuar.'); 
                    return false;
                }
                else {
                    this.submit();
                }
                
            });
        });
    </script>
@endsection

{{-- @section('scripts')
    <script src="{!! asset('js/validate-form-user.js') !!}"></script>
@endsection --}}