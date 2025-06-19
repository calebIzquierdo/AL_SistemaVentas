@extends('layouts.vista')

@section('title', 'Catálogo de Productos')

@section('content')

<!-- Carrusel tipo portada -->
<div id="carouselPortada" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="d-block w-100 carousel-bg" style="background-image: url('{{ asset('imagenes/banner1.jpg') }}');"></div>
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-white fw-bold text-shadow">El mejor ambiente</h2>
        <a href="#seccionLocales" class="btn btn-danger mt-3">NUESTROS LOCALES »</a>
      </div>
    </div>
    <div class="carousel-item">
      <div class="d-block w-100 carousel-bg" style="background-image: url('{{ asset('imagenes/banner2.jpg') }}');"></div>
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-white fw-bold text-shadow">Café y compañía</h2>
        <a href="#seccionCarta" class="btn btn-danger mt-3">VER LA CARTA »</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselPortada" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselPortada" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </button>
</div>

<!-- Título decorativo de sección -->
<section class="text-center my-5">
  <h2 class="titulo-decorado">Nuestros Productos</h2>
</section>

<!-- Catálogo de productos -->
<div class="container py-4">
  <div class="row g-4 justify-content-center">
    @foreach($productos as $producto)
    <div class="col-12 col-sm-6 col-md-3">
      <div class="card card-horizontal h-100">
        <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre_producto }}">
        <div class="card-body">
          <h6>{{ $producto->nombre_producto }}</h6>
          <small>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</small>
          <div class="fw-bold">S/ {{ number_format($producto->precio, 2) }}</div>
          <div class="d-flex justify-content-center gap-2 mt-auto">
            <!-- Botón carrito -->
            <button class="btn btn-outline-success btn-sm agregar-al-carrito" data-product-id="{{ $producto->id_producto }}" data-product-name="{{ $producto->nombre_producto }}" data-product-price="{{ $producto->precio }}">
              <i class="fas fa-shopping-cart"></i> Añadir al carrito
            </button>

            <!-- Botón detalle -->
            <button class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetalleProducto"
                    onclick="mostrarDetalle(
                      '{{ asset('storage/' . $producto->imagen) }}',
                      '{{ $producto->nombre_producto }}',
                      '{{ $producto->categoria->nombre ?? 'Sin categoría' }}',
                      '{{ $producto->talla }}',
                      '{{ number_format($producto->precio, 2) }}',
                      '{{ $producto->id_producto }}'
                    )">
              Detalle
            </button>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<!-- Ícono flotante del carrito -->
<div id="carritoFlotante" class="carrito-flotante">
  <a href="#" data-bs-toggle="modal" data-bs-target="#modalCarrito">
    <i class="fas fa-shopping-cart"></i>
    <span id="carrito-cantidad" class="badge rounded-pill bg-danger">0</span>
  </a>
</div>

@endsection

@section('modals')
<!-- Modal Ver Carrito -->
<div class="modal fade" id="modalCarrito" tabindex="-1" aria-labelledby="modalCarritoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCarritoLabel">Mi Carrito</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <!-- Tabla de productos del carrito -->
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="carrito-contenido">
            <!-- Los productos se llenarán aquí con JavaScript -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <strong>Total: <span id="carrito-total">S/ 0.00</span></strong>
        <button class="btn btn-primary" id="btn-finalizar">Finalizar compra</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal de Perfil -->
<!-- Modal de Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="modalPerfilLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- Verificar si el usuario está autenticado -->
                <h5 class="modal-title" id="modalPerfilLabel">
                    Perfil de {{ auth()->check() ? auth()->user()->nombre : 'Invitado' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Información del usuario -->
                <p><strong>Nombre:</strong> {{ auth()->check() ? auth()->user()->nombre : 'No disponible' }}</p>
                <p><strong>Email:</strong> {{ auth()->check() ? auth()->user()->correo : 'No disponible' }}</p>
                <p><strong>Celular:</strong> {{ auth()->check() ? auth()->user()->celular : 'No disponible' }}</p>
                <p><strong>Dirección:</strong> {{ auth()->check() ? auth()->user()->direccion : 'No disponible' }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




@endsection

@section('scripts')
<script>
  const routes = {
    agregar: "{{ route('carrito.agregar') }}",  
    actualizar: "{{ route('carrito.actualizar') }}",
    quitar: "{{ route('carrito.quitar', ['productoId' => '__ID__']) }}",
  };
</script>

@vite(['resources/js/vistas.js']) <!-- Asegúrate que el archivo está cargado correctamente -->
@endsection
