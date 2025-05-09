@extends('layouts.app', ['title' => 'Nueva compra'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Nueva compra'])
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Ingrese los datos</h3>
                        </div>
                        <div class="col-4 text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#formCollapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.compras.create') }}" id="form_compra" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Cantidad -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad" class="form-control-label">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" required>
                                            @error('cantidad')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Código -->
                                    <div class="col-md-6">
                                        <label for="codigo" class="form-control-label">Código</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            <input id="codigo" type="text" class="form-control" name="codigo">
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" style="visibility: hidden;">Buscar</label>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verModal">
                                                <i class="fas fa-search"></i>
                                            </button>

                                            <a href="{{url('/admin/productos/create')}}" type="button" class="btn btn-success">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de productos detalle  -->
                                <div class="table-responsive">
                                    <table class="table table-sm align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nro</th>
                                                <th>Código</th>
                                                <th>Cantidad</th>
                                                <th>Nombre</th>
                                                <th>Costo</th>
                                                <th>Total</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $cont = 1; $total_cantidad = 0; $total_compra = 0;?>
                                            @foreach($tmp_compras as $tmp_compra)
                                            <tr>
                                                <td>{{$cont++}}</td>
                                                <td>{{$tmp_compra->producto->codigo}}</td>
                                                <td>{{$tmp_compra->cantidad}}</td>
                                                <td>{{$tmp_compra->producto->nombre}}</td>
                                                <td>{{$tmp_compra->producto->precio_compra}}</td>
                                                <td>{{$costo = $tmp_compra->cantidad * $tmp_compra->producto->precio_compra}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-icon btn-danger delete-btn" data-id="{{$tmp_compra->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                            $total_cantidad += $tmp_compra->cantidad;
                                            $total_compra += $costo;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-end"><strong>Total</strong></td>
                                                <td><strong>{{$total_cantidad}}</strong></td>
                                                <td colspan="2" class="text-end"><strong>Total compra</strong></td>
                                                <td><strong>{{$total_compra}}</strong></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="col-md-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#labModal">
                                            <i class="fas fa-search"></i> Buscar laboratorio
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <!--añadir el nombre del laboratorio selecionado-->
                                        <input type="text" class="form-control" id="nombre_laboratorio" disabled>
                                        <input type="text" class="form-control" id="id_laboratorio" name="laboratorio_id" hidden>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha" class="form-control-label">Fecha</label>
                                            <input type="date" class="form-control" name="fecha" value="{{ old('fecha') }}">
                                            @error('fecha')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="comprobante" class="form-control-label">Comprobante</label>
                                            <select name="comprobante" id="comprobante" class="form-control">
                                                <option value="FACTURA">FACTURA</option>
                                                <option value="RECIBO">RECIBO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="precio_total" class="form-control-label">Total</label>
                                            <input type="text" style="text-align: center; background-color: #f8d7da" class="form-control" name="precio_total" 
                                                value="{{ isset($total_compra) ? $total_compra : '' }}" readonly>
                                            @error('precio_total')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Registrar compra</button>
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
                                <button type="button" class="btn btn-sm btn-info btn-seleccionar-producto" 
                                        data-bs-dismiss="modal"
                                        data-codigo="{{$producto->codigo}}">
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
                                <button type="button" class="btn btn-sm btn-info btn-seleccionar-laboratorio" 
                                        data-bs-dismiss="modal"
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
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/argon-dashboard/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/argon-dashboard/js/plugins/dataTables/dataTables.bootstrap5.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>




$(document).ready(function() {
 // Versión jQuery compatible con Argon
$(document).ready(function() {
    // Selección de laboratorio
    $(document).on('click', '.seleccionar-btn-laboratorio', function() {
        const id_laboratorio = $(this).data('id');
        const nombre = $(this).data('nombre');
        
        $('#nombre_laboratorio').val(nombre);
        $('#id_laboratorio').val(id_laboratorio);
        
        // Cerrar modal (BS5)
        var modal = bootstrap.Modal.getInstance($('#labModal')[0]);
        modal.hide();
    });

    // Selección de producto
    $(document).on('click', '.seleccionar-btn', function() {
        const id_producto = $(this).data('id');
        
        $('#codigo').val(id_producto);
        
        // Cerrar modal (BS5)
        var modal = bootstrap.Modal.getInstance($('#verModal')[0]);
        modal.hide();
        
        // Enfocar campo código
        setTimeout(() => $('#codigo').focus(), 300);
    });
});

    // 4. Eliminar producto de la tabla
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        
        Swal.fire({
            title: '¿Eliminar producto?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/compras/create/tmp') }}/" + id,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if(response.success) {
                            actualizarTablaProductos();
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo eliminar el producto', 'error');
                    }
                });
            }
        });
    });

    // 5. Buscar producto por código (presionando Enter)
    $('#codigo').on('keypress', function(e) {
        if(e.which === 13) {
            e.preventDefault();
            const codigo = $(this).val();
            const cantidad = $('#cantidad').val() || 1;
            
            if(codigo.length > 0) {
                $.ajax({
                    url: "{{ route('admin.compras.tmp_compras') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        codigo: codigo,
                        cantidad: cantidad
                    },
                    success: function(response) {
                        if(response.success) {
                            actualizarTablaProductos();
                            $('#codigo').val('').focus();
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error en la conexión', 'error');
                    }
                });
            }
        }
    });

    // Inicialización de DataTables
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
            "lengthMenu": "Mostrar _MENU_ ",
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