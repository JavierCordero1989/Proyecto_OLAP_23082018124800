@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">
@endsection

    @php
        $col_label = 'col-md-4';
        $col_input = 'col-md-4';
    @endphp

    <!-- Codigo del usuario Field -->
    <div class="form-group">
        <label for="user_code" class="control-label {!! $col_label !!}">Código de usuario:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                <input type="text" class="form-control" name="user_code" id="user_code">
            </div>
        </div>
    </div>

    <!-- Extension del usuario Field -->
    <div class="form-group">
        <label for="extension" class="control-label {!! $col_label !!}">Extensión:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <input type="tel" class="form-control" name="extension" id="extension">
            </div>
        </div>
    </div>

    <!-- Celular del usuario Field -->
    <div class="form-group">
        <label for="mobile" class="control-label {!! $col_label !!}">Celular:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                <input type="tel" class="form-control" name="mobile" id="mobile">
            </div>
        </div>
    </div>

    <!-- Nombre Field -->
    <div class="form-group">
        <label for="name" class="control-label {!! $col_label !!}">Nombre:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" name="name" id="name">
            </div>
        </div>
    </div>

    <!-- Email Field -->
    <div class="form-group">
        <label for="email" class="control-label {!! $col_label !!}">Email:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input type="text" class="form-control" name="email" id="email">
            </div>
        </div>
        <a 
            href="#" 
            data-toggle="popover" 
            data-trigger="focus" 
            title="Formato" 
            data-content="Debe contener: ninguno de estos caracteres (& * - / ¿ ¡ ! ? '), el formato @conare.ac.cr, sin espacios en blanco"
        >
            <i class="fas fa-info-circle"></i>
        </a>
    </div>

    <!-- Password Field -->
    <div class="form-group">
        <label for="password" class="control-label {!! $col_label !!}">Contraseña:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>
        <a 
            href="#" 
            data-toggle="popover" 
            data-trigger="focus" 
            title="Formato" 
            data-content="Debe contener: Una mayúscula, una minúscula, un dígito, un carácter (@ $ ! % * ? . - _), de 8 a 15 caracteres y sin espacios en blanco"
        >
            <i class="fas fa-info-circle"></i>
        </a>
    </div>

    <!-- Supervisor Field -->
    @if(Auth::user()->hasRole('Super Admin'))
        <div class="form-group">
            <label for="role_name" class="control-label {!! $col_label !!}">Rol del supervisor:</label>
            <div class="{!! $col_input !!} inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-option-vertical"></i></span>
                    {!! Form::select('role_name', [''=>'Elija un rol', 'Supervisor 1'=>'Supervisor 1', 'Supervisor 2'=>'Supervisor 2'], null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    @endif

    @if(Auth::user()->hasRole('Supervisor 1'))
        <div class="form-group">
            {!! Form::hidden('role_name', 'Supervisor 2') !!}
        </div>
    @endif

    <!-- Submit Field -->
    <div class="form-group">
        <label class="control-label {!! $col_label !!}"></label>
        <div class="{!! $col_input !!}">
            {!! Form::button('<span class="glyphicon glyphicon-floppy-saved"></span> Guardar', [
                'type' => 'submit',
                'class'=> 'btn btn-primary'
            ]) !!}
            <a href="{!! route('supervisores.index') !!}" class="btn btn-default">
                <span class="glyphicon glyphicon-arrow-left"></span>
                Cancelar</a>
            </a>
            
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
            $('[data-toggle="popover"]').popover();

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
                    extension: {
                        validators: {
                            notEmpty: {
                                message:'El número de extensión es requerido.'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'El número de teléfono debe solo contener dígitos, sin espacios o guiones'
                            }
                        }
                    },
                    mobile: {
                        validators: {
                            notEmpty: {
                                message:'El número de celular es requerido.'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'El número de teléfono debe solo contener dígitos, sin espacios o guiones'
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