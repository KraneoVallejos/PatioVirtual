<?php

session_start();
require_once "conexion.php";

//Cabecera JSON
header('Content-Type: application/json; charset=utf-8');

// Verificación de inicio de sesión
if (!isset($_SESSION["usuario"])) {
    echo json_encode(["success" => false, "error" => "acceso denegado"]);
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mensaje = trim($_POST["mensaje"] ?? "");
    $remitente_id = $_SESSION["id_usuario"];
    $estado = "pendiente";

    if ($mensaje === "") {
        echo json_encode(["success" => false, "error" => "Mensaje vacío, escribe un mensaje"]);
        exit;
    }
    
// Escape html y prevenir XSS
    $mensaje = htmlspecialchars($mensaje, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    $sql = "INSERT INTO mensajes (remitente_id, mensaje, fecha, estado)
    	VALUES (?, ?, NOW(), ?)";

    $consulta = $conexion->prepare($sql);
    if (!$consulta) {
        echo json_encode(["success" => false, "error" => "error en la preparación" . $conexion->error]);
        exit;
    }

    $consulta->bind_param('iss', $remitente_id, $mensaje, $estado);

    if ($consulta->execute()) {
        echo json_encode(["success" => true, "mensaje" => "mensaje guardado"]);
    } else {
        echo json_encode(["success" => false, "error" => $consulta->error]);
    }
    $consulta->close();
    exit;
}

echo json_encode(["success" => false, "error" => "método inválido"]);
exit;

