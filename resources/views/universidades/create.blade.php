@extends('layouts.app')

@section('title', "Crear universidad")

@section('content')
    <section class="content-header">
        <h1>
            Crear nueva universidad
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'universidades.store']) !!}

                        @include('universidades.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
