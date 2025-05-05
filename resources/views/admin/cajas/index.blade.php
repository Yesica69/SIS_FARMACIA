@extends('adminlte::page')

@section('content_header')
    <h1><b>Listado de cajas</b></h1>
@endsection

@section('content')
<div class="row">
    <!-- Tabla de usuarios registrados -->
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"></h3>
                            
                <div class="card-tools">

                @if ($cajaAbierto)                 
                 

                 @else 
                 <a href="{{ url('/admin/cajas/create') }}" class="btn btn-primary" style="margin-left: 20px;">
                        <i class="fas fa-plus"></i> Nuevo caja
                    </a>

                    <a href="{{ url('/admin/cajas/ingresos') }}" target="_blank" class="btn btn-danger" style="margin-left: 20px;">
                        <i class="fas fa-file-pdf"></i> reporte
                    </a>

                 @endif


                </div>
            </div>
            <div class="card-body">
                <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="text-align: center">Nro</th>
                            <th scope="col" style="text-align: center">Fecha de apertura</th>
                            <th scope="col" style="text-align: center">Monto inicial</th>
                            <th scope="col" style="text-align: center">Fecha de cierre</th>
                            <th scope="col" style="text-align: center">Monto final</th>
                            <th scope="col" style="text-align: center">Descripcion</th>
                            <th scope="col" style="text-align: center">Movimientos</th>
                            <th scope="col" style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($cajas as $caja)
                            <tr>
                                <td style="text-align: center">{{ $contador++ }}</td>
                                <td>{{ $caja->fecha_apertura }}</td>
                                <td>{{ $caja->monto_inicial }}</td>
                                <td>{{ $caja->fecha_cierre }}</td>
                                <td>{{ $caja->monto_final }}</td>
                                <td>{{ $caja->descripcion }}</td>
                                <td>
                                    <div class="row">
                                    <div class="col-md-5">
                                        <b>Ingresos</b>
                                        {{number_format($caja->total_ingresos,2)}}

                                    </div>
                                    <div class="col-md-5">
                                        <b>Egresos</b>
                                        {{number_format($caja->total_egresos,2)}}

                                    </div>
                                    </div>
                                </td>
                                <td style="text-align: center">
                                    <!-- Botón ingresos egresos-->
                                    <button type="button" class="btn btn-outline-warning" data-toggle="modal"
                                         data-target="#ingreso-egresoModal{{ $caja->id }}">
                                         <i class="fas fa-cash-register"></i>
                                    </button>
                                    
                                  

                                    <!-- Botón ingresos cerrar-->
                                    <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                         data-target="#cerrarModal{{ $caja->id }}">
                                         <i class="fas fa-lock"></i>
                                    </button>

                                    <!-- Botón ver-->
                                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                        data-target="#verModal{{ $caja->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Botón Editar -->
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal"
                                        data-target="#editarModal{{ $caja->id }}">
                                        <i class="fas fa-pencil"></i>
                                    </button>

                                   <!-- Botón Eliminar -->
<form id="miFormulario{{$caja->id}}" action="{{ url('/admin/cajas', $caja->id) }}" method="post" style="display: inline-block;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-outline-danger" onclick="preguntar{{$caja->id}}(event)">
        <i class="fas fa-trash"></i>
    </button>
</form>

<script>
function preguntar{{$caja->id}}(event) {
    event.preventDefault();

    Swal.fire({
        title: '¿Desea eliminar esta caja?',
        text: 'Si eliminas esta caja, se borrarán todos los movimientos asociados.',
        icon: 'warning',
        showDenyButton: true,
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#a5161d',
        denyButtonColor: '#6c757d',
        denyButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('miFormulario{{$caja->id}}').submit();
        }
    });
}
</script>


                            <!-- MODAL PARA INGRESOS/EGRESOS -->
                            <div class="modal fade" id="ingreso-egresoModal{{ $caja->id }}" tabindex="-1" role="dialog" aria-labelledby="ingresoEgresoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="ingresoEgresoModalLabel">Registro de Ingresos/Egresos</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/admin/cajas/create_ingresos_egresos')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $caja->id }}">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="fecha_apertura">Fecha de apertura</label>
                                                    <input type="datetime-local" class="form-control" value="{{ $caja->fecha_apertura }}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tipo">Tipo</label>
                                                    <select name="tipo" class="form-control">
                                                        <option value="INGRESO">INGRESO</option>
                                                        <option value="EGRESO">EGRESO</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="monto">Monto</label>
                                                    <input type="text" class="form-control" name="monto" value="{{ old('monto') }}">
                                                    @error('monto')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcion">Descripción</label>
                                                    <input type="text" class="form-control" name="descripcion" value="{{ old('descripcion') }}">
                                                    @error('descripcion')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Registrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL PARA CERRAR CAJA -->
                            <div class="modal fade" id="cerrarModal{{ $caja->id }}" tabindex="-1" role="dialog" aria-labelledby="cerrarModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="cerrarModalLabel">Cierre de caja</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/admin/cajas/create_cierre')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $caja->id }}">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="fecha_apertura">Fecha de apertura</label>
                                                    <input type="datetime-local" class="form-control" value="{{ $caja->fecha_apertura }}" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="monto_inicial">Monto inicial</label>
                                                    <input type="text" class="form-control" name="monto_inicial" value="{{ $caja->monto_inicial,old('monto_inicial') }}" disabled>
                                                    @error('monto_inicial')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="fecha_cierre">Fecha de cierre</label>
                                                    <input type="datetime-local" class="form-control" name="fecha_cierre" value="{{ old('fecha_cierre') }}">
                                                    @error('fecha_cierre')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="monto_final">Monto final</label>
                                                    <input type="text" class="form-control" name="monto_final" value="{{ old('monto_final') }}">
                                                    @error('monto_final')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Cerrar caja</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

 <!-- MODAL PARA VER -->
<div class="modal fade" id="verModal{{ $caja->id }}" tabindex="-1" role="dialog" aria-labelledby="verModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verModalLabel">Datos registrados</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Formulario -->
            <form action="{{ route('admin.cajas.show', $caja->id) }}" method="GET">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <!-- Caja 1: Datos de la Caja -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6>Datos de la Caja</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="fecha_apertura">Fecha de apertura</label>
                                        <input type="datetime-local" class="form-control" value="{{ $caja->fecha_apertura }}" name="fecha_apertura" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="monto_inicial">Monto inicial</label>
                                        <input type="text" class="form-control" value="{{ $caja->monto_inicial }}" name="monto_inicial" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_cierre">Fecha de Cierre</label>
                                        <input type="datetime-local" class="form-control" value="{{ $caja->fecha_cierre }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="monto_final">Monto Final</label>
                                        <input type="text" class="form-control" value="{{ $caja->monto_final }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <input type="text" class="form-control" value="{{ $caja->descripcion }}" name="descripcion" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Caja 2: Ingresos -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6>Ingresos</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr style="text-align: center">
                                                <th>Nro</th>
                                                <th>Detalle</th>
                                                <th>Monto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $contador = 1;?>
                                            

                                            @foreach($caja->movimientos->where('tipo', 'INGRESO') as $ingreso)
                                                    <tr>
                                                        <td style="text-align: center">{{ $contador++ }}</td>
                                                        <td>{{ $ingreso->descripcion }}</td>
                                                    <td>{{ $ingreso->monto }}</td>
                                                    
                                                    </tr>
                                               
                                            @endforeach


                                        </tbody>
                                        <tfooter>
                                            <tr>
                                            <td colspan="2" style="text-align: center"><b>Total</b></td>
                                <!-- Total Ingresos -->
                                            <td>{{ $caja->movimientos->where('tipo', 'INGRESO')->sum('monto') }} </td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Caja 3: Egresos -->
                        <div class="col-md-4">
                        <div class="card card-outline custom-lila">
                                <div class="card-header bg-light">
                                    <h6>Egresos</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Detalle</th>
                                                <th>Monto</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $contador = 1;?>
                                            @foreach($caja->movimientos->where('tipo', 'EGRESO') as $egreso)
                                                <tr>
                                                <td style="text-align: center">{{ $contador++ }}</td>
                                                <td>{{ $egreso->descripcion }}</td>
                                                    <td>{{ $egreso->monto }}</td>
                                                   
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                            <td colspan="2" style="text-align: center"><b>Total</b></td>
                               
                                <td>
                                <!-- Total Egresos -->
                                {{ $caja->movimientos->where('tipo', 'EGRESO')->sum('monto') }}
                            </td>
                                        </tfooter>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

     


                </div>
                <!-- Footer del modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



                            <!-- MODAL PARA EDITAR -->
                            <div class="modal fade" id="editarModal{{ $caja->id }}" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="editarModalLabel">Editar caja</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.cajas.update', $caja->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="fecha_apertura">Fecha de apertura</label>
                                                    <input type="datetime-local" class="form-control" name="fecha_apertura" value="{{ $caja->fecha_apertura }}" required>
                                                    @error('fecha_apertura')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="monto_inicial">Monto inicial</label>
                                                    <input type="text" class="form-control" name="monto_inicial" value="{{ $caja->monto_inicial }}">
                                                    @error('monto_inicial')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="descripcion">Descripción</label>
                                                    <input type="text" class="form-control" name="descripcion" value="{{ $caja->descripcion }}">
                                                    @error('descripcion')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Actualizar</button>
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


@endsection

@section('js')


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
@endsection
