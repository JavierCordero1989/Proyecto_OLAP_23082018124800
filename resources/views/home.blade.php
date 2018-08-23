@extends('layouts.app')

@section('title', 'Inicio') 

@section('css')
    <style>
        .flex-parent{
            display: -ms-flex;
            display: -webkit-flex;
            display: flex;
        }

        .flex-child{
            display: -ms-flex;
            display: -webkit-flex;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row flex-parent" style="height: 100%;">

        <div class="col-sm-6 flex-child" {{--style="height: 100%;"--}}>
            <img class="img-responsive center-block" src="{{ asset('img/logo_conare.png') }}" alt="">
        </div>
        
        <div class="col-sm-6 flex-child" {{--style="height: 100%;"--}}>
            <img class="img-responsive center-block" src="{{ asset('img/logo_olap.png') }}" alt="">
        </div>
    </div>
</div>
@endsection
