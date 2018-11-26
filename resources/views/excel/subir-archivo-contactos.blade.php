@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/modal_letters.css') }}">
    <link rel="stylesheet" href="{!! asset('css/estilos-app.min.css') !!}">
@endsection

@section('title', 'Archivo de contactos')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">

                    {!! Form::open(['route' => 'excel.subir-archivo-contactos', 'files' => 'true', 'id'=>'form_subir_contactos', 'onsubmit'=>'return eventoModalFormulario();']) !!}

                        <!-- Nombre Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('archivo_contactos', 'Seleccione el archivo a importar:') !!}
                            {!! Form::file('archivo_contactos', ['class' => 'form-control-file', 'accept'=>'.xlsx,.xls, .csv', 'required']) !!}
                            {{-- <input class="form-control" type="file" name="archivo_nuevo" id="archivo_nuevo" accept=".xlsx,.xls" required> --}}
                        </div>
                        
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! url('home') !!}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}

                    @include('modals.loading_letters')
                    @include('modals.mensaje')
                    @include('components.error-message')
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