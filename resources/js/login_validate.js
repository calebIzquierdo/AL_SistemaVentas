$(document).ready(function() {
    // Validación del formulario
    $('form').submit(function(event) {
        // Prevenir el envío del formulario si hay errores
        event.preventDefault();

        // Limpiar los mensajes de error previos
        $('small').remove();

        // Obtener valores de los campos
        var correo = $('input[name="correo"]').val();
        var contrasena = $('input[name="contrasena"]').val();
        var error = false;

        // Validación de correo
        if (!correo || !validateEmail(correo)) {
            showError('correo', 'Por favor ingresa un correo válido.');
            error = true;
        }

        // Validación de contraseña
        if (!contrasena || contrasena.length < 6) {
            showError('contrasena', 'La contraseña debe tener al menos 6 caracteres.');
            error = true;
        }

        // Si no hay errores, enviar el formulario
        if (!error) {
            this.submit();
        }
    });

    // Función para validar formato de correo electrónico
    function validateEmail(email) {
        var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(email);
    }

    // Función para mostrar el mensaje de error
    function showError(inputName, message) {
        var inputField = $('input[name="' + inputName + '"]');
        var errorDiv = $('<small>').text(message).css('color', 'red');

        inputField.after(errorDiv);

        // Eliminar el mensaje después de 3 segundos
        setTimeout(function() {
            errorDiv.remove(); // Elimina el mensaje de error
        }, 3000); // 3000 ms = 3 segundos
    }

    // Validación de la contraseña (mientras se escribe)
    $('input[name="contrasena"]').on('input', function() {
        var contrasena = $(this).val();

        // Si la contraseña tiene 6 o más caracteres, eliminamos el mensaje de error
        if (contrasena.length >= 6) {
            $('small').remove(); // Eliminar el mensaje de error si es válido
        }
    });

    // Toggle password visibility (ojo)
    $('#togglePassword').click(function() {
        // Obtener el campo de la contraseña
        var passwordField = $('#contrasena');

        // Comprobar el tipo actual del campo
        var type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);

        // Cambiar el ícono del ojo según la visibilidad
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
});
