@extends('layouts.app', ['title' => 'Sucursales'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sucursales'])
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>
                        <i class="ni ni-lock-circle-open text-primary me-2"></i>
                        <strong>Actualización de Contra</strong>
                    </h6>
                    <button type="button" class="btn btn-sm btn-primary mb-0" onclick="document.getElementById('passwordForm').submit()">
                        <i class="ni ni-check-bold me-1"></i> Guardar
                    </button>
                </div>
                
                <div class="card-body px-4 pt-0 pb-2">
                    <form id="passwordForm" role="form" method="POST" action="{{ route('change.perform') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        <input type="email" name="email" class="form-control" 
                                               value="{{ old('email', auth()->user()->email ?? '') }}" 
                                               readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-control-label">Contraseña Actual</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        <input type="password" name="current_password" class="form-control" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        <input type="password" name="password" class="form-control" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-control-label">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        <input type="password" name="confirm-password" class="form-control" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
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

@push('js')
<script>
    // Función para mostrar/ocultar contraseña
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
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
</script>
@endpush