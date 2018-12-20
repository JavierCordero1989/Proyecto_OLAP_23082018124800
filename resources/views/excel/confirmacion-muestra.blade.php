@extends('layouts.app')

@section('title', 'Confirmación de la muestra')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/modal_letters.css') }}">
@endsection

@section('content')
    <div class="content">
        <h3 class="text-center">
            Informe del archivo de la muestra
        </h3>
        @if (Session::has('data_excel'))
            <div class="box box-primary">
                <div class="box-body with-border">
                    {!! Form::label('', 'Tiempo invertido en la lectura del archivo: ') !!}
                    <p>{!! $report['tiempo_consumido'] !!}</p>
                    <hr>

                    {{-- <p>Links: {!! $report['links_duplicados'][0] !!}</p> --}}

                    @if ($report['total_de_casos'] <= 0)
                        <div class="roww">
                            <div class="alert alert-error alert-important alert-dismissible">
                                {{-- <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                                No existen casos en el archivo que se puedan almacenar, debido a que todos los tokens ya se encuentran registrados en el sistema.
                            </div>    
                            <a href="{!! route('excel.create') !!}" class="btn btn-default"><i class="fas fa-arrow-left"></i>&nbsp;Volver</a>
                        </div>
                        
                    @else
                            {!! Form::label('', 'Total de registros del archivo aceptados: ') !!}
                            <p>{!! $report['total_de_casos'] !!}</p>
                            <hr>

                            <div class="panel-group" id="report-file">

                                @if ($report['cedulas_repetidas'][0] > 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#report-file" href="#panel-cedula-repetidas">
                                                    <i class="fas fa-angle-down"></i>
                                                    Casos con más carreras
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-cedula-repetidas" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <h3>Total de casos: {!! $report['cedulas_repetidas'][0] !!}</h3>

                                                <table class="table table-condensed">
                                                    <thead>
                                                        <th>Cédula</th>
                                                        <th>Ocurrencias</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($report['cedulas_repetidas'][1] as $key => $value)
                                                            <tr>
                                                                <td>{!! $key !!}</td>
                                                                <td>{!! $value !!}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="clearfix"></div>
                                @endif
            
                                @if ($report['tokens_duplicados'][0] > 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#report-file" href="#panel-tokens-duplicados">
                                                    <i class="fas fa-angle-down"></i>
                                                    Tokens duplicados
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-tokens-duplicados" class="panel-collapse collapse">
                                            <div  class="panel-body">
                                                <h3>Total de casos: {!! $report['tokens_duplicados'][0] !!}</h3>

                                                @if ($report['tokens_duplicados'][0] < 1000)
                                                    <ul>
                                                        @foreach ($report['tokens_duplicados'][1] as $key => $value)
                                                            <li>{!! $key !!}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <div class="roww">
                                                        <div class="alert alert-error alert-important alert-dismissible">
                                                            {{-- <button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                                                            Hay más de 1000 casos con tokens duplicados. No se muestran debido a que hace lenta la carga de la información en esta pantalla.
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="clearfix"></div>
                                @endif
            
                                @if ($report['totales_por_area'][0] > 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#report-file" href="#panel-total-por-area">
                                                    <i class="fas fa-angle-down"></i>
                                                    Totales por área
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-total-por-area" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="table table-condensed">
                                                    <thead>
                                                        <th>Área</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($report['totales_por_area'][1] as $key => $value)
                                                            <tr>
                                                                <td>{!! $key !!}</td>
                                                                <td>{!! $value !!}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="clearfix"></div>
                                @endif
            
                                @if ($report['totales_por_agrupacion'][0] > 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#report-file" href="#panel-total-por-agrupacion">
                                                    <i class="fas fa-angle-down"></i>
                                                    Totales por agrupación
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-total-por-agrupacion" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="table table-condensed">
                                                    <thead>
                                                        <th>Agrupación</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($report['totales_por_agrupacion'][1] as $key => $value)
                                                            <tr>
                                                                <td>{!! $key !!}</td>
                                                                <td>{!! $value !!}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="clearfix"></div>
                                @endif
            
                                @if (sizeof($report['totales_por_caso']) > 0)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#report-file" href="#panel-total-tipo-de-caso">
                                                    <i class="fas fa-angle-down"></i>
                                                    Totales por tipo de caso
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="panel-total-tipo-de-caso" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="table table-condensed">
                                                    <thead>
                                                        <th>Tipo de caso</th>
                                                        <th>Total</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($report['totales_por_caso'] as $key => $value)
                                                            <tr>
                                                                <td>{!! $key !!}</td>
                                                                <td>{!! $value !!}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <a href="{!! route('excel.respuesta-archivo', 'SI') !!}" class='btn btn-primary' id='btn-aceptar-archivo'>Aceptar archivo</a>
                            <a href="{!! route('excel.respuesta-archivo', 'NO') !!}" class='btn btn-danger' id='btn-denegar-archivo'>Denegar Archivo</a>
                    @endif
                </div>
            </div>
        @else
            <div class="box box-danger">
                <div class="box-body with-border">
                    <h1 class="text-center text-danger">Ha ocurrido un error inesperado</h1>
                </div>
            </div>
        @endif

        @include('modals.loading_letters')
        @include('modals.mensaje')
    </div>
@endsection

@section('scripts')
    <!-- Script para las letras del modal -->
    <script src="{{ asset('js/jquery.lettering-0.6.1.min.js') }}"></script>

    <!-- Script para que las letras puedan tener su efecto de movimiento -->    
    <script>$(".loading").lettering();</script>

    <script>
        $('#btn-aceptar-archivo').on('click', function(event) {
            if(!confirm('¿En verdad desea aceptar estos datos?.\nTome en cuenta que la acción no se puede deshacer una vez aceptada.')) {
                event.preventDefault(); 
            }
            $('#modalLoadingLetters').modal('show');
        });

        $('#btn-denegar-archivo').on('click', function(event) {
            if(!confirm('¿En verdad desea rechazar estos datos?.\nTome en cuenta que la acción no se puede deshacer una vez aceptada.')) {
                event.preventDefault(); 
            }
        });
    </script>
@endsection