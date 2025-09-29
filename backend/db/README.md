# Módulo Base de datos - Patio Virtual

## Contenido:
- Archivo `patiovirtualBD.sql`: scripts para la creación de la base de datos de Patio Virtual
- Archivo `conexion.php`: el cual permite la conexión entre el servidor y la base de datos MySQL
- Información sobre utilización correcta y segura del archivo conexion.php
- instrucciones sobre la creación de la base de datos para el correcto funcionameinto del sistema

# conexion.php : INFORMACIÓN IMPORTANTE

este archivo contiene credenciales genéricas y deben ser modificadas antes de ser utilizado

## Antes de modificar los datos

- mantener conexion.php fuera del control de versiones o utilizar .gitignore
- Modifica las constantes con los datos reales de tu base de datos
- Nunca subas conexion.php con tus credenciales reales al repositorio

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

# patiovirtualBD.sql : BASE DE DATOS DE PATIO VIRTUAL

El script permite crear, inicializar y conectar la base de datos del proyecto, la cual contiene:
- Tablas de Usuarios, mansajes y carreras
- Relaciones y restricciones
- Listado de carreras incluidos como ejemplos para el registro de usuarios

## Instrucciones:

1. abre tu consola MySQL (phpMyAdmin. MySQL Workbench, etc.)
2. puedes tanto copiar el script y ejecutarlo en tu consola, como importar directamente el archivo `patiovirtualBD.sql`
3. Asegurate que la base de datos se llame `patiovirtual`, ya que es el nombre que espera el archivo conexion.php
