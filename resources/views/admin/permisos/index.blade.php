@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center bg-gradient-white p-3 rounded-top">
    <h1 class="m-0 text-black"><i class="fas fa-key"></i> <strong>LISTADO DE PERMISOS</strong></h1>
    <a href="{{ url('/admin/roles/reporte') }}" target="_blank" class="btn btn-danger btn-sm shadow-sm">
        <i class="fas fa-file-pdf mr-1"></i> Generar Reporte
    </a>
</div>
    
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Registro de permisos</h3>

                <div class="card-tools">
                    <!-- Botón para crear nuevo permiso -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCrear">
                        <i class="fas fa-plus"></i> Nuevo Permiso
                    </button>
                </div>
            </div>

            <div class="card-body">
                <!-- Tabla de permisos -->
                <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col" style="text-align: center">Nombre del Permiso</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($permisos as $permiso)
                            <tr>
                                <td style="text-align: center">{{ $contador++ }}</td>
                                <td style="text-align: center">{{ $permiso->name }}</td>
                                <td style="text-align: center">
                                    <!-- Botón Editar -->
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" 
                                        data-target="#editModal{{ $permiso->id }}">
                                        <i class="fas fa-pencil"></i>
                                    </button>

                                    <!-- Botón Eliminar -->
                                    <form action="{{ url('/admin/permisos', $permiso->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" >
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal para Editar Permiso -->
                            <div class="modal fade" id="editModal{{ $permiso->id }}" tabindex="-1" role="dialog" 
                                        aria-labelledby="editModalLabel{{ $permiso->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-gradient-success text-white">
                                                    <h5 class="modal-title" id="editModalLabel{{ $permiso->id }}">
                                                        <i class="fas fa-edit mr-2"></i>Editar Permiso
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('/admin/permisos', $permiso->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">Nombre del Permiso</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                                </div>
                                                                <input type="text" name="name" class="form-control" 
                                                                    value="{{ old('name', $permiso->name) }}" required>
                                                            </div>
                                                            @error('name')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                            <i class="fas fa-times mr-1"></i> Cancelar
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-save mr-1"></i> Actualizar
                                                        </button>
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

<!-- Modal para Crear Nuevo Permiso -->
<div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" 
    aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="modalCrearLabel">
                    <i class="fas fa-plus-circle mr-2"></i><strong>Registrar Nuevo Permiso</strong>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/admin/permisos/create') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre del Permiso</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type="text" class="form-control" name="name" 
                                value="{{ old('name') }}" required placeholder="Ej: Gestionar Roles">
                        </div>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    <!-- Estilos adicionales si son necesarios -->
@stop

@section('js')
    <!-- Scripts adicionales si son necesarios -->

    <script>
    $('#mitabla'). DataTable({
        "pageLength":5,
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
</script>
@stop



