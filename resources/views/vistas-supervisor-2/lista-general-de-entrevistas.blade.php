@extends('layouts.app')

@section('title', 'Encuestadores') 

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
                        <th>ID</th>
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
                        <th>Info de contacto</th>
                        <th>Tipo de caso</th>
                    </thead>
                    <tbody>
                    @foreach($entrevistas as $encuesta)
                        <tr>
                            <td>{!! $encuesta->id !!}</td>
                            <td>{!! $encuesta->identificacion_graduado !!}</td>
                            <td>{!! $encuesta->token !!}</td>
                            <td>{!! $encuesta->nombre_completo !!}</td>
                            <td>{!! $encuesta->annio_graduacion !!}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEnlaceEncuesta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        {{-- <i class="glyphicon glyphicon-eye-open"></i> --}}
                                        <i class="fas fa-link"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownEnlaceEncuesta">
                                        <li>
                                            <a href="{!! $encuesta->link_encuesta !!}" target="_blank"><i class="fas fa-eye"></i> {!! $encuesta->link_encuesta !!} </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td>{!! $encuesta->sexo !!}</td>
                            <td>{!! $encuesta->Carrera !!}</td>
                            <td>{!! $encuesta->Universidad !!}</td>
                            <td>{!! $encuesta->Grado !!}</td>
                            <td>{!! $encuesta->Disciplina !!}</td>
                            <td>{!! $encuesta->Area !!}</td>
                            <td>
                                <!-- Dropdown menu para mostrar la informacion de contacto del usuario -->
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEnlacesInfoContacto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fas fa-address-card"></i>
                                        <span class="caret"></span>
                                    </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownEnlacesInfoContacto">
                                            <!-- Se agrega un boton por cada registro de contacto que tenga cada encuesta, mediante un foreach -->
                                            @foreach($encuesta->contactos as $contacto)
                                                <li>
                                                    <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->nombre_referencia !!}</a>
                                                </li>
                                            @endforeach
                                            <li><a href="{{ route('encuestas-graduados.agregar-contacto', [$encuesta->id]) }}">Agregar contacto</a></li>
                                        </ul>
            
                                        <!-- Se agregan los modales mediante un foreach -->
                                        @foreach($encuesta->contactos as $contacto) 
                                            @include('modals.modal_info_contacto')
                                        @endforeach
                                </div>
                            </td>
                            <td>{!! $encuesta->tipo_de_caso !!}</td>
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

        }
    </script>
@endsection
