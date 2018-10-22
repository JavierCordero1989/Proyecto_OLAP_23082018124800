@extends('layouts.app')

@section('css')
    {{-- <!-- Bootstrap version 4.1.3--> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> --}}
    <!-- CSS para las letras del modal -->
    <link rel="stylesheet" href="{{ asset('css/modal_letters.css') }}">
@endsection

@section('title', "Subir archivo")

@section('content')

    {{-- CSS para las letras del modal --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/modal_letters.css') }}"> --}}

    <section class="content-header">
        <h1>
            Importar Excel a Base de Datos
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'excel.import', 'files' => 'true', 'id'=>'form_importar_excel', 'onsubmit'=>'return eventoModalFormulario();']) !!}

                        @include('excel.importar_archivo')

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