@extends('layouts.app')

@section('title', 'Filtro')

@section('css')
    <style>
        #menu_sector > li > ul, #menu_areas > li > ul {
            background-color: #ECF0F5;
        }

        #menu_sector > li.active > a, #menu_areas > li.active > a {
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
                
                <!-- Caja para los checkbox para las universidades separadas por sector -->
                <div class="col-xs-6">
                    <h3 class="text-center">
                        <label class="label-text">
                            <input type="checkbox" name="todos_los_sectores" id="todos_los_sectores" value="todos_los_sectores"> Sector
                        </label>
                    </h3>
                    <div class="col-xs-12">
                        <section class="sidebar">
                            <ul id="menu_sector" class="sidebar-menu">

                                <!-- Para las universidades publicas -->
                                <li class="treeview">
                                    <a href="#">
                                        <span>Público</span>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="checkbox">
                                            <label class="label-text">
                                                <input type="checkbox" name="universidades[]" value="publico"> Todas
                                            </label>
                                        </li>
                                        @foreach ($universidades_publicas as $universidad)
                                            <li class="checkbox">
                                                <label class="label-text">
                                                    <input type="checkbox" name="universidades[]" value="{!! $universidad->codigo !!}"> {!! $universidad->nombre !!}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <!-- ./ Para las universidades publicas -->

                                <!-- Para las universidades privadas -->
                                <li class="treeview">
                                    <a href="#">
                                        <span>Privado</span>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="checkbox">
                                            <label class="label-text">
                                                <input type="checkbox" name="universidades[]" value="privado"> Todas
                                            </label>
                                        </li>
                                        @foreach ($universidades_privadas as $universidad)
                                            <li class="checkbox">
                                                <label class="label-text">
                                                    <input type="checkbox" name="universidades[]" value="{!! $universidad->codigo !!}"> {!! $universidad->nombre !!}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <!-- ./ Para las universidades privadas -->

                            </ul>
                        </section>
                    </div>
                </div>
                <!-- ./Caja para los checkbox para las universidades separadas por sector -->

                <!-- Caja para los checkbox para las áreas -->
                <div id="contenedor_areas" class="col-xs-6">
                    <h3 class="text-center">
                        <label class="label-text">
                            <input type="checkbox" name="todas_las_areas" id="todas_las_areas" value="todas_las_areas"> Áreas
                        </label>
                    </h3>
                    <div id="contenedor-general-areas" class="col-xs-12">
                        <section class="sidebar">
                            <ul id="menu_areas" class="sidebar-menu">
                                <!-- LI para cara área -->
                                {{-- Se recorren todas las areas para agregarlas a la vista --}}
                                @foreach ($areas as $area) 
                                    <li class="treeview">
                                        <a href="#">
                                            <span>{!! $area->descriptivo !!}</span>
                                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li class="checkbox">
                                                <label class="label-text">
                                                    <input type="checkbox" name="areas[]" value="{!! $area->descriptivo !!}"> Todas
                                                </label>
                                            </li>
                                            {{-- Se recorren todas las disciplinas por area para agregarlas a la vista --}}
                                            @foreach ($area->disciplinas as $disciplina)
                                                <li class="checkbox">
                                                    <label class="label-text">
                                                        <input type="checkbox" name="areas[]" value="{!! $disciplina->codigo !!}"> {!! $disciplina->descriptivo !!}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
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
        var universidades = $('[name="universidades[]"]');
        var areas = $('[name="areas[]"]');

        // Carga los eventos a cada checkbox
        $(document).ready(function() {
            $('#todos_los_sectores').on('click', function() {
                $(universidades).prop('checked', $(this).prop('checked'));
            });

            $('#todas_las_areas').on('click', function() {
                $(areas).prop('checked', $(this).prop('checked'));
            });

            $('[name="universidades[]"]').on('click', function() {
                evento_universidades($(this))
            });

            $('[name="areas[]"]').on('click', function() {
                evento_areas($(this))
            });
        });

        function evento_areas(check_seleccionado) {

            // console.log(check_seleccionado.attr('value'));

            // Se obtiene todo el grupo del check que ha sido seleccionado.
            var grupo_checks = (check_seleccionado.parents('ul.treeview-menu')).find('input');
            // console.log($(grupo_checks[0]).attr('value'));

            // Si el check que se seleccionó no se puede pasar a decimal.
            if(isNaN(check_seleccionado.attr('value'))) {
                $(grupo_checks).prop('checked', $(check_seleccionado).prop('checked'));
            }
            
            // Si el check seleccionado cambia a falso, se deselecciona el de TODAS
            if(false == check_seleccionado.prop('checked')) {
                $(grupo_checks[0]).prop('checked', false);
                $('#todas_las_areas').prop('checked', false);
            }

            var areas_check = 0;
            areas.each(function() {
                if($(this).prop('checked')) { areas_check++; }
            });

            if(areas_check == $(areas).length-1) {
                $('#todas_las_areas').prop('checked', true);
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

        function evento_universidades(check_seleccionado) {

            // Se obtiene todo el grupo del check que ha sido seleccionado.
            var grupo_checks = (check_seleccionado.parents('ul.treeview-menu')).find('input');
            // console.log($(grupo_checks[0]).attr('value'));

            // Si el check que se seleccionó no se puede pasar a decimal.
            if(isNaN(check_seleccionado.attr('value'))) {
                $(grupo_checks).prop('checked', $(check_seleccionado).prop('checked'));
            }
            
            // Si el check seleccionado cambia a falso, se deselecciona el de TODAS
            if(false == check_seleccionado.prop('checked')) {
                $(grupo_checks[0]).prop('checked', false);
                $('#todos_los_sectores').prop('checked', false);
            }

            // Se cuentan los checkbox que estén seleccionados.
            var checkeados = 0;
            grupo_checks.each(function() {
                if($(this).prop('checked')) { checkeados++; }
            });

            var universidades_check = 0;
            universidades.each(function() {
                if($(this).prop('checked')) { universidades_check++; }
            });

            if(universidades_check == $(universidades).length-1) {
                $('#todos_los_sectores').prop('checked', true);
            }

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
            var cuenta_universidades = 0; // Inicia un contador para validar si un sector se seleccionó
            
            // Cuenta los checkbox de disciplinas marcados
            $('[name="universidades[]"]').each(function() {
                if($(this).prop('checked')) { cuenta_universidades++; }
            });

            // Si la cuenta resulta ser cero o menor, se mostrará una alerta
            if(cuenta_universidades <= 0) {
                alert('Debe seleccionar una universidad');
                return false;
            }

            var cuenta_areas = 0; // Inicia un contador para validar si una universidad se seleccionó

            // Cuenta los checkbox de areas marcados
            $('[name="areas[]"]').each(function() {
                if($(this).prop('checked')) { cuenta_areas++; }
            });

            // Si la cuenta resulta ser cero o menor, se mostrará una alerta
            if(cuenta_areas <= 0) {
                alert('Debe seleccionar una disciplina al menos.');
                return false;
            }

            // Si todo está en regla, puede enviar el formulario
            return true;
        }
    </script>
@endsection