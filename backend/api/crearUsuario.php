<?php
//generar conexión

require_once "conexion.php";

// Verificar conexión

if ($conexion->connect_error) {
	die("Error de conexión a la base de datos: " . $conexion->connect_error);
} else {
	echo "conectado a servidor!<br>";
}

// Verificar envío de formulario

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Recuperar datos del formulario y evitar inyecciones SQL con real_escape_string

	$nombre = $conexion->real_escape_string($_POST['nombre']);
	$apellpat = $conexion->real_escape_string($_POST['apellpat']);
	$apellmat = $conexion->real_escape_string($_POST['apellmat']);
	$correo = $conexion->real_escape_string($_POST['correo']);
	$carrera = $conexion->real_escape_string($_POST['carrera']);
	$contrasena = $conexion->real_escape_string($_POST['contrasena']);
	echo " Datos POST recuperados!!<br>";

	// consulta preparada con store_result() para verificar correo existente

	$sql = "SELECT id_usuario FROM usuario WHERE correo = ?";
	$stmt = $conexion->prepare($sql);
	$stmt->bind_param("s", $correo);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		echo "Este correo electrónico ya está registrado.<br>";
		echo "$correo";
		echo '<form>';
		echo '<button type="submit">Aceptar</button>';
		echo '</form>';
		$stmt->close();
		exit;
	} else {
		echo "El correo electrónico es válido.<br>";
	}

	// Hash de contraseña
	$hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
	echo "Hash de contraseña exitoso!!!<br>".$hashed_contrasena."<br>";

	// Consulta SQL preparada para crear usuario y evitar inyecciones SQL
	$sql = "INSERT INTO usuario (nombre, apellpat, apellmat, correo, carrera, contrasena) VALUES (?, ?, ?, ?, ?, ?)";
	$consulta = $conexion->prepare($sql);
	$consulta->bind_param('ssssss', $nombre, $apellpat, $apellmat, $correo, $carrera, $hashed_contrasena);

	if ($consulta->execute()) {
		echo "usuario agregado con éxito!";
		echo '<form action="index.php">';
		echo '<button type="submit">Aceptar</button>';
		echo '</form>';
	} else {
		echo "error !!!" . $consulta->error . "<br>";
	}
} else {
	echo date('H:i:s');
}
?>
<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="estilos.css" />
	<title>CREAR USUARIO</title>
</head>

<body>

	<h1>BIENVENIDO!!</h1>
	<h2>Regístrate</h2>

	<div>
	<p> Ingresa tu nombre completo, tu correo institucional y una contraseña</p>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

		<label for="nombre">nombre</label><br>
		<input type="text" id="nombre" name="nombre" placeholder = "nombre... " required>
		<br>
		<br>
		<label for="apellpat">primer apellido</label><br>
		<input type="text" id="apellpat" name="apellpat" placeholder = "primer apellido... " required>
		<br>
		<br>
		<label for="apellmat">segundo apellido</label><br>
		<input type="text" id="apellmat" name="apellmat" placeholder = "segundo apellido... " required>
		<br>
		<br>
		<label for="correo">correo electrónico</label><br>
		<input type="text" id="correo" name="correo"  placeholder = "nombre@email.com..." required>
		<br>
		<br>
		<label for="carrera">Selecciona carrera</label><br><br>
        <select id="carrera" name="carrera" required>
            <option value="">--Seleccione--</option>
            <?php
            $res = $conexion->query("SELECT nombre_carrera FROM carreras");
            while ($fila = $res->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($fila['nombre_carrera']) . "'>" . htmlspecialchars($fila['nombre_carrera']) . "</option>";
            }
            ?>
        </select><br><br>

		<label for="contrasena">crea una contraseña</label><br>
		<input type="password" id="contrasena" name="contrasena" autocomplete="off" required>
		<br>
		<p> Verifica tus datos y presiona confirmar</p>
		<button type="submit">confirmar</button>
	</form>

	<form action="index.php">
				<p> Si ya tienes cuenta puedes volver a la página de inicio</p>
		<button type="submit">volver al inicio</button>
	</form>
	</div>

</body>

</html>