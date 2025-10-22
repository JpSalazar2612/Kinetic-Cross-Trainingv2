<?php
// Aquí eliminamos la llamada a session_start(), ya que se ejecuta en Contacto.es.php

// Función para realizar la conexión con la base de datos
function db_connect() {
    $db_host = 'localhost';      // Servidor donde está alojada la base de datos
    $db_user = 'root';           // Usuario de la base de datos
    $db_password = '';       // Contraseña de la base de datos
    $db_name = 'gymsito';        // Nombre de la base de datos
    $db_port = 3306;             // Puerto de conexión, por defecto es 3306

    // Conexión a la base de datos
    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

    // Verificar si la conexión fue exitosa
    if (!$connection) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Establecer el conjunto de caracteres UTF-8 para evitar problemas con caracteres especiales
    mysqli_set_charset($connection, 'utf8mb4');

    return $connection;
}

// Función para ejecutar consultas SQL
function db_query($query) {
    $connection = db_connect();  // Llamamos a la conexión
    $result = mysqli_query($connection, $query);  // Ejecutamos la consulta

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($connection));
    }

    return $result;
}

// Función select genérica para obtener todos los registros de una tabla
function select($tbl_name) {
    $sql = "SELECT * FROM $tbl_name";
    $db = db_query($sql);
    return $db;
}

// Función select genérica con condiciones
function select_where($tbl_name, $field_condition) {
    $sql = "SELECT * FROM $tbl_name WHERE $field_condition";
    $db = db_query($sql);
    return $db;
}

// Función para insertar registros en una tabla
function insert($tbl_name, $db_values) {
    // Asegurándonos de que los valores sean correctamente escapados
    $sql = "INSERT INTO $tbl_name (con_nombre, con_correo, con_dudas) VALUES ($db_values)";
    return db_query($sql);
}

// Función para actualizar registros en una tabla
function update($tbl_name, $field_col, $field_where) {
    $sql = "UPDATE $tbl_name SET $field_col WHERE $field_where";
    return db_query($sql);
}

// Función para eliminar registros de una tabla
function delete($tbl_name, $field_condition) {
    $sql = "DELETE FROM $tbl_name WHERE $field_condition";
    return db_query($sql);
}
?>
