@extends('layouts.app')

@section('title', 'Datos del supervisor') 

@section('content')
    <section class="content-header">
        <h1>
            Datos del supervisor
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('supervisores.show_fields')
                    <a href="{!! route('supervisores.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
