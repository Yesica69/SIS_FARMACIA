@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Modificación de Venta'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6><b>Modificación de la venta</b></h6>
                </div>
                
                <div class="card-body">
                    <form action="{{url('/admin/ventas', $venta->id) }}" id="form_venta" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Columna izquierda (Cantidad) -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad" class="form-control-label">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidad" value="1" required>
                                            @error('cantidad')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Columna del código de producto -->
                                    <div class="col-md-6">
                                        <label for="codigo" class="form-control-label">Código</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                            <input id="codigo" type="text" class="form-control" name="codigo">                                      
                                        </div>
                                    </div>

                                    <!-- Botón de modal para ver productos -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div style="height: 32px"></div>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verModal">
                                                <i class="ni ni-zoom-split-in"></i> Buscar
                                            </button>

                                            <a href="{{url('/admin/productos/create')}}" type="button" class="btn btn-success btn-sm">
                                                <i class="ni ni-fat-add"></i> Nuevo
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de productos seleccionados -->
                                <div class="row mt-3">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nro</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Cantidad</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Precio</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Total</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $cont = 1; $total_cantidad = 0; $total_venta = 0;?>
                                                @foreach($venta->detallesVenta as $detalle)
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{$cont++}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-secondary text-xs font-weight-bold">{{$detalle->producto->codigo}}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{$detalle->cantidad}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-secondary text-xs font-weight-bold">{{$detalle->producto->nombre}}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{$detalle->producto->precio_venta}}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{$costo = $detalle->cantidad * $detalle->producto->precio_venta}}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$detalle->id}}">
                                                            <i class="ni ni-fat-remove"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php
                                                $total_cantidad += $detalle->cantidad;
                                                $total_venta += $costo;
                                                @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" class="text-end">
                                                        <span class="text-secondary text-xs font-weight-bold">Total</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-secondary text-xs font-weight-bold"><b>{{$total_cantidad}}</b></span>
                                                    </td>
                                                    <td colspan="2" class="text-end">
                                                        <span class="text-secondary text-xs font-weight-bold">Total venta</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="text-secondary text-xs font-weight-bold"><b>{{$total_venta}}</b></span>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Columna derecha (Cliente y Fecha) -->
                            <div class="col-md-4">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#clienteModal">
                                            <i class="ni ni-zoom-split-in me-1"></i> Buscar cliente
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#clientecrearModal">
                                            <i class="ni ni-fat-add me-1"></i> Nuevo cliente
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nombre_cliente_select" class="form-control-label">Nombre del cliente</label>
                                            <input type="text" class="form-control" id="nombre_cliente_select" value="{{$venta->cliente->nombre_cliente ?? 'S/N'}}">
                                            <input type="hidden" id="id_cliente" name="cliente_id" value="{{$venta->cliente->id ?? ''}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="nit_cliente_select" class="form-control-label">NIT/CI del cliente</label>
                                            <input type="text" class="form-control" id="nit_cliente_select" value="{{$venta->cliente->nit_ci ?? 'SIN'}}">
                                        </div>
                                    </div>
                                </div>

                                <hr class="horizontal dark">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fecha" class="form-control-label">Fecha de venta</label>
                                            <input type="date" class="form-control" name="fecha" value="{{old('fecha', $venta->fecha) }}">
                                            @error('fecha')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Sección del Total -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="precio_total" class="form-control-label">Total</label>
                                            <input type="text" style="text-align: center; background-color: rgba(255, 192, 203, 0.3)" class="form-control" name="precio_total" value="{{$total_venta}}">
                                            @error('precio_total')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ni ni-check-bold me-1"></i> Actualizar venta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver productos -->
<div class="modal fade" id="verModal" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verModalLabel"><b>Listado de productos</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="mitabla" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nro</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acción</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Código</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripción</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stock</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Precio</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vencimiento</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Imagen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            @foreach($productos as $producto)
                            <tr>
                                <td class="text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $contador++ }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm seleccionar-btn" data-id="{{$producto->codigo}}">
                                        <i class="ni ni-check-bold"></i> Seleccionar
                                    </button>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold">{{ $producto->codigo }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold"><b>{{ $producto->nombre }}</b></span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold">{{ $producto->descripcion }}</span>
                                </td>
                                <td>
                                    <span class="text-danger text-xs font-weight-bold">{{ $producto->stock }}</span>
                                </td>
                                <td>
                                    <span class="text-danger text-xs font-weight-bold">{{ $producto->precio_venta }}</span>
                                </td>
                                <td>
                                    <span class="text-danger text-xs font-weight-bold">{{ $producto->fecha_vencimiento }}</span>
                                </td>
                                <td class="text-center">
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" width="60" height="60" class="rounded" alt="Imagen">
                                    @else
                                        <span class="text-secondary text-xs">Sin imagen</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver clientes -->
<div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clienteModalLabel"><b>Listado de clientes</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="mitabla2" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nro</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acción</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIT/CI</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Celular</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            @foreach($clientes as $cliente)
                            <tr>
                                <td class="text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $contador++ }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm seleccionar-btn-cliente" 
                                        data-id="{{$cliente->id}}" 
                                        data-nit="{{$cliente->nit_ci}}" 
                                        data-nombre_cliente="{{$cliente->nombre_cliente}}">
                                        <i class="ni ni-check-bold"></i> Seleccionar
                                    </button>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold"><b>{{ $cliente->nombre_cliente }}</b></span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold"><b>{{ $cliente->nit_ci }}</b></span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold"><b>{{ $cliente->celular }}</b></span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold"><b>{{ $cliente->email }}</b></span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear clientes -->
<div class="modal fade" id="clientecrearModal" tabindex="-1" aria-labelledby="clientecrearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clientecrearModalLabel"><b>Registro de cliente</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Campo Nombre -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre_cliente" class="form-control-label">Nombre</label>
                            <input type="text" class="form-control" value="{{ old('nombre_cliente') }}" id="nombre_cliente">
                            @error('nombre_cliente')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>   

                    <!-- Campo Nit -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nit_ci" class="form-control-label">NIT/CI</label>
                            <input type="text" class="form-control" value="{{ old('nit_ci') }}" id="nit_ci">
                            @error('nit_ci')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>  

                    <!-- Campo Celular -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="celular" class="form-control-label">Celular</label>
                            <input type="text" class="form-control" value="{{ old('celular') }}" id="celular">
                            @error('celular')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>                 

                    <!-- Campo Correo -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="email" class="form-control-label">Correo</label>
                            <input type="email" value="{{ old('email') }}" class="form-control" id="email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="guardar_cliente()" class="btn btn-primary">
                    <i class="ni ni-check-bold me-1"></i> Registrar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
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
                        position: 'top-end',
                        icon: 'success',
                        title: 'Se agregó el cliente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo registrar el cliente'
                    });
                }
            },
            error: function(error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al registrar el cliente'
                });
            }
        });
    }

    // Seleccionar cliente de la búsqueda
    $(document).on('click', '.seleccionar-btn-cliente', function(){
        var id_cliente = $(this).data('id');
        var nombre_cliente = $(this).data('nombre_cliente');
        var nit_ci = $(this).data('nit');
        
        $('#nombre_cliente_select').val(nombre_cliente);
        $('#nit_cliente_select').val(nit_ci);
        $('#id_cliente').val(id_cliente);
        
        // Cerrar el modal
        var modal = bootstrap.Modal.getInstance(document.getElementById('clienteModal'));
        modal.hide();
    });

    // Seleccionar producto de la búsqueda
    $(document).on('click', '.seleccionar-btn', function(){
        var id_producto = $(this).data('id');
        $('#codigo').val(id_producto);
        
        // Cerrar el modal
        var modal = bootstrap.Modal.getInstance(document.getElementById('verModal'));
        modal.hide();
        
        // Enfocar el campo código después de cerrar el modal
        $('#codigo').focus();
    });

    // Eliminar un producto de la venta
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        if (id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{url('/admin/ventas/detalle')}}/"+id,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token()}}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Se eliminó el producto',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo eliminar el producto'
                                });
                            }
                        },
                        error: function(error) {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error al eliminar el producto'
                            });
                        }
                    });
                }
            });
        }
    });

    // Buscar producto mediante código (Enter)
    $('#codigo').on('keyup', function(e) {
        if (e.which === 13) {
            var codigo = $(this).val();
            var cantidad = $('#cantidad').val();
            var id_venta = '{{$venta->id}}';

            if(codigo.length > 0) {
                $.ajax({
                    url: "{{ route('admin.detalle.ventas.store') }}",
                    method: 'POST',
                    data: {
                        _token: '{{csrf_token()}}',
                        codigo: codigo,
                        cantidad: cantidad,
                        id_venta: id_venta
                    },
                    success: function(response) {
                        if(response.success){
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Se registró el producto',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'No se encontró el producto'
                            });
                        }
                    },
                    error: function(error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al buscar el producto'
                        });
                    }
                });
            }
        }
    });

    // Inicializar DataTables
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
                },
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "emptyTable": "No hay datos disponibles en la tabla"
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
                },
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "emptyTable": "No hay datos disponibles en la tabla"
            }
        });

        // Enfocar el campo código al cargar la página
        $('#codigo').focus();
        
        // Prevenir el envío del formulario al presionar Enter
        $('#form_venta').on('keypress', function(e) {
            if(e.keyCode === 13) {   
                e.preventDefault();
            }
        });
    });
</script>
@endpush