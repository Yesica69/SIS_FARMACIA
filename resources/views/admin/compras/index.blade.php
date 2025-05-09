@extends('layouts.app', ['title' => 'Gestión de Compras'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Compras'])
<div class="header bg-primary py-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="text-white mb-0">
                    <i class="fas fa-file-invoice-dollar"></i> Gestión de Compras
                </h2>
            </div>
            
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">
                                <i class="fas fa-history me-2"></i> Historial de Compras
                            </h3>
                        </div>
                        <div class="col-4 text-end">
                        <div class="col-md-6 text-md-right">
                @if(isset($cajaAbierto) && $cajaAbierto)
                    <a href="{{ url('/admin/compras/create') }}" 
                       class="btn btn-success btn-lg"
                       style="border-radius: 50px; padding: 8px 20px;">
                       <i class="fas fa-plus-circle"></i> REGISTRAR COMPRA
                    </a>
                @else
                    <a href="{{ url('/admin/cajas/create') }}" 
                       class="btn btn-danger btn-lg"
                       style="border-radius: 50px; padding: 8px 20px;">
                       <i class="fas fa-lock-open"></i> ABRIR CAJA
                    </a>
                @endif
            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="comprasTable" class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Detalles</th>
                                    <th class="text-center">Fecha/Hora</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Comprobante</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($compras as $index => $compra)
                                <tr>
                                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-info" data-bs-toggle="collapse" 
                                                data-bs-target="#details-{{ $compra->id }}" 
                                                aria-expanded="false">
                                            <i class="fas fa-chevron-down me-1"></i>
                                            Ver productos ({{ count($compra->detalles) }})
                                        </button>
                                        <div id="details-{{ $compra->id }}" class="collapse">
                                            <div class="mt-3 bg-soft-info p-3 rounded">
                                                <table class="table table-sm">
                                                    <thead class="bg-gradient-info text-white">
                                                        <tr>
                                                            <th>Producto</th>
                                                            <th class="text-center">Cantidad</th>
                                                            <th class="text-end">P. Unitario</th>
                                                            <th class="text-end">Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($compra->detalles as $detalle)
                                                        <tr>
                                                            <td>{{ $detalle->producto->nombre }}</td>
                                                            <td class="text-center">{{ $detalle->cantidad }}</td>
                                                            <td class="text-end">Bs{{ number_format($detalle->precio_unitario, 2) }}</td>
                                                            <td class="text-end">Bs{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y H:i') }}</td>
                                    <td class="align-middle text-success fw-bold">Bs{{ number_format($compra->precio_total, 2) }}</td>
                                    <td class="align-middle">
                                        <span class="badge bg-primary">{{ $compra->comprobante }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ url('/admin/compras', $compra->id) }}" 
                                               class="btn btn-sm btn-icon btn-primary mx-1" 
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            
                                            
                                            <a href="{{ url('/admin/compras/'.$compra->id.'/edit') }}" 
                                               class="btn btn-sm btn-icon btn-info mx-1" 
                                               title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            
                                            <form action="{{ url('/admin/compras', $compra->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-icon btn-danger mx-1" 
                                                        title="Eliminar"
                                                        onclick="return confirm('¿Confirmas eliminar esta compra?')">
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
                <div class="card-footer py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-default">
                            <i class="fas fa-database me-1"></i>
                            Total registros: {{ count($compras) }}
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
    /* Estilos personalizados adicionales */
    .bg-soft-info {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Ajustes para la tabla responsive */
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
        }
        
        #comprasTable tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        
        #comprasTable tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem;
            border-top: none;
            border-bottom: 1px solid #f1f1f1;
        }
        
        #comprasTable tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: #525f7f;
        }
        
        #comprasTable tbody td:last-child {
            border-bottom: none;
        }
    }
</style>
@endsection

@section('js')
<!-- Incluir DataTables para Bootstrap 5 -->
<script src="{{ asset('argon/js/argon-dashboard.js') }}"></script>
<script src="{{ asset('vendor/argon-dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/argon-dashboard/js/plugins/dataTables/dataTables.bootstrap5.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
        const table = $('#comprasTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "responsive": true,
            "autoWidth": false,
            "drawCallback": function(settings) {
                // Añadir data-labels para responsive
                if (window.innerWidth < 768) {
                    $('#comprasTable tbody td').each(function() {
                        var header = $('#comprasTable thead th').eq($(this).index()).text();
                        $(this).attr('data-label', header);
                    });
                }
            }
        });

        // Rotar icono de chevron al expandir detalles
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('.fa-chevron-down');
                if (icon) {
                    icon.classList.toggle('rotate-180');
                }
            });
        });
    });
</script>
@endsection