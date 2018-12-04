@extends('layouts.app')

@section('title', 'Encuestas sin asignar') 

@section('content')
    {!! Form::open(['route' => ['supervisor2.crear-nueva-asignacion-a-supervisor', 'id_supervisor'=>$id_supervisor,'id_supervisor_asignado'=>$id_supervisor_asignado], 'onsubmit' => 'return verificar();']) !!}
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
                                @foreach($encuestasNoAsignadas as $entrevista)
                                    <tr>
                                        <td>
                                            {!! Form::checkbox('encuestas[]', $entrevista->id) !!} 
                                            <a href="#modal-ver-detalles-de-entrevista-{{$entrevista->id}}" data-toggle="modal">{!! $entrevista->identificacion_graduado !!}</a>
                                            @include('vistas-supervisor-2.modulo-supervisor.modal_ver_detalles_de_entrevista')
                                        </td>
                                        <td>{!! $entrevista->nombre_completo !!}</td>
                                        <td>{!! $entrevista->annio_graduacion !!}</td>
                                        <td>{!! $entrevista->carrera->nombre !!}</td>
                                        <td>{!! $entrevista->universidad->nombre !!}</td>
                                        <td>{!! $entrevista->grado->nombre !!}</td>
                                        <td>{!! $entrevista->disciplina->descriptivo !!}</td>
                                        <td>{!! $entrevista->area->descriptivo !!}</td>
                                        <td>{!! $entrevista->agrupacion->nombre !!}</td>
                                        <td>{!! $entrevista->sector->nombre !!}</td>
                                        <td>{!! $entrevista->tipo_de_caso !!}</td>
                                        
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