@extends('layouts.app')

@section('title', 'Encuestadores') 

@section('content')
    <div id="app">
        <section class="content-header">
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
                    @include('encuestas_graduados.New_table')
                </div>
            </div>
            {{-- <div class="text-center">
            
            </div> --}}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
    <script>
        let lista = <?php echo json_encode($encuestas); ?>

        new Vue({
            el: '#app',
            data: {
                lista_encuestas: lista
            },
            methods: {
                eventoEliminar: function(evento) {
                    if(!confirm('¿Desea eliminar el registro de todas formas?')) {
                        evento.preventDefault()
                    }
                }
            }
        })
    </script>
@endsection

