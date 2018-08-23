@if(isset($data) && count($data) > 0)
        @section('css')
            @include('layouts.datatables_css')
        @endsection
        <table class="table table-responsive">
            <thead>
                <tr>
                    @foreach($data[0] as $key => $val)
                        @if($key != 'obj' && $key != 'options')
                            <th>
                                {!! $key !!}
                            </th>
                        @endif
                    @endforeach
                    <th>
                        Opciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $element)
                <tr>
                    @foreach($element as $key => $value)
                        @if($key != 'obj' && $key != 'options')
                            <td>{!! $value['data'] !!}</td>
                        @endif
                    @endforeach
                    <td>
                        {!! Form::open(['route' => [$element['options']['delete'], $element['options']['id']], 'method' => 'delete']) !!}

                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    {{-- <i class="glyphicon glyphicon-eye-open"></i> --}}
                                    <i class="fas fa-cog"></i>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a href="{!! route($element['options']['show'], [$element['options']['id']]) !!}"><i class="fas fa-eye"></i> Ver</a>
                                    </li>
                                    <li>
                                        <a href="{!! route($element['options']['edit'], [$element['options']['id']]) !!}"><i class="fas fa-edit"></i> Modificar</a>
                                    </li>
                                    <li>
                                        <a href="#modalEliminar-{{$element['options']['id']}}" data-toggle="modal"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                    </li>
                                </ul>
                            </div>

                            @include('parts.modal_eliminar')

                        {!! @Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @section('scripts')
        @include('layouts.datatables_js')
    @endsection
@else
    <div class="card-panel">
        <div class="card-content text-muted text-center">
            <i class="fas fa-grin-beam-sweat fa-10x"></i>
            <br>
            <p class="fa-2x">
                No hay datos por mostrar
            </p>
        </div>
    </div>
@endif