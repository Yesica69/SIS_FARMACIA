@extends('layouts.app', ['title' => 'Productos'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Productos'])

<div class="container-fluid mt--7">
    <!-- Header Section -->
    <!-- Sección de Encabezado Mejorado -->
<div class="row mb-6">
    <div class="col-xl-12">
        <!-- Tarjeta Contenedora -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <!-- Información de Gestión -->
                    <div class="col-md-8 mb-4 mb-md-0">
                        <div class="d-flex align-items-center">
                            <!-- Icono -->
                            <div class="icon icon-xl icon-shape bg-light-primary text-primary rounded-circle mr-4">
                                <i class="ni ni-box-2"></i>
                            </div>
                            
                            <!-- Texto -->
                            <div>
                                <h2 class="mb-1 text-gray-800">Gestión de Productos</h2>
                                <div class="d-flex flex-wrap align-items-center">
                                    <span class="text-muted mr-3">
                                        <i class="fas fa-cubes mr-1"></i> {{ count($productos) }} productos
                                    </span>
                                    <span class="badge badge-pill badge-light-success">
                                        <i class="fas fa-circle mr-1 small"></i> Sistema Activo
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botón de Acción -->
                    <div class="col-md-4">
                        <a href="{{ url('/admin/productos/create') }}" class="btn btn-primary btn-block btn-hover-scale">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus mr-2"></i>
                                <span>Agregar Producto</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
    
    <!-- Page content -->
   
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Listado de Productos</h3>
                            </div>
                            <div class="col-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                                            id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                            title="Exportar reporte en diferentes formatos">
                                        <i class="fas fa-download me-1"></i> Exportar
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                        <li>
                                            <a class="dropdown-item" 
                                            href="{{ route('admin.productos.reporte', ['tipo' => 'pdf']) }}?categoria={{ request('categoria') }}&stockBajo={{ request('stockBajo', 0) }}&diasVencimiento={{ request('diasVencimiento') }}"
                                            title="Exportar a PDF" target="_blank">
                                                <i class="fas fa-file-pdf text-danger me-2"></i> PDF
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                            href="{{ route('admin.productos.reporte', ['tipo' => 'excel']) }}?categoria={{ request('categoria') }}&stockBajo={{ request('stockBajo', 0) }}&diasVencimiento={{ request('diasVencimiento') }}"
                                            title="Exportar a Excel">
                                                <i class="fas fa-file-excel text-success me-2"></i> Excel
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" 
                                            href="{{ route('admin.productos.reporte', ['tipo' => 'csv']) }}?categoria={{ request('categoria') }}&stockBajo={{ request('stockBajo', 0) }}&diasVencimiento={{ request('diasVencimiento') }}"
                                            title="Exportar a CSV">
                                                <i class="fas fa-file-csv text-info me-2"></i> CSV
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>       
                        </div>
                    </div>
                    
                    <!-- Search and Filter -->
                    <div class="card-body pt-0">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group input-group-alternative input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input class="form-control" id="searchInput" placeholder="Buscar producto..." type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-alternative input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-filter"></i></span>
                                    </div>
                                    <select class="form-control" id="filterCategory">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Products Grid -->
                        <div class="row" id="productosContainer">
                            @foreach($productos as $producto)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 producto-card" data-category="{{ $producto->categoria_id }}">
                                <div class="card card-lift--hover shadow-sm h-100">
                                    <!-- Product Image -->
                                    <div class="card-header p-0 position-relative">
                                        @if($producto->imagen)
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" style="height: 160px; object-fit: cover;" alt="{{ $producto->nombre }}">
                                        @else
                                            <div class="placeholder-img d-flex align-items-center justify-content-center bg-secondary" style="height: 160px;">
                                                <i class="fas fa-box-open fa-3x text-white"></i>
                                            </div>
                                        @endif
                                        <span class="badge badge-primary badge-pill position-absolute" style="top: 10px; left: 10px;">#{{ $loop->iteration }}</span>
                                        <span class="badge badge-secondary badge-pill position-absolute" style="top: 10px; right: 10px;">{{ $producto->codigo }}</span>
                                    </div>
                                    
                                    <!-- Product Body -->
                                    <div class="card-body pt-3 pb-2">
                                        <h5 class="card-title mb-1">{{ $producto->nombre }}</h5>
                                        
                                        
                                        <!-- Product Details -->
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-sm text-muted">Stock:</span>
                                            <span class="badge badge-{{ $producto->stock < $producto->stock_minimo ? 'danger' : 'success' }} text-black">
                                                {{ $producto->stock }} / {{ $producto->stock_maximo }}
                                            </span>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-sm text-muted">Precio:</span>
                                            <span class="font-weight-bold text-success">Bs {{ number_format($producto->precio_venta, 2) }}</span>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-sm text-muted">Vence:</span>
                                            <span class="font-weight-bold text-muted">
                                                @if($producto->fecha_vencimiento)
                                                    @php
                                                        $fechaVencimiento = \Carbon\Carbon::parse($producto->fecha_vencimiento);
                                                        $esProximoAVencer = $fechaVencimiento->lt(now()->addMonths(3));
                                                    @endphp
                                                    
                                                    <span class="{{ $esProximoAVencer ? 'text-danger' : 'text-muted' }}">
                                                        {{ $fechaVencimiento->format('d/m/Y') }}
                                                        @if($esProximoAVencer)
                                                            <i class="fas fa-exclamation-triangle ml-1"></i>
                                                        @endif
                                                    </span>
                                                @else
                                                    <span class="text-info">No tiene fecha</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Footer -->
                                    <div class="card-footer bg-transparent pt-0 pb-3 border-0">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" 
                                            class="btn btn-sm btn-info text-white rounded-end shadow-sm px-4 "
                                                    onclick="openModal('verModal{{ $producto->id }}')"
                                                    title="Ver detalles" data-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                           
                                            
                                            
                                            



                                            <form action="{{ route('admin.productos.destroy', $producto->id) }}" 
      method="POST" 
      class="d-inline"
      data-producto='{"nombre":"{{ $producto->nombre }}"}'>
        @csrf
        @method('DELETE')
        <button type="button" 
                class="btn btn-sm bg-gradient-danger text-white rounded-end shadow-sm px-4 btn-eliminar-producto"
                title="Eliminar rol"
                data-bs-toggle="tooltip">
            <span class="btn-inner--icon me-1">
                <i class="fas fa-trash-alt"></i>
            </span>
            <span class="btn-inner--text"></span>
        </button>
    </form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarEliminacionSucursal(event) {
    event.preventDefault();
    const form = event.target.closest('form');
    const producto = JSON.parse(form.dataset.producto || '{}');
    
    Swal.fire({
        title: `<span class="swal2-title">Confirmar Eliminación</span>`,
        html: `<div class="swal2-content-container">
                 
                 <div class="swal2-text-content">
                     <h3 class="swal2-subtitle">¿Eliminar producto permanentemente?</h3>
                     <div class="swal2-user-info mt-3">
                         <i></i> ${producto.nombre || 'Este producto'}
                     </div>
                     <div class="swal2-warning-text">
                         <i class="fas fa-exclamation-triangle me-2"></i>
                         Esta acción no se puede deshacer
                     </div>
                 </div>
               </div>`,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `<i class="fas fa-trash-alt me-2"></i> Confirmar Eliminación`,
        cancelButtonText: `<i class="fas fa-times me-2"></i> Cancelar`,
        buttonsStyling: false,
        customClass: {
            popup: 'swal2-container-premium',
            confirmButton: 'swal2-confirm-btn-premium',
            cancelButton: 'swal2-cancel-btn-premium',
            actions: 'swal2-actions-premium'
        },
        background: 'rgba(255,255,255,0.98)',
        showClass: {
            popup: 'animate__animated animate__zoomIn animate__faster'
        },
        hideClass: {
            popup: 'animate__animated animate__zoomOut animate__faster'
        },
        allowOutsideClick: false,
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                html: `<div class="swal2-loader-container">
                         <div class="swal2-loader-circle"></div>
                         <div class="swal2-loader-bar-container">
                             <div class="swal2-loader-bar"></div>
                         </div>
                       </div>`,
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    const loaderBar = document.querySelector('.swal2-loader-bar');
                    loaderBar.style.width = '100%';
                    loaderBar.style.transition = 'width 1s ease-in-out';
                }
            });
            
            setTimeout(() => {
                form.submit();
            }, 1200);
        }
    });
}

document.querySelectorAll('.btn-eliminar-producto').forEach(button => {
    button.addEventListener('click', confirmarEliminacionSucursal);
});
</script>

<style>
/* Estilos Premium */
.swal2-container-premium {
    border-radius: 18px !important;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18) !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    max-width: 480px !important;
    padding: 2.5rem !important;
}

.swal2-icon-wrapper {
    text-align: center;
    margin: 1.5rem 0;
}

.swal2-icon-svg {
    width: 72px;
    height: 72px;
    opacity: 0.9;
}

.swal2-content-container {
    text-align: center;
    padding: 0 1.5rem;
}

.swal2-title {
    font-size: 1.8rem !important;
    font-weight: 600 !important;
    color: #2f3542 !important;
    letter-spacing: -0.5px;
    margin-bottom: 0 !important;
}

.swal2-subtitle {
    font-size: 1.25rem;
    color: #57606f;
    font-weight: 500;
    margin: 1rem 0;
}

.swal2-user-info {
    background: #f8f9fa;
    padding: 0.75rem;
    border-radius: 10px;
    font-size: 1.1rem;
    color: #2f3542;
    border-left: 4px solid #ff4757;
}

.swal2-warning-text {
    font-size: 0.95rem;
    color: #ff6b81;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px dashed #dfe4ea;
}

.swal2-confirm-btn-premium {
    background: linear-gradient(135deg, #ff4757, #ff6b81) !important;
    border: none !important;
    padding: 12px 28px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    border-radius: 10px !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(255, 71, 87, 0.25) !important;
    transition: all 0.3s ease !important;
}

.swal2-confirm-btn-premium:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(255, 71, 87, 0.3) !important;
}

.swal2-cancel-btn-premium {
    background: white !important;
    border: 1px solid #dfe4ea !important;
    padding: 12px 28px !important;
    font-weight: 500 !important;
    font-size: 1rem !important;
    border-radius: 10px !important;
    color: #57606f !important;
    transition: all 0.3s ease !important;
}

.swal2-cancel-btn-premium:hover {
    background: #f8f9fa !important;
    border-color: #ced6e0 !important;
}

.swal2-actions-premium {
    margin: 2rem 0 0 0 !important;
    gap: 1rem !important;
}

/* Loader premium */
.swal2-loader-container {
    width: 100%;
    padding: 1.5rem 0;
}

.swal2-loader-circle {
    width: 60px;
    height: 60px;
    border: 4px solid rgba(255, 71, 87, 0.2);
    border-top-color: #ff4757;
    border-radius: 50%;
    margin: 0 auto 1.5rem;
    animation: swal2-spin 1s linear infinite;
}

.swal2-loader-bar-container {
    width: 100%;
    height: 6px;
    background: rgba(255, 71, 87, 0.1);
    border-radius: 3px;
    overflow: hidden;
}

.swal2-loader-bar {
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, #ff4757, #ff6b81);
    border-radius: 3px;
}

@keyframes swal2-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>














                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
       
    </div>
</div>

@foreach($productos as $producto)



<!-- Modal para Ver Detalles - V -->
<div class="modal fade" id="verModal{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="verModalLabel{{ $producto->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <!-- Encabezado limpio -->
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center w-100">
                    <h5 class="modal-title text-dark mb-0" id="verModalLabel{{ $producto->id }}">
                        {{ $producto->nombre }}
                    </h5>
                    
                    <button type="button" class="btn-close text-black" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            
            <div class="modal-body pt-0">
                <div class="row">
                    <!-- Columna Imagen -->
                    <div class="col-md-5 mb-4 mb-md-0">
                        <div class="bg-light rounded-lg p-3 text-center mb-3">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid rounded" style="max-height: 220px; width: auto;" alt="{{ $producto->nombre }}">
                            @else
                                <div class="p-4 text-muted">
                                    <i class="fas fa-box-open fa-3x mb-2"></i>
                                    <p class="mb-0">Imagen no disponible</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge badge-{{ $producto->stock > 0 ? 'success' : 'danger' }} px-3 py-1">
                                {{ $producto->stock > 0 ? 'Disponible' : 'Agotado' }}
                            </span>
                            <span class="text-success font-weight-bold">Bs {{ number_format($producto->precio_venta, 2) }}</span>
                        </div>
                        
                        <div class="progress mb-3" style="height: 6px;">
                            @php
                                $porcentaje = ($producto->stock / $producto->stock_maximo) * 100;
                                $color = $porcentaje < 20 ? 'bg-danger' : ($porcentaje < 50 ? 'bg-warning' : 'bg-success');
                            @endphp
                            <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $porcentaje }}%"></div>
                        </div>
                        
                        <div class="small text-muted text-center">
                            {{ $producto->stock }} unidades en stock
                        </div>
                    </div>
                    
                    <!-- Columna Información -->
                    <div class="col-md-7">
                        <div class="mb-4">
                            <h6 class="text-muted small text-uppercase mb-2">Descripción</h6>
                            <p class="text-dark">{{ $producto->descripcion ?: 'Sin descripción' }}</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-muted small text-uppercase mb-1">Categoría</h6>
                                    <p class="font-weight-bold">{{ $producto->categoria->nombre }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6 class="text-muted small text-uppercase mb-1">Laboratorio</h6>
                                    <p class="font-weight-bold">{{ $producto->laboratorio->nombre }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h6 class="text-muted small text-uppercase mb-1">Precio compra</h6>
                                    <p class="font-weight-bold">Bs {{ number_format($producto->precio_compra, 2) }}</p>
                                </div>
                                
                                
                                <div class="mb-3">
                                    <h6 class="text-muted small text-uppercase mb-1">Margen</h6>
                                    <p class="font-weight-bold text-primary">
                                        @php
                                            $margen = (($producto->precio_venta - $producto->precio_compra) / $producto->precio_compra) * 100;
                                            echo number_format($margen, 2).'%';
                                        @endphp
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-top pt-3 mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted small text-uppercase mb-1">Fecha ingreso</h6>
                                    <p class="font-weight-bold">{{ \Carbon\Carbon::parse($producto->fecha_ingreso)->format('d/m/Y') }}</p>
                                </div>
                                
                                <div class="col-md-6">
    <h6 class="text-muted small text-uppercase mb-1">Vencimiento</h6>
    <p class="font-weight-bold">
        @if($producto->fecha_vencimiento)
            <span class="{{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->lt(now()->addMonths(3)) ? 'text-danger' : 'text-success' }}">
                {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}
                <small class="d-block {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->lt(now()) ? 'text-danger' : 'text-muted' }}">
                   
                </small>
            </span>
        @else
            <span class="text-info">No tiene fecha de vencimiento</span>
        @endif
    </p>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pie del modal limpio -->
            <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ni ni-fat-remove me-1"></i> Cerrar
                        </button>
                
                <button type="button" class="btn btn-primary" onclick="openModal('editarModal{{ $producto->id }}')" data-dismiss="modal">
                    Editar Producto
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }
    
    .modal-header {
        padding: 1.25rem 1.5rem 0;
    }
    
    .modal-body {
        padding: 0 1.5rem;
    }
    
    .modal-footer {
        padding: 0 1.5rem 1.5rem;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .rounded-lg {
        border-radius: 0.5rem !important;
    }
</style>

<!-- Modal para Editar -->
<!-- Modal para Editar Producto -->
<div class="modal fade" id="editarModal{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel{{ $producto->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-pencil-alt fa-lg mr-3"></i>
                    <h5 class="modal-title font-weight-bold" id="editarModalLabel{{ $producto->id }}">EDITAR PRODUCTO</h5>
                </div>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <form action="{{ url('/admin/productos', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body py-4">
                    <div class="row">
                        <!-- Sección de Formulario -->
                        <div class="col-lg-8 pr-lg-4">
                            
                        <div class="d-flex align-items-center mb-4">  <!-- Contenedor flex -->
    <!-- Laboratorio -->
    <div class="flex-grow-1 mr-3">  <!-- Ocupa espacio y margen derecho -->
        <label for="laboratorio_id" class="font-weight-bold text-primary mb-1 d-block">
            <i class="fas fa-flask mr-2"></i>Laboratorio
        </label>
        <select name="laboratorio_id" class="form-control border-primary w-100" required>
            @foreach($laboratorios as $laboratorio)
                <option value="{{ $laboratorio->id }}" {{ $laboratorio->id == $producto->laboratorio_id ? 'selected' : '' }}>
                    {{ $laboratorio->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-auto px-2 mb-3 d-flex align-items-center">
        <span class="text-muted"></span>
    </div>
    <!-- Categoría -->
    <div class="flex-grow-1 ml-3">  <!-- Ocupa espacio y margen izquierdo -->
        <label for="categoria_id" class="font-weight-bold text-primary mb-1 d-block">
            <i class="fas fa-tag mr-2"></i>Categoría
        </label>
        <select name="categoria_id" class="form-control border-primary w-100" required>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}" {{ $categoria->id == $producto->categoria_id ? 'selected' : '' }}>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>


<div class="d-flex align-items-center mb-4">  <!-- Contenedor flex -->
    <!-- Código -->
    <div class="flex-grow-1 mr-3" style="flex-basis: 30%;">  <!-- 30% del ancho -->
        <label for="codigo" class="font-weight-bold text-primary mb-1 d-block">
            <i class="fas fa-barcode mr-2"></i>Código
        </label>
        <input type="text" class="form-control border-primary w-100" name="codigo" value="{{ $producto->codigo }}" required>
    </div>
    <div class="col-auto px-2 mb-3 d-flex align-items-center">
        <span class="text-muted"></span>
    </div>
    <!-- Nombre del Producto -->
    <div class="flex-grow-1 ml-3" style="flex-basis: 70%;">  <!-- 70% del ancho -->
        <label for="nombre" class="font-weight-bold text-primary mb-1 d-block">
            <i class="fas fa-box mr-2"></i>Nombre del Producto
        </label>
        <input type="text" class="form-control border-primary w-100" name="nombre" value="{{ $producto->nombre }}" required>
    </div>
</div>


                            
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for="descripcion" class="font-weight-bold text-primary mb-1">
                                        <i class="fas fa-align-left mr-2"></i>Descripción
                                    </label>
                                    <textarea class="form-control border-primary" name="descripcion" rows="2">{{ $producto->descripcion }}</textarea>
                                </div>
                            </div>
                            







                            <div class="row">
                                    <div class="col-md-6 pr-md-2">
                                        <div class="card border-0 shadow-sm mb-3 h-100">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0">Control de Inventario</h6>
                                            </div>
                                            <div class="card-body p-2">
                                            <div class="form-group">
                                                <label for="stock" class="font-weight-bold text-primary mb-1">
                                                    <i class="fas fa-boxes mr-2"></i>Stock Actual
                                                </label>
                                                <input type="number" class="form-control border-primary" name="stock" value="{{ $producto->stock }}" required>
                                            </div>
                                                
                                            <div class="form-group">
                                        <label for="stock_minimo" class="font-weight-bold text-primary mb-1">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>Stock Mínimo
                                        </label>
                                        <input type="number" class="form-control border-primary" name="stock_minimo" value="{{ $producto->stock_minimo }}" required>
                                    </div>
                                                
                                    <div class="form-group">
                                        <label for="stock_maximo" class="font-weight-bold text-primary mb-1">
                                            <i class="fas fa-warehouse mr-2"></i>Stock Máximo
                                        </label>
                                        <input type="number" class="form-control border-primary" name="stock_maximo" value="{{ $producto->stock_maximo }}" required>
                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 pl-md-2">
                                        <div class="card border-0 shadow-sm mb-3 h-100">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0">Información de Precios</h6>
                                            </div>
                                            <div class="form-row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-group">
                                                    <label for="precio_compra" class="font-weight-bold text-primary mb-1">
                                                        <i class="fas fa-money-bill-wave mr-2"></i>Precio de Compra
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary text-white">Bs</span>
                                                        </div>
                                                        <input type="text" class="form-control border-primary" name="precio_compra" value="{{ $producto->precio_compra }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            <div class="col-md-6 mb-4">
                                                <div class="form-group">
                                                    <label for="precio_venta" class="font-weight-bold text-primary mb-1">
                                                        <i class="fas fa-tags mr-2"></i>Precio de Venta
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-primary text-white"> Bs </span>
                                                        </div>
                                                        <input type="text" class="form-control border-primary" name="precio_venta" value="{{ $producto->precio_venta }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>







                            
                            
                            
                            
                        </div>
                        
                        <!-- Sección de Imagen -->
                        <div class="col-lg-4 pl-lg-4">
    <!-- Card de Imagen - Diseño Premium -->
    <div class="card mb-4 border-0" style="box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.03); border-radius: 0.75rem; overflow: hidden;">
        <div class="card-header bg-white py-3" style="border-bottom: 1px solid rgba(0,0,0,0.03);">
            <h6 class="mb-0 font-weight-600 d-flex align-items-center text-primary">
                <i class="fas fa-camera mr-2" style="color: #6777ef;"></i>
                <span style="letter-spacing: 0.5px;">Imagen del Producto</span>
            </h6>
        </div>
        <div class="card-body p-4">
            <!-- Upload Area -->
            <div class="mb-4">
                <div class="file-upload-wrapper">
                    <input type="file" id="imagen{{ $producto->id }}" name="imagen" accept="image/*" class="file-upload-input" 
                           data-height="200" style="display: none;">
                    <label for="imagen{{ $producto->id }}" class="file-upload-label bg-light-primary text-primary d-flex flex-column align-items-center justify-content-center" 
                           style="border: 2px dashed #6777ef; border-radius: 0.5rem; padding: 1.5rem; cursor: pointer; transition: all 0.3s;">
                        <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 1.5rem;"></i>
                        <span class="text-center">Haz clic para subir una imagen</span>
                        <small class="text-muted mt-1">Formatos: JPG, PNG, GIF</small>
                    </label>
                </div>
            </div>
            
            <!-- Preview Area -->
            <div class="image-preview-container d-flex flex-column align-items-center justify-content-center" 
                 style="min-height: 200px; background-color: #f8fafc; border-radius: 0.5rem; padding: 1rem;">
                @if($producto->imagen)
                    <img id="preview{{ $producto->id }}" src="{{ asset('storage/' . $producto->imagen) }}" 
                         class="img-fluid rounded" style="max-height: 200px; object-fit: contain; width: 100%; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                @else
                    <div class="icon-placeholder bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; margin-bottom: 1rem;">
                        <i class="fas fa-box-open" style="font-size: 1.75rem;"></i>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 0.875rem; font-weight: 500;">No hay imagen disponible</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Card de Fechas - Diseño Premium -->
    <div class="card border-0" style="box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.03); border-radius: 0.75rem;">
    <div class="card-header bg-white py-3" style="border-bottom: 1px solid rgba(0,0,0,0.03);">
        <h6 class="mb-0 font-weight-600 d-flex align-items-center text-primary">
            <i class="far fa-calendar-alt mr-2" style="color: #6777ef;"></i>
            <span style="letter-spacing: 0.5px;">Gestión de Fechas</span>
        </h6>
    </div>
    <div class="card-body p-4">
        <!-- Fecha de Ingreso (Arriba) -->
        <div class="form-group mb-4">
            <label for="fecha_ingreso" class="d-block mb-2 font-weight-600 text-primary" style="font-size: 0.8125rem;">
                <i class="fas fa-calendar-plus mr-1"></i> Fecha de Ingreso
            </label>
            <div class="input-group input-group-alternative">
                <input type="date" class="form-control date-input" name="fecha_ingreso" 
                       value="{{ $producto->fecha_ingreso }}" required
                       style="border-radius: 0.5rem; border: 1px solid #e9ecef; height: calc(1.5em + 1rem + 2px); padding: 0.5rem 1rem;">
                <div class="input-group-append">
                    <span class="input-group-text" style="background: transparent; border-left: 0;">
                        <i class="fas fa-calendar-day" style="color: #adb5bd;"></i>
                    </span>
                </div>
            </div>
        </div>

        <!-- Separador visual -->
        <div class="my-4" style="border-top: 1px dashed #e9ecef;"></div>

        <!-- Fecha de Vencimiento (Abajo) -->
        <div class="form-group mt-4">
            <label for="fecha_vencimiento" class="d-block mb-2 font-weight-600 text-primary" style="font-size: 0.8125rem;">
                <i class="fas fa-calendar-times mr-1"></i> Fecha de Vencimiento
            </label>
            <div class="input-group input-group-alternative">
                <input type="date" class="form-control date-input" name="fecha_vencimiento" 
                       value="{{ $producto->fecha_vencimiento }}"
                       style="border-radius: 0.5rem; border: 1px solid #e9ecef; height: calc(1.5em + 1rem + 2px); padding: 0.5rem 1rem;">
                <div class="input-group-append">
                    <span class="input-group-text" style="background: transparent; border-left: 0;">
                        <i class="fas fa-calendar-alt" style="color: #adb5bd;"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    /* Efectos hover para interactividad */
    .file-upload-label:hover {
        background-color: rgba(103, 119, 239, 0.05) !important;
        border-color: #6777ef !important;
    }
    
    .date-input:focus {
        border-color: #6777ef !important;
        box-shadow: 0 0 0 2px rgba(103, 119, 239, 0.2) !important;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.08) !important;
    }
</style>
                    </div>
                </div>
                
                <!-- Pie del Modal -->
                <div class="modal-footer bg-light">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ni ni-fat-remove me-1"></i> Cancelar
                        </button>
                    
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach




<script>
    // Search and filter functionality remains the same
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const productCards = document.querySelectorAll('.producto-card');
        
        productCards.forEach(card => {
            const productName = card.querySelector('.card-title').textContent.toLowerCase();
            const productDesc = card.querySelector('.card-text').textContent.toLowerCase();
            
            if (productName.includes(searchValue) || productDesc.includes(searchValue)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    document.getElementById('filterCategory').addEventListener('change', function() {
        const categoryId = this.value;
        const productCards = document.querySelectorAll('.producto-card');
        
        productCards.forEach(card => {
            if (categoryId === '' || card.getAttribute('data-category') === categoryId) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<style>
    /* Tus estilos personalizados aquí */
    .icon-xl {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-hover-scale:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }
    
    .bg-light-primary {
        background-color: rgba(94, 114, 228, 0.1);
    }
    
    .input-group-merged .input-group-text {
        background-color: transparent;
        border-right: none;
    }
    
    .form-control-appended {
        border-left: none;
    }
    
    .badge-light-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
</style>

@endsection

@section('js')

<!-- Y estos scripts al final de tu body -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar Producto?',
        text: "¡Esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f5365c',  // Rojo similar a tu bg-gradient-danger
        cancelButtonColor: '#5e72e4',  // Azul de contraste
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        customClass: {
            container: 'animated pulse'  // Efecto de animación sutil
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inicializar List.js para búsqueda
        var options = {
            valueNames: ['card-title', 'card-text'],
            page: 12,
            pagination: true
        };

        var productosList = new List('productosContainer', options);

        // Búsqueda por input
        $('#searchInput').on('keyup', function() {
            productosList.search($(this).val());
        });

        // Filtro por categoría
        $('#filterCategory').on('change', function() {
            var category = $(this).val();
            if(category) {
                $('.producto-card').hide();
                $('.producto-card[data-category="'+category+'"]').show();
            } else {
                $('.producto-card').show();
            }
        });

        // Vista previa de imagen al editar
        $('input[type="file"]').change(function(e) {
            var previewId = $(this).attr('id').replace('imagen', 'preview');
            if (e.target.files.length > 0) {
                var src = URL.createObjectURL(e.target.files[0]);
                $('#' + previewId).attr('src', src);
            }
        });

        // Actualizar nombre del archivo seleccionado
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    // Función para abrir modales
    function openModal(modalId) {
        $('#' + modalId).modal('show');
    }

    // Función para confirmar eliminación
    function confirmDelete(id, nombre) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Vas a eliminar el producto "${nombre}"`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar formulario de eliminación
                $('#deleteForm').attr('action', '/admin/productos/' + id);
                $('#deleteForm').submit();
            }
        });
    }
</script>
@endsection


@section('styles')
<style>
    /* Tus estilos personalizados aquí */
    .icon-xl {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-hover-scale:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }
    
    .bg-light-primary {
        background-color: rgba(94, 114, 228, 0.1);
    }
    
    .input-group-merged .input-group-text {
        background-color: transparent;
        border-right: none;
    }
    
    .form-control-appended {
        border-left: none;
    }
    
    .badge-light-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
</style>
@endsection