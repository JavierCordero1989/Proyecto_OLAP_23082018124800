<div class="col-xs-6 col-xs-offset-3">
    <!-- Codigo del usuario Field -->
    <div class="form-group">
        {!! Form::label('user_code', 'Código:') !!}
        {!! Form::text('user_code', null, ['class' => 'form-control', 'readonly'=>'readonly']) !!}
    </div>

    <!-- Nombre Field -->
    <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Email Field -->
    <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'readonly'=>'readonly']) !!}
    </div>

    <!-- Password Field -->
    <div class="form-group">
        {!! Form::label('password', 'Contraseña:') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('encuestadores.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>