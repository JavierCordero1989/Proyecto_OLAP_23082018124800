{{-- <li class="{{ Request::is('supervisor/2/encuestadores/lista-de-encuestadores') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-de-encuestadores') !!}"><i class="fas fa-check"></i><span> Ver encuestadores</span></a>
</li> --}}

{{-- Cambio de la ruta general para Super Admin y Supervisor 1, para dejarla para Supervisor 2 tambien --}}
<li class="{{ Request::is('encuestadores*') ? 'active' : '' }}">
    <a href="{!! route('encuestadores.index') !!}"><i class="fas fa-check"></i><span> Ver encuestadores</span></a>
</li>

{{-- <li class="{{ Request::is('supervisor/2/supervisores/lista-de-supervisores') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-de-supervisores') !!}"><i class="fas fa-check"></i><span> Ver supervisores</span></a>
</li> --}}

{{-- Cambio de la ruta general para Super Admin y Supervisor 1, para dejarla para Supervisor 2 tambien --}}
<li class="{{ Request::is('supervisores*') ? 'active' : '' }}">
    <a href="{!! route('supervisores.index') !!}"><i class="fas fa-check"></i><span> Ver supervisores</span></a>
</li>

<li class="{{ Request::is('supervisor/2/supervisores/lista-de-supervisores/entrevistas-graduados') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-general-de-entrevistas') !!}"><i class="fas fa-check"></i><span> Lista de encuestas</span></a>
</li>
{{-- 
<li class="{{ Request::is('supervisor/2/supervisores/lista-de-supervisores/estadisticas-generales') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.estadisticas_generales') !!}"><i class="fas fa-chart-area"></i><span> Estadísticas generales</span></a>
</li> --}}

<!-- Menú desplegable para datos de carrera-->
<li class="treeview">
    <a href="#">
        <i class="fas fa-database"></i>
        <span>Catálogo de datos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('carreras*') ? 'active' : '' }}">
            <a href="{!! route('carreras.index') !!}"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Carreras</span></a>
        </li>

        <li class="{{ Request::is('universidades*') ? 'active' : '' }}">
            <a href="{!! route('universidades.index') !!}"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Universidades</span></a>
        </li>

        <li class="{{ Request::is('grados*') ? 'active' : '' }}">
            <a href="{!! route('grados.index') !!}"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Grados</span></a>
        </li>

        <li class="{{ Request::is('disciplinas*') ? 'active' : '' }}">
            <a href="{!! route('disciplinas.index') !!}"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Disciplinas</span></a>
        </li>

        <li class="{{ Request::is('areas*') ? 'active' : '' }}">
            <a href="{!! route('areas.index') !!}"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Áreas</span></a>
        </li>
    </ul>
</li>