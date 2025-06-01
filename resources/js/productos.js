$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');

    const tabla = $('#tabla-productos').DataTable({
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
        dom: `
        <'row mb-3'
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
        lengthMenu: [[5, 10, 25, 75, 100, 200], [5, 10, 25, 75, 100, 200]],
        pageLength: 10,
        buttons: [
            {
                text: '<i class="bi bi-arrow-clockwise"></i>',
                className: 'btn btn-secondary btn-sm',
                action: function (e, dt) {
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

    // CREAR
    $('#form-crear').submit(function (e) {
        e.preventDefault();
        const form = document.getElementById('form-crear');
        const data = new FormData(form);

        $.ajax({
            url: routes.store,
            method: 'POST',
            data: data,
            processData: false,
            contentType: false,
        }).done(() => {
            $('#modalCrear').modal('hide');
            form.reset();
            Swal.fire({ icon: 'success', title: 'Producto creado', timer: 1500, showConfirmButton: false });
            tabla.ajax.reload();
        }).fail(() => {
            Swal.fire('Error', 'No se pudo crear el producto.', 'error');
        });
    });

    // PRE LLENAR EDITAR
    $(document).on('click', '.btn-editar', function () {
        const btn = $(this);
        $('#form-editar [name="id_producto"]').val(btn.data('id'));
        $('#form-editar [name="nombre_producto"]').val(btn.data('nombre'));
        $('#form-editar [name="talla"]').val(btn.data('talla'));
        $('#form-editar [name="precio"]').val(btn.data('precio'));
        $('#form-editar [name="id_categoria"]').val(btn.data('id_categoria'));
        $('#form-editar [name="imagen"]').val(null);
        $('#imagen-previa').attr('src', btn.data('imagen_url'));
        new bootstrap.Modal(document.getElementById('modalEditar')).show();
    });

    // EDITAR
    $('#form-editar').submit(function (e) {
        e.preventDefault();
        const form = document.getElementById('form-editar');
        const id = $(form).find('[name="id_producto"]').val();
        const data = new FormData(form);
        data.append('_method', 'PUT');

        $.ajax({
            url: routes.update(id),
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: data,
            processData: false,
            contentType: false,
        }).done(() => {
            $('#modalEditar').modal('hide');
            Swal.fire({ icon: 'success', title: 'Producto actualizado', timer: 1500, showConfirmButton: false });
            tabla.ajax.reload();
        }).fail(() => {
            Swal.fire('Error', 'No se pudo actualizar el producto.', 'error');
        });
    });

    // ELIMINAR
    $(document).on('click', '.btn-eliminar', function () {
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
                    Swal.fire({ icon: 'success', title: 'Producto eliminado', timer: 1500, showConfirmButton: false });
                    tabla.ajax.reload();
                }).fail(() => Swal.fire('Error', 'No se pudo eliminar el producto.', 'error'));
            }
        });
    });

    // VER IMAGEN
    $(document).on('click', '.btn-ver-imagen', function () {
        const imgUrl = $(this).data('img');
        $('#vista-imagen').attr('src', imgUrl);
        new bootstrap.Modal(document.getElementById('modalImagen')).show();
    });
});
