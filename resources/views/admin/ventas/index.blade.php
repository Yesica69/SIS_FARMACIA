@extends('layouts.app', ['title' => 'Gestión '])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Gestión '])
<div class="container-fluid mt--6">
    <!-- Header -->
    <div class="header bg-gradient-primary pb-6 pt-5 pt-md-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">
                            <i class="fas fa-cash-register mr-2"></i> Gestión de Ventas
                        </h6>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">
                                    <i class="fas fa-history mr-2"></i> Historial de Ventas
                                </h3>
                            </div>
                            <div class="col-4 text-end">
                        <div class="col-md-6 text-md-right">
                @if(isset($cajaAbierto) && $cajaAbierto)
                    <a href="{{ url('/admin/ventas/create') }}" 
                       class="btn btn-success btn-lg"
                       style="border-radius: 50px; padding: 8px 20px;">
                       <i class="fas fa-plus-circle"></i> REGISTRAR Venta
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
                    
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ventasTable" class="table align-items-center table-flush">
                                <thead class="thead-light">
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
                                            <button class="btn btn-sm btn-info" data-bs-toggle="collapse" 
                                                    data-bs-target="#details-{{ $venta->id }}" 
                                                    aria-expanded="false">
                                                <i class="fas fa-chevron-down mr-1"></i>
                                                Ver productos ({{ count($venta->detallesVenta) }})
                                            </button>
                                            <div id="details-{{ $venta->id }}" class="collapse">
                                                <div class="mt-3">
                                                    <table class="table table-sm table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Producto</th>
                                                                <th class="text-center">Cantidad</th>
                                                                <th class="text-end">Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($venta->detallesVenta as $detalle)
                                                            <tr>
                                                                <td>{{ $detalle->producto->nombre }}</td>
                                                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                                                <td class="text-end">Bs{{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</td>
                                        <td class="align-middle text-success fw-bold">Bs{{ number_format($venta->precio_total, 2) }}</td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-center">
                                                <!-- Botón PDF -->
                                                <a href="{{ url('/admin/ventas/pdf/' . $venta->id) }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-danger mx-1" 
                                                   title="Imprimir PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                </a>
                                                
                                                <!-- Botón Ver -->
                                                <a href="{{ url('/admin/ventas', $venta->id) }}" 
                                                   class="btn btn-sm btn-primary mx-1" 
                                                   title="Ver detalles"
                                                   >
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                               
                                                
                                                <!-- Botón Editar -->
                                                <a href="{{ url('/admin/ventas/'.$venta->id.'/edit') }}" 
                                                   class="btn btn-sm btn-warning mx-1" 
                                                   title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                
                                                <!-- Botón Eliminar -->
                                                <form action="{{ url('/admin/ventas', $venta->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger mx-1" 
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
                    
                    <!-- Card footer -->
                    <div class="card-footer py-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">
                                <i class="fas fa-database mr-1"></i>
                                Total registros: {{ count($ventas) }}
                            </span>
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
    /* Estilos personalizados para Argon */
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    .btn-sm {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-xl {
        max-width: 1140px;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                }
            },
            "columnDefs": [
                { "responsivePriority": 1, "targets": 0 },
                { "responsivePriority": 2, "targets": -1 },
                { "responsivePriority": 3, "targets": 2 }
            ]
        });

        // Rotar icono de chevron al expandir detalles
        $('[data-bs-toggle="collapse"]').on('click', function() {
            $(this).find('.fa-chevron-down').toggleClass('rotate-180');
        });
    });
</script>
@endsection