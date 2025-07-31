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
            background: url('{{ asset('assets/img/fondo4.jpg') }}') no-repeat center center fixed;
            background-size: cover;
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
                        <!-- Encabezado -->
                        <div class="card-header bg-transparent text-center pt-4 pb-3">
                            <h4 class="mb-0 text-white" style="font-weight: 600;">Restablecer contraseña</h4>
                            <p class="text-white-50 mb-0">Ingresa tu correo y espera unos segundos</p>
                        </div>
                        
                        <!-- Cuerpo del formulario -->
                        <div class="card-body px-5 pt-4 pb-3">
                            <form role="form" method="POST" action="{{ route('reset.perform') }}">
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
                                               placeholder="Correo" 
                                               value="{{ old('email') }}" required>
                                    </div>
                                    @error('email') 
                                        <div class="text-white small mt-1" style="text-shadow: 0 0 3px rgba(255,0,0,0.5);">{{ $message }}</div> 
                                    @enderror
                                </div>
                                
                                <!-- Botón de Envío -->
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
                                        Enviar enlace
                                    </button>
                                </div>
                                
                                <!-- Alerta -->
                                <div id="alert">
                                    @include('components.alert')
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection