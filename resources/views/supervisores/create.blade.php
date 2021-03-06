@extends('layouts.app')

@section('title', "Crear Supervisor")

@section('content')
    <section class="content-header">
        <h1>
            Nuevo supervisor
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        {{-- @include('adminlte-templates::common.errors') --}}
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'supervisores.store', 'id' => 'form-crear-nuevo-supervisor', 'class'=>'form-horizontal']) !!}

                        <fieldset>
                            @include('supervisores.fields')
                        </fieldset>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection