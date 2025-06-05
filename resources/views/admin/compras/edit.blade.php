@extends('layouts.app', ['title' => 'Editar Compra'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Compra #'.$compra->id])
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <!-- Encabezado -->
            <div class="card shadow mb-4 border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Compra #{{ $compra->id }}</h4>
                </div>
            </div>

            <form action="{{ url('/admin/compras', $compra->id) }}" method="post" id="form_compra">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_compra" value="{{ $compra->id }}">

                <div class="row">
                    <!-- Columna izquierda: Productos -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-4 border-0">
                            <div class="card-header bg-light">
                                <strong>Productos</strong>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-2">
                                        <label class="form-label">Cantidad</label>
                                        <input type="number" name="cantidad" value="1" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Código</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            <input type="text" id="codigo" name="codigo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#verModal">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="{{ url('/admin/productos/create') }}" class="btn btn-outline-success">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Tabla de productos -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light text-center">
                                        <tr>
                <th class="text-center px-1" style="width: 3%;">#</th>
                <th class="text-center px-1" style="width: 10%;">Código</th>
                <th class="text-center px-1" style="width: 5%;">Cantidad</th>
                <th class="px-1" style="width: 40%;">Nombre</th>
                
                <th class="text-end px-1" style="width: 12%;">Unit.</th>
                <th class="text-end px-1" style="width: 15%;">total</th>
                <th class="text-center px-1" style="width: 5%;"></th>
                
            </tr>
                                        </thead>
                                        <tbody>
                                            @php $cont = 1; $total_cantidad = 0; $total_compra = 0; @endphp
                                            @foreach($compra->detalles as $detalle)
                                            <tr>
                                                <td>{{ $cont++ }}</td>
                                                <td>{{ $detalle->producto->codigo }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>{{ $detalle->producto->nombre }}</td>
                                                <td>{{ number_format($detalle->producto->precio_compra, 2) }}</td>
                                                <td>
                                                    @php $costo = $detalle->cantidad * $detalle->producto->precio_compra; @endphp
                                                    {{ number_format($costo, 2) }}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $detalle->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                                $total_cantidad += $detalle->cantidad;
                                                $total_compra += $costo;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="2" class="text-end fw-bold">Total</td>
                                                <td class="text-center fw-bold">{{ $total_cantidad }}</td>
                                                <td colspan="2" class="text-end fw-bold">Total Compra</td>
                                                <td class="text-center fw-bold">{{ number_format($total_compra, 2) }}</td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna derecha: Detalles de compra -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm mb-4 border-0">
                            <div class="card-header bg-light">
                                <strong>Detalles de compra</strong>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Laboratorio</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#labModal">
                                            <i class="fas fa-search me-2"></i>Buscar
                                        </button>
                                        <input type="text" class="form-control ms-2" value="{{ $compra->laboratorio->nombre }}" id="nombre_laboratorio" readonly>
                                        <input type="hidden" name="laboratorio_id" value="{{ $compra->laboratorio->id }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="{{ $compra->fecha }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Comprobante</label>
                                    <select name="comprobante" class="form-select">
                                        <option value="FACTURA" {{ trim($compra->comprobante) == 'FACTURA' ? 'selected' : '' }}>FACTURA</option>
                                        <option value="RECIBO" {{ trim($compra->comprobante) == 'RECIBO' ? 'selected' : '' }}>RECIBO</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Total</label>
                                    <input type="text" class="form-control text-center bg-gradient-danger text-white fw-bold fs-5" name="precio_total" value="{{ number_format($total_compra, 2) }}" readonly>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Actualizar Compra</button>
                                </div>
                                <a href="{{url('/admin/compras')}}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Productos -->
<div class="modal fade" id="verModal" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verModalLabel">Listado de productos</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mitabla" class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nro</th>
                            <th>Acción</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            
                            <th>Imagen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        @foreach($productos as $producto)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info seleccionar-btn" data-id="{{$producto->codigo}}">
                                    Seleccionar
                                </button>
                            </td>
                            <td>{{ $producto->codigo }}</td>
                            <td><strong>{{ $producto->nombre }}</strong></td>
                            <td>{{ $producto->descripcion }}</td>
                            
                            <td class="text-center">
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" width="80" height="80" alt="Imagen">
                                @else
                                    <p>Sin imagen</p>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Laboratorios -->
<div class="modal fade" id="labModal" tabindex="-1" aria-labelledby="labModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="labModalLabel">Listado de laboratorios</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mitabla2" class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nro</th>
                            <th>Acción</th>
                            <th>Laboratorio</th>
                            <th>Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        @foreach($laboratorios as $laboratorio)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info seleccionar-btn-laboratorio" 
                                        data-id="{{$laboratorio->id}}" 
                                        data-nombre="{{$laboratorio->nombre}}">
                                    Seleccionar
                                </button>
                            </td>
                            <td><strong>{{ $laboratorio->nombre }}</strong></td>
                            <td>{{ $laboratorio->telefono }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .table thead th {
        background-color: #f1f5f9;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Seleccionar laboratorio
$(document).on('click', '.seleccionar-btn-laboratorio', function() {
    const id_laboratorio = $(this).data('id');
    const nombre = $(this).data('nombre');
    $('#nombre_laboratorio').val(nombre);
    $('#id_laboratorio').val(id_laboratorio);
    $('#labModal').modal('hide');

    // Eliminar manualmente el backdrop si persiste
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open'); // Asegura que se pueda hacer scroll nuevamente
});

   // Seleccionar producto
$(document).on('click', '.seleccionar-btn', function() {
    const id_producto = $(this).data('id');
    $('#codigo').val(id_producto);
    $('#verModal').modal('hide');
    $('#codigo').focus();

    // Eliminar manualmente el backdrop si persiste
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
});

    // Eliminar producto
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{url('/admin/compras/detalle')}}/"+id,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Producto eliminado",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            } else {
                                Swal.fire('Error', response.message || 'Error al eliminar', 'error');
                            }
                        },
                        error: function(error) {
                            Swal.fire('Error', 'Error en la conexión', 'error');
                        }
                    });
                }
            });
        }
    });

    // Buscar producto por código
    $('#codigo').focus();
    $('#form_compra').on('keypress', function(e) {
        if(e.keyCode === 13) {   
            e.preventDefault();
        }
    });
    
    $('#codigo').on('keyup', function(e) {
        if (e.which === 13) {
            const codigo = $(this).val();
            const cantidad = $('#cantidad').val();
            const id_compra = $('#id_compra').val();
            const id_laboratorio = $('#id_laboratorio').val();

            if(codigo.length > 0) {
                $.ajax({
                    url: "{{ route('admin.detalle.compras.store') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        codigo: codigo,
                        cantidad: cantidad,
                        id_compra: id_compra,
                        id_laboratorio: id_laboratorio
                    },
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Producto agregado",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload();
                        } else {
                            Swal.fire('Error', response.message || 'Error al agregar', 'error');
                        }
                    },
                    error: function(error) {
                        Swal.fire('Error', 'Error en la conexión', 'error');
                    }
                });
            }
        }
    });

    // DataTables
    $('#mitabla').DataTable({
        "pageLength": 5,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    $('#mitabla2').DataTable({
        "pageLength": 5,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
});
</script>
@endsection