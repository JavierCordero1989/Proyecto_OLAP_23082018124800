@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-hover">
    <thead>
        <th>Código</th>
        <th>Nombre</th>
    </thead>
    <tbody>
    @foreach($grados as $grado)
        <tr>
            <td>{!! $grado->codigo !!}</td>
            <td>{!! $grado->nombre !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    @include('layouts.datatables_js')
@endsection