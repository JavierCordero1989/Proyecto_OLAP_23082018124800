@extends('layouts.app')

@section('title', 'Cambiar contraseña de usuario')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">
@endsection

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">

                    {!! Form::open(['route'=>['security.reset-password', $registro], 'id'=>'form-password-reset', 'class'=>'form-horizontal']) !!}

                        <fieldset>
                            <!-- Caja para el código del usuario -->
                            <div class="form-group">
                                <label class="control-label col-md-5" for="email">Código del usuario:</label>
                                <div class="col-md-5 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" name="user_code" id="user_code" value="{!! $user->user_code !!}" disabled>
                                    </div>
                                </div>
                            </div>
                        

                            <!-- Caja para el nombre del usuario -->
                            <div class="form-group">
                                <label class="control-label col-md-5" for="email">Nombre:</label>
                                <div class="col-md-5 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input type="text" class="form-control" name="name" id="name" value="{!! $user->name !!}" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el correo electrónico -->
                            <div class="form-group">
                                <label class="control-label col-md-5" for="email">Correo electrónico</label>
                                <div class="col-md-5 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        <input type="text" class="form-control" name="email" id="email" value="{!! $user->email !!}" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para la nueva contraseña -->
                            <div class="form-group">
                                <label class="control-label col-md-5" for="email">Ingrese la nueva contraseña</label>
                                <div class="col-md-5 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para la confirmacion de contraseña -->
                            <div class="form-group">
                                <label class="control-label col-md-5" for="email">Confirme la nueva contraseña</label>
                                <div class="col-md-5 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input type="password" class="form-control" name="password_confirm" id="password_confirm">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para los botones de guardar y cancelar -->
                            <div class="form-group">
                                <label class="control-label col-md-5"></label>
                                <div class="col-md-5">
                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Cambiar contraseña </button>
                                    <a href="{!! url('/home') !!}" class="btn btn-default">
                                    <span class="glyphicon glyphicon-arrow-left"></span>
                                    Cancelar</a>
                                </div>
                            </div>
                        </fieldset>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <script>
        $(function() {
            $('#form-password-reset').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }, 
                fields: {
                    password: {
                        validators: {
                            regexp: {
                                regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?.-_])[A-Za-z\d@$!%*?.-_]{7,15}$/,
                                message: 'Contraseña con formato no válida'
                            },
                            notEmpty: {
                                message: 'Debe ingresar una contraseña'
                            }
                        }
                    },
                    password_confirm: {
                        validators: {
                            regexp: {
                                regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?.-_])[A-Za-z\d@$!%*?.-_]{7,15}$/,
                                message: 'Contraseña con formato no válida'
                            },
                            identical: {
                                field: 'password',
                                message: 'Las contraseñas no coinciden.'
                            },
                            notEmpty: {
                                message: 'Debe ingresar una contraseña'
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
                
                // Hacer algo con el submit
                this.submit();
            });
        });
    </script>
@endsection