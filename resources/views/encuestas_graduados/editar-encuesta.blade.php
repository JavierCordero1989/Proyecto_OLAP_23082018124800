@extends('layouts.app')

@section('title', 'Editar datos de encuesta')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($encuesta, ['route' => ['encuestas-graduados.update', $encuesta->id], 'method' => 'patch', 'class'=>'form-horizontal']) !!}

                        <div class='form-group'>
                            {!! Form::label('identificacion_graduado', 'Identificación graduado: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-credit-card'></i></span>
                                    {!! Form::text('identificacion_graduado', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('token', 'Token: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-barcode'></i></span>
                                    {!! Form::text('token', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('nombre_completo', 'Nombre completo: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                                    {!! Form::text('nombre_completo', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('annio_graduacion', 'Año de graduación:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span>
                                    {!! Form::text('annio_graduacion', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('link_encuesta', 'Vínculo a la encuesta: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-link'></i></span>
                                    {!! Form::text('link_encuesta', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('sexo', 'Sexo:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-transgender'></i></span>
                                    {!! Form::select('sexo', $datos_academicos['sexo'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('sexo', $sexo, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('codigo_carrera', 'Carrera:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-university'></i></span>
                                    {!! Form::select('codigo_carrera', $datos_academicos['carreras'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('codigo_carrera', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('codigo_universidad', 'Universidad:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-university'></i></span>
                                    {!! Form::select('codigo_universidad', $datos_academicos['universidades'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('codigo_universidad', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('codigo_grado', 'Grado:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-university'></i></span>
                                    {!! Form::select('codigo_grado', $datos_academicos['grados'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('codigo_grado', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('codigo_area', 'Area:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-university'></i></span>
                                    {{-- {!! Form::text('codigo_area', null, ['class'=>'form-control']) !!} --}}
                                    {!! Form::select('codigo_area',  $datos_academicos['areas'], null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('codigo_disciplina', 'Disciplina: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-university'></i></span>
                                    {!! Form::select('codigo_disciplina',  $datos_academicos['disciplinas'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('codigo_disciplina', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('codigo_agrupacion', 'Agrupación: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-university'></i></span>
                                    {!! Form::select('codigo_agrupacion',  $datos_academicos['agrupaciones'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('codigo_agrupacion', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('codigo_sector', 'Sector:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-university'></i></span>
                                    {!! Form::select('codigo_sector',  $datos_academicos['sectores'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('codigo_sector', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            {!! Form::label('tipo_de_caso', 'Tipo de caso:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='ion ion-ios-keypad'></i></span>
                                    {!! Form::select('tipo_de_caso',  $datos_academicos['tipos'], null, ['class'=>'form-control']) !!}
                                    {{-- {!! Form::text('tipo_de_caso', null, ['class'=>'form-control']) !!} --}}
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label class='control-label col-md-4'></label>
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
                                    <a href="{!! route('encuestas-graduados.index') !!}" class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection