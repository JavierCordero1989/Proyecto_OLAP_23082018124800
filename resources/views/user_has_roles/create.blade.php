@extends('layouts.app')

@section('title', "Asignar roles")

@section('content')
    <section class="content-header">
        <h1>
            Asignar roles a un usuario
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'rolesToUser.store']) !!}

                        @include('user_has_roles.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
