@extends('layouts.app')

@section('title', 'Encuestas sin asignar') 

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

        {!! Form::open(['route' => ['supervisor2.remover-encuestas-a-encuestador', $id_encuestador], 'onsubmit' => 'return verificar();']) !!}
            <section class="content-header">
                <h1 class="pull-left">Encuestas asignadas</h1>
                <h1 class="pull-right">
                
                    {!! Form::submit('Quitar encuestas', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-top: -10px;margin-bottom: 5px;']) !!}
                    {{-- <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('asignar-encuestas.crear-asignacion', [$id_supervisor, $id_encuestador]) !!}">Asignar</a> --}}
                    
                </h1>
            </section>
            <div class="content">
                <div class="clearfix"></div>
                @include('flash::message')
                <div class="clearfix"></div>
                <div class="box-header">
                    <div class="box-body">

                        {{-- @section('css')
                            @include('layouts.datatables_css')
                        @endsection --}}

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>{!! Form::checkbox('select_all', 0) !!}  Identificacion</th>
                                    {{-- <th>Token</th> --}}
                                    <th>Nombre</th>
                                    <th>Año de graduación</th>
                                    {{-- <th>Link para encuesta</th> --}}
                                    <th>Sexo</th>
                                    <th>Carrera</th>
                                    <th>Universidad</th>
                                    <th>Grado</th>
                                    <th>Disciplina</th>
                                    <th>Área</th>
                                    {{-- <th>Info de contacto</th> --}}
                                    <th>Tipo de caso</th>
                                </thead>
                                <tbody>
                                @foreach($listaDeEncuestas as $encuesta)
                                    <tr>
                                        <td>{!! Form::checkbox('encuestas[]', $encuesta->id) !!} {!! $encuesta->identificacion_graduado !!}</td>
                                        {{-- <td>{!! $encuesta->token !!}</td> --}}
                                        <td>{!! $encuesta->nombre_completo !!}</td>
                                        <td>{!! $encuesta->annio_graduacion !!}</td>
                                        {{-- <td>
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEnlaceEncuesta" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="fas fa-link"></i>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownEnlaceEncuesta">
                                                    <li>
                                                        <a href="{!! $encuesta->link_encuesta !!}" target="_blank"><i class="fas fa-eye"></i> {!! $encuesta->link_encuesta !!} </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td> --}}
                                        <td>{!! $encuesta->sexo !!}</td>
                                        <td>{!! $encuesta->carrera->nombre !!}</td>
                                        <td>{!! $encuesta->universidad->nombre !!}</td>
                                        <td>{!! $encuesta->grado->nombre !!}</td>
                                        <td>{!! $encuesta->disciplina->nombre !!}</td>
                                        <td>{!! $encuesta->area->nombre !!}</td>
                                        {{-- <td>
                                            <!-- Se valida que haya registros de contacto -->
                                            @if(sizeof($encuesta->contactos) <= 0)
                                                <a href="#" data-toggle="modal">Agregar</a>
                                            @else
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
                                                            <li><a href="#">Agregar contacto</a></li>
                                                        </ul>
                        
                                                        <!-- Se agregan los modales mediante un foreach -->
                                                        @foreach($encuesta->contactos as $contacto) 
                                                            @include('modals.modal_info_contacto')
                                                        @endforeach
                                                </div>
                                            @endif
                                        </td> --}}
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

    @endif
@endsection

@section('scripts')
    {{-- @include('layouts.datatables_js') --}}

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