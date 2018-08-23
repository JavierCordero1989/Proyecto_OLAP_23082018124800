<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Identificacion Field -->
<div class="form-group col-sm-6">
    {{-- {!! Form::label('guard_name', 'Guard Name:') !!} --}}
    {{-- {!! Form::text('guard_name', null, ['class' => 'form-control']) !!} --}}
    {!! Form::hidden('guard_name', 'web') !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('permisos.index') !!}" class="btn btn-default">Cancelar</a>
</div>
