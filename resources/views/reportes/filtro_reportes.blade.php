@extends('layouts.app')

@section('title', 'Filtro')

@section('content')
    {{-- <section class="content-header">
        <h1 class="pull-left">
            <a class="btn btn-primary pull-left" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('reportes.filtro-encuestas') !!}">Generar reporte</a>
        </h1>
    </section> --}}

    <div class="clearfix"></div>

    <div class="content">
        {!! Form::open(['route'=>'reportes.filtro-encuestas']) !!}
            <div class="row">
                <div class="col-xs-6">
                    <h3>Áreas</h3>
                    <div class="col-xs-12">
                        @foreach($areas as $area)
                            {!! Form::checkbox('areas[]', $area->id) !!} {!! $area->nombre !!} <br>
                        @endforeach
                    </div>
                </div>

                <div class="col-xs-6">
                    <h3>Disciplinas</h3>
                    <div class="col-xs-12">
                        @foreach($disciplinas as $disciplina)
                            {!! Form::checkbox('disciplinas[]', $disciplina->id) !!} {!! $disciplina->nombre !!} <br>
                        @endforeach
                    </div>
                </div>

                <div class="col-xs-12" style="margin-top: 15px;">
                    {!! Form::submit('Generar reporte', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection