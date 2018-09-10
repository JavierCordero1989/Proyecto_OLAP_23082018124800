@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-hover">
    <thead>
        <th>Código</th>
        <th>Nombre</th>
    </thead>
    <tbody>
    @foreach($universidades as $universidad)
        <tr>
            <td>{!! $universidad->codigo !!}</td>
            <td>{!! $universidad->nombre !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    @include('layouts.datatables_js')
@endsection