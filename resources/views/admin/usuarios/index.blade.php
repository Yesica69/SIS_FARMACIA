@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Gestión de Usuarios'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>
                        <i class="ni ni-single-02 text-primary me-2"></i>
                        <strong>GESTIÓN DE USUARIOS</strong>
                    </h6>
                    <div>
                        <a href="{{ url('/admin/roles/reporte') }}" target="_blank" class="btn btn-sm btn-danger me-2">
                            <i class="ni ni-single-copy-04 me-1"></i> Generar Reporte
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                            <i class="ni ni-fat-add me-1"></i> Nuevo Usuario
                        </button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Nro</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Imagen</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rol</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sucursal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $contador = 1; @endphp
                                @foreach($usuarios as $usuario)
                                <tr>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $contador++ }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('argon') }}/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $usuario->firstname }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $usuario->email }}</p>
                                    </td>
                                    <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $usuario->sucursal_id }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $usuario->sucursal_id }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#verModal{{ $usuario->id }}">
                                            <i class="ni ni-zoom-split-in"></i>
                                        </button>
                                        
                                        <button type="button" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="modal" data-bs-target="#editarModal{{ $usuario->id }}">
                                            <i class="ni ni-ruler-pencil"></i>
                                        </button>
                                        
                                        <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="ni ni-fat-remove"></i>
                                            </button>
                                        </form>
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

<!-- Modal para Ver Usuario -->
@foreach($usuarios as $usuario)
<div class="modal fade" id="verModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="verModalLabel{{ $usuario->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verModalLabel{{ $usuario->id }}">
                    <i class="ni ni-single-02 me-2 text-primary"></i> Detalles del Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Rol del usuario</label>
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Nombre completo</label>
                            <div class="form-control form-control-alternative">
                                <i class="ni ni-single-02 me-2 text-primary"></i> 
                                {{ $usuario->name }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Correo electrónico</label>
                            <div class="form-control form-control-alternative">
                                <i class="ni ni-email-83 me-2 text-primary"></i> 
                                {{ $usuario->email }}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-control-label">Fecha de registro</label>
                            <div class="form-control form-control-alternative">
                                <i class="ni ni-calendar-grid-58 me-2 text-primary"></i> 
                                {{ $usuario->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Modal para Editar Usuario -->
@foreach($usuarios as $usuario)
<div class="modal fade" id="editarModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $usuario->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel{{ $usuario->id }}">
                    <i class="ni ni-ruler-pencil me-2 text-success"></i> Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/usuarios', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Rol del Usuario</label>
                                <select name="role" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $role->name == $usuario->roles->pluck('name')->implode(', ') ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-control-label">Nombre Completo</label>
                                <input type="text" class="form-control" value="{{ $usuario->name }}" name="name" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Correo Electrónico</label>
                                <input type="email" class="form-control" value="{{ $usuario->email }}" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-control-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para no cambiar">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-control-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal para Crear Usuario -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCrearLabel">
                    <i class="ni ni-fat-add me-2 text-primary"></i> Registrar Nuevo Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/usuarios/create') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Sucursal</label>
                                <select name="sucursal" class="form-control" required>
                                    <option value="">Seleccionar una sucursal</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}" {{ old('sucursal') == $sucursal->id ? 'selected' : '' }}>
                                            {{ $sucursal->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-control-label">Nombre Completo</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-control-label">Carnet de Identidad</label>
                                <input type="number" class="form-control" name="ci" value="{{ old('ci') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Rol del Usuario</label>
                                <select name="role" class="form-control" required>
                                    <option value="">Seleccionar un Rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-control-label">Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                            
                            <div class="alert alert-info mt-3">
                                <i class="ni ni-notification-70 me-2"></i> La contraseña será generada automáticamente
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    // Inicializar tooltips
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Confirmación antes de eliminar
    document.querySelectorAll('form[action*="destroy"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush