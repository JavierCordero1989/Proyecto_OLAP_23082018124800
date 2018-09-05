@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-hover">
    <thead>
        <th>Código</th>
        <th>Nombre</th>
        <th>Opciones</th>
    </thead>
    <tbody>
    @foreach($grados as $grado)
        <tr>
            <td>{!! $grado->codigo !!}</td>
            <td>{!! $grado->nombre !!}</td>
            <td>
                {!! Form::open(['route' => ['grados.destroy', $grado->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('grados.show', [$grado->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('grados.edit', [$grado->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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