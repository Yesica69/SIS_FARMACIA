@extends('adminlte::page')

@section('title', 'Gestión de Clientes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark"><i class="fas fa-users mr-2"></i> <strong>Clientes</strong></h1>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-plus mr-2"></i>Registro de Nuevo Cliente
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
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
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
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
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        </div>
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
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        </div>
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
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" value="{{ old('email') }}" class="form-control" name="email">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-1"></i> Registrar
                                            </button>
                                        </div>
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

        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list-ol mr-2"></i>Clientes Registrados
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="mitabla" class="table table-hover table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 8%; text-align: center">Nro</th>
                                    <th style="text-align: center">Nombre</th>
                                    <th style="text-align: center">NIT/CI</th>
                                    <th style="text-align: center">Celular</th>
                                    <th style="text-align: center">Correo</th>
                                    <th style="width: 15%; text-align: center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 1;?>
                                @foreach($clientes as $cliente)
                                <tr>
                                    <td style="text-align: center; vertical-align: middle">{{$contador++}}</td>
                                    <td style="vertical-align: middle">
                                        <span class="badge badge-primary p-2">
                                            <i class="fas fa-user mr-1"></i> {{$cliente->nombre_cliente}}
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle">{{$cliente->nit_ci}}</td>
                                    <td style="vertical-align: middle">{{$cliente->celular}}</td>
                                    <td style="vertical-align: middle">{{$cliente->email}}</td>
                                    <td style="text-align: center; vertical-align: middle">
                                        <div class="btn-group" role="group">
                                            <!-- Botón Editar -->
                                            <button type="button" class="btn btn-sm btn-outline-warning mx-1" data-toggle="modal" 
                                                data-target="#editModal{{ $cliente->id }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Botón Eliminar -->
                    <form action="{{ url('/admin/clientes', $cliente->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" >
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
<div class="modal fade" id="editModal{{ $cliente->id }}" role="dialog" aria-labelledby="editModalLabel{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title" id="editModalLabel{{ $cliente->id }}">
                    <i class="fas fa-edit mr-2"></i>Editar Cliente
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
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
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{$cliente->nombre_cliente}}" name="nombre_cliente">
                        </div>
                        @error('nombre_cliente')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nit_ci">NIT/CI</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{$cliente->nit_ci}}" name="nit_ci">
                        </div>
                        @error('nit_ci')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="celular">Celular</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{$cliente->celular}}" name="celular">
                        </div>
                        @error('celular')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{$cliente->email}}" name="email">
                        </div>
                        @error('email')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cerrar
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
@stop

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    .table thead th {
        background-color: #f1f5f9;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    .badge-primary {
        background-color: #3b82f6;
    }
    .btn-outline-warning {
        color: #eab308;
        border-color: #eab308;
    }
    .btn-outline-warning:hover {
        background-color: #eab308;
        color: #1f2937;
    }
    .btn-outline-danger {
        color: #ef4444;
        border-color: #ef4444;
    }
    .btn-outline-danger:hover {
        background-color: #ef4444;
        color: white;
    }
    .modal-header {
        border-top-left-radius: 0.3rem;
        border-top-right-radius: 0.3rem;
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    .input-group-text {
        background-color: #f8fafc;
    }
    #mitabla_wrapper .dataTables_filter input {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 5px;
    }
</style>
@stop

@section('js')
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
                $('.dataTables_filter input').addClass('form-control-sm');
            }
        });
    });
</script>
@stop