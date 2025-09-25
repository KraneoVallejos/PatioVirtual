# Módulo Backend de Patio Virtual

## Descripción

Scripts y servicios básicos para el funcionamiento del servidor de Patio Virtual

Este módulo gestiona:
- Autenticación de usuarios
- Registro y almacenamiento de mensajes
- Comunicación con la Base de datos MySQL

## Requisitos

- PHP 8+
- XAMPP o servidor Apache
- MySQL

## Estructura

- `index.php` : punto de entrada
- `db/conexion.php` : conexión a la base de datos
- `api/` : scripts necesarios para login, registro de nuevos usuarios, envío y almacenamiento de mensajes
- `utils/` : funciones auxiliares reutilizables

## Instrucciones para ejecutar localmente

1. inicia Apache y MySQL desde XAMPP
2. ubica esta carpeta dentro de la carpeta `htdocs` de XAMPP
3. Accede desde tu navegador a `http://localhost/backend/index.php`



