@extends('layouts.app')

@section('title', "Áreas")

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Lista de áreas en el catálogo</h1>
        <h1 class="pull-right">
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('areas.create') !!}">Nueva área</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('areas.table')
            </div>
        </div>
    </div>
@endsection

