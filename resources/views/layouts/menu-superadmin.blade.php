<li class="{{ Request::is('excel*') ? 'active' : '' }}">
    <a href="{!! route('excel.create') !!}"><i class="fas fa-file-excel"></i><span>  Importar archivo de excel</span></a>
</li>

<li class="{{ Request::is('encuestadores*') ? 'active' : '' }}">
    <a href="{!! route('encuestadores.index') !!}"><i class="fas fa-check"></i><span> Ver encuestadores</span></a>
</li>

<li class="{{ Request::is('supervisores*') ? 'active' : '' }}">
    <a href="{!! route('supervisores.index') !!}"><i class="fas fa-check"></i><span> Ver supervisores</span></a>
</li>

<li class="{{ Request::is('encuestas-graduados*') ? 'active' : '' }}">
    <a href="{!! route('encuestas-graduados.index') !!}"><i class="fas fa-check"></i><span> Lista de encuestas</span></a>
</li>

<li class="">
    <a href="{!! route('graficos.graficos-por-estado') !!}"><i class="fas fa-chart-area"></i><span> Gráficos por estado</span></a>
</li>

<!-- Menú desplegable para datos de carrera-->
<li class="treeview">
    <a href="#">
        <i class="fas fa-database"></i>
        <span>Datos varios</span>
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

        <li class="#">
            <a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Áreas</span></a>
        </li>
    </ul>
</li>