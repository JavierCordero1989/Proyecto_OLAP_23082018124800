@extends('layouts.app')

@section('title', "Crear disciplina")

@section('content')
    <section class="content-header">
        <h1>
            Crear nueva disciplina
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'disciplinas.store']) !!}

                        @include('disciplinas.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
