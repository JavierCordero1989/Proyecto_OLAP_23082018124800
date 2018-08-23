@extends('layouts.app')

@section('title', 'Inicio') 

@section('css')
    <style>
        .img_custom_logo {
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-sm-6">
            <img class="img-responsive center-block img_custom_logo" src="{{ asset('img/logo_conare.png') }}" alt="">
        </div>
        <div class="col-sm-6">
            <img class="img-responsive center-block img_custom_logo" src="{{ asset('img/logo_olap.png') }}" alt="">
        </div>
        
    </div>
</div>
@endsection
