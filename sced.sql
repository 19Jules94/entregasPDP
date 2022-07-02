-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Xerado en: 05 de Nov de 2019 as 23:56
-- Version do servidor: 10.1.37-MariaDB
-- Version do PHP: 7.3.0

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sced`
--
DROP DATABASE IF EXISTS `sced` ;

CREATE DATABASE IF NOT EXISTS `sced` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `sced`;

--
-- Usuario perytavalley
--

DROP USER IF EXISTS 'toor'@'localhost';
CREATE USER 'toor'@'localhost' IDENTIFIED BY 'toor';

GRANT ALL PRIVILEGES ON `sced`.* TO 'toor'@'localhost' IDENTIFIED BY 'toor';

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion`
--

DROP TABLE IF EXISTS `accion`;
CREATE TABLE `accion` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) UNIQUE COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anhoacademico`
--

DROP TABLE IF EXISTS `anhoacademico`;
CREATE TABLE `anhoacademico` (
  `id` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `anho` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

DROP TABLE IF EXISTS `asignatura`;
CREATE TABLE `asignatura` (
  `id` int(10) NOT NULL,
  `id_TITULACION` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_DEPARTAMENTO` int(10) NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `contenido` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `creditos` double(5,1) NOT NULL,
  `tipo` enum('OB','OP','FB') COLLATE utf8_spanish_ci NOT NULL,
  `horas` double(5,1) NOT NULL,
  `cuatrimestre` enum('1','2') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

DROP TABLE IF EXISTS `centro`;
CREATE TABLE `centro` (
  `id` int(10) NOT NULL,
  `id_UNIVERSIDAD` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
   UNIQUE KEY `uniq_centro` (`nombre`,`id_UNIVERSIDAD`),
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento` (
  `id` int(10) NOT NULL, 
  `id_CENTRO` int(10) NOT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
   UNIQUE KEY `uniq_dep` (`codigo`,`id_CENTRO`),
   UNIQUE KEY `uniq_dep_2` (`nombre`,`id_CENTRO`),
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificio`
--

DROP TABLE IF EXISTS `edificio`;
CREATE TABLE `edificio` (
  `id` int(10) NOT NULL,
  `id_UNIVERSIDAD` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  CONSTRAINT UQ_EDIFICIO UNIQUE (id_UNIVERSIDAD,nombre,ubicacion)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacio`
--

DROP TABLE IF EXISTS `espacio`;
CREATE TABLE `espacio` (
  `id` int(10) NOT NULL,
  `id_EDIFICIO` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('Aula','Despacho') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  CONSTRAINT UQ_ESPACIO UNIQUE (id_EDIFICIO,nombre,tipo)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionalidad`
--

DROP TABLE IF EXISTS `funcionalidad`;
CREATE TABLE `funcionalidad` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) UNIQUE COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ASIGNATURA` int(10) NOT NULL,
  `id_TITULACION` int(10) NOT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('GA','GB','GC') COLLATE utf8_spanish_ci NOT NULL,
  `horas` double(5,1) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_ESPACIO` int(10) NOT NULL,
  `id_GRUPO` int(10) DEFAULT NULL,
  `id_ASIGNATURA` int(10) NOT NULL,
  `id_TITULACION` int(10) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `asistencia` enum('Si','No','Pendiente') COLLATE utf8_spanish_ci NOT NULL,
  `dia` enum('lunes','martes','miercoles','jueves','viernes') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

DROP TABLE IF EXISTS `profesor`;
CREATE TABLE `profesor` (
  `dni` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_DEPARTAMENTO` int(10) NOT NULL,
  `dedicacion`varchar(10) COLLATE utf8_spanish_ci NOT NULL,

  -- `dedicacion` enum('TC','P1','P2','P3','P4','P5','P6') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) UNIQUE COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

DROP TABLE IF EXISTS `rol_permiso`;
CREATE TABLE `rol_permiso` (
  `id_ROL` int(10) NOT NULL,
  `id_FUNCIONALIDAD` int(10) NOT NULL,
  `id_ACCION` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulacion`
--

DROP TABLE IF EXISTS `titulacion`;
CREATE TABLE `titulacion` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_CENTRO` int(10) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL, 
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutoria`
--

DROP TABLE IF EXISTS `tutoria`;
CREATE TABLE `tutoria` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ESPACIO` int(10) NOT NULL,
  `asistencia` enum('Si','No', 'Pendiente') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidad`
--

DROP TABLE IF EXISTS `universidad`;
CREATE TABLE `universidad` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) UNIQUE COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `dni` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

DROP TABLE IF EXISTS `usuario_rol`;
CREATE TABLE `usuario_rol` (
  `id_USUARIO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ROL` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
--
-- Indices para tablas volcadas
--

--
-- Indices de la tabla `accion`
--
ALTER TABLE `accion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `anhoacademico`
--
ALTER TABLE `anhoacademico`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`, `id_TITULACION`),
  ADD UNIQUE KEY `codigo` (`codigo`,`id_ANHOACADEMICO`);


--
-- Indices de la tabla `centro`
--
ALTER TABLE `centro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `edificio`
--
ALTER TABLE `edificio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `funcionalidad`
--
ALTER TABLE `funcionalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`, `id_ASIGNATURA`, `id_TITULACION`),
  ADD UNIQUE KEY `codigo` (`codigo`,`id_TITULACION`);


--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`,`id_GRUPO`,`id_ASIGNATURA`, `id_TITULACION`);


--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`dni`);
--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`id_ROL`,`id_FUNCIONALIDAD`,`id_ACCION`);

--
-- Indices de la tabla `titulacion`
--
ALTER TABLE `titulacion`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD UNIQUE KEY `codigo` (`codigo`,`id_ANHOACADEMICO`);
--
-- Indices de la tabla `tutoria`
--
ALTER TABLE `tutoria`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`,`id_PROFESOR`);

--
-- Indices de la tabla `universidad`
--
ALTER TABLE `universidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`dni`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`id_USUARIO`,`id_ROL`);


-- ----------------------------------------------------
--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion`
--
ALTER TABLE `accion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `edificio`
--
ALTER TABLE `edificio`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `espacio`
--
ALTER TABLE `espacio`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `funcionalidad`
--
ALTER TABLE `funcionalidad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `titulacion`
--
ALTER TABLE `titulacion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tutoria`
--
ALTER TABLE `tutoria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `universidad`
--
ALTER TABLE `universidad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;


-- -----------------------------------------------
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `asignatura_ibfk_1` FOREIGN KEY (`id_TITULACION`,`id_ANHOACADEMICO`) REFERENCES `titulacion` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `asignatura_ibfk_2` FOREIGN KEY (`id_DEPARTAMENTO`) REFERENCES `departamento` (`id`),
  ADD CONSTRAINT `asignatura_ibfk_3` FOREIGN KEY (`id_PROFESOR`) REFERENCES `profesor` (`dni`),    
  ADD CONSTRAINT `asignatura_ibfk_4` FOREIGN KEY (`id_ANHOACADEMICO`) REFERENCES `anhoacademico` (`id`);


--
-- Filtros para la tabla `centro`
--
ALTER TABLE `centro`
  ADD CONSTRAINT `centro_ibfk_1` FOREIGN KEY (`id_UNIVERSIDAD`) REFERENCES `universidad` (`id`),
  ADD CONSTRAINT `centro_ibfk_2` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`dni`) ;  

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`id_CENTRO`) REFERENCES `centro` (`id`);

--
-- Filtros para la tabla `edificio`
--
ALTER TABLE `edificio`
  ADD CONSTRAINT `edificio_ibfk_1` FOREIGN KEY (`id_UNIVERSIDAD`) REFERENCES `universidad` (`id`);

--
-- Filtros para la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD CONSTRAINT `espacio_ibfk_1` FOREIGN KEY (`id_EDIFICIO`) REFERENCES `edificio` (`id`);

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`id_ASIGNATURA`, `id_ANHOACADEMICO`, `id_TITULACION`) REFERENCES `asignatura` (`id`, `id_ANHOACADEMICO`, `id_TITULACION`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario` 
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_ESPACIO`) REFERENCES `espacio` (`id`),
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`id_GRUPO`,`id_ANHOACADEMICO`, `id_ASIGNATURA`, `id_TITULACION`) REFERENCES `grupo` (`id`, `id_ANHOACADEMICO`, `id_ASIGNATURA`, `id_TITULACION`),
  ADD CONSTRAINT `horario_ibfk_3` FOREIGN KEY (`id_PROFESOR`) REFERENCES `profesor` (`dni`);
;

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`id_DEPARTAMENTO`) REFERENCES `departamento` (`id`),
  ADD CONSTRAINT `profesor_ibfk_2` FOREIGN KEY (`dni`) REFERENCES `usuario` (`dni`) ;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`id_ROL`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`id_FUNCIONALIDAD`) REFERENCES `funcionalidad` (`id`),
  ADD CONSTRAINT `rol_permiso_ibfk_3` FOREIGN KEY (`id_ACCION`) REFERENCES `accion` (`id`);

--
-- Filtros para la tabla `titulacion`
--
ALTER TABLE `titulacion`
  ADD CONSTRAINT `titulacion_ibfk_1` FOREIGN KEY (`id_CENTRO`) REFERENCES `centro` (`id`),
  ADD CONSTRAINT `titulacion_ibfk_2` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`dni`),
    ADD CONSTRAINT `titulacion_ibfk_3` FOREIGN KEY (`id_ANHOACADEMICO`) REFERENCES `anhoacademico` (`id`);


--
-- Filtros para la tabla `tutoria`
--
ALTER TABLE `tutoria`
  ADD CONSTRAINT `tutoria_ibfk_1` FOREIGN KEY (`id_PROFESOR`) REFERENCES `profesor` (`dni`),
  ADD CONSTRAINT `tutoria_ibfk_2` FOREIGN KEY (`id_ESPACIO`) REFERENCES `espacio` (`id`),
  ADD CONSTRAINT `tutoria_ibfk_3` FOREIGN KEY (`id_ANHOACADEMICO`) REFERENCES `anhoacademico` (`id`);

--
-- Filtros para la tabla `universidad`
--
ALTER TABLE `universidad`
  ADD CONSTRAINT `universidad_ibfk_1` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`dni`)  ;

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`id_USUARIO`) REFERENCES `usuario` (`dni`),
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`id_ROL`) REFERENCES `rol` (`id`);

COMMIT;


-- ---------------------------------------------
-- 
-- INSERTS
-- 

--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` (`id`, `nombre`, `descripcion`) VALUES
(1, 'ADD', 'Se anade un valor'),
(2, 'DELETE', 'Se borra un valor'),
(3, 'EDIT', 'Se edita un valor'),
(4, 'SHOWCURRENT', 'Se muestra un valor en detalle'),
(5, 'SHOWALL', 'Muestra todos los valores requeridos'),
(6, 'SEARCH', 'Busqueda por campos'),
(7, 'ASISTENCIA', 'Marcar asistencia');

--
-- Volcado de datos para la tabla `funcionalidad`
--
INSERT INTO `funcionalidad` (`id`, `nombre`, `descripcion`, `borrado`) VALUES
(1, 'ACCION', 'Gestion de acciones', 0),
(2, 'FUNCIONALIDAD', 'Gestion de funcionalidades', 0),
(3, 'ROL', 'Gestion de roles', 0),
(4, 'PERMISO', 'Gestion de los permisos en la aplicacion', 0),
(5, 'USUARIO', 'Gestion de usuarios', 0),
(6, 'ROL_USUARIO', 'Gestion de usuarios', 0),
(7, 'AACADEMICO', 'Gestion de los permisos de anos academicos', 0),
(8, 'UNIVERSIDAD', 'Gestion de los permisos de universidades', 0),
(9, 'CENTRO', 'Gestion de los permisos de centros', 0),
(10, 'TITULACION', 'Gestion de los permisos de titulaciones', 0),
(11, 'PDA', 'Gestion lectura de PDAS', 0),
(12, 'PROFESOR', 'Gestion de profesores', 0),
(13, 'TUTORIA', 'Gestion de tutorias', 0),
(14, 'DEPARTAMENTO', 'Gestion de Departamentos', 0),
(15, 'ASIGNATURA', 'Gestion de Asignatura', 0),
(16, 'POD', 'Gestion lecturas de PODs', 0),
(17, 'EDIFICIO', 'Gestion de Edificios', 0),
(18, 'ESPACIO', 'Gestion de Espacios', 0),
(19, 'GRUPO', 'Gestion de Grupos', 0),
(20, 'ASISTENCIA', 'Gestion de Asistencias', 0),
(21, 'HORARIO', 'Gestion de horarios', 0);
--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `borrado`) VALUES
(1, 'Administrador', 0),
(2, 'Rector', 0),
(3, 'Admin Centro', 0),
(4, 'Profesor', 0);
	
--
-- Volcado de datos para la tabla `rol_permiso`
--
INSERT INTO `rol_permiso` (`id_ROL`, `id_FUNCIONALIDAD`, `id_ACCION`) VALUES
(1, 1, 1),
(1, 1, 2),
(1, 1, 5),

(1, 2, 1),
(1, 2, 2),
(1, 2, 5),

(1, 3, 1),
(1, 3, 2),
(1, 3, 5),

(1, 4, 1),
(1, 4, 2),
(1, 4, 5),
(1, 4, 6),

(1, 5, 1),
(1, 5, 2),
(1, 5, 3),
(1, 5, 4),
(1, 5, 5),
(1, 5, 6),

(1, 6, 1),
(1, 6, 2),
(1, 6, 5),
(1, 6, 6),

(1, 8, 1),
(1, 8, 2),
(1, 8, 3),
(1, 8, 4),
(1, 8, 5),
(1, 8, 6),

(1, 17, 1),
(1, 17, 2),
(1, 17, 3),
(1, 17, 4),
(1, 17, 5),
(1, 17, 6),

(1, 18, 1),
(1, 18, 2),
(1, 18, 3),
(1, 18, 4),
(1, 18, 5),
(1, 18, 6),

(1, 19, 1),
(1, 19, 2),
(1, 19, 3),
(1, 19, 4),
(1, 19, 5),
(1, 19, 6),

(1, 21, 1),
(1, 21, 2),
(1, 21, 3),
(1, 21, 4),
(1, 21, 5),
(1, 21, 6),
(1, 21, 7),

(1, 9, 1),
(1, 9, 2),
(1, 9, 3),
(1, 9, 4),
(1, 9, 5),
(1, 9, 6),


(1, 10, 1),
(1, 10, 2),
(1, 10, 3),
(1, 10, 4),
(1, 10, 5),
(1, 10, 6),

(1, 14, 1),
(1, 14, 2),
(1, 14, 3),
(1, 14, 4),
(1, 14, 5),
(1, 14, 6),


(1, 15, 1),
(1, 15, 2),
(1, 15, 3),
(1, 15, 4),
(1, 15, 5),
(1, 15, 6),

(1, 12, 1),
(1, 12, 2),
(1, 12, 3),
(1, 12, 4),
(1, 12, 5),
(1, 12, 6),

(1, 11, 1),

(1, 16, 1),

(1, 13, 1),
(1, 13, 2),
(1, 13, 3),
(1, 13, 4),
(1, 13, 5),
(1, 13, 6),
(1, 13, 7),

(1, 7, 1),
(1, 7, 2),
(1, 7, 5);

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `nombre`, `apellidos`, `email`, `password`) VALUES
  ('12345678Z', 'ADMIN', 'Solutions', 'admin@outech.com', '12345678Z');

--
-- Volcado de datos para la tabla `usuario_rol`
--
INSERT INTO `usuario_rol` (`id_USUARIO`, `id_ROL`) VALUES
	('12345678Z', 1);
	
INSERT INTO `universidad`(`id`, `nombre`, `ciudad`, `responsable`, `borrado`) VALUES 
(1,'UVigo','Vigo',"12345678Z",0);

INSERT INTO `edificio`(`id`, `id_UNIVERSIDAD`, `nombre`, `ubicacion`, `borrado`) VALUES
(1,1,'Politécnico','Ourense',0);

INSERT INTO `espacio`(`id`, `id_EDIFICIO`, `nombre`, `tipo`, `borrado`) VALUES 
(1,1,'Aula Magna','Despacho',0);

INSERT INTO `centro`(`id`, `id_UNIVERSIDAD`, `nombre`, `ciudad`, `responsable`, `borrado`) VALUES 
(1,1,'ESEI','Ourense','12345678Z',0),
(2,1,'Facultade de Ciencias da Educación','Ourense','12345678Z',0);

INSERT INTO `departamento`(`id`, `id_CENTRO`, `codigo`, `nombre`, `borrado`) VALUES (1,1,'D00x50','Departamento de Informatica',0);

INSERT INTO `profesor`(`dni`, `id_DEPARTAMENTO`, `dedicacion`, `borrado`) VALUES ('12345678Z',1,'Completa',0);

INSERT INTO `anhoacademico`(`id`, `anho`, `borrado`) VALUES (20202021,"2020/2021",0);
INSERT INTO `anhoacademico`(`id`, `anho`, `borrado`) VALUES (20212022,"2021/2022",0);
INSERT INTO `anhoacademico`(`id`, `anho`, `borrado`) VALUES (20192020,"2019/2020",0);

INSERT INTO `titulacion`(`id`, `id_ANHOACADEMICO`, `id_CENTRO`, `codigo`, `nombre`, `responsable`, `borrado`) VALUES 
(1,20202021,1,'V55G020V44','Grao en Administración e Dirección de Empresas','12345678Z',0),
(2,20192020,2,'O05G110V01','Grao en Educación Infantil','12345678Z',0),
(3,20192020,2,'O05G120V01','Grao en Educación Primaria','12345678Z',0),
(4,20192020,2,'O05G130V01','Grao en Educación Social','12345678Z',0),
(5,20192020,2,'O05G220V01','Grao en Traballo Social','12345678Z',0);


INSERT INTO `asignatura`(`id`, `id_TITULACION`, `id_ANHOACADEMICO`, `id_DEPARTAMENTO`, `id_PROFESOR`, `codigo`, `nombre`, `contenido`, `creditos`, `tipo`, `horas`, `cuatrimestre`, `borrado`) 
VALUES (1,1,20202021,1,'12345678Z','V55G020V44123','Asignatura para Tests',"Asignatura para Tests",'6','OB','100','1',0);

INSERT INTO `grupo`(`id`,`id_ANHOACADEMICO`,`id_ASIGNATURA`,`id_TITULACION`,`codigo`,`nombre`,`tipo`,`horas`,`borrado`)
VALUES(1,20202021,1,1,'A00d00','Grupo para Tests','GA','2',0);

INSERT INTO `grupo`(`id`,`id_ANHOACADEMICO`,`id_ASIGNATURA`,`id_TITULACION`,`codigo`,`nombre`,`tipo`,`horas`,`borrado`)
VALUES(2,20202021,1,1,'A00d01','Grupo para Tests II','GB','2',0);

INSERT INTO `horario`(`id`, `id_ANHOACADEMICO`, `id_PROFESOR`, `id_ESPACIO`, `id_GRUPO`, `id_ASIGNATURA`, `id_TITULACION`, `fecha`, `hora_inicio`, `hora_fin`, `asistencia`, `dia`, `borrado`) VALUES
(1,20202021,'12345678Z',1,1,1,1,'2022-01-12','12:00','14:00','Pendiente','miercoles',0);

INSERT INTO `tutoria`(`id`, `id_ANHOACADEMICO`, `id_PROFESOR`, `id_ESPACIO`, `asistencia`, `fecha`, `hora_inicio`, `hora_fin`, `borrado`) VALUES 
(1,20202021,'12345678Z',1,'Pendiente','2022-01-13','12:00','14:00',0);

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
