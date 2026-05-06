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
    <title>PATIO VIRTUAL - CHAT</title>

</head>

<body>

    <h1>PATIO VIRTUAL</h1>

    <div class="contenedor centrado">
        <h1>Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h1>
        <p>Has iniciado sesión correctamente.</p>
    
        <!-- Cerrar sesión -->
        <form action="../backend/api/logout.php" method="post">
            <button type="submit">CERRAR SESIÓN</button>
        </form>
    </div>

    <!-- Contenedor historial de mensajes -->
    <div class="contenedor mensajes" id="mensajes"></div>

    <!-- ventana usuario editar mensajes -->
    <div class="contenedor nuevo_mensaje" id="mensajes_usuario">

        <form id="form_nuevo_mensaje">
            <textarea name="mensaje" placeholder="Escribe tu mensaje..." required maxlength="255"></textarea>
            <button type="submit">ENVIAR</button>
        </form>

    </div>

    <!--Contenedor informativo de estado de solicitudes del usuario-->
    <div class="informacion" id="info_estado"></div>
    


<!-- función con Consulta AJAX para cargar mensajes desde el servidor-->
<script>

    const infoEstado = document.getElementById("info_estado");

    function limpiarEstado() {
        infoEstado.innerHTML = "";
        infoEstado.style.display ="none";
    }

    function mostrarInfo(mensaje) {
        infoEstado.style.display ="block";
        infoEstado.innerHTML = `<p>${mensaje}</p>`;
        setTimeout(limpiarEstado,3000);
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
                mostrarInfo(data.error);
                return;
            }
                       
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
                mostrarInfo(`Error al cargar mensajes: ${error.message}`);
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
                mostrarInfo(data.error);
                return;
            }

            formulario.reset();
            cargarMensajes();

        } catch (error) {
            mostrarInfo(`Error de conexión: ${error.message}`);
        }
    }
    document.getElementById("form_nuevo_mensaje").addEventListener("submit", guardarMensaje);
    
    // intervalo de Actualización de Mensajes 
    setInterval(cargarMensajes, 5000);
    cargarMensajes();
</script>

</body>

</html>