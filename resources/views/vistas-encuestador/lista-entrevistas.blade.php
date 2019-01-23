@extends('layouts.app')

@section('title', 'Otras carreras')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                @php
                    $entrevista = $encuestas[0];
                @endphp

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <p>Cedula: <u>{!! $entrevista->identificacion_graduado !!}</u></p>
                        </h3>
                        <br>
                        <h3 class="box-title">
                            <p>Nombre: <u>{!! $entrevista->nombre_completo !!}</u></p>
                        </h3>
                        <br>
                        <h3 class="box-title">
                            <p>Sexo: <u>{!! $entrevista->sexo == 'F' ? 'MUJER' : ($entrevista->sexo == 'M' ? 'HOMBRE' : 'SIN CLASIFICAR') !!}</u></p>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>Año de graduación</th>
                                    <th>Carrera</th>
                                    <th>Universidad</th>
                                    <th>Grado</th>
                                    <th>Área</th>
                                    <th>Disciplina</th>
                                </thead>
                                <tbody>
                                    @foreach ($encuestas as $encuesta)
                                        <tr>
                                            <td>{!! $encuesta->annio_graduacion !!}</td>
                                            <td>{!! $encuesta->carrera->nombre !!}</td>
                                            <td>{!! $encuesta->universidad->nombre !!}</td>
                                            <td>{!! $encuesta->grado->nombre !!}</td>
                                            <td>{!! $encuesta->area->descriptivo !!}</td>
                                            <td>{!! $encuesta->disciplina->descriptivo !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection