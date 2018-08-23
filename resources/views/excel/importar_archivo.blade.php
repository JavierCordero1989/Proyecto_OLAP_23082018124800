<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('archivo_nuevo', 'Seleccione el archivo a importar:') !!}
    {!! Form::file('archivo_nuevo', ['class' => 'form-control', 'accept'=>'.xlsx,.xls', 'required']) !!}
    {{-- <input class="form-control" type="file" name="archivo_nuevo" id="archivo_nuevo" accept=".xlsx,.xls" required> --}}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! url('home') !!}" class="btn btn-default">Cancelar</a>
</div>