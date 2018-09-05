<!-- Código Field -->
<div class="form-group col-sm-6 col-sm-offset-3">
    {!! Form::label('codigo', 'Código:') !!}
    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
</div>

<!-- Nombre Field -->
<div class="form-group col-sm-6 col-sm-offset-3">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-6 col-sm-offset-3">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary col-sm-4']) !!}
    <a href="{!! route('grados.index') !!}" class="btn btn-default col-sm-4 col-sm-offset-4">Cancelar</a>
</div>
