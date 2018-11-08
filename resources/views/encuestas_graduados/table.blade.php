{{-- @section('css')
    @include('layouts.datatables_css')
@endsection --}}

@component('components.table')
    @slot('encabezados', ['Identificación', 'Nombre', 'Sexo', 'Carrera', 'Universidad', 'Grado', 'Disciplina', 'Área', 'Tipo de caso', 'Acciones'])
    
    @slot('cuerpo_tabla')
        @foreach($encuestas as $encuesta)
            <tr>
                <td>
                    <a href="#modal-ver-detalles-de-entrevista-{{$encuesta->id}}" data-toggle="modal">{!! $encuesta->identificacion_graduado !!}</a>
                    @include('modals.modal_ver_detalles_de_entrevista')
                </td>
                <td>{!! $encuesta->nombre_completo !!}</td>
                <td>{!! $encuesta->sexo == 'M' ? 'Hombre' : ($encuesta->sexo == 'F' ? 'Mujer' : 'ND') !!}</td>
                <td>{!! $encuesta->carrera->nombre !!}</td>
                <td>{!! $encuesta->universidad->nombre !!}</td>
                <td>{!! $encuesta->grado->nombre !!}</td>
                <td>{!! $encuesta->disciplina->descriptivo !!}</td>
                <td>{!! $encuesta->area->descriptivo !!}</td>
                {{-- <td>{!! $encuesta->agrupacion->nombre !!}</td> --}}
                {{-- <td>{!! $encuesta->sector->nombre !!}</td> --}}
                <td>{!! $encuesta->tipo_de_caso !!}</td>
                <td>
                    {!! Form::open(['route' => ['encuestas-graduados.destroy', $encuesta->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            {!! Form::button(
                                '<i class="glyphicon glyphicon-trash"></i>',
                                [
                                    'type' => 'submit', 
                                    'class' => 'btn btn-danger btn-xs'
                                ]
                            ) !!}
                            <a href="{!! route('encuestas-graduados.agregar-contacto', $encuesta->id) !!}" class="btn btn-default btn-xs">
                                {{-- <i class="fas fa-phone-square"></i> --}}
                                <i class="far fa-user"></i>
                            </a>
                        </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    @endslot

    @slot('paginacion', $encuestas->render())
@endcomponent

@include('components.error-message')

@section('scripts')
    {{-- @include('layouts.datatables_js') --}}
    <script>
        $('.btn-danger').on('click', function(event) {

            if(!confirm('¿Desea eliminar el registro de todas formas?')) {
                event.preventDefault();
            }
        });
    </script>
@endsection