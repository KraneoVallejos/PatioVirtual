<?php

session_start();
require_once "conexion.php";

// Verificación de inicio de sesión
if (!isset($_SESSION["usuario"])) {
    echo "Por favor inicia sesión, serás redirigido...";
    header("Refresh:3; url=index.php");
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
    <form action="logout.php" method="post">
        <button type="submit">Cerrar sesión</button>
    </form>

    <!-- Contenedor Principal -->

        <h1>PATIO VIRTUAL</h1>

        <!-- Contenedor historial de mensajes -->
        <div id="mensajes"></div>

        <!-- ventana usuario editar mensajes -->
        <div id="mensajes_usuario">

            <form id="form_nuevo_mensaje">
                <textarea name="mensaje" placeholder="Escribe tu mensaje..." required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>  

    <!-- función con Consulta AJAX para cargar mensajes desde el servidor-->
    <script>
        function cargarMensajes() {

            fetch("cargarmensajes.php")
                .then(res => res.json())
                .then(data => {
                    const box = document.getElementById("mensajes");
                    if (data.success){
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
            
            box.innerHTML = html;
            
            // requestAnimationFrame ayuda a “esperar el pintado” antes de hacer el scroll.
            // elemento.scrollTo({top: y, left: x})  método del DOM que mueve el scroll dentro de un elemento contenedor
            
            requestAnimationFrame(()=> {
                box.scrollTo({ top : box.scrollHeight, behavior: "smooth"});
            });

            
        }else{document.getElementById("mensajes").innerHTML = `<p>Error: ${data.error}</p>`;
            }
        })
        .catch(err => {
            document.getElementById("mensajes").innerHTML = `<p>Error al cargar mensajes: ${err}</p>`;
        });
        }
        
        //Consulta AJAX con FormData para envío de mensajes hacia el servidor

        document.getElementById("form_nuevo_mensaje").addEventListener("submit", function(e) {
            e.preventDefault();
            const formdata = new FormData(this);
            fetch("guardarmensaje.php", {
                    method: "POST",
                    body: formdata
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.reset();
                        cargarMensajes();
                    } else {
                        alert("Error: " + data.error);
                    }
                });
        });

        // intervalo de Actualización de Mensajes 
        setInterval(cargarMensajes, 5000);
        cargarMensajes();
    </script>

</body>

</html>