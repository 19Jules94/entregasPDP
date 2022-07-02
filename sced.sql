-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-07-2022 a las 13:31:16
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
CREATE DATABASE IF NOT EXISTS `sced` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `sced`;
DROP USER IF EXISTS 'toor'@'localhost';
CREATE USER 'toor'@'localhost' IDENTIFIED BY 'toor';

GRANT ALL PRIVILEGES ON `sced`.* TO 'toor'@'localhost' IDENTIFIED BY 'toor';
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion`
--

CREATE TABLE `accion` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `accion`
--

TRUNCATE TABLE `accion`;
--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` (`id`, `nombre`, `descripcion`, `borrado`) VALUES
(1, 'ADD', 'Se anade un valor', 0),
(2, 'DELETE', 'Se borra un valor', 0),
(3, 'EDIT', 'Se edita un valor', 0),
(4, 'SHOWCURRENT', 'Se muestra un valor en detalle', 0),
(5, 'SHOWALL', 'Muestra todos los valores requeridos', 0),
(6, 'SEARCH', 'Busqueda por campos', 0),
(7, 'ASISTENCIA', 'Marcar asistencia', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anhoacademico`
--

CREATE TABLE `anhoacademico` (
  `id` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `anhoacademico`
--

TRUNCATE TABLE `anhoacademico`;
--
-- Volcado de datos para la tabla `anhoacademico`
--

INSERT INTO `anhoacademico` (`id`, `borrado`) VALUES
('2018/2019', 0),
('2019/2020', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

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
-- Truncar tablas antes de insertar `asignatura`
--

TRUNCATE TABLE `asignatura`;
--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`id`, `id_ANHOACADEMICO`, `id_TITULACION`, `id_DEPARTAMENTO`, `id_PROFESOR`, `codigo`, `nombre`, `creditos`, `tipo`, `horas`, `cuatrimestre`, `borrado`) VALUES
(1, '2019/2020', 2, 1, '56874952B', '12123', 'Programacion I', 6.0, 'OB', 50.0, '1', 0),
(2, '2019/2020', 1, 2, '23432343F', '23442', 'Principios de la  Estadistica', 4.0, 'OB', 4.0, '1', 0),
(3, '2019/2020', 1, 3, '34534543R', '432443', 'Sistemas Digitales', 6.0, 'OB', 60.0, '2', 0),
(4, '2019/2020', 1, 1, '87687264F', '234234', 'Sistemas Inteligentes', 6.0, 'OB', 50.0, '2', 0),
(5, '2019/2020', 5, 3, '12549535E', '17854', 'Interfaces de Usuario', 3.0, 'OB', 3.0, '1', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistenciadocencia`
--

CREATE TABLE `asistenciadocencia` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_HORARIO` int(10) NOT NULL,
  `id_GRUPO` int(10) NOT NULL,
  `asistencia` enum('si','no') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `asistenciadocencia`
--

TRUNCATE TABLE `asistenciadocencia`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistenciatutoria`
--

CREATE TABLE `asistenciatutoria` (
  `id_TUTORIA` int(10) NOT NULL,
  `id_HORARIO` int(10) NOT NULL,
  `asistencia` enum('si','no') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `asistenciatutoria`
--

TRUNCATE TABLE `asistenciatutoria`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

CREATE TABLE `centro` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_UNIVERSIDAD` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `centro`
--

TRUNCATE TABLE `centro`;
--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` (`id`, `id_ANHOACADEMICO`, `id_UNIVERSIDAD`, `nombre`, `ciudad`, `responsable`, `borrado`) VALUES
(1, '2019/2020', 1, 'ESEI', 'Ourense', '12345670B', 0),
(2, '2019/2020', 2, 'Facultade de medicina', 'Santiago de Compostela', '56874952B', 0),
(3, '2019/2020', 3, 'Escuela de arquitectura', 'A Coruna', '96578631R', 0),
(4, '2019/2020', 1, 'Aeroespacial', 'Ourense', '42641234F', 0),
(5, '2019/2020', 4, 'Educacion', 'Ourense', '42641234F', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_CENTRO` int(10) NOT NULL,
  `codigo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `departamento`
--

TRUNCATE TABLE `departamento`;
--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `id_ANHOACADEMICO`, `id_CENTRO`, `codigo`, `nombre`, `borrado`) VALUES
(1, '2019/2020', 1, 'D12345', 'Matematicas', 0),
(2, '2019/2020', 1, 'D12346', 'Ciencias Sociales', 0),
(3, '2019/2020', 3, 'D12347', 'Geologia', 0),
(4, '2019/2020', 3, 'D12348', 'Redes', 0),
(5, '2019/2020', 3, 'D12349', 'Informatica', 0),
(6, '2019/2020', 1, 'D12340', 'Alimentacion', 0),
(7, '2019/2020', 1, 'D12341', 'Estadistica', 0),
(8, '2019/2020', 1, 'D12342', 'Hardware', 0),
(9, '2019/2020', 2, 'D12343', 'Biologia', 0),
(10, '2019/2020', 2, 'D12344', 'Traumatologia', 0),
(11, '2019/2020', 4, 'D12311', 'Fisica', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificio`
--

CREATE TABLE `edificio` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_UNIVERSIDAD` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `edificio`
--

TRUNCATE TABLE `edificio`;
--
-- Volcado de datos para la tabla `edificio`
--

INSERT INTO `edificio` (`id`, `id_ANHOACADEMICO`, `id_UNIVERSIDAD`, `nombre`, `ubicacion`, `borrado`) VALUES
(1, '2019/2020', 1, 'Campus da Auga', 'Campus Sur', 0),
(2, '2019/2020', 2, 'Edificio Politecnico', 'Campus Norte', 0),
(3, '2019/2020', 3, 'Edificio Facultades', 'Campus Norte', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacio`
--

CREATE TABLE `espacio` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_EDIFICIO` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('aula','despacho') COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `espacio`
--

TRUNCATE TABLE `espacio`;
--
-- Volcado de datos para la tabla `espacio`
--

INSERT INTO `espacio` (`id`, `id_ANHOACADEMICO`, `id_EDIFICIO`, `nombre`, `tipo`, `borrado`) VALUES
(1, '2019/2020', 1, 'Aula Magna', 'aula', 0),
(2, '2019/2020', 1, 'Aula 2.2', 'aula', 0),
(3, '2019/2020', 1, 'Despacho 413', 'despacho', 0),
(4, '2019/2020', 2, 'Depacho 312', 'despacho', 0),
(5, '2019/2020', 2, 'Salon de Graos', 'aula', 0),
(6, '2019/2020', 3, 'Laboratorio 38', 'aula', 0),
(7, '2019/2020', 3, 'Depacho 123', 'despacho', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionalidad`
--

CREATE TABLE `funcionalidad` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `funcionalidad`
--

TRUNCATE TABLE `funcionalidad`;
--
-- Volcado de datos para la tabla `funcionalidad`
--

INSERT INTO `funcionalidad` (`id`, `nombre`, `descripcion`, `borrado`) VALUES
(1, 'ACCION', 'Gestion de acciones', 0),
(2, 'FUNCIONALIDAD', 'Gestion de funcionalidades', 0),
(3, 'USUARIO', 'Gestion de usuarios', 0),
(4, 'PERMISO', 'Gestion de los permisos en la aplicacion', 0),
(5, 'AACADEMICO', 'Gestion de los permisos de anos academicos', 0),
(6, 'UNIVERSIDAD', 'Gestion de los permisos de universidades', 0),
(7, 'CENTRO', 'Gestion de los permisos de centros', 0),
(8, 'TITULACION', 'Gestion de los permisos de titulaciones', 0),
(9, 'PDA', 'Gestion lectura de PDAS', 0),
(10, 'PROFESOR', 'Gestion de profesores', 0),
(11, 'TUTORIA', 'Gestion de tutorias', 0),
(12, 'DEPARTAMENTO', 'Gestion de Departamentos', 0),
(13, 'ASIGNATURA', 'Gestion de Asignatura', 0),
(14, 'POD', 'Gestion lecturas de PODs', 0),
(15, 'EDIFICIO', 'Gestion de Edificios', 0),
(16, 'ESPACIO', 'Gestion de Espacios', 0),
(17, 'GRUPO', 'Gestion de Grupos', 0),
(18, 'ASISTENCIA', 'Gestion de Asistencias', 0),
(19, 'HORARIO', 'Gestion de horarios', 0),
(23, 'TFG', 'Gestion de tfgs', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

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

--
-- Truncar tablas antes de insertar `grupo`
--

TRUNCATE TABLE `grupo`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

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

--
-- Truncar tablas antes de insertar `horario`
--

TRUNCATE TABLE `horario`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `dni` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_DEPARTAMENTO` int(10) NOT NULL,
  `dedicacion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `profesor`
--

TRUNCATE TABLE `profesor`;
--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`dni`, `id_ANHOACADEMICO`, `id_DEPARTAMENTO`, `dedicacion`, `borrado`) VALUES
('12549535E', '2019/2020', 4, 'TC', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `res_centro` int(11) NOT NULL DEFAULT 0,
  `res_titulacion` int(11) NOT NULL DEFAULT 0,
  `res_asignatura` int(11) NOT NULL DEFAULT 0,
  `res_universidad` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `rol`
--

TRUNCATE TABLE `rol`;
--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `borrado`, `res_centro`, `res_titulacion`, `res_asignatura`, `res_universidad`) VALUES
(1, 'Administrador', 0, 0, 0, 0, 0),
(2, 'Rector', 0, 0, 0, 0, 1),
(3, 'Admin Centro', 0, 1, 0, 0, 0),
(4, 'Profesor', 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `id_ROL` int(10) NOT NULL,
  `id_FUNCIONALIDAD` int(10) NOT NULL,
  `id_ACCION` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `rol_permiso`
--

TRUNCATE TABLE `rol_permiso`;
--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` (`id_ROL`, `id_FUNCIONALIDAD`, `id_ACCION`) VALUES
(1, 1, 1),
(1, 1, 2),
(1, 1, 3),
(1, 1, 4),
(1, 1, 5),
(1, 1, 6),
(1, 2, 1),
(1, 2, 2),
(1, 2, 3),
(1, 2, 4),
(1, 2, 5),
(1, 2, 6),
(1, 3, 1),
(1, 3, 2),
(1, 3, 3),
(1, 3, 4),
(1, 3, 5),
(1, 3, 6),
(1, 4, 1),
(1, 4, 2),
(1, 4, 3),
(1, 4, 4),
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
(1, 6, 3),
(1, 6, 4),
(1, 6, 5),
(1, 6, 6),
(1, 7, 1),
(1, 7, 2),
(1, 7, 3),
(1, 7, 4),
(1, 7, 5),
(1, 7, 6),
(1, 8, 1),
(1, 8, 2),
(1, 8, 3),
(1, 8, 4),
(1, 8, 5),
(1, 8, 6),
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
(1, 11, 1),
(1, 11, 2),
(1, 11, 3),
(1, 11, 4),
(1, 11, 5),
(1, 11, 6),
(1, 12, 1),
(1, 12, 2),
(1, 12, 3),
(1, 12, 4),
(1, 12, 5),
(1, 12, 6),
(1, 13, 1),
(1, 13, 2),
(1, 13, 3),
(1, 13, 4),
(1, 13, 5),
(1, 13, 6),
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
(1, 16, 1),
(1, 16, 2),
(1, 16, 3),
(1, 16, 4),
(1, 16, 5),
(1, 16, 6),
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
(1, 18, 7),
(1, 19, 1),
(1, 19, 2),
(1, 19, 3),
(1, 19, 4),
(1, 19, 5),
(1, 19, 6),
(1, 19, 7),
(1, 23, 1),
(2, 5, 1),
(2, 5, 2),
(2, 5, 3),
(2, 5, 4),
(2, 5, 5),
(2, 5, 6),
(2, 6, 1),
(2, 6, 2),
(2, 6, 3),
(2, 6, 4),
(2, 6, 5),
(2, 6, 6),
(2, 7, 1),
(2, 7, 2),
(2, 7, 3),
(2, 7, 4),
(2, 7, 5),
(2, 7, 6),
(2, 8, 1),
(2, 8, 2),
(2, 8, 3),
(2, 8, 4),
(2, 8, 5),
(2, 8, 6),
(2, 9, 1),
(2, 9, 2),
(2, 9, 3),
(2, 9, 4),
(2, 9, 5),
(2, 9, 6),
(2, 10, 1),
(2, 10, 2),
(2, 10, 3),
(2, 10, 4),
(2, 10, 5),
(2, 10, 6),
(2, 11, 1),
(2, 11, 2),
(2, 11, 3),
(2, 11, 4),
(2, 11, 5),
(2, 11, 6),
(2, 12, 1),
(2, 12, 2),
(2, 12, 3),
(2, 12, 4),
(2, 12, 5),
(2, 12, 6),
(2, 13, 1),
(2, 13, 2),
(2, 13, 3),
(2, 13, 4),
(2, 13, 5),
(2, 13, 6),
(2, 15, 1),
(2, 15, 2),
(2, 15, 3),
(2, 15, 4),
(2, 15, 5),
(2, 15, 6),
(2, 16, 1),
(2, 16, 2),
(2, 16, 3),
(2, 16, 4),
(2, 16, 5),
(2, 16, 6),
(2, 17, 1),
(2, 17, 2),
(2, 17, 3),
(2, 17, 4),
(2, 17, 5),
(2, 17, 6),
(2, 18, 1),
(2, 18, 2),
(2, 18, 3),
(2, 18, 4),
(2, 18, 5),
(2, 18, 6),
(2, 18, 7),
(2, 19, 1),
(2, 19, 2),
(2, 19, 3),
(2, 19, 4),
(2, 19, 5),
(2, 19, 6),
(2, 19, 7),
(3, 17, 1),
(3, 17, 2),
(3, 17, 3),
(3, 17, 4),
(3, 17, 5),
(3, 17, 6),
(3, 18, 1),
(3, 18, 2),
(3, 18, 3),
(3, 18, 4),
(3, 18, 5),
(3, 18, 6),
(3, 18, 7),
(3, 19, 1),
(3, 19, 2),
(3, 19, 3),
(3, 19, 4),
(3, 19, 5),
(3, 19, 6),
(3, 19, 7),
(4, 18, 1),
(4, 18, 2),
(4, 18, 3),
(4, 18, 4),
(4, 18, 5),
(4, 18, 6),
(4, 18, 7),
(4, 19, 1),
(4, 19, 2),
(4, 19, 3),
(4, 19, 4),
(4, 19, 5),
(4, 19, 6),
(4, 19, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tfg`
--

CREATE TABLE `tfg` (
  `id_tfg` int(11) NOT NULL,
  `titulo` text COLLATE utf8_spanish_ci NOT NULL,
  `dni_profesor` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `tfg`
--

TRUNCATE TABLE `tfg`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulacion`
--

CREATE TABLE `titulacion` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_CENTRO` int(10) NOT NULL,
  `codigo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `titulacion`
--

TRUNCATE TABLE `titulacion`;
--
-- Volcado de datos para la tabla `titulacion`
--

INSERT INTO `titulacion` (`id`, `id_ANHOACADEMICO`, `id_CENTRO`, `codigo`, `nombre`, `responsable`, `borrado`) VALUES
(1, '2019/2020', 1, '123456789', 'Ingenieria Informatica', NULL, 0),
(2, '2019/2020', 1, '7895648', 'Master en Ingenieria Informatica', NULL, 0),
(3, '2019/2020', 2, '46629756', 'Enfermeria', NULL, 0),
(4, '2019/2020', 2, '1472345', 'Medicina', NULL, 0),
(5, '2019/2020', 3, '4698498', 'Arquitectura', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutoria`
--

CREATE TABLE `tutoria` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `horario` time NOT NULL,
  `id_PROFESOR` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `tutoria`
--

TRUNCATE TABLE `tutoria`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidad`
--

CREATE TABLE `universidad` (
  `id` int(10) NOT NULL,
  `id_ANHOACADEMICO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `responsable` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `universidad`
--

TRUNCATE TABLE `universidad`;
--
-- Volcado de datos para la tabla `universidad`
--

INSERT INTO `universidad` (`id`, `id_ANHOACADEMICO`, `nombre`, `ciudad`, `responsable`, `borrado`) VALUES
(1, '2019/2020', 'Uvigo', 'Ourense', '12345679B', 0),
(2, '2019/2020', 'USC', 'Santiago de Compostela', '12345745C', 0),
(3, '2019/2020', 'UDC', 'Universidade da Coruna', '45627896T', 0),
(4, '2019/2020', 'Uvigo', 'Ourense', '12345679B', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `dni` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `password` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `usuario`
--

TRUNCATE TABLE `usuario`;
--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `nombre`, `apellidos`, `email`, `password`, `borrado`) VALUES
('12345670B', 'Pepe', 'Sanchez', 'pepe@email.com', '926e27eecdbc7a18858b3798ba99bddd', 0),
('12345678L', 'Admin', 'Apellidos Admin', 'admin@email.com', '21232f297a57a5a743894a0e4a801fc3', 0),
('12345679B', 'Carlos', 'Perez', 'carlos@email.com', 'dc599a9972fde3045dab59dbd1ae170b', 0),
('12345745C', 'Juan', 'Lopez', 'juan@email.com', 'a94652aa97c7211ba8954dd15a3cf838', 0),
('12549535E', 'Javier', 'Rodeiro', 'javier@email.com', '3c9c03d6008a5adf42c2a55dd4a1a9f2', 0),
('23432343F', 'Fernando', 'Mondo', 'fer@email.com', '90eb8760c187a2097884ed4c9ffbb6a4', 0),
('34534543R', 'Luisa', 'Monte', 'luisa@email.com', '327229a1f11cc3c7ce66ee5d1341ae51', 0),
('35577002G', 'Julio', 'Patricio', 'j@gmail.com', 'abc123..!!', 0),
('42641234F', 'Fran', 'Barros', 'fran@email.com', '2c20cb5558626540a1704b1fe524ea9a', 0),
('45627896T', 'Pedro', 'Diaz', 'pedro@email.com', 'c6cc8094c2dc07b700ffcc36d64e2138', 0),
('56874952B', 'Maria', 'Giraldez', 'maria@email.com', '263bce650e68ab4e23f28263760b9fa5', 0),
('77151036C', 'Antonio', 'Fernandez', 'antonio@email.com', '4a181673429f0b6abbfd452f0f3b5950', 0),
('87687264F', 'Roberto', 'Justo', 'roberto@email.com', 'c1bfc188dba59d2681648aa0e6ca8c8e', 0),
('91376283C', 'Julio', 'Perez', 'julio@email.com', 'c027636003b468821081e281758e35ff', 0),
('96578631R', 'Laura', 'Ferreiro', 'laura@email.com', '680e89809965ec41e64dc7e447f175ab', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `id_USUARIO` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_ROL` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Truncar tablas antes de insertar `usuario_rol`
--

TRUNCATE TABLE `usuario_rol`;
--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`id_USUARIO`, `id_ROL`) VALUES
('12345670B', 3),
('12345678L', 1),
('12345679B', 2),
('12345745C', 2),
('12549535E', 4),
('35577002G', 1),
('45627896T', 2),
('56874952B', 3),
('77151036C', 4),
('91376283C', 4),
('96578631R', 3);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
