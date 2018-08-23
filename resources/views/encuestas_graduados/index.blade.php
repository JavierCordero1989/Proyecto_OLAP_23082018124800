@extends('layouts.app')

@section('title', 'Encuestadores') 

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Lista de encuestas</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('encuestas-graduados.create') !!}">Agregar nueva</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box-header">
            <div class="box-body">
                @include('encuestas_graduados.table')
            </div>
        </div>
        {{-- <div class="text-center">
        
        </div> --}}
    </div>
@endsection

