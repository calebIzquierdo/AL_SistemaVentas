$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');
    const routes = {
        listar: '/datos-contacto/ajax-listar',
        store: '/datos-contacto',
        update: '/datos-contacto/',
        delete: '/datos-contacto/'
    };

    const tabla = $('#tablaDatosContacto').DataTable({
        responsive: true,
        ajax: {
            url: routes.listar,
            type: 'GET',
            dataSrc: function (json) {
                console.log('Respuesta del servidor:', json);
                return json.data;
            }
        },
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
        ],
        columns: [
            { data: 0, title: '#' },
            { data: 1, title: 'Fecha Inicio' },
            { data: 2, title: 'Fecha Fin' },
            { data: 3, title: 'Cantidad' },
            { data: 4, title: 'Usuario' },
            { data: 5, title: 'Acciones' }
        ]
    });

    $('#form-crear').submit(function (e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action'); // Usar la URL del formulario
        const data = new FormData(form[0]);
    
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function(response) {
            if (response.success) {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Datos de contacto creados', 
                    timer: 1500, 
                    showConfirmButton: false 
                });
                form[0].reset();
            } else {
                Swal.fire('Error', 'No se pudieron crear los datos de contacto.', 'error');
            }
        }).fail(function(xhr) {
            Swal.fire('Error', xhr.responseJSON?.message || 'Error al crear los datos de contacto', 'error');
        });
    });

    // PRE LLENAR EDITAR
    $(document).on('click', '.btn-editar', function () {
        const btn = $(this);
        $('#form-editar [name="id_contrato"]').val(btn.data('id'));
        $('#form-editar [name="fecha_inicio"]').val(btn.data('fecha_inicio'));
        $('#form-editar [name="fecha_fin"]').val(btn.data('fecha_fin'));
        $('#form-editar [name="cantidad"]').val(btn.data('cantidad'));
        $('#form-editar [name="id_usuario"]').val(btn.data('id_usuario'));
    });

    // EDITAR
    $('#form-editar').submit(function (e) {
        e.preventDefault();
        const form = document.getElementById('form-editar');
        const id = $(form).find('[name="id_contrato"]').val();
        const data = new FormData(form);
        data.append('_method', 'PUT');

        $.ajax({
            url: routes.update + id,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': token },
            data: data,
            processData: false,
            contentType: false,
        }).done(() => {
            $('#modalEditar').modal('hide');
            Swal.fire({ 
                icon: 'success', 
                title: 'Datos de contacto actualizados', 
                timer: 1500, 
                showConfirmButton: false 
            });
            tabla.ajax.reload();
        }).fail(() => {
            Swal.fire('Error', 'No se pudieron actualizar los datos de contacto.', 'error');
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
                    url: routes.delete + id,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': token }
                }).done(() => {
                    tabla.ajax.reload();
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Datos de contacto eliminados', 
                        timer: 1500, 
                        showConfirmButton: false 
                    });
                }).fail(() => {
                    Swal.fire('Error', 'No se pudieron eliminar los datos de contacto.', 'error');
                });
            }
        });
    });
});