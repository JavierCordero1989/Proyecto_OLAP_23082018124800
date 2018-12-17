@extends('layouts.app')

@section('title', 'Cambiar estado de entrevista')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        
        <div class="box box-primary">
            <div class="box-body with-border">
                <h3>Estado actual: </h3>
                <p>{!! $estado_actual->estado !!}</p>
                <hr>
                {!! Form::open(['route'=>['encuestas-graduados.cambiar-estado-entrevista-post', $id_entrevista]]) !!}
                    <div class="form-group  col-md-12">
                        {!! Form::label('estado', 'Elija uno de los siguientes estados:') !!}
                        {!! Form::select('estado', $estados_disponibles, null, ['class'=>'form-control']) !!}
                    </div>
        
                    <!-- Submit Field -->
                    <div class="form-group col-md-12">
                        {!! Form::submit('Cambiar', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('encuestas-graduados.index') !!}" class="btn btn-default">Cancelar</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection