<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('panel') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/iconocurita.png') }}" alt="Icono Curita">
        </div>
        <div class="sidebar-brand-text mx-3">CURITA<sup>🖤</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('panel') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>PANEL</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Gestión Section -->
    <div class="sidebar-heading">Gestión</div>

    <!-- Productos -->
    @can('gestionar-productos')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProductos" aria-expanded="true" aria-controls="collapseProductos">
            <i class="fas fa-list"></i>
            <span>Productos</span>
        </a>
        <div id="collapseProductos" class="collapse" aria-labelledby="headingProductos" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('gestionar-medicamentos')
                <a class="collapse-item" href="{{ route('medicamentos.index') }}"><i class="fas fa-pills mr-2"></i>Medicamentos</a>
                @endcan
                @can('gestionar-equipos')
                <a class="collapse-item" href="{{ route('equipoMedico.index') }}"><i class="fas fa-stethoscope mr-2"></i>Equipos médicos</a>
                @endcan
                @can('gestionar-proveedores')
                <a class="collapse-item" href="{{ route('proveedores.index') }}"><i class="fas fa-truck mr-2"></i>Proveedores</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    <!-- Usuarios y Roles -->
    @can('usuarios-roles')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuariosRoles" aria-expanded="true" aria-controls="collapseUsuariosRoles">
            <i class="fas fa-users-cog"></i>
            <span>Usuarios y Roles</span>
        </a>
        <div id="collapseUsuariosRoles" class="collapse" aria-labelledby="headingUsuariosRoles" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can('ver-usuario')
                <a class="collapse-item" href="{{ route('users.index') }}"><i class="fas fa-users mr-2"></i>Gestionar Usuarios</a>
                @endcan
                @can('ver-roles')
                <a class="collapse-item" href="{{ route('roles.index') }}"><i class="fas fa-user-shield mr-2"></i>Roles y Permisos</a>
                @endcan
            </div>
        </div>
    </li>
    @endcan
    <!-- Sucursales -->
    @can('administrar-sucursales')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSucursales" aria-expanded="true" aria-controls="collapseSucursales">
            <i class="fas fa-building"></i>
            <span>Sucursales</span>
        </a>
        <div id="collapseSucursales" class="collapse" aria-labelledby="headingSucursales" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('sucursales.index')}}"><i class="fas fa-info-circle mr-2"></i>Información</a>

            </div>
        </div>
    </li>
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider">
    @can('gestionar-ventas')
    <!-- Ventas Section -->
    <div class="sidebar-heading">Ventas</div>

    <!-- Ventas -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVentas" aria-expanded="true" aria-controls="collapseVentas">
            <i class="fas fa-cash-register"></i>
            <span>Ventas</span>
        </a>
        <div id="collapseVentas" class="collapse" aria-labelledby="headingVentas" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('ventas.index')}}"><i class="fas fa-plus-circle mr-2"></i>Nueva venta</a>
            </div>
        </div>
    </li>
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider">

    @can('ver-clientes')
    <!-- Ventas Section -->
    <div class="sidebar-heading">Clientes</div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes" aria-expanded="true" aria-controls="collapseUsuariosRoles">
            <i class="fas fa-users-cog"></i>
            <span>Clientes</span>
        </a>
        <div id="collapseClientes" class="collapse" aria-labelledby="headingClientes" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('clientes.index') }}"><i class="fas fa-users mr-2"></i>Gestionar Clientes</a>
                
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img src="{{ asset('img/Tu con el Raw Alejandro.png') }}" alt="">
        <p class="text-center mb-2"><strong>Rauw Alejandro</strong></p>
        <a class="btn btn-success btn-sm" href="https://www.youtube.com/watch?v=NC4wwAtyBA8">Tu Con El (Lyric Video)</a>
    </div>

</ul>
