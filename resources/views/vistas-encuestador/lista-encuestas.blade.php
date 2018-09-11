@extends('layouts.app')

@section('title', 'Mis entrevistas') 

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Mis Entrevistas</h1>
        {{-- <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('encuestadores.create') !!}">Agregar nuevo</a>
        </h1> --}}
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="box-header">
            <div class="box-body">
                @include('vistas-encuestador.tabla-lista')
            </div>
        </div>
    </div>
@endsection

