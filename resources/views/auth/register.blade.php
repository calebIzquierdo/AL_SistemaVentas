@extends('layouts.vista')

@section('title', 'Registro de Usuario')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
        <div class="card-header text-center bg-primary text-white">
            <h4>¡Regístrate!</h4>
        </div>
        <div class="card-body">
            <form id="form-registro" method="POST" action="{{ route('registro.store') }}">
                @csrf

                <!-- Nombre -->
                <div class="form-group mb-3">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    <div id="nombre-feedback" class="invalid-feedback">Este campo es obligatorio.</div>
                </div>

                <!-- Correo -->
                <div class="form-group mb-3">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}" required>
                    @error('correo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div id="correo-feedback" class="invalid-feedback d-none">Ingresa un correo válido (ej. nombre@dominio.com).</div>
                </div>

                <!-- Celular -->
                <div class="form-group mb-3">
                    <label for="celular">Número de celular</label>
                    <input type="text" name="celular" id="celular" class="form-control @error('celular') is-invalid @enderror" value="{{ old('celular') }}" required>
                    @error('celular') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div id="celular-feedback" class="invalid-feedback d-none">Debe comenzar con 9 y tener 9 dígitos.</div>
                </div>

                <!-- Dirección -->
                <div class="form-group mb-3">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
                </div>

                <!-- Contraseña -->
                <div class="form-group mb-3">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" class="form-control @error('contrasena') is-invalid @enderror" required>
                    @error('contrasena') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div id="contrasena-feedback" class="invalid-feedback d-none">
                        La contraseña debe tener al menos una mayúscula, un número, un carácter especial y mínimo 7 caracteres.
                    </div>
                </div>

                <input type="hidden" name="estado" value="1">
                <input type="hidden" name="id_tipo_usuario" value="2">

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Estilos de validación -->
<style>
    .is-valid {
        border-color: #28a745 !important;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>

<!-- Validaciones en vivo -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const correo = document.getElementById('correo');
        const celular = document.getElementById('celular');
        const contrasena = document.getElementById('contrasena');

        // Regex
        const correoRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/i;
        const celularRegex = /^9\d{8}$/;
        const contrasenaRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{7,}$/;

        function validarCampo(input, regex, feedbackId) {
            const feedback = document.getElementById(feedbackId);
            if (regex.test(input.value)) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                feedback.classList.add('d-none');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                feedback.classList.remove('d-none');
            }
        }

        correo.addEventListener('input', function () {
            validarCampo(correo, correoRegex, 'correo-feedback');
        });

        celular.addEventListener('input', function () {
            validarCampo(celular, celularRegex, 'celular-feedback');
        });

        contrasena.addEventListener('input', function () {
            validarCampo(contrasena, contrasenaRegex, 'contrasena-feedback');
        });
    });
</script>
@endsection
