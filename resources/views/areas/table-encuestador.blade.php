@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-hover">
    <thead>
        <th>Código</th>
        <th>Nombre</th>
    </thead>
    <tbody>
    @foreach($areas as $area)
        <tr>
            <td>{!! $area->codigo !!}</td>
            <td>{!! $area->descriptivo !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    @include('layouts.datatables_js')
@endsection