@extends('adminlte::page')
@section('content_header')
    <h1><b>Caja / Registro de una nueva caja</b></h1>
@endsection
@section('content')
<div class="row">
    <!-- Formulario para crear un usuario -->
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{url('/admin/cajas/create')}}" method="post">
                    @csrf
                    <div class="row">
                        
                        <!-- Campo Nombre del Usuario -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_apertura">Fecha de apertura</label>
                                <input type="datetime-local" class="form-control" value="{{ old('fecha_apertura') }}" name="fecha_apertura" required >
                                
                                @error('fecha_apertura')
                                <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>                   
                        <!-- Campo Correo -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="monto_inicial">Monto inicial</label>
                                <input type="monto_inicial" class="form-control" value="{{ old('monto_inicial') }}" name="monto_inicial" >
                                
                                @error('monto_inicial')
                                <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <!-- Campo CONTRASEÑA -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <input type="descripcion" class="form-control" name="descripcion" required autocomplete="new-descripcion">
                                
                                @error('descripcion')
                                    
                                    <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                         
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('/admin/cajas')}}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary" style="margin-left: 20px;">
                                <i class="fas fa-save"></i> Registrar
                            </button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
