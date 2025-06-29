$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');

    // Inicializar DataTable
    const tabla = $('#tabla-stock').DataTable({
        responsive: true,
        ajax: routes.listar,
        language: {
            lengthMenu: 'Mostrar: _MENU_ registros',
            search: 'Buscar:',
            info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
            paginate: {
                first: 'Primero',
                last: 'Último',
                next: 'Siguiente',
                previous: 'Anterior'
            },
            zeroRecords: 'No se encontraron resultados',
            infoEmpty: 'Mostrando 0 a 0 de 0 registros',
            infoFiltered: '(filtrado de _MAX_ registros totales)',
            loadingRecords: 'Cargando...',
            processing: 'Procesando...'
        },
        dom: `<'row mb-3'
            <'col-lg-4 col-md-6 mb-2 d-flex align-items-center justify-content-start'B>
            <'col-lg-4 col-md-6 mb-2 d-flex align-items-center justify-content-start'l>
            <'col-lg-4 col-md-12 mb-2 d-flex align-items-center justify-content-end'f>
        >
        <'row'
            <'col-sm-12'tr>
        >
        <'row mt-2'
            <'col-md-5'i>
            <'col-md-7'p>
        >`,
        lengthMenu: [
            [5, 10, 25, 75, 100, 200],
            [5, 10, 25, 75, 100, 200]
        ],
        pageLength: 10,
        buttons: [
            {
                text: '<i class="bi bi-arrow-clockwise"></i>',
                className: 'btn btn-secondary btn-sm',
                action: function (e, dt, node, config) {
                    dt.ajax.reload();
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-file-earmark-excel"></i>',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="bi bi-file-earmark-pdf"></i>',
                className: 'btn btn-danger btn-sm',
                download: 'open'
            }
        ]
    });


  $('#modalCrear').on('show.bs.modal', function () {
    // Hacer la solicitud AJAX para obtener los productos disponibles
    $.ajax({
        url: routes.productosDisponibles,  // Ruta definida en el controlador
        method: 'GET',
        success: function(response) {
            console.log("Respuesta del servidor:", response);

            let select = $('#form-crear [name="id_producto"]');
            select.empty();
            select.append('<option value="">Seleccione producto</option>');

            if (response.productos && response.productos.length > 0) {
                response.productos.forEach(function(producto) {
                    select.append('<option value="' + producto.id_producto + '">' + producto.nombre_producto + '</option>');
                });
            } else {
                select.append('<option value="">No hay productos disponibles</option>');
            }

            // Establecer la fecha actual en el campo "fecha_inicio"
            const today = new Date().toISOString().split('T')[0];  // Obtener la fecha actual en formato YYYY-MM-DD
            $('#form-crear [name="fecha_inicio"]').val(today);  // Asignar la fecha al campo de fecha
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);  // Mostrar el error en la consola si algo sale mal
        }
    });
});











    // Crear Stock
    $('#form-crear').submit(function (e) {
        e.preventDefault();
        const data = $(this).serialize();

        $.post(routes.store, data)
            .done(() => {
                $('#modalCrear').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Stock creado',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => location.reload());
            })
            .fail(xhr => {
                Swal.fire('Error', 'No se pudo crear el stock.', 'error');
            });
    });

    // Editar Stock
    $('#tabla-stock').on('click', '.btn-editar', function () {
        const btn = $(this);
        $('#form-editar [name="id_stock"]').val(btn.data('id'));
        $('#form-editar [name="fecha_inicio"]').val(btn.data('fecha_inicio'));
        $('#form-editar [name="cantidad"]').val(btn.data('cantidad'));
        $('#form-editar [name="id_producto"]').val(btn.data('id_producto'));

        new bootstrap.Modal(document.getElementById('modalEditar')).show();
    });

    // Actualizar Stock
    $('#form-editar').submit(function (e) {
        e.preventDefault();
        const id = $('#form-editar [name="id_stock"]').val();
        const data = $(this).serialize() + `&_token=${token}`;

        $.ajax({
            url: routes.update(id),
            method: 'PUT',
            data: data
        }).done(() => {
            $('#modalEditar').modal('hide');
            tabla.ajax.reload();
            Swal.fire({
                icon: 'success',
                title: 'Stock actualizado',
                showConfirmButton: false,
                timer: 1500
            });
        }).fail(() => {
            Swal.fire('Error', 'No se pudo actualizar el stock.', 'error');
        });
    });

    // Eliminar Stock
    $('#tabla-stock').on('click', '.btn-eliminar', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: routes.delete(id),
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': token }
                }).done(() => {
                    tabla.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Stock eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }).fail(() => {
                    Swal.fire('Error', 'No se pudo eliminar el stock.', 'error');
                });
            }
        });
    });
});
