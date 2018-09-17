<div class="modal modal-default fade" id="modal-agregar-nueva-entrevista">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar nueva entrevista</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open(['route' => 'supervisor2.agregar-nuevo-caso-entrevista', 'onsubmit'=>'return validar_formulario();']) !!}

                        <!-- Número de cédula del graduado Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('identificacion_graduado', 'Identificación del graduado:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::text('identificacion_graduado', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Nombre completo Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('nombre_completo', 'Nombre completo:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::text('nombre_completo', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Token Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('token', 'Token:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::text('token', null, ['class' => 'form-control']) !!}
                        </div>
                        
                        <!-- Año de graduación Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('annio_graduacion', 'Año de graduación:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::number('annio_graduacion', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Link de la encuesta Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('link_encuesta', 'Link de la encuesta:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::text('link_encuesta', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Sexo Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('sexo', 'Sexo:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('sexo', ['M'=>'Masculino', 'F'=>'Femenino'], null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Carrera Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('codigo_carrera', 'Carrera:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('codigo_carrera', $datos_carreras['carreras'], null, ['class' => 'form-control', 'placeholder' => 'Elija una de la lista', 'required']) !!}
                        </div>

                        <!-- Universidad Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('codigo_universidad', 'Universidad:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('codigo_universidad', $datos_carreras['universidades'], null, ['class' => 'form-control', 'placeholder' => 'Elija una de la lista', 'required']) !!}
                        </div>

                        <!-- Grado Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('codigo_grado', 'Grado:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('codigo_grado', $datos_carreras['grados'], null, ['class' => 'form-control', 'placeholder' => 'Elija una de la lista', 'required']) !!}
                        </div>

                        <!-- Disciplina Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('codigo_disciplina', 'Disciplina:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('codigo_disciplina', $datos_carreras['disciplinas'], null, ['class' => 'form-control', 'placeholder' => 'Elija una de la lista', 'required']) !!}
                        </div>

                        <!-- Área Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('codigo_area', 'Área:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('codigo_area', $datos_carreras['areas'], null, ['class' => 'form-control', 'placeholder' => 'Elija una de la lista', 'required']) !!}
                        </div>

                        <!-- Agrupación Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('codigo_agrupacion', 'Agrupación:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('codigo_agrupacion', $datos_carreras['agrupaciones'], null, ['class' => 'form-control', 'placeholder' => 'Elija una de la lista', 'required']) !!}
                        </div>

                        <!-- Sector Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('codigo_sector', 'Sector:', ['class'=>'letra_pequennia']) !!}
                            {!! Form::select('codigo_sector', $datos_carreras['sectores'], null, ['class' => 'form-control', 'placeholder' => 'Elija una de la lista', 'required']) !!}
                        </div>

                        <!-- Tipo de caso Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::hidden('tipo_de_caso', 'Sustitucion', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Agregar contacto Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::hidden('agregar_contacto', 0, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <div class="col-xs-3 col-xs-offset-3">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary col-xs-12']) !!}
                            </div>
                            <div class="col-xs-3">
                                <button type="button" class="btn btn-default col-xs-12 pull-left" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>