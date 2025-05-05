@extends('adminlte::page')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0 text-dark"><i class="fas fa-shopping-cart mr-2"></i> <strong>Detalle de la Compra</strong></h1>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>Datos Registrados
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Columna izquierda (Tabla de productos) -->
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 5%; text-align: center">Nro</th>
                                            <th style="text-align: center">Código</th>
                                            <th style="text-align: center">Cantidad</th>
                                            <th style="text-align: center">Nombre</th>
                                            <th style="text-align: center">Lbortorio</th>
                                            <th style="text-align: center">Costo</th>
                                            <th style="text-align: center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 1; $total_cantidad = 0; $total_compra = 0; ?>
                                        @foreach($compra->detalles as $detalle)
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle">{{$cont++}}</td>
                                                <td style="text-align: center; vertical-align: middle">
                                                    <span class="badge badge-secondary">{{$detalle->producto->codigo}}</span>
                                                </td>
                                                <td style="text-align: center; vertical-align: middle">{{$detalle->cantidad}}</td>
                                                <td style="vertical-align: middle">{{$detalle->producto->nombre}}</td>
                                                <td style="vertical-align: middle">"{{$compra->laboratorio->nombre}}" </td>
                                                <td style="text-align: center; vertical-align: middle">Bs{{number_format($detalle->producto->precio_compra, 2)}}</td>
                                                <td style="text-align: center; vertical-align: middle">Bs{{number_format($costo = $detalle->cantidad * $detalle->producto->precio_compra, 2)}}</td>
                                            </tr>
                                            @php
                                                $total_cantidad += $detalle->cantidad;
                                                $total_compra += $costo;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="2" style="text-align: right"><strong>Total</strong></td>
                                            <td style="text-align: center"><strong>{{$total_cantidad}}</strong></td>
                                            <td colspan="2" style="text-align: right"><strong>Total compra</strong></td>
                                            <td style="text-align: center"><strong>Bs{{number_format($total_compra, 2)}}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <!-- Columna derecha (Fecha y detalles de compra) -->
                        <div class="col-md-4">
                            
                            <div class="card border-info mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0"><i class="fas fa-calendar-alt mr-2"></i>Información de Compra</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="fecha">Fecha</label>
                                        <input type="date" class="form-control bg-light" value="{{$compra->fecha}}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="comprobante{{$compra->id}}">Comprobante</label>
                                        <select name="comprobante" id="comprobante{{$compra->id}}" class="form-control bg-light" disabled>
                                            <option value="FACTURA" {{ trim($compra->comprobante) == 'FACTURA' ? 'selected' : '' }}>FACTURA</option>
                                            <option value="RECIBO" {{ trim($compra->comprobante) == 'RECIBO' ? 'selected' : '' }}>RECIBO</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="precio_total">Monto Total</label>
                                        <input type="text" class="form-control text-center font-weight-bold text-danger bg-light" value="Bs{{number_format($total_compra, 2)}}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer text-right">
                    <a href="{{url('/admin/compras')}}" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
    .badge-secondary {
        background-color: #6c757d;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    .bg-light {
        background-color: #f8f9fa!important;
    }
    .card.border-primary {
        border-color: #3b82f6!important;
    }
    .card.border-info {
        border-color: #06b6d4!important;
    }
    .text-danger {
        color: #dc3545!important;
    }
    .font-weight-bold {
        font-weight: 600!important;
    }
</style>
@endsection

@section('js')
<script>
//selecionar de la busqueda lab
$('.seleccionar-btn-laboratorio').click(function (){
    var id_laboratorio = $(this).data('id');
    var nombre = $(this).data('nombre');
   $('#nombre_laboratorio').val(nombre);
   $('#id_laboratorio').val(id_laboratorio);
   $('#labModal').modal('hide');
});

//selecionar de la busqueda un producto
$('.seleccionar-btn').click(function (){
    var id_producto = $(this).data('id');
   $('#codigo').val(id_producto);
   $('#verModal').modal('hide');
   $('#verModal').on('hidden.bs.modal', function () {
    $('#codigo').focus();
   });
});

//eliminar un compra
$('.delete-btn').click(function () {
    var id = $(this).data('id');
    if (id) {
        $.ajax({
            url: "{{url('/admin/compras/create/tmp')}}/"+id,
            type: 'POST',
            data: {
                _token: '{{ csrf_token()}}',
                _method: 'DELETE'
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Se eliminó el producto",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                } else {
                    alert('Error: no se pudo eliminar el producto');
                }
            },
            error: function (error) {
                alert(error);
            }
        });
    }
});

//para que aparesca al presionar enter
$('#codigo').focus();
//la 
$('#form_compra').on('keypress',function (e){
    if(e.keyCode === 13){   
        e.preventDefault();
    }
});
//para buscar el prodiucto meiante un codio
    $('#codigo').on('keyup', function (e) {
        if (e.which === 13){
            var codigo = $(this).val();
        var cantidad = $('#cantidad').val();

        if(codigo.length > 0) {
            $.ajax({
                url: "{{ route ('admin.compras.tmp_compras')}}",
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    codigo: codigo,
                    cantidad: cantidad
                },
                success: function (response) {
                    // Si hay éxito, mostramos el mensaje específico
                    if(response.success){
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Se regristro el producto",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    } else {
                        alert('No se encontró el producto');
                    }
                },
                error: function(error) {
                    // Mostramos el mensaje de error con el contenido del objeto
                    alert(JSON.stringify(error)); // Si necesitas ver todo el error
                }
            });
        }
        }
    });

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
        }
    });

    $('#mitabla2').DataTable({
        "pageLength": 5,
        "language": {
            "lengthMenu": "Mostrar _MENU_ ",
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