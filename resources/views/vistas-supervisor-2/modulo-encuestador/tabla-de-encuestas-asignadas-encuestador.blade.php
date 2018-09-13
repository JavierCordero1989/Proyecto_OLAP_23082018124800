@extends('layouts.app')

@section('title', 'Encuestas sin asignar') 

@section('content')
    <div class="box-header">
        <div class="box-body">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            @if(sizeof($listaDeEncuestas) <= 0)
                <div class="content">
                    <div class="clearfix"></div>
                        <div class="card-panel">
                            <div class="card-content text-muted text-center">
                                <i class="fas fa-grin-beam-sweat fa-10x"></i>
                                <br>
                                <p class="fa-2x">
                                    No tienes entrevistas asignadas
                                </p>
                            </div>
                        </div>
                    <div class="clearfix"></div>
                </div>
            @else

            {{-- {!! Form::open(['route' => ['supervisor2.remover-encuestas-a-encuestador', $id_encuestador], 'onsubmit' => 'return verificar();']) !!}
                <section class="content-header">
                    <h1 class="pull-left">Encuestas asignadas</h1>
                    <h1 class="pull-right">
                    
                        {!! Form::submit('Quitar encuestas', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-top: -10px;margin-bottom: 5px;']) !!}
                        
                    </h1>
                </section>
                <div class="content">
                    <div class="clearfix"></div>
                    @include('flash::message')
                    <div class="clearfix"></div>
                    <div class="box-header">
                        <div class="box-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <th>{!! Form::checkbox('select_all', 0) !!}  Identificacion</th>
                                        <th>Nombre</th>
                                        <th>Año de graduación</th>
                                        <th>Sexo</th>
                                        <th>Carrera</th>
                                        <th>Universidad</th>
                                        <th>Grado</th>
                                        <th>Disciplina</th>
                                        <th>Área</th>
                                        <th>Tipo de caso</th>
                                    </thead>
                                    <tbody>
                                    @foreach($listaDeEncuestas as $encuesta)
                                        <tr>
                                            <td>{!! Form::checkbox('encuestas[]', $encuesta->id) !!} {!! $encuesta->identificacion_graduado !!}</td>
                                            <td>{!! $encuesta->nombre_completo !!}</td>
                                            <td>{!! $encuesta->annio_graduacion !!}</td>
                                            <td>{!! $encuesta->sexo !!}</td>
                                            <td>{!! $encuesta->carrera->nombre !!}</td>
                                            <td>{!! $encuesta->universidad->nombre !!}</td>
                                            <td>{!! $encuesta->grado->nombre !!}</td>
                                            <td>{!! $encuesta->disciplina->nombre !!}</td>
                                            <td>{!! $encuesta->area->nombre !!}</td>
                                            <td>{!! $encuesta->tipo_de_caso !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!} --}}

                <div class="col-xs-12 text-center">
                <h4>{{ $encuestador->name }}</h4>
                </div>
                @foreach($listaDeEncuestas as $entrevista)
                    <div class="col-md-6">
                        <div class="box box-primary {{--collapsed-box--}}" >
                            <!-- Encabezado del cuadro -->
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    {!! $entrevista->nombre_completo !!}
                                </h3>

                                <!-- Botones de la parte superior derecha -->
                                <div class="box-tools pull-right">
                                    <div class='btn-group'>
                                        <!-- Boton para minimizar/maximiar cada cuadro -->
                                        <button type="button" class="btn btn-info btn-xs" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Imagen del cuadro -->
                            <div class="box-body">
                                <div class="col-md-12">
                                    <p><strong>Cédula:</strong> {!! $entrevista->identificacion_graduado !!}</p>
                                    <p><strong>Carrera:</strong> {!! $entrevista->carrera->nombre !!}</p>
                                    <p><strong>Universidad:</strong> {!! $entrevista->universidad->nombre !!}</p>
                                    <p><strong>Año de graduación:</strong> {!! $entrevista->annio_graduacion !!}</p>
                                </div>
                            </div>

                            <!-- Botones del cuadro, parte inferior -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="{!! route('supervisor2.remover-encuestas-a-encuestador', [$entrevista->id, $encuestador->id]) !!}" class="btn btn-danger btn-sm col-sm-12">
                                            <i class="fa fa-plus-square"></i> Quitar entrevista
                                        </a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="#modal-ver-detalles-de-entrevista-{{$entrevista->id}}" class="btn btn-default btn-sm col-sm-12" data-toggle="modal">
                                            <i class="fa fa-plus-square"></i> Ver detalles
                                        </a>
                                        @include('vistas-supervisor-2.modulo-encuestador.modal_ver_detalles_de_entrevista')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function verificar() {
            var suma = 0;
            var checks = document.getElementsByName('encuestas[]');

            for(indice=0, j = checks.length; indice<j; indice++) {
                if(checks[indice].checked == true){
                    suma++;
                }
            }

            console.log(suma);

            if(suma == 0){
                alert('Debe seleccionar al menos una encuesta');
                return false;
            }
        }

        // $('[name=select_all]').change(function() {
        //     alert('El estado del check ha cambiado');
        // });

        $('[name=select_all]').click(function() {
            var checks = document.getElementsByName('encuestas[]');

            if($('[name=select_all]').get(0).checked) {
                console.log('Entra al if');
                for(indice=0, j = checks.length; indice<j; indice++) {
                    checks[indice].checked = true;
                }
            }
            else {
                console.log('Entra al else');
                for(indice=0, j = checks.length; indice<j; indice++) {
                    checks[indice].checked = false;
                }
            }
        });

        $('#btn_quitar_encuesta').click(function(e) {
            e.preventDefault();

            return confirm('¿Desea quitar la entrevista asignada a este encuestador?');
        });
    </script>
@endsection