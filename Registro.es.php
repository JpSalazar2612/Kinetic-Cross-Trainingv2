<?php
session_start();  // Inicia la sesión para acceder a las variables de sesión

// Cambiar idioma al seleccionar
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];  // Obtener el idioma seleccionado desde la URL
    $_SESSION['lang'] = $lang;  // Guardar el idioma en la sesión

    // Verificar si el parámetro 'lang' ya está presente en la URL
    $currentPage = basename($_SERVER['PHP_SELF']);  // Obtener el nombre del archivo actual
    $queryString = $_SERVER['QUERY_STRING'];  // Obtener los parámetros de la URL actual

    // Evitar redireccionamientos innecesarios si 'lang' ya está en la URL
    if (strpos($queryString, "lang=$lang") === false) {
        // Redirigir a la misma página con el nuevo idioma y parámetros originales
        parse_str($queryString, $queryArray);  // Convertir la cadena en un array asociativo
        unset($queryArray['lang']);  // Eliminar cualquier parámetro 'lang' existente
        $newQuery = http_build_query($queryArray);  // Reconstruir la cadena de consulta

        // Redirigir a la misma página con el nuevo idioma y parámetros originales
        $redirectUrl = $currentPage . ($newQuery ? "?$newQuery&lang=$lang" : "?lang=$lang");
        header("Location: $redirectUrl");  // Realizar la redirección
        exit();
    }
}

// Establecer el idioma predeterminado si no está configurado
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es';  // Establecer el idioma por defecto como español
}
$lang = $_SESSION['lang'];  // Obtener el idioma de la sesión
?>

<!-- Mostrar mensaje de error, si existe -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="error" style="color: red; font-weight: bold;">
        <?= $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>  <!-- Limpiar el mensaje después de mostrarlo -->
<?php endif; ?>

<!-- Mostrar mensaje de éxito, si existe -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="success" style="color: green; font-weight: bold;">
        <?= $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>  <!-- Limpiar el mensaje después de mostrarlo -->
<?php endif; ?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Kinect Gym</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <script src="js/validacion.js" defer></script>  <!-- Incluye el archivo de validación JavaScript -->
</head>

<body class="main-layout home_page">
    <!-- Header -->
    <header>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                        <div class="full">
                            <div class="center-desk">
                                <div class="logo">
                                    <a href="index.es.php"><img src="images/logo.jpeg" alt="#" style="width: 100px; height: auto;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                        <div class="menu-area">
                            <div class="limit-box">
                                <nav class="main-menu">
                                    <?php
                                    // Incluir el menú según el idioma
                                    include "php/menu.$lang.php";
                                    ?>
                                </nav>
                                <!-- Botón desplegable de idiomas -->
                                <div class="dropdown" style="display: inline-block; margin-left: 15px;">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Idioma
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="languageDropdown">
                                        <a class="dropdown-item" href="?lang=es">Español</a>
                                        <a class="dropdown-item" href="?lang=en">English</a>
                                        <a class="dropdown-item" href="?lang=pt">Português</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contact -->
    <div class="Contact">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="registro-form">
                        <h2 class="h2">¡Regístrate Ahora!</h2>
                        <div id="error-message" style="color: red; display: none;"></div>
                        <div id="success-message" style="color: green; display: none;"></div>
                        <form id="formRegistro" action="Registrar_usuario.php" method="POST" onsubmit="return validarFormulario()">
                            <!-- Correo -->
                            <h3 class="h3">Correo</h3>
                            <input type="email" name="txt_Mail" id="txt_Mail" placeholder="Ingresa tu correo" required />

                            <!-- Teléfono -->
                            <h3 class="h3">Número de Teléfono (10 dígitos)</h3>
                            <input type="tel" name="txt_Telefone" id="txt_Telefone" placeholder="Número de teléfono" required pattern="(\+\d{1,3}[- ]?)?\d{10}" />


                            <!-- Nombre -->
                            <h3 class="h3">Nombre</h3>
                            <input type="text" name="txt_Nombre" id="txt_Nombre" placeholder="Nombre" onkeyup="javascript:this.value=this.value.toUpperCase();" required />

                            <!-- Apellido Paterno -->
                            <h3 class="h3">Apellido Paterno</h3>
                            <input type="text" name="txt_ApPat" id="txt_ApPat" placeholder="Apellido paterno" onkeyup="javascript:this.value=this.value.toUpperCase();" required />

                            <!-- Edad -->
                            <h3 class="h3">Edad</h3>
                            <input type="number" name="txt_Age" id="txt_Age" placeholder="Ingresa tu edad" required min="1" max="120" />

                            <!-- Género -->
                            <h3 class="h3">Género</h3>
                            <input type="radio" id="rad_Male" name="rad_Sex" value="Hombre" required>
                            <label for="rad_Male">Hombre</label>
                            <input type="radio" id="rad_Female" name="rad_Sex" value="Mujer">
                            <label for="rad_Female">Mujer</label>

                            <!-- Nivel -->
                            <h3 class="h3">Nivel</h3>
                            <select name="txt_Nivel" id="txt_Nivel" required>
                                <option value="">Selecciona tu nivel</option>
                                <option value="Principiante">Principiante</option>
                                <option value="Intermedio">Intermedio</option>
                                <option value="Avanzado">Avanzado</option>
                            </select>

                            <!-- Objetivo -->
                            <h3 class="h3">Objetivo</h3>
                              <select name="txt_objetivo" id="txt_objetivo" required>
                                 <option value="">Selecciona tu objetivo</option>
                                 <option value="Fuerza">Fuerza</option>
                                 <option value="Estética">Estética</option>
                              </select>

                            <!-- Contraseña -->
                            <h3 class="h3">Contraseña</h3>
                            <input type="password" name="txt_password" id="txt_password" placeholder="Contraseña" required minlength="8" />

                            <!-- Confirmar Contraseña -->
                            <h3 class="h3">Confirmar Contraseña</h3>
                            <input type="password" name="txt_confirm_password" id="txt_confirm_password" placeholder="Confirmar Contraseña" required />

                            <!-- Botón para enviar -->
                            <button type="submit" id="btn_Guardar">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>     

    <footer>
        <div class="footer">
            <div class="container">
                <div class="row pdn-top-30">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="Follow">
                            <h3 style="right: 60px;">Síguenos</h3>
                        </div>
                        <ul class="location_icon">
                            <li> <a href="https://www.facebook.com/KineticCeterFisioterapia?mibextid=LQQJ4d"><img src="icon/facebook.png"></a></li>
                            <li> <a href="#"><img src="icon/Twitter.png"></a></li>
                            <li> <a href="#"><img src="icon/linkedin.png"></a></li>
                            <li> <a href="https://www.instagram.com/kineticcrosstraining?igsh=cHEzazVxZm5jNnVi"><img src="icon/instagram.png"></a></li>
                        </ul>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12" style="left: 150px">
                        <div class="Follow">
                            <h3 style="right: 80px;">Contacto</h3>
                        </div>
                        <p class="Newsletter">
                            Municipio y Estado: Ciudad Hidalgo, Michoacán. <br>
                            Calle y Número: Salazar 91 <br>
                            Tel: 4435770169 <br>
                            Correo: Carlos.torresft@hotmail.com <br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <p>2024 Mi Sitio Web. Todos los derechos reservados. <a href="https://html.design/">Kinetic Cross Training</a></p>
            </div>
        </div>
    </footer>

    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>
