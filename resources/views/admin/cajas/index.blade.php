@extends('layouts.app', ['title' => 'Productos'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Productos'])
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="mb-0"><b>Listado de cajas</b></h3>
                    <div class="card-header bg-transparent border-0">
                    @if ($cajaAbierto)                 
                    @else 
                    <a href="{{ url('/admin/cajas/create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo caja
                    </a>

                    
                    @endif


                    <!-- Barra de acciones -->
                <div class="d-flex gap-2 align-items-center">
    <button class="btn btn-sm btn-outline-secondary" id="refreshTable">
        <i class="fas fa-sync-alt me-1"></i> Actualizar
    </button>
    <div class="position-relative"> <!-- Contenedor relativo importante -->
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                    id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-download me-1"></i> Exportar
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" 
                style="z-index: 1060; position: absolute;"
                aria-labelledby="exportDropdown">
                <li>
                    <a class="dropdown-item d-flex align-items-center" 
                       href="{{ route('admin.cajas.reporte', ['tipo' => 'pdf']) }}?fecha_inicio={{ request('fecha_inicio') }}&fecha_fin={{ request('fecha_fin') }}&cliente_id={{ request('cliente_id') }}"
                       target="_blank">
                        <i class="fas fa-file-pdf text-danger me-2"></i> PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" 
                       href="{{ route('admin.cajas.reporte', ['tipo' => 'excel']) }}?fecha_inicio={{ request('fecha_inicio') }}&fecha_fin={{ request('fecha_fin') }}&cliente_id={{ request('cliente_id') }}">
                        <i class="fas fa-file-excel text-success me-2"></i> Excel
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" 
                       href="{{ route('admin.cajas.reporte', ['tipo' => 'csv']) }}?fecha_inicio={{ request('fecha_inicio') }}&fecha_fin={{ request('fecha_fin') }}&cliente_id={{ request('cliente_id') }}">
                        <i class="fas fa-file-csv text-info me-2"></i> CSV
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
                </div>
                
                </div>
                
            </div>
            
            
        </div>
    </div>

   

    <!-- Card de tabla -->
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <!-- Tabla de Cajas -->
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table id="mitabla" class="table table-hover align-items-center mb-0 compact">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">#</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">Apertura</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder text-end">Inicial</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">Cierre</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder text-end">Final</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">Movimientos</th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cajas as $caja)
                        <tr>
                            <td class="text-xs text-center">{{ $loop->iteration }}</td>
                            <td class="text-xs">
                                <div class="d-flex flex-column">
                                    <span class="font-weight-bold">{{ date('d/m/Y', strtotime($caja->fecha_apertura)) }}</span>
                                    <small class="text-muted">{{ date('H:i', strtotime($caja->fecha_apertura)) }}</small>
                                </div>
                            </td>
                            <td class="text-xs text-end font-weight-bold text-primary">Bs {{ number_format($caja->monto_inicial, 2) }}</td>
                            <td class="text-xs">
                                @if($caja->fecha_cierre)
                                <div class="d-flex flex-column">
                                    <span class="font-weight-bold">{{ date('d/m/Y', strtotime($caja->fecha_cierre)) }}</span>
                                    <small class="text-muted">{{ date('H:i', strtotime($caja->fecha_cierre)) }}</small>
                                </div>
                                @else
                                <span class="badge bg-warning text-dark">Abierta</span>
                                @endif
                            </td>
                            <td class="text-xs text-end font-weight-bold @if($caja->monto_final) text-success @else text-muted @endif">
                                @if($caja->monto_final) Bs {{ number_format($caja->monto_final, 2) }} @else -- @endif
                            </td>
                            <td class="text-xs">
                                <div class="d-flex justify-content-around">
                                    <div class="text-center">
                                        <span class="badge bg-success text-white">Ingresos</span>
                                        <div class="font-weight-bold">Bs {{ number_format($caja->total_ingresos, 2) }}</div>
                                    </div>
                                    <div class="text-center">
                                        <span class="badge bg-danger text-white">Egresos</span>
                                        <div class="font-weight-bold">Bs {{ number_format($caja->total_egresos, 2) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
    <div class="d-flex justify-content-center gap-1">
        <!-- Botón ingresos/egresos -->
        @if(!$caja->fecha_cierre)
        <button type="button" class="btn btn-action btn-warning"
            data-bs-toggle="modal" data-bs-target="#ingresoEgresoModal{{$caja->id}}"
            data-bs-tooltip="tooltip" title="Registrar Movimientos">
            <i class="fas fa-exchange-alt"></i>
        </button>
        @endif
        <!-- Botón cerrar caja -->
        @if(!$caja->fecha_cierre)
        <button type="button" class="btn btn-action btn-secondary"
            data-bs-toggle="modal" data-bs-target="#cerrarModal{{$caja->id}}"
            data-bs-tooltip="tooltip" title="Cerrar Caja">
            <i class="fas fa-lock"></i>
        </button>
        @endif
        
        <!-- Botón ver -->
        <button type="button" class="btn btn-action btn-info"
            data-bs-toggle="modal" data-bs-target="#verModal{{$caja->id}}"
            data-bs-tooltip="tooltip" title="Ver Detalles">
            <i class="fas fa-eye"></i>
        </button>
        
        <!-- Botón editar 
        <button type="button" class="btn btn-action btn-primary"
            data-bs-toggle="modal" data-bs-target="#editarModal{{$caja->id}}"
            data-bs-tooltip="tooltip" title="Editar Caja">
            <i class="fas fa-pencil-alt"></i>
        </button>-->
        
        <!-- Botón eliminar -->
        <button type="button" class="btn btn-action btn-danger"
            onclick="confirmDelete({{$caja->id}})"
            data-bs-tooltip="tooltip" title="Eliminar Caja">
            <i class="fas fa-trash-alt"></i>
        </button>
        <form id="deleteForm{{$caja->id}}" action="{{url('/admin/cajas/'.$caja->id)}}" method="POST" class="d-none">
            @csrf @method('DELETE')
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

<!-- Modales -->
@foreach($cajas as $caja)
<!-- Modal Ingreso/Egreso -->
<div class="modal fade" id="ingresoEgresoModal{{$caja->id}}" tabindex="-1" aria-labelledby="ingresoEgresoModalLabel{{$caja->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ingresoEgresoModalLabel{{$caja->id}}">Registro de Ingresos/Egresos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('/admin/cajas/create_ingresos_egresos')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$caja->id}}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Fecha de apertura</label>
                        <input type="text" class="form-control" value="{{$caja->fecha_apertura}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select name="tipo" class="form-select" required>
                            <option value="INGRESO">INGRESO</option>
                            <option value="EGRESO">EGRESO</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" step="0.01" class="form-control" name="monto" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="descripcion" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cerrar Caja -->
<div class="modal fade" id="cerrarModal{{$caja->id}}" tabindex="-1" aria-labelledby="cerrarModalLabel{{$caja->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="cerrarModalLabel{{$caja->id}}">Cierre de Caja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{url('/admin/cajas/create_cierre')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$caja->id}}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Fecha de apertura</label>
                        <input type="text" class="form-control" value="{{$caja->fecha_apertura}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Monto inicial</label>
                        <input type="text" class="form-control" value="{{$caja->monto_inicial}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_cierre" class="form-label">Fecha de cierre</label>
                        <input type="datetime-local" class="form-control" name="fecha_cierre" required>
                    </div>
                    <div class="mb-3">
                        <label for="monto_final" class="form-label">Monto final</label>
                        <input type="number" step="0.01" class="form-control" name="monto_final" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Cerrar Caja</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ver -->
<div class="modal fade" id="verModal{{$caja->id}}" tabindex="-1" aria-labelledby="verModalLabel{{$caja->id}}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verModalLabel{{$caja->id}}">Detalles de Caja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Datos de Caja -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6>Datos de Caja</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Apertura</label>
                                    <input type="text" class="form-control" value="{{$caja->fecha_apertura}}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Monto Inicial</label>
                                    <input type="text" class="form-control" value="{{$caja->monto_inicial}}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fecha Cierre</label>
                                    <input type="text" class="form-control" value="{{$caja->fecha_cierre ?? 'No cerrada'}}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Monto Final</label>
                                    <input type="text" class="form-control" value="{{$caja->monto_final ?? 'No cerrada'}}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Descripción</label>
                                    <input type="text" class="form-control" value="{{$caja->descripcion}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ingresos -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6>Ingresos</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr class="text-center">
                                            <th>N°</th>
                                            <th>Detalle</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach($caja->movimientos->where('tipo', 'INGRESO') as $ingreso)
                                        <tr>
                                            <td class="text-center">{{$i++}}</td>
                                            <td>{{$ingreso->descripcion}}</td>
                                            <td>{{number_format($ingreso->monto, 2, '.', '.')}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-center"><b>Total</b></td>
                                            <td><b>{{number_format($caja->movimientos->where('tipo', 'INGRESO')->sum('monto'), 2, '.', '.')}}</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Egresos -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6>Egresos</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr class="text-center">
                                            <th>N°</th>
                                            <th>Detalle</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $e = 1; @endphp
                                        @foreach($caja->movimientos->where('tipo', 'EGRESO') as $egreso)
                                        <tr>
                                            <td class="text-center">{{$e++}}</td>
                                            <td>{{$egreso->descripcion}}</td>
                                            <td>{{ number_format($egreso->monto, 0, '.', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-center"><b>Total</b></td>
                                            <td><b>{{number_format($caja->movimientos->where('tipo', 'EGRESO')->sum('monto'), 2, '.', '.')}}</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
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

<!-- Modal Editar -->
<div class="modal fade" id="editarModal{{$caja->id}}" tabindex="-1" aria-labelledby="editarModalLabel{{$caja->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editarModalLabel{{$caja->id}}">Editar Caja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.cajas.update', $caja->id)}}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fecha_apertura" class="form-label">Fecha Apertura</label>
                        <input type="datetime-local" class="form-control" name="fecha_apertura" value="{{$caja->fecha_apertura}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="monto_inicial" class="form-label">Monto Inicial</label>
                        <input type="number" step="0.01" class="form-control" name="monto_inicial" value="{{$caja->monto_inicial}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" class="form-control" name="descripcion" value="{{$caja->descripcion}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach



<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#mitabla').DataTable({
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
                }
            }
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm'+id).submit();
            }
        })
    }
</script>
@endsection








