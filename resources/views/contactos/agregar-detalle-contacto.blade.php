@extends('layouts.app')

@section('title', 'Agregar detalle')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body with-border">
                {!! Form::open(['route'=>['contactos.guardar-detalle-contacto-post', $entrevista->id, $contacto->id]]) !!}
                    <div class="col-md-6 col-md-offset-3 form-group">
                        <label for="contacto">Contacto (número o correo):</label>
                        {!! Form::text('contacto', null, ['class'=>'form-control', 'required']) !!}
                    </div>

                    <div class="col-md-6 col-md-offset-3 form-group">
                        <label for="observacion">Observación:</label>
                        {!! Form::textarea('observacion', null, ['class'=>'form-control', 'rows'=>'5', 'cols'=>'40', 'maxlength'=>'200']) !!}
                        <span id="caracteres_restantes" class="text-success"></span>
                    </div>

                    <div class="col-md-6 col-md-offset-3">
                        {!! Form::submit('Agregar contacto', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('encuestas-graduados.administrar-contactos-get', $entrevista->id) !!}" class="btn btn-default">Cancelar</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {

            let mensajeCaracteres = $('#caracteres_restantes')
            let cajaObservacion = $('[name="observacion"]')
            let maxlength = 200
            let restantes = maxlength

            mensajeCaracteres.text("Caracteres restantes " + restantes + " de 200.")

            cajaObservacion.on('keyup', function() {
                restantes = maxlength - $(this).val().length
                mensajeCaracteres.text("Caracteres restantes " + restantes + " de 200.")
            });
        })
    </script>
@endsection