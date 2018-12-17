@extends('layouts.app')

@section('title', 'Encuestadores') 

@section('content')
    <div id="app">
        <section class="content-header">
            <div class="row">
                <div class="panel-body">
                    <div class="col-xs-12 col-sm-12">
                        <h1 class="pull-left">
                            {!! Form::button('<i class="fas fa-search"></i> Buscar...', [
                                'type'=>'submit',
                                'class'=>'btn btn-default pull-left',
                                'style'=>'margin-top: -10px;margin-bottom: 5px',
                                'onclick' => 'eventoForm()'
                            ]) !!}

                            <button id="btn-show" style="margin-top: -10px;margin-bottom: 5px;" class="btn btn-info pull-left" data-toggle="collapse" data-target="#panel-collapse">
                                {{-- <i class="fas fa-sort-up"></i> --}}
                                <i class="fas fa-sort-down" data-toggle="tooltip" title="Pulse para ver los campos de búsqueda" data-placement="top"></i>
                            </button>

                            <a href="{!! route('encuestas-graduados.index') !!}" style="margin-top: -10px;margin-bottom: 5px;" class="btn btn-primary pull-left" data-toggle="tooltip" title="Pulse para limpiar la búsqueda" data-placement="bottom">
                                <i class="fas fa-brush"></i>
                            </a>

                            @if (Auth::user()->hasRole(['Super Admin', 'Supervisor 1']))
                                <a href="{!! route('excel.descargar-filtro-encuestas') !!}" class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px;" data-toggle="tooltip" title="Pulse para descargar" data-placement="bottom">
                                    <i class="fas fa-file-excel"></i>
                                    Descargar
                                </a>
                            @endif
                        </h1>
                        {{-- <h1 class="pull-left">Lista de encuestas</h1> --}}
                        @if (Auth::user()->hasRole('Super Admin'))
                            <h1 class="pull-right">
                                <a id="btn-search" class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('encuestas-graduados.create') !!}">Agregar nueva</a>
                            </h1>
                        @endif
                    </div>
                </div>

                <div id="panel-collapse" class="collapse">
                    {!! Form::model(Request::all(), ['route'=>'encuestas-graduados.filtro', 'id'=>'form-filtro', 'method'=>'GET']) !!}
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-3">
                                <input type="text" name="identificacion_graduado" id="identificacion_graduado" class="form-control" placeholder="Identificación...">
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" placeholder="Nombre...">
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                {!! Form::select('sexo', config('options.sex_types'), null, ['class'=>'form-control', 'id'=>'sexo']) !!}
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <input type="text" name="codigo_carrera" id="codigo_carrera" class="form-control" placeholder="Carrera...">
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-3">
                                <input type="text" name="codigo_universidad" id="codigo_universidad" class="form-control" placeholder="Universidad...">
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                {!! Form::select('codigo_agrupacion', config('options.group_types'), null, ['class'=>'form-control', 'id'=>'codigo_agrupacion']) !!}
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                {!! Form::select('codigo_grado', config('options.grade_types'), null, ['class'=>'form-control', 'id'=>'codigo_grado']) !!}
                                {{-- <input type="text" name="codigo_grado" id="codigo_grado" class="form-control" placeholder="Grado..."> --}}
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                <input type="text" name="codigo_area" id="codigo_area" class="form-control" placeholder="Área...">
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-3">
                                <input type="text" name="codigo_disciplina" id="codigo_disciplina" class="form-control" placeholder="Disciplina...">
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                {!! Form::select('tipo_de_caso', config('options.case_types'), null, ['class'=>'form-control', 'id'=>'tipo_de_caso']) !!}
                            </div>
                            {{-- TODO --}}
                            <div class="col-xs-12 col-sm-3">
                                {!! Form::select('estado', config('options.survey_estatuses'), null, ['class'=>'form-control', 'id'=>'estado']) !!}
                                {{-- {!! Form::text('estado', null, ['class'=>'form-control', 'placeholder'=>'Estado...']) !!} --}}
                            </div>
                            <div class="col-xs-12 col-sm-3">
                                {!! Form::text('contacto', null, ['class'=>'form-control', 'placeholder'=>'Número o Correo', 'id'=>'contacto']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
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
    <script>

        $('#flash-overlay-modal').modal();

        $('.btn-danger').on('click', function(evento){
            if(!confirm('¿Desea eliminar el registro de todas formas?')) {
                evento.preventDefault();
            }
        });

        function eventoForm(evento) {
            if($('#btn-show').find('i').hasClass('fa-sort-down') && verificarBlancos()){
                alert('Despliegue los campos de búsqueda');
            }
            else if(verificarBlancos()) {
                alert('Al menos debe ingresar un valor en alguno de los campos de búsqueda');
            }
            else {
                $('#form-filtro').submit();
            }
        }

        $('#btn-show').on('click', function(event) {
            $('#btn-show').find('i').toggleClass('fa-sort-up fa-sort-down');
        });

        function verificarBlancos() {
            let datos = [];

            datos.push($('#identificacion_graduado').val().trim());
            datos.push($('#nombre_completo').val().trim());
            datos.push($('#sexo').val().trim());
            datos.push($('#codigo_carrera').val().trim());
            datos.push($('#codigo_universidad').val().trim());
            datos.push($('#codigo_agrupacion').val().trim());
            datos.push($('#codigo_grado').val().trim());
            datos.push($('#codigo_disciplina').val().trim());
            datos.push($('#codigo_area').val().trim());
            datos.push($('#tipo_de_caso').val().trim());
            datos.push($('#estado').val().trim());
            datos.push($('#contacto').val().trim());

            // TODO: campos de estado y contacto
            let contador = 0;

            datos.forEach(element=>{
                if(element == ''){
                    contador++;
                }
            });

            if(contador == datos.length) {
                return true;
            }

            return false;
        }
    </script>
@endsection

