SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "-04:00";

-- Base de datos: `patiovirtual`
CREATE DATABASE IF NOT EXISTS `patiovirtual`
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `patiovirtual`;

-- Estructura de tabla para la tabla `usuario`

CREATE TABLE `usuario` (
    `id_usuario` INT AUTO_INCREMENT NOT NULL,
    `nombre` VARCHAR(30) NOT NULL,
    `apellpat` VARCHAR(30) NOT NULL,
    `apellmat` VARCHAR(30) NOT NULL,
    `correo` VARCHAR(255) NOT NULL UNIQUE,
    `carrera` VARCHAR(30) NOT NULL,
    `categoria` ENUM(
        'estudiante',
        'profesor',
        'moderador'
    ) DEFAULT 'estudiante',
    `contrasena` VARCHAR(255),
    PRIMARY KEY (`id_usuario`)
);

CREATE TABLE correos_autorizados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE `mensajes` (
    `id_mensajes` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `remitente_id` INT NOT NULL,
    `mensaje` VARCHAR(255) NOT NULL,
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `estado` ENUM('pendiente', 'respondido') DEFAULT 'pendiente',
    FOREIGN KEY (`remitente_id`)
    REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `carreras` (
    `id_carrera` INT AUTO_INCREMENT NOT NULL,
    `nombre_carrera` VARCHAR(100) NOT NULL UNIQUE,
    PRIMARY KEY (`id_carrera`)
);
-- --------------------------------------------------------
INSERT INTO carreras (nombre_carrera) VALUES
('Técnico en Marketing Digital'),
('Técnico en Logística'),
('Contabilidad General'),
('Técnico en Recursos Humanos'),
('Técnico en Administración de Empresas'),
('Técnico en Administración Pública'),
('Técnico en Construcción ¡Nueva!'),
('Técnico en Control Industrial'),
('Técnico en Gestión de calidad y Ambiente'),
('Técnico en Procesos Mineros'),
('Técnico en Prevención de Riesgos'),
('Técnico en Informática'),
('Técnico en Automatización y Control'),
('Técnico en Análisis y Programación Computacional'),
('Técnico en Análisis de Datos'),
('Técnico en Ciberseguridad'),
('Técnico Jurídico'),
('Técnico en Trabajo Social'),
('Técnico en Educación Parvularia'),
('Técnico en Educación Diferencial');

INSERT INTO carreras (nombre_carrera) VALUES
('Ingeniería en Logística'),
('Contador Auditor'),
('Ingeniería en Recursos Humanos'),
('Ingeniería en Administración de Empresas'),
('Administración Pública'),
('Ingeniería en Seguridad Privada ¡Nueva!'),
('Ingeniería Industrial'),
('Ingeniería en Gestión de calidad y Ambiente'),
('Ingeniería en Minas'),
('Ingeniería en Prevención de Riesgos'),
('Ingeniería en Informática'),
('Ingeniería en Automatización y Control'),
('Ingeniería en Ciberseguridad'),
('Psicopedagogía'),
('Trabajo Social ¡Nueva!');

INSERT INTO carreras (nombre_carrera) VALUES
('Ingeniería en Logística - Continuidad de Estudios'),
('Contador Auditor - Continuidad de Estudios'),
('Ingeniería en Recursos Humanos - Continuidad de Estudios'),
('Ingeniería en Administración de Empresas - Continuidad de Estudios'),
('Ingeniería Industrial - Continuidad de Estudios'),
('Ingeniería en Gestión de calidad y Ambiente - Continuidad de Estudios'),
('Ingeniería en Minas - Continuidad de Estudios'),
('Ingeniería en Prevención de Riesgos - Continuidad de Estudios'),
('Ingeniería en Informática - Continuidad de Estudios'),
('Ingeniería en Automatización y Control - Continuidad de Estudios'),
('Ingeniería en Ciberseguridad - Continuidad de Estudios');
