<li class="{{ Request::is('supervisor/2/encuestadores/lista-de-encuestadores*') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-de-encuestadores') !!}"><i class="fas fa-check"></i><span> Ver encuestadores</span></a>
</li>

<li class="{{ Request::is('supervisor/2/supervisores/lista-de-supervisores*') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-de-supervisores') !!}"><i class="fas fa-check"></i><span> Ver supervisores</span></a>
</li>

<li class="{{ Request::is('encuestas-graduados*') ? 'active' : '' }}">
    <a href="{!! route('encuestas-graduados.index') !!}"><i class="fas fa-check"></i><span> Lista de encuestas</span></a>
</li>

<li class="">
    <a href="{!! route('graficos.graficos-por-estado') !!}"><i class="fas fa-chart-area"></i><span> Gráficos por estado</span></a>
</li>