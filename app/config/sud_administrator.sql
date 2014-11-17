-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2014 a las 16:24:47
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sud_administrator`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_aseguradora`
--

DROP TABLE IF EXISTS `sa_aseguradora`;
CREATE TABLE IF NOT EXISTS `sa_aseguradora` (
  `id` int(21) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `activado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_aseguradora`
--

INSERT INTO `sa_aseguradora` (`id`, `nombre`, `codigo`, `activado`) VALUES
(1414006201, 'Alianza', 'AL', 1),
(1414006202, 'Credinform', 'CR', 1),
(1414006203, 'Bisa Seguros', 'BS', 1),
(1414006204, 'Nacional Vida', 'NV', 1),
(1414006205, 'Crediseguro', 'CS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_departamento`
--

DROP TABLE IF EXISTS `sa_departamento`;
CREATE TABLE IF NOT EXISTS `sa_departamento` (
  `id` int(21) NOT NULL,
  `departamento` varchar(140) NOT NULL,
  `codigo` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_departamento`
--

INSERT INTO `sa_departamento` (`id`, `departamento`, `codigo`) VALUES
(1414006201, 'La Paz', 'LP'),
(1414006202, 'Oruro', 'OR'),
(1414006203, 'Potosi', 'PT'),
(1414006204, 'Cochabamba', 'CB'),
(1414006205, 'Chuquisaca', 'CH'),
(1414006206, 'Tarija', 'TJ'),
(1414006207, 'Santa Cruz', 'SC'),
(1414006208, 'Beni', 'BE'),
(1414006209, 'Pando', 'PA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_ef_aseguradora`
--

DROP TABLE IF EXISTS `sa_ef_aseguradora`;
CREATE TABLE IF NOT EXISTS `sa_ef_aseguradora` (
  `id` int(21) NOT NULL,
  `entidad_financiera` int(21) NOT NULL,
  `aseguradora` int(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_ef_aseguradora`
--

INSERT INTO `sa_ef_aseguradora` (`id`, `entidad_financiera`, `aseguradora`) VALUES
(1414006201, 1414006207, 1414006205),
(1414006202, 1414006201, 1414006201),
(1414006203, 1414006201, 1414006202),
(1414006204, 1414006201, 1414006205),
(1414006206, 1414006204, 1414006201),
(1414006207, 1414006205, 1414006204),
(1414006208, 1414006206, 1414006204),
(1414006209, 1414006203, 1414006203),
(1414006210, 1414006202, 1414006201);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_ef_producto`
--

DROP TABLE IF EXISTS `sa_ef_producto`;
CREATE TABLE IF NOT EXISTS `sa_ef_producto` (
  `id` int(21) NOT NULL,
  `entidad_financiera` int(21) NOT NULL,
  `producto` int(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_ef_producto`
--

INSERT INTO `sa_ef_producto` (`id`, `entidad_financiera`, `producto`) VALUES
(1414006201, 1414006201, 1414006201),
(1414006202, 1414006201, 1414006202),
(1414006203, 1414006201, 1414006203),
(1414006204, 1414006207, 1414006201),
(1414006205, 1414006206, 1414006201),
(1414006206, 1414006204, 1414006201),
(1414006207, 1414006205, 1414006201),
(1414006208, 1414006203, 1414006202),
(1414006209, 1414006203, 1414006203),
(1414006210, 1414006202, 1414006201);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_ef_usuario`
--

DROP TABLE IF EXISTS `sa_ef_usuario`;
CREATE TABLE IF NOT EXISTS `sa_ef_usuario` (
  `id` int(21) NOT NULL,
  `usuario` int(21) NOT NULL,
  `entidad_financiera` int(21) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_ef_usuario`
--

INSERT INTO `sa_ef_usuario` (`id`, `usuario`, `entidad_financiera`) VALUES
(1414006201, 1414006201, 1414006201),
(1414006202, 1414006201, 1414006202),
(1414006203, 1414006201, 1414006203),
(1414006204, 1414006201, 1414006204),
(1414006205, 1414006201, 1414006205),
(1414006206, 1414006201, 1414006206),
(1414006207, 1414006201, 1414006207);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_entidad_financiera`
--

DROP TABLE IF EXISTS `sa_entidad_financiera`;
CREATE TABLE IF NOT EXISTS `sa_entidad_financiera` (
  `id` int(21) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `dominio` varchar(140) NOT NULL,
  `db_host` varchar(140) NOT NULL,
  `db_database` varchar(140) NOT NULL,
  `db_user` varchar(140) NOT NULL,
  `db_password` varchar(140) NOT NULL,
  `activado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_entidad_financiera`
--

INSERT INTO `sa_entidad_financiera` (`id`, `nombre`, `codigo`, `dominio`, `db_host`, `db_database`, `db_user`, `db_password`, `activado`) VALUES
(1414006201, 'Ecofuturo', 'EC', 'ecofuturo', 'localhost', 'ecofuturo', 'root', '', 1),
(1414006202, 'Sembrar Sartawi', 'SS', 'sembrarsartawi', 'localhost', 'sartawi', 'root', '', 1),
(1414006203, 'Bisa Leasing', 'BL', 'bisaleasing', 'localhost', 'bisa', 'root', '', 1),
(1414006204, 'Emprender', 'EM', 'emprender', 'localhost', 'emprender', 'root', '', 1),
(1414006205, 'Paulo VI', 'PV', 'paulovi', 'localhost', 'paulo', 'root', '', 1),
(1414006206, 'Idepro', 'ID', 'idepro', 'localhost', 'idepro', 'root', '', 1),
(1414006207, 'Crecer', 'CR', 'crecer', 'localhost', 'crecer', 'root', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_producto`
--

DROP TABLE IF EXISTS `sa_producto`;
CREATE TABLE IF NOT EXISTS `sa_producto` (
  `id` int(21) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `activado` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_producto`
--

INSERT INTO `sa_producto` (`id`, `nombre`, `codigo`, `activado`) VALUES
(1414006201, 'Desgravamen', 'DE', 1),
(1414006202, 'Automotores', 'AU', 1),
(1414006203, 'Todo Riesgo', 'TRD', 1),
(1414006204, 'Ramos Tecnicos', 'TRM', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_usuario`
--

DROP TABLE IF EXISTS `sa_usuario`;
CREATE TABLE IF NOT EXISTS `sa_usuario` (
  `id` int(21) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `email` varchar(140) NOT NULL,
  `departamento` int(21) NOT NULL,
  `permiso` int(21) NOT NULL,
  `fechsa_creacion` date NOT NULL,
  `activado` tinyint(1) DEFAULT '0',
  `actualizacion_password` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_usuario`
--

INSERT INTO `sa_usuario` (`id`, `usuario`, `password`, `nombre`, `email`, `departamento`, `permiso`, `fechsa_creacion`, `activado`, `actualizacion_password`) VALUES
(1414006201, 'admin', '$2x$07$zcfSZ2.sE.jOSZdcCGK0geXOjt98pv2iUM22AIdJl.gcjgwYMd44S', 'Administrador', 'mmamani@coboser.com', 1414006201, 1414006201, '2014-10-23', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sa_usuario_permiso`
--

DROP TABLE IF EXISTS `sa_usuario_permiso`;
CREATE TABLE IF NOT EXISTS `sa_usuario_permiso` (
  `id` int(21) NOT NULL,
  `permiso` varchar(140) NOT NULL,
  `codigo` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sa_usuario_permiso`
--

INSERT INTO `sa_usuario_permiso` (`id`, `permiso`, `codigo`) VALUES
(1414006201, 'Administrador', 'ROOT'),
(1414006202, 'Reportes Generales', 'RGR'),
(1414006203, 'Reportes Clientes', 'RCL'),
(1414006204, 'Reportes Generales/Clientes', 'RGC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sa_aseguradora`
--
ALTER TABLE `sa_aseguradora`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `sa_departamento`
--
ALTER TABLE `sa_departamento`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `sa_ef_aseguradora`
--
ALTER TABLE `sa_ef_aseguradora`
 ADD PRIMARY KEY (`id`), ADD KEY `entidad_financiera` (`entidad_financiera`), ADD KEY `aseguradora` (`aseguradora`);

--
-- Indices de la tabla `sa_ef_producto`
--
ALTER TABLE `sa_ef_producto`
 ADD PRIMARY KEY (`id`), ADD KEY `entidad_financiera` (`entidad_financiera`), ADD KEY `producto` (`producto`);

--
-- Indices de la tabla `sa_ef_usuario`
--
ALTER TABLE `sa_ef_usuario`
 ADD PRIMARY KEY (`id`), ADD KEY `usuario` (`usuario`), ADD KEY `entidad_financiera` (`entidad_financiera`);

--
-- Indices de la tabla `sa_entidad_financiera`
--
ALTER TABLE `sa_entidad_financiera`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY (`codigo`, `dominio`);

--
-- Indices de la tabla `sa_producto`
--
ALTER TABLE `sa_producto`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `sa_usuario`
--
ALTER TABLE `sa_usuario`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `usuario` (`usuario`), ADD KEY `departamento` (`departamento`), ADD KEY `permiso` (`permiso`);

--
-- Indices de la tabla `sa_usuario_permiso`
--
ALTER TABLE `sa_usuario_permiso`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sa_ef_aseguradora`
--
ALTER TABLE `sa_ef_aseguradora`
ADD CONSTRAINT `sa_ef_aseguradora_ibfk_1` FOREIGN KEY (`entidad_financiera`) REFERENCES `sa_entidad_financiera` (`id`),
ADD CONSTRAINT `sa_ef_aseguradora_ibfk_2` FOREIGN KEY (`aseguradora`) REFERENCES `sa_aseguradora` (`id`);

--
-- Filtros para la tabla `sa_ef_producto`
--
ALTER TABLE `sa_ef_producto`
ADD CONSTRAINT `sa_ef_producto_ibfk_1` FOREIGN KEY (`entidad_financiera`) REFERENCES `sa_entidad_financiera` (`id`),
ADD CONSTRAINT `sa_ef_producto_ibfk_2` FOREIGN KEY (`producto`) REFERENCES `sa_producto` (`id`);

--
-- Filtros para la tabla `sa_ef_usuario`
--
ALTER TABLE `sa_ef_usuario`
ADD CONSTRAINT `sa_ef_usuario_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `sa_usuario` (`id`),
ADD CONSTRAINT `sa_ef_usuario_ibfk_2` FOREIGN KEY (`entidad_financiera`) REFERENCES `sa_entidad_financiera` (`id`);

--
-- Filtros para la tabla `sa_usuario`
--
ALTER TABLE `sa_usuario`
ADD CONSTRAINT `sa_usuario_ibfk_1` FOREIGN KEY (`departamento`) REFERENCES `sa_departamento` (`id`),
ADD CONSTRAINT `sa_usuario_ibfk_2` FOREIGN KEY (`permiso`) REFERENCES `sa_usuario_permiso` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
