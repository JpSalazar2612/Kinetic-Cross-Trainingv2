<?php session_start();
// Cambiar idioma al seleccionar
if (isset($_GET['lang'])) {
   $lang = $_GET['lang'];  // Obtener el idioma desde la URL
   $_SESSION['lang'] = $lang;  // Guardar en la sesión
   // Verificar si el parámetro 'lang' ya está presente en la URL
   $currentPage = basename($_SERVER['PHP_SELF']);  // Obtener el nombre del archivo actual
   $queryString = $_SERVER['QUERY_STRING'];  // Obtener los parámetros de la URL actual

   // Evitar redireccionamientos innecesarios si 'lang' ya está en la URL
   if (strpos($queryString, "lang=$lang") === false) {
       // Redirigir a la misma página sin parámetros duplicados
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
      <!-- Cabeçalho -->
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
                              include "php/menu_cliente.$lang.php";
                              ?>
                           </nav>
                           <!-- Botão dropdown de idioma -->
                           <div class="dropdown" style="display: inline-block; margin-left: 15px;">
                              <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Idioma
                              </button>
                              <div class="dropdown-menu" aria-labelledby="languageDropdown">
                                 <a class="dropdown-item" href="?lang=es">Espanhol</a>
                                 <a class="dropdown-item" href="?lang=en">Inglês</a>
                                 <a class="dropdown-item" href="?lang=pt">Português</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- fim da seção do cabeçalho -->
      </header>
      <!-- fim do cabeçalho -->
      <section class="slider_section">
         <div id="myCarousel" class="carousel slide banner-main" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                <img class="first-slide" src="images/Equipo2.jpeg" alt="First slide" style="width: 1540px; height: auto; filter: brightness(0.5);">
                  <div class="container">
                     <div class="carousel-caption relative">
                        <pre>






                        </pre>
                        <h1>Bem-vindo à página inicial</h1>
                        <h2>Bem-vindo ADMIN <?php echo $_SESSION["usuario"]; ?> . </h2>
                        <p>Olá, você fez login como Administrador.</p>
                        <p>A partir daqui, você pode gerenciar as diferentes áreas do sistema:</p>
                        <p><button>Usuários</button></p>
                        <p><button>Serviços</button></p>
                        <p><button>Fornecedores</button></p>
                  </div>
               </div>
              
        
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Próximo</span>
            </a>
         </div>
      </section>
      
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row pdn-top-30">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="Follow">
                        <h3 style="right: 60px;">Siga-nos</h3>
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
                     <p class="Newsletter">Município e Estado: Ciudad Hidalgo, Michoacán. <br>
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
      <!-- Arquivos de JavaScript -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- barra lateral -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>


