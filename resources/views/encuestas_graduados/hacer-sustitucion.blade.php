@extends('layouts.app')

@section('title', 'Sustitución')

@section('content')
    <div class="content">
        <!-- Cuadro para notificaciones -->
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body with-border">
                {!! Form::open(['route'=>'encuestas-graduados.hacer-sustitucion-post', 'class'=>'']) !!}
                    <div class="form-group">
                        {!! Form::label('token_entrevista', 'Ingrese el token de la entrevista a sustituir:') !!}
                        {!! Form::text('token_entrevista', null, ['class'=>'form-control']) !!}
                        <span id="mensaje-alerta"></span>
                    </div>

                    <div class="form-group">
                        {!! Form::button('<i class="fas fa-search"></i> Buscar...', [
                            'class'=>'btn btn-default',
                            'onclick'=>'buscarEncuesta()'
                        ]) !!}

                        {!! Form::button('<i class="fas fa-exchange-alt"></i> Sustituir', [
                            'class'=>'btn btn-primary',
                            'type'=>'submit',
                            'onclick'=>'return validarTokenEnBlanco();',
                            'disabled'=>'true'
                        ]) !!}

                        <a href="{!! url('home') !!}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i>
                            Cancelar
                        </a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div id="survey-box" class="box box-primary hide">
            <div id="survey-body" class="box-body with-border">
                
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let token = $('#token_entrevista')

        function validarTokenEnBlanco() {
            if(token.val() == '') {
                alert('Debe ingresar un token para realizar la búsqueda.')
                return false;
            }
            return true;
        }

        function buscarEncuesta() {
            if(token.val() == '') {
                alert('Debe ingresar un token para realizar la búsqueda.');
            }
            else {
                let encuesta = null
                let url = '{{ route("encuestas-graduados.buscar-encuesta") }}';

                axios.get(url, {
                    params: {
                        token: token.val()
                    }
                }).then(response=>{
                    encuesta = response.data

                    if(encuesta == 'encuesta no encontrada') {
                        mostrarMensajeDeError()
                    }
                    else {
                        cargarEncuestaEncontrada(encuesta)
                    }
                })
            }
        }

        function cargarEncuestaEncontrada(encuesta) {
            $('#survey-box').removeClass('hide');
            $('#survey-box').addClass('show');

            $('#survey-body');
            
            // Carga la encuesta
            console.log('DATOS ENCONTRADOS: ' + encuesta);
        }

        function mostrarMensajeDeError() {
            //No carga nada
            console.log('NO SE ENCONTRARON DATOS.');
        }
    </script>
@endsection