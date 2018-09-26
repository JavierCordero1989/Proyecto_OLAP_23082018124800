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

                <div id="contenedor_universidades" class="col-xs-3">
                    <h3>Universidad</h3>
                    <div id="contenedor_publicas" class="col-xs-12">
                        <input type="checkbox" name="universidad[]" value="1"> UCR
                        <br> 
                        <input type="checkbox" name="universidad[]" value="2"> UNA
                        <br> 
                        <input type="checkbox" name="universidad[]" value="3"> ITCR
                        <br>  
                        <input type="checkbox" name="universidad[]" value="4"> UNED
                        <br> 
                        <input type="checkbox" name="universidad[]" value="5"> UTN
                    </div>
                    <div id="contenedor_privadas" class="col-xs-12">
                        <input type="checkbox" name="universidad[]" value="6"> ULACIT
                        <br>
                        <input type="checkbox" name="universidad[]" value="7"> UCIMED
                        <br>
                        <input type="checkbox" name="universidad[]" value="8"> UMCA
                        <br>
                        <input type="checkbox" name="universidad[]" value="9"> U SJ
                        <br>
                        <input type="checkbox" name="universidad[]" value="10"> XXX
                    </div>
                </div>

                <div id="contenedor_areas" class="col-xs-3">
                    <h3>Área</h3>
                    <div class="col-xs-12">
                        <input type="checkbox" name="areas[]" value="1"> Area 1
                        <br>
                        <input type="checkbox" name="areas[]" value="2"> Area 2
                        <br>
                        <input type="checkbox" name="areas[]" value="3"> Area 3
                        <br>
                        <input type="checkbox" name="areas[]" value="4"> Area 4
                        <br>
                        <input type="checkbox" name="areas[]" value="5"> Area 5
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

            
            $.ajax({
                data: {
                    check_id : check_seleccionado.attr('value')
                },
                url: '{{ route("universidades.sector") }}',
                type: 'GET',
                success: function(respuesta_servidor) {
                    console.log(respuesta_servidor.msj);
                },
                error: function(jqXHR, respuesta_servidor, errorThrown) {
                    alert("AJAX error: " + respuesta_servidor + ' : ' + errorThrown);
                }
            });
        }

        function evento_universidades(check_seleccionado) {
            console.log('Universidad: ', check_seleccionado.attr('value'));
        }

        function evento_areas(check_seleccionado) {
            console.log('Área: ', check_seleccionado.attr('value'));
        }
    </script>
@endsection