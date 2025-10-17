<?php
session_start();

// Cambiar idioma al seleccionar
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];  // Obtener el idioma seleccionado desde la URL
    $_SESSION['lang'] = $lang;  // Guardar el idioma en la sesión

    // Verificar si el parámetro 'lang' ya está presente en la URL
    $currentPage = basename($_SERVER['PHP_SELF']);  // Obtener el nombre del archivo actual
    $queryString = $_SERVER['QUERY_STRING'];  // Obtener los parámetros de la URL actual

    // Evitar redireccionamientos innecesarios si 'lang' ya está en la URL
    if (strpos($queryString, "lang=$lang") === false) {
        // Redireccionar a la misma página sin parámetros duplicados
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
         
         <!-- end header inner -->
      </header>
      <!-- end header -->
      <section class="slider_section">
         <div id="myCarousel" class="carousel slide banner-main" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <img class="first-slide" src="images/Equipo2.jpeg" alt="First slide" style="width: 1540px; height: auto;filter: brightness(0.5);">
                  <div class="container">
                     <div class="carousel-caption relative">

                        <section>
                           <h1 class="h1" style="font-size: 30px;">Our Company</h1>
                           <p>At Kinetic Cross Training, we are a gym dedicated to improving the health and wellness of our community in Ciudad Hidalgo and surrounding areas. We specialize in providing an accessible and motivating space where everyone can reach their full physical potential. We have a dedicated team and personalized training programs designed to meet the needs and goals of our clients, thus promoting a healthier and more balanced life.</p>
                             
                           <div class="contenedordiv">
                              <img src="images/beliko.jpeg" alt="No pain, no gain" class="img2" style="filter: brightness(0.8)">
                        </section>


                        <section>
                           <h2 class="h2_e">Company Goal</h2>
                           <p>To position ourselves as the leading cross training gym in Ciudad Hidalgo and the entire region of Michoacán, achieving greater client retention through high-quality service, training programs adapted to each level, and a community atmosphere that fosters motivation and long-term commitment to fitness.</p>
                        </section>
                         
                        <section>
                           <h2 class="h2_e">Mission</h2>
                           <p>At Kinetic Cross Training, we provide an accessible, professional, and motivating space for every person in Ciudad Hidalgo and the region to reach their full physical potential. Through personalized training programs and a dedicated team, we aim to help our clients towards a healthier and more balanced life, promoting fitness as a pillar of well-being and personal development.</p>
                        </section>
                         
                        <section>
                           <h2 class="h2_e" style="left: -250px;">Vision</h2>
                           <p>To be the cross training gym of choice in Michoacán, recognized for our excellence in service, the quality of our facilities, and the positive impact we have on the lives of each client. We aim to become the best option for those seeking an integrated approach to health and physical performance, contributing to a healthier and more active community.</p>
                        <div class="button_section"> <a class="main_bt" href="#">Read More</a>  </div>
                        <ul class="locat_icon">
                           <li> <a href="#"><img src="icon/facebook.png"></a></li>
                           <li> <a href="#"><img src="icon/Twitter.png"></a></li>
                           <li> <a href="#"><img src="icon/linkedin.png"></a></li>
                           <li> <a href="#"><img src="icon/instagram.png"></a></li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>                        
      </section>
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row pdn-top-30">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="Follow">
                        <h3 style="right: 60px;">Follow Us</h3>
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
                        <h3 style="right: 80px;">Contact</h3>
                     </div>
                     <p class="Newsletter" >Municipality and State: Ciudad Hidalgo, Michoacán. <br>
                     Street and Number: Salazar 91 <br>
                     Phone: 4435770169 <br>
                     Email: Carlos.torresft@hotmail.com <br>
                     </p>
                     
                  </div>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <p>2024 My Website. All rights reserved. <a href="https://html.design/">Kinetic Cross Training</a></p>
            </div>
         </div>
      </footer>
      <!-- end footer -->
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
