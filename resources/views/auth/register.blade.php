@extends('layouts.vista')

@section('title', 'Registro de Usuario')

@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
        <div class="card-header text-center bg-primary text-white">
            <h4>¡Regístrate !</h4>
        </div>
        <div class="card-body">
            <form id="form-registro" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresa tu nombre completo" required>
                </div>

                <div class="form-group mb-3">
                    <label for="correo" class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingresa tu correo" required>
                </div>

                <div class="form-group mb-3">
                    <label for="celular" class="form-label">Número de celular</label>
                    <input type="text" name="celular" id="celular" class="form-control" placeholder="Ingresa tu celular">
                </div>

                <div class="form-group mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ingresa tu dirección">
                </div>

                <div class="form-group mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>
                </div>

                <input type="hidden" name="estado" value="1">
                <input type="hidden" name="id_tipo_usuario" value="2">

                <!-- Botones para enviar o cancelar el registro -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success w-48">Registrar</button>
                    <a href="" class="btn btn-outline-secondary w-48">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
