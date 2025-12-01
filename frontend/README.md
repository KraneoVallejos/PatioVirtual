# Módulo Frontend - Patio Virtual

Descripción:

Este módulo representa la interfaz web principal del sistema Patio Virtual.

Contiene las diferentes vistas del sistema, las cuales permitirán al usuario:

	- iniciar sesión o crear un nuevo registro.
	- enviar y recibir mensajes en tiempo real.

Desde aquí se interactua con los servicios del backend como las API y Base de datos:

API:
	- Autenticación: para el control de acceso e inicio de sesión.
	- carga de mensajes: los mensajes se cargan desde la base de datos posterior a la autenticación del usuario.
	- almacenamiento de mensajes: los mensajes enviados son guardados en la base de datos y mostrados en la pantalla principal del usuario logueado.
	- cierre de sesión: encargada de cerrar la sesión activa de forma segura.

Base de Datos:
	- contiene las tablas que permiten el almacenamiento de información de diferente índole tales como:
		- correos autorizados para la creación de nuevos registros  de usuario
		- registro completo de datos de usuario para el inicio de sesión
		- almacenamiento de mensajes asociado a remitente y ordenados cronologicamente para otorgar coherencia a la conversación 

## Objetivos

- Proveer un canal de comunicación sincrónica, con acceso desde navegadores web modernos
- Orientado a facilitar la usabilidad e incrementar la accesibilidad a la comunicación y a la información mediante una interfaz simple.


## Contenido

archivo: `index.php`: 

	- Página de inicio, el usuario puede iniciar sesión (con credenciales autorizadas) o bien crear un nuevo registro.

archivo: `crearUsuario`:

	- Página para la creación y almacenamiento de un nuevo registro de usuario (siempre y cuando su correo se encuentre previamente autorizado).

archivo: `iniciocorrecto.php`:

	- Verifica si el usuario está autenticado antes de permitir el acceso a la vista.
	- Tras un login exitoso la página muestra los mensajes almacenados en la base de datos.
	- El usuario puede enviar y recibir mensajes en tiempo real.

archivo: `estilos.css`:

	- define el estilo visual de la interfaz
	- aplica estilos personalizados a los elementos HTML
	- permite visualizar la plataforma en dispositivos con diferentes tamaños de pantalla.

