@extends('layouts.app')

@section('title', "Área")

@section('content')
    <section class="content-header">
        <h1>
            Área
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('areas.show_fields')
                    <a href="{!! route('areas.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
