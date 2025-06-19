@extends('layouts.vista')

@section('title', $producto->nombre_producto)

@section('content')
<div class="container py-4">
  <div class="row">
    <div class="col-md-6">
      <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-fluid" alt="{{ $producto->nombre_producto }}">
    </div>
    <div class="col-md-6">
      <h2>{{ $producto->nombre_producto }}</h2>
      <p class="lead">S/ {{ number_format($producto->precio, 2) }}</p>
      <p>{{ $producto->descripcion }}</p>
      <form method="POST" action="{{ route('carrito.agregar', $producto->id_producto) }}">
        @csrf
        <button type="submit" class="btn btn-success">Añadir al carrito</button>
      </form>
    </div>
  </div>
</div>
@endsection
