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
            </div>
        </div>
    </div>
@endsection