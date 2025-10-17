// Función que valida el formulario
function validarFormulario() {
    // Obtener los valores de los campos del formulario
    var correo = document.getElementById("txt_Mail").value;
    var telefono = document.getElementById("txt_Telefone").value;
    var nombre = document.getElementById("txt_Nombre").value;
    var apellido = document.getElementById("txt_ApPat").value;
    var edad = document.getElementById("txt_Age").value;
    var genero = document.querySelector('input[name="rad_Sex"]:checked');
    var nivel = document.getElementById("txt_Nivel").value;
    var objetivo = document.getElementById("txt_Objetivo").value;
    var contrasena = document.getElementById("txt_password").value;
    var confirmarContrasena = document.getElementById("txt_confirm_password").value;

    // Limpiar mensajes anteriores
    document.getElementById("error-message").style.display = 'none';
    document.getElementById("success-message").style.display = 'none';

    // Validar si todos los campos obligatorios están llenos
    if (!correo || !telefono || !nombre || !apellido || !edad || !genero || !nivel || !objetivo || !contrasena || !confirmarContrasena) {
        document.getElementById("error-message").style.display = 'block';
        document.getElementById("error-message").textContent = "Por favor, completa todos los campos obligatorios.";
        return false;  // Detener el envío del formulario
    }

    // Validar formato de correo
    var correoRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!correoRegex.test(correo)) {
        document.getElementById("error-message").style.display = 'block';
        document.getElementById("error-message").textContent = "Por favor, ingresa un correo válido.";
        return false;
    }

    // Validar que el teléfono tenga exactamente 10 dígitos y sea solo numérico
if (!preg_match('/^[0-9]{10}$/', $var_tel)) {
    $_SESSION['error_message'] = "El número de teléfono debe tener 10 dígitos.";
    header("Location: Registro.es.php");
    exit();
}


    // Validar contraseñas coincidentes
    if (contrasena !== confirmarContrasena) {
        document.getElementById("error-message").style.display = 'block';
        document.getElementById("error-message").textContent = "Las contraseñas no coinciden.";
        return false;
    }

    // Validar longitud de la contraseña (al menos 8 caracteres)
    if (contrasena.length < 8) {
        document.getElementById("error-message").style.display = 'block';
        document.getElementById("error-message").textContent = "La contraseña debe tener al menos 8 caracteres.";
        return false;
    }

    // Si todo es válido, mostrar el mensaje de éxito
    document.getElementById("success-message").style.display = 'block';
    document.getElementById("success-message").textContent = "El formulario se ha enviado correctamente. ¡Gracias por registrarte!";
    
    return true;  // Permitir el envío del formulario
}

  
