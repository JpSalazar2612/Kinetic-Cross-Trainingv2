<?php 
session_start(); // Aquí es donde debería estar la llamada a session_start()

// Incluir la conexión a la base de datos
include("php/conexion.php"); // Asegúrate de que la ruta sea correcta

// Cambiar idioma al seleccionar
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];  // Obtener el idioma seleccionado desde la URL
    $_SESSION['lang'] = $lang;  // Guardar el idioma en la sesión
}

// Establecer el idioma predeterminado si no está configurado
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es';  // Establecer el idioma por defecto como español
}
$lang = $_SESSION['lang'];  // Obtener el idioma de la sesión

// Comprobamos si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturamos los datos del formulario
    $nombre = mysqli_real_escape_string(db_connect(), $_POST['txt_Nombre']);
    $correo = mysqli_real_escape_string(db_connect(), $_POST['txt_Mail']);
    $mensaje = mysqli_real_escape_string(db_connect(), $_POST['txt_Dudas']);

    // Crear los valores para insertar en la base de datos
    $db_values = "'$nombre', '$correo', '$mensaje'";

    // Llamar a la función de inserción
    if (insert('contactos', $db_values)) {
        // Mensaje de éxito al guardar el mensaje
        echo "<script>
                alert('Tu mensaje ha sido enviado. ¡Gracias!');
                document.getElementById('contactForm').reset(); // Limpiar el formulario
              </script>";
    } else {
        // Mensaje de error en caso de fallo
        echo "<script>
                alert('Hubo un error al enviar tu mensaje. Por favor intenta de nuevo.');
              </script>";
    }
}
?>
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
                              <a href="index.php"><img src="images/logo.jpeg" alt="#" style="width: 100px; height: auto;"></a> 
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
      <!-- end header -->
      <section class="slider_section">
      <div class="about-bg">
                  <div class="abouttitle">
                     <h2><br>contacto</h2>
            </div>
         </div>
      <!-- Contact -->
      <div class="contact-area">
         <div class="contact-inner area-padding">
             <div class="container">
   
                 <!-- Fila de los iconos de contacto (arriba) -->
                 <div class="row contact-icons text-center">
                     <!-- Teléfono --> 
                     <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="contact-icon">
                             <i class="fa fa-mobile"></i>
                             <p>
                                 Tel: (+42) 443-577-0169<br>
                                 <span>Disponible Lunes a Viernes (9am-6pm)</span>
                             </p>
                         </div>
                     </div>
                     <!-- Correo -->
                     <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="contact-icon">
                             <i class="fa fa-envelope-o"></i>
                             <p>
                                 Email: Carlos.torresft@hotmail.com<br>
                                 <span>Colabora con nosotros por correo</span>
                             </p>
                         </div>
                     </div>
                   <!-- Ubicación -->
                     <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="contact-icon">
                             <i class="fa fa-map-marker"></i>
                             <p>
                                 Calle y Número: Salazar 91<br>
                                 <span>Col Centro, Ciudad Hidalgo, Michoacán</span>
                             </p>
                         </div>
                     </div>
                 </div>

                 <div class="row">
                     <!-- Google Map (izquierda) -->
                     <div class="col-md-6 col-sm-12 col-xs-12">
                         <iframe src="https://www.google.com/maps/embed?pb=..." width="100%" height="380" frameborder="0" style="border:0" allowfullscreen="" loading="lazy"></iframe>
                     </div>
     
                     <!-- Formulario de contacto (derecha) -->
                     <div class="col-md-6 col-sm-12 col-xs-12">
                         <div class="form contact-form">
                             <form action="" method="post" role="form" class="contactForm" id="contactForm">
                                 <div class="form-group">
                                     <input type="text" name="txt_Nombre" class="form-control" id="txt_Nombre" placeholder="Tu Nombre" required />
                                 </div>
                                 <div class="form-group">
                                     <input type="email" name="txt_Mail" class="form-control" id="txt_Mail" placeholder="Tu Correo" required />
                                 </div>
                                 <div class="form-group">
                                     <input type="text" name="txt_Dudas" class="form-control" id="txt_Dudas" placeholder="Dudas, sugerencias o comentarios" required />
                                 </div>
                                 <div class="text-center"><button type="submit">Enviar Mensaje</button></div>
                             </form>
                         </div>
                     </div>
                 </div>
     
             </div>
         </div>
      </section>
      <!-- end Contact -->
      <!-- footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row pdn-top-30">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="Follow">
                        <h3 style="right: 60px;">Siguenos </h3>
                     </div>
                     <ul class="location_icon">
                        <li> <a href="https://www.facebook.com/KineticCeterFisioterapia?mibextid=LQQJ4d"><img src="icon/facebook.png"></a></li>
                        <li> <a href="#"><img src="icon/Twitter.png"></a></li>
                        <li> <a href="#"><img src="icon/linkedin.png"></a></li>
                        <li> <a href="https://www.instagram.com/kinet_cet/?igshid=YmMyMTA2M2Y%3D"><img src="icon/instagram.png"></a></li>
                     </ul>
                  </div>
                  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                     <ul class="contant_icon">
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> Calle y Número: Salazar 91, Col Centro, Ciudad Hidalgo, Michoacán</li>
                        <li><i class="fa fa-mobile" aria-hidden="true"></i> (+42) 443-577-0169</li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i> carlos.torresft@hotmail.com</li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- footer -->
      <!-- jQuery files -->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/modernizr-3.6.0.min.js"></script>
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/jquery.easing.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>


