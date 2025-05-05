extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content_header')
    <h1><b>Editar Rol</b></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Rol</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nombre del Rol</label>
                            <select name="role" id="" class="form-control" >
                             <option value="">Seleccionar un Rol</option>
                            @foreach($roles as $role)
                             <option value="{{$role->name }}" {{$role->name  == $usuario->roles->pluck('name')->implode(', ') ? 'selected':''}}>{{$role->name}}</option>
                           @endforeach
                             </select>                           
                          
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop














