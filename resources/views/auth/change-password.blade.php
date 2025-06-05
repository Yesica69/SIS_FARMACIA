@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Menú Lateral -->
        @include('layouts.navbars.auth.sidenav')
        
        <!-- Contenido principal -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3 bg-gray-soft">
            <!-- Barra superior de navegación -->
            @include('layouts.navbars.auth.topnav', ['title' => 'Cambiar Contraseña'])
            
            <div class="container-fluid py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-11">
                        <div class="card shadow-lg border-0 rounded-3">
                            <!-- Cabecera de tarjeta con gradiente -->
                            <div class="card-header bg-gradient-primary py-3 border-0 rounded-top-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-white">
                                        <i class="fas fa-key me-2"></i>
                                        <strong>Actualización de Contraseña</strong>
                                    </h5>
                                    <button type="button" class="btn btn-light btn-sm shadow-sm" onclick="document.getElementById('passwordForm').submit()">
                                        <i class="fas fa-save me-1"></i> Guardar Cambios
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Cuerpo de la tarjeta -->
                            <div class="card-body p-4">
                                <form id="passwordForm" role="form" method="POST" action="{{ route('change.perform') }}">
                                    @csrf
                                    
                                    <div class="row g-4">
                                        <!-- Columna izquierda -->
                                        <div class="col-md-6">
                                            <!-- Email -->
                                            <div class="form-group">
                                                <label class="form-label text-dark fw-bold">Correo Electrónico</label>
                                                <div class="input-group input-group-glass">
                                                    <span class="input-group-text bg-transparent">
                                                        <i class="fas fa-envelope text-primary"></i>
                                                    </span>
                                                    <input type="email" name="email" class="form-control ps-2" 
                                                        value="{{ optional(auth()->user())->email ?? '' }}" 
                                                        readonly>
                                                </div>
                                                
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            
                                            <!-- Contraseña Actual -->
                                            <div class="form-group mt-4">
                                                <label class="form-label text-dark fw-bold">Contraseña Actual</label>
                                                <div class="input-group input-group-glass">
                                                    <span class="input-group-text bg-transparent">
                                                        <i class="fas fa-lock text-primary"></i>
                                                    </span>
                                                    <input type="password" name="current_password" class="form-control ps-2" required>
                                                    <button class="btn btn-link text-primary toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('current_password')
                                                    <div class="text-danger small mt-2">
                                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Columna derecha -->
                                        <div class="col-md-6">
                                            <!-- Nueva Contraseña -->
                                            <div class="form-group">
                                                <label class="form-label text-dark fw-bold">Nueva Contraseña</label>
                                                <div class="input-group input-group-glass">
                                                    <span class="input-group-text bg-transparent">
                                                        <i class="fas fa-lock text-primary"></i>
                                                    </span>
                                                    <input type="password" name="password" class="form-control ps-2" required>
                                                    <button class="btn btn-link text-primary toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="text-danger small mt-2">
                                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            
                                            <!-- Confirmar Contraseña -->
                                            <div class="form-group mt-4">
                                                <label class="form-label text-dark fw-bold">Confirmar Contraseña</label>
                                                <div class="input-group input-group-glass">
                                                    <span class="input-group-text bg-transparent">
                                                        <i class="fas fa-lock text-primary"></i>
                                                    </span>
                                                    <input type="password" name="confirm-password" class="form-control ps-2" required>
                                                    <button class="btn btn-link text-primary toggle-password" type="button">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Indicador de fortaleza de contraseña -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="password-strength-meter">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">Seguridad de la contraseña</small>
                                                    <small id="password-strength-text" class="fw-bold">-</small>
                                                </div>
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar" id="password-strength-bar" role="progressbar" style="width: 0%"></div>
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
        </main>
    </div>
</div>
@endsection

@push('css')
<style>
    .bg-gray-soft {
        background-color: #f8fafc;
        min-height: 100vh;
    }
    
    .card {
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .card-header.bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .input-group-glass {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .input-group-glass:focus-within {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
    
    .input-group-text {
        border: none;
        background: transparent;
    }
    
    .toggle-password {
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .toggle-password:hover {
        transform: scale(1.1);
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 3px;
    }
    
    .progress-bar {
        transition: width 0.5s ease, background-color 0.5s ease;
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar contraseña
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
    
    // Indicador de fortaleza de contraseña
    const passwordInput = document.querySelector('input[name="password"]');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const password = this.value;
            let strength = 0;
            
            // Validar longitud
            if (password.length > 0) strength += 1;
            if (password.length >= 8) strength += 1;
            
            // Validar caracteres especiales
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Actualizar UI
            const width = (strength / 5) * 100;
            strengthBar.style.width = width + '%';
            
            if (strength <= 1) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Débil';
                strengthText.className = 'fw-bold text-danger';
            } else if (strength <= 3) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Moderada';
                strengthText.className = 'fw-bold text-warning';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Fuerte';
                strengthText.className = 'fw-bold text-success';
            }
        });
    }
});
</script>
@endpush