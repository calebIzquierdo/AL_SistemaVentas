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
      <div class="card card-horizontal h-100"
           data-bs-toggle="modal"
           data-bs-target="#modalDetalleProducto"
           onclick="mostrarDetalle(
              '{{ asset('storage/' . $producto->imagen) }}',
              '{{ $producto->nombre_producto }}',
              '{{ $producto->categoria->nombre ?? 'Sin categoría' }}',
              '{{ $producto->talla }}',
              '{{ number_format($producto->precio, 2) }}'
           )">
        <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre_producto }}">
        <div class="card-body">
          <h6>{{ $producto->nombre_producto }}</h6>
          <small>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</small>
          <div class="fw-bold">S/ {{ number_format($producto->precio, 2) }}</div>
               <div class="d-flex justify-content-center gap-2 mt-auto">
            <!-- Botón carrito -->
            <button class="btn btn-outline-success btn-sm" onclick="agregarAlCarritoDesdeCatalogo('{{ $producto->id }}')">
              <i class="fas fa-shopping-cart"></i>
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
                      '{{ number_format($producto->precio, 2) }}'
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
<!-- Título decorativo de sección -->
<section class="text-center my-8">
  <h2 class="titulo-decorado">Conoce sobre Nosotros</h2>
</section>

<!-- Sección destacada de presentación -->
<section class="info-negocio py-5 text-center text-dark animate__animated animate__fadeInUp">
  <div class="container">
    <h2 class="fw-bold mb-3 text-primary animate__animated animate__fadeInDown">Ropa Deportiva & Confecciones a tu Estilo</h2>

    <div class="mb-4">
      <hr class="w-25 d-inline-block me-3 border-primary">
      <i class="fas fa-tshirt fa-lg text-primary"></i>
      <hr class="w-25 d-inline-block ms-3 border-primary">
    </div>

    <p class="lead text-muted mb-4 animate__animated animate__fadeInUp animate__delay-1s">
      En nuestra tienda encontrarás prendas deportivas personalizadas, cómodas y hechas a medida.
      Nos especializamos en confecciones para equipos, empresas y personas que buscan estilo y calidad.
    </p>

    <p class="text-secondary fst-italic animate__animated animate__fadeInUp animate__delay-2s">
      Uniformes | Polos deportivos | Ropa personalizada | Bordados y más...
    </p>
  </div>
@endsection


@section('modals')
<div class="modal fade" id="modalDetalleProducto" tabindex="-1" aria-labelledby="modalDetalleProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetalleProductoLabel">Detalle del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <img id="detalleImagen" src="" class="img-fluid mb-3" style="max-height: 250px;" alt="Imagen del producto">
        <h5 id="detalleNombre" class="fw-bold mb-1"></h5>
        <p id="detalleCategoria" class="text-muted mb-1"></p>
        <p id="detalleTalla" class="mb-1"></p>
        <div id="detallePrecio" class="fw-bold fs-5 text-primary mb-3"></div>
        <button class="btn btn-success" onclick="agregarAlCarrito()">Añadir al carrito</button>
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
</script>
@endsection
