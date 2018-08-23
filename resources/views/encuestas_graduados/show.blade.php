@extends('layouts.app')

@section('title', 'Datos del encuestador') 

@section('content')
    <section class="content-header">
        <h1>
            Datos del encuestador
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('encuestadores.show_fields')
                    <a href="{!! route('encuestadores.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
