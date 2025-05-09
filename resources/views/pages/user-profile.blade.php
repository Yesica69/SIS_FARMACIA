@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Perfil de Usuario'])
    
    <!-- Tarjeta de perfil mejorada -->
    <div class="container-fluid py-4">
        <div id="alert">
            @include('components.alert')
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-12">
                <!-- Card de información del perfil -->
                <div class="card shadow-lg mb-4">
                    <div class="card-header bg-gradient-primary text-white position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Mi Perfil</h5>
                            <button type="submit" form="profileForm" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-center pt-4 pb-2">
                        <div class="avatar-upload mb-3">
                            <div class="avatar-preview position-relative mx-auto">
                                @if(auth()->user()->imagen)
                                    <img src="{{ asset('storage/'.auth()->user()->imagen) }}" 
                                         class="rounded-circle shadow" 
                                         width="150" height="150"
                                         id="imagePreview">
                                @else
                                    <div class="bg-gradient-light rounded-circle shadow d-flex align-items-center justify-content-center" 
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                <label for="imageUpload" class="avatar-edit-btn">
                                    <i class="fas fa-camera text-white"></i>
                                    <input type="file" id="imageUpload" name="imagen" accept="image/*" 
                                           class="d-none" form="profileForm">
                                </label>
                            </div>
                        </div>
                        
                        <h4 class="mb-1">{{ auth()->user()->firstname ?? 'Nombre' }} {{ auth()->user()->lastname ?? 'Apellido' }}</h4>
                        <p class="text-muted mb-2">{{ auth()->user()->email }}</p>
                        
                        @if(auth()->user()->sucursal)
                        <div class="d-flex justify-content-center mb-3">
                            <span class="badge bg-gradient-info px-3 py-2">
                                <i class="fas fa-store me-1"></i>
                                {{ auth()->user()->sucursal->firstname ?? 'Sin sucursal' }}
                            </span>
                        </div>
                        @endif
                        
                        
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-12">
                <!-- Formulario de edición -->
                <div class="card shadow-lg">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">Información Personal</h5>
                    </div>
                    <div class="card-body">
                        <form id="profileForm" role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Sección de información básica -->
                            <div class="mb-4">
                                <h6 class="text-uppercase text-sm text-muted mb-3">
                                    <i class="fas fa-id-card me-2"></i>Datos Personales
                                </h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Usuario</label>
                                        <div class="input-group input-group-outline">
                                            <input class="form-control" type="text" name="username" 
                                                   value="{{ old('username', auth()->user()->username) }}"
                                                   placeholder="Nombre de usuario">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Correo electrónico</label>
                                        <div class="input-group input-group-outline">
                                            <input class="form-control" type="email" name="email" 
                                                   value="{{ old('email', auth()->user()->email) }}"
                                                   placeholder="Correo electrónico">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <div class="input-group input-group-outline">
                                            <input class="form-control" type="text" name="firstname"  
                                                   value="{{ old('firstname', auth()->user()->firstname) }}"
                                                   placeholder="Nombre">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido</label>
                                        <div class="input-group input-group-outline">
                                            <input class="form-control" type="text" name="lastname" 
                                                   value="{{ old('lastname', auth()->user()->lastname) }}"
                                                   placeholder="Apellido">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="horizontal dark my-4">

                            <!-- Información de contacto -->
                            <div class="mb-4">
                                <h6 class="text-uppercase text-sm text-muted mb-3">
                                    <i class="fas fa-address-book me-2"></i>Información de Contacto
                                </h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Dirección</label>
                                        <div class="input-group input-group-outline">
                                            <input class="form-control" type="text" name="direccion"
                                                   value="{{ old('direccion', auth()->user()->direccion) }}"
                                                   placeholder="Dirección completa">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Celular</label>
                                        <div class="input-group input-group-outline">
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
        </div>
    </div>
@endsection

@push('css')
<style>
    .avatar-upload {
        position: relative;
        max-width: 150px;
        margin: 0 auto;
    }
    .avatar-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
    }
    .avatar-edit-btn {
        position: absolute;
        right: 10px;
        bottom: 10px;
        width: 36px;
        height: 36px;
        background: #5e72e4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .avatar-edit-btn:hover {
        background: #4a5acf;
    }
    .input-group-outline {
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }
    .input-group-outline:focus-within {
        box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vista previa de la imagen
    const imageUpload = document.getElementById('imageUpload');
    if (imageUpload) {
        imageUpload.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        const avatarPreview = document.querySelector('.avatar-preview');
                        avatarPreview.innerHTML = `<img src="${e.target.result}" class="rounded-circle shadow" width="150" height="150" id="imagePreview">`;
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Validación del formulario
    const form = document.getElementById('profileForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = form.querySelector('input[name="password"]').value;
            const passwordConfirm = form.querySelector('input[name="password_confirmation"]').value;
            
            if (password && password !== passwordConfirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    }
});
</script>
@endpush