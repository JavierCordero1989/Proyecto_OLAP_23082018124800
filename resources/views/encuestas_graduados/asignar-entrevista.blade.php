@extends('layouts.app')

@section('title', 'Asignar entrevista')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body with-border">
                {!! Form::open(['route'=>['encuestas-graduados.asignar-entrevista-post', $entrevista->id]]) !!}
                    <div class="form-group">
                        {!! Form::label('user_code', 'Ingrese el código del usuario al que desea asignar:') !!}
                        {!! Form::text('user_code', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Asignar', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('encuestas-graduados.index') !!}" class="btn btn-default">Cancelar</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection