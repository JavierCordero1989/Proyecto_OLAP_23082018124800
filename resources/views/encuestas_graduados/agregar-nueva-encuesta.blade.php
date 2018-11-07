@extends('layouts.app')

@section('title', 'Nueva encuesta')

@section('css')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">
@endsection

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route'=>'encuestas-graduados.store', 'id'=>'form-nueva-encuesta', 'class'=>'form-horizontal']) !!}
                        <fieldset>
                            <!-- Caja para la cédula -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="identificacion_graduado">Identificación:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-address-card"></i></span>
                                        <input type="text" class="form-control" name="identificacion_graduado" id="identificacion_graduado">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el token -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="token">Token:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-fingerprint"></i></span>
                                        <input type="text" class="form-control" name="token" id="token">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el nombre completo -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="nombre_completo">Nombre completo:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" name="nombre_completo" id="nombre_completo">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el año de graduación -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="annio_graduacion">Año de graduación:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" name="annio_graduacion" id="annio_graduacion">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el link de la encuesta -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="link_encuesta">Link de la encuesta:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-link"></i></span>
                                        <input type="text" class="form-control" name="link_encuesta" id="link_encuesta">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el sexo -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="sexo">Sexo:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-transgender-alt"></i></span>
                                        <!-- HACER UN SELECT AQUI -->
                                        <input type="text" class="form-control" name="sexo" id="sexo">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el código de la carrera -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="codigo_carrera">Carrera:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <input type="text" class="form-control" name="codigo_carrera" id="codigo_carrera">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el código de la universidad -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="codigo_universidad">Universidad:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <input type="text" class="form-control" name="codigo_universidad" id="codigo_universidad">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el código del grado -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="codigo_grado">Grado:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <!-- HACER UN SELECT AQUI -->
                                        <input type="text" class="form-control" name="codigo_grado" id="codigo_grado">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el código de la área -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="codigo_area">Área:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <!-- HACER UN SELECT AQUI -->
                                        <input type="text" class="form-control" name="codigo_area" id="codigo_area">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el código de la disciplina -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="codigo_disciplina">Disciplina:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <!-- HACER UN SELECT AQUI -->
                                        <input type="text" class="form-control" name="codigo_disciplina" id="codigo_disciplina">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el código de la agrupación -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="codigo_agrupacion">Agrupación:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <!-- HACER UN SELECT AQUI -->
                                        <input type="text" class="form-control" name="codigo_agrupacion" id="codigo_agrupacion">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el código del sector -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="codigo_sector">Sector:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <!-- HACER UN SELECT AQUI -->
                                        <input type="text" class="form-control" name="codigo_sector" id="codigo_sector">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para el tipo de caso -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4" for="tipo_de_caso">Tipo de caso:</label>
                                <div class="col-md-8 inputGroupContainer">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
                                        <!-- HACER UN SELECT AQUI -->
                                        <input type="text" class="form-control" name="tipo_de_caso" id="tipo_de_caso">
                                    </div>
                                </div>
                            </div>

                            <!-- Caja para los botones de guardar y cancelar -->
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4"></label>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> Guardar caso </button>
                                    <a href="{!! route('encuestas-graduados.index') !!}" class="btn btn-default">
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
            let campos = {
                identificacion_graduado: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                token: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                nombre_completo: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                annio_graduacion: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                link_encuesta: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                sexo: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                codigo_carrera: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                codigo_universidad: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                codigo_grado: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                codigo_area: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                codigo_disciplina: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                codigo_agrupacion: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                codigo_sector: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                },
                tipo_de_caso: {
                    validators: {
                        notEmpty: {
                            message: 'El campo es requerido'
                        }
                    }
                }
            };

            $('#form-nueva-encuesta').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                }, 
                fields: campos
            })
            .on('success.form.bv', function(e){
                //$('#success_message').slideDown({opacity: "show"}, "slow")
                $('#form-nueva-encuesta').data('bootstrapValidator').resetForm();
                
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