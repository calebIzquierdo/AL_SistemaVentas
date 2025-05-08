@extends('layouts.app')

@section('content')
<h1>Lista de productos</h1>
<p>Esta es la lista de productos disponibles en la tienda.</p>
<table class="table">
    <thead>
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Descripción</th>
        <th scope="col">Precio</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal{{ $product->id }}">
                    Editar
                </button>
                @include('products.actualizar', ['product' => $product])
                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $product->id }})">
                  Eliminar
              </button>
              <form id="delete-form-{{ $product->id }}" action="{{ route('products.eliminar', $product->id) }}" method="POST" style="display: none;">
                  @csrf
                  @method('DELETE')
              </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
<script>
  function confirmDelete(productId) {
      if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
          document.getElementById('delete-form-' + productId).submit();
      }
  }
</script>
@endsection 