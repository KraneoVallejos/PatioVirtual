<?php
session_start();
session_unset(); // Limpia variables de sesión
session_destroy(); // Destruye la sesión

header("Location: ../../frontend/index.php");
exit();
