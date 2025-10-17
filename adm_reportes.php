<?php
include 'Conexion.php'; // Archivo donde está la conexión a la base de datos

// Función para generar reporte de ventas por usuario
function reporte_ventas_por_usuario() {
    $query = "SELECT u.usu_nombre, u.usu_apellidos, COUNT(v.id_venta) AS total_ventas, SUM(v.ven_pre_total) AS total_ingresos
              FROM usuarios u
              JOIN ventas v ON u.id_usuario = v.id_usuario
              GROUP BY u.id_usuario";
    return db_query($query);
}

// Función para generar reporte de servicios vendidos
function reporte_servicios_vendidos() {
    $query = "SELECT s.ser_nombre, COUNT(dv.id_det_ven) AS cantidad_vendida, SUM(s.ser_precio * dv.det_vent_cantidad) AS total_ingresos
              FROM servicios s
              JOIN detalles_ventas dv ON s.id_servicio = dv.id_servicio
              GROUP BY s.id_servicio";
    return db_query($query);
}

// Función para generar reporte de ingresos totales por fecha
function reporte_ingresos_por_fecha() {
    $query = "SELECT v.ven_fecha, SUM(v.ven_pre_total) AS total_ingresos
              FROM ventas v
              GROUP BY v.ven_fecha";
    return db_query($query);
}

// Función para generar reporte de contactos registrados
function reporte_contactos() {
    $query = "SELECT con_nombre, con_correo, con_dudas FROM contactos";
    return db_query($query);
}

// Lógica para manejar la solicitud de generación de reportes
$reporte = $_GET['reporte'] ?? null;
$resultados = [];

if ($reporte) {
    if ($reporte === 'ventas_por_usuario') {
        $resultados = reporte_ventas_por_usuario();
    } elseif ($reporte === 'servicios_vendidos') {
        $resultados = reporte_servicios_vendidos();
    } elseif ($reporte === 'ingresos_por_fecha') {
        $resultados = reporte_ingresos_por_fecha();
    } elseif ($reporte === 'contactos') {
        $resultados = reporte_contactos();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Administrador</title>
</head>
<body>
    <h1>Generar Reportes</h1>
    <ul>
        <li><a href="adm_reportes.php?reporte=ventas_por_usuario">Ventas por Usuario</a></li>
        <li><a href="adm_reportes.php?reporte=servicios_vendidos">Servicios Vendidos</a></li>
        <li><a href="adm_reportes.php?reporte=ingresos_por_fecha">Ingresos por Fecha</a></li>
        <li><a href="adm_reportes.php?reporte=contactos">Contactos Registrados</a></li>
    </ul>

    <?php if (!empty($resultados)): ?>
        <table border="1">
            <thead>
                <?php foreach (array_keys(mysqli_fetch_assoc($resultados)) as $columna): ?>
                    <th><?= htmlspecialchars($columna) ?></th>
                <?php endforeach; ?>
            </thead>
            <tbody>
                <?php mysqli_data_seek($resultados, 0); ?>
                <?php while ($fila = mysqli_fetch_assoc($resultados)): ?>
                    <tr>
                        <?php foreach ($fila as $valor): ?>
                            <td><?= htmlspecialchars($valor) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>