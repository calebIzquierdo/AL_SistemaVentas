@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">PRODUCTOS</h4>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCrear">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>

            <table class="table table-striped" id="tabla-productos" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Talla</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Imagen</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Talla</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Imagen</th>
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
        <form id="form-crear" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="nombre_producto" class="form-control mb-2" placeholder="Nombre del producto" required>
                <input name="talla" class="form-control mb-2" placeholder="Talla">
                <input name="precio" type="number" step="0.01" class="form-control mb-2" placeholder="Precio" required>
                <input name="imagen" type="file" class="form-control mb-2" accept="image/*">
                <select name="id_categoria" class="form-select mb-2" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach(App\Models\Categoria::activas()->get() as $categoria)
                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
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
        <form id="form-editar" class="modal-content" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_producto">
            <div class="modal-header">
                <h5 class="modal-title">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input name="nombre_producto" class="form-control mb-2" placeholder="Nombre del producto" required>
                <input name="talla" class="form-control mb-2" placeholder="Talla">
                <input name="precio" type="number" step="0.01" class="form-control mb-2" placeholder="Precio" required>

                <div class="mb-2">
                    <label class="form-label">Imagen actual:</label><br>
                    <img id="imagen-previa" src="" alt="Imagen actual" width="80" class="mb-2">
                </div>

                <input name="imagen" type="file" class="form-control mb-2" accept="image/*">
                <select name="id_categoria" class="form-select mb-2" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach(App\Models\Categoria::activas()->get() as $categoria)
                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL VISTA IMAGEN -->
<div class="modal fade" id="modalImagen" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 text-center">
            <img id="vista-imagen" src="" alt="Vista del producto" class="img-fluid rounded">
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const routes = {
    store: "{{ route('productos.store') }}",
    update: id => `/productos/${id}`,
    delete: id => `/productos/${id}`,
    listar: "{{ route('productos.ajax.listar') }}"
};
</script>
@vite(['resources/js/productos.js', 'resources/css/styles.css'])
@endsection
