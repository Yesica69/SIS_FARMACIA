@extends('layouts.app', ['title' => 'Gestión de Permisos'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Gestión de Permisos'])
<div class="container-fluid py-4">
    <!-- Header Principal -->
    <div class="card shadow-lg mb-4 border-0">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-shield fa-2x me-3 text-white"></i>
                <h2 class="mb-0 text-white"><strong>GESTIÓN DE PERMISOS</strong></h2>
            </div>
            <div class="d-flex">
                <button type="button" class="btn btn-light bg-gradient-info text-white me-2 shadow-sm" 
                        data-bs-toggle="modal" data-bs-target="#modalCrear">
                    <i class="fas fa-plus-circle me-1"></i> Nuevo Permiso
                </button>
                <a href="{{ url('/admin/roles/reporte') }}" target="_blank" 
                   class="btn bg-gradient-danger text-white shadow-sm">
                    <i class="fas fa-file-pdf me-1"></i> Generar Reporte
                </a>
            </div>
        </div>
    </div>

    <div id="alert">
        @include('components.alert')
    </div>

    <!-- Tabla de Permisos -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
            <h3 class="mb-0 text-primary">
                <i class="fas fa-list-check me-2"></i>Permisos Registrados
            </h3>
            <span class="badge bg-gradient-primary rounded-pill px-3 py-2">
                <i class="fas fa-database me-1"></i> Total: {{ $permisos->count() }}
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="mitabla" class="table table-hover align-items-center mb-0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">#</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">Nombre del Permiso</th>
                            <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permisos as $permiso)
                        <tr>
                            <td class="text-center align-middle">
                                <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-gradient-info rounded-pill me-2">
                                        <i class="fas fa-shield-alt"></i>
                                    </span>
                                    <span class="text-dark text-xs font-weight-bold">{{ $permiso->name }}</span>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group" role="group">
                                    <!-- Botón Editar - Verde -->
                                    <button type="button" class="btn btn-sm bg-gradient-success text-white rounded-start px-3" 
                                            data-bs-toggle="modal" data-bs-target="#editModal{{ $permiso->id }}"
                                            title="Editar permiso">
                                        <i class="fas fa-pen-to-square me-1"></i> Editar
                                    </button>
                                    
                                    <!-- Botón Eliminar - Rojo -->
                                    <form action="{{ url('/admin/permisos', $permiso->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-gradient-danger text-white rounded-end px-3"
                                                onclick="return confirm('¿Está seguro de eliminar este permiso?')"
                                                title="Eliminar permiso">
                                            <i class="fas fa-trash-can me-1"></i> Eliminar
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

<!-- Modal para Crear Nuevo Permiso -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modalCrearLabel">
                    <i class="fas fa-plus-circle me-2"></i> Nuevo Permiso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/permisos/create') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label text-muted mb-2">Nombre del Permiso</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text bg-transparent"><i class="fas fa-key text-primary"></i></span>
                            <input type="text" class="form-control border-bottom" name="name" 
                                   value="{{ old('name') }}" required 
                                   placeholder="Ej: gestionar-usuarios">
                        </div>
                        <small class="text-muted mt-1">Usar formato snake_case (ej: gestionar_usuarios)</small>
                        @error('name')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn bg-gradient-success text-white">
                        <i class="fas fa-save me-1"></i> Guardar Permiso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modales de Edición (generados dinámicamente) -->
@foreach($permisos as $permiso)
<div class="modal fade" id="editModal{{ $permiso->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $permiso->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title" id="editModalLabel{{ $permiso->id }}">
                    <i class="fas fa-edit me-2"></i> Editar Permiso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/permisos', $permiso->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="form-label text-muted mb-2">Nombre del Permiso</label>
                        <div class="input-group input-group-outline">
                            <span class="input-group-text bg-transparent"><i class="fas fa-key text-success"></i></span>
                            <input type="text" name="name" class="form-control border-bottom" 
                                   value="{{ old('name', $permiso->name) }}" required>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn bg-gradient-primary text-white">
                        <i class="fas fa-save me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<!-- DataTables Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración de DataTables
    $('#mitabla').DataTable({
        "pageLength": 10,
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
            "processing": "Procesando..."
        },
        "dom": '<"top"<"d-flex justify-content-between align-items-center"f<"ms-2"l>>>rt<"bottom"<"d-flex justify-content-between align-items-center"ip>>',
        "responsive": true,
        "autoWidth": false,
        "columnDefs": [
            { "orderable": false, "targets": [2] }
        ]
    });

    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection