@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
    <section class="content-header text-center">
        <h2>Reportes</h2>
    </section>

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <!-- Pestañas -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#panel_1" data-toggle="tab" aria-expanded="false"> Resumen general</a></li>
                        <li><a href="#panel_2" data-toggle="tab" aria-expanded="true"> UCR</a></li>
                        <li><a href="#panel_3" data-toggle="tab" aria-expanded="false"> UNA</a></li>
                    </ul>

                    <!-- Paneles -->
                    <div class="tab-content">

                        <!-- Panel primer pestaña -->
                        <div class="tab-pane active" id="panel_1">
                            <div class="row">
                                <!-- Tabla dinámica -->
                                <div class="col-xs-12">
                                    <div class="col-xs-12 text-center">
                                        <h3 id="titulo_reporte" class="text-uppercase"></h3>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="table-responsive">
                                        <table id="reporte_general" class="table table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center info">Agrupación</th>
                                                    <th colspan="3" class="text-center info">Población</th>
                                                    <th colspan="3" class="text-center info">Muestra</th>
                                                    <th colspan="2" class="text-center info">Entrevistas realizadas</th>
                                                    <th rowspan="2" class="text-center info">Porcentaje de avance</th>
                                                </tr>
                                                <tr>
                                                    <th class="success">Bachiller</th>
                                                    <th class="success">Licenciatura</th>
                                                    <th class="success">Total</th>
                                                    
                                                    <th class="warning">Bachiller</th>
                                                    <th class="warning">Licenciatura</th>
                                                    <th class="warning">Total</th>

                                                    <th class="warning">Bachiller</th>
                                                    <th class="warning">Licenciatura</th>
                                                </tr>
                                            </thead>

                                            {{-- <tbody>
                                                @foreach($reporte['data'] as $key => $value)
                                                    <tr>
                                                        <td class="text-uppercase">{!! $key !!}</td>
                                                        @foreach ($value as $data)
                                                            <td>{!! $data !!}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </div>
                                <!-- ./Tabla dinámica -->

                                <!-- Tabla #2 -->
                                <div class="col-xs-12">
                                    <div class="col-xs-12 text-center">
                                        <h3 class="text-uppercase">
                                            CUADRO RESUMEN DEL GRADO DE AVANCE DEL TRABAJO DE CAMPO DE LA ENCUESTA DE
                                            SEGUIMIENTO DE LA CONDICIÓN LABORAL DE LAS PERSONAS GRADUADAS 2011-2013 DE UNIVERSIDADES ESTATALES
                                            CORRESPONDIENTE AL ÁREA DE CIENCIAS BÁSICAS AL 25-04-2016
                                        </h3>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="table-responsive">
                                        <table class="table table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="text-center info">Agrupación</th>
                                                    <th colspan="3" class="text-center info">Población</th>
                                                    <th colspan="3" class="text-center info">Muestra</th>
                                                    <th colspan="2" class="text-center info">Entrevistas realizadas</th>
                                                    <th rowspan="2" class="text-center info">Porcentaje de avance</th>
                                                </tr>
                                                <tr>
                                                    <th class="success">Bachiller</th>
                                                    <th class="success">Licenciatura</th>
                                                    <th class="success">Total</th>
                                                    
                                                    <th class="warning">Bachiller</th>
                                                    <th class="warning">Licenciatura</th>
                                                    <th class="warning">Total</th>

                                                    <th class="warning">Bachiller</th>
                                                    <th class="warning">Licenciatura</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>UCR</td>
                                                    <td>398</td>
                                                    <td>58</td>
                                                    <td>456</td>
                                                    <td>301</td>
                                                    <td>27</td>
                                                    <td>238</td>
                                                    <td>61</td>
                                                    <td>6</td>
                                                    <td>20,43 %</td>
                                                </tr>
                                            </tbody>

                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- /Tabla #2 -->
                            </div>
                        </div>
                        <!-- /Panel primer pestaña -->

                        <!-- Panel segunda pestaña -->
                        <div class="tab-pane" id="panel_2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="col-xs-12 text-center">
                                                <h3 id="titulo-reporte-ucr" class="text-uppercase"></h3>
                                                <h3 id="fecha-reporte-ucr" class="text-uppercase"></h3>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="table-responsive">
                                                
                                            <table id="tabla-reporte-ucr" class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" class="text-center info">Área</th>
                                                        <th rowspan="2" class="text-center info">Disciplina</th>
                                                        <th colspan="3" class="text-center info">Población</th>
                                                        <th colspan="3" class="text-center info">Muestra</th>
                                                        <th colspan="2" class="text-center info">Entrevistas realizadas</th>
                                                        <th rowspan="2" class="text-center info">Porcentaje de avance</th>
                                                        <th rowspan="2" class="text-center info">* Estado</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="success">Bachiller</th>
                                                        <th class="success">Licenciatura</th>
                                                        <th class="success">Total</th>

                                                        <th class="warning">Bachiller</th>
                                                        <th class="warning">Licenciatura</th>
                                                        <th class="warning">Total</th>

                                                        <th class="warning">Bachiller</th>
                                                        <th class="warning">Licenciatura</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Panel segunda pestaña -->

                        <!-- Panel tercera pestaña -->
                        <div class="tab-pane" id="panel_3">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="col-xs-12 text-center">
                                                <h3 id="titulo-reporte-una" class="text-uppercase"></h3>
                                                <h3 id="fecha-reporte-una" class="text-uppercase"></h3>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="table-responsive">
                                                <table id="tabla-reporte-una" class="table table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" class="text-center info">Área</th>
                                                            <th rowspan="2" class="text-center info">Disciplina</th>
                                                            <th colspan="3" class="text-center info">Población</th>
                                                            <th colspan="3" class="text-center info">Muestra</th>
                                                            <th colspan="2" class="text-center info">Entrevistas realizadas</th>
                                                            <th rowspan="2" class="text-center info">Porcentaje de avance</th>
                                                            <th rowspan="2" class="text-center info">* Estado</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="success">Bachiller</th>
                                                            <th class="success">Licenciatura</th>
                                                            <th class="success">Total</th>

                                                            <th class="warning">Bachiller</th>
                                                            <th class="warning">Licenciatura</th>
                                                            <th class="warning">Total</th>

                                                            <th class="warning">Bachiller</th>
                                                            <th class="warning">Licenciatura</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Panel tercera pestaña -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{!! asset('js/reportTableGenerator.js') !!}"></script>
    <script>
        //Se obtienen los datos provenientes del servidor
        var datos_reporte_general = <?php echo $reporte; ?>;
        var datos_reporte_ucr = <?php echo $reporte_areas_ucr; ?>; 
        var datos_reporte_una = <?php echo $reporte_areas_una; ?>;
        
        generar_reporte_general(datos_reporte_general);
        generar_tabla_reporte(datos_reporte_ucr, 'titulo-reporte-ucr', 'fecha-reporte-ucr', 'tabla-reporte-ucr');
        generar_tabla_reporte(datos_reporte_una, 'titulo-reporte-una', 'fecha-reporte-una', 'tabla-reporte-una');

    </script>
@endsection