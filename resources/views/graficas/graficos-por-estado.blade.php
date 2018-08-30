@extends('layouts.app')

@section('title', 'Graficos')

@section('content')
    <section class="content-header">
        <!-- CAJA DONDE SE COLOCAN LOS GRAFICOS -->
        <div class="row">

            <!-- CAJA CON LOS GRAFICOS A LA IZQUIERDA -->
            <div class="col-md-6">

                <!-- Grafico aca-->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafico #1</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title='Minimizar'></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info no-click btn-social"><i class="fa fa-download"></i>Descarga</button>
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" onclick="descargarPNG(this,'grafico1',getFechaString())">Transparente</a></li>
                                    <li><a href="#" onclick="descargarJPG(this,'grafico1',getFechaString())">Fondo Blanco</a></li>
                                </ul>
                            </div>
                            {{--<a id="descargaJPG" class="btn btn-success"><i class="fa fa-download"></i> Descargar</a>--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="grafico1" style="height: 300px; width: 613px;" width="613" height="300"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafico #3</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title='Minimizar'></i>
                            </button>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info no-click btn-social"><i class="fa fa-download"></i>Descarga</button>
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" onclick="descargarPNG(this,'graficoPie',getFechaString())">Transparente</a></li>
                                    <li><a href="#" onclick="descargarJPG(this,'graficoPie',getFechaString())">Fondo Blanco</a></li>
                                </ul>
                            </div>
                            {{--<a id="descargaJPG" class="btn btn-success"><i class="fa fa-download"></i> Descargar</a>--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="graficoPie" style="height: 300px; width: 613px;" width="613" height="300"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col (LEFT) -->

            <!-- CAJA CON LOS GRAFICOS A LA DERECHA -->
            <div class="col-md-6">
                <!-- Grafico aca -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafico #2</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title='Minimizar'></i>
                            </button>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info no-click btn-social"><i class="fa fa-download"></i>Descarga</button>
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" onclick="descargarPNG(this,'grafico2',getFechaString())">Transparente</a></li>
                                    <li><a href="#" onclick="descargarJPG(this,'grafico2',getFechaString())">Fondo Blanco</a></li>
                                </ul>
                            </div>
                            {{--<a id="descargaJPG" class="btn btn-success"><i class="fa fa-download"></i> Descargar</a>--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="grafico2" style="height: 300px; width: 613px;" width="613" height="300"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Prueba Pie</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" title='Minimizar'></i>
                            </button>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info no-click btn-social"><i class="fa fa-download"></i>Descarga</button>
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" onclick="descargarPNG(this,'grafico4',getFechaString())">Transparente</a></li>
                                    <li><a href="#" onclick="descargarJPG(this,'grafico4',getFechaString())">Fondo Blanco</a></li>
                                </ul>
                            </div>
                            {{--<a id="descargaJPG" class="btn btn-success"><i class="fa fa-download"></i> Descargar</a>--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="grafico4" style="height: 300px; width: 613px;" width="613" height="300"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
            <!-- /.col (RIGHT) -->

        </div>
        <!-- aca cierra la caja para los graficos -->
        <!-- /.nav-tabs-custom -->
    </section>

    @section('scripts')
        <script type="text/javascript" src="{{ asset('js/Chart.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/chartGenerator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/chartDescarga.js') }}"></script>

        <script type="text/javascript">
            // var temperaturas = <?php /*echo json_encode($arrayTemperaturas['datos_temperaturas']);*/ ?>;
            // generarGraficoDeLineas(['Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto', 'Sétimo'], 'Gráfico #1', [32,45,8,6,99,12,24], 'grafico1');
            lineas('grafico1', ['Dato 1', 'Dato 2', 'Dato 3', 'Dato 4', 'Dato 5', 'Dato 6', 'Dato 7'], 'Grafico de lineas', []);
            // generarGraficoBarras(['Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto', 'Sétimo'], 'Gráfico #2', [32,45,8,6,99,12,24], 'grafico2');
            barras('grafico2');
            generarGraficoPie('graficoPie', [32,45,8,6,99,12,24]);
            pieChart("grafico4");
        </script>
    @endsection
@endsection
