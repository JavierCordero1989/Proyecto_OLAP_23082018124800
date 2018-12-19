@extends('layouts.app')

@section('title', 'Reasignar caso')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body with-border">
                
                <div class="row">
                    {!! Form::open(['route'=>['asignar-encuestas.reasignar-caso-post', $id_entrevista, $id_encuestador], 'class'=>'']) !!}
                        <div class="col-md-12 form-group">
                            {!! Form::label('user_code', 'Ingrese el código del usuario al que desea reasignar la entrevista:') !!}
                            {!! Form::text('user_code', null, ['class'=>'form-control', 'id'=>'user_code', 'required']) !!}
                        </div>
                        
                        <div class="col-md-12 form-group">
                            {!! Form::button('<i class="fas fa-exchange-alt"></i> Reasignar', [
                                'type'=>'submit',
                                'class'=>'btn btn-primary'
                            ]) !!}
        
                            <a href="{!! route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador) !!}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i>
                                Cancelar
                            </a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection