@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0 min-vh-100" style="
        background: url('{{ asset('assets/img/fondo4.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
        ">

   
        <div class="container">
            
            
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0 border-0" style="
                        background-color: rgba(95, 87, 87, 0.5);
                        backdrop-filter: blur(10px);
                        border-radius: 15px;
                        box-shadow: 0 10px 25px rgba(95, 87, 87, 0.5);
                        margin-bottom: 2rem;
                    ">
                        <div class="card-header text-center pt-4 bg-transparent">
                            <h5 class="text-white">Regístrate en tu cuenta</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register.perform') }}">
                                @csrf
                                <div class="flex flex-col mb-3">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text" style="
                                            background: rgba(255, 255, 255, 0.15);
                                            border: 1px solid rgba(255, 255, 255, 0.2);
                                            color: white;
                                        ">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="username" class="form-control text-white" 
                                               style="
                                                   background: rgba(255, 255, 255, 0.15);
                                                   border: 1px solid rgba(255, 255, 255, 0.2);
                                                   border-left: 0;
                                                   backdrop-filter: blur(5px);
                                               "
                                               placeholder="Nombre de usuario" 
                                               aria-label="Nombre" 
                                               value="{{ old('username') }}">
                                    </div>
                                    @error('username') <p class='text-white small mt-1' style="text-shadow: 0 0 3px rgba(255,0,0,0.5);"> {{ $message }} </p> @enderror
                                </div>
                                
                                <div class="flex flex-col mb-3">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text" style="
                                            background: rgba(255, 255, 255, 0.15);
                                            border: 1px solid rgba(255, 255, 255, 0.2);
                                            color: white;
                                        ">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control text-white" 
                                               style="
                                                   background: rgba(255, 255, 255, 0.15);
                                                   border: 1px solid rgba(255, 255, 255, 0.2);
                                                   border-left: 0;
                                                   backdrop-filter: blur(5px);
                                               "
                                               placeholder="Correo electrónico" 
                                               aria-label="Correo electrónico" 
                                               value="{{ old('email') }}">
                                    </div>
                                    @error('email') <p class='text-white small mt-1' style="text-shadow: 0 0 3px rgba(255,0,0,0.5);"> {{ $message }} </p> @enderror
                                </div>
                                
                                <div class="flex flex-col mb-3">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text" style="
                                            background: rgba(255, 255, 255, 0.15);
                                            border: 1px solid rgba(255, 255, 255, 0.2);
                                            color: white;
                                        ">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control text-white" 
                                               style="
                                                   background: rgba(255, 255, 255, 0.15);
                                                   border: 1px solid rgba(255, 255, 255, 0.2);
                                                   border-left: 0;
                                                   backdrop-filter: blur(5px);
                                               "
                                               placeholder="Contraseña" 
                                               aria-label="Contraseña">
                                    </div>
                                    @error('password') <p class='text-white small mt-1' style="text-shadow: 0 0 3px rgba(255,0,0,0.5);"> {{ $message }} </p> @enderror
                                </div>
                                
                               
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg w-100 my-4 mb-2 py-3" style="
                                        background: linear-gradient(135deg, rgba(255,126,0,0.8) 0%, rgba(255,94,0,0.9) 100%);
                                        border: none;
                                        color: white;
                                        font-weight: 600;
                                        letter-spacing: 0.5px;
                                        transition: all 0.3s ease;
                                        box-shadow: 0 4px 15px rgba(255, 94, 0, 0.3);
                                    ">
                                        Registrarse
                                    </button>
                                </div>
                                
                                <p class="text-sm mt-3 mb-0 text-white-50">¿Ya tienes una cuenta? 
                                    <a href="{{ route('login') }}" class="text-white font-weight-bolder">Iniciar sesión</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection