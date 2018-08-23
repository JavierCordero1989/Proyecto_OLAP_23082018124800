@extends('layouts.app')

@section('title', "Crear permiso")

@section('content')
    <section class="content-header">
        <h1>
            Permiso nuevo
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'permisos.store']) !!}

                        @include('permisos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
