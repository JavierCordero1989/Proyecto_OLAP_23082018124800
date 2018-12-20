{{-- @section('css')
    @include('layouts.datatables_css')
@endsection --}}
@if (sizeof($encuestas) > 0)
    
    @component('components.table')
        @slot('encabezados', ['Identificación', 'Nombre', 'Sexo', 'Carrera', 'Universidad', 'Grado', 'Área', 'Disciplina', 'Tipo de caso', 'Asignado a', 'Asignado por', 'Estado', 'Fecha del estado', 'Opciones'])
        
        @slot('cuerpo_tabla')
            @foreach($encuestas as $encuesta)
                <tr>
                    <td>
                        <a href="#modal-ver-detalles-de-entrevista-{{$encuesta->id}}" data-toggle="modal">{!! $encuesta->identificacion_graduado !!}</a>
                        @include('modals.modal_ver_detalles_de_entrevista')
                    </td>
                    <td>{!! $encuesta->nombre_completo !!}</td>
                    <td>{!! $encuesta->sexo == 'M' ? 'Hombre' : ($encuesta->sexo == 'F' ? 'Mujer' : 'Sin Clasificar') !!}</td>
                    <td>{!! $encuesta->carrera->nombre !!}</td>
                    <td>{!! $encuesta->universidad->nombre !!}</td>
                    <td>{!! $encuesta->grado->nombre !!}</td>
                    <td>{!! $encuesta->area->descriptivo !!}</td>
                    <td>{!! $encuesta->disciplina->descriptivo !!}</td>
                    {{-- <td>{!! $encuesta->agrupacion->nombre !!}</td> --}}
                    {{-- <td>{!! $encuesta->sector->nombre !!}</td> --}}
                    <td>{!! $encuesta->tipo_de_caso !!}</td>
                    <td>{!! $encuesta->encuestadorAsignado() !!}</td>
                    <td>{!! $encuesta->supervisorAsignado() !!}</td>
                    <td>{!! $encuesta->estado()->estado !!}</td>
                    <td>{!! is_null($encuesta->asignacion->updated_at) ? 'Sin Fecha' : $encuesta->asignacion->updated_at->format('d/m/Y') !!}</td>
                    <td>
                        @if (Auth::user()->hasRole('Super Admin'))
                            {!! Form::open(['route' => ['encuestas-graduados.destroy', $encuesta->id], 'method' => 'delete']) !!}
                        @endif
                            <div class="btn-group-vertical">
                                @if (Auth::user()->hasRole('Super Admin'))
                                    <button class="btn btn-danger btn-xs" type="submit" v-on:click="eventoEliminar" data-toggle="tooltip" title="Eliminar encuesta" data-placement="left"><i class="glyphicon glyphicon-trash"></i></button>
                                    
                                    <a href="{!! route('encuestas-graduados.edit', $encuesta->id) !!}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar datos" data-placement="left">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                
                                @if ($encuesta->contactos->count() <= 0)
                                    <a href="{!! route('encuestas-graduados.agregar-contacto', $encuesta->id) !!}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Agregar contacto" data-placement="left">
                                        {{-- <i class="fas fa-phone-square"></i> --}}
                                        <i class="far fa-user"></i>
                                    </a>
                                @endif

                            </div>
                            <div class="btn-group-vertical">
                                @if ($encuesta->tipo_de_caso != "REEMPLAZADA") 
                                    <a href="{!! route('encuestas-graduados.cambiar-estado-entrevista', $encuesta->id) !!}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Cambiar estado" data-placement="left"><i class="fas fa-exchange-alt"></i></a>
                                    
                                    @if ($encuesta->estado()->estado == "NO ASIGNADA")
                                        <a href="{!! route('encuestas-graduados.asignar-entrevista-get', $encuesta->id) !!}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Asignar encuesta" data-placement="left"><i class="fas fa-hand-point-right"></i></a>
                                    @endif
                                    
                                    @if ($encuesta->contactos->count() > 0)
                                        <a href="{!! route('encuestas-graduados.administrar-contactos-get', $encuesta->id) !!}" class="btn btn-info btn-xs" data-toggle="tooltip" title="Administrar contactos" data-placement="left"><i class="fas fa-phone-square"></i></a>
                                    @endif
                                @endif
                            </div>
                        @if (Auth::user()->hasRole('Super Admin'))
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
        @endslot

        @slot('paginacion', $encuestas->appends(Request::all())->render())
    @endcomponent

@else
    <!-- cuadro que aparece cuando no hay resultados de busqueda -->
    <div class="clearfix"></div>
    <div class="card-panel">
        <div class="card-content text-muted text-center">
            <i class="fas fa-grin-beam-sweat fa-10x"></i>
            <br>
            <p class="fa-2x">
                No hay resultados para su búsqueda
            </p>
        </div>
    </div>
    <div class="clearfix"></div>
@endif

@include('components.error-message')