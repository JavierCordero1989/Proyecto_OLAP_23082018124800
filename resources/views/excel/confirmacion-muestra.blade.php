@extends('layouts.app')

@section('title', 'Confirmación de la muestra')

@section('content')
    <div class="content">
        <h3 class="text-center">
            Informe del archivo de la muestra
        </h3>
        @if (Session::has('data_excel'))
            <div class="box box-primary">
                <div class="box-body with-border">
                    {!! Form::label('', 'Cantidad de casos subidos: ') !!}
                    {!! Form::text('', $report['cantidad_de_casos'], ['class'=>'form-control','disabled']) !!}
                    <hr>
                    {!! Form::label('', 'Totales por sexo: ') !!}
                    <div class="col-md-12">
                        @foreach ($report['total_por_sexo'] as $key =>$item)
                            {!! Form::label('', ($key=='M'?'Hombres':($key=='F'?'Mujeres':'Sin Clasificar'))) !!}
                            {!! Form::text('', $item, ['class'=>'form-control', 'disabled']) !!}
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::label('', 'Totales por tipo de caso') !!}
                    <div class="col-md-12">
                        @foreach ($report['totales_por_tipo_de_caso'] as $key => $item)
                            <div class="col-md-4">
                                {!! Form::label('', $key) !!}
                                {!! Form::text('', $item, ['class'=>'form-control', 'disabled']) !!}
                            </div>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::label('', 'Totales por agrupación') !!}
                    <div class="col-md-12">
                        @foreach ($report['totales_por_agrupacion'] as $key => $item)
                            <div class="col-md-4">
                                {!! Form::label('', $key) !!}
                                {!! Form::text('', $item, ['class'=>'form-control', 'disabled']) !!}    
                            </div>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    {!! Form::label('', 'Área y Disciplina de la muestra: ') !!}
                    {!! Form::text('', $report['area'].' - '.$report['disciplina'], ['class'=>'form-control','disabled']) !!}
                    <hr>
                    <a href="{!! route('excel.respuesta-archivo', 'SI') !!}" class='btn btn-primary' id='btn-aceptar-archivo'>Aceptar archivo</a>
                    <a href="{!! route('excel.respuesta-archivo', 'NO') !!}" class='btn btn-danger' id='btn-denegar-archivo'>Denegar Archivo</a>
                </div>
            </div>
        @else
            <div class="box box-danger">
                <div class="box-body with-border">
                    <h1 class="text-center text-danger">Ha ocurrido un error inesperado</h1>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $('#btn-aceptar-archivo').on('click', function(event) {
            if(!confirm('¿En verdad desea aceptar estos datos?.\nTome en cuenta que la acción no se puede deshacer una vez aceptada.')) {
                event.preventDefault(); 
            }
        });

        $('#btn-denegar-archivo').on('click', function(event) {
            if(!confirm('¿En verdad desea rechazar estos datos?.\nTome en cuenta que la acción no se puede deshacer una vez aceptada.')) {
                event.preventDefault(); 
            }
        });
    </script>
@endsection