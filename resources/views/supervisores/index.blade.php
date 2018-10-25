@extends('layouts.app')

@section('title', 'Supervisores') 

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Supervisores</h1>
        <h1 class="pull-right">
            @if(Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('supervisores.create') !!}">Agregar nuevo</a>
            @endif
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box-header">
            <div class="box-body">
                @include('supervisores.table')
            </div>
        </div>
        {{-- <div class="text-center">
        
        </div> --}}
    </div>
@endsection

