<?php
session_start(); // Inicia la sesión

// Verificar si se ha guardado el mensaje de éxito en la sesión
if (isset($_SESSION['success_message'])) {
    // Mostrar el mensaje de éxito
    echo "<h1>" . $_SESSION['success_message'] . "</h1>";
    unset($_SESSION['success_message']);  // Limpiar el mensaje de éxito después de mostrarlo

    // Redirigir automáticamente después de 3 segundos
    echo "<p>Serás redirigido automáticamente a la página de inicio de sesión...</p>";
    header("refresh:3; url=adm_usuario.php");  // Cambia "login.php" por la página que desees
} else {
    // Si no hay mensaje de éxito, redirigir al formulario de registro
    header("Location: adm_usuario_registrar.php");
    exit();
}
?>

