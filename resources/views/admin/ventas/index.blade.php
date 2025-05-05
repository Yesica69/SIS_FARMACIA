@extends('adminlte::page')

@section('content_header')
    <div class="content-header-container">
        <h1 class="content-header-title">
            <i class="fas fa-cash-register mr-2"></i>
            <span>Gestión de Ventas</span>
        </h1>
        <div class="content-header-actions">
            @if($cajaAbierto)
            <a href="{{ url('/admin/ventas/create') }}" class="btn btn-action btn-new">
                <i class="fas fa-plus-circle mr-1"></i> Nueva Venta
            </a>
            @else
            <a href="{{ url('/admin/cajas/create') }}" class="btn btn-action btn-danger">
                <i class="fas fa-lock-open mr-1"></i> Abrir Caja
            </a>
            @endif
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="elegant-card">
                <div class="elegant-card-header">
                    <h3 class="elegant-card-title">
                        <i class="fas fa-history mr-2"></i> Historial de Ventas
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="elegant-card-body">
                    <div class="table-responsive-lg">
                        <table id="ventasTable" class="table table-elegant">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Detalles</th>
                                    <th class="text-center">Fecha/Hora</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ventas as $index => $venta)
                                <tr>
                                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-details" data-toggle="collapse" 
                                                data-target="#details-{{ $venta->id }}" 
                                                aria-expanded="false">
                                            <i class="fas fa-chevron-down mr-1"></i>
                                            Ver productos ({{ count($venta->detallesVenta) }})
                                        </button>
                                        <div id="details-{{ $venta->id }}" class="collapse">
                                            <div class="product-details-container">
                                                <table class="table table-sm table-details">
                                                    <thead>
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th class="text-center">Cantidad</th>
                                                            
                                                            <th class="text-right">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($venta->detallesVenta as $detalle)
                                                        <tr>
                                                            <td>{{ $detalle->producto->nombre }}</td>
                                                            <td class="text-center">{{ $detalle->cantidad }}</td>
                                                           
                                                            <td class="text-right">Bs{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</td>
                                    <td class="align-middle text-success font-weight-bold">Bs{{ number_format($venta->precio_total, 2) }}</td>
                                    <td class="text-center align-middle">
                                        <div class="btn-action-group">
                                            <!-- Botón PDF -->
                                            <a href="{{ url('/admin/ventas/pdf/' . $venta->id) }}" 
                                               target="_blank" 
                                               class="btn btn-action btn-pdf" 
                                               title="Imprimir PDF">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            
                                            <!-- Botón Ver -->
                                            <a href="{{ url('/admin/ventas', $venta->id) }}" 
                                               class="btn btn-action btn-view" 
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ url('/admin/ventas', $venta->id) }}" 
   class="btn btn-action btn-view" 
   title="Ver detalles"
   data-toggle="modal" 
   data-target="#ventaModal{{ $venta->id }}"
   data-venta-id="{{ $venta->id }}">
    <i class="fas fa-eye"></i>
</a>


<!-- Modal para ver detalles de venta -->
<div class="modal fade" id="ventaModal" tabindex="-1" role="dialog" aria-labelledby="ventaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ventaModalLabel">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>
                    Detalle de Venta #{{ $venta->id }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Sección de productos -->
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover table-details">
                                    <thead class="thead-dark">
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
                                            <td class="text-right">${{ number_format($detalle->producto->precio_venta, 2) }}</td>
                                            <td class="text-right">${{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="2" class="text-right"><strong>Total:</strong></td>
                                            <td class="text-center"><strong>{{ $total_cantidad }}</strong></td>
                                            <td colspan="2" class="text-right"><strong>Total Venta:</strong></td>
                                            <td class="text-right text-success"><strong>${{ number_format($total_venta, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Sección de información -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user-tie mr-2"></i> Información del Cliente
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted mb-1">Nombre</label>
                                        <p class="font-weight-bold">{{ $venta->cliente ? $venta->cliente->nombre_cliente : 'Cliente no especificado' }}</p>
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <label class="small text-muted mb-1">NIT/CI</label>
                                        <p class="font-weight-bold">{{ $venta->cliente ? $venta->cliente->nit_ci : 'NIT/CI no especificado' }}</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Fecha</label>
                                        <p class="font-weight-bold">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle mr-2"></i> Información Adicional
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="small text-muted mb-1">Registrado por</label>
                                        <p class="font-weight-bold">{{ $venta->user->name ?? 'Usuario no disponible' }}</p>
                                    </div>
                                    
                                    <div class="text-center mt-4">
                                        <a href="{{ url('/admin/ventas/pdf/' . $venta->id) }}" target="_blank" class="btn btn-danger btn-sm btn-block">
                                            <i class="fas fa-file-pdf mr-2"></i> Exportar a PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Cerrar
                </button>
                <a href="{{ url('/admin/ventas/' . $venta->id . '/edit') }}" class="btn btn-primary">
                    <i class="fas fa-edit mr-2"></i> Editar Venta
                </a>
            </div>
        </div>
    </div>
</div>
                                            
                                            <!-- Botón Editar -->
                                            <a href="{{ url('/admin/ventas/'.$venta->id.'/edit') }}" 
                                               class="btn btn-action btn-edit" 
                                               title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                            <!-- Botón Eliminar -->
                                            <form action="{{ url('/admin/ventas', $venta->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-action btn-delete" 
                                                        title="Eliminar"
                                                        onclick="return confirm('¿Confirmas eliminar esta venta?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="elegant-card-footer">
                    <div class="summary-info">
                        <span class="badge badge-summary">
                            <i class="fas fa-database mr-1"></i>
                            Total registros: {{ count($ventas) }}
                        </span>
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
        --success-color: #2ecc71;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --info-color: #1abc9c;
        --light-color: #ecf0f1;
        --dark-color: #34495e;
        --border-radius: 0.375rem;
        --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Estructura principal */
    .content-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background-color: white;
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

    /* Tarjeta elegante */
    .elegant-card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .elegant-card-header {
        background-color: white;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .elegant-card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--secondary-color);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .elegant-card-body {
        padding: 1.5rem;
    }

    .elegant-card-footer {
        padding: 1rem 1.5rem;
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Tabla elegante */
    .table-elegant {
        width: 100%;
        margin-bottom: 0;
    }

    .table-elegant thead th {
        background-color: var(--light-color);
        color: var(--secondary-color);
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    .table-elegant tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #f1f1f1;
    }

    .table-elegant tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }

    /* Botones y acciones */
    .btn-action {
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        margin: 0 3px;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-new {
        background-color: var(--success-color);
        color: white;
    }

    .btn-view {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-edit {
        background-color: var(--warning-color);
        color: white;
    }

    .btn-delete {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-pdf {
        background-color: #e74c3c;
        color: white;
    }

    .btn-details {
        background-color: var(--info-color);
        color: white;
        border-radius: 50px;
        padding: 0.375rem 1rem;
        transition: var(--transition);
    }

    .btn-details:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-details[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
    }

    /* Detalles de productos */
    .product-details-container {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: var(--border-radius);
        margin-top: 0.5rem;
    }

    .table-details {
        background-color: white;
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .table-details thead th {
        background-color: #e9ecef;
    }

    /* Badges */
    .badge-summary {
        background-color: var(--secondary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-header-container {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .content-header-actions {
            margin-top: 1rem;
            width: 100%;
        }
        
        .btn-action-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .table-elegant thead {
            display: none;
        }
        
        .table-elegant tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: var(--border-radius);
        }
        
        .table-elegant tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem;
            border-top: none;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .table-elegant tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: var(--secondary-color);
        }
        
        .table-elegant tbody td:last-child {
            border-bottom: none;
        }
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#ventasTable').DataTable({
            "pageLength": 10,
            "responsive": true,
            "autoWidth": false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "<i class='fas fa-search'></i> Buscar:",
                "paginate": {
                    "first": "<i class='fas fa-angle-double-left'></i>",
                    "last": "<i class='fas fa-angle-double-right'></i>",
                    "next": "<i class='fas fa-angle-right'></i>",
                    "previous": "<i class='fas fa-angle-left'></i>"
                },
                "loadingRecords": "<i class='fas fa-spinner fa-spin'></i> Cargando...",
                "processing": "<i class='fas fa-cog fa-spin'></i> Procesando..."
            },
            "columnDefs": [
                { "responsivePriority": 1, "targets": 0 },
                { "responsivePriority": 2, "targets": -1 },
                { "responsivePriority": 3, "targets": 2 }
            ],
            "drawCallback": function(settings) {
                // Añadir data-labels para responsive
                if ($(window).width() < 768) {
                    $('#ventasTable tbody td').each(function() {
                        var header = $(this).parent().find('td').eq($(this).index()).text();
                        $(this).attr('data-label', header);
                    });
                }
            }
        });

        // Rotar icono de chevron al expandir detalles
        $('.btn-details').click(function() {
            $(this).find('.fa-chevron-down').toggleClass('rotate');
        });
    });
</script>
@endsection