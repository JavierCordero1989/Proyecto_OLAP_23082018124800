@extends('layouts.app')

@section('title', "Grado")

@section('content')
    <section class="content-header">
        <h1>
            Grado
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('grados.show_fields')
                    <a href="{!! route('grados.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
