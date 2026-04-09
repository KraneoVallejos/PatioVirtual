<?php

session_start();

//Cabecera JSON
header('Content-Type: application/json; charset=utf-8');

// Verificación de inicio de sesión
if (!isset($_SESSION["id_usuario"])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "error" => "acceso denegado"
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

require_once "../db/conexion.php";

// consulta SQL con JOIN 
$sql2 = "SELECT m.fecha, u1.nombre AS remitente, m.mensaje, m.estado
FROM mensajes m
JOIN usuario u1 ON m.remitente_id = u1.id_usuario
ORDER BY m.id_mensajes ASC";
$resultado = $conexion->query($sql2);

if (!$resultado) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "error en la consulta: " . $conexion->error
    ], JSON_UNESCAPED_UNICODE);
    $conexion->close();
    exit();
}

$mensajes = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $mensajes[] = [
            "fecha" => $fila["fecha"],
            "remitente" => $fila["remitente"],
            "mensaje" => $fila["mensaje"],
            "estado" => $fila["estado"]

        ];
    }
}

// Libera de memoria el resultado de consulta SQL y cierra la conexión
$resultado->free();
$conexion->close();

echo json_encode([
    "success" => true,
    "mensajes" => $mensajes
], JSON_UNESCAPED_UNICODE);
exit();
