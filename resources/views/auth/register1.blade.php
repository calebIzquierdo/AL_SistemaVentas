<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro - DB System</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>


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
      <a href="#">Contáctanos</a>
      <a href="#">Login</a>
    </nav>
    <div class="search-box">🔍 Buscar</div>
  </header>

  <!-- Main -->
  <div class="main-content">
    <h1>Bienvenido a tu registro!</h1>
    <p>Deberás completar estos campos para poder registrado y continuar con tu compra.!</p>
    <form>
      <!-- Campo select para documento -->
      <select class="select-doc">
        <option value="" disabled selected>Documento</option>
        <option value="dni">DNI</option>
        <option value="carnet">Carnet de extranjería</option>
        <option value="pasaporte">Pasaporte</option>
        <option value="otro">Otro</option>
      </select>

      <input type="text" placeholder="Número">
      <input type="text" placeholder="Nombre y Apellido">
      <input type="email" placeholder="Correo">
      <input type="text" placeholder="Número de celular">
      <input type="text" placeholder="Dirección">
      <input type="password" placeholder="Contraseña">

      <div class="form-buttons">
        <button type="submit">Registrar</button>
        <button type="button">Cancelar</button>
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

</body>
</html>
