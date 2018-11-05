@extends('layouts.app')

@section('title', 'Informe de errores')

@section('content')
    <section class="content-header">
        <h1 class="text-center text-danger">
            Informe de errores al subir el archivo
        </h1>
    </section>

    <div class="content">
        {{-- Aqui para los errores --}}
        <div class="box box-warning">
            <div class="box-body">
                <div class="row">

                    <div class="col-xs-12">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                {{-- Crear una pestaña por cada dato en el Array --}}
                                @foreach ($reporte['encabezados_panel'] as $index => $encabezado)
                                    @if ($index == 0)
                                        <li class="active"><a href="#panel-{{$index}}" data-toggle="tab" aria-expanded="true"><b>{!! $encabezado !!}</b></a></li>
                                    @else
                                        <li><a href="#panel-{{$index}}" data-toggle="tab" aria-expanded="false"><b>{!! $encabezado !!}</b></a></li>
                                    @endif
                                @endforeach
                            </ul>

                            <div class="tab-content">
                                {{-- Crear un panel por cada dato en el array --}}
                                @foreach ($reporte['encabezados_panel'] as $index => $encabezado)
                                    @if ($index == 0)
                                        <div class="tab-pane active" id="panel-{{$index}}">
                                            @foreach ($reporte[$index] as $item)
                                                {!! $item !!} <br>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="tab-pane" id="panel-{{$index}}">
                                            @foreach ($reporte[$index] as $item)
                                                {!! $item !!} <br>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                   
                    <div class="col-xs-12">
                        <h3 class="text-center">{!! $reporte['total_entrevistas_guardadas'] !!}</h3>

                        @if (sizeof($data_file) > 0)
                            <form id="guardar-casos-aceptados-form" action="{!! route('excel.guardar-aceptados') !!}" method="post">
                                {{ csrf_field() }}
                                @foreach($data_file as $data)
                                    <input type="hidden" name="data_file[]" value='<?php echo serialize($data); ?>'>
                                @endforeach
                                
                            </form>

                            <div class="col-xs-12 col-md-6">
                                <a id="btn_submit" href="{!! route('excel.guardar-aceptados') !!}" class="btn btn-primary col-xs-12 col-sm-6 col-sm-offset-3 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                                    Guardar registros aceptados
                                </a>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <a href="{!! url('/home') !!}" class="btn btn-default col-xs-12 col-sm-6 col-sm-offset-3 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                                    Cancelar
                                </a>
                            </div>
                        @endif
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#btn_submit').on('click', function(event) {
            event.preventDefault();
            $('#guardar-casos-aceptados-form').submit();
        });
    </script>
@endsection