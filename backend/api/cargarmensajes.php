<?php

session_start();
require_once "../db/conexion.php";

//Cabecera JSON
header('Content-Type: application/json; charset=utf-8');

// Verificación de inicio de sesión
if (!isset($_SESSION["usuario"])) {
    echo json_encode(["success" => false, "error" => "acceso denegado"]);
    exit;
}

// consulta SQL con JOIN 
$sql2 = "SELECT m.fecha, u1.nombre AS remitente, m.mensaje, m.estado
FROM mensajes m
JOIN usuario u1 ON m.remitente_id = u1.id_usuario
ORDER BY m.fecha ASC";
$resultado = $conexion->query($sql2);

if (!$resultado){
    echo json_encode(["success" => false, "error" => "error en la consulta". $conexion->error]);
    exit;
}

$mensajes = [];

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()){
        $mensajes[] = [
            "fecha" => $fila["fecha"],
            "remitente" => $fila["remitente"],
            "mensaje" => $fila["mensaje"],
            "estado" => $fila["estado"]

        ];
    }
}

echo json_encode(["success" => true, "mensajes" => $mensajes], JSON_UNESCAPED_UNICODE);
exit;