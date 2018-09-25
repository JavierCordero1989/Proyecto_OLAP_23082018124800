@extends('layouts.app')

@section('title', 'Filtro')

@section('content')
    {{-- <section class="content-header">
        <h1 class="pull-left">
            <a class="btn btn-primary pull-left" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('reportes.filtro-encuestas') !!}">Generar reporte</a>
        </h1>
    </section> --}}

    <div class="clearfix"></div>

    <div class="content">
        {!! Form::open(['route'=>'reportes.filtro-encuestas']) !!}
            <div class="row">
                <div class="col-xs-6">
                    <h3>Áreas</h3>
                    <div class="col-xs-12">
                        @foreach($areas as $area)
                            {!! Form::checkbox('areas[]', $area->id) !!} {!! $area->descriptivo !!} <br>
                        @endforeach
                    </div>
                </div>

                <div class="col-xs-6">
                    <h3>Disciplinas</h3>
                    <div id="disciplina" class="col-xs-12">
                        {{-- @foreach($disciplinas as $disciplina)
                            {!! Form::checkbox('disciplinas[]', $disciplina->id) !!} {!! $disciplina->descriptivo !!} <br>
                        @endforeach --}}
                    </div>
                </div>

                <div class="col-xs-12" style="margin-top: 15px;">
                    {!! Form::submit('Generar reporte', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script>
        //Varibale con las disciplinas obtenidas de la BD
        var disciplinas = <?php echo json_encode($disciplinas); ?>;

        $("input:checkbox").on('click', function() {
            // en el manejador, 'this' se refiere al checkbox que disparó el evento
            var $box = $(this);

            if ($box.is(":checked")) {
                /* Se selecciona todo el grupo de checkbox que tenga el mismo atributo name */
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                /* Todos los checks se ponen en un estado de seleccionado en falso */
                $(group).prop("checked", false);
                /* Se pone el estado del check selccionado en verdadero */
                $box.prop("checked", true);

                var value = $box.attr("value");
                caja_disciplina = $('#disciplina');
                caja_disciplina.html('');

                disciplinas.forEach(function(disc) {
                    if(disc.id_area == value) {
                        console.log(disc);
                        
                        caja_disciplina.append('<input name="disciplinas[]" type="checkbox" value="'+disc.id+'"> '+disc.descriptivo+'<br>');
                    }
                });
                
            } else {
                $box.prop("checked", false);
            }
        });
    </script>
@endsection