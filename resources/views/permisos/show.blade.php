@extends('layouts.app')

@section('title', "Ver permiso")

@section('content')
    <section class="content-header">
        <h1>
            Permiso
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px;">
                    @include('permisos.show_fields')
                    <a href="{!! route('permisos.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
