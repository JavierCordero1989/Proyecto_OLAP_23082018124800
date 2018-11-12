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
                <input type="text" class="form-control" name="user_code" id="user_code" value="{!! $supervisor->user_code !!}" readonly>
            </div>
        </div>
    </div>

    <!-- Extension del usuario Field -->
    <div class="form-group">
        <label for="extension" class="control-label {!! $col_label !!}">Extensión:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <input type="tel" class="form-control" name="extension" id="extension" value="{!! $supervisor->extension !!}">
            </div>
        </div>
    </div>

    <!-- Celular del usuario Field -->
    <div class="form-group">
        <label for="mobile" class="control-label {!! $col_label !!}">Celular:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                <input type="tel" class="form-control" name="mobile" id="mobile" value="{!! $supervisor->mobile !!}">
            </div>
        </div>
    </div>

    <!-- Nombre Field -->
    <div class="form-group">
        <label for="name" class="control-label {!! $col_label !!}">Nombre:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" name="name" id="name" value="{!! $supervisor->name !!}">
            </div>
        </div>
    </div>

    <!-- Email Field -->
    <div class="form-group">
        <label for="email" class="control-label {!! $col_label !!}">Email:</label>
        <div class="{!! $col_input !!} inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input type="text" class="form-control" name="email" id="email" value="{!! $supervisor->email !!}" readonly>
            </div>
        </div>
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
            @if(Auth::user()->id == $supervisor->id)
                {!! Form::hidden('role_name', 'Supervisor 1') !!}
            @else 
                {!! Form::hidden('role_name', 'Supervisor 2') !!}
            @endif
        </div>
    @endif

    <!-- Submit Field -->
    <div class="form-group">
        <label class="control-label {!! $col_label !!}"></label>
        <div class="{!! $col_input !!}">
            {!! Form::button('<span class="glyphicon glyphicon-floppy-saved"></span> Actualizar datos', [
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
        $(function() {
            $('#form-editar-supervisor').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }, 
                fields: {
                    extension: {
                        validators:{
                            notEmpty: {
                                message: 'El número de extension es requerido'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'El teléfono solo debe poseer números, sin guiones o espacios'
                            }
                        }
                    },
                    mobile: {
                        validators:{
                            notEmpty: {
                                message: 'El número de celular es requerido'
                            },
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: 'El celular solo debe poseer números, sin guiones o espacios'
                            }
                        }
                    },
                    name: {
                        validators: {
                            callback: {
                                message: 'El nombre es requerido',
                                callback: function(value, validator, $field){
                                    if(value != '') {
                                        return true;
                                    }
                                    else {
                                        return false;
                                    }
                                }
                            }
                        }
                    },
                    password: {
                        validators: {
                            callback: {
                                message: 'La contraseña requerida',
                                callback: function(value, validator, $field) {
                                    if(value == '') {
                                        return confirm('¿Desea dejar la contraseña vacia?\nSi queda en blanco, la contraseña actual no cambiará')
                                    }
                                    else {
                                        let regexp=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?.-_])[A-Za-z\d@$!%*?.-_]{7,15}$/;
                                        if(regexp.test(value)) {
                                            return true;
                                        }
                                        return false;
                                    }
                                    
                                }
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
                $('#form-editar-supervisor').data('bootstrapValidator').resetForm();
                
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