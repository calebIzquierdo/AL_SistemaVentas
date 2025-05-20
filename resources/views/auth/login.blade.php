@extends('layouts.app')

@section('content')
<div class="col-md-6 mx-auto">
    <h3 class="mb-4">Iniciar Sesión</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        <a href="{{ route('password.request') }}" class="btn btn-link">¿Olvidaste tu contraseña?</a>
    </form>
</div>
@endsection
