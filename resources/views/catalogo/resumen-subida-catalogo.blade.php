@extends('layouts.app')

@section('title', 'Resumen de archivos')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body with-border">
                <h3>Archivos subidos</h3>
                @foreach ($archivos_subidos as $item)
                    <p>{!! $item !!}</p>
                @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <h3>Totales: </h3>
                        @foreach ($contadores as $key => $item)
                            <p>{!! $key !!}: {!! $item !!}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection