@extends('layouts.app', ['title' => 'Gestión de Categorías'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Categorías'])
    
    <div class="container-fluid py-4">
        <!-- Primera tarjeta: Título y botón -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-radius-lg shadow">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">
                                <i class="ni ni-tag me-2 text-primary"></i>
                                <strong>Gestión de Categorías</strong>
                            </h5>
                        </div>
                        <button type="button" class="btn bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#modalCrear">
                            <i class="ni ni-fat-add me-1"></i> Nueva Categoría
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segunda tarjeta: Tabla de categorías -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 border-radius-lg shadow">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">
                            <i class="ni ni-bullet-list-67 me-2 text-primary"></i>
                            <strong>Categorías Registradas</strong>
                        </h6>
                    </div>
                    
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="mitabla" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 8%; text-align: center">Nro</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="text-align: center">Descripción</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 15%; text-align: center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $contador = 1;?>
                                    @foreach($categorias as $categoria)
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle">{{$contador++}}</td>
                                        <td style="vertical-align: middle">
                                            <span class="badge bg-gradient-primary p-2">
                                                <i class="ni ni-tag me-1"></i> {{$categoria->nombre}}
                                            </span>
                                        </td>
                                        <td style="vertical-align: middle">{{$categoria->descripcion}}</td>
                                        <td style="text-align: center; vertical-align: middle">
                                            <div class="btn-group" role="group">
                                                <!-- Botón Editar -->
                                                <button type="button" class="btn btn-sm btn-outline-warning mx-1" data-bs-toggle="modal" 
                                                    data-bs-target="#editModal{{ $categoria->id }}" title="Editar">
                                                    <i class="ni ni-ruler-pencil"></i>
                                                </button>

                                                <!-- Botón Eliminar -->
                                                <form action="{{ url('/admin/categorias', $categoria->id) }}" method="POST" style="display: inline-block;">
                                                   
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger mx-1" title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
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
    <div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="modalCrearLabel">
                        <i class="ni ni-fat-add me-2"></i><strong>Registrar Categoría</strong>
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/categorias/create') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre de la Categoría</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ni ni-tag"></i></span>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            </div>
                            @error('nombre')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion') }}" required>
                            </div>
                            @error('descripcion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="ni ni-fat-remove me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ni ni-check-bold me-1"></i> Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales para Editar (se generan dinámicamente para cada categoría) -->
    @foreach($categorias as $categoria)
    <div class="modal fade" id="editModal{{ $categoria->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $categoria->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-gradient-success">
                    <h5 class="modal-title text-white" id="editModalLabel{{ $categoria->id }}">
                        <i class="ni ni-ruler-pencil me-2"></i>Editar Categoría
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('/admin/categorias', $categoria->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Nombre de la categoría</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ni ni-tag"></i></span>
                                <input type="text" class="form-control" value="{{$categoria->nombre}}" name="nombre">
                            </div>
                            @error('nombre')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ni ni-align-left-2"></i></span>
                                <input type="text" class="form-control" value="{{$categoria->descripcion}}" name="descripcion">
                            </div>
                            @error('descripcion')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ni ni-fat-remove me-1"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="ni ni-check-bold me-1"></i> Actualizar
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
    }
    .badge-primary {
        background-color: #5e72e4;
    }
    .btn-outline-warning {
        color: #fb6340;
        border-color: #fb6340;
    }
    .btn-outline-warning:hover {
        background-color: #fb6340;
        color: #fff;
    }
    .btn-outline-danger {
        color: #f5365c;
        border-color: #f5365c;
    }
    .btn-outline-danger:hover {
        background-color: #f5365c;
        color: white;
    }
    .modal-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    .bg-gradient-primary {
        background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
    }
    .bg-gradient-success {
        background: linear-gradient(87deg, #2dce89 0, #2dcecc 100%) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(94, 114, 228, 0.05);
    }
    .input-group-text {
        background-color: #f8fafc;
    }
    .border-radius-lg {
        border-radius: 0.5rem;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#mitabla').DataTable({
            "pageLength": 5,
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