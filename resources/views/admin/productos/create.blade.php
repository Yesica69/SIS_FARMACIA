@extends('layouts.app', ['title' => 'Productos'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Productos'])
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0"><i class="ni ni-box-2 text-primary mr-2"></i>Gestión de Productos</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/productos') }}">Productos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                </ol>
            </nav>
        </div>
        <a href="{{ url('/admin/productos') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="mb-0"><i class="ni ni-fat-add text-primary mr-2"></i>Nuevo Producto</h3>
                </div>
                
                <div class="card-body">
                    <form action="{{ url('/admin/productos/create') }}" method="post" enctype="multipart/form-data" id="productForm">
                        @csrf
                        
                        <div class="row">
                            <!-- Sección principal del formulario -->
                            <div class="col-md-8">
                                <!-- Primera fila - Categoría y Laboratorio -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-control-label">Categoría</label>
                                        <select name="categoria_id" class="form-control" required>
                                            <option value="">Seleccionar una categoría</option>
                                            @foreach($categorias as $categoria)
                                                <option value="{{$categoria->id}}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                    {{$categoria->nombre}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categoria_id')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-control-label">Laboratorio</label>
                                        <select name="laboratorio_id" class="form-control" required>
                                            <option value="">Seleccionar un laboratorio</option>
                                            @foreach($laboratorios as $laboratorio)
                                                <option value="{{ $laboratorio->id }}" {{ old('laboratorio_id') == $laboratorio->id ? 'selected' : '' }}>
                                                    {{ $laboratorio->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('laboratorio_id')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Segunda fila - Código y Nombre -->
                                <div class="form-row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-control-label">Código</label>
                                        <input type="text" class="form-control" name="codigo" value="{{ old('codigo') }}" required>
                                        @error('codigo')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-9 mb-3">
                                        <label class="form-control-label">Nombre del Producto</label>
                                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre del producto" required>
                                        @error('nombre')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label class="form-control-label">Descripción</label>
                                    <textarea class="form-control" name="descripcion" rows="2">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                                
                                <!-- Tercera fila - Stock -->
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-control-label">Stock Actual</label>
                                        <input type="number" class="form-control" name="stock" value="{{ old('stock', 0) }}" required>
                                        @error('stock')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label class="form-control-label">Stock Mínimo</label>
                                        <input type="number" class="form-control" name="stock_minimo" value="{{ old('stock_minimo', 0) }}" required>
                                        @error('stock_minimo')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-4 mb-3">
                                        <label class="form-control-label">Stock Máximo</label>
                                        <input type="number" class="form-control" name="stock_maximo" value="{{ old('stock_maximo', 0) }}" required>
                                        @error('stock_maximo')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Cuarta fila - Precios -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-control-label">Precio de Compra</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs</span>
                                            </div>
                                            <input type="text" class="form-control" name="precio_compra" value="{{ old('precio_compra') }}" required>
                                        </div>
                                        @error('precio_compra')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-control-label">Precio de Venta</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Bs</span>
                                            </div>
                                            <input type="text" class="form-control" name="precio_venta" value="{{ old('precio_venta') }}" required>
                                        </div>
                                        @error('precio_venta')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Quinta fila - Fechas -->
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-control-label">Fecha de Ingreso</label>
                                        <input type="date" class="form-control" name="fecha_ingreso" value="{{ old('fecha_ingreso') }}" required>
                                        @error('fecha_ingreso')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-control-label">Fecha de Vencimiento</label>
                                        <input type="date" class="form-control" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}">
                                        @error('fecha_vencimiento')
                                            <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sección de imagen -->
                            <div class="col-md-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <label class="form-control-label">Imagen del Producto</label>
                                        <div class="custom-file mt-2">
                                            <input type="file" class="custom-file-input" id="file" name="imagen" accept=".jpg, .jpeg, .png">
                                            <label class="custom-file-label" for="file">Seleccionar imagen</label>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <img id="preview" class="img-fluid rounded shadow" style="max-height: 200px; display: none;">
                                            <div id="no-image" class="bg-gradient-light rounded p-3">
                                                <i class="ni ni-box-2 text-muted fa-3x"></i>
                                                <p class="text-xs text-muted mt-2 mb-0">No hay imagen seleccionada</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-12 text-right">
                                <button type="reset" class="btn btn-outline-secondary mr-2">
                                    <i class="fas fa-undo mr-1"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Guardar Producto
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    // Script para vista previa de imagen
    document.getElementById('file').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const noImage = document.getElementById('no-image');
        const files = e.target.files;

        if (files.length > 0) {
            const file = files[0];
            
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                    noImage.style.display = 'none';
                }
                
                reader.readAsDataURL(file);
            }
        } else {
            preview.style.display = 'none';
            noImage.style.display = 'block';
        }
    });

    // Actualizar nombre del archivo seleccionado
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        const fileName = e.target.files.length > 0 ? e.target.files[0].name : 'Seleccionar imagen';
        const label = this.nextElementSibling;
        label.textContent = fileName;
    });
</script>
@endpush