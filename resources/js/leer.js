$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Crear producto
    $('#form-crear').submit(function(e) {
        e.preventDefault();
        const datos = $(this).serialize();

        $.post(routes.store, datos, function(producto) {
            $('#tabla-productos tbody').append(`
                <tr data-id="${producto.id}">
                    <td>${producto.name}</td>
                    <td>${producto.description}</td>
                    <td>${producto.price}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-editar">Editar</button>
                        <button class="btn btn-sm btn-danger btn-eliminar">Eliminar</button>
                    </td>
                </tr>`);
            $('#form-crear')[0].reset();
        });
    });

    // Mostrar datos en formulario de edición
    $('#tabla-productos').on('click', '.btn-editar', function () {
        const fila = $(this).closest('tr');
        const id = fila.data('id');
        const name = fila.find('td:eq(0)').text();
        const description = fila.find('td:eq(1)').text();
        const price = fila.find('td:eq(2)').text();

        $('#form-editar [name=id]').val(id);
        $('#form-editar [name=name]').val(name);
        $('#form-editar [name=description]').val(description);
        $('#form-editar [name=price]').val(price);
        $('#form-editar-container').removeClass('d-none');
    });

    // Cancelar edición
    $('#cancelar-edicion').click(function () {
        $('#form-editar')[0].reset();
        $('#form-editar-container').addClass('d-none');
    });

    // Actualizar producto
    $('#form-editar').submit(function (e) {
        e.preventDefault();
        const id = $('#form-editar [name=id]').val();
        const datos = $(this).serialize();

        $.ajax({
            url: routes.update(id),
            type: 'PUT',
            data: datos,
            success: function (producto) {
                const fila = $(`#tabla-productos tr[data-id='${id}']`);
                fila.find('td:eq(0)').text(producto.name);
                fila.find('td:eq(1)').text(producto.description);
                fila.find('td:eq(2)').text(producto.price);
                $('#form-editar')[0].reset();
                $('#form-editar-container').addClass('d-none');
            }
        });
    });

    // Eliminar producto
    $('#tabla-productos').on('click', '.btn-eliminar', function() {
        const fila = $(this).closest('tr');
        const id = fila.data('id');

        $.ajax({
            url: routes.delete(id),
            type: 'DELETE',
            success: function() {
                fila.remove();
            }
        });
    });
});
