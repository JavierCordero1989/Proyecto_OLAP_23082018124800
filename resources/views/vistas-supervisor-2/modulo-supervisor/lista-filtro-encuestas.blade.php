@extends('layouts.app')

@section('title', 'Búsqueda') 

@section('content')
    <section class="content-header">
        <h1>
            Ingrese los filtros que desea para la muestra
        </h1>
    </section>

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['supervisor2.filtrar-muestra-de-entrevistas-a-asignar-a-supervisor', 'id_supervisor'=>$id_supervisor,'id_supervisor_asignado'=>$id_supervisor_asignado]]) !!}
                        {{-- <div class="form-group col-sm-6">
                            {!! Form::label('carrera', 'Carreras:') !!}
                            {!! Form::select('carrera', $carreras, null, ['class' => 'form-control', 'placeholder'=>'Elija una carrera']) !!}
                        </div> --}}

                        {{-- <div class="form-group col-sm-6">
                            {!! Form::label('universidad', 'Universidad:') !!}
                            {!! Form::select('universidad', $universidades, null, ['class' => 'form-control', 'placeholder'=>'Elija una universidad']) !!}
                        </div> --}}

                        <div class="form-group col-sm-6">
                            {!! Form::label('grado', 'Grado:') !!}
                            {!! Form::select('grado', $grados, null, ['class' => 'form-control', 'placeholder'=>'Elija un grado']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('disciplina', 'Disciplina:') !!}
                            {!! Form::select('disciplina', $disciplinas, null, ['class' => 'form-control', 'placeholder'=>'Elija una disciplina']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('area', 'Área:') !!}
                            {!! Form::select('area', $areas, null, ['class' => 'form-control', 'placeholder'=>'Elija un área']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('agrupacion', 'Agrupación:') !!}
                            {!! Form::select('agrupacion', $agrupaciones, null, ['class' => 'form-control', 'placeholder'=>'Elija una agrupación']) !!}
                        </div>

                        {{-- <div class="form-group col-sm-6">
                            {!! Form::label('sector', 'Sector:') !!}
                            {!! Form::select('sector', $sectores, null, ['class' => 'form-control', 'placeholder'=>'Elija un sector']) !!}
                        </div> --}}

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('supervisor2.lista-de-supervisores') !!}" class="btn btn-default">Cancelar</a>
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection