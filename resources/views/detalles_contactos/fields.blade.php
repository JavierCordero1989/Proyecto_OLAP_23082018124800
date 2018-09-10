<!-- Contacto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contacto', 'Contacto:') !!}
    {!! Form::text('contacto', null, ['class' => 'form-control']) !!}
</div>

<!-- Identificacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observación:') !!}
    {!! Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => 2, 'cols' => 40]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('encuestadores.lista-de-encuestas', Auth::user()->id) !!}" class="btn btn-default">Cancelar</a>
</div>
