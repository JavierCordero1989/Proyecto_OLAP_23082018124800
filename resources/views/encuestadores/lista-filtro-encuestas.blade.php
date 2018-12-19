@extends('layouts.app')

@section('title', 'Búsqueda') 

@section('content')
    <section class="content-header">
        <h1>
            Ingrese los filtros que desea para la muestra
        </h1>
    </section>

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['asignar-encuestas.filtrar-muestra', 'id_supervisor'=>$id_supervisor,'id_encuestador'=>$id_encuestador], 'onsubmit'=>'return validar_submit();']) !!}
                        {{-- <div class="form-group col-sm-6">
                            {!! Form::label('carrera', 'Carreras:') !!}
                            {!! Form::select('carrera', $datos_carrera['carreras'], null, ['class' => 'form-control', 'placeholder'=>'Elija una carrera']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('universidad', 'Universidad:') !!}
                            {!! Form::select('universidad', $datos_carrera['universidades'], null, ['class' => 'form-control', 'placeholder'=>'Elija una universidad']) !!}
                        </div> --}}

                        <div class="form-group col-sm-6">
                            {!! Form::label('agrupacion', 'Agrupación:') !!}
                            {!! Form::select('agrupacion', config('options.group_types'), null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('grado', 'Grado:') !!}
                            {!! Form::select('grado', config('options.grade_types'), null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('area', 'Área:') !!}
                            {!! Form::select('area', $datos_carrera['areas'], null, ['class' => 'form-control', 'placeholder'=>'Elija un área', 'id'=>'area']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('disciplina', 'Disciplina:') !!}
                            <select class="form-control" name="disciplina" id="disciplina">
                                <option value="">Elija una disciplina</option>
                            </select>
                            {{-- {!! Form::select('disciplina', $datos_carrera['disciplinas'], null, ['class' => 'form-control', 'placeholder'=>'Elija una disciplina']) !!} --}}
                        </div>

                        {{-- <div class="form-group col-sm-6">
                            {!! Form::label('sector', 'Sector:') !!}
                            {!! Form::select('sector', $datos_carrera['sectores'], null, ['class' => 'form-control', 'placeholder'=>'Elija un sector']) !!}
                        </div> --}}

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
                            @if ($rol_usuario == 'Encuestador')
                                <a href="{!! route('encuestadores.index') !!}" class="btn btn-default">Cancelar</a> 
                            @endif
                            @if ($rol_usuario == 'Supervisor')
                                <a href="{!! route('supervisores.index') !!}" class="btn btn-default">Cancelar</a> 
                            @endif
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#area').on('change', function() {
            let value = $(this).val()
            if(value != "") {
                // llenar el select con las disciplinas seleccionadas
                let lista = obtenerDisciplinas(value)
            }
            else {
                // vaciar el select
                console.log("No ha seleccionado nada");
            }
        });


        function obtenerDisciplinas(area) {
            
            let url = '{{ route("disciplinas.axios", ":id") }}'
            url = url.replace(":id", area)

            axios.get(url).then(response => {
                let disciplinas = response.data

                $('#disciplina').empty()
                $('#disciplina').append('<option value="">Elija una disciplina</option>')
                
                $.each(disciplinas, function(index, item) {
                    $.each(item, function(a,b) {
                        $('#disciplina').append('<option value="'+b.id+'">'+b.nombre+'</option>')
                    })
                })
                //cargar el select
            }); 
        }

        function validar_submit() {

            //Reune todos los select del formulario en un array
            var form_data = [
                // $('#carrera').val(),
                // $('#universidad').val(),
                $('#grado').val(),
                $('#disciplina').val(),
                $('#area').val(),
                $('#agrupacion').val(),
                // $('#sector').val()
            ];

            //Inicia un contador para ver cuantos valores hay en blanco
            var contador = 0;

            //Recorre el array con los datos del formulario, y cuenta los que estan vacios
            
            form_data.forEach( function(data) { 
                if(data.length == 0) {
                    contador++;
                }
            });

            //Si hay 7 o mas datos vacios, no permitirá que el formulario continue
            if(contador >= 7) {
                alert('Debe elegir una opcion del filtro al menos para continuar');
                return false;
            }
            else {
                return true;
            }
        }
    </script>
@endsection

