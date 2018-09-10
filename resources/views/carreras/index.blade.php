@extends('layouts.app')

@section('title', "Carreras")

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Lista de carreras en el catálogo</h1>
        @if(!Auth::user()->hasRole('Encuestador'))
            <h1 class="pull-right">
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('carreras.create') !!}">Nueva carrera</a>
            </h1>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body table-responsive">
                @if(Auth::user()->hasRole('Encuestador'))
                    @include('carreras.table-encuestador')
                @else
                    @include('carreras.table')
                @endif
            </div>
        </div>
    </div>
@endsection

