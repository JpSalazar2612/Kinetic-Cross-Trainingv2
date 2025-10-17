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
         <!-- fim da parte interna do cabeçalho -->
      </header>
      <!-- fim do cabeçalho -->
      <section class="slider_section">
         <div class="carousel-item active">
            <img class="first-slide" src="images/Equipo2.jpeg" alt="Primeiro slide" style="width: 1540px; height: 1200px; filter: brightness(0.5);">
            <div class="container">
               <div class="carousel-caption relative">
                  <section>
                     <h1 class="h1">Início</h1>
                     <div class="contenedor">
                        <div class="bloque_es">
                           <h2 class="h2_e">Exercício em Família</h2>
                           <p>No Kinetic Cross Training, promovemos exercícios em família em um ambiente acolhedor. 
                              Acreditamos que treinar juntos fortalece os laços familiares. Por isso, oferecemos programas adaptados a todas as idades e níveis, 
                              proporcionando uma experiência segura e personalizada para cada membro da família.</p>
                           <img src="images/Comunidad.jpeg" alt="Exercício em Família" class="bloque_img" style="filter: brightness(0.8);">
                        </div>
                        <div class="bloque_es">
                           <h2 class="h2_e">Matrículas Premium</h2>
                           <p>Nossas matrículas são projetadas para oferecer o melhor custo-benefício, com tarifas acessíveis e descontos especiais para estudantes. 
                              Queremos garantir que todos, independentemente da sua situação, possam ingressar em nossa comunidade e adotar um estilo de vida saudável e ativo.</p>
                           <img src="images/promo1.jpeg" alt="Matrículas Premium" class="bloque_img" style="filter: brightness(0.8);">
                        </div>
                        <div class="bloque_es">
                           <h2 class="h2_e">Sessões de Treino de Alta Qualidade</h2>
                           <p>Cada sessão de treino no Kinetic Cross Training é de alta qualidade, projetada para ser desafiadora e competitiva. 
                              Oferecemos planos personalizados que se ajustam às metas individuais, garantindo resultados eficazes e progresso contínuo, 
                              ajudando todos a alcançar seu máximo potencial.</p>
                           <img src="images/promo2.jpeg" alt="Sessões de Alta Qualidade" class="bloque_img" style="filter: brightness(0.8);">
                        </div>
                     </div>
                     <div class="button_section"> <a class="main_bt" href="#">Leia Mais</a> </div>
                     <ul class="locat_icon">
                        <li> <a href="#"><img src="icon/facebook.png"></a></li>
                        <li> <a href="#"><img src="icon/Twitter.png"></a></li>
                        <li> <a href="#"><img src="icon/linkedin.png"></a></li>
                        <li> <a href="#"><img src="icon/instagram.png"></a></li>
                     </ul>
                  </section>
               </div>
            </div>
         </div>
      </section>
      <!-- rodapé -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row pdn-top-30">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="Follow">
                        <h3>Siga-nos</h3>
                     </div>
                     <ul class="location_icon">
                        <li> <a href="https://www.facebook.com/KineticCeterFisioterapia?mibextid=LQQJ4d"><img src="icon/facebook.png"></a></li>
                        <li> <a href="#"><img src="icon/Twitter.png"></a></li>
                        <li> <a href="#"><img src="icon/linkedin.png"></a></li>
                        <li> <a href="https://www.instagram.com/kineticcrosstraining?igsh=cHEzazVxZm5jNnVi"><img src="icon/instagram.png"></a></li>
                     </ul>
                  </div>
                  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                     <div class="Follow">
                        <h3>Contato</h3>
                     </div>
                     <p class="Newsletter">Município e Estado: Ciudad Hidalgo, Michoacán. <br>
                     Endereço: Salazar 91 <br>
                     Telefone: 4435770169 <br>
                     Email: Carlos.torresft@hotmail.com <br>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         <div class="copyright">
            <div class="container">
               <p>2024 Meu Site. Todos os direitos reservados. <a href="https://html.design/">Kinetic Cross Training</a></p>
            </div>
         </div>
      </footer>
      <!-- fim do rodapé -->
      <!-- arquivos de Javascript -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>