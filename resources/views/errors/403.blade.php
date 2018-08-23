@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-body">
                <div class="card-panel">
                    <div class="card-content text-warning text-center">
                        <i class="fas fa-hand-paper fa-10x"></i>
                        <br>
                        <p class="fa-2x">
                            <h2>{{ $exception->getMessage() }}</h2>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection