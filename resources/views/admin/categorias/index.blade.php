@extends('layouts.app', ['title' => 'Gestión de Categorías'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Categorías'])
<div class="container-fluid py-4">
    <!-- Header Principal -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-radius-lg shadow-sm" style="border-left: 4px solid #5e72e4;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-tags fa-2x me-3 text-primary"></i>
                        <h4 class="mb-0">
                            <strong>GESTIÓN DE CATEGORÍAS</strong>
                        </h4>
                    </div>
                    <button type="button" class="btn bg-gradient-primary shadow-sm" 
                            data-bs-toggle="modal" data-bs-target="#modalCrear">
                        <i class="fas fa-plus-circle me-1"></i> Nueva Categoría
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de lista de categorías -->
    <div class="row">
        <div class="col-12">
            <div class="card border-radius-lg shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list-check me-2 text-primary"></i>
                        <strong>Catálogo de Categorías</strong>
                    </h5>
                    <span class="badge bg-gradient-primary rounded-pill px-3 py-2">
                        <i class="fas fa-database me-1"></i> Total: {{ $categorias->count() }}
                    </span>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="categorias-table" class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">#</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">Categoría</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">Descripción</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr>
                                    <td class="text-center align-middle">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-gradient-info rounded-circle me-2 p-2">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                            <span class="text-dark text-sm font-weight-bold">{{ $categoria->nombre }}</span>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-dark text-sm">{{ $categoria->descripcion }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-sm bg-gradient-info text-white mx-1" 
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $categoria->id }}"
                                                    title="Editar categoría">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            
                                            <!-- Botón Eliminar -->
                                            <form action="{{ url('/admin/categorias', $categoria->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm bg-gradient-danger text-white mx-1"
                                                        title="Eliminar categoría"
                                                        onclick="return confirm('¿Está seguro de eliminar esta categoría?')">
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

<!-- Modal para Crear Nueva Categoría -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modalCrearLabel">
                    <i class="fas fa-plus-circle me-2"></i> Nueva Categoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/categorias/create') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Nombre de la Categoría</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" name="nombre" 
                                   value="{{ old('nombre') }}" required 
                                   placeholder="Ej: Higiene">
                        </div>
                        @error('nombre')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Descripción</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                            <textarea class="form-control" name="descripcion" rows="3"
                                   placeholder="Ej: Productos de Higiene corporal">{{ old('descripcion') }}</textarea>
                        </div>
                        @error('descripcion')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn bg-gradient-primary">
                        <i class="fas fa-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modales de Edición (generados dinámicamente) -->
@foreach($categorias as $categoria)
<div class="modal fade" id="editModal{{ $categoria->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $categoria->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title" id="editModalLabel{{ $categoria->id }}">
                    <i class="fas fa-edit me-2"></i> Editar Categoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/categorias', $categoria->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Nombre</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" name="nombre" 
                                   value="{{ old('nombre', $categoria->nombre) }}" required>
                        </div>
                        @error('nombre')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Descripción</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                            <textarea class="form-control" name="descripcion" rows="3">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                        </div>
                        @error('descripcion')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn bg-gradient-info text-white">
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
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .bg-light {
        background-color: #f8fafc !important;
    }
    
    .bg-gray-100 {
        background-color: #f8f9fa !important;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .table td {
        vertical-align: middle;
        padding: 1rem;
    }
    
    .input-group-outline {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: border-color 0.15s ease-in-out;
    }
    
    .input-group-outline:focus-within {
        border-color: #5e72e4;
        box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
    }
    
    .input-group-text {
        background-color: transparent;
        border-right: none;
    }
    
    .form-control, .form-control:focus {
        border-left: none;
        background-color: transparent;
        box-shadow: none;
    }
    
    textarea.form-control {
        min-height: 100px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #5e72e4 0%, #825ee4 100%) !important;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%) !important;
    }
    
    .bg-gradient-danger {
        background: linear-gradient(135deg, #f5365c 0%, #f56036 100%) !important;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.375rem;
    }
    
    .modal-content {
        border: none;
        border-radius: 12px;
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .text-xs {
        font-size: 0.75rem;
    }
    
    .text-sm {
        font-size: 0.875rem;
    }
    
    .border-radius-lg {
        border-radius: 0.5rem;
    }
    
    .badge.rounded-circle {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Configuración de DataTables
    $('#categorias-table').DataTable({
        "pageLength": 10,
        "responsive": true,
        "autoWidth": false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron categorías",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay categorías registradas",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        },
        "dom": '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
        "initComplete": function() {
            $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Buscar categoría...');
            $('.dataTables_length select').addClass('form-select');
        }
    });
    
    // Confirmación antes de eliminar con SweetAlert2
    $('form[method="DELETE"]').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5e72e4',
            cancelButtonColor: '#f5365c',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endpush