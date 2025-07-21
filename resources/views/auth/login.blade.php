@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100 d-flex justify-content-center align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-7 mx-auto">
                            <div class="card shadow-lg rounded-lg border-0">
                                <div class="card-header text-start">
                                    <h4 class="font-weight-bolder text-dark">Iniciar sesión</h4>
                                    <p class="text-muted mb-0">Ingresa tus datos para acceder a tu cuenta</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login.perform') }}">
                                        @csrf
                                        @method('post')
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input type="email" name="email" id="email" class="form-control form-control-lg" value="{{ old('email') ?? 'usuario@gmail.com' }}" aria-label="Email" required>
                                            @error('email') 
                                                <div class="text-danger text-sm pt-1">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" name="password" id="password" class="form-control form-control-lg" aria-label="Password" value="secret" required>
                                            @error('password') 
                                                <div class="text-danger text-sm pt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" name="remember" type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Recordarme</label>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-lg">Iniciar sesión</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <p class="text-sm mb-0">
                                        ¿Olvidaste tu contraseña? <a href="{{ route('reset-password') }}" class="text-primary font-weight-bold">Restablecer contraseña</a>
                                    </p>
                                    <p class="text-sm mb-0">
                                        ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-primary font-weight-bold">Registrarse</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
