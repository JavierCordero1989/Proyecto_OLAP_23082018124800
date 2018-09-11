<li class="{{ Request::is('encuestador*') ? 'active' : '' }}">
    <a href="{!! route('encuestador.mis-entrevistas', Auth::user()->id) !!}"><i class="fas fa-list-ul"></i><span> Mis encuestas</span></a>
</li>

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