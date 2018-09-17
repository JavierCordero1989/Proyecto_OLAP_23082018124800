@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Nueva información de contacto
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['supervisor2.guardar-detalle-contacto', 'id_contacto' => $id_contacto, 'id_entrevista' => $id_entrevista]]) !!}

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
                            <a href="{!! route('supervisor2.realizar-entrevista', $id_entrevista) !!}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
