@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Perfil de Usuario'])
    
    <div class="container-fluid py-4">
        <div id="alert">
            @include('components.alert')
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-12">
                <!-- Tarjeta de perfil con diseño moderno -->
                <div class="card profile-card mb-4">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Mi Perfil</h5>
                            <button type="submit" form="profileForm" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-save me-1"></i> Guardar
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-center pt-4 pb-2">
                        <div class="profile-avatar-container mb-3">
                            <div class="avatar-wrapper position-relative mx-auto">
                            @if(auth()->user()->imagen)
                                        <img src="{{ asset('storage/'.auth()->user()->imagen) }}" 
                                             class="rounded-circle shadow-lg border border-white border-4"
                                             width="150" height="150"
                                             id="imagePreview">
                                    @else
                                    <div class="avatar-placeholder bg-gradient-light shadow-lg">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                                <label for="imageUpload" class="avatar-edit-btn">
                                    
                                    <input type="file" id="imageUpload" name="imagen" accept="image/*" 
                                           class="d-none" form="profileForm">
                                </label>
                            </div>
                        </div>
                        
                        <h3 class="profile-name mb-1">{{ auth()->user()->firstname ?? 'Nombre' }} {{ auth()->user()->lastname ?? 'Apellido' }}</h3>
                        <p class="profile-email text-muted mb-2">{{ auth()->user()->email }}</p>
                        
                        @if(auth()->user()->sucursal)
                        <div class="profile-branch mb-3">
                            <span class="badge branch-badge px-3 py-2">
                                <i class="fas fa-store me-1"></i>
                                {{ auth()->user()->sucursal->nombre ?? 'Sin sucursal' }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-12">
                <!-- Formulario con diseño moderno -->
                <div class="card profile-edit-card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-primary">Información Personal</h5>
                    </div>
                    <div class="card-body">
                        <form id="profileForm" role="form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Sección de información básica -->
                            <div class="section-container mb-4">
                                <h6 class="section-title">
                                    <i class="fas fa-id-card me-2"></i>Datos Personales
                                </h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="imagen" class="form-label">Imagen de perfil</label>
                                        <input type="file" class="form-control custom-file-input" id="imagen" name="imagen" accept=".jpg, .jpeg, .png">
                                        <div class="mt-2 text-center" id="imagePreview"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Usuario</label>
                                        <div class="input-group custom-input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input class="form-control" type="text" name="username" 
                                                   value="{{ old('username', auth()->user()->username) }}"
                                                   placeholder="Nombre de usuario">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Correo electrónico</label>
                                        <div class="input-group custom-input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input class="form-control" type="email" name="email" 
                                                   value="{{ old('email', auth()->user()->email) }}"
                                                   placeholder="Correo electrónico">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <div class="input-group custom-input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <input class="form-control" type="text" name="firstname"  
                                                   value="{{ old('firstname', auth()->user()->firstname) }}"
                                                   placeholder="Nombre">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido</label>
                                        <div class="input-group custom-input-group">
                                            <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                            <input class="form-control" type="text" name="lastname" 
                                                   value="{{ old('lastname', auth()->user()->lastname) }}"
                                                   placeholder="Apellido">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-divider"></div>

                            <!-- Información de contacto -->
                            <div class="section-container mb-4">
                                <h6 class="section-title">
                                    <i class="fas fa-address-book me-2"></i>Información de Contacto
                                </h6>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Dirección</label>
                                        <div class="input-group custom-input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input class="form-control" type="text" name="address"
                                                   value="{{ old('address', auth()->user()->address) }}"
                                                   placeholder="Dirección completa">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Celular</label>
                                        <div class="input-group custom-input-group">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
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
    /* Estilos generales para la tarjeta de perfil */
    .profile-card {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    .profile-card .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }
    
    /* Estilos para el avatar */
    .profile-avatar-container {
        position: relative;
        max-width: 150px;
        margin: 0 auto;
    }
    
    .avatar-wrapper {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
    }
    
    .profile-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 3px solid white;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        border: 3px solid white;
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
        color: white;
        border: 2px solid white;
    }
    
    .avatar-edit-btn:hover {
        background: #4a5acf;
        transform: scale(1.1);
    }
    
    /* Estilos para la información del perfil */
    .profile-name {
        font-weight: 600;
        color: #344767;
        margin-top: 1rem;
    }
    
    .profile-email {
        font-size: 0.9rem;
    }
    
    .branch-badge {
        background: linear-gradient(310deg, #17c1e8 0%, #5e72e4 100%);
        font-weight: 500;
        font-size: 0.8rem;
        border-radius: 12px;
    }
    
    /* Estilos para la tarjeta de edición */
    .profile-edit-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .profile-edit-card .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    /* Estilos para las secciones del formulario */
    .section-container {
        padding: 1rem;
        background: rgba(245, 245, 245, 0.5);
        border-radius: 10px;
    }
    
    .section-title {
        color: #5e72e4;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
        margin: 1.5rem 0;
    }
    
    /* Estilos para los inputs */
    .custom-input-group {
        border-radius: 8px;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .custom-input-group .input-group-text {
        background-color: #f8f9fa;
        border: none;
        color: #5e72e4;
    }
    
    .custom-input-group:focus-within {
        border-color: #5e72e4;
        box-shadow: 0 0 0 2px rgba(94, 114, 228, 0.2);
    }
    
    .custom-file-input {
        border-radius: 8px;
        padding: 0.5rem;
    }
    
    .custom-file-input:focus {
        border-color: #5e72e4;
        box-shadow: 0 0 0 2px rgba(94, 114, 228, 0.2);
    }
    
    /* Efecto hover para los inputs */
    .form-control:not(:focus) {
        transition: all 0.3s ease;
    }
    
    .form-control:not(:focus):hover {
        border-color: #adb5bd;
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
                        const avatarWrapper = document.querySelector('.avatar-wrapper');
                        avatarWrapper.innerHTML = `
                            <img src="${e.target.result}" class="profile-avatar shadow-lg" id="imagePreview">
                            <label for="imageUpload" class="avatar-edit-btn">
                                <i class="fas fa-camera"></i>
                                <input type="file" id="imageUpload" name="imagen" accept="image/*" 
                                       class="d-none" form="profileForm">
                            </label>
                        `;
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
            const password = form.querySelector('input[name="password"]')?.value;
            const passwordConfirm = form.querySelector('input[name="password_confirmation"]')?.value;
            
            if (password && password !== passwordConfirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    }
});
</script>
@endpush