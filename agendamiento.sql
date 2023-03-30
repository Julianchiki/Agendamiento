-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2023 a las 16:17:11
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agendamiento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_doctor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `fecha`, `hora`, `id_paciente`, `id_doctor`) VALUES
(2, '2023-03-30', '15:59:00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorio`
--

CREATE TABLE `consultorio` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consultorio`
--

INSERT INTO `consultorio` (`id`, `numero`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `especialidad` enum('Odontologo','Medico General','Oftalmólogo','Pediatra','Ginecologo') NOT NULL,
  `id_consultorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id`, `nombre`, `apellido`, `especialidad`, `id_consultorio`) VALUES
(1, 'Andres', 'Almario', 'Odontologo', 1),
(2, 'Ruben', 'Delgado', 'Pediatra', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `apellido` text NOT NULL,
  `documento` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellido`, `documento`) VALUES
(1, 'Sonia', 'Diaz', 1083871906);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id`, `nombre`) VALUES
(1, 'Agendar'),
(2, 'Listar'),
(3, 'Acceso'),
(4, 'Consultar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_rol`
--

CREATE TABLE `permiso_rol` (
  `id` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permiso_rol`
--

INSERT INTO `permiso_rol` (`id`, `id_rol`, `id_permiso`) VALUES
(1, 2, 4),
(2, 1, 1),
(3, 1, 2),
(4, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`) VALUES
(1, 'Admin'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `identificacion` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `contrasena` varchar(64) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `telefono` bigint(10) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `identificacion`, `username`, `contrasena`, `nombre`, `apellido`, `telefono`, `correo`, `id_rol`) VALUES
(1, 1083874040, 'Chiki', '$2y$10$O6RhFgWtJBQcVXbqEc0YSeRDYih9yAkRGe7P/zJZbkJTMdlI5YMqC', 'Julian', 'Ramirez', 3118961146, 'julianjavierramirezdiaz73@gmail.com', 1),
(2, 1083871906, 'Mama', '$2y$10$jl1ZG47eoXsE2qfXGqQLi.qTPIjwUWRfTFBtLodYlS.9RiYiJJ9Za', 'Sonia', 'Diaz', 3114746131, 'sonia@gmail.com', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_paciente`),
  ADD KEY `id_doctor` (`id_doctor`);

--
-- Indices de la tabla `consultorio`
--
ALTER TABLE `consultorio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_consultorio` (`id_consultorio`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_permiso` (`id_permiso`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contrasena` (`contrasena`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `consultorio`
--
ALTER TABLE `consultorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`id_doctor`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`);

--
-- Filtros para la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`id_consultorio`) REFERENCES `consultorio` (`id`);

--
-- Filtros para la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD CONSTRAINT `permiso_rol_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`),
  ADD CONSTRAINT `permiso_rol_ibfk_2` FOREIGN KEY (`id_permiso`) REFERENCES `permiso` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
