@extends('errors.layout')

@section('css')
    <style>
        .img-responsive {
            margin-top: 15%;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-xs-4">
            {{-- <img src="https://images3.alphacoders.com/112/112347.jpg" alt="" class="img-responsive"> --}}
        </div>
        <div class="col-xs-4">
            <img src="{!! asset('img/404.png') !!}" alt="" class="img-responsive">
        </div>
        <div class="col-xs-4">
            {{-- <img src="https://images3.alphacoders.com/112/112347.jpg" alt="" class="img-responsive"> --}}
        </div>
        <div class="col-xs-12">
            <h3 class="text-center">¡¡Página no encontrada!!</h3>
        </div>
    </div>
@endsection