@extends('layouts.app')

@section('title', 'Encuestadores') 

@section('content')
    <div id="app">
        <section class="content-header">
            <div class="col-xs-12">
                <h1 class="pull-left">
                    <a href="#" class="btn btn-default pull-left" v-on:click="clearInputs">Limpiar campos</a>
                </h1>
                <h1 class="pull-right">
                    <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('encuestadores.create') !!}">Agregar nuevo</a>
                </h1>
            </div>

            <div class="col-xs-12">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="search_user_code" class="control-label">Código: @{{user_code}}</label>
                        <div class="input-group">
                            <input type="search" class="form-control" v-model="user_code">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="search_name_code" class="control-label">Nombre: @{{name}}</label>
                        <div class="input-group">
                            <input type="search" class="form-control" v-model="name">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="search_email" class="control-label">Correo electrónico: @{{email}}</label>
                        <div class="input-group">
                            <input type="search" class="form-control" v-model="email">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="content">
            <div class="clearfix"></div>

            @include('flash::message')

            <div class="clearfix"></div>
            <div class="box-header">
                <div class="box-body">
                    @include('encuestadores.table')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
    <script>
        let lista = <?php echo json_encode($lista_encuestadores); ?>

        new Vue({
            el: '#app',
            data: {
                user_code: '',
                name: '',
                email: '',
                conected_user: '{{Auth::user()->id}}',
                lista_encuestadores: lista
            },
            methods: {
                getDeleteRoute: function(id) {
                    let route = '{{ route("encuestadores.destroy", ":id") }}'
                    route = route.replace(":id", id)
                    return route
                },
                getEditRoute: function(id) {
                    let route = '{{ route("encuestadores.edit", ":id") }}'
                    route = route.replace(":id", id)
                    return route
                },
                getAssignedInterviewsRoute: function(id) {
                    let route = '{{ route("asignar-encuestas.lista-encuestas-asignadas", ":id") }}'
                    route = route.replace(":id", id)
                    return route
                },
                assignInterviews: function(id) {
                    let route = '{{ route("asignar-encuestas.asignar", [":id_user", ":id"]) }}'
                    route = route.replace(":id_user", this.conected_user)
                    route = route.replace(":id", id)
                    return route
                },
                clearInputs: function(event) {
                    console.log('limpiando campos...')
                    this.user_code = ''
                    this.name = ''
                    this.email= ''
                }
            },
            computed: {
                listaFiltro() {
                    let filtro = this.lista_encuestadores
                    
                    if(this.user_code != '') {
                        filtro = filtro.filter(element=>element.user_code.toLowerCase().includes(this.user_code.toLowerCase()))
                    }

                    if(this.name != '') {
                        filtro = filtro.filter(element=>element.name.toLowerCase().includes(this.name.toLowerCase()))
                    }

                    if(this.email != '') {
                        filtro = filtro.filter(element=>element.email.toLowerCase().includes(this.email.toLowerCase()))
                    }

                    return filtro
                }
            }
        })
    </script>
@endsection