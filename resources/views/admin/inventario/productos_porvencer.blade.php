@extends('layouts.app', ['title' => 'Gestión de Compras'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Compras'])
<div class="container-fluid">
    
        <!-- Card Header -->
        <div class="card border-0 shadow-sm rounded-3 mb-4">
    <!-- Card Header -->
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                    <i class="fas fa-clock text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-semibold">Control de Vencimientos</h5>
                    <small class="text-muted">Filtrado por días restantes</small>
                </div>
            </div>
            <div class="mt-3 text-center">
                        <a href="{{ route('admin.inventario.index') }}?sucursal={{ $sucursalId }}" class="btn btn-sm btn-primary">
                            <i class="ni ni-zoom-split-in"></i> Volver
                        </a>
                    </div>
        </div>
    </div>

    <!-- Card Body - Filtro por días -->
    <div class="card-body p-4">
        <form method="get" action="{{ route('admin.inventario.productos_porvencer') }}" class="row g-3 align-items-center">
            <div class="col-md-8">
                <label class="form-label small text-muted mb-1">Mostrar productos que vencen en:</label>
                <div class="input-group">
                    <select name="dias" class="form-select">
                        <option value="7" {{ request('dias') == 7 ? 'selected' : '' }}>Próximos 7 días</option>
                        <option value="15" {{ request('dias') == 15 ? 'selected' : '' }}>Próximos 15 días</option>
                        <option value="30" {{ !request('dias') || request('dias') == 30 ? 'selected' : '' }}>Próximos 30 días</option>
                        <option value="60" {{ request('dias') == 60 ? 'selected' : '' }}>Próximos 60 días</option>
                    </select>
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-filter me-1"></i> Aplicar
                    </button>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-file-export me-1"></i> Exportar
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="fas fa-print me-1"></i> Imprimir
                </button>
            </div>
        </form>
    </div>
</div>
    </div>

<div class="container-fluid">

    <!-- Card Header -->
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary">
                <i class="fas fa-clock me-2"></i>
                Control de Vencimientos
            </h5>
            <div>
                <span class="badge bg-light-primary text-primary me-2">
                    {{ $productos->total() }} Registros
                </span>
                
            </div>
        </div>
    

    <!-- Card Body -->
     
    <div class="card-body p-0">
        <!-- Tabla Responsive -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="100" class="ps-4">Código</th>
                        <th>Producto</th>
                        <th width="120">Lote</th>
                        <th width="100" class="text-center">Stock</th>
                        <th width="150" class="text-center">Vencimiento</th>
                        <th width="150" class="text-center">Estado</th>
                      
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $item)
                        @php
                            $hoy = \Carbon\Carbon::now();
                            $fechaVencimiento = \Carbon\Carbon::parse($item->fecha_vencimiento);
                            $dias = $fechaVencimiento->diffInDays($hoy);
                            $porcentaje = min(100, max(0, 100 - ($dias / 30 * 100)));
                            $vencido = $fechaVencimiento->lt($hoy);
                        @endphp
                        <tr class="{{ $vencido ? 'bg-light-danger' : ($dias <= 5 ? 'bg-light-warning' : '') }}">
                            <td class="ps-4 fw-bold text-muted">{{ $item->codigo }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-40px me-3">
                                        <span class="symbol-label {{ $vencido ? 'bg-light-danger' : 'bg-light-primary' }}">
                                            <i class="fas fa-box {{ $vencido ? 'text-danger' : 'text-primary' }}"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $item->nombre }}</div>
                                        
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light-secondary text-dark">{{ $item->numero_lote }}</span>
                            </td>
                            <td class="text-center fw-bold">{{ $item->cantidad_lote }}</td>
                            <td class="text-center">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $fechaVencimiento->format('d/m/Y') }}</span>
                                    
                                </div>
                            </td>
                            <td class="text-center">
    @if($vencido)
        <span class="badge bg-danger text-white">
            <i class="fas fa-exclamation-circle me-1"></i> Vencido
        </span>
    @else
        <div class="progress-container" style="width: 100px; margin: 0 auto;">
    <div class="d-flex justify-content-between small mb-1">
        <span class="{{ $dias <= 5 ? 'text-warning' : ($dias <= 15 ? 'text-info' : 'text-success') }}">
            {{ floor($dias) }} días
        </span>
        
    </div>
    
</div>
    @endif
</td>
                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay productos por vencer o vencidos</h5>
                                    <p class="text-muted small">No se encontraron registros con los filtros actuales</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    
</div>
    

        
    

            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <div class="text-muted small">
                    Mostrando {{ $productos->firstItem() }} a {{ $productos->lastItem() }} de {{ $productos->total() }} registros
                </div>
                <div>
                    {{ $productos->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection