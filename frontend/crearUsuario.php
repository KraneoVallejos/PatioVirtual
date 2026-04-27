<?php
require_once "../backend/db/conexion.php";
?>

<!DOCTYPE html>

<html lang="es">

<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="estilos.css" />
	<title>CREAR USUARIO</title>
</head>

<body>

	<h1>Regístrate:</h1>

	<p> Ingresa tu nombre completo, tu correo institucional y una contraseña.
		 Si ya tienes cuenta puedes <a href="index.php">volver al inicio</a>
	</p>

	<div>
		
		<form id="formRegistro" method="post">

			<label for="nombre">nombre</label><br>
			<input type="text" id="nombre" name="nombre" placeholder = "nombre... " required maxlength="30">
			<br>
			<br>
			<label for="apellpat">primer apellido</label><br>
			<input type="text" id="apellpat" name="apellpat" placeholder = "primer apellido... " required maxlength="30">
			<br>
			<br>
			<label for="apellmat">segundo apellido</label><br>
			<input type="text" id="apellmat" name="apellmat" placeholder = "segundo apellido... " required maxlength="30">
			<br>
			<br>
			<label for="correo">correo electrónico</label><br>
			<input type="email" id="correo" name="correo"  placeholder = "nombre@email.com..." required maxlength="50">
			<br>
			<br>
			<label for="carrera">Selecciona carrera</label><br>
			<select id="carrera" name="carrera" required>
				<option value="">--Seleccione--</option>
				<?php
				$res = $conexion->query("SELECT nombre_carrera FROM carreras");
				while ($fila = $res->fetch_assoc()) {
					echo "<option value='" . htmlspecialchars($fila['nombre_carrera'], ENT_QUOTES, 'UTF-8') . "'>"
					. htmlspecialchars($fila['nombre_carrera'], ENT_QUOTES, 'UTF-8') 
					. "</option>";
				}
				$res->free();
				$conexion->close();
				?>
			</select><br><br>

			<label for="contrasena">crea una contraseña</label><br>
			<input type="password" id="contrasena" name="contrasena" autocomplete="off" required maxlength="30">
			<br>
			<p> Verifica tus datos y presiona confirmar</p>
			<p id="info_estado"></p>
			<button type="submit">confirmar</button>
		</form>
	</div>

<!-- Consulta con método AJAX para enviar y almacenar datos de nuevo usuario en BD -->
	<script>

		const infoEstado = document.getElementById("info_estado");

		function limpiarInfo() {
			infoEstado.innerHTML = "";
		}

		function mostrarInfo(mensaje) {
			infoEstado.innerHTML = `<p>${mensaje}</p>`;
			setTimeout(limpiarInfo,3000);
		}
		
		async function registrarUsuario(e) {
			e.preventDefault();

			try {
				const formRegistro = e.target;
				const formdata = new FormData(formRegistro);
				const res = await fetch("../backend/api/registrarusuario.php", {
					method: "POST",
					body: formdata
				});

				const data = await res.json();

				if (!data.success) {
					mostrarInfo(data.error);					
					return;
				}

				mostrarInfo(data.mensaje);
				formRegistro.reset();
				window.location.href=("index.php")
								
			} catch (error) {
				mostrarInfo(`Error en el envío de datos: ${error.message}`);				
			}
		}
		document.getElementById("formRegistro").addEventListener("submit", registrarUsuario);
		
	</script>

</body>

</html>