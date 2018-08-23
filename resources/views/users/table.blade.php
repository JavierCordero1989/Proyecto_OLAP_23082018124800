@section('css')
    @include('layouts.datatables_css')
@endsection

<table class="table table-responsive" id="subeArchivos-table">
    <thead>
        <th>Nombre</th>
        <th>Email</th>
        <th>Accion</th>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{!! $user->name !!}</td>
            <td>{!! $user->email !!}</td>
            <td>
                {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete', 'id'=>'form_eliminar_'.$user->id]) !!}
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Acciones
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="{!! route('users.edit_name', [$user->id]) !!}">Cambiar nombre</a></li>
                        <li><a href="{!! route('users.edit_password', [$user->id]) !!}">Cambiar contraseña</a></li>
                        <li><a href="#">Desactivar</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#modalEliminar-{{$user->id}}" data-toggle="modal">Eliminar</a></li>
                    </ul>
                </div>

                <!-- Se incluye el modal en el form, que fue creado en una vista aparte. -->
                @include('users.modal_eliminar')

                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@section('scripts')
    @include('layouts.datatables_js')
    {{-- <script>
        function eliminar(id) {
            var idForm = "form_eliminar_"+id;
            var form = document.getElementById(idForm);

            if(confirm('¿Está seguro?')) {
                form.submit();
            }
            console.log(form);
        }
    </script> --}}
@endsection