@extends('layouts.app', ['title' => 'Clientes'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Clientes'])
<div class="container-fluid py-4">
    <!-- Tarjeta de título -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-radius-lg shadow-sm" style="border-left: 4px solid #5e72e4;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-users me-2 text-primary"></i>
                            <strong>Clientes</strong>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de registro -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-radius-lg shadow-sm">
                <div class="card-header pb-0" style="background-color: #f8fafc;">
                    <h6 class="mb-0">
                        <i class="fas fa-user-plus me-2 text-primary"></i>
                        <strong>Registro de Nuevo Cliente</strong>
                    </h6>
                </div>
                
                <div class="card-body">
                    <form action="{{ url('/admin/clientes/create') }}" method="post">
                        @csrf
                        <div class="row">
                            <!-- Campo Nombre -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre_cliente">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" value="{{ old('nombre_cliente') }}" name="nombre_cliente" required>
                                    </div>
                                    @error('nombre_cliente')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Campo NIT/CI -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="nit_ci">NIT/CI</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control" value="{{ old('nit_ci') }}" name="nit_ci">
                                    </div>
                                    @error('nit_ci')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Campo Celular -->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="celular">Celular</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        <input type="text" class="form-control" value="{{ old('celular') }}" name="celular">
                                    </div>
                                    @error('celular')
                                        <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Campo Correo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Correo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" value="{{ old('email') }}" class="form-control" name="email">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Registrar
                                        </button>
                                    </div>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de lista de clientes -->
    <div class="row">
        <div class="col-12">
            <div class="card border-radius-lg shadow-sm">
                <div class="card-header pb-0" style="background-color: #f8fafc;">
                    <h6 class="mb-0">
                        <i class="fas fa-list-ol me-2 text-primary"></i>
                        <strong>Clientes Registrados</strong>
                    </h6>
                </div>
                
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="mitabla" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 8%; text-align: center">Nro</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">NIT/CI</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Celular</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Correo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 15%; text-align: center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 1;?>
                                @foreach($clientes as $cliente)
                                <tr>
                                    <td style="text-align: center; vertical-align: middle">
                                        <span class="text-secondary text-xs font-weight-bold">{{$contador++}}</span>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <span class="badge bg-gradient-primary p-2">
                                            <i class="fas fa-user me-1"></i> {{$cliente->nombre_cliente}}
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <span class="text-secondary text-xs font-weight-bold">{{$cliente->nit_ci}}</span>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <span class="text-secondary text-xs font-weight-bold">{{$cliente->celular}}</span>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <span class="text-secondary text-xs font-weight-bold">{{$cliente->email}}</span>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <div class="d-flex justify-content-center">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-sm bg-gradient-success text-white mx-1" 
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $cliente->id }}" 
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                                            <form action="{{ url('/admin/clientes', $cliente->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm bg-gradient-danger text-white mx-1" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
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

<!-- Modales para Editar (se generan dinámicamente para cada cliente) -->
@foreach($clientes as $cliente)
<div class="modal fade" id="editModal{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title" id="editModalLabel{{ $cliente->id }}">
                    <i class="fas fa-edit me-2"></i>Editar Cliente
                </h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('/admin/clientes', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del cliente</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control" value="{{$cliente->nombre_cliente}}" name="nombre_cliente">
                        </div>
                        @error('nombre_cliente')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nit_ci">NIT/CI</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" class="form-control" value="{{$cliente->nit_ci}}" name="nit_ci">
                        </div>
                        @error('nit_ci')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                            <input type="text" class="form-control" value="{{$cliente->celular}}" name="celular">
                        </div>
                        @error('celular')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="text" class="form-control" value="{{$cliente->email}}" name="email">
                        </div>
                        @error('email')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cerrar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Actualizar
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
    .bg-gradient-primary {
        background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
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
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#mitabla').DataTable({
            "pageLength": 5,
            "responsive": true,
            "autoWidth": false,
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