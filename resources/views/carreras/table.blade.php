@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-responsive" id="subeArchivos-table">
    <thead>
        <th>Código</th>
        <th>Nombre</th>
        <th>Opciones</th>
    </thead>
    <tbody>
    @foreach($carreras as $carrera)
        <tr>
            <td>{!! $carrera->codigo !!}</td>
            <td>{!! $carrera->nombre !!}</td>
            <td>
                {!! Form::open(['route' => ['carreras.destroy', $carrera->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('carreras.show', [$carrera->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('carreras.edit', [$carrera->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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

@section('scripts')
    @include('layouts.datatables_js')
@endsection