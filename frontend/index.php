<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="estilos.css" />
	<title>PATIO VIRTUAL - LOGIN</title>
</head>

<body>
	<h1>Bienvenido!</h1>
	
	<div class="contenedor centrado">
		<h2>Inicia sesión</h2>
		<form class="formulario centrado" id="formCredencial" method ="post">
			<label for="correo">Ingresa tu correo institucional</label>
			<input type="email" id="correo" name="correo" maxlength="50" placeholder="ejemplo@institucion.cl..." required>
			
			<label for="contrasena">Ingresa tu contraseña</label>
			<input type="password" id="contrasena" name="contrasena" maxlength="30" placeholder="contraseña..." required>
			
			<button type="submit">INICIAR SESIÓN</button>
		</form>
		<div class="informacion" id="info_estado"></div>

	</div>
	
	<div class="contenedor centrado">
		<h2>Crear nuevo usuario</h2>
		<form class="formulario centrado" action="crearUsuario.php" method="get">
			<button type="submit">REGISTRARSE</button>
		</form>
	</div>

	<script>
		
		const infoEstado = document.getElementById("info_estado");
		
		function limpiarInfo() {
			infoEstado.innerHTML = "";
			infoEstado.style.display = "none";
		}

		function mostrarInfo(mensaje) {
			infoEstado.style.display = "flex";
			infoEstado.innerHTML = `<p>⚠️ ${mensaje}</p>`;
			setTimeout(limpiarInfo, 3000);
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
					return;
				}

				window.location.href= "iniciocorrecto.php";

			} catch (error) {
				console.error(error);
				mostrarInfo(`error en la conexión con el servidor : ${error.message}`);				
			}
		}
		document.getElementById("formCredencial").addEventListener("submit", loginUsuario);

	</script>
</body>

</html>