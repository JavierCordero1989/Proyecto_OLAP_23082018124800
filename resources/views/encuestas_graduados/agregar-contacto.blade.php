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
                    {!! Form::open(['route' => ['encuestas-graduados.guardar-contacto', $id_encuesta], 'id'=>'form-nuevo-contacto']) !!}

                        <!-- Campo para la identificacion de la referencia -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('identificacion_referencia', 'Identificacion de la referencia:') !!}
                            {!! Form::text('identificacion_referencia', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Campo para el nombre de la referencia -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('nombre_referencia', 'Nombre de la referencia:') !!}
                            {!! Form::text('nombre_referencia', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Campo para el parentezco -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('parentezco', 'Parentezco con el graduado:') !!}
                            {!! Form::text('parentezco', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Campo para el nombre de la referencia -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('informacion_contacto', 'Información de contacto:') !!}
                            {!! Form::text('informacion_contacto', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Campo para la observacion -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('observacion_contacto', 'Observación:') !!}
                            {!! Form::textarea('observacion_contacto', null, ['class' => 'form-control', 'rows' => 2, 'cols' => 40]) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('encuestas-graduados.index') !!}" class="btn btn-default">Cancelar</a>
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
                    identificacion_referencia: {
                        validators: {

                        }
                    },
                    nombre_referencia: {
                        validators: {
                            callback:{
                                message: 'Al menos el nombre del contacto es requerido.',
                                callback: function(value, validator, $field) {
                                    let parentezco_contacto = $('#parentezco').val();
                                    console.log('Nombre: '+parentezco_contacto);

                                    return (value != '' || parentezco_contacto != '');
                                }
                            }
                        }
                    },
                    parentezco: {
                        validators: {
                            callback:{
                                message: 'Al menos el parentezco con el graduado es requerido.',
                                callback: function(value, validator, $field) {
                                    let nombre_contacto = $('#nombre_referencia').val();
                                    console.log('Parentezco: ' + nombre_contacto);

                                    return (value != '' || nombre_contacto != '');
                                }
                            }
                        }
                    },
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