# Descripción

Este módulo contiene el archivo conexion.php:
 el cual permite la conexión entre
 el servidor y la base de datos MySQL


# INFORMACIÓN IMPORTANTE SOBRE conexion.php

este archivo contiene credenciales genéricas y deben ser modificadas antes de ser utilizado

## Antes de modificar los datos

- mantener conexion.php fuera del control de versiones o utilizar .gitignore
- Modifica las constantes con los datos reales de tu base de datos

El propósito de este archivo es centralizar los parametros de conexión:
- `host`
- `usuario`
- `contraseǹa`
- `base de datos`

## Scripts relacionados
los siguientes archivos dependen de la conexión proporcionada por `conexion.php`:

- `login.php`
- `crearusuario.php`
- `guardarmensaje.php`
- `cargarmensajes.php`

