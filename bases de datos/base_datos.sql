-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2019 a las 16:20:20
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bd_futbolivia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE IF NOT EXISTS `acceso` (
`id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`id`, `menu_id`, `usuario_id`) VALUES
(1, 1, 3),
(2, 6, 3),
(3, 2, 3),
(4, 7, 3),
(5, 8, 3),
(6, 3, 3),
(7, 9, 3),
(8, 2, 4),
(9, 8, 4),
(10, 4, 4),
(11, 18, 4),
(12, 5, 4),
(13, 23, 4),
(14, 6, 3),
(15, 7, 3),
(16, 1, 4),
(17, 6, 4),
(18, 2, 4),
(19, 7, 4),
(20, 1, 5),
(21, 6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE IF NOT EXISTS `actividad` (
`id` int(11) NOT NULL,
  `nombre_actividad` text NOT NULL,
  `telefono` varchar(30) DEFAULT '0',
  `celular` varchar(30) DEFAULT '0',
  `direccion` text NOT NULL,
  `email` text,
  `tipo_impresion` varchar(10) NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `estado` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id`, `nombre_actividad`, `telefono`, `celular`, `direccion`, `email`, `tipo_impresion`, `ciudad`, `sucursal_id`, `estado`) VALUES
(1, 'DEPORTES', '3-4321415', '', 'Calle Antonio de Rojas / Av. paragua Nro. 3830 Barrio Gil Reyes, UV:40,MZA:144A', 'futbolivia@gmail.com', 'ROLLO', 'Santa Cruz - Bolivia', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
`id` int(11) NOT NULL,
  `codigo` text NOT NULL,
  `nombre_categoria` text NOT NULL,
  `estado` varchar(10) NOT NULL DEFAULT 'ACTIVO'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `codigo`, `nombre_categoria`, `estado`) VALUES
(1, '0', 'items', 'ACTIVO'),
(2, '1', 'Sodas', 'ACTIVO'),
(3, '2', 'Otros', 'ACTIVO'),
(4, '3', 'Cervezas', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre_sesion`
--

CREATE TABLE IF NOT EXISTS `cierre_sesion` (
`id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `sesion_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cierre_sesion`
--

INSERT INTO `cierre_sesion` (`id`, `fecha`, `sesion_id`) VALUES
(1, '2018-11-28 19:22:26', 124),
(2, '2018-11-28 19:36:54', 1),
(3, '2018-11-28 20:20:18', 2),
(4, '2018-11-28 20:21:05', 3),
(5, '2018-11-28 20:24:09', 4),
(6, '2018-11-28 20:27:11', 6),
(7, '2018-11-28 20:28:03', 6),
(8, '2018-11-28 20:28:37', 7),
(9, '2018-11-28 20:29:28', 8),
(10, '2018-11-28 20:41:20', 9),
(11, '2018-11-29 11:52:26', 10),
(12, '2018-11-29 16:28:39', 11),
(13, '2018-11-29 22:22:54', 12),
(14, '2018-11-30 01:09:30', 13),
(15, '2018-11-30 04:11:59', 14),
(16, '2018-11-30 04:24:16', 15),
(17, '2018-11-30 04:51:36', 16),
(18, '2018-11-30 04:55:06', 17),
(19, '2018-11-30 05:01:19', 18),
(20, '2018-11-30 19:59:47', 19),
(21, '2018-11-30 20:09:09', 20),
(22, '2018-11-30 20:22:12', 21),
(23, '2018-11-30 20:33:09', 22),
(24, '2018-12-02 02:03:08', 23),
(25, '2018-12-05 14:16:00', 24),
(26, '2018-12-05 14:41:31', 25),
(27, '2018-12-05 14:42:05', 26),
(28, '2018-12-05 14:43:07', 27),
(29, '2018-12-05 14:47:02', 28),
(30, '2018-12-05 14:49:05', 27),
(31, '2018-12-05 15:21:31', 29),
(32, '2018-12-05 15:27:19', 30),
(33, '2018-12-06 01:05:37', 31),
(34, '2018-12-06 02:02:10', 32),
(35, '2018-12-07 03:02:15', 33),
(36, '2018-12-07 14:22:40', 34),
(37, '2018-12-09 00:33:25', 35),
(38, '2018-12-09 01:22:23', 35),
(39, '2018-12-09 01:33:51', 36),
(40, '2018-12-09 21:38:45', 37),
(41, '2018-12-09 21:39:48', 38),
(42, '2019-11-07 21:32:55', 39),
(43, '2019-11-07 21:33:21', 40),
(44, '2019-11-07 21:39:08', 39),
(45, '2019-11-07 21:39:14', 41),
(46, '2019-11-08 22:38:22', 42),
(47, '2019-11-09 16:08:11', 42),
(48, '2019-11-09 16:11:50', 44),
(49, '2019-11-09 16:12:50', 43),
(50, '2019-11-09 16:13:14', 45),
(51, '2019-11-09 16:23:49', 45),
(52, '2019-11-09 16:50:46', 46),
(53, '2019-11-09 17:00:15', 47),
(54, '2019-11-09 17:13:55', 48),
(55, '2019-11-09 17:42:42', 48),
(56, '2019-11-09 17:42:56', 49),
(57, '2019-11-09 17:51:51', 50),
(58, '2019-11-09 18:00:25', 51),
(59, '2019-11-09 18:02:09', 52),
(60, '2019-11-09 19:43:03', 53),
(61, '2019-11-10 01:17:45', 54);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
`id` int(11) NOT NULL,
  `ci_nit` varchar(15) NOT NULL DEFAULT '0',
  `nombre_cliente` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT '0',
  `direccion` text,
  `email` varchar(50) DEFAULT NULL,
  `estado` tinyint(2) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `ci_nit`, `nombre_cliente`, `telefono`, `direccion`, `email`, `estado`) VALUES
(1, '1138600055', 'JUAN CARLOS MORALES VARGAS', '7897545', 'AV BENI', 'juan@gmail.com', 1),
(2, '7845454', 'ELIANA ESPINOZA', '8987654654', 'AV BENI', 'eliana@gmail.com', 0),
(3, '22335564', 'FLAVIA MENDOZA', '69095758', 'CALLE JUNIN 89', 'flavia@gmail.com', 1),
(4, '11223344', 'BRENDA VARGAS', '69095753', 'AV BENI', 'brenda@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE IF NOT EXISTS `detalle_venta` (
`id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `detalle` text NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(20,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `venta_id`, `item_id`, `detalle`, `cantidad`, `precio_venta`) VALUES
(1, 1, 30, '', 1, '7.00'),
(2, 2, 14, '', 1, '13.00'),
(3, 3, 23, '', 1, '10.00'),
(4, 4, 2, '', 1, '13.00'),
(5, 5, 11, '', 1, '6.00'),
(6, 6, 45, '', 1, '12.00'),
(7, 7, 11, '', 1, '6.00'),
(8, 8, 45, '', 2, '12.00'),
(9, 9, 6, '', 1, '6.00'),
(10, 9, 8, '', 1, '12.00'),
(11, 10, 6, '', 2, '6.00'),
(12, 11, 1, '', 1, '10.00'),
(13, 11, 14, '', 1, '13.00'),
(14, 11, 15, '', 1, '15.00'),
(19, 14, 1, '', 1, '10.00'),
(20, 14, 10, '', 1, '6.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dosificacion`
--

CREATE TABLE IF NOT EXISTS `dosificacion` (
`id` int(11) NOT NULL,
  `autorizacion` text NOT NULL,
  `nro_inicio` int(11) NOT NULL DEFAULT '1',
  `llave` text NOT NULL,
  `fecha_limite` date DEFAULT NULL,
  `leyenda` text NOT NULL,
  `fecha_registro` date NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `impresora_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL DEFAULT '1',
  `estado` varchar(10) NOT NULL DEFAULT 'INACTIVO'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dosificacion`
--

INSERT INTO `dosificacion` (`id`, `autorizacion`, `nro_inicio`, `llave`, `fecha_limite`, `leyenda`, `fecha_registro`, `actividad_id`, `impresora_id`, `sucursal_id`, `estado`) VALUES
(1, '3834017000631301', 336890, 'N=$dt\\UDWQ5E7A-f$EWE=4)MXfCNH(F2=TSLI)2@A16@j(IW*2sB76%6VY9U+grdC', '2018-12-14', 'Ley N° 453: Los servicios deben suministrarse en condiciones de inocuidad, calidad y seguridad.', '2017-05-31', 1, 1, 1, 'CADUCADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
`id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `dosificacion_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nro_factura` int(11) NOT NULL,
  `monto_total` decimal(20,2) NOT NULL DEFAULT '0.00',
  `importe_ice` decimal(20,2) DEFAULT '0.00',
  `importe_excento` decimal(20,2) DEFAULT '0.00',
  `ventas_grabadas_taza_cero` decimal(20,2) DEFAULT '0.00',
  `subtotal` decimal(20,2) DEFAULT '0.00',
  `descuento` decimal(20,2) DEFAULT '0.00',
  `importe_base` decimal(20,2) NOT NULL DEFAULT '0.00',
  `debito_fiscal` decimal(20,2) NOT NULL DEFAULT '0.00',
  `codigo_control` varchar(15) NOT NULL DEFAULT '0',
  `estado` char(2) NOT NULL DEFAULT 'V'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id`, `venta_id`, `dosificacion_id`, `fecha`, `nro_factura`, `monto_total`, `importe_ice`, `importe_excento`, `ventas_grabadas_taza_cero`, `subtotal`, `descuento`, `importe_base`, `debito_fiscal`, `codigo_control`, `estado`) VALUES
(1, 1, 1, '2018-12-09', 336890, '7.00', '0.00', '0.00', '0.00', '7.00', '0.00', '7.00', '0.91', '75-45-EF-48-76', 'V'),
(2, 2, 1, '2018-12-09', 336891, '13.00', '0.00', '0.00', '0.00', '13.00', '0.00', '13.00', '1.69', '9E-95-4B-9A-38', 'V'),
(3, 3, 1, '2018-12-09', 336892, '10.00', '0.00', '0.00', '0.00', '10.00', '0.00', '10.00', '1.30', '76-3B-38-40-31', 'V'),
(4, 4, 1, '2018-12-09', 336893, '13.00', '0.00', '0.00', '0.00', '13.00', '0.00', '13.00', '1.69', 'C4-45-14-52-68', 'V'),
(5, 5, 1, '2018-12-09', 336894, '6.00', '0.00', '0.00', '0.00', '6.00', '0.00', '6.00', '0.78', '94-1F-29-72', 'V'),
(6, 6, 1, '2018-12-09', 336895, '12.00', '0.00', '0.00', '0.00', '12.00', '0.00', '12.00', '1.56', '8E-49-F8-EF-21', 'V'),
(7, 7, 1, '2018-12-09', 336896, '6.00', '0.00', '0.00', '0.00', '6.00', '0.00', '6.00', '0.78', '7F-01-E2-C2-07', 'V'),
(8, 8, 1, '2018-12-09', 336897, '24.00', '0.00', '0.00', '0.00', '24.00', '0.00', '24.00', '3.12', '47-38-73-AE', 'V'),
(9, 9, 1, '2018-12-09', 336898, '18.00', '0.00', '0.00', '0.00', '18.00', '0.00', '18.00', '2.34', '14-A7-D5-AE-D0', 'V'),
(10, 10, 1, '2018-12-09', 336899, '12.00', '0.00', '0.00', '0.00', '12.00', '0.00', '12.00', '1.56', '75-4E-4F-BA-F6', 'V'),
(11, 11, 1, '2019-11-07', 336900, '38.00', '0.00', '0.00', '0.00', '38.00', '0.00', '38.00', '4.94', 'ED-EE-60-CE-BE', 'V'),
(12, 14, 1, '2019-11-09', 336901, '16.00', '0.00', '0.00', '0.00', '16.00', '0.00', '16.00', '2.08', 'F8-A6-98-F6-28', 'V');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_datos`
--

CREATE TABLE IF NOT EXISTS `factura_datos` (
  `venta_id` int(11) NOT NULL,
  `autorizacion` varchar(30) NOT NULL,
  `nit_cliente` varchar(20) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `nro_factura` int(11) NOT NULL,
  `monto_total` decimal(20,2) NOT NULL DEFAULT '0.00',
  `importe_ice` decimal(20,2) DEFAULT '0.00',
  `importe_excento` decimal(20,2) DEFAULT '0.00',
  `ventas_grabadas_taza_cero` decimal(20,2) DEFAULT '0.00',
  `subtotal` decimal(20,2) DEFAULT '0.00',
  `descuento` decimal(20,2) DEFAULT '0.00',
  `importe_base` decimal(20,2) NOT NULL DEFAULT '0.00',
  `debito_fiscal` decimal(20,2) NOT NULL DEFAULT '0.00',
  `codigo_control` varchar(15) NOT NULL DEFAULT '0',
  `estado` char(2) NOT NULL DEFAULT 'V',
  `sucursal_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `factura_datos`
--

INSERT INTO `factura_datos` (`venta_id`, `autorizacion`, `nit_cliente`, `nombre_cliente`, `fecha`, `nro_factura`, `monto_total`, `importe_ice`, `importe_excento`, `ventas_grabadas_taza_cero`, `subtotal`, `descuento`, `importe_base`, `debito_fiscal`, `codigo_control`, `estado`, `sucursal_id`, `usuario_id`) VALUES
(1, '3834017000631301', '1138600055', 'JUAN CARLOS MORALES VARGAS', '2018-12-09', 336890, '7.00', '0.00', '0.00', '0.00', '7.00', '0.00', '7.00', '0.91', '75-45-EF-48-76', 'V', 1, 1),
(2, '3834017000631301', '1138600055', 'JUAN CARLOS MORALES VARGAS', '2018-12-09', 336891, '13.00', '0.00', '0.00', '0.00', '13.00', '0.00', '13.00', '1.69', '9E-95-4B-9A-38', 'V', 1, 1),
(3, '3834017000631301', '1138600055', 'JUAN CARLOS MORALES VARGAS', '2018-12-09', 336892, '10.00', '0.00', '0.00', '0.00', '10.00', '0.00', '10.00', '1.30', '76-3B-38-40-31', 'V', 1, 1),
(4, '3834017000631301', '7845454', 'ELIANA ESPINOZA', '2018-12-09', 336893, '13.00', '0.00', '0.00', '0.00', '13.00', '0.00', '13.00', '1.69', 'C4-45-14-52-68', 'V', 1, 1),
(5, '3834017000631301', '7845454', 'ELIANA ESPINOZA', '2018-12-09', 336894, '6.00', '0.00', '0.00', '0.00', '6.00', '0.00', '6.00', '0.78', '94-1F-29-72', 'V', 1, 1),
(6, '3834017000631301', '1138600055', 'JUAN CARLOS MORALES VARGAS', '2018-12-09', 336895, '12.00', '0.00', '0.00', '0.00', '12.00', '0.00', '12.00', '1.56', '8E-49-F8-EF-21', 'V', 1, 1),
(7, '3834017000631301', '1138600055', 'JUAN CARLOS MORALES VARGAS', '2018-12-09', 336896, '6.00', '0.00', '0.00', '0.00', '6.00', '0.00', '6.00', '0.78', '7F-01-E2-C2-07', 'V', 1, 1),
(8, '3834017000631301', '1138600055', 'JUAN CARLOS MORALES VARGAS', '2018-12-09', 336897, '24.00', '0.00', '0.00', '0.00', '24.00', '0.00', '24.00', '3.12', '47-38-73-AE', 'V', 1, 1),
(9, '3834017000631301', '121211', 'ELIANA', '2018-12-09', 336898, '18.00', '0.00', '0.00', '0.00', '18.00', '0.00', '18.00', '2.34', '14-A7-D5-AE-D0', 'V', 1, 1),
(10, '3834017000631301', '7845454', 'ELIANA ESPINOZA', '2018-12-09', 336899, '12.00', '0.00', '0.00', '0.00', '12.00', '0.00', '12.00', '1.56', '75-4E-4F-BA-F6', 'V', 1, 1),
(11, '3834017000631301', '121211', 'ELIANA', '2019-11-07', 336900, '38.00', '0.00', '0.00', '0.00', '38.00', '0.00', '38.00', '4.94', 'ED-EE-60-CE-BE', 'V', 1, 1),
(14, '3834017000631301', '121211', 'ELIANA', '2019-11-09', 336901, '16.00', '0.00', '0.00', '0.00', '16.00', '0.00', '16.00', '2.08', 'F8-A6-98-F6-28', 'V', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impresora`
--

CREATE TABLE IF NOT EXISTS `impresora` (
`id` int(11) NOT NULL,
  `marca` text NOT NULL,
  `serial` varchar(20) NOT NULL DEFAULT 'NA',
  `sucursal_id` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `estado` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `impresora`
--

INSERT INTO `impresora` (`id`, `marca`, `serial`, `sucursal_id`, `activo`, `estado`) VALUES
(1, 'EPSON TM-20II', 'CS100FJ001', 1, 1, 1),
(2, 'EPSON TM-20II', 'TC6F050237', 2, 0, 1),
(3, 'EPSON TM-20II', 'CS100FJ001', 3, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio_sesion`
--

CREATE TABLE IF NOT EXISTS `inicio_sesion` (
`id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `impresora_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inicio_sesion`
--

INSERT INTO `inicio_sesion` (`id`, `fecha`, `usuario_id`, `impresora_id`) VALUES
(1, '2018-11-28 19:22:32', 1, 1),
(2, '2018-11-28 19:56:07', 1, 1),
(3, '2018-11-28 20:20:52', 1, 1),
(4, '2018-11-28 20:21:13', 3, 1),
(5, '2018-11-28 20:24:15', 1, 1),
(6, '2018-11-28 20:24:17', 1, 1),
(7, '2018-11-28 20:28:09', 1, 1),
(8, '2018-11-28 20:28:46', 1, 1),
(9, '2018-11-28 20:29:42', 1, 1),
(10, '2018-11-29 01:32:47', 1, 1),
(11, '2018-11-29 15:56:10', 1, 1),
(12, '2018-11-29 22:17:26', 1, 1),
(13, '2018-11-30 00:31:03', 1, 1),
(14, '2018-11-30 04:02:55', 1, 1),
(15, '2018-11-30 04:16:08', 1, 1),
(16, '2018-11-30 04:25:34', 1, 1),
(17, '2018-11-30 04:53:06', 1, 1),
(18, '2018-11-30 04:56:51', 1, 1),
(19, '2018-11-30 19:38:03', 1, 1),
(20, '2018-11-30 20:00:53', 1, 1),
(21, '2018-11-30 20:10:43', 1, 1),
(22, '2018-11-30 20:25:02', 1, 1),
(23, '2018-12-02 02:02:17', 1, 1),
(24, '2018-12-05 14:13:42', 1, 1),
(25, '2018-12-05 14:18:27', 1, 1),
(26, '2018-12-05 14:41:41', 4, 1),
(27, '2018-12-05 14:42:10', 1, 1),
(28, '2018-12-05 14:43:13', 5, 1),
(29, '2018-12-05 14:53:57', 1, 1),
(30, '2018-12-05 15:26:55', 1, 1),
(31, '2018-12-06 00:15:54', 1, 1),
(32, '2018-12-06 01:10:18', 1, 1),
(33, '2018-12-06 23:41:28', 1, 1),
(34, '2018-12-07 14:07:26', 1, 1),
(35, '2018-12-08 23:23:36', 1, 1),
(36, '2018-12-09 01:26:09', 1, 1),
(37, '2018-12-09 19:06:16', 1, 1),
(38, '2018-12-09 21:38:53', 1, 1),
(39, '2018-12-09 21:39:53', 1, 1),
(40, '2019-11-07 21:33:03', 1, 1),
(41, '2019-11-07 21:33:30', 1, 1),
(42, '2019-11-08 22:11:26', 1, 1),
(43, '2019-11-09 16:11:35', 1, 1),
(44, '2019-11-09 16:11:38', 1, 1),
(45, '2019-11-09 16:13:10', 1, 1),
(46, '2019-11-09 16:29:10', 1, 1),
(47, '2019-11-09 16:51:03', 1, 1),
(48, '2019-11-09 17:00:25', 1, 1),
(49, '2019-11-09 17:14:14', 1, 1),
(50, '2019-11-09 17:44:25', 1, 1),
(51, '2019-11-09 17:53:09', 1, 1),
(52, '2019-11-09 18:01:35', 1, 1),
(53, '2019-11-09 19:32:33', 1, 1),
(54, '2019-11-10 01:04:26', 1, 1),
(55, '2019-11-11 14:37:18', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE IF NOT EXISTS `item` (
`id` int(11) NOT NULL,
  `codigo_barra` varchar(30) NOT NULL,
  `nombre_item` varchar(70) DEFAULT NULL,
  `precio_venta` decimal(20,2) NOT NULL,
  `tamaño` varchar(10) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `estado` varchar(10) NOT NULL DEFAULT '1',
  `sucursal_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id`, `codigo_barra`, `nombre_item`, `precio_venta`, `tamaño`, `stock`, `fecha_registro`, `categoria_id`, `estado`, `sucursal_id`) VALUES
(1, '', 'SALTEÑAS', '10.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(2, '', 'SODA 2LT. PARA LLEVAR', '13.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(3, '', 'SODA 2LT.', '17.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(4, '', 'SODA 1/2 LT.', '10.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(5, '', 'SODA PERSONAL DE 350 ML', '8.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(6, '', 'CABAÑA', '6.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(7, '', 'MENDOCINA CHICA', '4.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(8, '', 'MENDOCINA 2LT.', '12.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(9, '', 'MENDOCINA 2LT.', '15.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(10, '', 'AGUA CON GAS', '6.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(11, '', 'AGUA SIN GAS', '6.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(12, '', 'CERVEZA PICO DE PLATA ', '10.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(13, '', 'BURN', '15.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(14, '', 'JUGO CON LECHE', '13.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(15, '', 'JUGO CON LECHE PARA LLEVAR', '15.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(16, '', 'JUGO CON AGUA', '10.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(17, '', 'JUGO CON AGUA LLEVAR', '10.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(18, '', 'MENDOCINA 1LT', '8.00', '', 0, '0000-00-00 00:00:00', 2, 'ACTIVO', 1),
(19, '', 'MEDIO PLATO DE FRICASE', '36.00', '', 0, '0000-00-00 00:00:00', 3, 'ACTIVO', 1),
(20, '', 'MEDIO PLATO DE FRICASE PARA LLEVAR ', '38.00', '', 0, '0000-00-00 00:00:00', 3, 'ACTIVO', 1),
(21, '', 'FRICASE', '50.00', '', 0, '0000-00-00 00:00:00', 3, 'ACTIVO', 1),
(22, '', 'FRICASE PARA LLEVAR ', '55.00', '', 0, '0000-00-00 00:00:00', 3, 'ACTIVO', 1),
(23, '', 'AQUARIUS PERSONAL', '10.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(24, '', 'SALTEÑAS PRECOSIDAS CONGELADAS', '11.00', '', 0, '0000-00-00 00:00:00', 3, 'ACTIVO', 1),
(25, '', 'PLASTOFOR PARA 20 CANTIDAD', '30.00', '', 0, '0000-00-00 00:00:00', 3, 'ACTIVO', 1),
(26, '', 'PLASTOFOR PARA 40 CANTIDAD', '40.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(27, '', 'PLASTOFOR PARA 70 CANTIDAD', '60.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(28, '', 'PLASTOFOR PARA 150 CANTIDAD', '90.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(29, '', 'MOCOCHINCHI ', '5.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(30, '', 'MOCOCHINCHI PARA LLEVAR', '7.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(31, '', 'MOCOCHINCHI JARRA CHICA', '20.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(32, '', 'MOCOCHINCHI JARRA GRANDE', '30.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(33, '', 'LIMONADA', '5.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(34, '', 'LIMONADA PARA LLEVAR', '7.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(35, '', 'LIMONADA JARRA CHICA', '20.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(36, '', 'LIMONADA JARRA GRANDE', '30.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(37, '10', 'MINERAGUA', '6.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(38, '0', 'CAFE', '7.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(39, '0', 'CAFE CON LECHE', '8.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(40, '0', 'TE', '7.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(41, '0', 'MEDIO FRICASE', '36.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(42, '5', 'AGUA SIN GAS GLACIAR', '5.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(43, '3', 'SALTEÑAS COCTELERAS', '8.00', '', 0, '0000-00-00 00:00:00', 1, 'ACTIVO', 1),
(44, '0', 'Coca', '23.00', 'Grande', 0, '2017-12-14 00:00:00', 3, 'ACTIVO', 0),
(45, '0', 'Cerveza Paceña', '12.00', 'Ninguno', 0, '2017-12-15 00:00:00', 4, 'ACTIVO', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_agregado`
--

CREATE TABLE IF NOT EXISTS `item_agregado` (
  `item_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `number` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `parent`, `name`, `icon`, `slug`, `number`) VALUES
(1, NULL, 'AGENDA', 'fa fa-address-book', 'Item-1', 1),
(2, NULL, 'VENTAS', 'fa fa-list', 'Item-1', 2),
(3, NULL, 'ITEMS', 'fa fa-th-large', 'Item-1', 3),
(4, NULL, 'EMPRESA', 'fa fa-building-o', 'Item-1', 4),
(5, NULL, 'REPORTES', 'fa fa-area-chart', 'Item-1', 5),
(6, 1, 'Registrar cliente', 'fa fa-circle-o', 'cliente', 1),
(7, 2, 'Venta', 'fa fa-circle-o', 'venta', 1),
(8, 2, 'Consulta Venta', 'fa fa-circle-o', 'consultar_venta', 2),
(9, 3, 'Registro items', 'fa fa-circle-o', 'item', 2),
(16, 4, 'Actividad', 'fa fa-circle-o', 'actividad', 1),
(17, 4, 'Impresora', 'fa fa-circle-o', 'impresora', 2),
(18, 4, 'Dosificacion', 'fa fa-circle-o', 'dosificacion', 3),
(19, 4, 'Usuario', 'fa fa-circle-o', 'usuario', 4),
(23, 5, 'Reporte LCV', 'fa fa-circle-o', 'reporte', 3),
(24, 2222, 'Reimpresiones', 'fa fa-circle-o', 'consultar_venta/reimpresiones', 3),
(25, 5, 'Reporte Venta Dia', 'fa fa-circle-o', 'reporte/reporte_venta_dia', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE IF NOT EXISTS `sucursal` (
`id` int(11) NOT NULL,
  `nit` int(11) DEFAULT NULL,
  `nombre_empresa` varchar(70) DEFAULT NULL,
  `direccion` text NOT NULL,
  `sucursal` varchar(30) NOT NULL,
  `estado` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id`, `nit`, `nombre_empresa`, `direccion`, `sucursal`, `estado`) VALUES
(1, 11386005, 'FUTBOLIVIA', 'Calle Antonio de Rojas / Av. paragua Nro. 3830 Barrio Gil Reyes, UV:40,MZA:144A', 'CASA MATRIZ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`id` int(11) NOT NULL,
  `ci` varchar(20) DEFAULT '0',
  `nombre_usuario` varchar(120) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `cargo` varchar(20) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '0',
  `sucursal_id` int(11) NOT NULL,
  `estado` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `ci`, `nombre_usuario`, `telefono`, `fecha_nacimiento`, `cargo`, `usuario`, `clave`, `activo`, `sucursal_id`, `estado`) VALUES
(1, '0', 'ADMINISTRADOR', '0', '0000-00-00', 'ADMINISTRADOR', 'admin', '$2y$10$9kbE0OVkWXln4OqOIi7I2eiPUlatlS0n6J9c36Vs3/ntQ3gTe/UXi', 1, 1, 1),
(2, '56546546', 'JUAN CARLOS', '768686', '0000-00-00', 'ADMINISTRADOR', 'juan', '$2y$10$9BEC6HnMV.2eqG8Unz4QZOcqOnXDb7iaV.H5YexFrgMw1cAzqM7fa', 1, 1, 1),
(3, '7665756', 'ELIANA', '768686', '2018-12-21', 'VENDEDOR', 'eliana', '$2y$10$WES8nBYd1YGe//LqX5z7MOZdtpyp4Bylz4Nmm5quED6YeKhIeilQa', 0, 1, 1),
(4, '78745', 'TATIANA', '78974', '1985-12-31', 'VENDEDOR', 'tatiana', '$2y$10$sys2AMfgNqalibCJEQEb1eKv6Is09zQG1qm/7F8L//.ER3LiyWrFG', 0, 1, 1),
(5, '787545', 'FERNANDA', '7875454', '2018-12-03', 'VENDEDOR', 'fernanda', '$2y$10$HxIdP1JxYDAceapq3/VhXuTAIiWsOAS3N6Nucox7TP2z.bsNJikG2', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_sucursal`
--

CREATE TABLE IF NOT EXISTS `usuario_sucursal` (
  `usuario_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_sucursal`
--

INSERT INTO `usuario_sucursal` (`usuario_id`, `sucursal_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE IF NOT EXISTS `venta` (
`id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` text NOT NULL,
  `subtotal` decimal(20,2) NOT NULL,
  `descuento` decimal(20,2) NOT NULL DEFAULT '0.00',
  `total` decimal(20,2) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `estado` tinyint(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `fecha`, `hora`, `subtotal`, `descuento`, `total`, `cliente_id`, `sucursal_id`, `usuario_id`, `estado`) VALUES
(1, '2018-12-08', '', '7.00', '0.00', '7.00', 1, 1, 1, 1),
(2, '0000-00-00', '', '13.00', '0.00', '13.00', 1, 1, 1, 1),
(3, '2018-12-09', '00:32:22', '10.00', '0.00', '10.00', 1, 1, 1, 1),
(4, '2018-12-09', '01:17:56', '13.00', '0.00', '13.00', 2, 1, 1, 1),
(5, '2018-12-09', '01:31:08', '6.00', '0.00', '6.00', 2, 1, 1, 1),
(6, '2018-12-09', '01:32:51', '12.00', '0.00', '12.00', 1, 1, 1, 1),
(7, '2018-12-09', '19:07:25', '6.00', '0.00', '6.00', 1, 1, 1, 1),
(8, '2018-12-09', '19:11:46', '24.00', '0.00', '24.00', 1, 1, 1, 1),
(9, '2018-12-09', '19:16:52', '18.00', '0.00', '18.00', 3, 1, 1, 1),
(10, '2018-12-09', '19:25:26', '12.00', '0.00', '12.00', 2, 1, 1, 1),
(11, '2019-11-07', '', '38.00', '0.00', '38.00', 3, 1, 1, 1),
(14, '2019-11-09', '', '16.00', '0.00', '16.00', 3, 1, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cierre_sesion`
--
ALTER TABLE `cierre_sesion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dosificacion`
--
ALTER TABLE `dosificacion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura_datos`
--
ALTER TABLE `factura_datos`
 ADD PRIMARY KEY (`venta_id`);

--
-- Indices de la tabla `impresora`
--
ALTER TABLE `impresora`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inicio_sesion`
--
ALTER TABLE `inicio_sesion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `item`
--
ALTER TABLE `item`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
 ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acceso`
--
ALTER TABLE `acceso`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `cierre_sesion`
--
ALTER TABLE `cierre_sesion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `dosificacion`
--
ALTER TABLE `dosificacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `impresora`
--
ALTER TABLE `impresora`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `inicio_sesion`
--
ALTER TABLE `inicio_sesion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT de la tabla `item`
--
ALTER TABLE `item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
