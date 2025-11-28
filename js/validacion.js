function validarFormulario() {
    // Validar contraseñas coincidentes
    var password = document.getElementById('txt_password').value;
    var confirmPassword = document.getElementById('txt_confirm_password').value;
    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden.');
        return false; // Detener envío del formulario
    }

    // Validar que el email tenga formato correcto
    var email = document.getElementById('txt_Mail').value;
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert('Por favor ingrese un email válido.');
        return false;
    }

    // Validar que el teléfono tenga 10 dígitos
    var telefono = document.getElementById('txt_Telefone').value;
    var telefonoPattern = /^[0-9]{10}$/;
    if (!telefonoPattern.test(telefono)) {
        alert('El número de teléfono debe tener 10 dígitos.');
        return false;
    }

    // Validación de edad
    var edad = document.getElementById('txt_Age').value;
    if (edad < 1 || edad > 120) {
        alert('Por favor ingrese una edad válida (entre 1 y 120 años).');
        return false;
    }

    // Si todas las validaciones son correctas, permitir el envío del formulario
    return true;
}

  
