@extends('layouts.app')

@section('title', "Crear carrera")

@section('content')
    <section class="content-header">
        <h1>
            Crear nueva carrera
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'carreras.store']) !!}

                        @include('carreras.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
