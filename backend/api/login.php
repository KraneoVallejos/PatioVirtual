<?php
session_start();

// Verificar si se ha enviado el formulario con método POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../frontend/index.php?error=1");
    exit();
}

// Recuperar datos del formulario
$correo = trim($_POST["correo"]);
$contrasena = $_POST["contrasena"];

if (!$correo || !$contrasena) {
    header("Location: ../../frontend/index.php?error=1");
    exit();
}
require_once "../db/conexion.php";

// Consulta SQL preparada para verificar credenciales y evitar inyecciones SQL    
$sql = "SELECT id_usuario, contrasena, nombre FROM usuario WHERE correo=?";
$consulta = $conexion->prepare($sql);

// Confirmación de consulta SQL
if (!$consulta) {
    $conexion->close();
    header("Location: ../../frontend/index.php?error=1");
    exit();
}
$consulta->bind_param('s', $correo);
$consulta->execute();
$consulta->store_result();

// si la verificación resulta correcta se redirige a página de bienvenida
if ($consulta->num_rows === 1) {
    $consulta->bind_result($id_usuario, $hashed_password, $nombre);
    $consulta->fetch();

    //verificar hash
    if (is_string($hashed_password) && password_verify($contrasena, $hashed_password)) {
        session_regenerate_id(true);
        $_SESSION["id_usuario"] = $id_usuario;
        $_SESSION["usuario"] = $nombre;
        $_SESSION["correo"] = $correo;

        $consulta->close();
        $conexion->close();
        header("Location: ../../frontend/iniciocorrecto.php");
        exit();
    }
}
$consulta->close();
$conexion->close();
header("Location: ../../frontend/index.php?error=1");
exit();
