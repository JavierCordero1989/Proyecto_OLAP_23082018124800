@extends('layouts.app')

@section('title', "Crear Encuestador")

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
                    {!! Form::open(['route' => ['asignar-encuestas.guardar-contacto-entrevista-supervisor', 'id_entrevista'=>$id_entrevista, 'id_supervisor'=>Auth::user()->id], 'id'=>'form-nuevo-contacto']) !!}

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

                        <!-- Campo para el parentezco de la referencia -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('parentezco', 'Parentezco con el encuestado:') !!}
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
                            <a href="{!! route('asignar-encuestas.realizar-entrevista', $id_entrevista) !!}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts') 
    {{-- <script>
        function validar_campos() {
            var identificacion = $('#identificacion_referencia');
            var nombre = $('#nombre_referencia');
            var contacto = $('#informacion_contacto');
            var observacion = $('#observacion_contacto');

            if(identificacion.val().length <=0 && nombre.val().length <= 0 && contacto.val().length <= 0 && observacion.val().length <= 0) {
                alert('Si desea guardar información, al menos debe de ingresar un dato');
                return false;
            }
            else {
                return true;
            }
        }
    </script> --}}
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