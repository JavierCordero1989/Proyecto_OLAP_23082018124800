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
                    {!! Form::open(['route' => ['encuestadores.guardar-contacto', 'id_encuesta'=>$id_encuesta, 'id_encuestador'=>Auth::user()->id],'onsubmit'=>'return validar_campos();']) !!}

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
                            <a href="{!! route('encuestadores.lista-de-encuestas', Auth::user()->id) !!}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts') 
    <script>
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
    </script>
@endsection