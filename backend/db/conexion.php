<?php
define("SERVIDOR","localhost"); //Servidor de base de datos (por defecto localhost)
define("USUARIO","usuario"); // Usuario de la base de datos
define("PASSWORD","contraseña"); //Contraseña del usuario
define("BD","patiovirtual");

//generar conexión
$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BD);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}
?>
