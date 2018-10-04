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
    @foreach($areas as $area)
        <tr>
            <td>{!! $area->codigo !!}</td>
            <td>{!! $area->descriptivo !!}</td>
            <td>
                {!! Form::open(['route' => ['areas.destroy', $area->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('areas.show', [$area->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('areas.edit', [$area->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
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