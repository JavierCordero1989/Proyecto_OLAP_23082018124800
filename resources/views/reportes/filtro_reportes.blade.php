@extends('layouts.app')

@section('title', 'Filtro')

@section('css')

@endsection

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
                
                <!-- Caja para los checkbox para los sectores -->
                <div class="col-xs-2">
                    <h3>Sector</h3>
                    <div class="col-xs-12">
                        <div class="checkbox">
                            <label class="label-text">
                                <input id="seleccionar_sectores" type="checkbox" name="sector[]" value="1">
                                Todos
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="label-text">
                                <input type="checkbox" name="sector[]" value="2">
                                Público
                            </label>
                        </div>

                        <div class="checkbox">
                            <label class="label-text">
                                <input type="checkbox" name="sector[]" value="3">
                                Privado
                            </label>
                        </div>                        
                    </div>
                </div>
                <!-- ./Caja para los checkbox para los sectores -->

                <!-- Caja para los checkbox para las universidades -->
                <div id="contenedor_universidades" class="col-xs-3 hide">
                    <h3>Universidades</h3>
                    <div id="contenedor-general-universidades" class="col-xs-12">
                    </div>
                </div>
                <!-- ./Caja para los checkbox para las universidades -->

                <!-- Caja para los checkbox para las áreas -->
                <div id="contenedor_areas" class="col-xs-3 hide">
                    <h3>Áreas</h3>
                    <div id="contenedor-general-areas" class="col-xs-12">
                    </div>
                </div>
                <!-- ./Caja para los checkbox para las áreas -->

                <div id="contenedor_disciplinas" class="col-xs-3 hide">
                    <h3>Disciplinas</h3>
                    <div id="contenedor_general_disciplinas" class="col-xs-12">
                        
                    </div>
                </div>

            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
        <!-- Script para eventos -->
    <script>
        // Carga los eventos a cada checkbox
        $(document).ready(function() {
            $('[name="sector[]"]').on('click', function() {
                evento_sectores($(this));
            });
        });

        function evento_sectores(check_seleccionado) {
            var valor_check = check_seleccionado.attr('value');
            var valor_checkeado = check_seleccionado.prop('checked');
            var grupo_checks = $('[name="sector[]"]');

            //Check de TODOS
            if(valor_check == 1) {
                $(grupo_checks).prop('checked', valor_checkeado);
            }

            // Check para sector PÚBLICO
            if(valor_check == 2) {
                if(false == check_seleccionado.prop('checked')) {
                    $('#seleccionar_sectores').prop('checked', false);
                }

                if($('[name="sector[]"]:checked').length == $(grupo_checks).length-1) {
                    $("#seleccionar_sectores").prop('checked', true);
                }
            }

            // Check para sector PRIVADO
            if(valor_check == 3) {
                if(false == check_seleccionado.prop('checked')) {
                    $('#seleccionar_sectores').prop('checked', false);
                }

                if($('[name="sector[]"]:checked').length == $(grupo_checks).length-1) {
                    $("#seleccionar_sectores").prop('checked', true);
                }
            }

            //Se crea un arreglo para guardar los IDS seleccionados.
            var valores_checks = [];

            //Se recorre el grupo de checks y se comprueba los que están seleccionados.
            grupo_checks.each(function() {
                if(this.checked) {
                    // Se agrega el valor del check al arreglo.
                    valores_checks.push($(this).val());
                }
            });

            //Envío de datos al controlador para procesarlos.
            $.ajax({
                cache: false,
                type: 'get',
                dataType: 'json',
                data: {
                    valores:valores_checks
                },
                url: '{{ route("universidades.sector") }}',
                success: function(respuesta) {

                    // Se vacía el contenedor
                    $('#contenedor-general-universidades').html('');
                    $('#contenedor-general-areas').html('');

                    if(respuesta.datos_obtenidos.length <= 0) {
                        $('#contenedor_universidades').addClass('hide');
                        $('#contenedor_universidades').removeClass('show');
                        $('#contenedor_areas').addClass('hide');
                        $('#contenedor_areas').removeClass('show');
                        $('#contenedor_disciplinas').addClass('hide');
                        $('#contenedor_general_disciplinas').removeClass('show');
                    }
                    else {
                        cargarUniversidades(respuesta.datos_obtenidos);
                        cargarAreas(respuesta.areas);
                    }
                    
                },
                error: function(jqXHR, respuesta_servidor, errorThrown) {
                    alert("AJAX error: " + respuesta_servidor + ' : ' + errorThrown);
                }
            });
        }

        //Llena la caja con los datos de las universidades que se seleccionaron.
        function cargarUniversidades(data) {

            //se muestra lo que trae el objeto data
            $('#contenedor_universidades').removeClass('hide');
            $('#contenedor_universidades').addClass('show');

            $('#contenedor-general-universidades').append(
                '<div class="checkbox">'+
                    '<label>'+
                        '<input type="checkbox" id="seleccionar_universidades" name="universidades[]" value="0">'+
                        'Todas'+
                    '</label>'+
                '</div>'
                // '<input type="checkbox" id="seleccionar_universidades" name="universidades[]" value="0"> Todas <br>'
            );
            
            //Se recorre el objeto data, para mostrar su información en la caja de las universidades
            data.forEach(function(element) {
                $('#contenedor-general-universidades').append(
                    '<div class="checkbox">'+
                        '<label>'+
                            '<input type="checkbox" name="universidades[]" value="'+element.id+'">'+
                            element.nombre+
                        '</label>'+
                    '</div>'
                    // '<input type="checkbox" name="universidades[]" value="'+element.id+'"> '+element.nombre+'<br>'
                );
            });

            //Agregar eventos para los checks recién creados.
            $('[name="universidades[]"]').on('click', function() {
                evento_universidades($(this));
            });
        }

        function evento_universidades(check_seleccionado) {
            // console.log('Universidad: ', check_seleccionado.attr('value'));

            var grupo_checks = $('[name="universidades[]"]');
            
            if(check_seleccionado.attr('value') == 0) {
                $(grupo_checks).prop('checked', $(check_seleccionado).prop('checked'));
            }

            if(false == check_seleccionado.prop('checked')) {
                $('#seleccionar_universidades').prop('checked', false);
            }

            if($('[name="universidades[]"]:checked').length == $(grupo_checks).length-1) {
                $("#seleccionar_universidades").prop('checked', true);
            }
        }

        function cargarAreas(data) {
 
            //se muestra lo que trae el objeto data
            $('#contenedor_areas').removeClass('hide');
            $('#contenedor_areas').addClass('show');

            $('#contenedor-general-areas').append(
                '<div class="checkbox">'+
                    '<label class="label-text">'+
                        '<input type="checkbox" id="seleccionar_areas" name="areas[]" value="0">'+
                        'Todas'+
                    '</label>'+
                '</div>'
            );

            //Se recorre el objeto data, para mostrar su información en la caja de las áreas
            data.forEach(function(element) {
                $('#contenedor-general-areas').append(
                    '<div class="checkbox">'+
                        '<label class="label-text">'+
                            '<input type="checkbox" name="areas[]" value="'+element.codigo+'">'+
                            element.descriptivo+
                        '</label>'+
                    '</div>'
                );
            });

            //Agregar eventos para los checks recién creados.
            $('[name="areas[]"]').on('click', function() {
                evento_areas($(this))
            });
        }

        function evento_areas(check_seleccionado) {
            console.log('Área: ', check_seleccionado.attr('value'));

            var grupo_checks = $('[name="areas[]"]');
            
            if(check_seleccionado.attr('value') == 0) {
                $(grupo_checks).prop('checked', $(check_seleccionado).prop('checked'));
            }

            if(false == check_seleccionado.prop('checked')) {
                $('#seleccionar_areas').prop('checked', false);
            }

            if($('[name="areas[]"]:checked').length == $(grupo_checks).length-1) {
                $("#seleccionar_areas").prop('checked', true);
            }

            //Se crea un arreglo para guardar los IDS seleccionados.
            var valores_checks = [];

            //Se recorre el grupo de checks y se comprueba los que están seleccionados.
            grupo_checks.each(function() {
                if(this.checked) {
                    // Se agrega el valor del check al arreglo.
                    valores_checks.push($(this).val());
                }
            });

            $.ajax({
                cache: false,
                type: 'get',
                dataType: 'json',
                data: {
                    valores:valores_checks
                },
                url: '{{ route("disciplinas.area") }}',
                success: function(respuesta) {
                    console.log('SUCCESS-DISCIPLINAS: ', respuesta);
                },
                error: function(jqXHR, respuesta_servidor, errorThrown) {
                    alert("ERROR: " + respuesta_servidor + ' : ' + errorThrown);
                    console.log('ERROR: ', jqXHR.status);
                }
            });
        }
    </script>
@endsection