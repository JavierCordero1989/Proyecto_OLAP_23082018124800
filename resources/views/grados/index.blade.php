@extends('layouts.app')

@section('title', "Grados")

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Lista de grados en el catálogo</h1>
        @if(!Auth::user()->hasRole('Encuestador') || Auth::user()->hasRole('Supervisor 2'))
            <h1 class="pull-right">
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('grados.create') !!}">Nuevo grado</a>
            </h1>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body table-responsive">
                @if(Auth::user()->hasRole('Encuestador') || Auth::user()->hasRole('Supervisor 2'))
                    @include('grados.table-encuestador')
                @else
                    @include('grados.table')
                @endif
            </div>
        </div>
    </div>
@endsection

