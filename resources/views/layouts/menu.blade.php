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

<li>
    <img class="img-responsive center-block" src="{{ asset(config('global.logo_conare')) }}" alt="Logo del CONARE" style="width: 200px; margin-top: 15px; margin-bottom: 15px;">
</li>

@if(Auth::user()->hasRole('Super Admin'))
    <li>
        <a href="{!! route('catalogo.subir') !!}"><i class="fas fa-file"></i><span> Subir catálogos</span></a>
    </li>
    @include('layouts.menu-superadmin')
@endif

@if(Auth::user()->hasRole('Supervisor 1'))
    @include('layouts.menu-supervisor-1')
@endif

@if(Auth::user()->hasRole('Supervisor 2'))
    @include('vistas-supervisor-2.menu')
@endif

@if(Auth::user()->hasRole('Encuestador'))
    @include('vistas-encuestador.menu')
@endif

<li class="">
    <a href="{!! route('ver-calendario', Auth::user()->id) !!}"><i class="far fa-calendar-alt"></i><span> Calendario de citas</span></a>
</li>

<li class="treeview">
    <a href="#">
        <i class="fas fa-clipboard-list"></i>
        <span>Reportes</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="#">
            <a href="{!! route('reportes.filtro') !!}"><i class="fa fa-edit"></i><span>Reportes</span></a>
        </li>

        <li class="#">
            <a href="{!! route('reportes.index') !!}"><i class="fa fa-edit"></i><span>Filtro</span></a>
        </li>
    </ul>
</li>