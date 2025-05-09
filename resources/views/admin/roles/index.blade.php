@extends('layouts.app', ['title' => 'Gestión de Roles'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Gestión de Roles'])
<div class="container-fluid py-4">
    <!-- Header Principal -->
    
    <div class="card border-radius-lg shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">
                            <i class="fas fa-user-tag fa-1x me-2"></i>
                            <strong>Gestion de Roles</strong>
                        </h5>
                    </div>
            <div class="d-flex">
                <button type="button" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#crearRolModal">
                    <i class="fas fa-plus-circle me-1"></i> Nuevo Rol
                </button>
                <a href="{{ url('/admin/roles/reporte') }}" target="_blank" class="btn btn-danger shadow-sm">
                    <i class="fas fa-file-pdf me-1"></i> Generar Reporte
                </a>
            </div>
        </div>
    </div>

    <div id="alert">
        @include('components.alert')
    </div>

    <!-- Modal para Crear Nuevo Rol -->
    <div class="modal fade" id="crearRolModal" tabindex="-1" aria-labelledby="crearRolModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-info text-white">
                    <h5 class="modal-title" id="crearRolModalLabel">
                        <i class="fas fa-plus-circle me-2"></i> Registrar Nuevo Rol
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ url('/admin/roles/create') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="name" class="form-label fw-bold text-dark mb-2">Nombre del Rol</label>
                            <div class="input-group input-group-outline">
                                <span class="input-group-text bg-transparent"><i class="fas fa-user-tag"></i></span>
                                <input type="text" value="{{ old('name') }}" 
                                       class="form-control border-bottom" 
                                       name="name" 
                                       placeholder="Ej: Administrador"
                                       required>
                            </div>
                            @error('name')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Guardar Rol
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Card de Roles registrados -->
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">
                <i class="fas fa-users me-2"></i> Roles Registrados
            </h3>
            <span class="badge bg-white text-primary">{{ $roles->count() }} roles</span>
        </div>
        
        <div class="card-body">
            <div class="row">
                @foreach($roles as $role)
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card border-left-info shadow h-100">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 text-info fw-bold">
                                <i class="fas fa-user-tag me-2"></i>{{ $role->name }}
                            </h5>
                            <span class="badge bg-gradient-primary">
                                {{ $role->users_count }} usuarios
                            </span>
                        </div>
                        
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-uppercase text-xs text-muted mb-2">Permisos asignados ({{ $role->permissions_count }})</h6>
                                <div class="permisos-list" style="max-height: 120px; overflow-y: auto;">
                                    @forelse($role->permissions as $permiso)
                                    <span class="badge bg-gradient-info text-white mb-1 me-1">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        {{ ucwords(str_replace('.', ' ', $permiso->name)) }}
                                    </span>
                                    @empty
                                    <span class="text-muted small">No tiene permisos asignados</span>
                                    @endforelse
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                               
                                
                                <div class="btn-group">
                                    <!-- Botón Asignar Permisos -->
                                    <button type="button" class="btn btn-sm bg-gradient-warning text-white" 
                                        data-bs-toggle="modal" data-bs-target="#asignarModal{{ $role->id }}"
                                        title="Asignar permisos">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    
                                    <!-- Botón Editar -->
                                    <button type="button" class="btn btn-sm bg-gradient-success text-white" 
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $role->id }}"
                                        title="Editar rol">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    
                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-gradient-danger text-white" 
                                            onclick="return confirm('¿Estás seguro de eliminar este rol?')"
                                            title="Eliminar rol">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Editar Rol -->
                <div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1" aria-labelledby="editLabel{{ $role->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-gradient-info text-white">
                                <h5 class="modal-title" id="editLabel{{ $role->id }}">Editar Rol</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Nombre del Rol</label>
                                        <div class="input-group input-group-outline">
                                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                                        </div>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Asignar Permisos -->
                <div class="modal fade" id="asignarModal{{ $role->id }}" tabindex="-1" aria-labelledby="asignarLabel{{ $role->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-gradient-primary text-white">
                                <h5 class="modal-title fw-bold">
                                    <i class="fas fa-key me-2"></i> Asignar Permisos: {{ $role->name }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            
                            <form action="{{ url('/admin/roles/asignar', $role->id) }}" method="POST" id="formPermisos{{ $role->id }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <div class="form-group mb-4">
                                        <div class="input-group input-group-outline">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" class="form-control" id="searchPermisos{{ $role->id }}" placeholder="Buscar permisos...">
                                        </div>
                                    </div>
                                    
                                    <div class="row permisos-container" style="max-height: 400px; overflow-y: auto;">
                                        @foreach($permisos->chunk(ceil($permisos->count()/3)) as $chunk)
                                        <div class="col-md-4">
                                            @foreach($chunk as $permiso)
                                            <div class="form-check mb-3 permisos-item">
                                                <input type="checkbox" class="form-check-input" id="permiso_{{ $permiso->id }}_{{ $role->id }}" 
                                                    name="permisos[]" value="{{ $permiso->id }}"
                                                    {{ $role->permissions->contains($permiso->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permiso_{{ $permiso->id }}_{{ $role->id }}">
                                                    <span class="badge bg-light border me-2">
                                                        <i class="fas fa-shield-alt text-primary"></i>
                                                    </span>
                                                    {{ ucwords(str_replace('.', ' ', $permiso->name)) }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="alert alert-info mt-3 mb-0 py-2">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            <span id="selectedCount{{ $role->id }}">{{ $role->permissions_count }}</span> permisos seleccionados de {{ $permisos->count() }} disponibles
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función de búsqueda para permisos
    const searchInputs = document.querySelectorAll('[id^="searchPermisos"]');
    searchInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            const modalId = this.closest('.modal').id;
            const searchText = this.value.toLowerCase();
            const permisosItems = document.querySelectorAll(`#${modalId} .permisos-item`);
            
            permisosItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    });
    
    // Contador de permisos seleccionados
    function setupCounter(modalId) {
        const checkboxes = document.querySelectorAll(`#${modalId} input[name="permisos[]"]`);
        const countElement = document.querySelector(`#${modalId} #selectedCount${modalId.replace('asignarModal', '')}`);
        
        function updateCount() {
            const selected = document.querySelectorAll(`#${modalId} input[name="permisos[]"]:checked`).length;
            if (countElement) countElement.textContent = selected;
        }
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateCount);
        });
        
        updateCount(); // Inicializar
    }
    
    // Configurar contadores para cada modal
    document.querySelectorAll('[id^="asignarModal"]').forEach(modal => {
        setupCounter(modal.id);
    });
    
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection