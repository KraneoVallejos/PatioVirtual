<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require_once "../backend/db/conexion.php";
?>

<!DOCTYPE html>

<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="estilos.css" />
	<title>CREAR USUARIO</title>
</head>

<body>

	<h1>Regístrate:</h1>

	<p> Ingresa tu nombre completo, tu correo institucional y una contraseña. Si ya tienes cuenta puedes <a href="index.php">volver al inicio</a></p>

	<div class="contenedor">
		
		<form class="formulario izquierda" id="formRegistro" method="post">

			<label for="nombre">nombre</label>
			<input type="text" id="nombre" name="nombre" placeholder = "nombre... " required maxlength="30">
			
			
			<label for="apellpat">primer apellido</label>
			<input type="text" id="apellpat" name="apellpat" placeholder = "primer apellido... " required maxlength="30">
			
			
			<label for="apellmat">segundo apellido</label>
			<input type="text" id="apellmat" name="apellmat" placeholder = "segundo apellido... " required maxlength="30">
			
			
			<label for="correo">correo electrónico</label>
			<input type="email" id="correo" name="correo"  placeholder = "ejemplo@institución.cl..." required maxlength="50">
			
			
			<label for="carrera">selecciona tu carrera</label>
			<select id="carrera" name="carrera" required>
				<option value=""> - - Carreras - - </option>
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
			</select>

			<label for="contrasena">crea una contraseña</label>
			<input type="password" id="contrasena" name="contrasena" autocomplete="off" placeholder="contraseña..." maxlength="30" required>
			
			<p> Verifica tus datos y presiona confirmar</p>
			<button type="submit">CONFIRMAR</button>
		</form>
		<div class="informacion"  id="info_estado"></div>
	</div>

<!-- Consulta con método AJAX para enviar y almacenar datos de nuevo usuario en BD -->
	<script>

		const infoEstado = document.getElementById("info_estado");

		function limpiarInfo() {
			infoEstado.innerHTML = "";
			infoEstado.style.display = "none";
		}

		function mostrarInfo(mensaje) {
			infoEstado.style.display = "flex";
			infoEstado.innerHTML = `<p>⚠️ ${mensaje}</p>`;
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