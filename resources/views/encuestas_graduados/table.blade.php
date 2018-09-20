{{-- @section('css')
    @include('layouts.datatables_css')
@endsection --}}

<table class="table table-hover">
    <thead>
        <th>Identificacion</th>
        <th>Nombre</th>
        <th>Sexo</th>
        <th>Carrera</th>
        <th>Universidad</th>
        <th>Grado</th>
        <th>Disciplina</th>
        <th>Área</th>
        <th>Agrupación</th>
        <th>Sector</th>
        <th>Tipo de caso</th>
        {{-- <th>Opciones</th> --}}
    </thead>
    <tbody>
    @foreach($encuestas as $encuesta)
        <tr>
            <td>
                <a href="#modal-ver-detalles-de-entrevista-{{$encuesta->id}}" data-toggle="modal">{!! $encuesta->identificacion_graduado !!}</a>
                @include('modals.modal_ver_detalles_de_entrevista')
            </td>
            <td>{!! $encuesta->nombre_completo !!}</td>
            <td>{!! $encuesta->sexo !!}</td>
            <td>{!! $encuesta->carrera->nombre !!}</td>
            <td>{!! $encuesta->universidad->nombre !!}</td>
            <td>{!! $encuesta->grado->nombre !!}</td>
            <td>{!! $encuesta->disciplina->nombre !!}</td>
            <td>{!! $encuesta->area->nombre !!}</td>
            <td>{!! $encuesta->agrupacion->nombre !!}</td>
            <td>{!! $encuesta->sector->nombre !!}</td>
            <td>{!! $encuesta->tipo_de_caso !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{!! $encuestas->render() !!}
{{-- @section('scripts')
    @include('layouts.datatables_js')
@endsection --}}