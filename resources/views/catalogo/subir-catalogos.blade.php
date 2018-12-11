@extends('layouts.app')

@section('title', 'Carga de catálogo')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body with-border">
                <div class="row">
                    {!! Form::open(['route'=>'catalogo.cargar', 'files' => 'true', 'onsubmit'=>'return eventoModalFormulario();']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('catalogo_areas', 'Seleccione el archivo de áreas:') !!}
                            {!! Form::file('catalogo_areas', ['class' => 'form-control-file', 'accept'=>'.xlsx,.xls, .csv']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('catalogo_disciplinas', 'Seleccione el archivo de disciplinas:') !!}
                            {!! Form::file('catalogo_disciplinas', ['class' => 'form-control-file', 'accept'=>'.xlsx,.xls, .csv']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('catalogo_universidades', 'Seleccione el archivo de las universidades:') !!}
                            {!! Form::file('catalogo_universidades', ['class' => 'form-control-file', 'accept'=>'.xlsx,.xls, .csv']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('catalogo_carreras', 'Seleccione el archivo de las carreras:') !!}
                            {!! Form::file('catalogo_carreras', ['class' => 'form-control-file', 'accept'=>'.xlsx,.xls, .csv']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Subir archivos', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! url('home') !!}" class="btn btn-default">Cancelar</a>
                        </div>
                    {!! Form::close() !!}

                    @include('modals.loading_letters')
                    @include('modals.mensaje')
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts') 
    <!-- Script para las letras del modal -->
    <script src="{{ asset('js/jquery.lettering-0.6.1.min.js') }}"></script>

    <!-- Script para que las letras puedan tener su efecto de movimiento -->    
    <script>$(".loading").lettering();</script>

    <!-- Script para obtener los datos del formulario y realizar la peticion AJAX -->
    <script>
        function eventoModalFormulario() {
            $('#modalLoadingLetters').modal('show');
            return true;
        }
    </script>
@endsection