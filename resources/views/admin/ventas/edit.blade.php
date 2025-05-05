@extends('adminlte::page')

@section('content_header')
    <h1><b>Modificacion de la venta</b></h1>
@endsection

@section('content')
<div class="row">
    <!-- Formulario para crear un usuario -->
    <div class="col-md-12">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Formulario -->
                <form action="{{url('/admin/ventas', $venta->id) }}" id="form_venta"method="post">
                        @csrf
                        @method('PUT')

                    <div class="modal-body text-left">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Columna izquierda (Cantidad) -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad</label>
                                            <input type="number" class="form-control" id ="cantidad" value="1" required>
                                            @error('cantidad')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Columna del código de producto -->
                                    <div class="col-md-6">
                                        <label for="codigo">Codigo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            </div>
                                            <input id ="codigo" type="text" class="form-control" name="codigo" >                                      
                                        </div>
                                    </div>

                                    <!-- Botón de modal para ver productos -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div style="height: 32px"></div>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#verModal">
                                                <i class="fas fa-search"></i>
                                            </button>

                                            <!-- Modal para ver productos -->
                                            <div class="modal fade" id="verModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="exampleModalLabel"><b>Listado de productos</b></h5>
                                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <table id="mitabla" class="table table-striped table-bordered table-hover table-lg table-responsive">
                                                                <!-- Aquí va el contenido de la tabla de productos -->
                                                                
                                                                        <thead class="thead-dark">
                                                                            <tr>
                                                                                <th>Nro</th>
                                                                                <th>Accion</th>
                                                                                <th>Código</th>
                                                                                <th>Nombre</th>
                                                                                <th>Descripción</th>
                                                                                <th>Stock</th>
                                                                                <th>Precio</th>
                                                                                <th>Fecha de Vencimiento</th>
                                                                                <th>Imagen</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $contador = 1; ?>
                                                                            @foreach($productos as $producto)
                                                                            <tr>
                                                                                <td>{{ $contador++ }}</td>
                                                                                <td style="text-align: center;vertical-align: middle">
                                                                                    <button type="button"class="btn btn-info seleccionar-btn" data-id="{{$producto->codigo}}">Seleccionar</button>
                                                                                </td>
                                                                                <td>{{ $producto->codigo }}</td>
                                                                                <td><b>{{ $producto->nombre }}</b></td>
                                                                                <td>{{ $producto->descripcion }}</td>
                                                                                <td style="color: red; font-weight: bold;">{{ $producto->stock }}</td>
                                                                                <td style="color: red; font-weight: bold;">{{ $producto->precio_venta }}</td>
                                                                                <td style="color: red; font-weight: bold;">{{ $producto->fecha_vencimiento }}</td>
                                                                                <td class="text-center">
                                                                                    @if($producto->imagen)
                                                                                        <img src="{{ asset('storage/' . $producto->imagen) }}" width="80" height="80" alt="Imagen">
                                                                                    @else
                                                                                        <p>Sin imagen</p>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    

                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="{{url('/admin/productos/create')}}" type="button" class="btn btn-success"> <i class="fas fa-plus"></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de productos seleccionados -->
                                <div class="row">
                                    <table class="table table-sm table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nro</th>
                                                <th>Codigo</th>
                                                <th>Cantidad</th>
                                                <th>Nombre</th>
                                                <th>Costo</th>
                                                <th>Total</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Aquí puedes agregar las filas dinámicamente con los productos -->
                                             <?php $cont = 1; $total_cantidad = 0; $total_venta = 0;?>
                                             @foreach($venta->detallesVenta as $detalle)
                                            


                                             <tr>
                                                <td style="text-align: center">{{$cont++}}</td>
                                                <td style="text-align: center">{{$detalle->producto->codigo}}</td>
                                                <td style="text-align: center">{{$detalle->cantidad}}</td>
                                                <td >{{$detalle->producto->nombre}}</td>
                                                <td style="text-align: center">{{$detalle->producto->precio_venta}}</td>
                                                <td style="text-align: center">{{$costo = $detalle->cantidad * $detalle->producto->precio_venta}}</td>
                                                <td style="text-align: center">
                                                <!-- Botón Eliminar -->
                                                
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{$detalle->id}}">
                                                        <i class="fas fa-trash"></i> 
                                                    </button>
                                                

                                                </td>
                                             </tr>
                                              <!--calcular el total-->
                                              @php
                                             $total_cantidad += $detalle->cantidad;
                                             $total_venta += $costo;
                                             @endphp
                                             @endforeach
                                        </tbody>
                                        <tfooter>
                                            <tr>
                                                <td colspan="2" style="text-align: right">Total</td>
                                               <td style="text-align: center"><b>{{$total_cantidad}}</b></td>
                                               <td colspan="2" style="text-align: right">Total venta</td>
                                               <td style="text-align: center"><b>{{$total_venta}}</b></td>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                            </div>

                            <!-- Columna derecha (Fecha) -->

                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#clienteModal">
                                            <i class="fas fa-search"></i>  cliente
                                        </button>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#clientecrearModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">Nonmbre del cliente</label>
                                                <input type="text" class="form-control" id="nombre_cliente_select" value="{{$venta->cliente->nombre_cliente ?? 'S/N'}}">
                                                <input type="text" class="form-control" id="id_cliente" name="cliente_id" value="{{$venta->cliente->id ??''}}"hidden>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">NIT/CI del cliente</label>
                                                <input type="text" class="form-control" id="nit_cliente_select" value="{{$venta->cliente->nit_ci ?? 'SIN'}}" >
                                               
                                            </div>
                                        </div>
<hr>
                                    
                                </div> <!-- Cierra la fila correctamente -->

                                <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha">Fecha de venta</label>
                                            <input type="date" class="form-control" name="fecha" value="{{old( 'fecha', $venta->fecha) }}">
                                            @error('fecha')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    
                                </div> <!-- Cierra la fila correctamente -->

                                <!-- Sección del Total -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="precio_total">Total</label>
                                            <input type="text" style="text-align: center;background-color: pink" class="form-control" name="precio_total" 
                                                value="{{$total_venta}}">
                                            @error('precio_total')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div> <!-- Cierra la fila correctamente -->
                            </div> <!-- Cierra col-md-4 correctamente -->

                            <!-- Modal para ver clientes -->
                            <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="exampleModalLabel"><b>Listado de clientes</b></h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table id="mitabla2" class="table table-striped table-bordered table-hover table-lg table-responsive">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Nro</th>
                                                        <th>Acción</th>
                                                        <th>Nombre</th>
                                                        <th>NIT/CI</th>
                                                        <th>Celular</th>
                                                        <th>Correo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $contador = 1; ?>
                                                    @foreach($clientes as $cliente)
                                                    <tr>
                                                        <td>{{ $contador++ }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-info seleccionar-btn-cliente" data-id="{{$cliente->id}}"  data-nit="{{$cliente->nit_ci}}" data-nombre_cliente="{{$cliente->nombre_cliente}}">
                                                                Seleccionar
                                                            </button>
                                                        </td>
                                                        <td><b>{{ $cliente->nombre_cliente }}</b></td>
                                                        <td><b>{{ $cliente->nit_ci }}</b></td>
                                                        <td><b>{{ $cliente->celular }}</b></td>
                                                        <td><b>{{ $cliente->email }}</b></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Cierra el modal correctamente -->
  <!-- Modal para ver clientes -->
  <div class="modal fade" id="clientecrearModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="exampleModalLabel"><b>Registar de clientes</b></h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        
                    
                                            @csrf

                                            <div class="row">
                                                <!-- Campo Nombre -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nombre_cliente">Nombre</label>
                                                        <input type="text" class="form-control" value="{{ old('nombre_cliente') }}" id="nombre_cliente" >
                                                        @error('nombre_cliente')
                                                            <small style="color: red;">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>   

                                                <!-- Campo Nit -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nit_ci">NIT/CI</label>
                                                        <input type="text" class="form-control" value="{{ old('nit_ci') }}" id="nit_ci"   >
                                                        @error('nit_ci')
                                                            <small style="color: red;">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>  

                                                <!-- Campo Celular -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="celular">Celular</label>
                                                        <input type="text" class="form-control" value="{{ old('celular') }}" id="celular"  >
                                                        @error('celular')
                                                            <small style="color: red;">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>                 

                                                <!-- Campo Correo -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email">Correo</label>
                                                        <div class="input-group">
                                                            <input type="email" value="{{ old('email') }}" class="form-control" id="email" >
                                                        </div>
                                                        @error('email')
                                                            <small style="color: red;">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" onclick="guardar_cliente()" class="btn btn-primary" style="margin-left: 20px;">
                                            <i class="fas fa-save"></i> Registrar
                                        </button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Cierra el modal correctamente -->

                            
                            
                        </div>
                    </div>

                    <!-- Footer del formulario -->
                    <div class="modal-footer">
                       
                        <button type="submit" class="btn btn-primary">actualizar venta</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
@endsection

@section('js')
<script>
    //REGISTRAR UN CLINTE 
    function guardar_cliente(){
        const data = {
    nombre_cliente: $('#nombre_cliente').val(),
    nit_ci: $('#nit_ci').val(),
    celular: $('#celular').val(),
    email: $('#email').val(),
    _token: '{{csrf_token()}}' 
};

        $.ajax({
            url:'{{route("admin.ventas.cliente.store")}}',
            type: 'POST',
            data: data,
            success:function (response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Se agrego el cliente",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    location.reload();
                } else {
                    alert('Error: no se pudo eliminar el producto');
                }

                
            },
            error: function(error) {
                    // Mostramos el mensaje de error con el contenido del objeto
                    alert(JSON.stringify(error)); // Si necesitaver todo el error
                }
        });
    }

//selecionar de la busqueda lab
$('.seleccionar-btn-cliente').click(function (){
    var id_cliente = $(this).data('id');
    var nombre_cliente = $(this).data('nombre_cliente');
    var nit_ci = $(this).data('nit');
  // alert(nombre_cliente);   nombre_cliente
   $('#nombre_cliente_select').val(nombre_cliente);
   $('#nit_cliente_select').val(nit_ci);
   $('#id_cliente').val(id_cliente);
   //cerra el modal 
   $('#clienteModal').modal('hide');
   
});


//selecionar de la busqueda un producto
$('.seleccionar-btn').click(function (){
    var id_producto = $(this).data('id');
   // alert(id_producto)
   $('#codigo').val(id_producto);
   //cerra el modal 
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
            url: "{{url('/admin/ventas/detalle')}}/"+id, // Se corrigió el uso de route()
            type: 'POST',
            data: {
                _token: '{{ csrf_token()}}', // Se corrigió el espacio en csrf_token()
                _method: 'DELETE' // Se corrigió method por _method
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
    console.log(error); // Esto ayudará a ver todo el objeto en la consola para depuración.
    alert('Error: ' + (error.responseJSON?.message || error.statusText || 'Algo salió mal'));
}

            
        });
    }
});

//para que aparesca al presionar enter
$('#codigo').focus();
//la 
$('#form_venta').on('keypress',function (e){
    if(e.keyCode === 13){   
        e.preventDefault();
    }
});
//para buscar el prodiucto meiante un codio
    $('#codigo').on('keyup', function (e) {
        if (e.which === 13){
            var codigo = $(this).val();
        var cantidad = $('#cantidad').val();
        var id_venta = '{{$venta->id}}';

        if(codigo.length > 0) {
            $.ajax({
                url: "{{ route ('admin.detalle.ventas.store')}}",
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    codigo: codigo,
                    cantidad: cantidad,
                    id_venta: id_venta
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
</script>

<script>
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
