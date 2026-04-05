<?php
define("SERVIDOR", "localhost"); //Servidor de base de datos (por defecto localhost)
define("USUARIO", "root"); // Usuario de la base de datos
define("PASSWORD", ""); //Contraseña del usuario
define("BD", "patiovirtual");

//generar conexión
$conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BD);

// Verificar la conexión
if ($conexion->connect_error) {
    throw new Exception("Error de conexión a la base de datos");
}
$conexion->set_charset("utf8mb4"); // Se establece el tipo de codificación a UTF-8