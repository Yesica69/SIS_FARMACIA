@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <section class="min-vh-100" style="
    background: linear-gradient(to bottom, #ff8c00, #ff6b00, #ccca70ff);
    display: flex;
    align-items: center;
    ">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
           

            <div class="card border-0" style=" 
                background-color: rgba(95, 87, 87, 0.5);
                backdrop-filter: blur(10px);
                border-radius: 15px;
                box-shadow: 0 10px 25px rgba(95, 87, 87, 0.5);
            ">
                <!-- Encabezado con logo transparente -->
                <div class="card-header bg-transparent text-center pt-4 pb-3">
                    <div class="d-flex justify-content-center mb-3">
                        <div style="
                            width: 120px;
                            height: 120px;
                            background: rgba(255, 126, 0, 0.2);
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border: 2px solid rgba(255, 255, 255, 0.3);
                            backdrop-filter: blur(5px);
                        ">
                            <img src="{{ asset('assets/img/logo3.jpeg') }}" alt="Logo" 
                                 class="img-fluid rounded-circle" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                    </div>
                    <h4 class="mb-0 text-white" style="font-weight: 600;">INGRESAR</h4>
                </div>
                
                <!-- Cuerpo del formulario transparente -->
                <div class="card-body px-5 pt-4 pb-3">
                    <form role="form" method="POST" action="{{ route('login.perform') }}">
                        @csrf
                        @method('post')
                        
                        <!-- Campo Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label text-white" style="font-weight: 500;">Correo electrónico</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="
                                     background: rgba(255, 255, 255, 0.15);
                                    border: 1px solid rgba(255, 255, 255, 0.2);
                                    color: white;
                                
                                ">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email" 
                                       class="form-control text-white" 
                                       style="
                                           background: rgba(255, 255, 255, 0.15);
                                    border: 1px solid rgba(255, 255, 255, 0.2);
                                           border-left: 0;
                                           backdrop-filter: blur(5px);
                                       "
                                       placeholder="usuario@ejemplo.com" 
                                       value="{{ old('email') ?? 'usuario@gmail.com' }}" required>
                            </div>
                            @error('email') 
                                <div class="text-white small mt-1" style="text-shadow: 0 0 3px rgba(255,0,0,0.5);">{{ $message }}</div> 
                            @enderror
                        </div>
                        
                        <!-- Campo Contraseña -->
                        <div class="mb-4">
                            <label for="password" class="form-label text-white" style="font-weight: 500;">Contraseña</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    border: 1px solid rgba(255, 255, 255, 0.2);
                                    color: white;
                                ">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" 
                                       class="form-control text-white" 
                                       style="
                                           background: rgba(255, 255, 255, 0.1);
                                           border: 1px solid rgba(255, 255, 255, 0.2);
                                           border-left: 0;
                                           backdrop-filter: blur(5px);
                                       "
                                       placeholder="Ingresa tu contraseña" 
                                       value="secret" required>
                            </div>
                            @error('password') 
                                <div class="text-white small mt-1" style="text-shadow: 0 0 3px rgba(255,0,0,0.5);">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Recordar contraseña -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                           
                            <a href="{{ route('reset-password') }}" class="small" style="
                                color: rgba(255, 255, 255, 0.8);
                                text-decoration: none;
                                transition: all 0.3s ease;
                            ">
                                ¿Olvidaste tu contraseña?
                            </a>
                        </div>
                        
                        <!-- Botón de Login -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-lg py-3" 
                                    style="
                                        background: linear-gradient(135deg, rgba(255,126,0,0.8) 0%, rgba(255,94,0,0.9) 100%);
                                        border: none;
                                        color: white;
                                        font-weight: 600;
                                        letter-spacing: 0.5px;
                                        transition: all 0.3s ease;
                                        box-shadow: 0 4px 15px rgba(255, 94, 0, 0.3);
                                    ">
                                Iniciar sesión
                            </button>
                        </div>
                        
                        <!-- Registro -->
                        <div class="text-center mt-4">
                            <p class="small text-white-50 mb-0">¿No tienes una cuenta? 
                                <a href="{{ route('register') }}" class="fw-bold" style="
                                    color: rgba(255, 255, 255, 0.9);
                                    text-decoration: none;
                                    transition: all 0.3s ease;
                                ">
                                    Regístrate aquí
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        </section>
    </main>
@endsectiona