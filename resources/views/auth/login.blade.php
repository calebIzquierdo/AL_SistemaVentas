<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - DB System</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

  <!-- Header -->
  <header>
    <div class="logo">
      <img src="/imagenes/logo.png" alt="Logo" />
      <span>Confecciones</span>
    </div>
    <nav>
      <a href="#">Inicio</a>
      <a href="#">Categorías</a>
      <a href="#">Servicios</a>
      <a href="#">Nosotros</a>
      <a href="#">Contáctanos</a>
      <a href="#">Login</a>
    </nav>
    <div class="search-box">🔍 Buscar</div>
  </header>

  <!-- Main -->
  <div class="main-content">
    <h1>Bienvenido de nuevo!</h1>
    <p>Por favor ingresa tus credenciales para acceder al sistema.</p>

   <form>
  <input type="email" placeholder="Correo">
  <input type="password" placeholder="Contraseña">

  <div class="form-buttons">
  <button type="submit">Iniciar sesión</button>
  <button type="button" onclick="window.location.href='{{ route('register') }}'">Registrarse</button>
</div>

</form>

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

  <!-- Validación simple -->
  <script>
    document.querySelector("form").addEventListener("submit", function (e) {
      const inputs = this.querySelectorAll("input");
      let valid = true;

      inputs.forEach(input => {
        if (!input.value.trim()) {
          valid = false;
          input.style.boxShadow = "0 0 5px red";
        } else {
          input.style.boxShadow = "0 4px 10px rgba(0,0,0,0.1)";
        }
      });

      if (!valid) {
        e.preventDefault();
        alert("Por favor completa todos los campos.");
      }
    });
  </script>

</body>
</html>
