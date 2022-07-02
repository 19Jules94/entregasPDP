-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2022 a las 12:23:17
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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


DROP USER IF EXISTS 'toor'@'localhost';
CREATE USER 'toor'@'localhost' IDENTIFIED BY 'toor';

GRANT ALL PRIVILEGES ON `sced`.* TO 'toor'@'localhost' IDENTIFIED BY 'toor';
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion`
--

DROP TABLE IF EXISTS `accion`;
CREATE TABLE `accion` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anhoacademico`
--

DROP TABLE IF EXISTS `anhoacademico`;
CREATE TABLE `anhoacademico` (
  `id` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

DROP TABLE IF EXISTS `asignatura`;
CREATE TABLE `asignatura` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_TITULACION` int(10) NOT NULL,
  `id_DEPARTAMENTO` int(10) NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `creditos` double(5,1) NOT NULL,
  `tipo` enum('OB','OP','FB') COLLATE utf8_spanish_ci NOT NULL,
  `horas` double(5,1) NOT NULL,
  `cuatrimestre` enum('1','2') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `asignatura`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistenciadocencia`
--

DROP TABLE IF EXISTS `asistenciadocencia`;
CREATE TABLE `asistenciadocencia` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_HORARIO` int(10) NOT NULL,
  `id_GRUPO` int(10) NOT NULL,
  `asistencia` enum('si','no') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistenciatutoria`
--

DROP TABLE IF EXISTS `asistenciatutoria`;
CREATE TABLE `asistenciatutoria` (
  `id_TUTORIA` int(10) NOT NULL,
  `id_HORARIO` int(10) NOT NULL,
  `asistencia` enum('si','no') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

DROP TABLE IF EXISTS `centro`;
CREATE TABLE `centro` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_UNIVERSIDAD` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

DROP TABLE IF EXISTS `departamento`;
CREATE TABLE `departamento` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_CENTRO` int(10) NOT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificio`
--

DROP TABLE IF EXISTS `edificio`;
CREATE TABLE `edificio` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_UNIVERSIDAD` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacio`
--

DROP TABLE IF EXISTS `espacio`;
CREATE TABLE `espacio` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_EDIFICIO` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('aula','despacho') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionalidad`
--

DROP TABLE IF EXISTS `funcionalidad`;
CREATE TABLE `funcionalidad` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ASIGNATURA` int(10) NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('GA','GB','GC') COLLATE utf8_spanish_ci NOT NULL,
  `horas` double(5,1) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

DROP TABLE IF EXISTS `horario`;
CREATE TABLE `horario` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ESPACIO` int(10) NOT NULL,
  `id_GRUPO` int(10) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

DROP TABLE IF EXISTS `profesor`;
CREATE TABLE `profesor` (
  `dni` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_DEPARTAMENTO` int(10) NOT NULL,
  `dedicacion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `res_centro` int(11) NOT NULL DEFAULT 0,
  `res_titulacion` int(11) NOT NULL DEFAULT 0,
  `res_asignatura` int(11) NOT NULL DEFAULT 0,
  `res_universidad` int(11) NOT NULL DEFAULT 0
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
-- Estructura de tabla para la tabla `tfg`
--

DROP TABLE IF EXISTS `tfg`;
CREATE TABLE `tfg` (
  `id_tfg` int(11) NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `dni_profesor` varchar(10) COLLATE utf8_spanish_ci NOT NULL
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
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutoria`
--

DROP TABLE IF EXISTS `tutoria`;
CREATE TABLE `tutoria` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `horario` time NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidad`
--

DROP TABLE IF EXISTS `universidad`;
CREATE TABLE `universidad` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



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
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

DROP TABLE IF EXISTS `usuario_rol`;
CREATE TABLE `usuario_rol` (
  `id_USUARIO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ROL` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;



--
-- Índices para tablas volcadas
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
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_TITULACION` (`id_TITULACION`),
  ADD KEY `id_DEPARTAMENTO` (`id_DEPARTAMENTO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `id_PROFESOR` (`id_PROFESOR`),
  ADD KEY `asignatura_ibfk_1` (`id_TITULACION`,`id_ANHOACADEMICO`),
  ADD KEY `asignatura_ibfk_2` (`id_DEPARTAMENTO`,`id_ANHOACADEMICO`),
  ADD KEY `asignatura_ibfk_3` (`id_PROFESOR`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `asistenciadocencia`
--
ALTER TABLE `asistenciadocencia`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_PROFESOR` (`id_PROFESOR`),
  ADD KEY `id_HORARIO` (`id_HORARIO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `asistenciadocencia_ibfk_1` (`id_PROFESOR`,`id_ANHOACADEMICO`),
  ADD KEY `asistenciadocencia_ibfk_2` (`id_HORARIO`,`id_ANHOACADEMICO`),
  ADD KEY `asistenciadocencia_ibfk_3` (`id_GRUPO`);

--
-- Indices de la tabla `asistenciatutoria`
--
ALTER TABLE `asistenciatutoria`
  ADD PRIMARY KEY (`id_TUTORIA`,`id_HORARIO`),
  ADD KEY `asistenciatutoria_ibfk_1` (`id_HORARIO`);

--
-- Indices de la tabla `centro`
--
ALTER TABLE `centro`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `id_UNIVERSIDAD` (`id_UNIVERSIDAD`) USING BTREE,
  ADD KEY `centro_ibfk_1` (`id_UNIVERSIDAD`,`id_ANHOACADEMICO`),
  ADD KEY `centro_ibfk_2` (`responsable`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `id_CENTRO` (`id_CENTRO`),
  ADD KEY `departamento_ibfk_1` (`id_CENTRO`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `edificio`
--
ALTER TABLE `edificio`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `id_UNIVERSIDAD` (`id_UNIVERSIDAD`),
  ADD KEY `edificio_ibfk_1` (`id_UNIVERSIDAD`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_EDIFICIO` (`id_EDIFICIO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `espacio_ibfk_1` (`id_EDIFICIO`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `funcionalidad`
--
ALTER TABLE `funcionalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_ASIGNATURA` (`id_ASIGNATURA`),
  ADD KEY `id_PROFESOR` (`id_PROFESOR`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `grupo_ibfk_1` (`id_PROFESOR`,`id_ANHOACADEMICO`),
  ADD KEY `grupo_ibfk_2` (`id_ASIGNATURA`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_ESPACIO` (`id_ESPACIO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `id_GRUPO` (`id_GRUPO`),
  ADD KEY `horario_ibfk_1` (`id_ESPACIO`,`id_ANHOACADEMICO`),
  ADD KEY `horario_ibfk_2` (`id_GRUPO`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`dni`,`id_ANHOACADEMICO`),
  ADD KEY `id_DEPARTAMENTO` (`id_DEPARTAMENTO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `profesor_ibfk_1` (`id_DEPARTAMENTO`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`id_ROL`,`id_FUNCIONALIDAD`,`id_ACCION`),
  ADD KEY `id_FUNCIONALIDAD` (`id_FUNCIONALIDAD`),
  ADD KEY `id_ACCION` (`id_ACCION`);

--
-- Indices de la tabla `tfg`
--
ALTER TABLE `tfg`
  ADD PRIMARY KEY (`id_tfg`),
  ADD KEY `dni_profesor` (`dni_profesor`);

--
-- Indices de la tabla `titulacion`
--
ALTER TABLE `titulacion`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_CENTRO` (`id_CENTRO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `titulacion_ibfk_1` (`id_CENTRO`,`id_ANHOACADEMICO`),
  ADD KEY `titulacion_ibfk_2` (`responsable`);

--
-- Indices de la tabla `tutoria`
--
ALTER TABLE `tutoria`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `id_PROFESOR` (`id_PROFESOR`),
  ADD KEY `tutoria_ibfk_2` (`id_PROFESOR`,`id_ANHOACADEMICO`);

--
-- Indices de la tabla `universidad`
--
ALTER TABLE `universidad`
  ADD PRIMARY KEY (`id`,`id_ANHOACADEMICO`),
  ADD KEY `id_ANHOACADEMICO` (`id_ANHOACADEMICO`),
  ADD KEY `universidad_ibfk_2` (`responsable`);

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
  ADD PRIMARY KEY (`id_USUARIO`,`id_ROL`),
  ADD KEY `id_USUARIO` (`id_USUARIO`),
  ADD KEY `id_ROL` (`id_ROL`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion`
--
ALTER TABLE `accion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `asignatura`
--
ALTER TABLE `asignatura`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `asistenciadocencia`
--
ALTER TABLE `asistenciadocencia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `edificio`
--
ALTER TABLE `edificio`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `espacio`
--
ALTER TABLE `espacio`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `funcionalidad`
--
ALTER TABLE `funcionalidad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tfg`
--
ALTER TABLE `tfg`
  MODIFY `id_tfg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `titulacion`
--
ALTER TABLE `titulacion`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tutoria`
--
ALTER TABLE `tutoria`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `universidad`
--
ALTER TABLE `universidad`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `asignatura_ibfk_1` FOREIGN KEY (`id_TITULACION`,`id_ANHOACADEMICO`) REFERENCES `titulacion` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `asignatura_ibfk_2` FOREIGN KEY (`id_DEPARTAMENTO`,`id_ANHOACADEMICO`) REFERENCES `departamento` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `asignatura_ibfk_3` FOREIGN KEY (`id_PROFESOR`,`id_ANHOACADEMICO`) REFERENCES `profesor` (`dni`, `id_ANHOACADEMICO`);

--
-- Filtros para la tabla `asistenciadocencia`
--
ALTER TABLE `asistenciadocencia`
  ADD CONSTRAINT `asistenciadocencia_ibfk_1` FOREIGN KEY (`id_PROFESOR`,`id_ANHOACADEMICO`) REFERENCES `profesor` (`dni`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `asistenciadocencia_ibfk_2` FOREIGN KEY (`id_HORARIO`,`id_ANHOACADEMICO`) REFERENCES `horario` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `asistenciadocencia_ibfk_3` FOREIGN KEY (`id_GRUPO`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `asistenciatutoria`
--
ALTER TABLE `asistenciatutoria`
  ADD CONSTRAINT `asistenciatutoria_ibfk_1` FOREIGN KEY (`id_HORARIO`) REFERENCES `horario` (`id`),
  ADD CONSTRAINT `asistenciatutoria_ibfk_2` FOREIGN KEY (`id_TUTORIA`) REFERENCES `tutoria` (`id`);

--
-- Filtros para la tabla `centro`
--
ALTER TABLE `centro`
  ADD CONSTRAINT `centro_ibfk_1` FOREIGN KEY (`id_UNIVERSIDAD`,`id_ANHOACADEMICO`) REFERENCES `universidad` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `centro_ibfk_2` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`dni`);

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`id_CENTRO`,`id_ANHOACADEMICO`) REFERENCES `centro` (`id`, `id_ANHOACADEMICO`);

--
-- Filtros para la tabla `edificio`
--
ALTER TABLE `edificio`
  ADD CONSTRAINT `edificio_ibfk_1` FOREIGN KEY (`id_UNIVERSIDAD`,`id_ANHOACADEMICO`) REFERENCES `universidad` (`id`, `id_ANHOACADEMICO`);

--
-- Filtros para la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD CONSTRAINT `espacio_ibfk_1` FOREIGN KEY (`id_EDIFICIO`,`id_ANHOACADEMICO`) REFERENCES `edificio` (`id`, `id_ANHOACADEMICO`);

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`id_PROFESOR`,`id_ANHOACADEMICO`) REFERENCES `profesor` (`dni`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `grupo_ibfk_2` FOREIGN KEY (`id_ASIGNATURA`,`id_ANHOACADEMICO`) REFERENCES `asignatura` (`id`, `id_ANHOACADEMICO`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_ESPACIO`,`id_ANHOACADEMICO`) REFERENCES `espacio` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`id_GRUPO`,`id_ANHOACADEMICO`) REFERENCES `grupo` (`id`, `id_ANHOACADEMICO`);

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `profesor_ibfk_1` FOREIGN KEY (`id_DEPARTAMENTO`,`id_ANHOACADEMICO`) REFERENCES `departamento` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `profesor_ibfk_2` FOREIGN KEY (`dni`) REFERENCES `usuario` (`dni`);

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`id_ROL`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`id_FUNCIONALIDAD`) REFERENCES `funcionalidad` (`id`),
  ADD CONSTRAINT `rol_permiso_ibfk_3` FOREIGN KEY (`id_ACCION`) REFERENCES `accion` (`id`);

--
-- Filtros para la tabla `tfg`
--
ALTER TABLE `tfg`
  ADD CONSTRAINT `tfg_ibfk_1` FOREIGN KEY (`dni_profesor`) REFERENCES `profesor` (`dni`);

--
-- Filtros para la tabla `titulacion`
--
ALTER TABLE `titulacion`
  ADD CONSTRAINT `titulacion_ibfk_1` FOREIGN KEY (`id_CENTRO`,`id_ANHOACADEMICO`) REFERENCES `centro` (`id`, `id_ANHOACADEMICO`),
  ADD CONSTRAINT `titulacion_ibfk_2` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`dni`);

--
-- Filtros para la tabla `tutoria`
--
ALTER TABLE `tutoria`
  ADD CONSTRAINT `tutoria_ibfk_2` FOREIGN KEY (`id_PROFESOR`,`id_ANHOACADEMICO`) REFERENCES `profesor` (`dni`, `id_ANHOACADEMICO`);

--
-- Filtros para la tabla `universidad`
--
ALTER TABLE `universidad`
  ADD CONSTRAINT `universidad_ibfk_1` FOREIGN KEY (`id_ANHOACADEMICO`) REFERENCES `anhoacademico` (`id`),
  ADD CONSTRAINT `universidad_ibfk_2` FOREIGN KEY (`responsable`) REFERENCES `usuario` (`dni`);

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`id_USUARIO`) REFERENCES `usuario` (`dni`),
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`id_ROL`) REFERENCES `rol` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` VALUES(1, 'ADD', 'Se anade un valor', 0);
INSERT INTO `accion` VALUES(2, 'DELETE', 'Se borra un valor', 0);
INSERT INTO `accion` VALUES(3, 'EDIT', 'Se edita un valor', 0);
INSERT INTO `accion` VALUES(4, 'SHOWCURRENT', 'Se muestra un valor en detalle', 0);
INSERT INTO `accion` VALUES(5, 'SHOWALL', 'Muestra todos los valores requeridos', 0);
INSERT INTO `accion` VALUES(6, 'SEARCH', 'Busqueda por campos', 0);
INSERT INTO `accion` VALUES(7, 'ASISTENCIA', 'Marcar asistencia', 0);


--
-- Volcado de datos para la tabla `funcionalidad`
--

INSERT INTO `funcionalidad` VALUES(1, 'ACCION', 'Gestion de acciones', 0);
INSERT INTO `funcionalidad` VALUES(2, 'FUNCIONALIDAD', 'Gestion de funcionalidades', 0);
INSERT INTO `funcionalidad` VALUES(3, 'USUARIO', 'Gestion de usuarios', 0);
INSERT INTO `funcionalidad` VALUES(4, 'PERMISO', 'Gestion de los permisos en la aplicacion', 0);
INSERT INTO `funcionalidad` VALUES(5, 'AACADEMICO', 'Gestion de los permisos de anos academicos', 0);
INSERT INTO `funcionalidad` VALUES(6, 'UNIVERSIDAD', 'Gestion de los permisos de universidades', 0);
INSERT INTO `funcionalidad` VALUES(7, 'CENTRO', 'Gestion de los permisos de centros', 0);
INSERT INTO `funcionalidad` VALUES(8, 'TITULACION', 'Gestion de los permisos de titulaciones', 0);
INSERT INTO `funcionalidad` VALUES(9, 'PDA', 'Gestion lectura de PDAS', 0);
INSERT INTO `funcionalidad` VALUES(10, 'PROFESOR', 'Gestion de profesores', 0);
INSERT INTO `funcionalidad` VALUES(11, 'TUTORIA', 'Gestion de tutorias', 0);
INSERT INTO `funcionalidad` VALUES(12, 'DEPARTAMENTO', 'Gestion de Departamentos', 0);
INSERT INTO `funcionalidad` VALUES(13, 'ASIGNATURA', 'Gestion de Asignatura', 0);
INSERT INTO `funcionalidad` VALUES(14, 'POD', 'Gestion lecturas de PODs', 0);
INSERT INTO `funcionalidad` VALUES(15, 'EDIFICIO', 'Gestion de Edificios', 0);
INSERT INTO `funcionalidad` VALUES(16, 'ESPACIO', 'Gestion de Espacios', 0);
INSERT INTO `funcionalidad` VALUES(17, 'GRUPO', 'Gestion de Grupos', 0);
INSERT INTO `funcionalidad` VALUES(18, 'ASISTENCIA', 'Gestion de Asistencias', 0);
INSERT INTO `funcionalidad` VALUES(19, 'HORARIO', 'Gestion de horarios', 0);
INSERT INTO `funcionalidad` VALUES(23, 'TFG', 'Gestion de tfgs', 0);

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` VALUES(1, 'Administrador', 0, 0, 0, 0, 0);
INSERT INTO `rol` VALUES(2, 'Rector', 0, 0, 0, 0, 1);
INSERT INTO `rol` VALUES(3, 'Admin Centro', 0, 1, 0, 0, 0);
INSERT INTO `rol` VALUES(4, 'Profesor', 0, 0, 0, 1, 0);

--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` VALUES(1, 1, 1);
INSERT INTO `rol_permiso` VALUES(1, 1, 2);
INSERT INTO `rol_permiso` VALUES(1, 1, 3);
INSERT INTO `rol_permiso` VALUES(1, 1, 4);
INSERT INTO `rol_permiso` VALUES(1, 1, 5);
INSERT INTO `rol_permiso` VALUES(1, 1, 6);
INSERT INTO `rol_permiso` VALUES(1, 2, 1);
INSERT INTO `rol_permiso` VALUES(1, 2, 2);
INSERT INTO `rol_permiso` VALUES(1, 2, 3);
INSERT INTO `rol_permiso` VALUES(1, 2, 4);
INSERT INTO `rol_permiso` VALUES(1, 2, 5);
INSERT INTO `rol_permiso` VALUES(1, 2, 6);
INSERT INTO `rol_permiso` VALUES(1, 3, 1);
INSERT INTO `rol_permiso` VALUES(1, 3, 2);
INSERT INTO `rol_permiso` VALUES(1, 3, 3);
INSERT INTO `rol_permiso` VALUES(1, 3, 4);
INSERT INTO `rol_permiso` VALUES(1, 3, 5);
INSERT INTO `rol_permiso` VALUES(1, 3, 6);
INSERT INTO `rol_permiso` VALUES(1, 4, 1);
INSERT INTO `rol_permiso` VALUES(1, 4, 2);
INSERT INTO `rol_permiso` VALUES(1, 4, 3);
INSERT INTO `rol_permiso` VALUES(1, 4, 4);
INSERT INTO `rol_permiso` VALUES(1, 4, 5);
INSERT INTO `rol_permiso` VALUES(1, 4, 6);
INSERT INTO `rol_permiso` VALUES(1, 5, 1);
INSERT INTO `rol_permiso` VALUES(1, 5, 2);
INSERT INTO `rol_permiso` VALUES(1, 5, 3);
INSERT INTO `rol_permiso` VALUES(1, 5, 4);
INSERT INTO `rol_permiso` VALUES(1, 5, 5);
INSERT INTO `rol_permiso` VALUES(1, 5, 6);
INSERT INTO `rol_permiso` VALUES(1, 6, 1);
INSERT INTO `rol_permiso` VALUES(1, 6, 2);
INSERT INTO `rol_permiso` VALUES(1, 6, 3);
INSERT INTO `rol_permiso` VALUES(1, 6, 4);
INSERT INTO `rol_permiso` VALUES(1, 6, 5);
INSERT INTO `rol_permiso` VALUES(1, 6, 6);
INSERT INTO `rol_permiso` VALUES(1, 7, 1);
INSERT INTO `rol_permiso` VALUES(1, 7, 2);
INSERT INTO `rol_permiso` VALUES(1, 7, 3);
INSERT INTO `rol_permiso` VALUES(1, 7, 4);
INSERT INTO `rol_permiso` VALUES(1, 7, 5);
INSERT INTO `rol_permiso` VALUES(1, 7, 6);
INSERT INTO `rol_permiso` VALUES(1, 8, 1);
INSERT INTO `rol_permiso` VALUES(1, 8, 2);
INSERT INTO `rol_permiso` VALUES(1, 8, 3);
INSERT INTO `rol_permiso` VALUES(1, 8, 4);
INSERT INTO `rol_permiso` VALUES(1, 8, 5);
INSERT INTO `rol_permiso` VALUES(1, 8, 6);
INSERT INTO `rol_permiso` VALUES(1, 9, 1);
INSERT INTO `rol_permiso` VALUES(1, 9, 2);
INSERT INTO `rol_permiso` VALUES(1, 9, 3);
INSERT INTO `rol_permiso` VALUES(1, 9, 4);
INSERT INTO `rol_permiso` VALUES(1, 9, 5);
INSERT INTO `rol_permiso` VALUES(1, 9, 6);
INSERT INTO `rol_permiso` VALUES(1, 10, 1);
INSERT INTO `rol_permiso` VALUES(1, 10, 2);
INSERT INTO `rol_permiso` VALUES(1, 10, 3);
INSERT INTO `rol_permiso` VALUES(1, 10, 4);
INSERT INTO `rol_permiso` VALUES(1, 10, 5);
INSERT INTO `rol_permiso` VALUES(1, 10, 6);
INSERT INTO `rol_permiso` VALUES(1, 11, 1);
INSERT INTO `rol_permiso` VALUES(1, 11, 2);
INSERT INTO `rol_permiso` VALUES(1, 11, 3);
INSERT INTO `rol_permiso` VALUES(1, 11, 4);
INSERT INTO `rol_permiso` VALUES(1, 11, 5);
INSERT INTO `rol_permiso` VALUES(1, 11, 6);
INSERT INTO `rol_permiso` VALUES(1, 12, 1);
INSERT INTO `rol_permiso` VALUES(1, 12, 2);
INSERT INTO `rol_permiso` VALUES(1, 12, 3);
INSERT INTO `rol_permiso` VALUES(1, 12, 4);
INSERT INTO `rol_permiso` VALUES(1, 12, 5);
INSERT INTO `rol_permiso` VALUES(1, 12, 6);
INSERT INTO `rol_permiso` VALUES(1, 13, 1);
INSERT INTO `rol_permiso` VALUES(1, 13, 2);
INSERT INTO `rol_permiso` VALUES(1, 13, 3);
INSERT INTO `rol_permiso` VALUES(1, 13, 4);
INSERT INTO `rol_permiso` VALUES(1, 13, 5);
INSERT INTO `rol_permiso` VALUES(1, 13, 6);
INSERT INTO `rol_permiso` VALUES(1, 14, 1);
INSERT INTO `rol_permiso` VALUES(1, 14, 2);
INSERT INTO `rol_permiso` VALUES(1, 14, 3);
INSERT INTO `rol_permiso` VALUES(1, 14, 4);
INSERT INTO `rol_permiso` VALUES(1, 14, 5);
INSERT INTO `rol_permiso` VALUES(1, 14, 6);
INSERT INTO `rol_permiso` VALUES(1, 15, 1);
INSERT INTO `rol_permiso` VALUES(1, 15, 2);
INSERT INTO `rol_permiso` VALUES(1, 15, 3);
INSERT INTO `rol_permiso` VALUES(1, 15, 4);
INSERT INTO `rol_permiso` VALUES(1, 15, 5);
INSERT INTO `rol_permiso` VALUES(1, 15, 6);
INSERT INTO `rol_permiso` VALUES(1, 16, 1);
INSERT INTO `rol_permiso` VALUES(1, 16, 2);
INSERT INTO `rol_permiso` VALUES(1, 16, 3);
INSERT INTO `rol_permiso` VALUES(1, 16, 4);
INSERT INTO `rol_permiso` VALUES(1, 16, 5);
INSERT INTO `rol_permiso` VALUES(1, 16, 6);
INSERT INTO `rol_permiso` VALUES(1, 17, 1);
INSERT INTO `rol_permiso` VALUES(1, 17, 2);
INSERT INTO `rol_permiso` VALUES(1, 17, 3);
INSERT INTO `rol_permiso` VALUES(1, 17, 4);
INSERT INTO `rol_permiso` VALUES(1, 17, 5);
INSERT INTO `rol_permiso` VALUES(1, 17, 6);
INSERT INTO `rol_permiso` VALUES(1, 18, 1);
INSERT INTO `rol_permiso` VALUES(1, 18, 2);
INSERT INTO `rol_permiso` VALUES(1, 18, 3);
INSERT INTO `rol_permiso` VALUES(1, 18, 4);
INSERT INTO `rol_permiso` VALUES(1, 18, 5);
INSERT INTO `rol_permiso` VALUES(1, 18, 6);
INSERT INTO `rol_permiso` VALUES(1, 18, 7);
INSERT INTO `rol_permiso` VALUES(1, 19, 1);
INSERT INTO `rol_permiso` VALUES(1, 19, 2);
INSERT INTO `rol_permiso` VALUES(1, 19, 3);
INSERT INTO `rol_permiso` VALUES(1, 19, 4);
INSERT INTO `rol_permiso` VALUES(1, 19, 5);
INSERT INTO `rol_permiso` VALUES(1, 19, 6);
INSERT INTO `rol_permiso` VALUES(1, 19, 7);
INSERT INTO `rol_permiso` VALUES(1, 23, 1);
INSERT INTO `rol_permiso` VALUES(2, 5, 1);
INSERT INTO `rol_permiso` VALUES(2, 5, 2);
INSERT INTO `rol_permiso` VALUES(2, 5, 3);
INSERT INTO `rol_permiso` VALUES(2, 5, 4);
INSERT INTO `rol_permiso` VALUES(2, 5, 5);
INSERT INTO `rol_permiso` VALUES(2, 5, 6);
INSERT INTO `rol_permiso` VALUES(2, 6, 1);
INSERT INTO `rol_permiso` VALUES(2, 6, 2);
INSERT INTO `rol_permiso` VALUES(2, 6, 3);
INSERT INTO `rol_permiso` VALUES(2, 6, 4);
INSERT INTO `rol_permiso` VALUES(2, 6, 5);
INSERT INTO `rol_permiso` VALUES(2, 6, 6);
INSERT INTO `rol_permiso` VALUES(2, 7, 1);
INSERT INTO `rol_permiso` VALUES(2, 7, 2);
INSERT INTO `rol_permiso` VALUES(2, 7, 3);
INSERT INTO `rol_permiso` VALUES(2, 7, 4);
INSERT INTO `rol_permiso` VALUES(2, 7, 5);
INSERT INTO `rol_permiso` VALUES(2, 7, 6);
INSERT INTO `rol_permiso` VALUES(2, 8, 1);
INSERT INTO `rol_permiso` VALUES(2, 8, 2);
INSERT INTO `rol_permiso` VALUES(2, 8, 3);
INSERT INTO `rol_permiso` VALUES(2, 8, 4);
INSERT INTO `rol_permiso` VALUES(2, 8, 5);
INSERT INTO `rol_permiso` VALUES(2, 8, 6);
INSERT INTO `rol_permiso` VALUES(2, 9, 1);
INSERT INTO `rol_permiso` VALUES(2, 9, 2);
INSERT INTO `rol_permiso` VALUES(2, 9, 3);
INSERT INTO `rol_permiso` VALUES(2, 9, 4);
INSERT INTO `rol_permiso` VALUES(2, 9, 5);
INSERT INTO `rol_permiso` VALUES(2, 9, 6);
INSERT INTO `rol_permiso` VALUES(2, 10, 1);
INSERT INTO `rol_permiso` VALUES(2, 10, 2);
INSERT INTO `rol_permiso` VALUES(2, 10, 3);
INSERT INTO `rol_permiso` VALUES(2, 10, 4);
INSERT INTO `rol_permiso` VALUES(2, 10, 5);
INSERT INTO `rol_permiso` VALUES(2, 10, 6);
INSERT INTO `rol_permiso` VALUES(2, 11, 1);
INSERT INTO `rol_permiso` VALUES(2, 11, 2);
INSERT INTO `rol_permiso` VALUES(2, 11, 3);
INSERT INTO `rol_permiso` VALUES(2, 11, 4);
INSERT INTO `rol_permiso` VALUES(2, 11, 5);
INSERT INTO `rol_permiso` VALUES(2, 11, 6);
INSERT INTO `rol_permiso` VALUES(2, 12, 1);
INSERT INTO `rol_permiso` VALUES(2, 12, 2);
INSERT INTO `rol_permiso` VALUES(2, 12, 3);
INSERT INTO `rol_permiso` VALUES(2, 12, 4);
INSERT INTO `rol_permiso` VALUES(2, 12, 5);
INSERT INTO `rol_permiso` VALUES(2, 12, 6);
INSERT INTO `rol_permiso` VALUES(2, 13, 1);
INSERT INTO `rol_permiso` VALUES(2, 13, 2);
INSERT INTO `rol_permiso` VALUES(2, 13, 3);
INSERT INTO `rol_permiso` VALUES(2, 13, 4);
INSERT INTO `rol_permiso` VALUES(2, 13, 5);
INSERT INTO `rol_permiso` VALUES(2, 13, 6);
INSERT INTO `rol_permiso` VALUES(2, 15, 1);
INSERT INTO `rol_permiso` VALUES(2, 15, 2);
INSERT INTO `rol_permiso` VALUES(2, 15, 3);
INSERT INTO `rol_permiso` VALUES(2, 15, 4);
INSERT INTO `rol_permiso` VALUES(2, 15, 5);
INSERT INTO `rol_permiso` VALUES(2, 15, 6);
INSERT INTO `rol_permiso` VALUES(2, 16, 1);
INSERT INTO `rol_permiso` VALUES(2, 16, 2);
INSERT INTO `rol_permiso` VALUES(2, 16, 3);
INSERT INTO `rol_permiso` VALUES(2, 16, 4);
INSERT INTO `rol_permiso` VALUES(2, 16, 5);
INSERT INTO `rol_permiso` VALUES(2, 16, 6);
INSERT INTO `rol_permiso` VALUES(2, 17, 1);
INSERT INTO `rol_permiso` VALUES(2, 17, 2);
INSERT INTO `rol_permiso` VALUES(2, 17, 3);
INSERT INTO `rol_permiso` VALUES(2, 17, 4);
INSERT INTO `rol_permiso` VALUES(2, 17, 5);
INSERT INTO `rol_permiso` VALUES(2, 17, 6);
INSERT INTO `rol_permiso` VALUES(2, 18, 1);
INSERT INTO `rol_permiso` VALUES(2, 18, 2);
INSERT INTO `rol_permiso` VALUES(2, 18, 3);
INSERT INTO `rol_permiso` VALUES(2, 18, 4);
INSERT INTO `rol_permiso` VALUES(2, 18, 5);
INSERT INTO `rol_permiso` VALUES(2, 18, 6);
INSERT INTO `rol_permiso` VALUES(2, 18, 7);
INSERT INTO `rol_permiso` VALUES(2, 19, 1);
INSERT INTO `rol_permiso` VALUES(2, 19, 2);
INSERT INTO `rol_permiso` VALUES(2, 19, 3);
INSERT INTO `rol_permiso` VALUES(2, 19, 4);
INSERT INTO `rol_permiso` VALUES(2, 19, 5);
INSERT INTO `rol_permiso` VALUES(2, 19, 6);
INSERT INTO `rol_permiso` VALUES(2, 19, 7);
INSERT INTO `rol_permiso` VALUES(3, 17, 1);
INSERT INTO `rol_permiso` VALUES(3, 17, 2);
INSERT INTO `rol_permiso` VALUES(3, 17, 3);
INSERT INTO `rol_permiso` VALUES(3, 17, 4);
INSERT INTO `rol_permiso` VALUES(3, 17, 5);
INSERT INTO `rol_permiso` VALUES(3, 17, 6);
INSERT INTO `rol_permiso` VALUES(3, 18, 1);
INSERT INTO `rol_permiso` VALUES(3, 18, 2);
INSERT INTO `rol_permiso` VALUES(3, 18, 3);
INSERT INTO `rol_permiso` VALUES(3, 18, 4);
INSERT INTO `rol_permiso` VALUES(3, 18, 5);
INSERT INTO `rol_permiso` VALUES(3, 18, 6);
INSERT INTO `rol_permiso` VALUES(3, 18, 7);
INSERT INTO `rol_permiso` VALUES(3, 19, 1);
INSERT INTO `rol_permiso` VALUES(3, 19, 2);
INSERT INTO `rol_permiso` VALUES(3, 19, 3);
INSERT INTO `rol_permiso` VALUES(3, 19, 4);
INSERT INTO `rol_permiso` VALUES(3, 19, 5);
INSERT INTO `rol_permiso` VALUES(3, 19, 6);
INSERT INTO `rol_permiso` VALUES(3, 19, 7);
INSERT INTO `rol_permiso` VALUES(4, 18, 1);
INSERT INTO `rol_permiso` VALUES(4, 18, 2);
INSERT INTO `rol_permiso` VALUES(4, 18, 3);
INSERT INTO `rol_permiso` VALUES(4, 18, 4);
INSERT INTO `rol_permiso` VALUES(4, 18, 5);
INSERT INTO `rol_permiso` VALUES(4, 18, 6);
INSERT INTO `rol_permiso` VALUES(4, 18, 7);
INSERT INTO `rol_permiso` VALUES(4, 19, 1);
INSERT INTO `rol_permiso` VALUES(4, 19, 2);
INSERT INTO `rol_permiso` VALUES(4, 19, 3);
INSERT INTO `rol_permiso` VALUES(4, 19, 4);
INSERT INTO `rol_permiso` VALUES(4, 19, 5);
INSERT INTO `rol_permiso` VALUES(4, 19, 6);
INSERT INTO `rol_permiso` VALUES(4, 19, 7);

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` VALUES('12345670B', 'Pepe', 'Sanchez', 'pepe@email.com', '926e27eecdbc7a18858b3798ba99bddd', 0);
INSERT INTO `usuario` VALUES('12345678L', 'Admin', 'Apellidos Admin', 'admin@email.com', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `usuario` VALUES('12345679B', 'Carlos', 'Perez', 'carlos@email.com', 'dc599a9972fde3045dab59dbd1ae170b', 0);
INSERT INTO `usuario` VALUES('12345745C', 'Juan', 'Lopez', 'juan@email.com', 'a94652aa97c7211ba8954dd15a3cf838', 0);
INSERT INTO `usuario` VALUES('12549535E', 'Javier', 'Rodeiro', 'javier@email.com', '3c9c03d6008a5adf42c2a55dd4a1a9f2', 0);
INSERT INTO `usuario` VALUES('23432343F', 'Fernando', 'Mondo', 'fer@email.com', '90eb8760c187a2097884ed4c9ffbb6a4', 0);
INSERT INTO `usuario` VALUES('34534543R', 'Luisa', 'Monte', 'luisa@email.com', '327229a1f11cc3c7ce66ee5d1341ae51', 0);
INSERT INTO `usuario` VALUES('35577002G', 'Julio', 'Patricio', 'j@gmail.com', 'abc123..!!', 0);
INSERT INTO `usuario` VALUES('42641234F', 'Fran', 'Barros', 'fran@email.com', '2c20cb5558626540a1704b1fe524ea9a', 0);
INSERT INTO `usuario` VALUES('45627896T', 'Pedro', 'Diaz', 'pedro@email.com', 'c6cc8094c2dc07b700ffcc36d64e2138', 0);
INSERT INTO `usuario` VALUES('56874952B', 'Maria', 'Giraldez', 'maria@email.com', '263bce650e68ab4e23f28263760b9fa5', 0);
INSERT INTO `usuario` VALUES('77151036C', 'Antonio', 'Fernandez', 'antonio@email.com', '4a181673429f0b6abbfd452f0f3b5950', 0);
INSERT INTO `usuario` VALUES('87687264F', 'Roberto', 'Justo', 'roberto@email.com', 'c1bfc188dba59d2681648aa0e6ca8c8e', 0);
INSERT INTO `usuario` VALUES('91376283C', 'Julio', 'Perez', 'julio@email.com', 'c027636003b468821081e281758e35ff', 0);
INSERT INTO `usuario` VALUES('96578631R', 'Laura', 'Ferreiro', 'laura@email.com', '680e89809965ec41e64dc7e447f175ab', 0);

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` VALUES('12345670B', 3);
INSERT INTO `usuario_rol` VALUES('12345678L', 1);
INSERT INTO `usuario_rol` VALUES('12345679B', 2);
INSERT INTO `usuario_rol` VALUES('12345745C', 2);
INSERT INTO `usuario_rol` VALUES('12549535E', 4);
INSERT INTO `usuario_rol` VALUES('35577002G', 1);
INSERT INTO `usuario_rol` VALUES('45627896T', 2);
INSERT INTO `usuario_rol` VALUES('56874952B', 3);
INSERT INTO `usuario_rol` VALUES('77151036C', 4);
INSERT INTO `usuario_rol` VALUES('91376283C', 4);
INSERT INTO `usuario_rol` VALUES('96578631R', 3);

--
-- Volcado de datos para la tabla `universidad`
--

INSERT INTO `universidad` VALUES(1, '2019/2020', 'Uvigo', 'Ourense', '12345679B', 0);
INSERT INTO `universidad` VALUES(2, '2019/2020', 'USC', 'Santiago de Compostela', '12345745C', 0);
INSERT INTO `universidad` VALUES(3, '2019/2020', 'UDC', 'Universidade da Coruna', '45627896T', 0);
INSERT INTO `universidad` VALUES(4, '2019/2020', 'Uvigo', 'Ourense', '12345679B', 0);

--
-- Volcado de datos para la tabla `edificio`
--

INSERT INTO `edificio` VALUES(1, '2019/2020', 1, 'Campus da Auga', 'Campus Sur', 0);
INSERT INTO `edificio` VALUES(2, '2019/2020', 2, 'Edificio Politecnico', 'Campus Norte', 0);
INSERT INTO `edificio` VALUES(3, '2019/2020', 3, 'Edificio Facultades', 'Campus Norte', 0);

--
-- Volcado de datos para la tabla `espacio`
--

INSERT INTO `espacio` VALUES(1, '2019/2020', 1, 'Aula Magna', 'aula', 0);
INSERT INTO `espacio` VALUES(2, '2019/2020', 1, 'Aula 2.2', 'aula', 0);
INSERT INTO `espacio` VALUES(3, '2019/2020', 1, 'Despacho 413', 'despacho', 0);
INSERT INTO `espacio` VALUES(4, '2019/2020', 2, 'Depacho 312', 'despacho', 0);
INSERT INTO `espacio` VALUES(5, '2019/2020', 2, 'Salon de Graos', 'aula', 0);
INSERT INTO `espacio` VALUES(6, '2019/2020', 3, 'Laboratorio 38', 'aula', 0);
INSERT INTO `espacio` VALUES(7, '2019/2020', 3, 'Depacho 123', 'despacho', 0);

--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` VALUES(1, '2019/2020', 1, 'ESEI', 'Ourense', '12345670B', 0);
INSERT INTO `centro` VALUES(2, '2019/2020', 2, 'Facultade de medicina', 'Santiago de Compostela', '56874952B', 0);
INSERT INTO `centro` VALUES(3, '2019/2020', 3, 'Escuela de arquitectura', 'A Coruna', '96578631R', 0);
INSERT INTO `centro` VALUES(4, '2019/2020', 1, 'Aeroespacial', 'Ourense', '42641234F', 0);
INSERT INTO `centro` VALUES(5, '2019/2020', 4, 'Educacion', 'Ourense', '42641234F', 0);

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` VALUES(1, '2019/2020', 1, 'D12345', 'Matematicas', 0);
INSERT INTO `departamento` VALUES(2, '2019/2020', 1, 'D12346', 'Ciencias Sociales', 0);
INSERT INTO `departamento` VALUES(3, '2019/2020', 3, 'D12347', 'Geologia', 0);
INSERT INTO `departamento` VALUES(4, '2019/2020', 3, 'D12348', 'Redes', 0);
INSERT INTO `departamento` VALUES(5, '2019/2020', 3, 'D12349', 'Informatica', 0);
INSERT INTO `departamento` VALUES(6, '2019/2020', 1, 'D12340', 'Alimentacion', 0);
INSERT INTO `departamento` VALUES(7, '2019/2020', 1, 'D12341', 'Estadistica', 0);
INSERT INTO `departamento` VALUES(8, '2019/2020', 1, 'D12342', 'Hardware', 0);
INSERT INTO `departamento` VALUES(9, '2019/2020', 2, 'D12343', 'Biologia', 0);
INSERT INTO `departamento` VALUES(10, '2019/2020', 2, 'D12344', 'Traumatologia', 0);
INSERT INTO `departamento` VALUES(11, '2019/2020', 4, 'D12311', 'Fisica', 0);

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` VALUES('12549535E', '2019/2020', 4, 'TC', 0);
--
-- Volcado de datos para la tabla `anhoacademico`
--

INSERT INTO `anhoacademico` VALUES('2018/2019', 0);
INSERT INTO `anhoacademico` VALUES('2019/2020', 0);
--
-- Volcado de datos para la tabla `titulacion`
--

INSERT INTO `titulacion` VALUES(1, '2019/2020', 1, '123456789', 'Ingenieria Informatica', NULL, 0);
INSERT INTO `titulacion` VALUES(2, '2019/2020', 1, '7895648', 'Master en Ingenieria Informatica', NULL, 0);
INSERT INTO `titulacion` VALUES(3, '2019/2020', 2, '46629756', 'Enfermeria', NULL, 0);
INSERT INTO `titulacion` VALUES(4, '2019/2020', 2, '1472345', 'Medicina', NULL, 0);
INSERT INTO `titulacion` VALUES(5, '2019/2020', 3, '4698498', 'Arquitectura', NULL, 0);

INSERT INTO `asignatura` VALUES(1, '2019/2020', 2, 1, '56874952B', '12123', 'Programacion I', 6.0, 'OB', 50.0, '1', 0);
INSERT INTO `asignatura` VALUES(2, '2019/2020', 1, 2, '23432343F', '23442', 'Principios de la  Estadistica', 4.0, 'OB', 4.0, '1', 0);
INSERT INTO `asignatura` VALUES(3, '2019/2020', 1, 3, '34534543R', '432443', 'Sistemas Digitales', 6.0, 'OB', 60.0, '2', 0);
INSERT INTO `asignatura` VALUES(4, '2019/2020', 1, 1, '87687264F', '234234', 'Sistemas Inteligentes', 6.0, 'OB', 50.0, '2', 0);
INSERT INTO `asignatura` VALUES(5, '2019/2020', 5, 3, '12549535E', '17854', 'Interfaces de Usuario', 3.0, 'OB', 3.0, '1', 0);










/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
