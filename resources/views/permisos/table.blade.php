@section('css')
    @include('layouts.datatables_css')
@endsection

{{-- {!!$permisos->render()!!} --}}

<table class="table table-responsive">
    <thead>
        <th>Nombre</th>
        <th>Accion</th>
    </thead>
    <tbody>
    @foreach($permisos as $permiso)
        <tr>
            <td>{!! $permiso->name !!}</td>
            <td>
                {!! Form::open(['route' => ['permisos.destroy', $permiso->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('permisos.show', [$permiso->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('permisos.edit', [$permiso->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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

{{-- {!!$permisos->render()!!} --}}

@section('scripts')
    @include('layouts.datatables_js')
@endsection