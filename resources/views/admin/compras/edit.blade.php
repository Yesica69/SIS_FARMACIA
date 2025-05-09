@extends('layouts.app', ['title' => 'Editar Compra'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Compra #'.$compra->id])
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/compras') }}">Compras</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </nav>

            <!-- Card Principal -->
            <div class="card">
                <!-- Card Header -->
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Compra #{{ $compra->id }}</h3>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#collapseCard">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <form action="{{url('/admin/compras', $compra->id) }}" id="form_compra" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{$compra->id}}" id="id_compra" name="id_compra">

                        <div class="row">
                            <!-- Columna Izquierda -->
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" required>
                                            @error('cantidad')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="codigo" class="form-label">Código</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            <input id="codigo" type="text" class="form-control" name="codigo">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label" style="visibility: hidden;">Buscar</label>
                                            <div class="d-flex">
                                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#verModal">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                <a href="{{url('/admin/productos/create')}}" class="btn btn-success">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de Productos -->
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 5%; text-align: center">Nro</th>
                                                <th style="text-align: center">Código</th>
                                                <th style="text-align: center">Cantidad</th>
                                                <th style="text-align: center">Nombre</th>
                                                <th style="text-align: center">Costo</th>
                                                <th style="text-align: center">Total</th>
                                                <th style="text-align: center">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $cont = 1; $total_cantidad = 0; $total_compra = 0;?>
                                            @foreach($compra->detalles as $detalle)
                                                <tr>
                                                    <td style="text-align: center">{{$cont++}}</td>
                                                    <td style="text-align: center">{{$detalle->producto->codigo}}</td>
                                                    <td style="text-align: center">{{$detalle->cantidad}}</td>
                                                    <td>{{$detalle->producto->nombre}}</td>
                                                    <td style="text-align: center">{{$detalle->producto->precio_compra}}</td>
                                                    <td style="text-align: center">{{$costo = $detalle->cantidad * $detalle->producto->precio_compra}}</td>
                                                    <td style="text-align: center">
                                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$detalle->id}}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                    $total_cantidad += $detalle->cantidad;
                                                    $total_compra += $costo;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" style="text-align: right">Total</td>
                                                <td style="text-align: center"><b>{{$total_cantidad}}</b></td>
                                                <td colspan="2" style="text-align: right">Total compra</td>
                                                <td style="text-align: center"><b>{{$total_compra}}</b></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-md-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#labModal">
                                            <i class="fas fa-search me-2"></i>Buscar laboratorio
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" value="{{$compra->laboratorio->nombre}}" id="nombre_laboratorio" readonly>
                                        <input type="hidden" class="form-control" id="id_laboratorio" value="{{$compra->laboratorio->id}}" name="laboratorio_id">
                                    </div>
                                </div>

                                <hr>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" name="fecha" value="{{$compra->fecha}}">
                                            @error('fecha')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="comprobante" class="form-label">Comprobante</label>
                                            <select name="comprobante" id="comprobante" class="form-control">
                                                <option value="FACTURA" {{ trim($compra->comprobante) == 'FACTURA' ? 'selected' : '' }}>FACTURA</option>
                                                <option value="RECIBO" {{ trim($compra->comprobante) == 'RECIBO' ? 'selected' : '' }}>RECIBO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="precio_total" class="form-label">Total</label>
                                            <input type="text" style="text-align: center; background-color: #f8d7da" class="form-control" name="precio_total" value="{{$total_compra}}" readonly>
                                            @error('precio_total')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar compra</button>
                        </div>
                    </form>
                </div>
            </div>
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
    });

    // Seleccionar producto
    $(document).on('click', '.seleccionar-btn', function() {
        const id_producto = $(this).data('id');
        $('#codigo').val(id_producto);
        $('#verModal').modal('hide');
        $('#codigo').focus();
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