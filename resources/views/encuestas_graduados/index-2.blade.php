@extends('layouts.app')

@section('title', 'Encuestadores') 

@section('content')
    <div id="app">
        <section class="content-header">
            <div class="panel-body">
                <div class="col-xs-12 col-sm-6">
                    <input type="text" class="form-control" placeholder="Nombre..." v-model="nombre">
                </div>
                <div class="col-xs-12 col-sm-6">
                    <input type="text" class="form-control" placeholder="Carrera..." v-model="carrera">
                </div>
            </div>
            <h1 class="pull-left">Lista de encuestas</h1>
            <h1 class="pull-right">
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('encuestas-graduados.create') !!}">Agregar nueva</a>
            </h1>
        </section>
        <div class="content">
            <div class="clearfix"></div>
    
            @include('flash::message')
    
            <div class="clearfix"></div>
            <div class="box-header">
                <div class="box-body table-responsive">
                    {{-- <pre>
                        @{{lista_encuestas}}
                    </pre> --}}
                    {{-- @include('encuestas_graduados.New_table') --}}
                    @include('encuestas_graduados.table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vuejs-paginator/2.0.0/vuejs-paginator.js"></script>
    <script>
        // let lista = <?php #echo json_encode($paginacion); ?>

        new Vue({
            el: '#app',
            data: {
                lista_encuestas: [],
                pagination: [],
                nombre: '',
                carrera: '',
            },
            created: function(){
                this.getEncuestas()
            },
            methods: {
                eventoEliminar: function(evento) {
                    if(!confirm('¿Desea eliminar el registro de todas formas?')) {
                        evento.preventDefault()
                    }
                },
                addContactRoute: function(id) {
                    let route = '{{route("encuestas-graduados.agregar-contacto", ":id")}}'
                    route = route.replace(":id", id)
                    return route
                },
                getEncuestas: function(page) {
                    let url = 'lista-de-encuestas?page='+page
                    axios.get(url).then(response=> {
                        this.lista_encuestas = response.data.encuestas.data
                        this.pagination = response.data.pagination
                    })
                },
                changePage: function(page) {
                    this.pagination.current_page == page
                    this.getEncuestas(page)
                }
            },
            computed: {
                isActived: function() {
                    return this.pagination.current_page
                },
                pagesNumber: function(){
                    if(!this.pagination.to) {
                        return []
                    }

                    let offset = 2
                    let from = this.pagination.current_page - offset
                    
                    from = (from < 1) ? 1 : from

                    let to = from + (offset * 2)
                    to = (to >= this.pagination.last_page) ? this.pagination.last_page : to

                    let pagesArray = []

                    while(from <= to) {
                        pagesArray.push(from)
                        from++
                    }

                    return pagesArray
                },
                listaFiltro: function() {
                    let filtro = this.lista_encuestas

                    filtro = filtro.filter(el=>el.nombre_completo.toLowerCase().includes(this.nombre.toLowerCase()))
                    filtro = filtro.filter(el=>el.codigo_carrera.toLowerCase().includes(this.carrera.toLowerCase()))
                    
                    return filtro
                }
            }
        })
    </script>
@endsection

