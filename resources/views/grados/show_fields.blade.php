<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $grado->id !!}</p>
</div>

<!-- Código Field -->
<div class="form-group">
    {!! Form::label('codigo', 'Código:') !!}
    <p>{!! $grado->codigo !!}</p>
</div>

<!-- Nombre Field -->
<div class="form-group">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{!! $grado->nombre !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creada el:') !!}
    <p>{!! $grado->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Modificada el:') !!}
    <p>{!! $grado->updated_at !!}</p>
</div>

