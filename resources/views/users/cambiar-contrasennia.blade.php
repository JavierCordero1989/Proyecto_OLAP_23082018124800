@extends('layouts.app')

@section('title', 'Cambiar contraseña')

@section('css')
    <link rel="stylesheet" href="{!! asset('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css') !!}">
@endsection

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route'=>['users.update_password', $usuario->id], 'class'=>'form-horizontal', 'id'=>'form-change-password', 'method'=>'patch']) !!}
                        {{-- <fieldset> --}}
                            <!-- campo para el correo -->
                            <div class="form-group col-xs-12">
                                {!! Form::label('email', 'Ingrese su correo', ['class'=>'control-label col-md-5']) !!}
                                <div class="col-md-5 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                        {!! Form::email('email', null, ['class'=>'form-control', 'required'=>'required']) !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Campo para la contraseña -->
                            <div class="form-group col-xs-12">
                                {!! Form::label('password', 'Ingrese su contraseña', ['class'=>'control-label col-md-5']) !!}
                                <div class="col-md-5 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        {!! Form::password('password', ['class'=>'form-control', 'required'=>'required']) !!}
                                    </div>
                                </div>
                            </div>

                            <!-- Botónes para ENVIAR y CANCELAR -->
                            <div class="form-group col-xs-12">
                                {!! Form::label('', '', ['class'=>'control-label col-md-5']) !!}
                                <div class="col-md-5">
                                    {!! Form::button(
                                        '<span class="glyphicon glyphicon-floppy-saved"></span> Guardar',
                                        [
                                            'type' => 'submit', 
                                            'class' => 'btn btn-primary'
                                        ]) 
                                    !!}

                                    <a href="#" class="btn btn-default">
                                        <span class="glyphicon glyphicon-arrow-left"></span>
                                        Cancelar
                                    </a>
                                </div>
                            </div>
                        {{-- </fieldset> --}}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js') !!}"></script>
    <script>
        $(function() {
            $('#form-change-password').bootstrapValidator({
                feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
                }, 
                fields: {
                    email: {
                        validators: {
                            regexp: {
                                regexp: /^[^\s&*-/¿¡!?']{2,}@conare\.ac\.cr$/,
                                message: 'Correo con formato inválido'
                            },
                            notEmpty: {
                                message: 'Debe ingresar un email'
                            },
                            emailAddress: {
                                message: ' '
                            }
                        }
                    },
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