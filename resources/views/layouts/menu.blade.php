{{-- <li class="treeview">
    <a href="#">
        <i class="fas fa-user"></i>
        <span>Usuarios</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        @can('users.index')
            <li class="{{ Request::is('users*') ? 'active' : '' }}">
                <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Lista</span></a>
            </li>
        @endcan

        @can('users.index_table')
            <li class="{{ Request::is('usuarios*') ? 'active' : '' }}">
                <a href="{!! route('usuarios.index_table') !!}"><i class="fa fa-edit"></i><span>Lista #2</span></a>
            </li>
        @endcan
    </ul>
</li>
--}}

<li class="{{ Request::is('excel*') ? 'active' : '' }}">
    <a href="{!! route('excel.create') !!}"><i class="fas fa-file-excel"></i><span>  Importar archivo de excel</span></a>
</li>

{{--
<li class="treeview">
    <a href="#">
        <i class="fas fa-lock"></i>
        <span>Roles y permisos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        @can('roles.index')
            <li class="{{ Request::is('roles*') ? 'active' : '' }}">
                <a href="{!! route('roles.index') !!}"><i class="fa fa-edit"></i><span>Roles</span></a>
            </li>
        @endcan

        @can('permisos.index')
            <li class="{{ Request::is('permisos*') ? 'active' : '' }}">
                <a href="{!! route('permisos.index') !!}"><i class="fa fa-edit"></i><span>Permisos</span></a>
            </li>
        @endcan
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fas fa-user-secret"></i>
        <span>Asignaciones</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-right pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        @can('permissionsToRol.create')
            <li class="{{ Request::is('permissionsToRol*') ? 'active' : '' }}">
                <a href="{!! route('permissionsToRol.create') !!}"><i class="fa fa-edit"></i><span>Asignar permisos a rol</span></a>
            </li>
        @endcan

        @can('rolesToUser.create')
            <li class="{{ Request::is('rolesToUser*') ? 'active' : '' }}">
                <a href="{!! route('rolesToUser.create') !!}"><i class="fa fa-edit"></i><span>Asignar roles a usuario</span></a>
            </li>
        @endcan
    </ul>
</li> --}}


<li class="{{ Request::is('encuestadores*') ? 'active' : '' }}">
    <a href="{!! route('encuestadores.index') !!}"><i class="fas fa-check"></i><span> Ver encuestadores</span></a>
</li>

<li class="{{ Request::is('supervisores*') ? 'active' : '' }}">
    <a href="{!! route('supervisores.index') !!}"><i class="fas fa-check"></i><span> Ver supervisores</span></a>
</li>

<li class="{{ Request::is('encuestas-graduados*') ? 'active' : '' }}">
    <a href="{!! route('encuestas-graduados.index') !!}"><i class="fas fa-check"></i><span> Lista de encuestas</span></a>
</li>