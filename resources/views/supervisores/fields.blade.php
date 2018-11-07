@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">
@endsection

<div class="col-xs-12 col-sm-6 col-sm-offset-3">
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
    @if(Auth::user()->hasRole('Super Admin'))
        <div class="form-group">
            {!! Form::label('role_name', 'Elija un rol:') !!}
            {!! Form::select('role_name', [''=>'Elija un rol', 'Supervisor 1'=>'Supervisor 1', 'Supervisor 2'=>'Supervisor 2'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    @endif

    @if(Auth::user()->hasRole('Supervisor 1'))
        <div class="form-group">
            {!! Form::hidden('role_name', 'Supervisor 2') !!}
        </div>
    @endif

    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('supervisores.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    
    <!-- Script para verificar codigo de usuario y correo ingresados -->
    <script>

        // Caja para el email del usuario
        let caja_email_usuario = $('#email');

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
        
        $(function() {
            $('#form-crear-nuevo-supervisor').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }, 
                fields: {
                    user_code: {
                        validators: {
                            notEmpty: {
                                message: 'El código del supervisor es requerido.'
                            },
                            callback: {
                                message: 'El código ingresado ya está en uso.',
                                callback: function(value, validator, $field) {
                                    // Que el callback devuelva TRUE, significa que la condición se cumple
                                    // y el dato ingresado está bien.
                                    var call = true;

                                    $.ajax({
                                        url: '{{ route("findUserByCode") }}',
                                        data: {codigo_usuario: value},
                                        type: 'GET',
                                        dataType: 'json',
                                        async: false,
                                        success: function(respuesta) {
                                            /* Si la respuesta de AJAX es TRUE, quiere decir que el código
                                            ingresado existe, por lo que la respuesta del call deberá
                                            ser FALSE y lanzar el error en el formulario. */
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
                                regexp: /^[^\s&*-/¿¡!?']{2,}@conare\.ac\.cr$/,
                                message: 'Correo electrónico con formato no válido'
                            },
                            notEmpty: {
                                message: 'El correo electrónico es requerido.'
                            },
                            callback: {
                                message: 'El correo ingresado ya está en uso.',
                                callback: function(value, validator, $field) {
                                    /* Que el callback devuelva TRUE, significa que la condición se cumple 
                                    y el dato ingresado está bien. */
                                    var call = true;

                                    $.ajax({
                                        url: '{{ route("findUserByEmail") }}',
                                        data: {email: value},
                                        type: 'GET',
                                        dataType: 'json',
                                        async: false,
                                        success: function(respuesta) {
                                            /* Si la respuesta de AJAX es TRUE, quiere decir que el email
                                            ingresado existe, por lo que la respuesta del call deberá
                                            ser FALSE y lanzar el error en el formulario. */
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
                    },
                    role_name: {
                        validators: {
                            notEmpty: {
                                message: 'El rol del usuario es requerido'
                            }
                        }
                    }
                }
            })
            .on('success.form.bv', function(e){
                //$('#success_message').slideDown({opacity: "show"}, "slow")
                $('#form-crear-nuevo-supervisor').data('bootstrapValidator').resetForm();
                
                //Previene el submit
                e.preventDefault();
                
                // Obtiene la instancia del formulario
                let $formulario = $(e.target);
                
                //Obtiene la instancia del validador de bootstrap
                let bv = $formulario.data('bootstrapValidator');

                this.submit();                
            });
        });
    </script>
@endsection

{{-- @section('scripts')
    <script src="{!! asset('js/validate-form-user.js') !!}"></script>
@endsection --}}