@extends('adminlte::page')

@section('content_header')
<div class="content-header-container">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="content-header-title">
            <i class="fas fa-file-invoice-dollar mr-2"></i>
            <span>Detalle de Venta #{{ $venta->id }}</span>
        </h1>
        <div class="header-actions">
            <a href="{{ url('/admin/ventas') }}" class="btn btn-back">
                <i class="fas fa-arrow-left mr-1"></i> Volver al listado
            </a>
            <a href="{{ url('/admin/ventas/pdf/' . $venta->id) }}" target="_blank" class="btn btn-pdf ml-2">
                <i class="fas fa-file-pdf mr-1"></i> Exportar PDF
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="invoice-card">
                <div class="invoice-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="invoice-card-title">
                            <i class="fas fa-receipt mr-2"></i> Resumen de la venta
                        </h3>
                        <span class="badge badge-status">
                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
                
                <div class="invoice-card-body">
                    <div class="row">
                        <!-- Sección de productos -->
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-products">
                                    <thead class="thead-products">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Código</th>
                                            <th class="text-center">Cantidad</th>
                                            <th>Producto</th>
                                            <th class="text-right">P. Unitario</th>
                                            <th class="text-right">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $total_cantidad = 0; 
                                            $total_venta = 0; 
                                        @endphp
                                        
                                        @foreach($venta->detallesVenta as $index => $detalle)
                                        @php
                                            $subtotal = $detalle->cantidad * $detalle->producto->precio_venta;
                                            $total_cantidad += $detalle->cantidad;
                                            $total_venta += $subtotal;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $detalle->producto->codigo }}</td>
                                            <td class="text-center">{{ $detalle->cantidad }}</td>
                                            <td>{{ $detalle->producto->nombre }}</td>
                                            <td class="text-right">Bs{{ number_format($detalle->producto->precio_venta, 2) }}</td>
                                            <td class="text-right">Bs{{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Sección de información del cliente y totales -->
                        <div class="col-md-4">
                            <div class="client-info-card">
                                <div class="client-info-header">
                                    <h4><i class="fas fa-user-tie mr-2"></i> Información del Cliente</h4>
                                </div>
                                <div class="client-info-body">
                                    <div class="form-group">
                                        <label>Nombre del cliente</label>
                                        <div class="form-control-static">
                                            {{ $venta->cliente ? $venta->cliente->nombre_cliente : 'Cliente no especificado' }}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>NIT/CI</label>
                                        <div class="form-control-static">
                                            {{ $venta->cliente ? $venta->cliente->nit_ci : 'NIT/CI no especificado' }}
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Fecha de venta</label>
                                        <div class="form-control-static">
                                            {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="summary-card mt-3">
                                <div class="summary-header">
                                    <h4><i class="fas fa-calculator mr-2"></i> Totales</h4>
                                </div>
                                <div class="summary-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Total productos:</span>
                                        <strong>{{ $total_cantidad }}</strong>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <span>Total venta:</span>
                                        <strong class="total-amount">Bs{{ number_format($total_venta, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="invoice-card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="footer-notes">
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Venta registrada por: {{ $venta->user->name ?? 'Usuario no disponible' }}
                            </small>
                        </div>
                        <div class="footer-actions">
                            <a href="{{ url('/admin/ventas/' . $venta->id . '/edit') }}" class="btn btn-edit">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Estilos base */
    :root {
        --primary-color: #3498db;
        --secondary-color: #2c3e50;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #fd7e14;
        --info-color: #17a2b8;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --border-radius: 0.375rem;
        --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Estructura principal */
    .content-header-container {
        background-color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 1.5rem;
    }

    .content-header-title {
        display: flex;
        align-items: center;
        color: var(--secondary-color);
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    /* Tarjeta de factura */
    .invoice-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .invoice-card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
    }

    .invoice-card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--secondary-color);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .invoice-card-body {
        padding: 1.5rem;
    }

    .invoice-card-footer {
        padding: 1rem 1.5rem;
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Tabla de productos */
    .table-products {
        width: 100%;
        margin-bottom: 0;
    }

    .thead-products {
        background-color: var(--light-color);
        color: var(--secondary-color);
    }

    .table-products th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 0.75rem;
    }

    .table-products td {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #f1f1f1;
    }

    .table-products tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    /* Tarjeta de información del cliente */
    .client-info-card, .summary-card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: var(--border-radius);
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .client-info-header, .summary-header {
        background-color: var(--light-color);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .client-info-header h4, .summary-header h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .client-info-body, .summary-body {
        padding: 1rem;
        background-color: white;
    }

    .form-control-static {
        display: block;
        padding: 0.375rem 0.75rem;
        background-color: #f8f9fa;
        border-radius: var(--border-radius);
        min-height: calc(1.5em + 0.75rem + 2px);
    }

    /* Badges */
    .badge-status {
        background-color: var(--info-color);
        color: white;
        padding: 0.35em 0.65em;
        font-weight: 500;
        border-radius: 50px;
    }

    /* Botones */
    .btn-back {
        background-color: var(--secondary-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        padding: 0.375rem 0.75rem;
        transition: var(--transition);
    }

    .btn-back:hover {
        background-color: #1d2124;
        color: white;
        transform: translateY(-1px);
    }

    .btn-pdf {
        background-color: var(--danger-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        padding: 0.375rem 0.75rem;
        transition: var(--transition);
    }

    .btn-pdf:hover {
        background-color: #c82333;
        color: white;
        transform: translateY(-1px);
    }

    .btn-edit {
        background-color: var(--warning-color);
        color: white;
        border: none;
        border-radius: var(--border-radius);
        padding: 0.375rem 0.75rem;
        transition: var(--transition);
    }

    .btn-edit:hover {
        background-color: #e0a800;
        color: white;
        transform: translateY(-1px);
    }

    /* Totales */
    .total-amount {
        color: var(--success-color);
        font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-header-container {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .header-actions {
            margin-top: 1rem;
            width: 100%;
        }
        
        .invoice-card-body .row {
            flex-direction: column-reverse;
        }
        
        .col-md-8, .col-md-4 {
            width: 100%;
            max-width: 100%;
        }
        
        .client-info-card, .summary-card {
            margin-top: 1.5rem;
        }
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Inicialización de tooltips si es necesario
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection