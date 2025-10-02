<?php
session_start();
include "../backend/db/conexion.php";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario y evitar inyecciones SQL con real_escape_string
    $correo = $conexion->real_escape_string($_POST["correo"]);
    $contrasena = $_POST["contrasena"]; 

    // Consulta SQL preparada para verificar credenciales y evitar inyecciones SQL

    $sql = "SELECT id_usuario, contrasena, nombre FROM usuario WHERE correo=?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param('s', $correo);
    $consulta->execute();
    $consulta->store_result();

    // si la verificación resulta correcta se redirige a página de bienvenida

	if ($consulta->num_rows == 1) {
        $consulta->bind_result($id_usuario, $hashed_password, $nombre);
        $consulta->fetch();

        //verificar hash
        if(password_verify($contrasena, $hashed_password)){
            session_regenerate_id(true);
            $_SESSION["id_usuario"] = $id_usuario;
            $_SESSION["usuario"] = $nombre;
            $_SESSION["correo"] = $correo;
            header("Location: ../../frontend/iniciocorrecto.php");
        	exit;
        } else {
        header("Location: ../../frontend/index.php?error=1");
        }
    }else{
        header("Location: ../../frontend/index.php?error=1");
    }
    $consulta->close();
}
$conexion->close();
?>