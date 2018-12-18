@extends('layouts.app')

@section('title', 'Editar contacto')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body with-border">
                {!! var_dump($contacto) !!}
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="">Identificación:</label>
                        {!! Form::text('', null, ['class'=>'form-control']) !!}
                    </div>
    
                    <div class="col-md-6 form-group">
                        <label for="">Nombre:</label>
                        {!! Form::text('', null, ['class'=>'form-control']) !!}
                    </div>
    
                    <div class="col-md-6 form-group">
                        <label for="">Parentezco:</label>
                        {!! Form::text('', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-md-12 form-group">
                        {!! Form::submit('Actualizar datos', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('encuestas-graduados.administrar-contactos-get', $contacto->id_graduado) !!}" class="btn btn-default">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection