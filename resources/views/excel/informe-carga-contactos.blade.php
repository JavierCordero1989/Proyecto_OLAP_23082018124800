@extends('layouts.app')

@section('title', 'Informe archivo de contactos')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body with-border">
                <div class="panel-group" id="panel-informe">
                    {!! Form::label('', 'Total de registros del archivo: ') !!}
                    <p>{!! $informe['total_de_registros'] !!}</p>
                    <hr>
                    <div class="clearfix"></div>

                    {!! Form::label('', 'Total de contactos guardados:') !!}
                    <p>{!! $informe['total_de_guardados'] !!}</p>
                    <hr>
                    <div class="clearfix"></div>

                    {!! Form::label('', 'Registros con cédulas repetidas:') !!}
                    <p>{!! $informe['registros_cedula_repetida'] !!}</p>

                    @if (sizeof($informe['cedulas_sin_coincidencias']) > 0)
                        <hr>
                        <div class="clearfix"></div>
                        <!-- Panel para mostrar las cedulas que no han sido encontradas -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-cedulas">
                                        <i class="fas fa-angle-down"></i>
                                        Cédulas no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-cedulas" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Cédula</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['cedulas_sin_coincidencias'] as $item)
                                                    <tr>
                                                        <td>{!! $item !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{-- <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#report-panel" href="#panel-cedulas">
                                    <i class="fas fa-angle-down"></i>
                                    Cédulas no encontradas
                                </a>
                            </h4>
                        </div>
                        <div id="panel-cedulas" class="panel-collapse collapse">
                            <div class="panel-body">

                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
@endsection