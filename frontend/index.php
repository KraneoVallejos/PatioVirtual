<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos.css"/>
	<title>Iniciar sesión</title>
</head>
<body>
	<h2>Bienvenido! inicia sesión</h2>
	<div>
		<form action="../backend/api/login.php" method="post">
			<label for="correo" >ingresa correo institucional</label><br>
			<input type="email" id="correo" name="correo" required>
			<br>
			<label for="contrasena">contraseña</label><br>
			<input type="password" id="contrasena" name="contrasena" required>
			<br>
			<br>
			<button type="submit">INICIO SESIÓN</button>
		</form>
	</div>

	<div>
	<h2>Crear nuevo usuario</h2>
		<form action="crearUsuario.php">
		<button type="submit">crear nuevo registro</button>
		</form>

</body>
</html>
