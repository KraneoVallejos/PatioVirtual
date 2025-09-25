# Arquitectura Técnica - Proyecto Patio Virtual

En el presente documento se describe la arquitectuta general del sistema Patio Virtual.

- Diseñada para entornos de educación asincrónica, como herramienta complementaria de comunicación, mediante una plataforma con chat en tiempo real.

## Componentes Principales

### 1. Frontend Web

- **Lenguajes**: HTML, CSS, JavaScript
- **Frameworks**: Bootstrap
- **Funcionalidad**: Interfaz de usuario (docentes, estudiantes)
	- Login
	- Creación de nuevo usuario
	- Historial de mensajes
	- Formulario de envío de mensajes
-**Ubicación**: `/frontend`

### 2. Backend

-**Lenguajes**: PHP
-**Servidor**: Apache (XAMPP)
-**Base de datos**: MySQL
-**Funcionalidad**: Procesamiento de peticiones, autenticación, validaciones, almacenamiento y recuperación de datos.
-**Ubicación**: `/backend`

