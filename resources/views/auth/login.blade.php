@extends('layouts.vista')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="container">
        <h1>Bienvenido de nuevo!</h1>
        <p>Por favor ingresa tus credenciales para acceder al sistema.</p>

        <!-- Formulario de login -->
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="Correo" required>
            <div id="correoError"></div>

            <div class="password-container">
                <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>
                <i id="togglePassword" class="fas fa-eye"></i>
            </div>
            <div id="contrasenaError"></div>

            <div class="form-buttons mt-3">
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                <a href="{{ route('registro.form') }}" class="btn btn-secondary">Registrarse</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Verificar si hay un mensaje de registro exitoso en sessionStorage
            if (sessionStorage.getItem('registroExitoso')) {
                // Mostrar la alerta de éxito con SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: sessionStorage.getItem('registroExitoso'),
                    showConfirmButton: false,
                    timer: 2000 // Mostrar la alerta por 2 segundos
                });

                // Limpiar el mensaje de sessionStorage después de mostrarlo
                sessionStorage.removeItem('registroExitoso');
            }
        });
    </script>
@endsection
