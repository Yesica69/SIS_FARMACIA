@extends('layouts.app', ['title' => 'Gestión de Compras'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Compras'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Productos con Bajo Stock
                    </h5>
                    @if($sucursalId > 0)
                        <span class="badge bg-primary">
                            Sucursal: {{ App\Models\Sucursal::find($sucursalId)->nombre }}
                        </span>
                    @endif
                    <div class="mt-3 text-center">
                        <a href="{{ route('admin.inventario.index') }}?sucursal={{ $sucursalId }}" class="btn btn-sm btn-primary">
                            <i class="ni ni-zoom-split-in"></i> Volver
                        </a>
                    </div>
                </div>

                
             </div>
             
             </div>
             </div>
             <hr>

<div class="card shadow border-0">
    <div class="card-header bg-white text-white py-2 "style="height: 50px;">
        <div class="d-flex justify-content-between align-items-center">
            
            <div class="d-flex align-items-center">
                <i class=" bg-black fas fa-exclamation-triangle me-2" style="font-size: 0.9rem"></i>
                <h6 class="mb-0" style="font-size: 0.95rem">LISTADO DE PRODUCTOS CON STOCK BAJO</h6>
            </div>
            <span class="badge bg-white text-danger" style="font-size: 0.75rem">
                {{ $productos->total() }} PRODUCTOS
            </span>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="bg-light">
                    <tr style="font-size: 0.8rem">
                        <th class="ps-3">Código</th>
                        <th>Producto</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Mínimo</th>
                        <th class="text-center">Diferencia</th>
                        <th class="text-center">Estado</th>
                        
                        <th class="text-center pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    @php
                        $stockActual = $producto->lotes->sum('cantidad');
                        $diferencia = $stockActual - $producto->stock_minimo;
                        $statusClass = $stockActual <= 0 ? 'danger' : ($diferencia < 0 ? 'warning' : 'info');
                    @endphp
                    <tr class="{{ $stockActual <= 0 ? 'bg-danger-soft' : ($diferencia < 0 ? 'bg-warning-soft' : 'bg-info-soft') }}" style="font-size: 0.82rem">
                        <td class="ps-3 font-weight-bold">{{ $producto->codigo ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-light rounded-circle mr-2" style="width: 28px; height: 28px;">
                                    <i class="fas fa-pills text-{{ $statusClass }}" style="font-size: 0.9rem"></i>
                                </div>
                                <div>
                                    <span class="d-block font-weight-bold">{{ $producto->nombre }}</span>
                                    <small class="text-muted" style="font-size: 0.75rem">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center font-weight-bold text-{{ $statusClass }}">
                            {{ $stockActual }}
                        </td>
                        <td class="text-center">{{ $producto->stock_minimo }}</td>
                        <td class="text-center font-weight-bold {{ $diferencia < 0 ? 'text-danger' : 'text-success' }}">
                            {{ $diferencia }}
                        </td>
                        <td class="text-center">
                            @if($stockActual <= 0)
                                <span class="badge bg-danger py-1 px-2" style="font-size: 0.7rem">
                                    <i class="fas fa-times-circle me-1"></i> SIN STOCK
                                </span>
                            @elseif($diferencia < 0)
                                <span class="badge bg-warning py-1 px-2" style="font-size: 0.7rem">
                                    <i class="fas fa-exclamation-triangle me-1"></i> CRÍTICO
                                </span>
                            @elseif($stockActual < ($producto->stock_minimo * 1.5))
                                <span class="badge bg-info py-1 px-2" style="font-size: 0.7rem">
                                    <i class="fas fa-info-circle me-1"></i> PRECAUCIÓN
                                </span>
                            @else
                                <span class="badge bg-success py-1 px-2" style="font-size: 0.7rem">
                                    <i class="fas fa-check-circle me-1"></i> NORMAL
                                </span>
                            @endif
                        </td>
                        
                        <td class="text-center pe-3">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.productos.create', $producto->id) }}" 
                                   class="btn btn-xs btn-primary mx-1" 
                                   data-toggle="tooltip" 
                                   title="Reabastecer"
                                   style="padding: 0.15rem 0.3rem; font-size: 0.7rem">
                                    <i class="fas fa-warehouse"></i>
                                </a>
                                
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-footer bg-light py-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="legend" style="font-size: 0.75rem">
                <span class="badge bg-danger-soft text-danger mr-2">
                    <i class="fas fa-circle me-1"></i> Sin stock
                </span>
                <span class="badge bg-warning-soft text-warning mr-2">
                    <i class="fas fa-circle me-1"></i> Crítico
                </span>
                <span class="badge bg-info-soft text-info mr-2">
                    <i class="fas fa-circle me-1"></i> Precaución
                </span>
                <span class="badge bg-success-soft text-success">
                    <i class="fas fa-circle me-1"></i> Normal
                </span>
            </div>
            <div style="font-size: 0.8rem">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .avatar {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.08) !important;
    }
    .bg-warning-soft {
        background-color: rgba(255, 193, 7, 0.08) !important;
    }
    .bg-info-soft {
        background-color: rgba(23, 162, 184, 0.08) !important;
    }
    .bg-success-soft {
        background-color: rgba(25, 135, 84, 0.08) !important;
    }
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    .table-sm th, .table-sm td {
        padding: 0.4rem 0.5rem;
    }
    .btn-xs {
        padding: 0.15rem 0.3rem;
        font-size: 0.7rem;
        line-height: 1.2;
    }
</style>


            </div>
        </div>
    </div>
</div>
@endsection