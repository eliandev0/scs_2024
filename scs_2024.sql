-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2024 a las 11:55:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `scs_2024`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scs_administradores`
--

CREATE TABLE `scs_administradores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido1` varchar(150) NOT NULL,
  `apellido2` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` set('ADMINISTRADOR') NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ipUltimoAcceso` varchar(20) NOT NULL,
  `fechaHoraUltimoAcceso` datetime DEFAULT NULL,
  `numeroIntentosFallidos` int(11) NOT NULL,
  `tokenPasswordOlvidada` varchar(255) DEFAULT NULL,
  `bloqueado` tinyint(1) NOT NULL,
  `areaTrabajo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `scs_administradores`
--

INSERT INTO `scs_administradores` (`id`, `nombre`, `apellido1`, `apellido2`, `email`, `password`, `rol`, `telefono`, `ipUltimoAcceso`, `fechaHoraUltimoAcceso`, `numeroIntentosFallidos`, `tokenPasswordOlvidada`, `bloqueado`, `areaTrabajo`) VALUES
(67, 'Root', 'Root', 'Root', 'root@scs.es', '$2y$10$I0mU39fEJ0roN0hpQV1lfuE3BQ2MzXm5I0HY40.R4lZJ3F3IHl6Da', 'ADMINISTRADOR', '+34600202020', '', '2024-05-31 20:47:19', 0, NULL, 0, 'Administración de Sistemas'),
(73, 'Elian', 'De Valois', 'Revuelta', 'elian.d@scs.es', '$2y$10$S/ArqxVs57H9IkFcpeJkIuz00DU6fFAa7S4YocZNitYpSS0ShOqS6', 'ADMINISTRADOR', '+34600202020', '', '2024-05-31 20:47:58', 0, NULL, 0, 'Administración de Sistemas'),
(95, 'Pepe', 'Sanchez', 'Tamaimo', 'pepe.s@scs.es', '$2y$10$j9O6yzygwR.ysl8QdPCLpe5wGYt3REJB9B7vluKX.qrIwlEs1qoJC', 'ADMINISTRADOR', '+34666666666', '', NULL, 0, '', 0, 'Administración de Sistemas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scs_ambulatorios`
--

CREATE TABLE `scs_ambulatorios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `scs_ambulatorios`
--

INSERT INTO `scs_ambulatorios` (`id`, `nombre`, `direccion`, `telefono`) VALUES
(1, 'Tomé Cano', 'Calle Tomé cano, 23', '+34922252525'),
(2, 'San Benito', 'Calle San Benito, 24', '+34922262626'),
(3, 'La Salud', 'Calle La Salud, 23', '+34922282828'),
(4, 'María Jiménez', 'Calle María Jiménez, 89', '+34922292929'),
(5, 'Anaga', 'Calle Anaga, 32', '+34922698542'),
(6, 'Candelaria', 'Calle Candelaria, 23', '+34922212121');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scs_consultas`
--

CREATE TABLE `scs_consultas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `idAmbulatorio` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `scs_consultas`
--

INSERT INTO `scs_consultas` (`id`, `nombre`, `idAmbulatorio`) VALUES
(1, 'Tomé Cano 1', 1),
(2, 'Tomé Cano 2', 1),
(3, 'San Benito 1', 2),
(4, 'San Benito 2', 2),
(5, 'La Salud 1', 3),
(6, 'La Salud 2', 3),
(7, 'María Jiménez 1', 4),
(8, 'María Jiménez 2', 4),
(9, 'Anaga 1', 5),
(10, 'Anaga 2', 5),
(11, 'Candelaria 1', 6),
(12, 'Candelaria 2', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scs_enfermeros`
--

CREATE TABLE `scs_enfermeros` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido1` varchar(150) NOT NULL,
  `apellido2` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` set('ENFERMERO') NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ipUltimoAcceso` varchar(20) NOT NULL,
  `fechaHoraUltimoAcceso` datetime DEFAULT NULL,
  `numeroIntentosFallidos` int(11) NOT NULL,
  `tokenPasswordOlvidada` varchar(255) DEFAULT NULL,
  `bloqueado` tinyint(1) NOT NULL,
  `numeroColegiado` int(11) NOT NULL,
  `idConsulta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `scs_enfermeros`
--

INSERT INTO `scs_enfermeros` (`id`, `nombre`, `apellido1`, `apellido2`, `email`, `password`, `rol`, `telefono`, `ipUltimoAcceso`, `fechaHoraUltimoAcceso`, `numeroIntentosFallidos`, `tokenPasswordOlvidada`, `bloqueado`, `numeroColegiado`, `idConsulta`) VALUES
(2, 'Carlos', 'García', 'Martínez', 'carlos.g@scs.es', 'password123', 'ENFERMERO', '+34600123456', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1001, 1),
(3, 'María', 'López', 'González', 'maria.l@scs.es', 'password123', 'ENFERMERO', '+34600123457', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1002, 1),
(4, 'Juan', 'Rodríguez', 'Fernández', 'juan.r@scs.es', 'password123', 'ENFERMERO', '+34600123458', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1003, 1),
(5, 'Ana', 'Hernández', 'García', 'ana.h@scs.es', 'password123', 'ENFERMERO', '+34600123459', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1004, 1),
(6, 'Luis', 'Martín', 'López', 'luis.m@scs.es', 'password123', 'ENFERMERO', '+34600123460', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1005, 1),
(7, 'Elena', 'Díaz', 'Martínez', 'elena.d@scs.es', 'password123', 'ENFERMERO', '+34600123461', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1006, 1),
(8, 'Pablo', 'Pérez', 'Rodríguez', 'pablo.p@scs.es', 'password123', 'ENFERMERO', '+34600123462', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1007, 1),
(9, 'Lucía', 'Gómez', 'Fernández', 'lucia.g@scs.es', 'password123', 'ENFERMERO', '+34600123463', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1008, 1),
(10, 'Miguel', 'Ruiz', 'García', 'miguel.r@scs.es', 'password123', 'ENFERMERO', '+34600123464', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1009, 1),
(11, 'Laura', 'Jiménez', 'González', 'laura.j@scs.es', 'password123', 'ENFERMERO', '+34600123465', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1010, 1),
(12, 'Antonio', 'Moreno', 'López', 'antonio.m@scs.es', 'password123', 'ENFERMERO', '+34600123466', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1011, 1),
(13, 'Sara', 'Hernández', 'Martínez', 'sara.h@scs.es', 'password123', 'ENFERMERO', '+34600123467', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1012, 1),
(14, 'Javier', 'Gutiérrez', 'Rodríguez', 'javier.g@scs.es', 'password123', 'ENFERMERO', '+34600123468', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1013, 1),
(15, 'Cristina', 'Sánchez', 'Fernández', 'cristina.s@scs.es', 'password123', 'ENFERMERO', '+34600123469', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1014, 1),
(16, 'Daniel', 'Ramírez', 'García', 'daniel.r@scs.es', 'password123', 'ENFERMERO', '+34600123470', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1015, 1),
(17, 'Raquel', 'Castro', 'González', 'raquel.c@scs.es', 'password123', 'ENFERMERO', '+34600123471', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1016, 1),
(18, 'Pedro', 'Ortega', 'López', 'pedro.o@scs.es', 'password123', 'ENFERMERO', '+34600123472', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1017, 1),
(19, 'Natalia', 'Vargas', 'Martínez', 'natalia.v@scs.es', 'password123', 'ENFERMERO', '+34600123473', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1018, 1),
(20, 'Roberto', 'Silva', 'Rodríguez', 'roberto.s@scs.es', 'password123', 'ENFERMERO', '+34600123474', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1019, 1),
(21, 'Patricia', 'Molina', 'Fernández', 'patricia.m@scs.es', 'password123', 'ENFERMERO', '+34600123475', '192.168.1.1', '2024-05-25 12:31:29', 0, NULL, 0, 1020, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scs_medicos`
--

CREATE TABLE `scs_medicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido1` varchar(150) NOT NULL,
  `apellido2` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` set('MÉDICO') NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ipUltimoAcceso` varchar(20) NOT NULL,
  `fechaHoraUltimoAcceso` datetime DEFAULT NULL,
  `numeroIntentosFallidos` int(11) NOT NULL,
  `bloqueado` tinyint(1) NOT NULL,
  `tokenPasswordOlvidada` varchar(255) DEFAULT NULL,
  `especialidad` varchar(150) NOT NULL,
  `numeroColegiado` int(11) NOT NULL,
  `idConsulta` int(11) NOT NULL,
  `idAmbulatorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `scs_medicos`
--

INSERT INTO `scs_medicos` (`id`, `nombre`, `apellido1`, `apellido2`, `email`, `password`, `rol`, `telefono`, `ipUltimoAcceso`, `fechaHoraUltimoAcceso`, `numeroIntentosFallidos`, `bloqueado`, `tokenPasswordOlvidada`, `especialidad`, `numeroColegiado`, `idConsulta`, `idAmbulatorio`) VALUES
(37, 'Jorge', 'Torres', 'Ramírez', 'jorge.t@scs.es', 'password123', 'MÉDICO', '+34600123476', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'MEDICINA FAMILIAR', 3001, 2, 2),
(38, 'Marta', 'Vega', 'Suárez', 'marta.v@scs.es', 'password123', 'MÉDICO', '+34600123477', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'PEDIATRÍA', 3002, 2, 4),
(39, 'Andrés', 'Navarro', 'Santos', 'andres.n@scs.es', 'password123', 'MÉDICO', '+34600123478', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'UROLOGÍA', 3003, 2, 4),
(40, 'Clara', 'Ortiz', 'Méndez', 'clara.o@scs.es', '$2y$10$eFF72R1ZW.PrCcsHylf5NuBfF.nNQTuT8EC3fSMtMC0L/6Hc8R3xW', 'MÉDICO', '+34600123479', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'MEDICINA FAMILIAR', 3004, 1, 0),
(41, 'Emilio', 'Ramos', 'Castillo', 'emilio.r@scs.es', 'password123', 'MÉDICO', '+34600123480', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'TRAUMATOLOGÍA', 3005, 2, 6),
(42, 'Julia', 'Flores', 'Núñez', 'julia.f@scs.es', 'password123', 'MÉDICO', '+34600123481', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'MEDICINA FAMILIAR', 3006, 1, 3),
(43, 'Hugo', 'Iglesias', 'Romero', 'hugo.i@scs.es', 'password123', 'MÉDICO', '+34600123482', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'PEDIATRÍA', 3007, 1, 5),
(44, 'Alicia', 'Castro', 'Lara', 'alicia.c@scs.es', 'password123', 'MÉDICO', '+34600123483', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'UROLOGÍA', 3008, 1, 3),
(45, 'Fernando', 'Blanco', 'Perez', 'fernando.b@scs.es', '$2y$10$49lx3mQUY9Yhcru2EEwTouiMZcfT4LA2Aq9h5IQu5D1oftZJfxL5W', 'MÉDICO', '+34600123484', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'GINECOLOGÍA', 3009, 2, 0),
(46, 'Isabel', 'Lorenzo', 'Pascual', 'isabel.l@scs.es', 'password123', 'MÉDICO', '+34600123485', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'TRAUMATOLOGÍA', 3010, 1, 5),
(47, 'Raúl', 'Cabrera', 'Serrano', 'raul.c@scs.es', 'password123', 'MÉDICO', '+34600123486', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'MEDICINA FAMILIAR', 3011, 2, 3),
(48, 'Teresa', 'Reyes', 'Molina', 'teresa.r@scs.es', 'password123', 'MÉDICO', '+34600123487', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'PEDIATRÍA', 3012, 2, 5),
(49, 'Sergio', 'Domínguez', 'Ríos', 'sergio.d@scs.es', 'password123', 'MÉDICO', '+34600123488', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'UROLOGÍA', 3013, 2, 3),
(50, 'Cristina', 'Fuentes', 'Peña', 'cristina.f@scs.es', 'password123', 'MÉDICO', '+34600123489', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'GINECOLOGÍA', 3014, 1, 2),
(51, 'Iván', 'Mendoza', 'Vargas', 'ivan.m@scs.es', 'password123', 'MÉDICO', '+34600123490', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'TRAUMATOLOGÍA', 3015, 2, 5),
(52, 'Paula', 'Soto', 'Carrasco', 'paula.s@scs.es', 'password123', 'MÉDICO', '+34600123491', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'MEDICINA FAMILIAR', 3016, 1, 4),
(53, 'Álvaro', 'Cruz', 'Paredes', 'alvaro.c@scs.es', 'password123', 'MÉDICO', '+34600123492', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'PEDIATRÍA', 3017, 1, 6),
(54, 'Silvia', 'Sanz', 'Miranda', 'silvia.s@scs.es', 'password123', 'MÉDICO', '+34600123493', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'UROLOGÍA', 3018, 1, 2),
(55, 'Eduardo', 'Nieto', 'Calvo', 'eduardo.n@scs.es', 'password123', 'MÉDICO', '+34600123494', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'GINECOLOGÍA', 3019, 1, 2),
(56, 'Inés', 'Pardo', 'Ortega', 'ines.p@scs.es', 'password123', 'MÉDICO', '+34600123495', '192.168.1.1', '2024-05-25 12:41:37', 0, 0, '', 'TRAUMATOLOGÍA', 3020, 1, 4),
(58, 'Tomate', 'La Parra', 'Herrera', 'tomate.l@scs.es', '$2y$10$XRT.pmZcmLetAfMrMqRw9ertFrCZCNo3IGM/ucDSIQSyGR3DZrQWe', 'MÉDICO', '+34698556325', '', NULL, 0, 0, NULL, 'TRAUMATOLOGÍA', 1234, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scs_mensajes`
--

CREATE TABLE `scs_mensajes` (
  `id` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `enviarYa` tinyint(1) NOT NULL,
  `enviado` tinyint(1) NOT NULL,
  `fechaEnvio` datetime NOT NULL,
  `erroresEnvio` tinyint(1) NOT NULL,
  `textoErroresEnvio` text NOT NULL,
  `responderA` varchar(255) NOT NULL,
  `asuntoMensaje` varchar(255) NOT NULL,
  `textoMensaje` text NOT NULL,
  `emailDestinatarios` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`emailDestinatarios`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scs_pacientes`
--

CREATE TABLE `scs_pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido1` varchar(150) NOT NULL,
  `apellido2` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` set('PACIENTE') NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ipUltimoAcceso` varchar(20) NOT NULL,
  `fechaHoraUltimoAcceso` datetime DEFAULT NULL,
  `numeroIntentosFallidos` int(11) NOT NULL,
  `tokenPasswordOlvidada` varchar(255) DEFAULT NULL,
  `bloqueado` tinyint(1) NOT NULL,
  `cip` varchar(100) NOT NULL,
  `csv` int(11) NOT NULL,
  `idConsulta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `scs_pacientes`
--

INSERT INTO `scs_pacientes` (`id`, `nombre`, `apellido1`, `apellido2`, `email`, `password`, `rol`, `telefono`, `ipUltimoAcceso`, `fechaHoraUltimoAcceso`, `numeroIntentosFallidos`, `tokenPasswordOlvidada`, `bloqueado`, `cip`, `csv`, `idConsulta`) VALUES
(2, 'Lucas', 'Mendoza', 'Santos', 'lucas.m@scs.es', 'password123', 'PACIENTE', '+34600123496', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'LMS123456789012', 1234, 1),
(3, 'Elena', 'Martínez', 'Hernández', 'elena.m@scs.es', 'password123', 'PACIENTE', '+34600123497', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'EMH123456789012', 1235, 1),
(4, 'Diego', 'Moreno', 'Lara', 'diego.m@scs.es', 'password123', 'PACIENTE', '+34600123498', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'DML123456789012', 1236, 1),
(5, 'Nuria', 'Pérez', 'García', 'nuria.p@scs.es', 'password123', 'PACIENTE', '+34600123499', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'NPG123456789012', 1237, 1),
(6, 'Adrián', 'Ramírez', 'Gil', 'adrian.r@scs.es', 'password123', 'PACIENTE', '+34600123500', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'ARG123456789012', 1238, 1),
(7, 'Sofía', 'López', 'Núñez', 'sofia.l@scs.es', 'password123', 'PACIENTE', '+34600123501', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'SLN123456789012', 1239, 1),
(8, 'David', 'González', 'Ortiz', 'david.g@scs.es', 'password123', 'PACIENTE', '+34600123502', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'DGO123456789012', 1240, 1),
(9, 'Laura', 'Jiménez', 'Martín', 'laura.j@scs.es', 'password123', 'PACIENTE', '+34600123503', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'LJM123456789012', 1241, 1),
(10, 'Alberto', 'Ruiz', 'Fernández', 'alberto.r@scs.es', 'password123', 'PACIENTE', '+34600123504', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'ARF123456789012', 1242, 1),
(11, 'Marta', 'Díaz', 'Sánchez', 'marta.d@scs.es', 'password123', 'PACIENTE', '+34600123505', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'MDS123456789012', 1243, 1),
(12, 'Pedro', 'Hernández', 'Cruz', 'pedro.h@scs.es', 'password123', 'PACIENTE', '+34600123506', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'PHC123456789012', 1244, 1),
(13, 'Carmen', 'Suárez', 'Molina', 'carmen.s@scs.es', 'password123', 'PACIENTE', '+34600123507', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'CSM123456789012', 1245, 1),
(14, 'Manuel', 'Gómez', 'Blanco', 'manuel.g@scs.es', 'password123', 'PACIENTE', '+34600123508', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'MGB123456789012', 1246, 1),
(15, 'Raquel', 'Santos', 'Lara', 'raquel.s@scs.es', 'password123', 'PACIENTE', '+34600123509', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'RSL123456789012', 1247, 1),
(16, 'Sergio', 'Gil', 'Castro', 'sergio.g@scs.es', 'password123', 'PACIENTE', '+34600123510', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'SGC123456789012', 1248, 1),
(17, 'Teresa', 'Vega', 'Peña', '', 'password123', 'PACIENTE', '+34600123511', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'TVP123456789012', 1249, 1),
(18, 'José', 'Navarro', 'Martínez', 'jose.n@scs.es', 'password123', 'PACIENTE', '+34600123512', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'JNM123456789012', 1250, 1),
(19, 'Ana', 'Lara', 'Santos', 'ana.l@scs.es', 'password123', 'PACIENTE', '+34600123513', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'ALS123456789012', 1251, 1),
(20, 'Miguel', 'Castillo', 'Reyes', 'miguel.c@scs.es', 'password123', 'PACIENTE', '+34600123514', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'MCR123456789012', 1252, 1),
(21, 'Lucía', 'Ortega', 'Vargas', 'lucia.o@scs.es', 'password123', 'PACIENTE', '+34600123515', '192.168.1.1', '2024-05-25 12:52:54', 0, NULL, 0, 'LOV123456789012', 1253, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `scs_administradores`
--
ALTER TABLE `scs_administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tokenPasswordOlvidada` (`tokenPasswordOlvidada`);

--
-- Indices de la tabla `scs_ambulatorios`
--
ALTER TABLE `scs_ambulatorios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `scs_consultas`
--
ALTER TABLE `scs_consultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `scs_enfermeros`
--
ALTER TABLE `scs_enfermeros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `scs_medicos`
--
ALTER TABLE `scs_medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `scs_pacientes`
--
ALTER TABLE `scs_pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cip` (`cip`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `scs_administradores`
--
ALTER TABLE `scs_administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT de la tabla `scs_ambulatorios`
--
ALTER TABLE `scs_ambulatorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `scs_consultas`
--
ALTER TABLE `scs_consultas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `scs_enfermeros`
--
ALTER TABLE `scs_enfermeros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `scs_medicos`
--
ALTER TABLE `scs_medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `scs_pacientes`
--
ALTER TABLE `scs_pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
