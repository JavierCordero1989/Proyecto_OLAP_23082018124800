@extends('layouts.app')

@section('title', 'Encuestas sin asignar') 

@section('content')
    {!! Form::open(['route' => ['supervisor2.crear-nueva-asignacion', 'id_supervisor'=>$id_supervisor,'id_encuestador'=>$id_encuestador], 'onsubmit' => 'return verificar();']) !!}
        <section class="content-header">
            <h1 class="pull-left">Encuestas sin asignar</h1>
            <h1 class="pull-right">
            
                {!! Form::submit('Asignar encuestas', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-top: -10px;margin-bottom: 5px;']) !!}
                
            </h1>
        </section>
        <div class="content">
            <div class="clearfix"></div>
            <div class="clearfix"></div>
            <div class="box-header">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>{!! Form::checkbox('select_all', 0) !!} Identificacion</th>
                                <th>Nombre</th>
                                <th>Año de graduación</th>
                                <th>Sexo</th>
                                <th>Carrera</th>
                                <th>Universidad</th>
                                <th>Grado</th>
                                <th>Disciplina</th>
                                <th>Área</th>
                                <th>Tipo de caso</th>
                                <th>Detalles</th>
                            </thead>
                            <tbody>
                                @foreach($encuestasNoAsignadas as $entrevista)
                                    <tr>
                                        <td>{!! Form::checkbox('encuestas[]', $entrevista->id) !!} {!! $entrevista->identificacion_graduado !!}</td>
                                        <td>{!! $entrevista->nombre_completo !!}</td>
                                        <td>{!! $entrevista->annio_graduacion !!}</td>
                                        <td>{!! $entrevista->sexo !!}</td>
                                        <td>{!! $entrevista->carrera->nombre !!}</td>
                                        <td>{!! $entrevista->universidad->nombre !!}</td>
                                        <td>{!! $entrevista->grado->nombre !!}</td>
                                        <td>{!! $entrevista->disciplina->nombre !!}</td>
                                        <td>{!! $entrevista->area->nombre !!}</td>
                                        <td>{!! $entrevista->tipo_de_caso !!}</td>
                                        <td>
                                            <a href="#modal-ver-detalles-de-entrevista-{{$entrevista->id}}" data-toggle="modal">Ver detalles</a>
                                            @include('vistas-supervisor-2.modulo-encuestador.modal_ver_detalles_de_entrevista')
                                        </td>
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
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
        </script>
@endsection