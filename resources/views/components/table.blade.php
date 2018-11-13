<table class="table table-hover">
    <thead>
        @foreach ($encabezados as $titulo)
            <th>{!! $titulo !!}</th>
        @endforeach
    </thead>

    <tbody>
        {!! $cuerpo_tabla !!}
    </tbody>

</table>

{{-- {!! $paginacion !!} --}}