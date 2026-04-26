<?php

session_start();

// Verificación de inicio de sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION["usuario"];
$id_usuario = $_SESSION["id_usuario"];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="estilos.css" />
    <title>PATIO VIRTUAL</title>
</head>

<body>
    <div>
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h1>
        <p>Has iniciado sesión correctamente.</p>

    </div>
    <!-- Cerrar sesión -->
    <form action="../backend/api/logout.php" method="post">
        <button type="submit">Cerrar sesión</button>
    </form>

    <!-- Contenedor Principal -->

    <h1>PATIO VIRTUAL</h1>

    <!-- Contenedor historial de mensajes -->
    <div id="mensajes"></div>

    <!-- ventana usuario editar mensajes -->
    <div id="mensajes_usuario">

        <form id="form_nuevo_mensaje">
        
        <!--Párrafo informativo de estado de solicitudes del usuario-->
            <p id="info_estado"></p>
            <textarea name="mensaje" placeholder="Escribe tu mensaje..." required maxlength="255"></textarea>
            <button type="submit">Enviar</button>
        </form>
    
    </div>

<!-- función con Consulta AJAX para cargar mensajes desde el servidor-->
<script>

    const infoEstado = document.getElementById("info_estado");

    function mostrarError(mensaje) {
        infoEstado.innerHTML = `<p>${mensaje}</p>`;
    }

    function limpiarEstado() {
        infoEstado.innerHTML = "";
    }
    
    async function cargarMensajes() {
        const ventana_mensajes = document.getElementById("mensajes");

        try {
            const res = await fetch("../backend/api/cargarmensajes.php");

            if (res.status === 401) {
                window.location.href = "index.php";
                return;
            }

            const data = await res.json();

            if (!data.success){
                mostrarError(data.error);
                return;
            }
            
            limpiarEstado();
            
            let html = `<table>
                <tr>
                    <th>FECHA</th>
                    <th>REMITENTE</th>
                    <th>MENSAJE</th>
                    <th>ESTADO</th>
                </tr>`;
            
            data.mensajes.forEach(m => {
                html += `
                <tr>    
                    <td>${m.fecha}</td>
                    <td>${m.remitente}</td>
                    <td>${m.mensaje}</td>
                    <td>${m.estado}</td>
                </tr>`;
            });
            html += `</table>`;
            ventana_mensajes.innerHTML = html;

                // requestAnimationFrame ayuda a “esperar el pintado” antes de hacer el scroll.
                // elemento.scrollTo({top: y, left: x})  método del DOM que mueve el scroll dentro de un elemento contenedor

            requestAnimationFrame(() => {
                ventana_mensajes.scrollTo({
                    top: ventana_mensajes.scrollHeight,
                    behavior: "smooth"
                });
            });
            
        } catch(error) {
                mostrarError(`Error al cargar mensajes: ${error.message}`);
        }
    }

    //Consulta AJAX con FormData para envío de mensajes hacia el servidor

    async function guardarMensaje(e) {
        e.preventDefault();

        try {
            const formulario = e.target;
            const formdata = new FormData(formulario);
            const res = await fetch("../backend/api/guardarmensaje.php", {
                method: "POST",
                body: formdata
            });

            if (res.status === 401) {
                window.location.href = "index.php";
                return;
            }

            const data = await res.json();

            if (!data.success) {
                mostrarError(data.error);
                return;
            }

            formulario.reset();
            limpiarEstado();            
            cargarMensajes();

        } catch (error) {
            mostrarError(`Error de conexión: ${error.message}`);           
        }
    }
    document.getElementById("form_nuevo_mensaje").addEventListener("submit", guardarMensaje);
    
    // intervalo de Actualización de Mensajes 
    setInterval(cargarMensajes, 5000);
    cargarMensajes();
</script>

</body>

</html>