<!-- Roles Disponibles Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Usuarios disponibles:') !!}
    {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'placeholder'=>'Elija un usuario', 'required']) !!}
</div>

<!-- Roles Field -->
<div class="form-group col-sm-12">
    {!! Form::label('roles_list', 'Lista de roles:') !!} <br>
    @foreach($roles as $rol)
        {!! Form::checkbox('roles[]', $rol->id) !!} {!! $rol->name !!} <br>
    @endforeach
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! url('/home') !!}" class="btn btn-default">Cancelar</a>
</div>
