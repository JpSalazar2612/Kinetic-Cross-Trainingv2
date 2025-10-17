<?php session_start();
//validamos si se ha hecho o no el inicio de sesion correctamente
//si no se ha hecho la sesion nos regresará a login.php
    if(!isset($_SESSION['usuario']) || !isset($_SESSION['tipo']) ){
        echo "Usuario no Logueado";
        header('Location: login.php'); 
        exit();
    }
?>
<?php include("php/conexion.php"); 

//obtener las variables
$var_id = isset($_POST['hid_id']) ? $_POST['hid_id'] : '';  // Si no está definida, asignar vacío
$var_email = isset($_POST['ema_email']) ? $_POST['ema_email'] : '';
$var_pass = isset($_POST['pas_password']) ? $_POST['pas_password'] : '';
$var_tipo = isset($_POST['lst_Tipo']) ? $_POST['lst_Tipo'] : '';
$var_apPat = isset($_POST['txt_ApPat']) ? $_POST['txt_ApPat'] : '';
$var_nombre = isset($_POST['txt_Nombre']) ? $_POST['txt_Nombre'] : '';

?>

<h2>Datos recibidos</h2>
<hr>
<p>Usted ingreso los siguientes datos:</p>
<?php
//mostrar los datos recibidos
echo "<h3>$var_id</h3>
      <h3>$var_nombre</h3>
      <h3>$var_apPat</h3>
      <h3>$var_tipo</h3>
      <h3>$var_email</h3>
      <h3>$var_pass</h3>";

//realizar la inserción de datos en la tabla con la siguiente sentencia SQL
//insert into t_usuario values( "NULL" , "" , "" , "" ,   , "" )
//considere que la insercion de la primary Key es nula ya que es autoincrmentable

$cons = update( 
    "usuarios", 
    "usu_correo='$var_email', 
     usu_contraseña='$var_pass',  
     usu_tipo='$var_tipo', 
     usu_apellidos='$var_apPat',  
     usu_nombre='$var_nombre'", 
    "id_usuario=$var_id"       
);
  
if($cons) {
?>
<script languaje="javascript" >alert("El Usuario SE MODIFICAD CORRECTAMENTE a la base de datos");</script> 
<?php
} else {
?>
<script languaje="javascript" >alert("El usuario no pudo ser modificado en la base de datos.");</script>
<?php
}
?>
<meta http-equiv="refresh" content="0;URL=adm_usuario.php" > 
