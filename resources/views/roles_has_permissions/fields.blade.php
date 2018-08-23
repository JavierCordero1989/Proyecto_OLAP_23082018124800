<!-- Roles Disponibles Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rol_name', 'Roles disponibles:') !!}
    {!! Form::select('rol_name', $roles, null, ['class' => 'form-control', 'placeholder'=>'Elija un rol', 'required']) !!}
</div>

<!-- Permisos Field -->
<div class="form-group col-sm-12">
    {!! Form::label('permission_list', 'Lista de permisos:') !!} <br>
    @foreach($permissions as $permission)
        {!! Form::checkbox('permissions[]', $permission->id) !!} {!! $permission->name !!} <br>
    @endforeach
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! url('/home') !!}" class="btn btn-default">Cancelar</a>
</div>
