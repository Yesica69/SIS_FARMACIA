@extends('adminlte::page')

@section('content_header')
    
    <div class="d-flex justify-content-between align-items-center bg-gradient-white p-3 rounded-top">
    <h1 class="m-0 text-black"><i class="fas fa-user mr-2"></i> <strong>GESTIÓN DE USUARIOS</strong></h1>
    <a href="{{ url('/admin/roles/reporte') }}" target="_blank" class="btn btn-danger btn-sm shadow-sm">
        <i class="fas fa-file-pdf mr-1"></i> Generar Reporte
    </a>
</div>
@endsection

@section('content')
<div class="row">
    <!-- Tabla de usuarios registrados -->
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Usuarios registrados</h3>
                            

                <div class="card-tools">
                   
        <!-- Modal para crear usuario-->

  <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCrear">
  <i class="fas fa-plus"></i> Nuevo Usuario
                                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col" style="text-align: center">Nombre del Usuario</th>
                            <th scope="col" style="text-align: center">Correo</th>
                            <th scope="col" style="text-align: center">Rol</th>
                            <th scope="col" style="text-align: center">Sucursal</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td style="text-align: center">{{ $contador++ }}</td>
                                <td >{{ $usuario->name }}</td>
                                <td >{{ $usuario->email }}</td>
                                <td > {{ $usuario->roles->pluck('name')->implode(', ') }}</td>
                                <td > {{ $usuario->sucursal_id }}</td>
                                <td style="text-align: center">

                                      <!-- Botón ver-->
                                  <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#verModal{{ $usuario->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Botón Editar -->
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#editarModal{{ $usuario->id }}">
                                        <i class="fas fa-pencil"></i>
                                    </button>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                   <!-- MODAL PARA VER -->
<div class="modal fade" id="verModal{{ $usuario->id }}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <!-- Header del modal - Mejorado -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-user-circle mr-2"></i> Detalles del Usuario
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="opacity-75">&times;</span>
                </button>
            </div>
            
            <!-- Formulario -->
            <form action="{{ route('admin.usuarios.show', $usuario->id) }}" method="GET">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <!-- Contenedor de información con mejor diseño -->
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">
                            <!-- Campo: Rol -->
                            <div class="form-group mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Rol del usuario</label>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0 text-dark font-weight-bold">
                                        <i class="fas fa-user-tag mr-2 text-primary"></i> 
                                        {{ $usuario->roles->pluck('name')->implode(', ') }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Campo: Nombre del usuario -->
                            <div class="form-group mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Nombre completo</label>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0 text-dark font-weight-bold">
                                        <i class="fas fa-user mr-2 text-primary"></i> 
                                        {{ $usuario->name }}
                                    </p>
                                </div>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <!-- Campo: Correo -->
                            <div class="form-group mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Correo electrónico</label>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0 text-dark font-weight-bold">
                                        <i class="fas fa-envelope mr-2 text-primary"></i> 
                                        {{ $usuario->email }}
                                    </p>
                                </div>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- Campo: Fecha de registro -->
                            <div class="form-group mb-4">
                                <label class="text-muted small font-weight-bold text-uppercase mb-1">Fecha de registro</label>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0 text-dark font-weight-bold">
                                        <i class="far fa-calendar-alt mr-2 text-primary"></i> 
                                        {{ $usuario->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer del modal - Mejorado -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

                                    

                                    <!-- MODAL PARA EDITAR USUARIO -->
<div class="modal fade" id="editarModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $usuario->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <!-- Header del modal - Mejorado -->
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title font-weight-bold">
                    <i class="fas fa-user-edit mr-2"></i> Editar Usuario
                </h5>
                <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Formulario -->
            <form action="{{ url('/admin/usuarios', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <!-- Campo: Rol -->
                            <div class="form-group mb-4">
                                <label for="role-{{ $usuario->id }}" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-user-tag mr-1"></i> Rol del Usuario
                                </label>
                                <select name="role" id="role-{{ $usuario->id }}" class="form-control select2" style="width: 100%;">
                                    <option value="">Seleccionar un Rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $role->name == $usuario->roles->pluck('name')->implode(', ') ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Campo: Nombre -->
                            <div class="form-group mb-4">
                                <label for="name" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-user mr-1"></i> Nombre Completo
                                </label>
                                <input type="text" class="form-control" id="name" value="{{ $usuario->name }}" name="name" required>
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <!-- Campo: Email -->
                            <div class="form-group mb-4">
                                <label for="email" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-envelope mr-1"></i> Correo Electrónico
                                </label>
                                <input type="email" class="form-control" id="email" value="{{ $usuario->email }}" name="email" required>
                                @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- Campo: Contraseña -->
                            <div class="form-group mb-4">
                                <label for="password" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-lock mr-1"></i> Nueva Contraseña
                                </label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="text-muted">Dejar en blanco para no cambiar</small>
                                @error('password')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- Campo: Confirmar Contraseña -->
                            <div class="form-group mb-4">
                                <label for="password_confirmation" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-lock mr-1"></i> Confirmar Contraseña
                                </label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer del modal - Mejorado -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
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

                       <!-- MODAL CREAR USUARIO -->
<div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <!-- Header del modal - Mejorado -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title font-weight-bold" id="modalCrearLabel">
                    <i class="fas fa-user-plus mr-2"></i> Registrar Nuevo Usuario
                </h5>
                <button type="button" class="close text-white opacity-75" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <!-- Formulario -->
            <form action="{{ url('/admin/usuarios/create') }}" method="post">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <!-- Campo: Sucursal -->
                            <div class="form-group mb-4">
                                <label for="sucursal" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-store mr-1"></i> Sucursal
                                </label>
                                <select name="sucursal" id="sucursal" class="form-control select2" required>
                                    <option value="">Seleccionar una sucursal</option>
                                    @foreach($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}" {{ old('sucursal') == $sucursal->id ? 'selected' : '' }}>
                                            {{ $sucursal->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Campo: Nombre -->
                            <div class="form-group mb-4">
                                <label for="name" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-user mr-1"></i> Nombre Completo
                                </label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autocomplete="off">
                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- Campo: Carnet de Identidad -->
                            <div class="form-group mb-4">
                                <label for="ci" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-id-card mr-1"></i> Carnet de Identidad
                                </label>
                                <input type="number" class="form-control" id="ci" name="ci" value="{{ old('ci') }}" autocomplete="off">
                            </div>
                        </div>
                        
                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <!-- Campo: Rol -->
                            <div class="form-group mb-4">
                                <label for="role" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-user-tag mr-1"></i> Rol del Usuario
                                </label>
                                <select name="role" id="role" class="form-control select2" required>
                                    <option value="">Seleccionar un Rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Campo: Correo -->
                            <div class="form-group mb-4">
                                <label for="email" class="text-muted small font-weight-bold text-uppercase mb-2">
                                    <i class="fas fa-envelope mr-1"></i> Correo Electrónico
                                </label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="off">
                                @error('email')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- Sección de Contraseña -->
                            <div class="alert alert-info mt-3 p-2">
                                <small>
                                    <i class="fas fa-info-circle mr-1"></i> La contraseña será generada automáticamente 
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer del modal - Mejorado -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
                                            </div>
                                        </div>
                                    </div>


@endsection

@section('css')
@endsection

@section('js')
@endsection