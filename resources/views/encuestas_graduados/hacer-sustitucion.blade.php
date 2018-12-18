@extends('layouts.app')

@section('title', 'Sustitución')

@section('content')
    <div id="app-vue-sustitucion" class="content">
        <!-- Cuadro para notificaciones -->
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body with-border">
                {!! Form::open(['route'=>'encuestas-graduados.hacer-sustitucion-post', 'class'=>'']) !!}
                    <div class="form-group">
                        {!! Form::label('token_entrevista', 'Ingrese el token de la entrevista a sustituir:') !!}
                        {!! Form::text('token_entrevista', null, ['class'=>'form-control', 'v-model'=>'token', 'v-bind:readonly'=>'setReadonly']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::button('<i class="fas fa-search"></i> Buscar...', [
                            'class'=>'btn btn-default',
                            'v-on:click'=>'find_survey_by_token()'
                        ]) !!}

                        {!! Form::button('<i class="fas fa-exchange-alt"></i> Reemplazar', [
                            'class'=>'btn btn-primary',
                            'type'=>'submit',
                            'onclick'=>'return verificar_solicitud();',
                            'v-bind:disabled'=>'setActive'
                        ]) !!}

                        {!! Form::button('<i class="fas fa-brush"></i> Limpiar', [
                            'type'=>'button',
                            'class'=>'btn btn-primary',
                            'v-on:click' => 'cleanToken()'
                        ]) !!}

                        <a href="{!! url('home') !!}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i>
                            Cancelar
                        </a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

        <!-- Caja donde se muestra la información de la entrevista encontrada -->
        <div v-if="encuesta_encontrada" class="box box-primary">
            <div id="survey-body" class="box-body with-border">
                <div class="col-md-6">
                    <p><u>Estado actual: </u> @{{ encuesta.estado_actual }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Identificación del graduado:</u> @{{ encuesta.identificacion_graduado }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Nombre completo:</u> @{{ encuesta.nombre_completo }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Año de graduación:</u> @{{ encuesta.annio_graduacion }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Link de la encuesta:</u> <a :href="encuesta.link_encuesta" target="_blank">@{{ encuesta.link_encuesta }}</a></p>
                </div>

                <div class="col-md-6">
                    <p v-if="encuesta.sexo == 'M'"><u>Sexo:</u> Hombre</p>
                    <p v-else-if="encuesta.sexo == 'F'"><u>Sexo:</u> Mujer</p>
                    <p v-else><u>Sexo:</u> Sin Clasificar</p>
                </div>

                <div class="col-md-6">
                    <p><u>Carrera:</u> @{{ encuesta.codigo_carrera }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Universidad:</u> @{{ encuesta.codigo_universidad }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Grado:</u> @{{ encuesta.codigo_grado }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Disciplina:</u> @{{ encuesta.codigo_disciplina }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Área:</u> @{{ encuesta.codigo_area }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Agrupación:</u> @{{ encuesta.codigo_agrupacion }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Sector:</u> @{{ encuesta.codigo_sector }}</p>
                </div>

                <div class="col-md-6">
                    <p><u>Tipo de caso:</u> @{{ encuesta.tipo_de_caso }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        function verificar_solicitud() {
            return confirm('¿Está seguro de realizar el reemplazo con los datos solicitados?')
        }

        new Vue({
            el: '#app-vue-sustitucion', 
            data: {
                token: '',
                encuesta_encontrada: false,
                encuesta: null,
                setActive: true,
                setReadonly: false
            },
            methods: {
                find_survey_by_token: function() {
                    if(this.token == '') {
                        alert('Debe ingresar un token para poder realizar la búsqueda')
                    }
                    else {
                        let url = '{{ route("encuestas-graduados.buscar-encuesta") }}';

                        axios.get(url, {
                            params: {
                                token: this.token
                            }
                        }).then(response => {

                            let encontrada = response.data.encontrada
                            this.encuesta = response.data.encuesta
                            let mensaje = response.data.mensaje

                            if(!encontrada) {
                                this.encuesta_encontrada = false
                                this.setActive = true
                                alert(mensaje)
                            }
                            else {
                                this.encuesta_encontrada = true
                                this.setActive = false
                                this.setReadonly = true
                                alert(mensaje)
                            }
                        })
                    }
                },
                cleanToken: function() {
                    this.token = ''
                    this.encuesta_encontrada = false
                    this.encuesta = null
                    this.setActive = true
                    this.setReadonly = false
                }
            }
        })

        
        // let token = $('#token_entrevista')

        // function validarTokenEnBlanco() {
        //     if(token.val() == '') {
        //         alert('Debe ingresar un token para realizar la búsqueda.')
        //         return false;
        //     }
        //     return true;
        // }

        // function buscarEncuesta() {
        //     if(token.val() == '') {
        //         alert('Debe ingresar un token para realizar la búsqueda.');
        //     }
        //     else {
        //         let encuesta = null
        //         let url = '{{ route("encuestas-graduados.buscar-encuesta") }}';

        //         axios.get(url, {
        //             params: {
        //                 token: token.val()
        //             }
        //         }).then(response=>{
        //             encuesta = response.data

        //             if(encuesta == 'encuesta no encontrada') {
        //                 mostrarMensajeDeError()
        //             }
        //             else {
        //                 cargarEncuestaEncontrada(encuesta)
        //             }
        //         })
        //     }
        // }

        // function cargarEncuestaEncontrada(encuesta) {
        //     $('#survey-box').removeClass('hide');
        //     $('#survey-box').addClass('show');

        //     $('#survey-body');
            
        //     // Carga la encuesta
        //     console.log('DATOS ENCONTRADOS: ' + encuesta);
        // }

        // function mostrarMensajeDeError() {
        //     //No carga nada
        //     console.log('NO SE ENCONTRARON DATOS.');
        // }
    </script>
@endsection