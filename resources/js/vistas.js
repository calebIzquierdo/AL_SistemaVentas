document.addEventListener("DOMContentLoaded", function() {

    // Función para obtener los productos del carrito y mostrar en la tabla
    function obtenerProductosDelCarrito() {
        $.ajax({
            url: '/carrito',  // Ruta para obtener el carrito
            method: 'GET',
            success: function(response) {
                // Verificar si la respuesta tiene productos en el carrito
                if (response.cart && Object.keys(response.cart).length > 0) {
                    let productosHTML = '';
                    let total = 0;

                    // Iteramos sobre los productos en el carrito
                    for (let productId in response.cart) {
                        let product = response.cart[productId];
                        let subtotal = parseFloat(product.precio) * parseInt(product.cantidad);
                        total += subtotal;

                        // Construir el HTML para cada producto
                        productosHTML += `
                            <tr id="producto-${productId}">
                                <td>${product.nombre}</td>
                                <td>S/ ${product.precio}</td>
                                <td>
                                    <input type="number" class="form-control cantidad" 
                                           data-product-id="${productId}" 
                                           value="${product.cantidad}" min="1" />
                                </td>
                                <td>S/ ${subtotal.toFixed(2)}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" 
                                            data-product-id="${productId}" 
                                            onclick="quitarProducto(${productId})">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    }

                    // Actualizar el contenido del modal con los productos
                    $('#carrito-contenido').html(productosHTML);
                    // Actualizar el total en el modal
                    $('#carrito-total').text(`S/ ${total.toFixed(2)}`);

                    // Asignar evento para actualizar la cantidad de un producto
                    $('.cantidad').on('change', function() {
                        const productId = $(this).data('product-id');
                        const nuevaCantidad = $(this).val();
                        actualizarCantidad(productId, nuevaCantidad);
                    });
                } else {
                    // Si el carrito está vacío
                    $('#carrito-contenido').html('<tr><td colspan="5" class="text-muted text-center">Tu carrito está vacío.</td></tr>');
                    $('#carrito-total').text('S/ 0.00');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los productos del carrito:', error);
                $('#carrito-contenido').html('<tr><td colspan="5" class="text-muted text-center">Hubo un problema al cargar el carrito.</td></tr>');
            }
        });
    }

    // Función para actualizar la cantidad de un producto
    function actualizarCantidad(productId, nuevaCantidad) {
        $.ajax({
            url: '/carrito/actualizar',  // Ruta para actualizar la cantidad
            method: 'POST',
            data: {
                producto_id: productId,
                cantidad: nuevaCantidad,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Actualizar el carrito con la nueva cantidad
                obtenerProductosDelCarrito();
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar la cantidad:', error);
            }
        });
    }

    // **Función QUITAR un producto del carrito**
    // Aquí es donde defines la función quitarProducto globalmente
    window.quitarProducto = function(productId) {
        $.ajax({
            url: `/carrito/${productId}`,  // Ruta para eliminar el producto
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Eliminar el producto de la tabla
                $(`#producto-${productId}`).remove();
                // Actualizar el total
                obtenerProductosDelCarrito();
            },
            error: function(xhr, status, error) {
                console.error('Error al quitar el producto:', error);
            }
        });
    }

    // Asignar el evento click al carrito flotante para mostrar el modal
    $('#carritoFlotante').on('click', function() {
        obtenerProductosDelCarrito();
    });

    // Función para agregar un producto al carrito desde el catálogo
    function agregarAlCarritoDesdeCatalogo(productId, productoNombre, productoPrecio) {
        console.log('Producto agregado al carrito:', productoNombre, 'Precio:', productoPrecio);

        $.ajax({
            url: routes.agregar, // Verifica que esta ruta esté bien definida
            method: 'POST',
            data: {
                producto_id: productId,
                producto_nombre: productoNombre, 
                producto_precio: productoPrecio, 
                cantidad: 1, 
                _token: $('meta[name="csrf-token"]').attr('content') // Asegúrate de que el token CSRF esté bien configurado
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Verifica lo que devuelve el servidor
                if (response.cart) {
                    // Si la respuesta contiene el carrito, actualiza el carrito flotante
                    actualizarCarritoFlotante(response.cart); 
                }
                mostrarAlertaCarrito('Producto agregado al carrito', 'success');
            },
            error: function(xhr, status, error) {
                console.error('Error al agregar al carrito:', error);
                mostrarAlertaCarrito('Hubo un problema al agregar el producto', 'error');
            }
        });
    }

    // Función para actualizar el carrito flotante con la cantidad de productos
    function actualizarCarritoFlotante(cart) {
        const cantidad = Object.keys(cart).reduce((total, key) => total + cart[key].cantidad, 0);
        $('#carrito-cantidad').text(cantidad);  // Actualiza el contador de productos en el carrito flotante
    }

    // Función para mostrar la alerta flotante cuando el carrito se actualiza
    function mostrarAlertaCarrito(mensaje, tipo) {
        const alerta = tipo === 'success' ? '#alertaCarrito' : '#alertaCarritoWarning';
        $(alerta).text(mensaje).show();

        setTimeout(function() {
            $(alerta).fadeOut();
        }, 3000);
    }

    // Asignar el evento click a los botones "Añadir al carrito"
    const agregarAlCarritoBtns = document.querySelectorAll('.agregar-al-carrito');
    
    agregarAlCarritoBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const productPrice = this.getAttribute('data-product-price');

            console.log('ID:', productId, 'Nombre:', productName, 'Precio:', productPrice); // Verificación de datos antes de enviar
            agregarAlCarritoDesdeCatalogo(productId, productName, productPrice);
        });
    });

});
