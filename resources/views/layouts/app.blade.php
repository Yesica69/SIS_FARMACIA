<!DOCTYPE html>
<html lang="es"> <!-- Idioma principal español -->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Dashboard')</title>

<!-- Asegúrate de tener estas dependencias en tu head -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



  <!-- Preload de recursos críticos -->
  <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" as="style">
  <link rel="preload" href="https://code.jquery.com/jquery-3.6.0.min.js" as="script">
  <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" as="script">

  <!-- Fuentes y estilos -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap y librerías externas -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

  <!-- CSS local -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet">
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/img/favicon.png">
</head>

<body class="{{ $class ?? '' }}">

  @guest
    @yield('content')
  @endguest

  @auth
    @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register', 'recover-password', 'rtl', 'virtual-reality']))
      @yield('content')
    @else
      @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
        <div class="min-height-300 bg-primary position-absolute w-100"></div>
      @else
        <div class="position-absolute w-100 min-height-300 top-0"
             style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
          <span class="mask bg-primary opacity-6"></span>
        </div>
      @endif

      @include('layouts.navbars.auth.sidenav')
      <main class="main-content border-radius-lg">
        @yield('content')
      </main>
      @include('components.fixed-plugin')
    @endif
  @endauth

  <!-- Scripts JS principales -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Scripts locales -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>

  <!-- Scrollbar -->
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
  </script>

  <!-- Argon Dashboard JS -->
  <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>

  <!-- Scripts personalizados -->
  @yield('js')
  @stack('js')
</body>
</html>
