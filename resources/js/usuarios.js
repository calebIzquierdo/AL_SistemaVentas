$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');

    // ✅ Inicializar DataTable
    const tabla = $('#tabla-usuarios').DataTable({
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
            >
            `,
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

    // ✅ CREAR
    $('#form-crear').submit(function (e) {
    e.preventDefault();
    const data = $(this).serialize();

    $.post(routes.store, data)
        .done(() => {
            $('#modalCrear').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Usuario creado',
                showConfirmButton: false,
                timer: 1500
            }).then(() => location.reload());
        })
        .fail(xhr => {
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                const errores = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                Swal.fire({
                    icon: 'warning',
                    title: 'Error al crear usuario',
                    html: 'El correo ya esta <b>registrado.</b><br>',
                    customClass: {
                        popup: 'swal-small',
                        title: 'swal-custom-title',
                        confirmButton: 'swal-custom-button'
                    },
                    
                    confirmButtonText: 'Entendido',
                    customClass: {
                        popup: 'animated fadeInDown'
                    }
                });

            } else {
                Swal.fire('Error', 'No se pudo crear el usuario.', 'error');
            }
        });
});


    // ✅ PRE LLENAR MODAL EDITAR
    $('#tabla-usuarios').on('click', '.btn-editar', function () {
        const btn = $(this);
        $('#form-editar [name="id_usuario"]').val(btn.data('id'));
        $('#form-editar [name="nombre"]').val(btn.data('nombre'));
        $('#form-editar [name="correo"]').val(btn.data('correo'));
        $('#form-editar [name="celular"]').val(btn.data('celular'));
        $('#form-editar [name="direccion"]').val(btn.data('direccion'));
        $('#form-editar [name="id_tipo_usuario"]').val(btn.data('id_tipo_usuario'));

        new bootstrap.Modal(document.getElementById('modalEditar')).show();
    });

    // ✅ EDITAR
    $('#form-editar').submit(function (e) {
        e.preventDefault();
        const id = $('#form-editar [name="id_usuario"]').val();
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
                title: 'Usuario actualizado',
                showConfirmButton: false,
                timer: 1500
            });
        }).fail(() => {
            Swal.fire('Error', 'No se pudo actualizar el usuario.', 'error');
        });
    });

    // ✅ ELIMINAR
    $('#tabla-usuarios').on('click', '.btn-eliminar', function () {
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
                        title: 'Usuario eliminado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }).fail(() => {
                    Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                });
            }
        });
    });
});
