<?php

session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

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
        <h2>Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h2>
    
        <!-- Cerrar sesión -->
        <form action="../backend/api/logout.php" method="post">
            <button type="submit">CERRAR SESIÓN</button>
        </form>
    </div>

    <!-- Contenedor historial de mensajes -->
    <div id="mensajes" class="contenedor mensajes">
        <table>
            <thead>
                <tr>
                    <th>HORA</th>
                    <th>REMITENTE</th>
                    <th>MENSAJE</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody id="tbody_mensajes"></tbody>
        </table>
    </div>

    <!-- ventana usuario editar mensajes -->
    <div id="mensajes_usuario" class="contenedor nuevo_mensaje">

        <form id="form_nuevo_mensaje">
            <textarea rows="1" name="mensaje" placeholder="Escribe tu mensaje..." required maxlength="255"></textarea>
            <button type="submit">ENVIAR</button>
        </form>
    </div>

    <!--Contenedor informativo de estado de solicitudes del usuario-->
    <div class="informacion" id="info_estado"></div>
    


<!-- función con Consulta AJAX para cargar mensajes desde el servidor-->
<script>

    const infoEstado = document.getElementById("info_estado");
    const mensajeLogin = sessionStorage.getItem("login_correcto")

    function limpiarEstado() {
        infoEstado.innerHTML = "";
        infoEstado.style.display ="none";
    }

    function mostrarInfo(mensaje) {
        infoEstado.style.display ="flex";
        infoEstado.innerHTML = `<p>${mensaje}</p>`;
        setTimeout(limpiarEstado,3000);
    }

    
    if(mensajeLogin){
        mostrarInfo(mensajeLogin);
        sessionStorage.removeItem("login_correcto");
    }
        
    async function cargarMensajes() {
        const cuerpo_mensaje = document.getElementById("tbody_mensajes");
        const contenedor_tabla_mensajes = document.getElementById("mensajes");


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
                       
            let contenido = "";
            
            data.mensajes.forEach(m => {
                contenido += `
                <tr>    
                    <td>${m.fecha}</td>
                    <td>${m.remitente}</td>
                    <td>
                        <div class="burbuja">${m.mensaje}</div>
                    </td>
                    <td>${m.estado}</td>
                </tr>`;
            });
            cuerpo_mensaje.innerHTML = contenido;

                // requestAnimationFrame ayuda a “esperar el pintado” antes de hacer el scroll.
                // elemento.scrollTo({top: y, left: x})  método del DOM que mueve el scroll dentro de un elemento contenedor
            
            requestAnimationFrame(() => {
                contenedor_tabla_mensajes.scrollTo({
                    top: contenedor_tabla_mensajes.scrollHeight,
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
    setInterval(cargarMensajes, 2000);
    cargarMensajes();
</script>

</body>

</html>