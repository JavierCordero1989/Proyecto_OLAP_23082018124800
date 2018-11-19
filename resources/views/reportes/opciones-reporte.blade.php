@extends('layouts.app')

@section('title', 'Filtro de reportes')

@section('content')
    <div id="app-vue-reports" class="content">
        <div class="jumbotron">
            <div class="col-md-12">
                {!! Form::button('<i class="fas fa-search"></i> Limpiar...', ['class'=>'btn btn-default pull-left', 'v-on:click'=>'cleanInputs']) !!}
            </div>

            <!-- SELECT CON LOS SECTORES -->
            <div class="form-group col-md-3">
                <label for="" class="control-label">Sector</label>
                {!! Form::select('', config('options.sector_types'), null, ['class'=>'form-control', 'v-model'=>'sector']) !!}
            </div>
    
            <!-- SELECT CON LAS AGRUPACIONES -->
            <div class="form-group col-md-3">
                <label for="" class="control-label">Agrupación</label>
                {!! Form::select('', config('options.group_types'), null, ['class'=>'form-control', 'v-model'=>'agrupacion']) !!}
            </div>
    
            <!-- SELECT CON LAS ÁREAS -->
            <div class="form-group col-md-3">
                <label for="" class="control-label">Área</label>
                <select class="form-control" v-model="area" @change="cargarDisciplinas(area)">
                    <option disabled value="">- - - ÁREAS - - -</option>
                    <option class="text-uppercase" v-for="(item, index) in lista_areas" :value="index" :selected="index == 1 ? 'true' : 'false'">@{{ item }}</option>
                </select>
            </div>
            
            <!-- SELECT CON LAS DISCIPLINAS POR ÁREA -->
            <div class="form-group col-md-3">
                <label for="" class="control-label">Disciplina</label>
                <select v-model="disciplina" class="form-control">
                    <option disabled value="">- - - DISCIPLINAS - - -</option>
                    <option v-for="(item, index) in lista_disciplinas" :value="index">@{{ item }}</option>
                </select>
            </div>

            <div class="form-group col-md-12">
                {!! Form::button('<i class="fas fa-clipboard"></i> Generar reporte', ['class'=>'btn btn-primary pull-left', 'v-on:click'=>'generarReporte']) !!}
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body with-border">
                @{{reporte}}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#app-vue-reports',
            created: function() {
                this.getCarreras()
            },
            data: {
                sector: '',
                agrupacion: '',
                area: '',
                disciplina: '',
                lista_areas: [],
                lista_disciplinas: [],
                reporte: []
            },
            methods: {
                cleanInputs: function() {
                    this.sector = '',
                    this.agrupacion = '',
                    this.area = '',
                    this.disciplina = ''
                },
                getCarreras: function() {
                    url = '{{ route("areas.axios") }}'
                    axios.get(url).then(response=>{
                        this.lista_areas = response.data
                    })
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
                generarReporte: function() {
                    this.reporte = 'HOLA REPORTE'
                }
            }
        })
    </script>
@endsection