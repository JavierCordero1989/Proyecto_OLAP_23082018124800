<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $universidad->id !!}</p>
</div>

<!-- Código Field -->
<div class="form-group">
    {!! Form::label('codigo', 'Código:') !!}
    <p>{!! $universidad->codigo !!}</p>
</div>

<!-- Nombre Field -->
<div class="form-group">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{!! $universidad->nombre !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creada el:') !!}
    <p>{!! $universidad->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Modificada el:') !!}
    <p>{!! $universidad->updated_at !!}</p>
</div>

