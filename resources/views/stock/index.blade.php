@extends('layouts.app')

@section('title', 'Stock')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">STOCK</h4>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalCrear">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>

            <table class="table table-striped" id="tabla-stock" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Acciones</th>
                        <th>Producto</th>
                        <th>Fecha de inicio</th>
                        <th>Cantidad</th>
                        <th>Fecha Actualizada</th>
                        <th>Stock</th> <!-- Nueva columna para la barra de progreso -->
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Acciones</th>
                        <th>Producto</th>
                        <th>Fecha de inicio</th>
                        <th>Cantidad</th>
                        <th>Fecha Actualizada</th>
                        <th>Stock</th> <!-- Nueva columna para la barra de progreso -->
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
                <h5 class="modal-title">Nuevo Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="date" name="fecha_inicio" class="form-control mb-2" required>
                <input type="number" name="cantidad" class="form-control mb-2" placeholder="Cantidad" required>

                <!-- Asegúrate de que el name sea 'id_producto' -->
                <select name="id_producto" class="form-select" required>
                    <option value="">Seleccione producto</option>  <!-- Opción por defecto -->
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>



<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-editar" class="modal-content">
            @csrf
            <input type="hidden" name="id_stock">
            <div class="modal-header">
                <h5 class="modal-title">Editar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="date" name="fecha_inicio" class="form-control mb-2" required>
                <input type="number" name="cantidad" class="form-control mb-2" required>
                <select name="id_producto" class="form-select" disabled required>
                    <option value="">Seleccione producto</option>
                    @foreach($productos->where('estado', 1) as $producto)
                        <option value="{{ $producto->id_producto }}">{{ $producto->nombre_producto }}</option>
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
        store: "{{ route('stock.store') }}",
        update: id => `/stock/${id}`,
        delete: id => `/stock/${id}`,
        listar: "{{ route('stock.ajax.listar') }}",
        productosDisponibles: "{{ route('productosDisponibles') }}",
    };
</script>
@vite(['resources/js/stock.js', 'resources/css/styles.css'])
@endsection
