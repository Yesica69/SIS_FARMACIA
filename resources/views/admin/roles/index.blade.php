
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center bg-gradient-white p-3 rounded-top">
    <h1 class="m-0 text-black"><i class="fas fa-user-tag mr-2"></i> <strong>GESTIÓN DE ROLES</strong></h1>
    <a href="{{ url('/admin/roles/reporte') }}" target="_blank" class="btn btn-danger btn-sm shadow-sm">
        <i class="fas fa-file-pdf mr-1"></i> Generar Reporte
    </a>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
            <h3 class="card-title">Registrar nuevo rol</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ url('/admin/roles/create') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre del Rol</label>
                                <div class="input-group">
                                    <input type="text" value="{{ old('name') }}" class="form-control" name="name" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary" style="margin-left: 20px;">
                                            <i class="fas fa-save"></i> Registrar
                                        </button>
                                        <a href="{{ url('/admin/roles/reporte') }}" target="_blank" class="btn btn-danger" style="margin-left: 20px;">
                                            <i class="fas fa-file-pdf"></i> reporte
                                        </a>
                                    </div>
                                </div>
                                @error('name')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Lista de roles -->
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Roles registrados</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th style="text-align: center">Nro</th>
                            <th style="text-align: center">Nombre del rol</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($roles as $role)
                        <tr>
                            <td style="text-align: center">{{ $contador++ }}</td>
                            <td style="text-align: center">{{ $role->name }}</td>
                            <td style="text-align: center">
                                <!-- Botón Asignar -->
                                <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#asignarModal{{ $role->id }}">
                                    <i class="fas fa-check"></i>
                                </button>

                                <!-- Botón Editar -->
                                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#editModal{{ $role->id }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>

                                <!-- Formulario Eliminar -->
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este rol?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <!-- Modal Editar -->
                                <div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="editLabel{{ $role->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLabel{{ $role->id }}">Editar Rol</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Nombre del Rol</label>
                                                        <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                                                        @error('name')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @foreach($roles as $rol)
<!-- Modal Asignar Permisos -->
<div class="modal fade" id="asignarModal{{ $rol->id }}" tabindex="-1" role="dialog" aria-labelledby="asignarLabel{{ $rol->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Cambiado a modal-lg para mejor visualización -->
        <div class="modal-content border-0 shadow-lg">
            <!-- Header del modal - Mejorado -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-key mr-2"></i> Asignar Permisos al Rol: <span class="text-capitalize">{{ $rol->name }}</span>
                </h5>
                <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form action="{{ url('/admin/roles/asignar', $rol->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <!-- Barra de búsqueda (opcional) -->
                    <div class="form-group mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class="form-control" id="searchPermisos" placeholder="Buscar permisos...">
                        </div>
                    </div>
                    
                    <!-- Lista de permisos organizada -->
                    <div class="row permisos-container" style="max-height: 400px; overflow-y: auto;">
                        @foreach($permisos->chunk(ceil($permisos->count()/3)) as $chunk)
                        <div class="col-md-4">
                            @foreach($chunk as $permiso)
                            <div class="custom-control custom-checkbox mb-3 permisos-item">
                                <input type="checkbox" class="custom-control-input" id="permiso_{{ $permiso->id }}_{{ $rol->id }}" 
                                    name="permisos[]" value="{{ $permiso->id }}"
                                    {{ $rol->permissions->contains($permiso->id) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="permiso_{{ $permiso->id }}_{{ $rol->id }}">
                                    <span class="badge badge-light border mr-2">
                                        <i class="fas fa-shield-alt text-primary"></i>
                                    </span>
                                    {{ ucwords(str_replace('.', ' ', $permiso->name)) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Contador de permisos seleccionados -->
                    <div class="alert alert-info mt-3 mb-0 py-2">
                        <small>
                            <i class="fas fa-info-circle mr-1"></i>
                            <span id="selectedCount"></span> permisos {{ $permisos->count() }} disponibles
                        </small>
                    </div>
                </div>
                
                <!-- Footer del modal - Mejorado -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<!-- Estilos adicionales si necesitas -->
@stop

@section('js')
<!-- Script para funcionalidad adicional -->
@push('scripts')
<script>
$(document).ready(function() {
    // Función de búsqueda
    $('#searchPermisos').on('keyup', function() {
        const searchText = $(this).val().toLowerCase();
        $('.permisos-item').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.includes(searchText));
        });
    });
    
    // Contador de permisos seleccionados
    function updateSelectedCount() {
        const selected = $('input[name="permisos[]"]:checked').length;
        $('#selectedCount').text(selected);
    }
    
    $('input[name="permisos[]"]').change(updateSelectedCount);
    updateSelectedCount(); // Inicializar contador
});
</script>
@endpush
<!-- Asegúrate de tener jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@stop
