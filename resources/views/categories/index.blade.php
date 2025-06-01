@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">CATEGORÍAS</h4>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCrear">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>

            <table class="table table-striped" id="tabla-categorias" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center"> #</th>
                        <th >Acciones</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody></tbody>
                 <tfoot>
                                <tr>
                                  <th class="text-center" >#</th>
                                  <th>Acciones</th>
                                  <th>Nombre</th>
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
                <h5 class="modal-title">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre de categoría" required>
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
            <input type="hidden" name="id_categoria">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="nombre" class="form-control" placeholder="Nuevo nombre" required>
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
    store: "{{ route('categorias.store') }}",
    update: id => `/categorias/${id}`,
    delete: id => `/categorias/${id}`,
    listar: "{{ route('categorias.ajax.listar') }}"
};
</script>
@vite(['resources/js/categorias.js', 'resources/css/styles.css'])
@endsection
