@extends('layouts.app')

@section('title', "Crear Encuestador")

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Agregar nueva información de contacto
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['encuestas-graduados.guardar-contacto', $id_encuesta], 'id'=>'form-nuevo-contacto', 'class'=>'form-horizontal']) !!}
                        
                        <!-- Campo para la identificacion de la referencia -->
                        <div class="form-group">
                            {!! Form::label('user_code', 'Identificación de la referencia: ', ['class'=>'control-label col-md-4']) !!}
                            <div class="inputGroupContainer col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
                                    {!! Form::text('user_code', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campo para el nombre de la referencia -->
                        <div class='form-group'>
                            <label for='nombre_referencia' class='control-label col-md-4'>Nombre de referencia: </label>
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                                    <input type='text' class='form-control' name='nombre_referencia' id='nombre_referencia'>
                                </div>
                            </div>
                        </div>

                        <!-- Campo para el parentezco -->
                        <div class='form-group'>
                            <label for='parentezco' class='control-label col-md-4'>Parentezco con el graduado: </label>
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='fas fa-users'></i></span>
                                    <input type='text' class='form-control' name='parentezco' id='parentezco'>
                                </div>
                            </div>
                        </div>
                            
                        <!-- Campo para el nombre de la referencia -->
                        <div class='form-group'>
                            <label for='informacion_contacto' class='control-label col-md-4'>Información de contacto: </label>
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='fas fa-calendar-plus'></i></span>
                                    <input type='text' class='form-control' name='informacion_contacto' id='informacion_contacto'>
                                </div>
                            </div>
                        </div>

                        <!-- Campo para la observacion -->
                        <div class='form-group'>
                            <label for='observacion_contacto' class='control-label col-md-4'>Observación:</label>
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='far fa-eye'></i></span>
                                    <input type='textarea' class='form-control' name='observacion_contacto' id='observacion_contacto' rows='2', cols='40'>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Field -->
                        <div class='form-group'>
                            <label for='' class='control-label col-md-4'></label>
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <button type="submit" class='btn btn-primary'>Guardar</button>
                                    <a href="{!! route('encuestas-graduados.index') !!}" class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </div>

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
            $('#form-nuevo-contacto').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }, 
                fields: {
                    informacion_contacto: {
                        validators: {
                            notEmpty:{
                                message: 'El contacto es un dato requerido.'
                            }
                        }
                    },
                    observacion_contacto: {
                        validators: {
                            stringLength:{
                                min: 0,
                                max: 200,
                                message: 'La observación no puede contener más de 200 caractéres.'
                            }
                        }
                    },
                }
            })
            .on('success.form.bv', function(e){
                //$('#success_message').slideDown({opacity: "show"}, "slow")
                $('#form-nuevo-contacto').data('bootstrapValidator').resetForm();
                
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