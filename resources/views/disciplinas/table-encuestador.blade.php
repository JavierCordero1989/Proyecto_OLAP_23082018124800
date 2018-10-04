@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-hover">
    <thead>
        <th>Código</th>
        <th>Nombre</th>
    </thead>
    <tbody>
    @foreach($disciplinas as $disciplina)
        <tr>
            <td>{!! $disciplina->codigo !!}</td>
            <td>{!! $disciplina->descriptivo !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    @include('layouts.datatables_js')
@endsection