<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $area->id !!}</p>
</div>

<!-- Código Field -->
<div class="form-group">
    {!! Form::label('codigo', 'Código:') !!}
    <p>{!! $area->codigo !!}</p>
</div>

<!-- Nombre Field -->
<div class="form-group">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{!! $area->nombre !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creada el:') !!}
    <p>{!! $area->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Modificada el:') !!}
    <p>{!! $area->updated_at !!}</p>
</div>

