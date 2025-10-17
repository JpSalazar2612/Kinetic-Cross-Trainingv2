<?php
session_start();
include("php/Conexion.php"); // Verifica que esta ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $var_email = trim($_POST['txt_Mail']);
    $var_tel = trim($_POST['txt_Telefone']);
    $var_nombre = trim($_POST['txt_Nombre']);
    $var_apPat = trim($_POST['txt_ApPat']);
    $var_edad = trim($_POST['txt_Age']);
    $var_genero = trim($_POST['rad_Sex']);
    $var_objetivo = trim($_POST['txt_objetivo']);
    $var_nivel = trim($_POST['txt_Nivel']);
    $var_pass = $_POST['txt_password'];
    $var_confirm_pass = $_POST['txt_confirm_password'];

    // Validaciones básicas
    if ($var_pass !== $var_confirm_pass) {
        $_SESSION['error_message'] = "Las contraseñas no coinciden.";
        header("Location: Registro.es.php");
        exit();
    }

    if (!filter_var($var_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Por favor, ingresa un correo electrónico válido.";
        header("Location: Registro.es.php");
        exit();
    }

    if (!preg_match('/^[0-9]{10}$/', $var_tel)) {
        $_SESSION['error_message'] = "El número de teléfono debe tener 10 dígitos.";
        header("Location: Registro.es.php");
        exit();
    }

    if ($var_edad < 1 || $var_edad > 120) {
        $_SESSION['error_message'] = "Por favor, ingresa una edad válida (entre 1 y 120 años).";
        header("Location: Registro.es.php");
        exit();
    }

    if (empty($var_nombre) || empty($var_apPat) || empty($var_nivel)) {
        $_SESSION['error_message'] = "Por favor, completa todos los campos obligatorios.";
        header("Location: Registro.es.php");
        exit();
    }

    // Hash de la contraseña
    $hashed_password = password_hash($var_pass, PASSWORD_DEFAULT);

    // Conexión a la base de datos
    $conn = db_connect();
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Verificar si el correo ya existe
    $sql_check_email = "SELECT COUNT(*) FROM usuarios WHERE usu_correo = ?";
    if ($stmt_check = mysqli_prepare($conn, $sql_check_email)) {
        mysqli_stmt_bind_param($stmt_check, "s", $var_email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $email_count);
        mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);

        if ($email_count > 0) {
            $_SESSION['error_message'] = "El correo electrónico ya está registrado. Intenta con otro.";
            header("Location: Registro.es.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Error al verificar el correo: " . mysqli_error($conn);
        header("Location: Registro.es.php");
        exit();
    }

    // Preparar la consulta para insertar el usuario
   // Preparar la consulta SQL para insertar el usuario
$sql_insert = "INSERT INTO usuarios (usu_correo, usu_num_tel, usu_nombre, usu_apellidos, usu_edad, usu_genero, usu_objetivo, usu_nivel, usu_contraseña, usu_Concontraseña) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Intentar preparar la consulta
if ($stmt_insert = mysqli_prepare($conn, $sql_insert)) {
// Vincular los parámetros
mysqli_stmt_bind_param($stmt_insert, "ssssisssss", $var_email, $var_tel, $var_nombre, $var_apPat, $var_edad, $var_genero, $var_objetivo, $var_nivel, $hashed_password, $var_confirm_pass);

// Ejecutar la consulta
if (mysqli_stmt_execute($stmt_insert)) {
// Si el registro es exitoso
$_SESSION['success_message'] = "¡Registro exitoso! Bienvenido, " . $var_nombre;
header("Location: registro_exitoso.php");
exit();
} else {
// Si ocurre un error en la ejecución
$_SESSION['error_message'] = "Error al ejecutar la consulta: " . mysqli_error($conn);
header("Location: Registro.es.php");
exit();
}

// Cerrar la sentencia
mysqli_stmt_close($stmt_insert);
} else {
// Si no se pudo preparar la consulta
$_SESSION['error_message'] = "Error al preparar la consulta. Intenta más tarde.";
header("Location: Registro.es.php");
exit();
}

}
?>
