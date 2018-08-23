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
            <th>Opciones</th>
        </thead>
        <tbody>
        @foreach($encuestas as $encuesta)
            <tr>
                <td>{!! $encuesta->identificacion_graduado !!}</td>
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
                <td>
                    {!! Form::open(['route' => ['permisos.destroy', $encuesta->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('permisos.show', [$encuesta->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('permisos.edit', [$encuesta->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button(
                            '<i class="glyphicon glyphicon-trash"></i>',
                            [
                                'type' => 'submit', 
                                'class' => 'btn btn-danger btn-xs', 
                                'onclick' => "return confirm('¿Está seguro?')"
                            ]
                        ) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- {!!$permisos->render()!!} --}}

@section('scripts')
    @include('layouts.datatables_js')
@endsection