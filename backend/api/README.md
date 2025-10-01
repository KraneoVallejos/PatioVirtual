# Módulo API de Patio Virtual

## Descripción
Este módulo contiene todos los **scripts backend** gestionando todas las interacciones clave entre el usuario y la plataforma.

Estas incluyen:

### `login.php`:
Gestiona el acceso por medio de autenticación de credenciales alojadas en la base de datos.

### `logout.php`:
Cierra la sesión activa del usuario y limpia las variables de sesión

### `cargarmensajes.php`:
Gestiona la carga del historial de mensajes desde la BD

### `guardarmensaje.php`:
Encargada del almacenamiento de los nuevos mensajes en la base de datos

### `crearusuario.php`:
Permite crear registros de nuevos usuarios válidos para el sistema

Los archivos presentes constituyen *endpoints* de la API permitiendo:
- autenticación
- gestión de sesiones
- Comunicación en tiemnpo real entre participantes por medio de mensajería escrita
