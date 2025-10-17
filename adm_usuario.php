<?php
session_start(); 
include('php/conexion.php'); 


// Validar si el usuario está logueado
if(!isset($_SESSION['usuario']) || !isset($_SESSION['tipo'])){
    header('Location: login.php');
    exit();
}

// Establecer idioma (opcional)
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es';
}
$lang = $_SESSION['lang'];

// Conexión a la base de datos
$connection = db_connect();
$search = ""; // Inicializar búsqueda

// Manejo de búsqueda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search = trim($_POST['search']);
    $query = "SELECT * FROM usuarios WHERE usu_nombre LIKE ? OR usu_correo LIKE ? OR usu_apellidos LIKE ?";
    $stmt = mysqli_prepare($connection, $query);
    $searchTerm = "%$search%";
    mysqli_stmt_bind_param($stmt, "sss", $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $query = "SELECT * FROM usuarios";
    $result = mysqli_query($connection, $query);
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
      <style>
          /* Estilos generales para cambiar el color del texto */
          body {
              color: #333; /* Color de texto general */
              font-family: Arial, sans-serif;
          }

          /* Estilo para la tabla */
          table {
              width: 100%;
              border-collapse: collapse;
              background-color: #fff; /* Fondo blanco para la tabla */
          }

          table th, table td {
              padding: 10px;
              text-align: left;
              border: 1px solid #ddd;
              color: #333; /* Color del texto en las celdas de la tabla */
          }

          table th {
              background-color: #f8f9fa; /* Fondo gris claro para los encabezados */
              font-weight: bold;
              color: #007bff; /* Color del texto en los encabezados de la tabla */
          }

          /* Estilo para los botones */
          button, .button, .buttonDelete {
              color: #fff; /* Color del texto en los botones */
              background-color: #007bff; /* Color de fondo del botón */
              border: none;
              padding: 10px 20px;
              cursor: pointer;
              border-radius: 5px;
          }

          button:hover, .button:hover, .buttonDelete:hover {
              background-color: #0056b3; /* Color al pasar el mouse sobre el botón */
          }

          /* Estilo para el pie de página */
         

      </style>
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
                              <?php include('php/menu_admin.es.php'); ?>
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
      
      <section class="slider_section">
         <div id="myCarousel" class="carousel slide banner-main" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <img class="first-slide" src="images/Equipo2.jpeg" alt="First slide" style="width: 1540px; height: auto; filter: brightness(0.5);">
                  <div class="container">
                     <div class="carousel-caption relative">
                     <meta charset="utf-8">
    <title>Kinect Gym</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 10px; border: 1px solid #ddd; }
        table th { background-color: #f8f9fa; }
        .button { background-color: #007bff; color: #fff; padding: 5px 10px; text-decoration: none; border-radius: 5px; }
        .button:hover { background-color: #0056b3; }
    </style>
</head>

    <header>
        <h1>Administración de Usuarios</h1>
    </header>
    <section>
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Buscar por nombre, correo o apellidos" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="button">Buscar</button>
        </form>
        <br>
        <a href="adm_usuario_registrar.php" class="button">Crear Usuario</a>
        <h2>Lista de Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['id_usuario']}</td>";
                        echo "<td>{$row['usu_correo']}</td>";
                        echo "<td>{$row['usu_tipo']}</td>";
                        echo "<td>{$row['usu_nombre']}</td>";
                        echo "<td>{$row['usu_apellidos']}</td>";
                        echo "<td>{$row['usu_num_tel']}</td>";
                        echo "<td>
                            <a href='adm_usuario_modificar.php?id={$row['id_usuario']}' class='button'>Modificar</a>
                            <a href='adm_usuario_eliminar.php?id={$row['id_usuario']}' class='button' onclick='return confirmarEliminacion()'>Eliminar</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron usuarios</td></tr>";
                }
                ?>
                
        </table>
        
    </section>
    
<script>
   function confirmarEliminacion() {
       return confirm("¿Estás seguro de que deseas eliminar este usuario?");
   }
</script>
        <footer>
        <div class="footer">
            <div class="container">
               <div class="row pdn-top-30">
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                     <div class="Follow">
                        <h3>Siguenos</h3>
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
                        <h3>Contacto</h3>
                     </div>
                     <p class="Newsletter">Municipio y Estado: Ciudad Hidalgo, Michoacán. <br>
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
               <p>2024 Mi Sitio Web. Todos los derechos reservados. <a href="https://html.design/">Kinetic Cross training</a></p>
            </div>
        </div>
    </footer>

    <!-- ************ FOOTER *************** -->
   
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


