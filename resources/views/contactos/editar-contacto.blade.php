@extends('layouts.app')

@section('title', 'Editar contacto')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body with-border">
                <div class="row">
                    {!! Form::model($contacto, ['route'=>['contactos.editar-contacto-post', $entrevista->id, $contacto->id], 'method' => 'patch']) !!}
                        <div class="col-md-6 form-group">
                            <label for="identificacion_referencia">Identificación:</label>
                            {!! Form::text('identificacion_referencia', null, ['class'=>'form-control']) !!}
                        </div>
        
                        <div class="col-md-6 form-group">
                            <label for="nombre_referencia">Nombre:</label>
                            {!! Form::text('nombre_referencia', null, ['class'=>'form-control']) !!}
                        </div>
        
                        <div class="col-md-6 form-group">
                            <label for="parentezco">Parentezco:</label>
                            {!! Form::text('parentezco', null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="col-md-12 form-group">
                            {!! Form::submit('Actualizar datos', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('encuestas-graduados.administrar-contactos-get', $contacto->id_graduado) !!}" class="btn btn-default">Cancelar</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection