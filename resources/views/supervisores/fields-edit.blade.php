<div class="col-xs-12 col-sm-6 col-sm-offset-3">
    <!-- Nombre Field -->
    <div class="form-group">
        {!! Form::label('user_code', 'Código de usuario:') !!}
        {!! Form::text('user_code', null, ['class' => 'form-control', 'required' => 'required', 'readonly'=>'readonly']) !!}
    </div>

    <!-- Nombre Field -->
    <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required', 'readonly'=>'readonly']) !!}
    </div>

    <!-- Password Field -->
    <div class="form-group">
        {!! Form::label('password', 'Contraseña:') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <!-- Supervisor Field -->
    @if(Auth::user()->hasRole('Super Admin'))
        <div class="form-group">
            {!! Form::label('role_name', 'Elija un rol:') !!}
            {!! Form::select('role_name', [''=>'Elija un rol', 'Supervisor 1'=>'Supervisor 1', 'Supervisor 2'=>'Supervisor 2'], null, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    @endif

    @if(Auth::user()->hasRole('Supervisor 1'))
        <div class="form-group">
            @if(Auth::user()->id == $supervisor->id)
                {!! Form::hidden('role_name', 'Supervisor 1') !!}
            @else 
                {!! Form::hidden('role_name', 'Supervisor 2') !!}
            @endif
        </div>
    @endif

    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('supervisores.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>