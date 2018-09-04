<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $carrera->id !!}</p>
</div>

<!-- Código Field -->
<div class="form-group">
    {!! Form::label('codigo', 'Código:') !!}
    <p>{!! $carrera->codigo !!}</p>
</div>

<!-- Nombre Field -->
<div class="form-group">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{!! $carrera->nombre !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creada el:') !!}
    <p>{!! $carrera->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Modificada el:') !!}
    <p>{!! $carrera->updated_at !!}</p>
</div>

