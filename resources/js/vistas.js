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
                            <tr id="producto-${productId}" data-product-id="${productId}">
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
                    $('#carrito-total').text(`S/ ${total.toFixed(2)}`);  // Usar backticks (`` ` ``)

                    // Asignar evento para actualizar la cantidad de un producto
                    $('.cantidad').on('change', function() {
                        const productId = $(this).data('product-id');
                        const nuevaCantidad = $(this).val();
                        actualizarCantidad(productId, nuevaCantidad);
                    });

                    // Mostrar notificación en carrito flotante
                    mostrarNotificacionCarrito(response.cart);

                } else {
                    // Si el carrito está vacío
                    $('#carrito-contenido').html('<tr><td colspan="5" class="text-muted text-center">Tu carrito está vacío.</td></tr>');
                    $('#carrito-total').text('S/ 0.00');
                    // Remover notificación de carrito flotante
                    removerNotificacionCarrito();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los productos del carrito:', error);
                $('#carrito-contenido').html('<tr><td colspan="5" class="text-muted text-center">Hubo un problema al cargar el carrito.</td></tr>');
            }
        });
    }

    window.mostrarDetalle = function(imagen, nombre, categoria, talla, precio, id) {
         // Asignamos los valores del producto a los elementos del modal
        $('#modalDetalleProducto .modal-body img').attr('src', imagen); // Imagen del producto
        $('#modalDetalleProducto .modal-body .nombre-producto').text(nombre); // Nombre del producto
        $('#modalDetalleProducto .modal-body .categoria-producto').text(categoria); // Categoría del producto
        $('#modalDetalleProducto .modal-body .talla-producto').text(talla); // Talla del producto
        $('#modalDetalleProducto .modal-body .precio-producto').text('S/ ' + precio); // Precio del producto
        $('#modalDetalleProducto .modal-body .id-producto').text(id); // ID del producto, si lo deseas mostrar

        // Establecer la cantidad inicial a 1
        $('#modalDetalleProducto #cantidadProducto').val(1); 

        // Si el modal está oculto, lo mostramos
        $('#modalDetalleProducto').modal('show');
    };

    window.agregarAlCarritoDesdeModal = function() {
        // Obtener los valores del modal
        const productoId = $('#modalDetalleProducto .modal-body .id-producto').text();
        const cantidad = parseInt($('#cantidadProducto').val()) || 1;  // Obtener la cantidad o usar 1 si no es válida
        const nombre = $('#modalDetalleProducto .modal-body .nombre-producto').text();
        const precio = $('#modalDetalleProducto .modal-body .precio-producto').text().replace('S/ ', '');
    
        // Llamar a la función para agregar al carrito
        agregarAlCarritoDesdeCatalogo(productoId, nombre, precio, cantidad);
        
        // Cerrar el modal después de agregar al carrito
        $('#modalDetalleProducto').modal('hide');
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
                // Actualizar el total del carrito
                obtenerProductosDelCarrito();
            },
            error: function(xhr, status, error) {
                console.error('Error al quitar el producto:', error);
            }
        });
    }

    // Función para mostrar la notificación en el carrito flotante cuando haya productos
    function mostrarNotificacionCarrito(cart) {
        const carritoFlotante = $('#carritoFlotante');
        const carritoCantidad = Object.keys(cart).length;

        // Si hay productos, mostrar el punto rojo con la cantidad de productos
        if (carritoCantidad > 0) {
            $('#carrito-cantidad').text(carritoCantidad).show();  // Mostrar la cantidad en el punto rojo
        } else {
            $('#carrito-cantidad').hide();  // Si no hay productos, ocultar el punto rojo
        }
    }

    // Función para remover la notificación del carrito flotante cuando esté vacío
    function removerNotificacionCarrito() {
        $('#carrito-cantidad').hide();  // Ocultar el punto rojo cuando no haya productos
    }

    // Asignar el evento click al carrito flotante para mostrar el modal
    $('#carritoFlotante').on('click', function() {
        obtenerProductosDelCarrito();
    });

    // Función para agregar un producto al carrito desde el catálogo
    function agregarAlCarritoDesdeCatalogo(productId, productoNombre, productoPrecio) {
        $.ajax({
            url: routes.agregar, // Verifica que esta ruta esté bien definida
            method: 'POST',
            data: {
                producto_id: productId,
                producto_nombre: productoNombre, 
                producto_precio: productoPrecio, 
                cantidad: 1, 
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.cart) {
                    // Si la respuesta contiene el carrito, actualiza el carrito flotante
                    actualizarCarritoFlotante(response.cart); 
                }
                // Mostrar mensaje de confirmación de agregar al carrito
                mostrarAlertaCarrito('Producto agregado al carrito', 'success');
            },
            error: function(xhr, status, error) {
                console.error('Error al agregar al carrito:', error);
                mostrarAlertaCarrito('Hubo un problema al agregar el producto', 'error');
            }
        });
    }

    // Función para actualizar el carrito flotante (el icono y la cantidad)
    function actualizarCarritoFlotante(cart) {
        const carritoFlotante = $('#carritoFlotante');
        const carritoCantidad = Object.keys(cart).length;

        // Si hay productos en el carrito, mostrar el número de productos en el ícono
        if (carritoCantidad > 0) {
            $('#carrito-cantidad').text(carritoCantidad).show();  // Mostrar la cantidad en el punto rojo
        } else {
            $('#carrito-cantidad').hide();  // Si no hay productos, ocultar el punto rojo
        }
    }

    // Función para mostrar la alerta flotante cuando el carrito se actualiza
    function mostrarAlertaCarrito(mensaje, tipo) {
        const alerta = tipo === 'success' ? '#alertaCarrito' : '#alertaCarritoWarning';
        $(alerta).text(mensaje).show();

        setTimeout(function() {
            $(alerta).fadeOut();
        }, 3000);  // La alerta desaparecerá después de 3 segundos
    }

    // Asignar el evento click a los botones "Añadir al carrito"
    const agregarAlCarritoBtns = document.querySelectorAll('.agregar-al-carrito');
    
    agregarAlCarritoBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const productPrice = this.getAttribute('data-product-price');

            agregarAlCarritoDesdeCatalogo(productId, productName, productPrice);
        });
    });

    // Función para finalizar la compra
    $('#btn-finalizar').on('click', function() {
        const productos = [];
        let total = 0;
    
        // Obtener los productos del carrito
        $('#carrito-contenido tr').each(function() {
            const productId = $(this).data('product-id');
            const cantidad = $(this).find('.cantidad').val();
            const precio = $(this).find('td:nth-child(2)').text().replace('S/ ', ''); // Obtener el precio correctamente
            const subTotal = cantidad * precio;
            total += subTotal;
    
            productos.push({
                id_producto: productId,
                cantidad: cantidad,
                sub_total: subTotal
            });
        });
    
        // Enviar la solicitud para finalizar la compra
        $.ajax({
            url: '/carrito/finalizar', 
            method: 'POST',
            data: {
                productos: productos,
                total: total,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Compra finalizada correctamente');
                // Redirigir al usuario o limpiar el carrito
                window.location.href = "/gracias"; // Puedes cambiar a la página que desees
            },
            error: function(xhr, status, error) {
                console.error('Error al finalizar la compra:', error);
                alert('Hubo un problema al finalizar la compra');
            }
        });
    });
});
