<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Login - DB System')</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  @vite(['resources/css/styles.css'])

  @if (Request::is('login'))
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  @endif

  <style>
    .bg-custom {
      background-color: #003366 !important;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-md navbar-dark bg-custom px-4">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" style="height: 60px; margin-right: 10px;">
        <span class="fw-bold">Confecciones</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavbar" aria-controls="menuNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNavbar">
        <ul class="navbar-nav ms-auto mb-2 mb-md-0 me-3">
          <li class="nav-item"><a class="nav-link text-white" href="{{ route('inicio.index') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Categorías</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Servicios</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Nosotros</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="#">Contáctanos</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
        </ul>

        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" title="Buscar">
          <i class="fas fa-search text-primary"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main class="main-content">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-custom text-white py-4 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-3 mb-4">
          <h5>CONTACTANOS</h5>
          <p>📞 12356789</p>
          <p>📧 gfg@gmail.com</p>
          <p>📍 Chiclayo</p>
        </div>
        <div class="col-12 col-md-3 mb-4">
          <h5>SERVICIOS</h5>
          <p>Confección</p>
          <p>Personalizados/Bordados</p>
        </div>
        <div class="col-12 col-md-3 mb-4">
          <h5>NOSOTROS</h5>
          <p>📘 Historia</p>
          <p>🎯 Misión / Visión</p>
          <p>🗺️ Mapa del sitio</p>
        </div>
        <div class="col-12 col-md-3 mb-4">
          <h5>SÍGUENOS</h5>
          <p><a class="text-white" href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></p>
          <p><a class="text-white" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></p>
          <p><a class="text-white" href="https://wa.me/51999999999" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('modals')
  @yield('scripts')
</body>
</html>
