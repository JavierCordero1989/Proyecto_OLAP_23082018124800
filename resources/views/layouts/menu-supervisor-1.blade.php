<li class="treeview">
    <a href="">
        <i class="fas fa-upload"></i>
        <span>Subir archivos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li>
            <a href="{!! route('excel.create') !!}"><i class="fa fa-file" aria-hidden="true"></i><span>Archivo de muestra</span></a>
        </li>

        <li>
            <a href="{!! route('excel.subir-contactos') !!}"><i class="fa fa-file" aria-hidden="true"></i><span>Archivo de contactos</span></a>
        </li>
    </ul>
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

{{-- <li class="">
    <a href="{!! route('graficos.graficos-por-estado') !!}"><i class="fas fa-chart-area"></i><span> Gráficos por estado</span></a>
</li> --}}