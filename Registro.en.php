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
      <!-- Contact -->
      <div class="Contact">
         <div class="container">
             <div class="row">
                 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                     <div class="registro-form">
                         <h2 class="h2">Register Now!</h2>
                         <div id="error-message" style="color: red; display: none;">
                             Please complete all required fields.
                         </div>
                         <div id="success-message" style="color: green; display: none;">
                             The form has been submitted successfully. Thank you for registering!
                         </div>
                         <form id="formRegistro" action="registrar_usuario.php" method="POST" onsubmit="return validarFormulario()">
                             <!-- Correo -->
                             <h3 class="h3">Email</h3>
                             <input type="email" name="txt_Mail" id="txt_Mail" placeholder="Enter your email" required />
     
                             <!-- Teléfono -->
                             <h3 class="h3">Phone Number (10 digits)</h3>
                             <input type="text" name="txt_Telefone" id="txt_Telefone" placeholder="Phone number" required pattern="[0-9]{10}" />
     
                             <!-- Nombre -->
                             <h3 class="h3">First Name</h3>
                             <input type="text" name="txt_Nombre" id="txt_Nombre" placeholder="First Name" onkeyup="javascript:this.value=this.value.toUpperCase();" required />
     
                             <!-- Apellido Paterno -->
                             <h3 class="h3">Last Name</h3>
                             <input type="text" name="txt_ApPat" id="txt_ApPat" placeholder="Last Name" onkeyup="javascript:this.value=this.value.toUpperCase();" required />
     
                             <!-- Edad -->
                             <h3 class="h3">Age</h3>
                             <input type="number" name="txt_Age" id="txt_Age" placeholder="Enter your age" required min="1" max="120" />
     
                             <!-- Género -->
                             <h3 class="h3">Gender</h3>
                             <input type="radio" id="rad_Male" name="rad_Sex" value="Hombre" required>
                             <label for="rad_Male">Male</label>
                             <input type="radio" id="rad_Female" name="rad_Sex" value="Mujer">
                             <label for="rad_Female">Female</label>
     
                             <!-- Nivel -->
                             <h3 class="h3">Level</h3>
                             <select name="txt_Nivel" id="txt_Nivel" required>
                                 <option value="">Select your level</option>
                                 <option value="Principiante">Beginner</option>
                                 <option value="Intermedio">Intermediate</option>
                                 <option value="Avanzado">Advanced</option>
                             </select>
     
                             <!-- Contraseña -->
                             <h3 class="h3">Password (minimum 8 characters, including at least one letter and one number)</h3>
                             <input type="password" name="txt_password" id="txt_password" placeholder="Password" required minlength="8" />
     
                             <!-- Confirmar Contraseña -->
                             <h3 class="h3">Confirm Password</h3>
                             <input type="password" name="txt_confirm_password" id="txt_confirm_password" placeholder="Confirm Password" required />
     
                             <!-- Botón para enviar -->
                             <button type="submit" id="btn_Guardar">Save</button>
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
                     <h3 style="right: 60px;">Follow Us </h3>
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
            <p>2024 My Website. All rights reserved. <a href="https://html.design/">Kinetic Cross training</a></p>
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

