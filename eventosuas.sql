-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2023 a las 04:55:45
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
-- Base de datos: `eventosuas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistentes`
--

CREATE TABLE `asistentes` (
  `id_asistente` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `grupo` varchar(5) NOT NULL,
  `facultad` int(11) NOT NULL,
  `evento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asistentes`
--

INSERT INTO `asistentes` (`id_asistente`, `nombre`, `apellido_paterno`, `apellido_materno`, `grupo`, `facultad`, `evento`) VALUES
(1, 'Jose Angel', 'Placencia', 'Lizarraga', '4-2', 1, 31),
(2, 'Marco', 'Rodriguez', 'Angulo', '4-2', 3, 34),
(3, 'Diana', 'Camargo', 'Saracho', '3-2', 1, 31),
(4, 'Pedro', 'Garcia', 'Garcia', '3-2', 1, 31),
(5, 'Juan', 'Perez', 'Perez', '3-2', 1, 31),
(6, 'Caro', 'Meza', 'Ruiz', '4-2', 1, 31),
(7, 'Daniel', 'Salas', 'Salas', '3-2', 1, 31),
(8, 'Gael', 'Sanchez', 'Luna', '3-1', 1, 31),
(9, 'Sandra', 'Lara', 'Lara', '3-1', 1, 31),
(10, 'Laura', 'Mora', 'Osuna', '3-1', 1, 31),
(11, 'Daniela', 'Zarate', 'Galvan', '2-2', 1, 31),
(12, 'Paul', 'Sanchez', 'Garcia', '2-2', 1, 31),
(13, 'Gael', 'Santos', 'Osuna', '2-1', 1, 31),
(14, 'Pedro', 'Osuna', 'Osuna', '2-1', 1, 31),
(16, 'Edgar', 'Sanchez', 'Lizarraga', '3-1', 1, 34),
(17, 'Jose Angel', 'Placencia', 'Lizarraga', '4-2', 1, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `expositor` varchar(100) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime NOT NULL,
  `tipo_evento` enum('Concurso','Conferencia','Ponencia','Demostración de laboratorio','Recorrido virtual','Cartel de investigacion','Exposición','Foro','Panel','Coloquio','Taller','Conversatorio','Visita guiada','Actividad cultural','Actividad deportiva') NOT NULL,
  `sede` int(11) NOT NULL,
  `facultad` int(11) NOT NULL,
  `programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `title`, `expositor`, `start`, `end`, `tipo_evento`, `sede`, `facultad`, `programa`) VALUES
(31, 'Taller fimaz', 'po', '2023-02-06 09:00:00', '2023-02-08 13:37:00', 'Coloquio', 6, 1, 1),
(32, 'Conferencia faciso', 'sd', '2023-02-06 09:00:00', '2023-02-08 13:40:00', 'Panel', 7, 2, 1),
(34, 'vicerrectoria', 'juan', '2023-02-06 09:00:00', '2023-02-10 13:06:00', 'Panel', 8, 3, 1),
(38, 'Platica Emprendedores', 'Diana Camargo', '2023-02-12 10:00:00', '2023-02-13 10:00:00', 'Conferencia', 6, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultades`
--

CREATE TABLE `facultades` (
  `id_facultad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nombre_corto` varchar(100) NOT NULL,
  `color_boton` varchar(8) NOT NULL,
  `color_sombra` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facultades`
--

INSERT INTO `facultades` (`id_facultad`, `nombre`, `nombre_corto`, `color_boton`, `color_sombra`) VALUES
(1, 'Facultad de Informática Mazatlán', 'FIMAZ', '3d7fcb', '2e6099'),
(2, 'Facultad de Ciencias Sociales', 'FACISO', '353972', '222447'),
(3, 'Vicerrectoria', 'Vicerrectoria', '', ''),
(4, 'Facultad de Ciencias Economico Administrativas de Mazatlan', 'FACEAM', '0045bb', '002666');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id_programa` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `programas`
--

INSERT INTO `programas` (`id_programa`, `nombre`) VALUES
(1, 'CITIS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id_sede` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `facultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id_sede`, `nombre`, `capacidad`, `facultad`) VALUES
(6, 'Laboratorio de computo', 40, 1),
(7, 'Auditorio', 100, 2),
(8, 'Teatro', 150, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contra` varchar(50) NOT NULL,
  `facultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido_paterno`, `apellido_materno`, `usuario`, `contra`, `facultad`) VALUES
(1, 'Rogelio', 'Estrada', 'Lizarraga', 'fimaz', 'fimaz123', 1),
(2, 'Jose Angel', 'Placencia', 'Lizarraga', 'faciso', 'faciso123', 2),
(3, 'Pedro', 'Osuna', 'Rodriguez', 'faceam', 'faceam123', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD PRIMARY KEY (`id_asistente`),
  ADD KEY `evento` (`evento`),
  ADD KEY `facultad` (`facultad`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `sede` (`sede`),
  ADD KEY `programa` (`programa`),
  ADD KEY `facultad` (`facultad`);

--
-- Indices de la tabla `facultades`
--
ALTER TABLE `facultades`
  ADD PRIMARY KEY (`id_facultad`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id_programa`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id_sede`),
  ADD KEY `facultad` (`facultad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `facultad` (`facultad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistentes`
--
ALTER TABLE `asistentes`
  MODIFY `id_asistente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `facultades`
--
ALTER TABLE `facultades`
  MODIFY `id_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `programas`
--
ALTER TABLE `programas`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id_sede` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistentes`
--
ALTER TABLE `asistentes`
  ADD CONSTRAINT `asistentes_ibfk_3` FOREIGN KEY (`facultad`) REFERENCES `facultades` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `asistentes_ibfk_4` FOREIGN KEY (`evento`) REFERENCES `eventos` (`id_evento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`sede`) REFERENCES `sedes` (`id_sede`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `eventos_ibfk_2` FOREIGN KEY (`programa`) REFERENCES `programas` (`id_programa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `eventos_ibfk_3` FOREIGN KEY (`facultad`) REFERENCES `facultades` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD CONSTRAINT `sedes_ibfk_1` FOREIGN KEY (`facultad`) REFERENCES `facultades` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`facultad`) REFERENCES `facultades` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
