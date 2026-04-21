<?php

// Cabecera JSON
header('Content-Type: application/json; charset=utf-8');

try {
    // Verificación de método HTTP 
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            echo json_encode([
                "success" => false,
                "error" => "método NO permitido"
                ], JSON_UNESCAPED_UNICODE);
            exit();
        }

    $nombre = trim($_POST['nombre'] ?? "");
    $apellpat = trim($_POST['apellpat'] ?? "");
    $apellmat = trim($_POST['apellmat'] ?? "");
    $correo = trim($_POST['correo'] ?? "");
    $carrera = trim($_POST['carrera'] ?? "");
    $contrasena = ($_POST['contrasena'] ?? "");

    if ($nombre === "" ||
        $apellpat=== "" ||
        $apellmat=== "" ||
        $correo=== "" ||
        $carrera=== "" ||
        $contrasena=== "") {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "error" => "los datos no pueden estar vacíos"
                ], JSON_UNESCAPED_UNICODE);
            exit();
        }

    // Conexión al servidor
    require_once "../db/conexion.php";

    // consulta preparada con store_result() para verificar correo autorizado
    $sql = "SELECT id FROM correos_autorizados WHERE correo = ?";
    $respuesta = $conexion->prepare($sql);
    if (!$respuesta) {
            http_response_code(500);
            echo json_encode([
                "success" => false, 
                "error" => "error en la preparación de la consulta"
            ], JSON_UNESCAPED_UNICODE);
            $conexion->close();
            exit();
    }
    $respuesta->bind_param("s", $correo);
    $respuesta->execute();
    $respuesta->store_result();

    if ($respuesta->num_rows === 0) {
        http_response_code(403);
        echo json_encode([
            "success" => false, 
            "error" => "el correo no está autorizado o es incorrecto"
            ], JSON_UNESCAPED_UNICODE);
        $respuesta->close();
        $conexion->close();
        exit();
    }
    $respuesta->close();

    // consulta preparada con store_result() para verificar correo existente
    $sql = "SELECT id_usuario FROM usuario WHERE correo = ?";
    $respuesta = $conexion->prepare($sql);
    if (!$respuesta) {
            http_response_code(500);
            echo json_encode([
                "success" => false, 
                "error" => "error en la preparación de la consulta"
            ], JSON_UNESCAPED_UNICODE);
            $conexion->close();
            exit();
    }

    $respuesta->bind_param("s", $correo);
    $respuesta->execute();
    $respuesta->store_result();

    if ($respuesta->num_rows > 0) {
        http_response_code(409);
        echo json_encode([
            "success" => false, 
            "error" => "este correo ya esta registrado"
            ], JSON_UNESCAPED_UNICODE);
        $respuesta->close();
        $conexion->close();
        exit();
    }

    $respuesta->close();

    // Hash de contraseña
    $hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    // Consulta SQL preparada para crear usuario y evitar inyecciones SQL
    $sql = "INSERT INTO usuario (nombre, apellpat, apellmat, correo, carrera, contrasena) VALUES (?, ?, ?, ?, ?, ?)";
    
    $consulta = $conexion->prepare($sql);
    if (!$consulta) {
            http_response_code(500);
            echo json_encode([
                "success" => false, 
                "error" => "error en la preparación de la consulta"
            ], JSON_UNESCAPED_UNICODE);
            $conexion->close();
            exit();
    }

    $consulta->bind_param('ssssss', $nombre, $apellpat, $apellmat, $correo, $carrera, $hashed_contrasena);

    if (!$consulta->execute()) {
            http_response_code(500);
            echo json_encode([
                "success" => false, 
                "error" => "error al crear usuario: " . $consulta->error
            ], JSON_UNESCAPED_UNICODE);
            $consulta->close();
            $conexion->close();
            exit();
    }

    $consulta->close();
    $conexion->close();

    echo json_encode([
            "success" => true, 
            "mensaje" => "usuario registrado con éxito"
            ], JSON_UNESCAPED_UNICODE);
            exit();

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "error interno del servidor" 
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

?>