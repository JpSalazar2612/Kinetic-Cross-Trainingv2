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
$var_email = $_POST['ema_email'];
$var_pass = $_POST['pas_password'];
$var_tipo = $_POST['usu_Tipo'];
$var_apPat = $_POST['txt_ApPat'];
$var_apMat = $_POST['txt_ApMat'];
$var_nombre = $_POST['txt_Nombre'];
?>

<h2>Datos recibidos</h2>
<hr>
<p>Usted ingreso los siguientes datos:</p>
<?php
//mostrar los datos recibidos
echo "<h3>$var_nombre</h3>
      <h3>$var_apPat</h3>
      <h3>$var_tipo</h3>
      <h3>$var_email</h3>
      <h3>$var_pass</h3>";

//realizar la inserción de datos en la tabla con la siguiente sentencia SQL
//insert into t_usuario values( "NULL" , "" , "" , "" ,   , "" )
//considere que la insercion de la primary Key es nula ya que es autoincrmentable

$cons = insert( 
      'usuarios',
      "NULL,'$var_email','$var_pass','$var_tipo','$var_apPat','$var_nombre'");

if($cons) {
?>
<script languaje="javascript" >alert("El Usuario SE AÑADIO CORRECTAMENTE a la base de datos");</script> 
<?php
} else {
?>
<script languaje="javascript" >alert("El usuario no pudo ser insertada en la base de datos.");</script>
<?php
}
?>
<meta http-equiv="refresh" content="0;URL=adm_usuario.php" > 
