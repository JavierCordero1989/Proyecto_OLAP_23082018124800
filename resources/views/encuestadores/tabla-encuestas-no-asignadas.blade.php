@extends('layouts.app')

@section('title', 'Encuestas sin asignar') 

@section('content')
    {!! Form::open(['route' => ['asignar-encuestas.crear-asignacion', 'id_supervisor'=>$id_supervisor,'id_encuestador'=>$id_encuestador]]) !!}
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

                    @section('css')
                        @include('layouts.datatables_css')
                    @endsection

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>Identificacion</th>
                                <th>Token</th>
                                <th>Nombre</th>
                                <th>Año de graduación</th>
                                <th>Link para encuesta</th>
                                <th>Sexo</th>
                                <th>Carrera</th>
                                <th>Universidad</th>
                                <th>Grado</th>
                                <th>Disciplina</th>
                                <th>Área</th>
                                <th>Tipo de caso</th>
                            </thead>
                            <tbody>
                            @foreach($encuestasNoAsignadas as $encuesta)
                                <tr>
                                    <td>{!! Form::checkbox('encuestas[]', $encuesta->id) !!} {!! $encuesta->identificacion_graduado !!}</td>
                                    <td>{!! $encuesta->token !!}</td>
                                    <td>{!! $encuesta->nombre_completo !!}</td>
                                    <td>{!! $encuesta->annio_graduacion !!}</td>
                                    <td>{!! $encuesta->link_encuesta !!}</td>
                                    <td>{!! $encuesta->sexo !!}</td>
                                    <td>{!! $encuesta->carrera !!}</td>
                                    <td>{!! $encuesta->universidad !!}</td>
                                    <td>{!! $encuesta->Grado !!}</td>
                                    <td>{!! $encuesta->Disciplina !!}</td>
                                    <td>{!! $encuesta->Area !!}</td>
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
    @include('layouts.datatables_js')
@endsection