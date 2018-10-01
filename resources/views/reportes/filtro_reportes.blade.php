@extends('layouts.app')

@section('title', 'Filtro')

@section('css')
    <style>
        #menu_areas > li > ul {
            background-color: #ECF0F5;
        }

        #menu_areas > li.active > a {
            border-left-color: var(--color-azul-oscuro);
        }
    </style>
@endsection

@section('content')
    {!! Form::open(['route'=>'reportes.filtro-encuestas', 'onsubmit'=>'return validar_form();']) !!}
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
                <div id="contenedor_universidades" class="col-xs-5 hide">
                    <h3>Universidades</h3>
                    <div id="contenedor-general-universidades" class="col-xs-12">
                    </div>
                </div>
                <!-- ./Caja para los checkbox para las universidades -->

                <!-- Caja para los checkbox para las áreas -->
                <div id="contenedor_areas" class="col-xs-4 hide">
                    <h3>Áreas</h3>
                    <div id="contenedor-general-areas" class="col-xs-12">
                        <section class="sidebar">
                            <ul id="menu_areas" class="sidebar-menu">
                                <!-- Aquí irán todas las áreas con sus respectivas disciplinas -->
                            </ul>
                        </section>
                    </div>
                </div>
                <!-- ./Caja para los checkbox para las áreas -->

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
                    $('#menu_areas').html('');

                    if(respuesta.datos_obtenidos.length <= 0) {
                        $('#contenedor_universidades').addClass('hide');
                        $('#contenedor_universidades').removeClass('show');
                        $('#contenedor_areas').addClass('hide');
                        $('#contenedor_areas').removeClass('show');
                    }
                    else {
                        cargarUniversidades(respuesta.datos_obtenidos);
                        cargarAreas(respuesta.disciplinas);
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

            var menu = $('#menu_areas'); // Contenedor de las áreas del menú.

            for(var nombre_area in data) {
                var li = $('<li>', {
                    'class': 'treeview'
                }).appendTo(menu);

                var a = $('<a>', {
                    'href': '#'
                }).appendTo(li);

                $('<span>', {
                    'text': nombre_area
                }).appendTo(a);

                var span_2 = $('<span>', {
                    'class': 'pull-right-container'
                }).appendTo(a);
                
                $('<i>', {
                    'class': 'fa fa-angle-left pull-right'
                }).appendTo(span_2);
                
                var ul = $('<ul>', {
                    'class': 'treeview-menu'
                }).appendTo(li);

                var li_todos = $('<li>', {
                    'class': 'checkbox'
                }).appendTo(ul);

                var label_todos = $('<label>', {
                    'class': 'label-text'
                }).appendTo(li_todos);

                label_todos.append('<input type="checkbox" name="disciplinas[]" value="'+nombre_area+'"> Todas');

                for(var disciplina in data[nombre_area]) {
                    var sub_li = $('<li>', {
                        'class': 'checkbox'
                    }).appendTo(ul);

                    var label_check = $('<label>', {
                        'class': 'label-text'
                    }).appendTo(sub_li);
                    
                    label_check.append('<input type="checkbox" name="disciplinas[]" value="'+(data[nombre_area])[disciplina].codigo+'"> '+(data[nombre_area])[disciplina].descriptivo);
                }
            }

            // Agregar eventos para los checks recién creados.
            $('[name="disciplinas[]"]').on('click', function() {
                evento_areas($(this))
            });
        }

        function evento_areas(check_seleccionado) {
            // var valor = check_seleccionado.attr('value');
            
            // if(isNaN(check_seleccionado.attr('value'))) {
            //     console.log('Seleccionó todos');

            //     var padre = check_seleccionado.parents('ul.treeview-menu');
            //     var hijos = padre.find('input');

            //     console.log('Área: ', valor);
            //     console.log('Padre: ', padre);
            //     console.log('Hijos: ', hijos);
            // }

            // Se obtiene todo el grupo del check que ha sido seleccionado.
            var grupo_checks = (check_seleccionado.parents('ul.treeview-menu')).find('input');
            console.log($(grupo_checks[0]).attr('value'));

            // Si el check que se seleccionó no se puede pasar a decimal.
            if(isNaN(check_seleccionado.attr('value'))) {
                $(grupo_checks).prop('checked', $(check_seleccionado).prop('checked'));
            }
            
            // Si el check seleccionado cambia a falso, se deselecciona el de TODAS
            if(false == check_seleccionado.prop('checked')) {
                $(grupo_checks[0]).prop('checked', false);
            }

            // Se cuentan los checkbox que estén seleccionados.
            var checkeados = 0;
            grupo_checks.each(function() {
                if($(this).prop('checked')) { checkeados++; }
            });

            // Si el total de chequeados coincide con el total de checkbox - 1,
            // se vuelve a marcar el de TODAS
            if(checkeados == $(grupo_checks).length-1) {
                $(grupo_checks[0]).prop('checked', true);
            }
        }

        /** 
         * Valida el formulario para que pueda o no ser acpetado
         * @returns Verdadero si todo está correcto.
        */
        function validar_form() {
            var cuenta_sector = 0; // Inicia un contador para validar si un sector se seleccionó
            
            // Cuenta los checkbox de sector marcados
            $('[name="sector[]"]').each(function() {
                if($(this).prop('checked')) { cuenta_sector++; }
            });

            // Si la cuenta resulta ser cero o menor, se mostrará una alerta
            if(cuenta_sector <= 0) {
                alert('Debe seleccionar un sector');
                return false;
            }

            var cuenta_universidades = 0; // Inicia un contador para validar si una universidad se seleccionó

            // Cuenta los checkbox de universidad marcados
            $('[name="universidades[]"]').each(function() {
                if($(this).prop('checked')) { cuenta_universidades++; }
            });

            // Si la cuenta resulta ser cero o menor, se mostrará una alerta
            if(cuenta_universidades <= 0) {
                alert('Debe seleccionar una universidad al menos');
                return false;
            }

            var cuenta_disciplinas = 0; // Inicia un contador para validar si una disciplina se seleccionó

            // Cuenta los checkbox de disciplinas marcados
            $('[name="disciplinas[]"]').each(function() {
                if($(this).prop('checked')) { cuenta_disciplinas++; }
            });

            // Si la cuenta resulta ser cero o menor, se mostrará una alerta
            if(cuenta_disciplinas <= 0) {
                alert('Debe seleccionar una disciplina al menos.');
                return false;
            }

            // Si todo está en regla, puede enviar el formulario
            return true;
        }
    </script>
@endsection