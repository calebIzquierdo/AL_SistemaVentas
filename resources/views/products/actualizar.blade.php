<div class="modal fade" id="modal{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar producto</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="{{ route('products.update', $product) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="mb-3">
                      <label for="name" class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                  </div>
                  <div class="mb-3">
                      <label for="description" class="form-label">Descripción</label>
                      <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                  </div>
                  <div class="mb-3">
                      <label for="price" class="form-label">Precio</label>
                      <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}">
                  </div>
                  <button type="submit" class="btn btn-primary">Actualizar producto</button>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
      </div>
  </div>
</div>