@extends('layouts.app')

@section('title', "Crear área")

@section('content')
    <section class="content-header">
        <h1>
            Crear nueva área
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'areas.store']) !!}

                        @include('areas.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
