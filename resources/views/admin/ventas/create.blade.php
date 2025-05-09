@extends('layouts.app', ['title' => 'Nueva venta'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Nueva venta'])
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Ingrese los datos</h3>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#collapseCard">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Card body -->
                <div class="card-body">
                    <form action="{{ route('admin.ventas.create') }}" id="form_venta" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Cantidad -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad" class="form-control-label">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidad" value="1" required>
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
                                            <a href="{{url('/admin/productos/create')}}" class="btn btn-success">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de productos -->
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nro</th>
                                                <th>Código</th>
                                                <th>Cantidad</th>
                                                <th>Nombre</th>
                                                <th>Precio</th>
                                                <th>Total</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $cont = 1; $total_cantidad = 0; $total_venta = 0;?>
                                            @foreach($tmp_ventas as $tmp_venta)
                                            <tr>
                                                <td style="text-align: center">{{$cont++}}</td>
                                                <td style="text-align: center">{{$tmp_venta->producto->codigo}}</td>
                                                <td style="text-align: center">{{$tmp_venta->cantidad}}</td>
                                                <td>{{$tmp_venta->producto->nombre}}</td>
                                                <td style="text-align: center">{{$tmp_venta->producto->precio_venta}}</td>
                                                <td style="text-align: center">{{$costo = $tmp_venta->cantidad * $tmp_venta->producto->precio_venta}}</td>
                                                <td style="text-align: center">
                                                    <button type="button" class="btn btn-sm btn-icon btn-danger delete-btn" data-id="{{$tmp_venta->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php
                                            $total_cantidad += $tmp_venta->cantidad;
                                            $total_venta += $costo;
                                            @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-end">Total</td>
                                                <td style="text-align: center"><b>{{$total_cantidad}}</b></td>
                                                <td colspan="2" class="text-end">Total venta</td>
                                                <td style="text-align: center"><b>{{$total_venta}}</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="col-md-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#clienteModal">
                                            <i class="fas fa-search"></i> Cliente
                                        </button>
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#clientecrearModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Nombre del cliente</label>
                                                <input type="text" class="form-control" id="nombre_cliente_select" value="S/N" disabled>
                                                <input type="hidden" class="form-control" id="id_cliente" name="cliente_id">
                                            </div>
                                            <div class="col-md-6">
                                                <label>NIT/CI del cliente</label>
                                                <input type="text" class="form-control" id="nit_cliente_select" value="0" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha" class="form-control-label">Fecha de venta</label>
                                            <input type="date" class="form-control" name="fecha" value="{{ old('fecha',date('Y-m-d')) }}">
                                            @error('fecha')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="precio_total" class="form-control-label">Total</label>
                                            <input type="text" style="text-align: center; background-color: #f8d7da" class="form-control" name="precio_total" value="{{$total_venta}}" readonly>
                                            @error('precio_total')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Registrar venta</button>
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
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Fecha Venc.</th>
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
                            <td style="color: red; font-weight: bold;">{{ $producto->stock }}</td>
                            <td style="color: red; font-weight: bold;">{{ $producto->precio_venta }}</td>
                            <td style="color: red; font-weight: bold;">{{ $producto->fecha_vencimiento }}</td>
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

<!-- Modal Clientes -->
<div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="clienteModalLabel">Listado de clientes</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="mitabla2" class="table table-striped table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nro</th>
                            <th>Acción</th>
                            <th>Nombre</th>
                            <th>NIT/CI</th>
                            <th>Celular</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador = 1; ?>
                        @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info seleccionar-btn-cliente" 
                                        data-id="{{$cliente->id}}" 
                                        data-nit="{{$cliente->nit_ci}}" 
                                        data-nombre_cliente="{{$cliente->nombre_cliente}}">
                                    Seleccionar
                                </button>
                            </td>
                            <td><strong>{{ $cliente->nombre_cliente }}</strong></td>
                            <td><strong>{{ $cliente->nit_ci }}</strong></td>
                            <td><strong>{{ $cliente->celular }}</strong></td>
                            <td><strong>{{ $cliente->email }}</strong></td>
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

<!-- Modal Crear Cliente -->
<div class="modal fade" id="clientecrearModal" tabindex="-1" aria-labelledby="clientecrearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="clientecrearModalLabel">Registrar cliente</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre_cliente">Nombre</label>
                            <input type="text" class="form-control" id="nombre_cliente" value="{{ old('nombre_cliente') }}">
                            @error('nombre_cliente')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>   

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nit_ci">NIT/CI</label>
                            <input type="text" class="form-control" id="nit_ci" value="{{ old('nit_ci') }}">
                            @error('nit_ci')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>  

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="text" class="form-control" id="celular" value="{{ old('celular') }}">
                            @error('celular')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>                 

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" id="email" value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="guardar_cliente()" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar
                </button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// REGISTRAR UN CLIENTE
function guardar_cliente(){
    const data = {
        nombre_cliente: $('#nombre_cliente').val(),
        nit_ci: $('#nit_ci').val(),
        celular: $('#celular').val(),
        email: $('#email').val(),
        _token: '{{csrf_token()}}' 
    };

    $.ajax({
        url: '{{route("admin.ventas.cliente.store")}}',
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Se agregó el cliente",
                    showConfirmButton: false,
                    timer: 1500
                });
                location.reload();
            } else {
                Swal.fire('Error', 'No se pudo registrar el cliente', 'error');
            }
        },
        error: function(error) {
            Swal.fire('Error', 'Ocurrió un error al registrar el cliente', 'error');
        }
    });
}

// Seleccionar cliente
$(document).on('click', '.seleccionar-btn-cliente', function(){
    const id_cliente = $(this).data('id');
    const nombre_cliente = $(this).data('nombre_cliente');
    const nit_ci = $(this).data('nit');
    
    $('#nombre_cliente_select').val(nombre_cliente);
    $('#nit_cliente_select').val(nit_ci);
    $('#id_cliente').val(id_cliente);
    
    // Cerrar modal
    const clienteModal = bootstrap.Modal.getInstance(document.getElementById('clienteModal'));
    clienteModal.hide();
});

// Seleccionar producto
$(document).on('click', '.seleccionar-btn', function(){
    const id_producto = $(this).data('id');
    $('#codigo').val(id_producto);
    
    // Cerrar modal
    const verModal = bootstrap.Modal.getInstance(document.getElementById('verModal'));
    verModal.hide();
    
    $('#codigo').focus();
});

// Eliminar producto de la venta temporal
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
                    url: "{{url('/admin/ventas/create/tmp')}}/"+id,
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
                    error: function() {
                        Swal.fire('Error', 'Error en la conexión', 'error');
                    }
                });
            }
        });
    }
});

// Buscar producto por código (Enter)
$('#codigo').focus();
$('#form_venta').on('keypress', function(e) {
    if(e.keyCode === 13) {   
        e.preventDefault();
    }
});

$('#codigo').on('keyup', function(e) {
    if (e.which === 13) {
        const codigo = $(this).val();
        const cantidad = $('#cantidad').val();

        if(codigo.length > 0) {
            $.ajax({
                url: "{{ route('admin.ventas.tmp_ventas') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    codigo: codigo,
                    cantidad: cantidad
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
                error: function() {
                    Swal.fire('Error', 'Error en la conexión', 'error');
                }
            });
        }
    }
});

// DataTables
$(document).ready(function() {
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