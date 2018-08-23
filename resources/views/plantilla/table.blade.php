@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-responsive" id="subeArchivos-table">
    <thead>
        <th>Nombre</th>
        <th>Accion</th>
    </thead>
    <tbody>
    @foreach($roles as $rol)
        <tr>
            <td>{!! $rol->name !!}</td>
            <td>
                {!! Form::open(['route' => ['roles.destroy', $rol->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('roles.show', [$rol->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('roles.edit', [$rol->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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