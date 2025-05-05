@extends('layouts.app', ['title' => 'Productos'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Productos'])

<div class="container-fluid mt--7">
    <!-- Sección de Gestión Superior -->
    <div class="row mb-5">
        <div class="col-xl-12">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <!-- Tarjeta de Gestión -->
                        <div class="col-lg-8 col-12 mb-4 mb-lg-0">
                            <div class="card bg-gradient-primary shadow">
                                <div class="card-body py-3">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-white text-dark rounded-circle shadow-lg">
                                                <i class="ni ni-box-2"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h3 class="text-white mb-0">Gestión de Productos</h3>
                                            <p class="text-light opacity-8 mb-0">Total: {{ count($productos) }} productos registrados</p>
                                        </div>
                                        <div class="col-auto">
                                            <span class="badge badge-lg badge-success">Activo</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botón Nuevo Producto -->
                        <div class="col-lg-4 col-12">
                            <a href="{{ url('/admin/productos/create') }}" class="btn btn-block btn-success btn-lg shadow-lg py-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-plus-circle mr-3" style="font-size: 1.5rem"></i>
                                    <span style="font-size: 1.1rem">NUEVO PRODUCTO</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Barra de Búsqueda y Filtros -->
                <div class="card-body pt-0">
                    <div class="row mt-3">
                        <div class="col-md-6 col-12 mb-3 mb-md-0">
                            <div class="input-group input-group-alternative input-group-merge shadow">
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
                        <div class="col-md-6 col-12">
                            <div class="input-group input-group-alternative input-group-merge shadow">
                                <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto..." aria-label="Buscar" aria-describedby="search-addon">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Visualización de Productos -->
    <div class="row mt-4">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Listado de Productos</h3>
                </div>
                <div class="card-body">
                    <div class="row" id="productosContainer">
                        @foreach($productos as $producto)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-5 producto-card" data-category="{{ $producto->categoria_id }}">
                            <div class="card card-lift--hover shadow-lg h-100">
                                <!-- Encabezado de la Tarjeta -->
                                <div class="card-header bg-transparent pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge badge-pill badge-primary">#{{ $loop->iteration }}</span>
                                        <span class="text-xs text-muted">COD: {{ $producto->codigo }}</span>
                                    </div>
                                </div>
                                
                                <!-- Cuerpo de la Tarjeta -->
                                <div class="card-body pt-2">
                                    <!-- Imagen del Producto -->
                                    <div class="text-center mb-3">
                                        @if($producto->imagen)
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-center img-fluid rounded shadow" style="max-height: 120px; width: auto;" alt="{{ $producto->nombre }}">
                                        @else
                                            <div class="icon icon-shape icon-xl bg-gradient-secondary text-white rounded-circle shadow">
                                                <i class="fas fa-box-open"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Nombre y Descripción -->
                                    <h5 class="card-title text-dark mb-1">{{ $producto->nombre }}</h5>
                                    <p class="card-text text-sm text-muted mb-3">
                                        {{ Str::limit($producto->descripcion, 70) }}
                                    </p>
                                    
                                    <!-- Detalles del Producto -->
                                    <div class="bg-gray-100 p-3 rounded">
                                        <!-- Stock -->
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-xs text-muted"><i class="fas fa-cubes mr-1"></i> Stock</span>
                                            <span class="badge badge-{{ $producto->stock < $producto->stock_minimo ? 'danger' : 'success' }} badge-pill">
                                                {{ $producto->stock }} / {{ $producto->stock_maximo }}
                                            </span>
                                        </div>
                                        
                                        <!-- Precio -->
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-xs text-muted"><i class="fas fa-tag mr-1"></i> Precio</span>
                                            <span class="font-weight-bold text-success">Bs {{ number_format($producto->precio_venta, 2) }}</span>
                                        </div>
                                        
                                        <!-- Vencimiento -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-xs text-muted"><i class="fas fa-calendar-alt mr-1"></i> Vence</span>
                                            <span class="font-weight-bold {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->lt(now()->addMonths(3)) ? 'text-danger' : 'text-default' }}">
                                                {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}
                                                @if(\Carbon\Carbon::parse($producto->fecha_vencimiento)->lt(now()->addMonths(3)))
                                                    <i class="fas fa-exclamation-triangle ml-1"></i>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pie de Tarjeta con Botones -->
                                <div class="card-footer bg-transparent pt-0 pb-3 border-0">
                                    <div class="d-flex justify-content-between">
                                        <!-- Botón Ver -->
                                        <button type="button" class="btn btn-sm btn-info btn-icon-only rounded-circle shadow" 
                                                data-toggle="modal" data-target="#verModal{{ $producto->id }}" 
                                                title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Botón Editar -->
                                        <button type="button" class="btn btn-sm btn-warning btn-icon-only rounded-circle shadow" 
                                                data-toggle="modal" data-target="#editarModal{{ $producto->id }}" 
                                                title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-icon-only rounded-circle shadow" 
                                                    title="Eliminar" 
                                                    onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Ver Detalles -->
                        <div class="modal fade" id="verModal{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="verModalLabel{{ $producto->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title" id="verModalLabel{{ $producto->id }}">
                                            <i class="fas fa-box-open mr-2"></i>Detalles del Producto
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Columna Imagen -->
                                            <div class="col-md-5 text-center">
                                                @if($producto->imagen)
                                                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid rounded shadow-lg mb-4" style="max-height: 250px;" alt="{{ $producto->nombre }}">
                                                @else
                                                    <div class="icon icon-shape icon-xxl bg-gradient-secondary text-white rounded-circle shadow">
                                                        <i class="fas fa-box-open"></i>
                                                    </div>
                                                    <p class="text-muted mt-3">No hay imagen disponible</p>
                                                @endif
                                                <div class="mt-3">
                                                    <span class="badge badge-pill badge-{{ $producto->stock > 0 ? 'success' : 'danger' }} px-4 py-2">
                                                        {{ $producto->stock > 0 ? 'DISPONIBLE' : 'AGOTADO' }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Columna Información -->
                                            <div class="col-md-7">
                                                <h3 class="text-dark font-weight-bold">{{ $producto->nombre }}</h3>
                                                <p class="text-muted mb-4">{{ $producto->codigo }}</p>
                                                
                                                <div class="mb-4">
                                                    <h6 class="text-uppercase text-muted ls-1 mb-3">Descripción</h6>
                                                    <p class="text-dark">{{ $producto->descripcion ?: 'Sin descripción disponible' }}</p>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <h6 class="text-uppercase text-muted ls-1 mb-3">Categoría</h6>
                                                            <p class="text-dark font-weight-bold">{{ $producto->categoria->nombre }}</p>
                                                        </div>
                                                        
                                                        <div class="mb-4">
                                                            <h6 class="text-uppercase text-muted ls-1 mb-3">Laboratorio</h6>
                                                            <p class="text-dark font-weight-bold">{{ $producto->laboratorio->nombre }}</p>
                                                        </div>
                                                        
                                                        <div class="mb-4">
                                                            <h6 class="text-uppercase text-muted ls-1 mb-3">Inventario</h6>
                                                            <div class="progress-wrapper">
                                                                <div class="progress-info">
                                                                    <div class="progress-label">
                                                                        <span>Stock actual</span>
                                                                    </div>
                                                                    <div class="progress-percentage">
                                                                        <span>{{ $producto->stock }} / {{ $producto->stock_maximo }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="progress">
                                                                    @php
                                                                        $porcentaje = ($producto->stock / $producto->stock_maximo) * 100;
                                                                        $color = $porcentaje < 20 ? 'bg-danger' : ($porcentaje < 50 ? 'bg-warning' : 'bg-success');
                                                                    @endphp
                                                                    <div class="progress-bar {{ $color }}" role="progressbar" 
                                                                         style="width: {{ $porcentaje }}%" 
                                                                         aria-valuenow="{{ $porcentaje }}" 
                                                                         aria-valuemin="0" 
                                                                         aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <h6 class="text-uppercase text-muted ls-1 mb-3">Precios</h6>
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span class="text-muted">Compra:</span>
                                                                <span class="font-weight-bold">Bs {{ number_format($producto->precio_compra, 2) }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span class="text-muted">Venta:</span>
                                                                <span class="font-weight-bold text-success">Bs {{ number_format($producto->precio_venta, 2) }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted">Margen:</span>
                                                                <span class="font-weight-bold text-primary">
                                                                    @php
                                                                        $margen = (($producto->precio_venta - $producto->precio_compra) / $producto->precio_compra) * 100;
                                                                        echo number_format($margen, 2).'%';
                                                                    @endphp
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-4">
                                                            <h6 class="text-uppercase text-muted ls-1 mb-3">Fechas</h6>
                                                            <div class="d-flex justify-content-between mb-2">
                                                                <span class="text-muted">Ingreso:</span>
                                                                <span class="font-weight-bold">{{ \Carbon\Carbon::parse($producto->fecha_ingreso)->format('d/m/Y') }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted">Vencimiento:</span>
                                                                <span class="font-weight-bold {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->lt(now()->addMonths(3)) ? 'text-danger' : 'text-success' }}">
                                                                    {{ \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') }}
                                                                </span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <small class="text-muted">
                                                                    @php
                                                                        $diasRestantes = \Carbon\Carbon::parse($producto->fecha_vencimiento)->diffInDays(now());
                                                                        echo $diasRestantes > 0 ? "$diasRestantes días restantes" : "Vencido hace ".abs($diasRestantes)." días";
                                                                    @endphp
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fas fa-times mr-1"></i> Cerrar
                                        </button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#editarModal{{ $producto->id }}">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Editar -->
                        <div class="modal fade" id="editarModal{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel{{ $producto->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary text-white">
                                        <h5 class="modal-title" id="editarModalLabel{{ $producto->id }}">
                                            <i class="fas fa-edit mr-2"></i>Editar Producto
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ url('/admin/productos', $producto->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row">
                                                <!-- Columna Formulario -->
                                                <div class="col-lg-8">
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="categoria_id" class="form-control-label">
                                                                <i class="fas fa-tag mr-1"></i>Categoría
                                                            </label>
                                                            <select name="categoria_id" class="form-control" required>
                                                                @foreach($categorias as $categoria)
                                                                    <option value="{{ $categoria->id }}" {{ $categoria->id == $producto->categoria_id ? 'selected' : '' }}>
                                                                        {{ $categoria->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label for="laboratorio_id" class="form-control-label">
                                                                <i class="fas fa-flask mr-1"></i>Laboratorio
                                                            </label>
                                                            <select name="laboratorio_id" class="form-control" required>
                                                                @foreach($laboratorios as $laboratorio)
                                                                    <option value="{{ $laboratorio->id }}" {{ $laboratorio->id == $producto->laboratorio_id ? 'selected' : '' }}>
                                                                        {{ $laboratorio->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="codigo" class="form-control-label">
                                                                <i class="fas fa-barcode mr-1"></i>Código
                                                            </label>
                                                            <input type="text" class="form-control" name="codigo" value="{{ $producto->codigo }}" required>
                                                        </div>
                                                        
                                                        <div class="col-md-8 mb-3">
                                                            <label for="nombre" class="form-control-label">
                                                                <i class="fas fa-box mr-1"></i>Nombre
                                                            </label>
                                                            <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="descripcion" class="form-control-label">
                                                            <i class="fas fa-align-left mr-1"></i>Descripción
                                                        </label>
                                                        <textarea class="form-control" name="descripcion" rows="2">{{ $producto->descripcion }}</textarea>
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="stock" class="form-control-label">
                                                                <i class="fas fa-boxes mr-1"></i>Stock
                                                            </label>
                                                            <input type="number" class="form-control" name="stock" value="{{ $producto->stock }}" required>
                                                        </div>
                                                        
                                                        <div class="col-md-4 mb-3">
                                                            <label for="stock_minimo" class="form-control-label">
                                                                <i class="fas fa-exclamation-circle mr-1"></i>Mínimo
                                                            </label>
                                                            <input type="number" class="form-control" name="stock_minimo" value="{{ $producto->stock_minimo }}" required>
                                                        </div>
                                                        
                                                        <div class="col-md-4 mb-3">
                                                            <label for="stock_maximo" class="form-control-label">
                                                                <i class="fas fa-warehouse mr-1"></i>Máximo
                                                            </label>
                                                            <input type="number" class="form-control" name="stock_maximo" value="{{ $producto->stock_maximo }}" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="precio_compra" class="form-control-label">
                                                                <i class="fas fa-money-bill-wave mr-1"></i>Precio Compra
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Bs</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="precio_compra" value="{{ $producto->precio_compra }}" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label for="precio_venta" class="form-control-label">
                                                                <i class="fas fa-tag mr-1"></i>Precio Venta
                                                            </label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Bs</span>
                                                                </div>
                                                                <input type="text" class="form-control" name="precio_venta" value="{{ $producto->precio_venta }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="fecha_ingreso" class="form-control-label">
                                                                <i class="fas fa-calendar-plus mr-1"></i>Fecha Ingreso
                                                            </label>
                                                            <input type="date" class="form-control" name="fecha_ingreso" value="{{ $producto->fecha_ingreso }}" required>
                                                        </div>
                                                        
                                                        <div class="col-md-6 mb-3">
                                                            <label for="fecha_vencimiento" class="form-control-label">
                                                                <i class="fas fa-calendar-times mr-1"></i>Fecha Vencimiento
                                                            </label>
                                                            <input type="date" class="form-control" name="fecha_vencimiento" value="{{ $producto->fecha_vencimiento }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Columna Imagen -->
                                                <div class="col-lg-4">
                                                    <div class="card shadow-sm h-100">
                                                        <div class="card-body text-center">
                                                            <label class="form-control-label">
                                                                <i class="fas fa-image mr-1"></i>Imagen del Producto
                                                            </label>
                                                            
                                                            <div class="custom-file mt-3">
                                                                <input type="file" class="custom-file-input" id="imagen{{ $producto->id }}" name="imagen" accept="image/*">
                                                                <label class="custom-file-label" for="imagen{{ $producto->id }}">Seleccionar imagen</label>
                                                            </div>
                                                            
                                                            <div class="mt-4">
                                                                @if($producto->imagen)
                                                                    <img id="preview{{ $producto->id }}" src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid rounded shadow" style="max-height: 200px;">
                                                                @else
                                                                    <div class="icon icon-shape icon-xl bg-gradient-secondary text-white rounded-circle shadow mt-4">
                                                                        <i class="fas fa-box-open"></i>
                                                                    </div>
                                                                    <p class="text-muted mt-3">No hay imagen</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times mr-1"></i> Cancelar
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-1"></i> Guardar Cambios
                                            </button>
                                        </div>
                                    </form>
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
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>
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
</script>
@endsection