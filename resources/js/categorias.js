$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr('content');

    const tabla =$('#tabla-categorias').DataTable({
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
            text: '<i class="bi bi-arrow-clockwise"></i> ',
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
            text: '<i class="bi bi-file-earmark-pdf"></i> ',
            className: 'btn btn-danger btn-sm',
            download: 'open'
        }
    ],
     columnDefs: [
    {
        targets: 0,            // Primera columna (ej. "#")
        width: '20px',         // Reduce su ancho a 30px
        className: 'text-center' // Centra su contenido
    },
    {
        targets: 1,            // Primera columna (ej. "#")
        width: '10px',         // Reduce su ancho a 30px
        className: 'text-center' // Centra su contenido
    },
    {
        targets: 2,            // Primera columna (ej. "#")
       
        className: 'text-center' // Centra su contenido
    },
    {
        targets: 3,            // Primera columna (ej. "#")
        width: '200px',         // Reduce su ancho a 30px
        className: 'text-center' // Centra su contenido
    },
    ],
    

    });



    // ✅ CREAR
    $('#form-crear').submit(function (e) {
        e.preventDefault();
        const data = $(this).serialize();
        $.post(routes.store, data)
            .done(() => {
                // Cerrar modal
                $('#modalCrear').modal('hide');

                // 🔽 Limpiar campos
                $('#form-crear')[0].reset();

                // Alerta
                Swal.fire({
                    icon: 'success',
                    title: 'Categoría creada',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => location.reload());
            })
            .fail(() => {
                Swal.fire('Error', 'No se pudo crear la categoría.', 'error');
            });
    });


    // PRE LLENAR EDITAR
    $(document).on('click', '.btn-editar', function () {
        $('#form-editar [name="id_categoria"]').val($(this).data('id'));
        $('#form-editar [name="nombre"]').val($(this).data('nombre'));
        new bootstrap.Modal(document.getElementById('modalEditar')).show();
    });

    // EDITAR
    $('#form-editar').submit(function (e) {
        e.preventDefault();
        const id = $(this).find('[name="id_categoria"]').val();
        const data = $(this).serialize() + `&_token=${token}`;
        $.ajax({
            url: routes.update(id),
            method: 'PUT',
            data: data
        }).done(() => {
            $('#modalEditar').modal('hide');
            Swal.fire({ icon: 'success', title: 'Categoría actualizada', timer: 1500, showConfirmButton: false });
            tabla.ajax.reload();
        }).fail(() => Swal.fire('Error', 'No se pudo actualizar la categoría.', 'error'));
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
                    Swal.fire({ icon: 'success', title: 'Eliminado', timer: 1500, showConfirmButton: false });
                    tabla.ajax.reload();
                }).fail(() => Swal.fire('Error', 'No se pudo eliminar la categoría.', 'error'));
            }
        });
    });
});
