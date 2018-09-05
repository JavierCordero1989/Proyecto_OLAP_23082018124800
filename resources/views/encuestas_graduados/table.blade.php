@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-hover">
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
        {{-- <th>Opciones</th> --}}
    </thead>
    <tbody>
    @foreach($encuestas as $encuesta)
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
            <td>{!! $encuesta->sexo !!}</td>
            <td>{!! $encuesta->Carrera !!}</td>
            <td>{!! $encuesta->Universidad !!}</td>
            <td>{!! $encuesta->Grado !!}</td>
            <td>{!! $encuesta->Disciplina !!}</td>
            <td>{!! $encuesta->Area !!}</td>
            <td>
                {{-- <!-- Se valida que haya registros de contacto -->
                @if(sizeof($encuesta->contactos) <= 0)
                    <a href="#" data-toggle="modal">Agregar contacto</a>
                @else --}}
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
                {{-- @endif --}}
            </td>
            <td>{!! $encuesta->tipo_de_caso !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    @include('layouts.datatables_js')
@endsection