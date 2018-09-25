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
                        <li><a href="#panel_1" data-toggle="tab" aria-expanded="false"> Resumen general</a></li>
                        <li class="active"><a href="#panel_2" data-toggle="tab" aria-expanded="true"> UCR</a></li>
                        <li><a href="#panel_3" data-toggle="tab" aria-expanded="false"> UNA</a></li>
                    </ul>

                    <!-- Paneles -->
                    <div class="tab-content">

                        <!-- Panel primer pestaña -->
                        <div class="tab-pane" id="panel_1">
                            <div class="row">

                                <!-- Tabla #1 -->
                                <div class="col-xs-12">
                                    <div class="col-xs-12 text-center">
                                        <h3 class="text-uppercase">
                                            CUADRO RESUMEN DEL GRADO DE AVANCE DEL TRABAJO DE CAMPO DE LA ENCUESTA DE
                                            SEGUIMIENTO DE LA CONDICIÓN LABORAL DE LAS PERSONAS GRADUADAS 2011-2013 DE UNIVERSIDADES ESTATALES
                                            CORRESPONDIENTE AL ÁREA DE EDUCACIÓN AL 25-04-2016
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
                                                    <td>1315</td>
                                                    <td>452</td>
                                                    <td>1767</td>
                                                    <td>683</td>
                                                    <td>430</td>
                                                    <td>1113</td>
                                                    <td>370</td>
                                                    <td>248</td>
                                                    <td>55,5 %</td>
                                                </tr>
                                                <tr>
                                                    <td>UNA</td>
                                                    <td>1197</td>
                                                    <td>660</td>
                                                    <td>1858</td>
                                                    <td>807</td>
                                                    <td>508</td>
                                                    <td>1315</td>
                                                    <td>233</td>
                                                    <td>148</td>
                                                    <td>29,0 %</td>
                                                </tr>
                                                <tr>
                                                    <td>ITCR</td>
                                                    <td>203</td>
                                                    <td>6</td>
                                                    <td>209</td>
                                                    <td>124</td>
                                                    <td>0</td>
                                                    <td>124</td>
                                                    <td>29</td>
                                                    <td>0</td>
                                                    <td>23,4 %</td>
                                                </tr>
                                                <tr>
                                                    <td>UNED</td>
                                                    <td>1318</td>
                                                    <td>990</td>
                                                    <td>2308</td>
                                                    <td>342</td>
                                                    <td>204</td>
                                                    <td>546</td>
                                                    <td>79</td>
                                                    <td>31</td>
                                                    <td>20,1 %</td>
                                                </tr>
                                                <tr>
                                                    <td>UTN</td>
                                                    <td>524</td>
                                                    <td>0</td>
                                                    <td>524</td>
                                                    <td>197</td>
                                                    <td>0</td>
                                                    <td>197</td>
                                                    <td>3</td>
                                                    <td>0</td>
                                                    <td>1,5 %</td>
                                                </tr>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>4557</th>
                                                    <th>2108</th>
                                                    <th>6666</th>
                                                    <th>2153</th>
                                                    <th>1142</th>
                                                    <th>3295</th>
                                                    <th>714</th>
                                                    <th>427</th>
                                                    <th>34,63</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- /Tabla #1 -->

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
                        <div class="tab-pane active" id="panel_2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="col-xs-12 text-center">
                                                <h3 class="text-uppercase">
                                                    Universidad de Costa Rica
                                                </h3>
                                                <h3 class="text-uppercase">
                                                    Fecha: {!! \Carbon\Carbon::now()->format('d - m - Y') !!}
                                                </h3>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="table-responsive">
                                                <table class="table table-condensed table-hover">
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

                                                    <tbody>
                                                        <tr>
                                                            <th rowspan="9">Educación</th>
                                                            <th>Total educación</th>
                                                            <th>1315</th>
                                                            <th>452</th>
                                                            <th>1767</th>
                                                            <th>683</th>
                                                            <th>430</th>
                                                            <th>1113</th>
                                                            <th>370</th>
                                                            <th>248</th>
                                                            <th>55,53</th>
                                                            <th>0</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Administración educativa</td>
                                                            <td>0</td>
                                                            <td>79</td>
                                                            <td>79</td>
                                                            <td>0</td>
                                                            <td>79</td>
                                                            <td>79</td>
                                                            <td>0</td>
                                                            <td>47</td>
                                                            <td>59,49</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Artes Industriales</td>
                                                            <td>1</td>
                                                            <td>0</td>
                                                            <td>1</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Docencia</td>
                                                            <td>0</td>
                                                            <td>2</td>
                                                            <td>2</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Preescolar</td>
                                                            <td>126</td>
                                                            <td>56</td>
                                                            <td>182</td>
                                                            <td>30</td>
                                                            <td>56</td>
                                                            <td>86</td>
                                                            <td>10</td>
                                                            <td>34</td>
                                                            <td>51,16</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Especial</td>
                                                            <td>67</td>
                                                            <td>34</td>
                                                            <td>101</td>
                                                            <td>67</td>
                                                            <td>34</td>
                                                            <td>101</td>
                                                            <td>37</td>
                                                            <td>25</td>
                                                            <td>61,39</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Física</td>
                                                            <td>106</td>
                                                            <td>0</td>
                                                            <td>106</td>
                                                            <td>30</td>
                                                            <td>0</td>
                                                            <td>30</td>
                                                            <td>22</td>
                                                            <td>0</td>
                                                            <td>73,33</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Preescolar Inglés</td>
                                                            <td>27</td>
                                                            <td>0</td>
                                                            <td>27</td>
                                                            <td>27</td>
                                                            <td>0</td>
                                                            <td>27</td>
                                                            <td>15</td>
                                                            <td>0</td>
                                                            <td>55,56</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Primaria</td>
                                                            <td>90</td>
                                                            <td>65</td>
                                                            <td>155</td>
                                                            <td>90</td>
                                                            <td>65</td>
                                                            <td>155</td>
                                                            <td>44</td>
                                                            <td>40</td>
                                                            <td>54,19</td>
                                                            <td>0</td>
                                                        </tr>

                                                        <tr>
                                                            <th rowspan="6">Ciencias básicas</th>
                                                            <th>Total ciencias básicas</th>
                                                            <th>398</th>
                                                            <th>58</th>
                                                            <th>456</th>
                                                            <th>301</th>
                                                            <th>27</th>
                                                            <th>328</th>
                                                            <th>61</th>
                                                            <th>6</th>
                                                            <th>20,43</th>
                                                            <th>Revisar</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Biología</td>
                                                            <td>107</td>
                                                            <td>14</td>
                                                            <td>121</td>
                                                            <td>30</td>
                                                            <td>0</td>
                                                            <td>30</td>
                                                            <td>4</td>
                                                            <td></td>
                                                            <td>13,33</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estadística</td>
                                                            <td>33</td>
                                                            <td>3</td>
                                                            <td>36</td>
                                                            <td>33</td>
                                                            <td>0</td>
                                                            <td>33</td>
                                                            <td>12</td>
                                                            <td></td>
                                                            <td>36,36</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Física</td>
                                                            <td>25</td>
                                                            <td></td>
                                                            <td>25</td>
                                                            <td>25</td>
                                                            <td>0</td>
                                                            <td>25</td>
                                                            <td>11</td>
                                                            <td></td>
                                                            <td>44,00</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Geología</td>
                                                            <td>45</td>
                                                            <td>14</td>
                                                            <td>59</td>
                                                            <td>45</td>
                                                            <td>0</td>
                                                            <td>45</td>
                                                            <td>13</td>
                                                            <td></td>
                                                            <td>28,89</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Laboratorista Químico</td>
                                                            <td>84</td>
                                                            <td></td>
                                                            <td>84</td>
                                                            <td>84</td>
                                                            <td>0</td>
                                                            <td>84</td>
                                                            <td>12</td>
                                                            <td></td>
                                                            <td>14,29</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                    </tbody>

                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total</th>
                                                            <th>1713</th>
                                                            <th>510</th>
                                                            <th>2223</th>
                                                            <th>984</th>
                                                            <th>457</th>
                                                            <th>1441</th>
                                                            <th>431</th>
                                                            <th>254</th>
                                                            <th>47,54</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
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
                                                <h3 class="text-uppercase">
                                                    Universidad Nacional
                                                </h3>
                                                <h3 class="text-uppercase">
                                                    Fecha: {!! \Carbon\Carbon::now()->format('d - m - Y') !!}
                                                </h3>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="table-responsive">
                                                <table class="table table-condensed table-hover">
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

                                                    <tbody>
                                                        <tr>
                                                            <th rowspan="9">Educación</th>
                                                            <th>Total educación</th>
                                                            <th>1315</th>
                                                            <th>452</th>
                                                            <th>1767</th>
                                                            <th>683</th>
                                                            <th>430</th>
                                                            <th>1113</th>
                                                            <th>370</th>
                                                            <th>248</th>
                                                            <th>55,53</th>
                                                            <th>0</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Administración educativa</td>
                                                            <td>0</td>
                                                            <td>79</td>
                                                            <td>79</td>
                                                            <td>0</td>
                                                            <td>79</td>
                                                            <td>79</td>
                                                            <td>0</td>
                                                            <td>47</td>
                                                            <td>59,49</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Artes Industriales</td>
                                                            <td>1</td>
                                                            <td>0</td>
                                                            <td>1</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Docencia</td>
                                                            <td>0</td>
                                                            <td>2</td>
                                                            <td>2</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Preescolar</td>
                                                            <td>126</td>
                                                            <td>56</td>
                                                            <td>182</td>
                                                            <td>30</td>
                                                            <td>56</td>
                                                            <td>86</td>
                                                            <td>10</td>
                                                            <td>34</td>
                                                            <td>51,16</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Especial</td>
                                                            <td>67</td>
                                                            <td>34</td>
                                                            <td>101</td>
                                                            <td>67</td>
                                                            <td>34</td>
                                                            <td>101</td>
                                                            <td>37</td>
                                                            <td>25</td>
                                                            <td>61,39</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Física</td>
                                                            <td>106</td>
                                                            <td>0</td>
                                                            <td>106</td>
                                                            <td>30</td>
                                                            <td>0</td>
                                                            <td>30</td>
                                                            <td>22</td>
                                                            <td>0</td>
                                                            <td>73,33</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Preescolar Inglés</td>
                                                            <td>27</td>
                                                            <td>0</td>
                                                            <td>27</td>
                                                            <td>27</td>
                                                            <td>0</td>
                                                            <td>27</td>
                                                            <td>15</td>
                                                            <td>0</td>
                                                            <td>55,56</td>
                                                            <td>0</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Educación Primaria</td>
                                                            <td>90</td>
                                                            <td>65</td>
                                                            <td>155</td>
                                                            <td>90</td>
                                                            <td>65</td>
                                                            <td>155</td>
                                                            <td>44</td>
                                                            <td>40</td>
                                                            <td>54,19</td>
                                                            <td>0</td>
                                                        </tr>

                                                        <tr>
                                                            <th rowspan="6">Ciencias básicas</th>
                                                            <th>Total ciencias básicas</th>
                                                            <th>398</th>
                                                            <th>58</th>
                                                            <th>456</th>
                                                            <th>301</th>
                                                            <th>27</th>
                                                            <th>328</th>
                                                            <th>61</th>
                                                            <th>6</th>
                                                            <th>20,43</th>
                                                            <th>Revisar</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Biología</td>
                                                            <td>107</td>
                                                            <td>14</td>
                                                            <td>121</td>
                                                            <td>30</td>
                                                            <td>0</td>
                                                            <td>30</td>
                                                            <td>4</td>
                                                            <td></td>
                                                            <td>13,33</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estadística</td>
                                                            <td>33</td>
                                                            <td>3</td>
                                                            <td>36</td>
                                                            <td>33</td>
                                                            <td>0</td>
                                                            <td>33</td>
                                                            <td>12</td>
                                                            <td></td>
                                                            <td>36,36</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Física</td>
                                                            <td>25</td>
                                                            <td></td>
                                                            <td>25</td>
                                                            <td>25</td>
                                                            <td>0</td>
                                                            <td>25</td>
                                                            <td>11</td>
                                                            <td></td>
                                                            <td>44,00</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Geología</td>
                                                            <td>45</td>
                                                            <td>14</td>
                                                            <td>59</td>
                                                            <td>45</td>
                                                            <td>0</td>
                                                            <td>45</td>
                                                            <td>13</td>
                                                            <td></td>
                                                            <td>28,89</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Laboratorista Químico</td>
                                                            <td>84</td>
                                                            <td></td>
                                                            <td>84</td>
                                                            <td>84</td>
                                                            <td>0</td>
                                                            <td>84</td>
                                                            <td>12</td>
                                                            <td></td>
                                                            <td>14,29</td>
                                                            <td>Revisar</td>
                                                        </tr>
                                                    </tbody>
                                                    
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total</th>
                                                            <th>1713</th>
                                                            <th>510</th>
                                                            <th>2223</th>
                                                            <th>984</th>
                                                            <th>457</th>
                                                            <th>1441</th>
                                                            <th>431</th>
                                                            <th>254</th>
                                                            <th>47,54</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
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