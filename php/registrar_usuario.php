<?php
include("Conexion.php");
$conn = db_connect();

if ($conn) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error en la conexión.";
}
?>
