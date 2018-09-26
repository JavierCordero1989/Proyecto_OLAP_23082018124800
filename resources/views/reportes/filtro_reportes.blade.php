@extends('layouts.app')

@section('title', 'Filtro')

@section('content')
    {!! Form::open(['route'=>'reportes.filtro-encuestas']) !!}
        <section class="content-header">
            <h1 class="pull-left">
                {!! Form::submit('Generar reporte', ['class' => 'btn btn-primary']) !!}
            </h1>
        </section>

        <div class="clearfix"></div>

        <div class="content">
            <div class="row">
                
                <div class="col-xs-3">
                    <h3>Sector</h3>
                    <div class="col-xs-12">
                        <input type="checkbox" name="sector[]" value="1"> Todos
                        <br>
                        <input type="checkbox" name="sector[]" value="2"> Público
                        <br>
                        <input type="checkbox" name="sector[]" value="3"> Privado
                    </div>
                </div>

                <div id="contenedor_universidades" class="col-xs-3 hide">
                    <h3>Universidad</h3>
                    <div id="contenedor-general-universidades" class="col-xs-12 hide">

                    </div>
                    {{-- <div id="contenedor_publicas" class="col-xs-12 hide">

                    </div>
                    <div id="contenedor_privadas" class="col-xs-12 hide">

                    </div> --}}
                </div>

                <div id="contenedor_areas" class="col-xs-3 hide">
                    <h3>Área</h3>
                    <div id="areas" class="col-xs-12">
                    </div>
                </div>

            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        // Carga los eventos a cada checkbox
        $(document).ready(function() {
            $('[name="sector[]"]').on('click', function() {
                evento_sectores($(this));
            });

            $('[name="universidad[]"]').on('click', function() {
                evento_universidades($(this));
            });

            $('[name="areas[]"]').on('click', function() {
                evento_areas($(this))
            });
        });

        function evento_sectores(check_seleccionado) {
            // Comprueba que fue seleccionado el check TODOS
            if(check_seleccionado.attr('value') == 1) {
                // Si esta checkeado, se activan los demás, si no se desactivan
                if(check_seleccionado.is(':checked')) {
                    grupo_checks = $('[name="sector[]"]');
                    $(grupo_checks).prop("checked", true);
                }
                else {
                    grupo_checks = $('[name="sector[]"]');
                    $(grupo_checks).prop("checked", false);
                }
            }

            if(check_seleccionado.is(':checked')) {
                $.ajax({
                    data: {
                        check_id : check_seleccionado.attr('value')
                    },
                    url: '{{ route("universidades.sector") }}',
                    type: 'GET',
                    success: function(respuesta_servidor) {
                        console.log(respuesta_servidor.msj);
                        console.log(respuesta_servidor.uni);

                        $('#contenedor_universidades').removeClass('hide');
                        $('#contenedor-general-universidades').removeClass('hide');
                        $('#contenedor-general-universidades').html('');

                        var datos_universidades = respuesta_servidor.uni;
                        datos_universidades.forEach(function(universidad) {
                            $('#contenedor-general-universidades').append('<input type="checkbox" name="universidades[]" value="'+universidad.id+'"> '+universidad.nombre+'<br>');
                        });

                        
                    },
                    error: function(jqXHR, respuesta_servidor, errorThrown) {
                        alert("AJAX error: " + respuesta_servidor + ' : ' + errorThrown);
                    }
                });
            }
            else {
                $('#contenedor_universidades').removeClass('show');
                $('#contenedor_universidades').addClass('hide');
                $('#contenedor-general-universidades').removeClass('show');
                $('#contenedor-general-universidades').addClass('hide');
                $('#contenedor-general-universidades').html('');
            }
        }

        function evento_universidades(check_seleccionado) {
            console.log('Universidad: ', check_seleccionado.attr('value'));
        }

        function evento_areas(check_seleccionado) {
            console.log('Área: ', check_seleccionado.attr('value'));
        }
    </script>
@endsection