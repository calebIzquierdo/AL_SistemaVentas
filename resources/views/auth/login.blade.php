@extends('layouts.vista')

@section('title', 'Iniciar Sesión')

@section('content')
  <h1>Bienvenido de nuevo!</h1>
  <p>Por favor ingresa tus credenciales para acceder al sistema.</p>

  @if(session('error'))
    <div class="alert alert-danger" style="color:red;">{{ session('error') }}</div>
  @endif

  <form method="POST" action="{{ route('login.post') }}">
    @csrf
    <input type="email" name="correo" value="{{ old('correo') }}" placeholder="Correo" required>
    @error('correo') <small style="color:red;">{{ $message }}</small> @enderror

    <input type="password" name="contrasena" placeholder="Contraseña" required>
    @error('contrasena') <small style="color:red;">{{ $message }}</small> @enderror

    <div class="form-buttons">
      <button type="submit">Iniciar sesión</button>
      <button type="button" onclick="window.location.href='{{ route('register') }}'">Registrarse</button>
    </div>
  </form>
@endsection

@section('scripts')
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
@endsection
