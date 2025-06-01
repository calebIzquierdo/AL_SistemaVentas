<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Login - DB System')</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="{{ asset('images/logo.png') }}" alt="Logo" />
      <span>DB System</span>
    </div>
    <nav>
      <a href="{{ route('inicio.index') }}">Inicio</a>
      <a href="#">Categorías</a>
      <a href="#">Servicios</a>
      <a href="#">Nosotros</a>
      <a href="#">Contáctanos</a>
      <a href="{{ route('login') }}">Login</a>
    </nav>
    <div class="search-box">🔍 Buscar</div>
  </header>

  <!-- Main -->
  <div class="main-content">
    @yield('content')
  </div>

  <!-- Footer -->
  <footer>
    <div>
      <h4>CONTACTANOS</h4>
      <p>📞 12356789</p>
      <p>📧 gfg@gmail.com</p>
      <p>📍 Chiclayo</p>
    </div>
    <div>
      <h4>SERVICIOS</h4>
      <p>Confección</p>
      <p>Personalizados/Bordados</p>
    </div>
    <div>
      <h4>NOSOTROS</h4>
      <p>📘 Historia</p>
      <p>🎯 Misión / Visión</p>
      <p>🗺️ Mapa del sitio</p>
    </div>
    <div>
      <h4>SÍGUENOS</h4>
      <p><a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></p>
      <p><a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></p>
      <p><a href="https://wa.me/51999999999" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></p>
    </div>
  </footer>

  @yield('scripts')
</body>
</html>
