@extends('layouts.app')

@section('title', 'Búsqueda') 

@section('content')
    <section class="content-header">
        <h1>
            Ingrese los filtros que desea para la muestra
        </h1>
    </section>

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['asignar-encuestas.filtrar-muestra', 'id_supervisor'=>$id_supervisor,'id_encuestador'=>$id_encuestador], 'onsubmit'=>'return validar_submit();']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('carrera', 'Carreras:') !!}
                            {!! Form::select('carrera', $datos_carrera['carreras'], null, ['class' => 'form-control', 'placeholder'=>'Elija una carrera']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('universidad', 'Universidad:') !!}
                            {!! Form::select('universidad', $datos_carrera['universidades'], null, ['class' => 'form-control', 'placeholder'=>'Elija una universidad']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('grado', 'Grado:') !!}
                            {!! Form::select('grado', $datos_carrera['grados'], null, ['class' => 'form-control', 'placeholder'=>'Elija un grado']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('disciplina', 'Disciplina:') !!}
                            {!! Form::select('disciplina', $datos_carrera['disciplinas'], null, ['class' => 'form-control', 'placeholder'=>'Elija una disciplina']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('area', 'Área:') !!}
                            {!! Form::select('area', $datos_carrera['areas'], null, ['class' => 'form-control', 'placeholder'=>'Elija un área']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('agrupacion', 'Agrupación:') !!}
                            {!! Form::select('agrupacion', $datos_carrera['agrupaciones'], null, ['class' => 'form-control', 'placeholder'=>'Elija una agrupación']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('sector', 'Sector:') !!}
                            {!! Form::select('sector', $datos_carrera['sectores'], null, ['class' => 'form-control', 'placeholder'=>'Elija un sector']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('encuestadores.index') !!}" class="btn btn-default">Cancelar</a>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function validar_submit() {

            //Reune todos los select del formulario en un array
            var form_data = [
                $('#carrera').val(),
                $('#universidad').val(),
                $('#grado').val(),
                $('#disciplina').val(),
                $('#area').val(),
                $('#agrupacion').val(),
                $('#sector').val()
            ];

            //Inicia un contador para ver cuantos valores hay en blanco
            var contador = 0;

            //Recorre el array con los datos del formulario, y cuenta los que estan vacios
            form_data.forEach( function(data) {
                if(data.length == 0) {
                    contador++;
                }
            });

            //Si hay 7 o mas datos vacios, no permitirá que el formulario continue
            if(contador >= 7) {
                alert('Debe elegir una opcion del filtro al menos para continuar');
                return false;
            }
            else {
                return true;
            }
        }
    </script>
@endsection

