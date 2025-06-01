@extends('layouts.vista')

@section('title', 'Catálogo de Productos')

@section('content')
<div class="container py-4">
  <div class="row">
    @forelse($productos as $producto)
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          @if($producto->imagen)
            <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="Imagen de {{ $producto->nombre_producto }}" style="object-fit: cover; height: 200px;">
          @endif
          <div class="card-body">
            <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
            <p class="card-text">S/ {{ number_format($producto->precio, 2) }}</p>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <p class="text-muted text-center">No hay productos disponibles.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection
