@extends('layouts.app')

@section('title', "Crear Encuestador")

@section('content')
    <section class="content-header">
        <h1>
            Nuevo encuestador
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'encuestadores.store', 'onsubmit' => 'return validar_formulario();']) !!}

                        @include('encuestadores.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
