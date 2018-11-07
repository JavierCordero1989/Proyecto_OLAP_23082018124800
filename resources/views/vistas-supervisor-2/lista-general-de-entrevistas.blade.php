@extends('layouts.app')

@section('title', 'Encuestadores') 

@section('css')
    <style>
        .letra_pequennia {
            font-size: 15px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Lista de encuestas</h1>
        <h1 class="pull-right">
            <!-- Boton para ver los datos del encuestador -->
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="#modal-agregar-nueva-entrevista" data-toggle="modal" title="Puedes agregar un nuevo caso de entrevista"><i class="fas fa-plus"></i> Nueva entrevista</a>
            @include('vistas-supervisor-2.modal_agregar_nueva_entrevista')
           {{-- <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('encuestas-graduados.create') !!}">Agregar nueva</a> --}}
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box-header">
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>Identificacion</th>
                        <th>Nombre</th>
                        <th>Sexo</th>
                        {{-- <th>Año de graduación</th> --}}
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
                    @foreach($entrevistas as $entrevista)
                        <tr>
                            <td>
                                <a href="#modal-ver-detalles-de-entrevista-{{$entrevista->id}}" data-toggle="modal">{!! $entrevista->identificacion_graduado !!}</a>
                                @include('vistas-supervisor-2.modal_ver_detalles_de_entrevista')
                            </td>
                            <td>{!! $entrevista->nombre_completo !!}</td>
                            <td>{!! $entrevista->sexo == 'M' ? 'Hombre' : ($entrevista->sexo == 'F' ? 'Mujer' : 'ND') !!}</td>
                            {{-- <td>{!! $entrevista->annio_graduacion !!}</td> --}}
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
                {!! $entrevistas->render() !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function validar_formulario() {
            var identificacion_graduado = $('#identificacion_graduado').val();
            var nombre_completo         = $('#nombre_completo').val();
            var annio_graduacion        = $('#token').val();
            var token                   = $('#annio_graduacion').val();
            var link_encuesta           = $('#link_encuesta').val();
            var sexo                    = $('#sexo').val();

            if(identificacion_graduado=="" || nombre_completo==""  || annio_graduacion=="" || token=="" || link_encuesta=="" || sexo=="" ) {
                alert('Todos los campos deben estar completos');
                return false
            }
            else {
                var agregar_contacto = confirm('¿Desea agregar un contacto a la entrevista?');
                if(agregar_contacto) {
                    $('[name=agregar_contacto]').val(1);
                }

                return true;
            }
        }
    </script>
@endsection
