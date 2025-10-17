<?php
session_start();   
include('php/Conexion.php'); 

// Obtener las variables del formulario
$var_email = $_POST['ema_email'];   
$var_password = $_POST['pas_password'];

// Verificar si la columna correcta es 'usu_correo' (ajustar si es otro nombre en la base de datos)
$result = select_where("usuarios", "usu_correo='$var_email'");

if(mysqli_num_rows($result) > 0) { // Verifica si el usuario existe
    // Si existe, procesamos los datos
    while($row = mysqli_fetch_object($result)) {
        // Verificamos la contraseña usando password_verify() para las contraseñas cifradas
        if(password_verify($var_password, $row->usu_contraseña)) { // Si la contraseña es correcta
            // Almacenamos el nombre de usuario y el tipo de usuario en la sesión
            $_SESSION['tipo'] = $row->usu_tipo;           // Guardamos el tipo de usuario (admin, gerente, cliente)
            $_SESSION['usuario'] = $row->usu_nombre;      // Guardamos el nombre del usuario
            $_SESSION['id_usuario'] = $row->id_usuario;   // Guardamos el ID del usuario
            
            // Verificar si la sesión está correctamente establecida
            var_dump($_SESSION); // Esto puede ser útil para depurar si el tipo de usuario se guarda correctamente.
            // IMPORTANTE: Eliminar var_dump() después de depurar, ya que puede exponer información sensible.

            // Mensaje de bienvenida
            echo "<script>alert('¡Bienvenido, " . $row->usu_nombre . " " . $row->usu_apellidos . "!');</script>";
            
            // Redirigir según el tipo de usuario
            switch ($_SESSION['tipo']) {
                case 'admin':
                    header("Location: adm_index.php");  // Si es admin, redirigimos al menú de administrador
                    break;
                case 'gerente':
                    header("Location: ger_index.php");   // Si es gerente, redirigimos al menú de gerente
                    break;
                case 'cliente':
                    header("Location: cli_index.php");  // Si es cliente, redirigimos al menú de cliente
                    break;
                default:
                    header(" adm_index.php");  // Si no se encuentra el tipo de usuario, redirige al login
                    break;
            }
            exit(); // Termina la ejecución después de la redirección
        } else {
            // Si la contraseña es incorrecta
            echo "<script>alert('Acceso Incorrecto. La contraseña es incorrecta.');</script>";
            header("Location: Login.es.php"); // Redirige al login si la contraseña es incorrecta
            exit();
        }
    }
} else {
    // Si el correo no existe en la base de datos
    echo "<script>alert('Usuario o Contraseña incorrectos!');</script>";
    header("Location: Login.es.php"); // Redirige al login si el correo no está registrado
    exit();
}
?>


