<?php
session_start();

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

// Incluir la conexión a la base de datos
include("php/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturamos los datos del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST['txt_Nombre']);
    $correo = mysqli_real_escape_string($conn, $_POST['txt_Mail']);
    $mensaje = mysqli_real_escape_string($conn, $_POST['txt_Dudas']);

    // Insertar los datos en la tabla "contacto"
    $sql = "INSERT INTO contacto (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

    if (mysqli_query($conn, $sql)) {
        // Mensaje de éxito al guardar el mensaje
        echo "<script>alert('Tu mensaje ha sido enviado. ¡Gracias!');</script>";
    } else {
        // Mensaje de error en caso de fallo
        echo "<script>alert('Hubo un error al enviar tu mensaje. Por favor intenta de nuevo.');</script>";
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
         <!-- fim do cabeçalho interno -->
      </header>
      <!-- fim do cabeçalho -->
      <section class="slider_section">
      <div class="about-bg">
                  <div class="abouttitle">
                     <h2><br>contato</h2>
            </div>
         </div>
      <!-- Contato -->
      <div class="contact-area">
         <div class="contact-inner area-padding">
             <div class="container">
                 <div class="row contact-icons text-center">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="contact-icon">
                             <i class="fa fa-mobile"></i>
                             <p>
                                 Tel: (+42) 443-577-0169<br>
                                 <span>Disponível de Segunda a Sexta (9h-18h)</span>
                             </p>
                         </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="contact-icon">
                             <i class="fa fa-envelope-o"></i>
                             <p>
                                 Email: Carlos.torresft@hotmail.com<br>
                                 <span>Colabore conosco por e-mail</span>
                             </p>
                         </div>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                         <div class="contact-icon">
                             <i class="fa fa-map-marker"></i>
                             <p>
                                 Rua e Número: Salazar 91<br>
                                 <span>Bairro Centro, Cidade Hidalgo, Michoacán</span>
                             </p>
                         </div>
                     </div>
                 </div>
                 <div class="row">
                     <div class="col-md-6 col-sm-12 col-xs-12">
                         <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3756.6349344803302!2d-100.5526505!3d19.6855743!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d2cbb5531000ab%3A0x1d10d3b29ec51e0c!2sVidal%20Solis%2089%2C%20Centro%2C%2061164%20Cdad.%20Hidalgo%2C%20Mich.!5e0!3m2!1ses-419!2smx!4v1731009212392!5m2!1ses-419!2smx" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen="" loading="lazy"></iframe>
                     </div>
                     <div class="col-md-6 col-sm-12 col-xs-12">
                         <div class="form contact-form">
                             <div id="sendmessage">Sua mensagem foi enviada. Obrigado!</div>
                             <div id="errormessage"></div>
                             <form action="" method="post" role="form" class="contactForm">
                                 <div class="form-group">
                                     <input type="text" name="txt_Nome" class="form-control" id="txt_Nome" placeholder="Seu Nome" required />
                                     <div class="validation"></div>
                                 </div>
                                 <div class="form-group">
                                     <input type="email" name="txt_Email" class="form-control" id="txt_Email" placeholder="Seu Email" required />
                                     <div class="validation"></div>
                                 </div>
                                 <div class="form-group">
                                     <input type="text" name="txt_Dúvidas" class="form-control" id="txt_Dúvidas" placeholder="Dúvidas, sugestões ou comentários" required />
                                     <div class="validation"></div>
                                 </div>
                                 <div class="text-center"><button type="submit">Enviar Mensagem</button></div>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
      </div>
      </section>
      <!-- fim do Contato -->
      <!-- rodapé -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row pdn-top-30">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="Follow">
                        <h3 style="right: 60px;">Siga-nos </h3>
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
                        <h3 style="right: 80px;">Contato</h3>
                     </div>
                     <p class="Newsletter">Município e Estado: Cidade Hidalgo, Michoacán. <br>
                     Rua e Número: Salazar 91 <br>
                     Tel: 4435770169 <br>
                     Email: Carlos.torresft@hotmail.com <br>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <p>2024 Meu Site. Todos os direitos reservados. <a href="https://html.design/">Kinetic Cross training</a></p>
            </div>
         </div>
      </footer>
      <!-- fim do rodapé -->
      <!-- arquivos Javascript -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- barra lateral -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="

js/custom.js"></script>
   </body>
</html>