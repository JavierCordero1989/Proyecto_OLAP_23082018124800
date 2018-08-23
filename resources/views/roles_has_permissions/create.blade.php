@extends('layouts.app')

@section('title', "Asignar permisos")

@section('content')
    <section class="content-header">
        <h1>
            Asignar permisos a un rol
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'permissionsToRol.store']) !!}

                        @include('roles_has_permissions.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
