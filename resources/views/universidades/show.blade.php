@extends('layouts.app')

@section('title', "Universidad")

@section('content')
    <section class="content-header">
        <h1>
            Universidad
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('universidades.show_fields')
                    <a href="{!! route('universidades.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
