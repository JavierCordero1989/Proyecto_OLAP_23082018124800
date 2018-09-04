@extends('layouts.app')

@section('title', "Carrera")

@section('content')
    <section class="content-header">
        <h1>
            Carrera
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('carreras.show_fields')
                    <a href="{!! route('carreras.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
