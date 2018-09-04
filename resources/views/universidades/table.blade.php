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
    @foreach($universidades as $universidad)
        <tr>
            <td>{!! $universidad->codigo !!}</td>
            <td>{!! $universidad->nombre !!}</td>
            <td>
                {!! Form::open(['route' => ['universidades.destroy', $universidad->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('universidades.show', [$universidad->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('universidades.edit', [$universidad->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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