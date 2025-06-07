@extends('layouts.app')

@section('content')
<div class="card" style="width: 24rem;">
  <div class="card-body">
    <h5 class="card-title">Agregar producto</h5>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class=@extends('layouts.app')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-center">Nuevos Lanzamientos</h4>

    <!-- Estilos -->
    <style>
        .scroll-horizontal {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            overflow-x: auto;
            gap: 1rem;
            padding-bottom: 1rem;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .scroll-horizontal::-webkit-scrollbar {
            display: none;
        }

        .card-horizontal {
            flex-shrink: 0;
            width: 240px;
            scroll-snap-align: start;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card-horizontal:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-horizontal img {
            height: 220px;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
        }

        .card-body h6 {
            margin-bottom: 0.25rem;
            font-weight: bold;
        }

        .card-body small {
            color: #6c757d;
        }

        .card-body .fw-bold {
            margin-top: 0.5rem;
            color: #0d6efd;
        }
    </style>

    <!-- Galería de productos -->
    <div class="scroll-horizontal">
        @foreach($productos as $producto)
        <div class="card card-horizontal"
             data-bs-toggle="modal"
             data-bs-target="#modalDetalleProducto"
             onclick="mostrarDetalle(
                '{{ asset('storage/' . $producto->imagen) }}',
                '{{ $producto->nombre_producto }}',
                '{{ $producto->categoria->nombre ?? 'Sin categoría' }}',
                '{{ $producto->talla }}',
                '{{ number_format($producto->precio, 2) }}'
             )">
            <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-100" alt="{{ $producto->nombre_producto }}">
            <div class="card-body">
                <h6>{{ $producto->nombre_producto }}</h6>
                <small>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</small>
                <div class="fw-bold">S/ {{ number_format($producto->precio, 2) }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal Detalle de Producto -->
    <div class="modal fade" id="modalDetalleProducto" tabindex="-1" aria-labelledby="detalleProductoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detalleProductoLabel">Detalle del Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body text-center">
            <img id="detalleImagen" src="" alt="" class="img-fluid mb-3" style="max-height: 250px; object-fit: contain;">
            <h5 id="detalleNombre" class="fw-bold mb-1"></h5>
            <p id="detalleCategoria" class="text-muted mb-1"></p>
            <p id="detalleTalla" class="mb-1"></p>
            <div id="detallePrecio" class="fw-bold fs-5 text-primary mb-3"></div>
            <button class="btn btn-success" onclick="agregarAlCarrito()">Añadir al carrito</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function mostrarDetalle(imagen, nombre, categoria, talla, precio) {
        document.getElementById('detalleImagen').src = imagen;
        document.getElementById('detalleNombre').textContent = nombre;
        document.getElementById('detalleCategoria').textContent = 'Categoría: ' + categoria;
        document.getElementById('detalleTalla').textContent = 'Talla: ' + talla;
        document.getElementById('detallePrecio').textContent = 'S/ ' + precio;
    }

    function agregarAlCarrito() {
        Swal.fire({
            icon: 'success',
            title: 'Añadido al carrito',
            text: 'El producto fue añadido correctamente.',
            timer: 1500,
            showConfirmButton: false
        });
    }
</script>
@endsection
"form-label">Descripción</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif    

  </div>
</div>
@endsection
