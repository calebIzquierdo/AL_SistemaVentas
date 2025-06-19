$(document).ready(function () {
    $('#form-registro').submit(function (e) {
        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

        const data = $(this).serialize(); // Serializa los datos del formulario

        $.ajax({
            url: '/registro', // La ruta para enviar los datos
            method: 'POST', // Método POST para enviar los datos
            data: data, // Datos que se enviarán al backend
            success: function (response) {
                // Almacenar el mensaje de éxito en sessionStorage
                sessionStorage.setItem('registroExitoso', 'Usuario registrado con éxito. Puedes iniciar sesión ahora.');

                // Redirigir al login después de la alerta
                window.location.href = '/login'; // Redirige al login
            },
            error: function (xhr) {
                // Si ocurre un error, mostrar los mensajes de error
                const errors = xhr.responseJSON.errors;
                let errorMessage = '';
                for (let field in errors) {
                    errorMessage += errors[field].join('<br>') + '<br>';
                }
                Swal.fire('Error', errorMessage, 'error');
            }
        });
    });
});
