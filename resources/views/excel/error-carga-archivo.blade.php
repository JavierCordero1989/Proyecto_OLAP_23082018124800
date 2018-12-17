@extends('layouts.app')

@section('title', 'Error de carga')

@section('content')
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="box box-primary">
            <div class="box-body with-border">
                <div class="panel-group" id="report-panel">
                    
                    @if (isset($informe['carreras']) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-carreras">
                                        <i class="fas fa-angle-down"></i>
                                        Carreras no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-carreras" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Código</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['carreras'] as $carrera => $encontradas)
                                                    <tr>
                                                        <td>{!! $carrera !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (isset($informe['universidades']) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-universidades">
                                        <i class="fas fa-angle-down"></i>
                                        Universidades no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-universidades" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Código</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['universidades'] as $universidad => $repeticiones)
                                                    <tr>
                                                        <td>{!! $universidad !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (isset($informe['grados']) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-grados">
                                        <i class="fas fa-angle-down"></i>
                                        Grados no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-grados" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Código</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['grados'] as $grado => $repeticiones)
                                                    <tr>
                                                        <td>{!! $grado !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (isset($informe['areas']) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-areas">
                                        <i class="fas fa-angle-down"></i>
                                        Áreas no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-areas" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Código</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['areas'] as $area => $repeticiones)
                                                    <tr>
                                                        <td>{!! $area !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (isset($informe['disciplinas']) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-disciplinas">
                                        <i class="fas fa-angle-down"></i>
                                        Disciplinas no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-disciplinas" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Código</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['disciplinas'] as $disciplinas => $repeticiones)
                                                    <tr>
                                                        <td>{!! $disciplinas !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (isset($informe['agrupaciones']) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-agrupaciones">
                                        <i class="fas fa-angle-down"></i>
                                        Agrupaciones no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-agrupaciones" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Código</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['agrupaciones'] as $agrupaciones => $repeticiones)
                                                    <tr>
                                                        <td>{!! $agrupaciones !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (isset($informe['sectores']) > 0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#report-panel" href="#panel-sectores">
                                        <i class="fas fa-angle-down"></i>
                                        Sectores no encontradas
                                    </a>
                                </h4>
                            </div>
                            <div id="panel-sectores" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <th>Código</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($informe['sectores'] as $sectores => $repeticiones)
                                                    <tr>
                                                        <td>{!! $sectores !!}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection