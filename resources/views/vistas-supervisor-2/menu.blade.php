<li class="{{ Request::is('supervisor/2/encuestadores/lista-de-encuestadores') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-de-encuestadores') !!}"><i class="fas fa-check"></i><span> Ver encuestadores</span></a>
</li>

<li class="{{ Request::is('supervisor/2/supervisores/lista-de-supervisores') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-de-supervisores') !!}"><i class="fas fa-check"></i><span> Ver supervisores</span></a>
</li>

<li class="{{ Request::is('supervisor/2/supervisores/lista-de-supervisores/entrevistas-graduados') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.lista-general-de-entrevistas') !!}"><i class="fas fa-check"></i><span> Lista de encuestas</span></a>
</li>

<li class="{{ Request::is('supervisor/2/supervisores/lista-de-supervisores/estadisticas-generales') ? 'active' : '' }}">
    <a href="{!! route('supervisor2.estadisticas_generales') !!}"><i class="fas fa-chart-area"></i><span> Estadísticas generales</span></a>
</li>