@extends('layouts.app', ['title' => 'Gestión de Proveedores'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Proveedores'])
    
    <div class="container-fluid py-4">
        <!-- Primera tarjeta: Título y botón -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-radius-lg shadow-sm" style="border-left: 4px solid #5e72e4;">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="ni ni-delivery-fast me-2 text-primary"></i>
                                <strong>Gestión de Proveedores</strong>
                            </h5>
                        </div>
                        <button type="button" class="btn bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#modalCrear">
                            <i class="ni ni-fat-add me-1"></i> Nuevo Proveedor
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda tarjeta: Tabla de proveedores -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 border-radius-lg shadow-sm">
                    <div class="card-header pb-0" style="background-color: #f8fafc;">
                        <h6 class="mb-0">
                            <i class="ni ni-bullet-list-67 me-2 text-primary"></i>
                            <strong>Proveedores Registrados</strong>
                        </h6>
                    </div>
                    
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="mitabla" class="table align-items-center mb-0">
                                <thead>
                                    <tr style="background-color: #f8fafc;">
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 5%; text-align: center">Nro</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Empresa</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Dirección</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Teléfono</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Correo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Contacto</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Celular</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 12%; text-align: center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $contador = 1;?>
                                    @foreach($proveedores as $proveedor)
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle">{{$contador++}}</td>
                                        <td style="vertical-align: middle">
                                            <span class="badge bg-gradient-primary p-2">
                                                <i class="ni ni-building me-1"></i> {{$proveedor->empresa}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle">{{$proveedor->direccion}}</td>
                                        <td style="vertical-align: middle">{{$proveedor->telefono}}</td>
                                        <td style="vertical-align: middle">{{$proveedor->email}}</td>
                                        <td style="vertical-align: middle">{{$proveedor->nombre}}</td>
                                        <td style="vertical-align: middle; text-align: center">
                                            <a href="https://wa.me/591{{$proveedor->celular}}" target="_blank"
                                               class="btn btn-sm bg-gradient-success" title="Contactar por WhatsApp">
                                                <i class="ni ni-send me-1"></i> {{$proveedor->celular}}
                                            </a>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle">
                                            <div class="btn-group" role="group">
                                                <!-- Botón Ver -->
                                                <button type="button" class="btn btn-sm bg-gradient-info mx-1 text-white" 
                                                        data-bs-toggle="modal" data-bs-target="#verModal{{ $proveedor->id }}"
                                                        title="Ver detalles">
                                                    <i class="ni ni-zoom-split-in"></i>
                                                </button>
                                                
                                                <!-- Botón Editar -->
                                                <button type="button" class="btn btn-sm bg-gradient-success mx-1 text-white" 
                                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $proveedor->id }}"
                                                        title="Editar">
                                                    <i class="ni ni-ruler-pencil"></i>
                                                </button>

                                                <!-- Botón Eliminar -->
                                                <form action="{{ url('/admin/proveedores', $proveedor->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-gradient-danger text-white">
                                                        <i class="ni ni-fat-remove"></i>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Crear Nuevo Proveedor -->
    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="modalCrearLabel">
                        <i class="ni ni-fat-add me-2"></i><strong>Registrar Proveedor</strong>
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/proveedores/create') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empresa">Empresa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-building"></i></span>
                                        <input type="text" class="form-control" value="{{ old('empresa') }}" name="empresa" required>
                                    </div>
                                    @error('empresa')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-pin-3"></i></span>
                                        <input type="text" class="form-control" value="{{ old('direccion') }}" name="direccion" required>
                                    </div>
                                    @error('direccion')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        <input type="text" class="form-control" value="{{ old('telefono') }}" name="telefono" required>
                                    </div>
                                    @error('telefono')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        <input type="text" class="form-control" value="{{ old('email') }}" name="email" required>
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre del proveedor</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                        <input type="text" class="form-control" value="{{ old('nombre') }}" name="nombre" required>
                                    </div>
                                    @error('nombre')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        <input type="text" class="form-control" value="{{ old('celular') }}" name="celular" required>
                                    </div>
                                    @error('celular')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ni ni-fat-remove me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ni ni-check-bold me-1"></i> Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales para Ver y Editar (se generan dinámicamente para cada proveedor) -->
    @foreach($proveedores as $proveedor)
    <!-- Modal Ver -->
    <div class="modal fade" id="verModal{{ $proveedor->id }}" tabindex="-1" role="dialog" aria-labelledby="verModalLabel{{ $proveedor->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-info">
                    <h5 class="modal-title text-white" id="verModalLabel{{ $proveedor->id }}">
                        <i class="ni ni-zoom-split-in me-2"></i>Detalles del Proveedor
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-3 border-0 shadow-none">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Empresa:</label>
                                        <p class="form-control-static">{{$proveedor->empresa}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Dirección:</label>
                                        <p class="form-control-static">{{$proveedor->direccion}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Teléfono:</label>
                                        <p class="form-control-static">{{$proveedor->telefono}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Correo:</label>
                                        <p class="form-control-static">{{$proveedor->email}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Contacto:</label>
                                        <p class="form-control-static">{{$proveedor->nombre}}</p>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold text-primary">Celular:</label>
                                        <p class="form-control-static">
                                            <a href="https://wa.me/591{{$proveedor->celular}}" target="_blank"
                                               class="btn btn-sm bg-gradient-success">
                                                <i class="ni ni-send me-1"></i> {{$proveedor->celular}}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ni ni-fat-remove me-1"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editModal{{ $proveedor->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $proveedor->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-success">
                    <h5 class="modal-title text-white" id="editModalLabel{{ $proveedor->id }}">
                        <i class="ni ni-ruler-pencil me-2"></i>Editar Proveedor
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('/admin/proveedores', $proveedor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empresa">Empresa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-building"></i></span>
                                        <input type="text" class="form-control" name="empresa" value="{{ $proveedor->empresa }}" required>
                                    </div>
                                    @error('empresa')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-pin-3"></i></span>
                                        <input type="text" class="form-control" name="direccion" value="{{ $proveedor->direccion }}" required>
                                    </div>
                                    @error('direccion')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        <input type="text" class="form-control" value="{{ $proveedor->telefono }}" name="telefono">
                                    </div>
                                    @error('telefono')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        <input type="text" class="form-control" value="{{ $proveedor->email }}" name="email" required>
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre del Contacto</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                        <input type="text" class="form-control" value="{{ $proveedor->nombre }}" name="nombre" required>
                                    </div>
                                    @error('nombre')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                                        <input type="text" class="form-control" value="{{ $proveedor->celular }}" name="celular" required>
                                    </div>
                                    @error('celular')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ni ni-fat-remove me-1"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="ni ni-check-bold me-1"></i> Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .badge-primary {
        background-color: #5e72e4;
    }
    .bg-gradient-info {
        background: linear-gradient(87deg, #11cdef 0, #1171ef 100%) !important;
    }
    .bg-gradient-success {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
    }
    .bg-gradient-danger {
        background: linear-gradient(87deg, #f5365c 0, #f56036 100%) !important;
    }
    .modal-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .bg-gradient-primary {
        background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(94, 114, 228, 0.05);
        transition: background-color 0.2s ease;
    }
    .input-group-text {
        background-color: #f8fafc;
        border-right: none;
    }
    .form-control {
        border-left: none;
    }
    .form-control-static {
        padding: 0.375rem 0;
        margin-bottom: 0;
        line-height: 1.5;
        border-bottom: 1px solid #e9ecef;
    }
    .border-radius-lg {
        border-radius: 0.5rem;
    }
    .card {
        border: none;
        box-shadow: 0 0.5rem 1.25rem rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
    }
    .btn-group .btn {
        margin: 0 2px;
        border-radius: 4px !important;
    }
    .table td, .table th {
        vertical-align: middle;
        padding: 0.75rem 1.5rem;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
            },
            "dom": '<"top"f>rt<"bottom"lip><"clear">',
            "initComplete": function() {
                $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Buscar...');
                $('.dataTables_length select').addClass('form-control');
            }
        });
    });
</script>
@endpush