<?php
session_start(); 
include('php/conexion.php');

// Validar si el usuario está logueado
if(!isset($_SESSION['usuario']) || !isset($_SESSION['tipo'])){
    header('Location: login.php');
    exit();
}

// Conexión a la base de datos
$connection = db_connect();

// Variables para mensaje de contacto
$nombre = $correo = $mensaje = "";
$nombreErr = $correoErr = $mensajeErr = "";
$successMessage = "";

// Validación del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["nombre"])) {
        $nombreErr = "El nombre es obligatorio.";
    } else {
        $nombre = test_input($_POST["nombre"]);
    }

    if (empty($_POST["correo"])) {
        $correoErr = "El correo es obligatorio.";
    } else {
        $correo = test_input($_POST["correo"]);
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $correoErr = "El correo no es válido.";
        }
    }

    if (empty($_POST["mensaje"])) {
        $mensajeErr = "El mensaje es obligatorio.";
    } else {
        $mensaje = test_input($_POST["mensaje"]);
    }

    // Si no hay errores, procesamos el mensaje
    if (empty($nombreErr) && empty($correoErr) && empty($mensajeErr)) {
        // Insertar el mensaje en la base de datos
        $query = "INSERT INTO mensajes_contacto (nombre, correo, mensaje) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sss", $nombre, $correo, $mensaje);
        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Mensaje enviado correctamente.";
            // Limpiar campos del formulario
            $nombre = $correo = $mensaje = "";
        } else {
            $successMessage = "Hubo un error al enviar el mensaje.";
        }
    }
}

// Función para limpiar los datos
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Mi Sitio Web</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <section class="container">
        <h1>Formulario de Contacto</h1>

        <?php if ($successMessage) { echo "<div class='alert alert-success'>$successMessage</div>"; } ?>

        <form method="POST" action="contacto.php">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                <span class="text-danger"><?php echo $nombreErr; ?></span>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo; ?>">
                <span class="text-danger"><?php echo $correoErr; ?></span>
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje:</label>
                <textarea class="form-control" id="mensaje" name="mensaje" rows="5"><?php echo $mensaje; ?></textarea>
                <span class="text-danger"><?php echo $mensajeErr; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
        </form>
    </section>

    <footer class="bg-light py-4">
        <div class="container text-center">
            <p>© 2024 Mi Sitio Web. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
