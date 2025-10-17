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
                        <h1 class="h1" style="font-size: 30px;">Nuestra empresa</h1>
                           <p>En Kinetic Cross Training, somos un gimnasio dedicado a mejorar la salud y el bienestar
                              de nuestra comunidad en Ciudad Hidalgo y sus alrededores. Nos especializamos en ofrecer 
                              un espacio accesible y motivador donde cada persona pueda alcanzar su máximo potencial físico. 
                              Contamos con un equipo comprometido y programas de entrenamiento personalizados diseñados para 
                              adaptarse a las necesidades y
                             objetivos de nuestros clientes, fomentando así una vida más saludable y equilibrada.</p>
                             
                             <div class="contenedordiv ">
                             
                           <img src="images/beliko.jpeg" alt="No pain, no gain" class="img2" style="filter: brightness(0.8)">
                        </section>


                               <section >
                             <h2 class="h2_e"> Objetivo de la empresa</h2>
                             <p>Posicionarnos como el gimnasio de cross training líder en Ciudad Hidalgo y en toda la región de Michoacán,
                               logrando una mayor retención de clientes mediante un servicio de alta calidad, programas de entrenamiento 
                               adaptados a cada nivel, y un ambiente de comunidad que impulse la motivación y el compromiso a largo plazo 
                               con el fitness.</p>
                           </section>
                         
                           <section >
                               <h2 class="h2_e">Misión</h2>
                             <p>En Kinetic Cross Training, brindamos un espacio accesible, profesional y motivador para que cada persona de
                                Ciudad Hidalgo y la región alcance su máximo potencial físico. A través de programas de entrenamiento personalizados
                                 y un equipo comprometido, buscamos impulsar a nuestros clientes hacia una vida más saludable y equilibrada, 
                                 promoviendo el fitness como un pilar de bienestar y desarrollo personal.</p>
                               </section>
                         
                                 <section >
                               <h2 class="h2_e" style="left: -250px;">Visión</h2>
                             <p>Ser el gimnasio de cross training de referencia en Michoacán, reconocido por nuestra excelencia en el servicio, 
                               la calidad de nuestras instalaciones y el impacto positivo en la vida de cada cliente. Aspiramos a consolidarnos
                                como la mejor opción para quienes buscan un enfoque integral de salud y rendimiento físico, contribuyendo a una 
                                comunidad más saludable y activa.</p>
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
                           <h3 style="right: 60px;">Siguenos </h3>
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
                        <p class="Newsletter" >Municipio y Estado: Ciudad hidalgo, Michoacan. <br>
                        Calle y Numero: Salazar 91 <br>
                        Tel: 4435770169 <br>
                        Correo: Carlos.torresft@hotmail.com <br>
                        </p>
                        
                     </div>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <p>2024 Mi Sitio Web. Todos los derechos reservados. <a href="https://html.design/">Kinetic Cross training</a></p>
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
<?php

