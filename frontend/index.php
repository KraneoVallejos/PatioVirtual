<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos.css" />
	<title>Patio Virtual</title>
</head>

<body>
	<h2>Bienvenido! inicia sesión</h2>
	<div>
		<form id="formCredencial" method ="post">
			<label for="correo">ingresa correo institucional</label><br>
			<input type="email" id="correo" name="correo" maxlength="50" required>
			<br>
			<label for="contrasena">contraseña</label><br>
			<input type="password" id="contrasena" name="contrasena" maxlength="30" required>
			<br>
			<p id="info_estado"></p>
			<button type="submit">INICIO SESIÓN</button>
		</form>
	</div>

	
	
	<div>
		<h2>Crear nuevo usuario</h2>
		<form action="crearUsuario.php" method="get">
			<button type="submit">crear nuevo registro</button>
		</form>
	</div>

	<script>
		
		const infoEstado = document.getElementById("info_estado");
		
		function mostrarInfo(mensaje) {
			infoEstado.innerHTML = `<p>${mensaje}</p>`;
		}
		function limpiarInfo() {
			infoEstado.innerHTML = "";
		}

		async function loginUsuario(e) {
			e.preventDefault();

			try {
				const formCredencial = e.target;
				const formdata = new FormData(formCredencial);
				const res = await fetch("../backend/api/login.php", {
					method: "POST",
					body: formdata
				});

				const data = await res.json();

				if (!data.success) {
					mostrarInfo(data.error);
					setTimeout(limpiarInfo, 3000);
					return;
				}

				window.location.href= "iniciocorrecto.php";

			} catch (error) {
				console.error(error);
				mostrarInfo(`error en la conexión con el servidor : ${error.message}`);
				setTimeout(limpiarInfo, 3000);
			}
		}
		document.getElementById("formCredencial").addEventListener("submit", loginUsuario);

	</script>
</body>

</html>