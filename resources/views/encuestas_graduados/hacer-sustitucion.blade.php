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
                        <span id="mensaje-alerta"></span>
                    </div>

                    <div class="form-group">
                        {!! Form::button('<i class="fas fa-search"></i> Buscar...', [
                            'class'=>'btn btn-default',
                            'v-on:click'=>'find_survey_by_token()'
                        ]) !!}

                        {!! Form::button('<i class="fas fa-exchange-alt"></i> Sustituir', [
                            'class'=>'btn btn-primary',
                            'type'=>'submit',
                            'onclick'=>'return validarTokenEnBlanco();',
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

        <div v-if="encuesta_encontrada" class="box box-primary">
            <div id="survey-body" class="box-body with-border">
                <div class="col-md-6">
                    <label for="">Identificación del graduado:</label>
                    <p>@{{ encuesta.identificacion_graduado }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Nombre completo:</label>
                    <p>@{{ encuesta.nombre_completo }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Año de graduación:</label>
                    <p>@{{ encuesta.annio_graduacion }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Link de la encuesta:</label>
                    <p><a :href="encuesta.link_encuesta" target="_blank">@{{ encuesta.link_encuesta }}</a></p>
                </div>

                <div class="col-md-6">
                    <label for="">Sexo:</label>
                    <p v-if="encuesta.sexo == 'M'">Hombre</p>
                    <p v-else-if="encuesta.sexo == 'F'">Mujer</p>
                    <p v-else>Sin Clasificar</p>
                </div>

                <div class="col-md-6">
                    <label for="">Carrera:</label>
                    <p>@{{ encuesta.codigo_carrera }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Universidad:</label>
                    <p>@{{ encuesta.codigo_universidad }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Grado:</label>
                    <p>@{{ encuesta.codigo_grado }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Disciplina</label>
                    <p>@{{ encuesta.codigo_disciplina }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Área:</label>
                    <p>@{{ encuesta.codigo_area }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Agrupación</label>
                    <p>@{{ encuesta.codigo_agrupacion }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Sector:</label>
                    <p>@{{ encuesta.codigo_sector }}</p>
                </div>

                <div class="col-md-6">
                    <label for="">Tipo de caso</label>
                    <p>@{{ encuesta.tipo_de_caso }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

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
                            // console.log(response.data)

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