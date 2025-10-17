<?php
session_start();
include_once('php/Conexion.php');

// Definir idioma por defecto
$lang = 'es';
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
}

// Verificar inicio de sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['tipo'])) {
    echo "Usuario no logueado";
    header('Location: login.php');
    exit;
}

// Verificar si el ID del usuario es válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $var_id = $_GET['id'];
} else {
    echo "ID de usuario no válido.";
    exit;
}

// Consultar el usuario
$result = select_where("usuarios", "id_usuario = $var_id");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_object($result);
} else {
    echo "No se encontró el usuario.";
    exit;
}

// Validar si el formulario fue enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extraer valores del formulario
    $correo = $_POST['ema_email'] ?? '';
    $nombre = $_POST['txt_Nombre'] ?? '';
    $apellidos = $_POST['txt_ApPat'] ?? '';
    $num_tel = $_POST['txt_NumTel'] ?? '';
    $contraseña = $_POST['pas_password'] ?? '';
    $confirmar_contraseña = $_POST['pas_password2'] ?? '';
    $tipo = $_POST['lst_Tipo'] ?? '';

    // Validar campos requeridos
    if (empty($correo) || empty($nombre) || empty($contraseña) || empty($confirmar_contraseña)) {
        echo "Todos los campos requeridos deben ser llenados.";
        exit;
    }

    // Validar si las contraseñas coinciden
    if ($contraseña !== $confirmar_contraseña) {
        echo "Error: Las contraseñas no coinciden.";
        exit;
    }

    // Actualizar datos del usuario
    $update_result = update('usuarios', "
        usu_correo='$correo',
        usu_nombre='$nombre',
        usu_apellidos='$apellidos',
        usu_num_tel='$num_tel',
        usu_tipo='$tipo',
        usu_contraseña='$contraseña'
    ", "id_usuario=$var_id");

    

    if ($update_result) {
        echo "Usuario actualizado correctamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }

    var_dump($_POST);
exit;
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
                        <div id="content">
        <div id="section">
        <?php 
    $var_id = $_GET['id'];
    $result = select_where("usuarios", "id_usuario = $var_id");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_object($result);
        ?>
        <h1>Modificando usuario</h1>
<form id="form1" name="form1" method="post" action="adm_usuario_modificar_usuario.php" style="text-align:center;" onsubmit="return validarForm(this);">
    <input name="hid_id" type="hidden" value="<?php echo isset($row->id_usuario) ? $row->id_usuario : ''; ?>" />

    <label for="ema_email">Email</label><br>
    <input name="ema_email" type="email" required onkeyup="javascript:this.value=this.value.toLowerCase();" value="<?php echo isset($row->usu_correo) ? $row->usu_correo : ''; ?>" />

    <p><label for="txt_Nombre">Nombre</label><br>
    <input type="text" name="txt_Nombre" id="txt_Nombre" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo isset($row->usu_nombre) ? $row->usu_nombre : ''; ?>" /></p>

    <p><label for="txt_ApMat">Apellidos</label><br>
    <input type="text" name="txt_ApMat" id="txt_ApMat" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo isset($row->usu_apellidos) ? $row->usu_apellidos : ''; ?>" /></p>

    <p><label for="txt_NumTel">Número de Teléfono</label><br>
    <input type="text" name="txt_NumTel" id="txt_NumTel" maxlength="10" value="<?php echo isset($row->usu_num_tel) ? $row->usu_num_tel : ''; ?>" /></p>

    <p><label for="lst_Tipo">Tipo de Usuario</label><br>
    <select name="lst_Tipo" id="lst_Tipo">
        <option value="<?php echo isset($row->usu_tipo) ? $row->usu_tipo : ''; ?>">
            <?php echo isset($row->usu_tipo) ? $row->usu_tipo : ''; ?>
        </option>
        <option value="admin">Administrador</option>
        <option value="gerente">Gerente</option>
        <option value="cliente">Cliente</option>
    </select></p>

    <p><label for="pas_password">Contraseña</label><br>
    <input name="pas_password" type="password" required value="<?php echo isset($row->usu_contraseña) ? $row->usu_contraseña : ''; ?>" /></p>

    <p><label for="pas_password2">Confirmar Contraseña</label><br>
    <input name="pas_password2" type="password" required value="<?php echo isset($row->usu_Concontraseña) ? $row->usu_Concontraseña : ''; ?>" /></p>

    <p><button name="btn_actualizar" id="btn_actualizar" class="button">Actualizar</button>
    </p>
</form>

        <?php
    } else {
        echo "No hay ningún registro";
    }
?>

        </div>            
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
