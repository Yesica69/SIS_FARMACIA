@extends('layouts.app', ['title' => 'Productos'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Productos'])
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="mb-0"><b>Caja / Registro de una nueva caja</b></h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Formulario para crear un usuario -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="card-title mb-0">Ingrese los datos</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="ni ni-minus- text-dark"></i>
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
                                    <label for="fecha_apertura" class="form-control-label">Fecha de apertura</label>
                                    <input type="datetime-local" class="form-control" value="{{ old('fecha_apertura') }}" name="fecha_apertura" required >
                                    
                                    @error('fecha_apertura')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>                   
                            <!-- Campo Correo -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="monto_inicial" class="form-control-label">Monto inicial</label>
                                    <input type="monto_inicial" class="form-control" value="{{ old('monto_inicial') }}" name="monto_inicial" >
                                    
                                    @error('monto_inicial')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- Campo CONTRASEÑA -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="descripcion" class="form-control-label">Descripcion</label>
                                    <input type="descripcion" class="form-control" name="descripcion" required autocomplete="new-descripcion">
                                    
                                    @error('descripcion')
                                        <small class="text-danger">{{$message}}</small>
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
</div>
@endsection

@section('css')
    
@endsection

@section('js')
    
@endsection