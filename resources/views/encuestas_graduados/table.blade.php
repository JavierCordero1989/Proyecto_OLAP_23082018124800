{{-- @section('css')
    @include('layouts.datatables_css')
@endsection --}}

@component('components.table')
    @slot('encabezados', ['Identificación', 'Nombre', 'Sexo', 'Carrera', 'Universidad', 'Grado', 'Disciplina', 'Área', 'Agrupación', 'Sector', 'Tipo de caso'])
    
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
                <td>{!! $encuesta->agrupacion->nombre !!}</td>
                <td>{!! $encuesta->sector->nombre !!}</td>
                <td>{!! $encuesta->tipo_de_caso !!}</td>
            </tr>
        @endforeach
    @endslot

    @slot('paginacion', $encuestas->render())
@endcomponent

{{-- @section('scripts')
    @include('layouts.datatables_js')
@endsection --}}