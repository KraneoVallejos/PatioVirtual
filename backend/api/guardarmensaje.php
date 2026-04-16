<?php

session_start();

//Cabecera JSON
header('Content-Type: application/json; charset=utf-8');

// Manejo de errores con try/catch
try {
    // Verificación de inicio de sesión
    if (!isset($_SESSION["id_usuario"])) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "error" => "acceso denegado"
            ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Verificar método HTTP
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode([
            "success" => false,
            "error" => "método NO permitido"
            ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $mensaje = trim($_POST["mensaje"] ?? "");
    $remitente_id = $_SESSION["id_usuario"];
    $estado = "pendiente";

    if ($mensaje === "") {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "Mensaje vacío, escribe un mensaje"
            ], JSON_UNESCAPED_UNICODE);
        exit();
    }
        
    // Escape html y prevenir XSS
    $mensaje = htmlspecialchars($mensaje, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    // Conexión al servidor
    require_once "../db/conexion.php";

    //Consulta SQL para insertar mensaje a BD
    $sql = "INSERT INTO mensajes (remitente_id, mensaje, fecha, estado)
        VALUES (?, ?, NOW(), ?)";

    $consulta = $conexion->prepare($sql);

    if (!$consulta) {
        http_response_code(500);
        echo json_encode([
            "success" => false, 
            "error" => "error en la petición" . $conexion->error
        ], JSON_UNESCAPED_UNICODE);
        $conexion->close();
        exit();
    }

    $consulta->bind_param('iss', $remitente_id, $mensaje, $estado);

    if (!$consulta->execute()) {
        http_response_code(500);
        echo json_encode([
            "success" => false, 
            "error" => "error al guardar mensaje: " . $consulta->error
            ], JSON_UNESCAPED_UNICODE);
            $consulta->close();
            $conexion->close();
            exit();  
    }
    $consulta->close();
    $conexion->close();

    echo json_encode([
            "success" => true, 
            "mensaje" => "mensaje guardado"
            ], JSON_UNESCAPED_UNICODE);
    exit();
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "error en la conexión" 
    ], JSON_UNESCAPED_UNICODE);
    exit();
}



