<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}" target="_blank">
            <img src="./img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Dashboard</span>
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
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">DASHBOARD</span>
                </a>
            </li>

            <!-- Sección Datos -->
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
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
           
            @auth
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'change-password' ? 'active' : '' }}" 
                href="{{ route('change-password') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center 
                    me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-lock-circle-open text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Cambiar Contraseña</span>
                </a>
            </li>
            @endauth
            
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'user-management') == true ? 'active' : '' }}" 
                href="{{ route('page', ['page' => 'user-management']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center 
                    me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>

            <!-- Sección Administración -->
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
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
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Usuario</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.usuarios*') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestión de usuarios</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Roles</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.permisos*') ? 'active' : '' }}" href="{{ route('admin.permisos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Permisos</span>
                </a>
            </li>

            <!-- Sección Inventario -->
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Inventario</h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categorias*') ? 'active' : '' }}" href="{{ route('admin.categorias.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-primary text-sm opacity-10"></i>
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
                        <i class="ni ni-delivery-fast text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Proveedores</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" href="{{ route('admin.productos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-delivery-fast text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Productos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}" href="{{ route('admin.clientes.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-delivery-fast text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Clientes</span>
                </a>
            </li>

            <!-- Sección Operaciones -->
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Operaciones</h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.compras*') ? 'active' : '' }}" href="{{ route('admin.compras.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Compras</span>
                </a>
            </li>
                        
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}" href="{{ route('admin.ventas.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-ambulance text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Ventas</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.cajas.*') ? 'active' : '' }}" href="{{ route('admin.cajas.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-delivery-fast text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Caja</span>
                </a>
            </li>

            <!-- Sección Reportes -->
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Reportes</h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.ingresos*') ? 'active' : '' }}" href="{{ route('admin.reporte.ingresos') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tag text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Reporte de Ingresos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.egresos.*') ? 'active' : '' }}" href="{{ route('admin.reporte.egresos') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-delivery-fast text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Reporte de Egresos</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}" href="{{ route('admin.productos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-delivery-fast text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Reporte de Inventario</span>
                </a>
            </li>

            <!-- Sección Pages -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pages</h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'tables') == true ? 'active' : '' }}" href="{{ route('page', ['page' => 'tables']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'billing') == true ? 'active' : '' }}" href="{{ route('page', ['page' => 'billing']) }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'virtual-reality' ? 'active' : '' }}" href="{{ route('virtual-reality') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li>
            
            <!-- Sección Account pages -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile-static' ? 'active' : '' }}" href="{{ route('profile-static') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sign-up-static') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-collection text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

