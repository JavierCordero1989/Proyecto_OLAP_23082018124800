@extends('layouts.app')

@section('title', 'Encuestas sin asignar') 

@section('content')
    {!! Form::open(['route' => ['asignar-encuestas.crear-asignacion', 'id_supervisor'=>$id_supervisor,'id_encuestador'=>$id_encuestador], 'onsubmit' => 'return verificar();']) !!}
        <section class="content-header">
            <h1 class="pull-left">Encuestas sin asignar</h1>
            <h1 class="pull-right">
            
                {!! Form::submit('Asignar encuestas', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-top: -10px;margin-bottom: 5px;']) !!}
                {{-- <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('asignar-encuestas.crear-asignacion', [$id_supervisor, $id_encuestador]) !!}">Asignar</a> --}}
                
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
                                <th>Agrupación</th>
                                <th>Sector</th>
                                <th>Tipo de caso</th>
                            </thead>
                            <tbody>
                                @foreach($encuestasNoAsignadas as $encuesta)
                                    <tr>
                                        <td>
                                            {!! Form::checkbox('encuestas[]', $encuesta->id) !!}
                                            <a href="#modal-ver-detalles-de-entrevista-{{$encuesta->id}}" data-toggle="modal">{!! $encuesta->identificacion_graduado !!}</a> 
                                            @include('modals.modal_ver_detalles_de_entrevista')
                                        </td>
                                        <td>{!! $encuesta->nombre_completo !!}</td>
                                        <td>{!! $encuesta->annio_graduacion !!}</td>
                                        <td>{!! $encuesta->sexo == 'M' ? 'Hombre' : ($encuesta->sexo == 'F' ? 'Mujer' : 'ND') !!}</td>
                                        <td>{!! $encuesta->carrera->nombre !!}</td>
                                        <td>{!! $encuesta->universidad->nombre !!}</td>
                                        <td>{!! $encuesta->grado->nombre !!}</td>
                                        <td>{!! $encuesta->disciplina->descriptivo !!}</td>
                                        <td>{!! $encuesta->area->descriptivo !!}</td>
                                        <td>{!! $encuesta->agrupacion->nombre !!}</td>
                                        <td>{!! $encuesta->sector->nombre !!}</td>
                                        <td>{!! $encuesta->tipo_de_caso !!}</td>
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

                // console.log(suma);

                if(suma == 0){
                    alert('Debe seleccionar al menos una encuesta');
                    return false;
                }
            }

            $('[name=select_all]').click(function() {
                var checks = document.getElementsByName('encuestas[]');

                if($('[name=select_all]').get(0).checked) {
                    // console.log('Entra al if');
                    for(indice=0, j = checks.length; indice<j; indice++) {
                        checks[indice].checked = true;
                    }
                }
                else {
                    // console.log('Entra al else');
                    for(indice=0, j = checks.length; indice<j; indice++) {
                        checks[indice].checked = false;
                    }
                }
            });
        </script>
@endsection