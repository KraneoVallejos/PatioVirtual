<?php
session_start();

// Cabecera JSON
header('Content-Type: application/json; charset=utf-8');

try {
    // Verificar si se ha enviado el formulario con método POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode([
            "success" => false,
            "error" => "método no permitido"
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Recuperar datos del formulario
    $correo = trim($_POST["correo"] ?? "");
    $contrasena = ($_POST["contrasena"] ?? "");

    if ($correo === "" || $contrasena === "") {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "campos vacíos"
        ], JSON_UNESCAPED_UNICODE);    
        exit();
    }
    require_once "../db/conexion.php";

    // Consulta SQL preparada para verificar credenciales y evitar inyecciones SQL    
    $sql = "SELECT id_usuario, contrasena, nombre FROM usuario WHERE correo=?";
    $consulta = $conexion->prepare($sql);

    // Confirmación de consulta SQL
    if (!$consulta) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => "error en la preparación de la consulta"
        ], JSON_UNESCAPED_UNICODE);
        $conexion->close();
        exit();
    }

    $consulta->bind_param('s', $correo);

    if (!$consulta->execute()) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => "error en la ejecución de la consulta"
        ], JSON_UNESCAPED_UNICODE);
        $consulta->close();
        $conexion->close();
        exit();
    }

    $consulta->store_result();

    // verificación de correo existente
    if ($consulta->num_rows !== 1) {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "error" => "credenciales inválidas"
        ], JSON_UNESCAPED_UNICODE);
        $consulta->close();
        $conexion->close();
        exit();
    }

    $consulta->bind_result($id_usuario, $hashed_password, $nombre);
    $consulta->fetch();

    //verificar hash
    if (is_string($hashed_password) && password_verify($contrasena, $hashed_password)) {
        session_regenerate_id(true);
        $_SESSION["id_usuario"] = $id_usuario;
        $_SESSION["usuario"] = $nombre;
        $_SESSION["correo"] = $correo;

        echo json_encode ([
            "success" => true,
            "mensaje" => "has iniciado sesión correctamente"
        ], JSON_UNESCAPED_UNICODE);
        $consulta->close();
        $conexion->close();
        exit();
    }

    http_response_code(401);
    echo json_encode ([
        "success" => false,
        "error" => "credenciales inválidas"
    ], JSON_UNESCAPED_UNICODE);
    $consulta->close();
    $conexion->close();
    exit();

} catch (Throwable $e) {
    error_log($e->__toString());

    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => "error interno del servidor" 
    ], JSON_UNESCAPED_UNICODE);
    exit();
}

