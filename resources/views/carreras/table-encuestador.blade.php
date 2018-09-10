@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-hover">
    <thead>
        <th>Código</th>
        <th>Nombre</th>
    </thead>
    <tbody>
    @foreach($carreras as $carrera)
        <tr>
            <td>{!! $carrera->codigo !!}</td>
            <td>{!! $carrera->nombre !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    @include('layouts.datatables_js')
@endsection