@extends('layouts.app')

@section('title', "Disciplina")

@section('content')
    <section class="content-header">
        <h1>
            Disciplina
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('disciplinas.show_fields')
                    <a href="{!! route('disciplinas.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
