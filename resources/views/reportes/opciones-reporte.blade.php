@extends('layouts.app')

@section('title', 'Filtro de reportes')

@section('content')
    @php
        $sectores = config("options.sector_types");
    @endphp

    <div id="app-vue-reports" class="content">
        <div class="panel-group" style="padding-bottom:2em;">
            {!! Form::button('<i class="fas fa-brush"></i> Limpiar', [
                'class'=>'btn btn-default pull-left',
                'v-on:click'=>'limpiar'
            ]) !!}

            <button class="btn btn-primary pull-left" style="margin-left: 2em;" :disabled="activarBotonGenerarReporte" v-on:click="generarReporte">
                <i class="fas fa-clipboard"></i> 
                Generar reporte
            </button>
        </div>

        <div class="clearfix"></div>
        <div class="panel-group" id="accordion">

            <!-- PANEL COLAPSABLE PARA LOS SECTORES Y AGRUPACIONES -->
            <div class="panel panel-default">
                <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#sector-agrupacion">
                        <i class="fas fa-angle-down"></i>
                        Sector y Agrupación
                    </a>
                </h4>
                </div>
                <div id="sector-agrupacion" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="panel-group" id="accordion-sectores-agrupaciones">

                            <!-- PANEL ANIDADO PARA SECTOR -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion-sectores-agrupaciones" href="#panel-sector">
                                            <i class="fas fa-angle-down"></i>
                                            Sector
                                        </a>
                                    </h4>
                                </div>
                                <div id="panel-sector" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <li v-for="item in lista_sectores" class="checkbox">
                                            <label class="label-text">
                                                <input type="checkbox" :value="item.id" v-model="sector"> @{{item.nombre}}
                                            </label>
                                        </li>
                                    </div>
                                </div>
                            </div>

                            <!-- PANEL ANIDADO PARA AGRUPACIÓN -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion-sectores-agrupaciones" href="#panel-agrupacion">
                                            <i class="fas fa-angle-down"></i>
                                            Agrupación
                                        </a>
                                    </h4>
                                </div>
                                <div id="panel-agrupacion" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <li v-for="item in lista_agrupaciones" class="checkbox">
                                            <label class="label-text">
                                                <input type="checkbox" :value="item.id" v-model="agrupacion"> @{{item.nombre}}
                                            </label>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL COLAPSABLE PARA LAS ÁREAS -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#areas">
                            <i class="fas fa-angle-down"></i>
                            Áreas
                        </a>
                    </h4>
                </div>
                <div id="areas" class="panel-collapse collapse">
                    <div class="panel-body">
                        <li v-for="(item, index) in lista_areas" class="checkbox">
                            <label class="label-text">
                                <input type="checkbox" :value="index" @change="cargarDisciplinas(area)" v-model="area"> @{{item}}
                            </label>
                        </li>
                    </div>
                </div>
            </div>

            <!-- PANEL COLAPSABLE PARA LAS DISCIPLINAS DE CADA ÁREA -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#disciplinas-por-area">
                            <i class="fas fa-angle-down"></i>
                            Disciplinas
                        </a>
                    </h4>
                </div>
                <div id="disciplinas-por-area" class="panel-collapse collapse">
                    <!-- PANEL ANIDADO PARA LAS DISCIPLINAS-->
                    <div class="panel-body">
                        <div class="panel-group" id="accordion2">
                            <div v-for="(item, index) in lista_disciplinas" class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion2" :href="'#panel_'+index.replace(/ /g, '_')">
                                            <i class="fas fa-angle-down"></i>
                                            @{{ index }}
                                        </a>
                                    </h4>
                                </div>
                                <div :id="'panel_'+index.replace(/ /g, '_')" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <li class="checkbox" v-for="disc in item">
                                            <label class="label-text">
                                                <input type="checkbox" :value="disc.id" v-model="disciplina">
                                                @{{disc.nombre}}
                                            </label>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <pre class="hide">
            debug mode:  <br>
            sectores: @{{sector}} <br>
            agrupaciones: @{{agrupacion}} <br>
            areas: @{{area}} <br>
            disciplinas: @{{disciplina}} <br>
            reporte: @{{reporte}} <br>
        </pre> --}}
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#app-vue-reports',
            created: function() {
                this.getCarreras()
                this.getSectores()
                this.getAgrupaciones()
            },
            data: {
                sector: [],
                agrupacion: [],
                area: [],
                disciplina: [],
            
                lista_sectores: [],
                lista_agrupaciones: [],
                lista_areas: [],
                lista_disciplinas: [],

                reporte: [],
                btnActive: true,
            },
            methods: {
                cleanInputs: function() {
                    this.sector = '',
                    this.agrupacion = '',
                    this.area = [],
                    this.disciplina = ['1']
                    this.btnActive = true
                    this.reporte = []
                    this.lista_disciplinas = []
                },
                getCarreras: function() {
                    url = '{{ route("areas.axios") }}'
                    axios.get(url).then(response=>{
                        this.lista_areas = response.data
                    })
                },
                getSectores: function() {
                    this.lista_sectores = [
                        {id:'1', nombre:'PÚBLICO'},
                        {id:'2', nombre:'PRIVADO'}
                    ]
                },
                getAgrupaciones: function() {
                    this.lista_agrupaciones = [
                        {id:'1', nombre:'UCR'},
                        {id:'2', nombre:'UNED'},
                        {id:'3', nombre:'ITCR'},
                        {id:'4', nombre:'UTN'},
                        {id:'5', nombre:'UNA'},
                        {id:'6', nombre:'PRIVADA'}
                    ]
                },
                cargarDisciplinas: function(area) {
                    
                    if(area != '') {
                        let url = '{{ route("disciplinas.axios", ":id") }}'
                        url = url.replace(":id", area)

                        axios.get(url).then(response=> {
                            this.lista_disciplinas = response.data
                        })
                    }
                    else {
                        this.lista_disciplinas = []
                    }
                },
                tamannioDisciplinas: function() {
                    return Object.keys(this.lista_disciplinas);
                },
                generarReporte: function() {
                    let url = '{{ route("reportes.generar") }}'
                    axios.get(url, {
                        params: {
                            sector: this.sector,
                            agrupacion: this.agrupacion,
                            area: this.area,
                            disciplina: this.disciplina
                        }
                    }).then(response=>{
                        this.reporte = response.data
                        console.log(this.reporte)
                    })
                },
                limpiar: function() {
                    this.sector = []
                    this.agrupacion = []
                    this.area = []
                    this.disciplina = []
                    this.lista_disciplinas = []
                }
            },
            computed: {
                activarBotonGenerarReporte: function() {
                    let activo = true

                    if(this.sector.length > 0) {activo = false}
                    if(this.agrupacion.length > 0) {activo = false}
                    if(this.area.length > 0) {activo = false}
                    if(this.disciplina.length > 0) {activo = false}

                    return activo;
                }
            }
        })
    </script>
@endsection