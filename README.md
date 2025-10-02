# Proyecto Patio Virtual

## Descripción

Plataforma de comunicación escrita en tiempo real de tipo chat, orientada a facilitar la comunicación en entornos educativos asincrónicos

## Objetivos del proyecto:

* Complementar plataformas educativas asincrónicas existentes
* Promover el aprendizaje significativo mediante comunicación efectiva entre estudiantes y docentes
* Facilitar el acceso a la comunicación e información por medio de una interfaz accesible multiplataforma (web y app Android)

## Estructura General del proyecto ( Carpetas y Módulos)

PatioVirtual/
│
│   README.md 			-> Información general del proyecto
│
├───app/
│       README.md 		-> Documentación de la aplicación Android
│
├───backend/			-> Servidor local en PHP (XAMPP)
│   │   index.php
│   │   README.md
│   │
│   ├───api/			-> Endpoints de la API REST
│   │       cargarmensajes.php
│   │       crearUsuario.php
│   │       guardarmensaje.php
│   │       login.php
│   │       logout.php
│   │       README.md
│   │
│   └───db/			-> Conexión y base de datos MySQL
│           conexion.php
│           patiovirtualBD.sql
│           README.md
│
├───docs/			-> Documentación técnica y de arquitectura
│       arquitectura.md
│       README.md
│
└───frontend/			-> Interfaz web del sistema
        estilos.css
        iniciocorrecto.php
        README.md

## Tecnologías utilizadas

* Android Studio ( kotlin + XML) 	-> desarrollo de app Patio Virtual versión móvil
* XAMPP (PHP + MySQL) 		-> Backend local, base de datos y API REST
* AJAX (Fetch API) 			-> Peticiones asincrónicas al backend
* FRONTED WEB (HTML + CSS) 		-> Interfaz web responsiva
* Git + GitHub 			-> control de versiones

## Autor

* Ariel Vallejos Martínez
* GitHub: \[@KraneoVallejos](https://github.com/KraneoVallejos)

### Estado del proyecto:
- El proyecto aún se encunetra en desarrollo
- versión web inicial para pruebas locales con XAMPP

