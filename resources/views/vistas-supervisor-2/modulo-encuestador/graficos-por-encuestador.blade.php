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
                        <h3 class="box-title">Grafico de barras</h3>

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
                            <canvas id="grafico1" style="height: 300px; width: 613px;" width="800" height="450"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafico de lineas</h3>

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
                            <canvas id="grafico2" style="height: 300px; width: 613px;" width="800" height="450"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

                <!-- Grafico aca-->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafico de barras horizontales</h3>

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
                                    <li><a href="#" onclick="descargarPNG(this,'grafico5',getFechaString())">Transparente</a></li>
                                    <li><a href="#" onclick="descargarJPG(this,'grafico5',getFechaString())">Fondo Blanco</a></li>
                                </ul>
                            </div>
                            {{--<a id="descargaJPG" class="btn btn-success"><i class="fa fa-download"></i> Descargar</a>--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="grafico5" style="height: 300px; width: 613px;" width="800" height="450"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col (LEFT) -->

            <!-- CAJA CON LOS GRAFICOS A LA DERECHA -->
            <div class="col-md-6">
                <!-- Grafico aca -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafico de dona</h3>

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
                                    <li><a href="#" onclick="descargarPNG(this,'grafico3',getFechaString())">Transparente</a></li>
                                    <li><a href="#" onclick="descargarJPG(this,'grafico3',getFechaString())">Fondo Blanco</a></li>
                                </ul>
                            </div>
                            {{--<a id="descargaJPG" class="btn btn-success"><i class="fa fa-download"></i> Descargar</a>--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="grafico3" style="height: 300px; width: 613px;" width="800" height="450"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gráfico de pie</h3>

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
                            <canvas id="grafico4" style="height: 300px; width: 613px;" width="800" height="450"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gráfico de barras combinadas</h3>

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
                                    <li><a href="#" onclick="descargarPNG(this,'grafico6',getFechaString())">Transparente</a></li>
                                    <li><a href="#" onclick="descargarJPG(this,'grafico6',getFechaString())">Fondo Blanco</a></li>
                                </ul>
                            </div>
                            {{--<a id="descargaJPG" class="btn btn-success"><i class="fa fa-download"></i> Descargar</a>--}}
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="grafico6" style="height: 300px; width: 613px;" width="800" height="450"></canvas>
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
            graficoDeBarras("grafico1");
            graficoDeLineas("grafico2");
            graficoDeDona("grafico3");
            graficoDePie("grafico4");
            graficoDeBarrasHorizontales("grafico5");
            graficoDeBarrasAgrupadas("grafico6");
        </script>
    @endsection
@endsection
