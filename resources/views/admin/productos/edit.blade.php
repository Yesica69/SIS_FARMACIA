@extends('adminlte::page')

@section('content_header')
    <h1><b>Productos registrados</b></h1>
@endsection

@section('content')
<div class="row">
    <section class="content">
        <!-- Default box -->
        <div class="card card-solid">
            <div class="col-md-12">
                <div class="card-body pb-sm">

                    <!-- MODAL PARA EDITAR PRODUCTO -->
                    <div class="modal fade" id="editarModal{{$producto->id}}" tabindex="-1" aria-labelledby="editarModalLabel{{$producto->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <!-- Header del modal -->
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="editarModalLabel{{$producto->id}}"><b>Editar Producto</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <!-- Formulario -->
                                <form action="{{ url('/admin/productos/' . $producto->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Selección de Categoría -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="categoria_id">Categoría</label>
                                                    <select name="categoria_id" class="form-control">
                                                        <option value="">Seleccionar una categoría</option>
                                                        @foreach($categorias as $categoria)
                                                            <option value="{{$categoria->id}}" {{$categoria->id == $producto->categoria_id ? 'selected' : ''}}>
                                                                {{$categoria->nombre}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Nombre del Producto -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nombre">Nombre del producto</label>
                                                    <input type="text" class="form-control" name="nombre" value="{{$producto->nombre}}" required>
                                                    @error('nombre')
                                                        <small style="color: red;">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer del modal -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- FIN DEL MODAL -->

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('css')
@endsection

@section('js')
@endsection
