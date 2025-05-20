<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil de Usuario - DB System</title>
  <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="/logo.png" alt="Logo" />
      <span>DB System</span>
    </div>
    <nav>
      <a href="#">Inicio</a>
      <a href="#">Categorías</a>
      <a href="#">Servicios</a>
      <a href="#">Nosotros</a>
      <a href="#">Perfil</a>
      <a href="{{ route('logout') }}">Cerrar sesión</a>
    </nav>
    <div class="search-box">🔍 Buscar</div>
  </header>

  <!-- Contenido -->
  <div class="main-content">
    <h1>Mi Perfil</h1>
    <p>Aquí puedes revisar y actualizar tu información.</p>
@auth
<form action="{{ route('perfil.actualizar') }}" method="POST">
  @csrf
  @method('PUT')

  <input type="text" name="nombre" value="{{ old('nombre', Auth::user()->nombre) }}" placeholder="Nombre y Apellido">
  <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Correo">
  <input type="text" name="telefono" value="{{ old('telefono', Auth::user()->telefono) }}" placeholder="Número de celular">
  <input type="text" name="direccion" value="{{ old('direccion', Auth::user()->direccion) }}" placeholder="Dirección">

  <div class="form-buttons">
    <button type="submit">Guardar Cambios</button>
    <button type="button" onclick="window.location.href='{{ url('/') }}'">Cancelar</button>
  </div>
</form>
@endauth

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
<p>
  <a href="https://www.facebook.com/" target="_blank">
    <i class="fab fa-facebook-f"></i> Facebook
  </a>
</p>
<p>
  <a href="https://www.instagram.com/" target="_blank">
    <i class="fab fa-instagram"></i> Instagram
  </a>
</p>
<p>
  <a href="https://wa.me/51999999999" target="_blank">
    <i class="fab fa-whatsapp"></i> WhatsApp
  </a>
</p>
    </div>
  </footer>

</body>
</html>
