@extends('layouts.app')

@section('title', 'Encuestas asignadas') 

@section('content')
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
        <section class="content-header">
            <h1 class="pull-left">Encuestas asignadas</h1>
            <h1 class="pull-right">
            
                {{-- <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('asignar-encuestas.crear-asignacion', [$id_supervisor, $id_encuestador]) !!}">Asignar</a> --}}
                
            </h1>
        </section>
        <div class="content">
            <div class="clearfix"></div>
            @include('flash::message')
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
                                <th>Info de contacto</th>
                                <th>Tipo de caso</th>
                                <th>Observaciones</th>
                            </thead>
                            <tbody>
                            @foreach($listaDeEncuestas as $encuesta)
                                <tr>
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
                                    <td>{!! $encuesta->sexo == 'M' ? 'Hombre' : ($encuesta->sexo == 'F' ? 'Mujer' : 'ND') !!}</td>
                                    <td>{!! $encuesta->carrera->nombre !!}</td>
                                    <td>{!! $encuesta->universidad->nombre !!}</td>
                                    <td>{!! $encuesta->grado->nombre !!}</td>
                                    <td>{!! $encuesta->disciplina->nombre !!}</td>
                                    <td>{!! $encuesta->area->nombre !!}</td>
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
                                                            @if ($contacto->nombre_referencia != "")
                                                                <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->nombre_referencia !!}</a>
                                                            @else
                                                                <a href="#modal-{!! $contacto->id !!}" data-toggle="modal" ><i class="fas fa-eye"></i>{!! $contacto->parentezco !!}</a>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                    <li><a href="{!! route('encuestadores.agregar-contacto', $encuesta->id ) !!}">Agregar contacto</a></li>
                                                </ul>
                
                                                <!-- Se agregan los modales mediante un foreach -->
                                                @foreach($encuesta->contactos as $contacto) 
                                                    @include('modals.modal_info_contacto')
                                                @endforeach
                                        </div>
                                    </td>
                                    <td>{!! $encuesta->tipo_de_caso !!}</td>
                                    <td><a href="#', $encuesta->id) !!}">{!! $encuesta->estado() !!}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @include('layouts.datatables_js')
@endsection