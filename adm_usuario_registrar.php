<?php session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresará a login.php
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['tipo']) ){
        echo "Usuario no Logueado";
        header('Location: adm_usuario_registrar.php'); 
        exit();
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
                           <?php  include('php/menu_admin.php'); ?>
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
                <img class="first-slide" src="images/Equipo2.jpeg" alt="First slide" style="width: 1540px; height: auto; filter: brightness(0.5);">
                  <div class="container">
                     <div class="carousel-caption relative">

        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="registro-form">
                        <h2 class="h2">¡Regístrate Ahora!</h2>
                        <div id="error-message" style="color: red; display: none;"></div>
                        <div id="success-message" style="color: green; display: none;"></div>
                        <form id="formRegistro" action="Registrar_usuario_adm.php" method="POST" onsubmit="return validarFormulario()">
                            <!-- Correo -->
                            <h3 class="h3">Correo</h3>
                            <input type="email" name="ema_email" id="ema_email" placeholder="Ingresa tu correo" required />

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
                        <script>
        function validarFormulario() {
            var password = document.getElementById('txt_password').value;
            var confirmPassword = document.getElementById('txt_confirm_password').value;
            
            // Verifica si las contraseñas coinciden
            if (password !== confirmPassword) {
                alert("Las contraseñas no coinciden.");
                return false;  // Previene el envío del formulario
            }

            return true;  // Permite el envío del formulario
        }
    </script>
                    </div>
                </div>
            </div>
        </div>   
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
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
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
