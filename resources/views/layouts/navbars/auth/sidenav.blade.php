<aside style="z-index:1000" class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav">
        </i>
            <a class="navbar-brand m-0 d-flex flex-column align-items-center text-center" href="{{ route('home') }}" target="_blank">
                

                <h6 class="mb-0 fw-bold">{{ auth()->user()->firstname ?? 'Nombre' }}</h6>
                <h6 class="mb-1">{{ auth()->user()->lastname ?? 'Apellido' }}</h6>
            </a>

    </div>

    <hr class="horizontal dark mt-0">
    
    <!-- Contenedor principal del menú con scroll mejorado -->
<div class="collapse navbar-collapse h-auto" id="sidenav-collapse-main" 
     style="overflow-y: auto; height: calc(100vh - 180px);">
    <ul class="navbar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-chart-pie-35 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">DASHBOARD</span>
            </a>
        </li>

        <!-- Sección Datos -->
        <li class="nav-item mt-3 d-flex align-items-center">
            <div class="ps-4">
                <i class="ni ni-collection" style="color: #f4645f;"></i>
            </div>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Datos</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" 
            href="{{ route('profile') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center 
                me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Perfil</span>
            </a>
        </li>
       
       
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'change-password' ? 'active' : '' }}" 
            href="{{ route('change-password') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center 
                me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-key-25 text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Cambiar Contraseña</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.usuarios*') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-circle-08 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Gestión de usuarios</span>
            </a>
        </li>

        <!-- Sección Administración -->
        <li class="nav-item mt-3 d-flex align-items-center">
            <div class="ps-4">
                <i class="ni ni-settings-gear-65" style="color: #f4645f;"></i>
            </div>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Administración</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.sucursals.*') ? 'active' : '' }}" href="{{ route('admin.sucursals.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-shop text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Sucursales</span>
            </a>
        </li>
        
        
        
       
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-badge text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Roles</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.permisos*') ? 'active' : '' }}" href="{{ route('admin.permisos.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-key-25 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Permisos</span>
            </a>
        </li>

        <!-- Sección Inventario -->
        <li class="nav-item mt-3 d-flex align-items-center">
            <div class="ps-4">
                <i class="ni ni-box-2" style="color: #f4645f;"></i>
            </div>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Inventario</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categorias*') ? 'active' : '' }}" href="{{ route('admin.categorias.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-bullet-list-67 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Categorías</span>
            </a>
        </li>
                    
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.laboratorios.*') ? 'active' : '' }}" href="{{ route('admin.laboratorios.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-ambulance text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Laboratorios</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.proveedores.*') ? 'active' : '' }}" href="{{ route('admin.proveedores.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-truck text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Proveedores</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" href="{{ route('admin.productos.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-app text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Productos</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}" href="{{ route('admin.clientes.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-satisfied text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Clientes</span>
            </a>
        </li>

        <!-- Sección Operaciones -->
        <li class="nav-item mt-3 d-flex align-items-center">
            <div class="ps-4">
                <i class="ni ni-cart" style="color: #f4645f;"></i>
            </div>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Operaciones</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.compras*') ? 'active' : '' }}" href="{{ route('admin.compras.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-basket text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Compras</span>
            </a>
        </li>
                    
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}" href="{{ route('admin.ventas.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-money-coins text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Ventas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.cajas.*') ? 'active' : '' }}" href="{{ route('admin.cajas.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Caja</span>
            </a>
        </li>

        <!-- Sección Reportes -->
        <li class="nav-item mt-3 d-flex align-items-center">
            <div class="ps-4">
                <i class="ni ni-single-copy-04" style="color: #f4645f;"></i>
            </div>
            <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Reportes</h6>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.ingresos*') ? 'active' : '' }}" href="{{ route('admin.reporte.ingresos') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-money-coins text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Reporte de Ingresos</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.egresos.*') ? 'active' : '' }}" href="{{ route('admin.reporte.egresos') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Reporte de Egresos</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" href="{{ route('admin.productos.index') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-archive-2 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Reporte de Inventario</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.catalogo.*') ? 'active' : '' }}" 
            href="{{ route('admin.catalogo.index') }}" 
            target="_blank" 
            rel="noopener noreferrer">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-book-bookmark text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">CATÁLOGO</span>
            </a>
        </li>

       
</aside>

