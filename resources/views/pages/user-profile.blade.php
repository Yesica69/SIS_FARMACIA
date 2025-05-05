@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Perfil'])
    
    <!-- Tarjeta de perfil con imagen -->
    <div class="card shadow-lg mx-4 mt-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar avatar-xxl position-relative">
                        @if(auth()->user()->imagen)
                            <img src="{{ asset('storage/'.auth()->user()->imagen) }}" class="rounded-circle" width="100" height="120">
                            @else
                                            <div class="bg-light rounded-circle" style="width: 100px; height: 1000px;"></div>
                                        @endif
                       
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex flex-column">
                        <h4 class="mb-1">
                            {{ auth()->user()->firstname ?? 'Nombre' }} {{ auth()->user()->lastname ?? 'Apellido' }}
                        </h4>
                        <div class="d-flex align-items-center">
                            
                            @if(auth()->user()->sucursal)
                            <span class="badge bg-gradient-info">
                                <i class="fas fa-store me-1"></i>
                                {{ auth()->user()->sucursal->firstname ?? 'Sin sucursal' }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div id="alert">
        @include('components.alert')
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0 bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Editar Perfil</h5>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Sección para subir imagen -->
                            <div class="mb-4">
                                <h6 class="text-uppercase text-sm text-muted mb-3">Imagen de Perfil</h6>
                                <div class="d-flex align-items-center">
                                    
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control" name="imagen" accept="image/*">
                                        <small class="text-muted">Formatos aceptados: JPEG, PNG, JPG. Máximo 2MB.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Información del username -->
                            <div class="mb-4">
                                <h6 class="text-uppercase text-sm text-muted mb-3">Información Personal</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Usuario</label>
                                        <input class="form-control" type="text" name="username" 
                                               value="{{ old('username', auth()->user()->username) }}"
                                               placeholder="Nombre de username">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Correo electrónico</label>
                                        <input class="form-control" type="email" name="email" 
                                               value="{{ old('email', auth()->user()->email) }}"
                                               placeholder="Correo electrónico">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input class="form-control" type="text" name="firstname"  
                                               value="{{ old('firstname', auth()->user()->firstname) }}"
                                               placeholder="Nombre">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido</label>
                                        <input class="form-control" type="text" name="lastname" 
                                               value="{{ old('lastname', auth()->user()->lastname) }}"
                                               placeholder="Apellido">
                                    </div>
                                </div>
                            </div>

                            <hr class="horizontal dark my-4">

                            <!-- Información de contacto -->
                            <div class="mb-4">
                                <h6 class="text-uppercase text-sm text-muted mb-3">Información de Contacto</h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Dirección</label>
                                        <input class="form-control" type="text" name="direccion"
                                               value="{{ old('direccion', auth()->user()->direccion) }}"
                                               placeholder="Dirección completa">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Celular</label>
                                        <input class="form-control" type="text" name="celular" 
                                               value="{{ old('celular', auth()->user()->celular) }}"
                                               placeholder="Número de celular">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection