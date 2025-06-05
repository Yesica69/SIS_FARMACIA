@extends('layouts.app', ['title' => 'Gestión de Usuarios'])

@section('content')


    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-0">
            <i class="ni ni-single-02 text-primary"></i>
            <strong>GESTIÓN DE USUARIOS</strong>
        </h2>
        <a href="{{ url('/admin/roles/reporte') }}" target="_blank" class="btn btn-danger btn-sm shadow">
            <i class="fas fa-file-pdf mr-1"></i> Generar Reporte
        </a>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Usuarios registrados</h3>
                        </div>
                        <div class="col text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCrear">
                                <i class="fas fa-plus mr-1"></i> Nuevo Usuario
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">Nro</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($usuarios as $usuario)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $usuario->firstname }} {{ $usuario->lastname ?? '' }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->roles->first()->name ?? 'Sin rol' }}</td>
                                    <td>{{ $usuario->sucursal->nombre ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <!-- Botón ver-->
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#verModal{{ $usuario->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Botón Editar -->
                                        <a href="{{ route('management.edit', $usuario->id) }}" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('management.destroy', $usuario->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                               <!-- MODAL PARA VER -->
                               <div class="modal fade" id="verModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="ni ni-single-02 text-primary mr-2"></i>Detalles del Usuario
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Rol del usuario</label>
                                                                <div class="input-group input-group-alternative mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                                                    </div>
                                                                    <input class="form-control" value="{{ $usuario->roles->pluck('name')->implode(', ') }}" readonly>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="form-control-label">Nombre completo</label>
                                                                <div class="input-group input-group-alternative mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                                                    </div>
                                                                    <input class="form-control" value="{{ $usuario->firstname }}" readonly>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="form-control-label">Carnet de Identidad</label>
                                                                <div class="input-group input-group-alternative mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                                                    </div>
                                                                    <input class="form-control" value="{{ $usuario->ci }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Correo electrónico</label>
                                                                <div class="input-group input-group-alternative mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                                                    </div>
                                                                    <input class="form-control" value="{{ $usuario->email }}" readonly>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="form-control-label">Sucursal</label>
                                                                <div class="input-group input-group-alternative mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-shop"></i></span>
                                                                    </div>
                                                                    <input class="form-control" value="{{ $usuario->sucursal->nombre ?? 'N/A' }}" readonly>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="form-control-label">Fecha de registro</label>
                                                                <div class="input-group input-group-alternative">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                                    </div>
                                                                    <input class="form-control" value="{{ $usuario->created_at->format('d/m/Y H:i') }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL PARA EDITAR USUARIO -->
                                    <div class="modal fade" id="editarModal{{ $usuario->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="ni ni-ruler-pencil text-success mr-2"></i>Editar Usuario
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label">Rol del Usuario</label>
                                                                    <select name="role" class="form-control">
                                                                        <option value="">Seleccionar un Rol</option>
                                                                        @foreach($roles as $role)
                                                                            <option value="{{ $role->name }}" {{ $role->name == $usuario->roles->pluck('name')->implode(', ') ? 'selected' : '' }}>
                                                                                {{ $role->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label class="form-control-label">Nombre Completo</label>
                                                                    <input type="text" class="form-control" name="firstname" value="{{ $usuario->firstname }}" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label class="form-control-label">Carnet de Identidad</label>
                                                                    <input type="text" class="form-control" name="ci" value="{{ $usuario->ci }}">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-control-label">Correo Electrónico</label>
                                                                    <input type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label class="form-control-label">Sucursal</label>
                                                                    <select name="sucursal_id" class="form-control">
                                                                        @foreach($sucursales as $sucursal)
                                                                            <option value="{{ $sucursal->id }}" {{ $usuario->sucursal_id == $sucursal->id ? 'selected' : '' }}>
                                                                                {{ $sucursal->nombre }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label class="form-control-label">Nueva Contraseña</label>
                                                                    <input type="password" class="form-control" name="password">
                                                                    <small class="text-muted">Dejar en blanco para no cambiar</small>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label class="form-control-label">Confirmar Contraseña</label>
                                                                    <input type="password" class="form-control" name="password_confirmation">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('css')
    <style>
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                },
                responsive: true
            });
        });
    </script>
@endsection


