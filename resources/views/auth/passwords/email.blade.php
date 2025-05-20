@extends('layouts.app')

@section('content')
<div class="col-md-6 mx-auto">
    <h3 class="mb-4">Recuperar Contraseña</h3>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <button type="submit" class="btn btn-warning">Enviar enlace de recuperación</button>
    </form>
</div>
@endsection
