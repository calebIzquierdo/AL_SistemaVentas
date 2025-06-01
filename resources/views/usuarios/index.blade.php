@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">USUARIOS</h4>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCrear">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>

            <table class="table table-striped" id="tabla-usuarios" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Dirección</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Dirección</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- MODAL CREAR -->
<div class="modal fade" id="modalCrear" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-crear" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre completo" required>
                <input type="email" name="correo" class="form-control mb-2" placeholder="Correo" required>
                <input type="text" name="celular" class="form-control mb-2" placeholder="Celular">
                <input type="text" name="direccion" class="form-control mb-2" placeholder="Dirección">
                <input type="password" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required>

                <select name="id_tipo_usuario" class="form-select" required>
                    <option value="">Seleccione tipo de usuario</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id_tipo_usuario }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-editar" class="modal-content">
            @csrf
            <input type="hidden" name="id_usuario">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre completo" required>
                <input type="email" name="correo" class="form-control mb-2" placeholder="Correo" required>
                <input type="text" name="celular" class="form-control mb-2" placeholder="Celular">
                <input type="text" name="direccion" class="form-control mb-2" placeholder="Dirección">

                <select name="id_tipo_usuario" class="form-select" required>
                    <option value="">Seleccione tipo de usuario</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id_tipo_usuario }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const routes = {
        store: "{{ route('usuarios.store') }}",
        update: id => `/usuarios/${id}`,
        delete: id => `/usuarios/${id}`,
        listar: "{{ route('usuarios.ajax.listar') }}"
    };
</script>
@vite(['resources/js/usuarios.js', 'resources/css/styles.css'])
@endsection
