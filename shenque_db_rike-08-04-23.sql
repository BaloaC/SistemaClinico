-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2023 a las 23:03:05
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shenque_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `auditoria_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `accion` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`auditoria_id`, `fecha_creacion`, `usuario_id`, `accion`, `descripcion`) VALUES
(3, '2023-03-01 07:31:37', 2, 'delete', 'Eliminó empresa caja1'),
(4, '2023-03-01 07:31:42', 2, 'delete', 'Eliminó empresa caja1'),
(5, '2023-03-01 07:41:54', 2, 'update', 'Actualizó seguro amaioquierooo'),
(7, '2023-03-01 07:49:48', 2, 'update', 'Actualizó seguro amaio'),
(8, '2023-03-01 11:55:56', 2, 'delete', 'Eliminó empresa Last Dance'),
(9, '2023-03-01 05:47:37', 2, 'insert', 'Inserto empresa First'),
(12, '2023-03-03 05:58:00', 2, 'update', 'Actualizó empresa First'),
(13, '2023-03-04 05:59:26', 2, 'delete', 'Eliminó empresa First Dance'),
(28, '2023-03-06 01:36:10', 2, 'update', 'Actualizó insumo inyecciones'),
(29, '2023-03-06 01:36:10', 2, 'update', 'Actualizó insumo Vitamina C'),
(31, '2023-03-06 01:38:53', 2, 'update', 'Actualizó insumo Voto latino'),
(33, '2023-03-06 01:41:44', 2, 'update', 'Actualizó insumo Voto latino'),
(35, '2023-03-06 01:44:49', 2, 'update', 'Actualizó insumo Voto latino'),
(37, '2023-03-06 01:45:21', 2, 'update', 'Actualizó insumo Voto latino'),
(39, '2023-03-06 01:45:33', 2, 'update', 'Actualizó insumo Voto latino'),
(41, '2023-03-06 01:50:42', 2, 'update', 'Actualizó insumo Voto latino'),
(43, '2023-03-06 01:51:14', 2, 'update', 'Actualizó insumo Voto latino'),
(45, '2023-03-06 01:52:10', 2, 'update', 'Actualizó insumo Voto latino'),
(47, '2023-03-06 01:55:43', 2, 'update', 'Actualizó insumo Voto latino'),
(48, '2023-03-06 01:57:47', 2, 'insert', 'Inserto empresa caja'),
(52, '2023-03-06 01:59:34', 2, 'update', 'Actualizó insumo Voto latino'),
(54, '2023-03-06 01:59:47', 2, 'update', 'Actualizó insumo Voto latino'),
(56, '2023-03-06 01:59:55', 2, 'update', 'Actualizó insumo Voto latino'),
(58, '2023-03-06 02:03:45', 2, 'update', 'Actualizó insumo Voto latino'),
(64, '2023-03-06 02:19:18', 7, 'update', 'Actualizó insumo Voto latino'),
(66, '2023-03-06 02:19:56', 7, 'update', 'Actualizó insumo Voto latino'),
(68, '2023-03-06 02:20:10', 7, 'update', 'Actualizó insumo Voto latino'),
(70, '2023-03-06 02:20:23', 7, 'update', 'Actualizó insumo Voto latino'),
(72, '2023-03-06 02:22:26', 7, 'update', 'Actualizó insumo Voto latino'),
(74, '2023-03-06 02:22:45', 7, 'update', 'Actualizó insumo Voto latino'),
(76, '2023-03-06 02:22:52', 7, 'update', 'Actualizó insumo Voto latino'),
(78, '2023-03-06 02:23:03', 7, 'update', 'Actualizó insumo Voto latino'),
(80, '2023-03-06 02:23:08', 7, 'update', 'Actualizó insumo Voto latino'),
(82, '2023-03-06 02:23:09', 7, 'update', 'Actualizó insumo Voto latino'),
(84, '2023-03-06 02:24:13', 7, 'update', 'Actualizó insumo Voto latino'),
(86, '2023-03-06 02:24:27', 7, 'update', 'Actualizó insumo Voto latino'),
(88, '2023-03-06 02:24:39', 7, 'update', 'Actualizó insumo Voto latino'),
(90, '2023-03-06 02:25:15', 7, 'update', 'Actualizó insumo Voto latino'),
(92, '2023-03-06 02:25:24', 7, 'update', 'Actualizó insumo Voto latino'),
(93, '2023-03-06 02:27:23', 7, 'insert', 'Inserto factura compra '),
(94, '2023-03-06 02:27:23', 7, 'insert', 'Inserto compra insumo '),
(95, '2023-03-06 02:27:23', 7, 'update', 'Actualizó insumo Voto latino'),
(96, '2023-03-06 02:28:54', 7, 'insert', 'Inserto factura compra '),
(97, '2023-03-06 02:28:54', 7, 'insert', 'Inserto compra insumo '),
(98, '2023-03-06 02:28:54', 7, 'update', 'Actualizó insumo Voto latino'),
(99, '2023-03-06 02:30:08', 7, 'insert', 'Inserto factura compra '),
(100, '2023-03-06 02:30:08', 7, 'insert', 'Inserto compra insumo '),
(101, '2023-03-06 02:30:08', 7, 'update', 'Actualizó insumo Voto latino'),
(102, '2023-03-06 02:30:31', 2, 'insert', 'Inserto factura compra '),
(103, '2023-03-06 02:30:31', 2, 'insert', 'Inserto compra insumo '),
(104, '2023-03-06 02:30:31', 2, 'update', 'Actualizó insumo inyecciones'),
(105, '2023-03-06 02:30:31', 2, 'insert', 'Inserto compra insumo '),
(106, '2023-03-06 02:30:31', 2, 'update', 'Actualizó insumo Voto latino'),
(107, '2023-03-06 02:31:13', 2, 'insert', 'Inserto factura compra '),
(108, '2023-03-06 02:31:13', 2, 'insert', 'Inserto compra insumo '),
(109, '2023-03-06 02:31:13', 2, 'update', 'Actualizó insumo Vitamina C'),
(110, '2023-03-06 02:31:13', 2, 'insert', 'Inserto compra insumo '),
(111, '2023-03-06 02:31:13', 2, 'update', 'Actualizó insumo inyecciones'),
(112, '2023-03-06 11:16:59', 2, 'insert', 'Inserto seguro Enrique'),
(123, '2023-03-26 09:22:20', 2, 'insert', 'Inserto factura compra '),
(124, '2023-03-26 09:22:20', 2, 'insert', 'Inserto compra insumo '),
(125, '2023-03-26 09:22:20', 2, 'update', 'Actualizó insumo inyecciones'),
(126, '2023-03-26 10:00:06', 2, 'insert', 'Inserto examen asd'),
(127, '2023-03-26 10:02:34', 2, 'insert', 'Inserto examen lolxd'),
(128, '2023-04-03 01:15:05', 2, 'insert', 'Inserto examen asdd'),
(129, '2023-04-03 01:15:15', 2, 'update', 'Actualizó examen asdd'),
(130, '2023-04-03 01:15:18', 2, 'update', 'Actualizó examen asdd'),
(131, '2023-04-03 01:15:21', 2, 'update', 'Actualizó examen asddaa'),
(132, '2023-04-04 10:56:39', 2, 'update', 'Actualizó proveedor paca csa'),
(133, '2023-04-04 10:56:47', 2, 'update', 'Actualizó proveedor paca csas'),
(134, '2023-04-04 10:56:51', 2, 'update', 'Actualizó proveedor paca csas'),
(135, '2023-04-04 11:01:48', 2, 'update', 'Actualizó proveedor paca csasaa'),
(136, '2023-04-05 08:44:16', 2, 'update', 'Actualizó seguro caracaa'),
(137, '2023-04-05 08:46:10', 2, 'insert', 'Inserto insumo a'),
(138, '2023-04-06 11:36:33', 2, 'insert', 'Inserto factura seguro '),
(139, '2023-04-06 11:37:10', 2, 'insert', 'Inserto factura seguro '),
(140, '2023-04-06 11:37:18', 2, 'insert', 'Inserto factura seguro '),
(141, '2023-04-06 11:37:48', 2, 'insert', 'Inserto factura seguro '),
(142, '2023-04-06 11:37:51', 2, 'insert', 'Inserto factura seguro '),
(143, '2023-04-06 11:39:41', 2, 'insert', 'Inserto factura seguro '),
(144, '2023-04-06 11:39:43', 2, 'insert', 'Inserto factura seguro '),
(145, '2023-04-06 11:41:17', 2, 'insert', 'Inserto factura seguro '),
(146, '2023-04-06 11:42:24', 2, 'insert', 'Inserto factura seguro '),
(147, '2023-04-06 11:42:27', 2, 'insert', 'Inserto factura seguro '),
(148, '2023-04-06 11:42:29', 2, 'insert', 'Inserto factura seguro '),
(149, '2023-04-06 11:42:35', 2, 'insert', 'Inserto factura seguro '),
(150, '2023-04-06 11:44:57', 2, 'delete', 'Eliminó factura seguro '),
(151, '2023-04-06 11:45:02', 2, 'delete', 'Eliminó factura seguro '),
(152, '2023-04-06 11:45:05', 2, 'delete', 'Eliminó factura seguro '),
(153, '2023-04-06 11:45:05', 2, 'delete', 'Eliminó factura seguro '),
(154, '2023-04-06 11:45:59', 2, 'delete', 'Eliminó factura seguro '),
(155, '2023-04-06 20:21:16', 2, 'update', 'Actualizó examen asdd'),
(156, '2023-04-07 22:28:02', 2, 'insert', 'Inserto empresa ASd'),
(157, '2023-04-08 14:23:06', 2, 'insert', 'Inserto examen Mamografísa'),
(158, '2023-04-08 14:28:56', 2, 'update', 'Actualizó examen holter'),
(159, '2023-04-08 14:37:21', 2, 'update', 'Actualizó empresa ASd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `cita_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL DEFAULT 0,
  `especialidad_id` int(11) NOT NULL,
  `fecha_cita` datetime NOT NULL,
  `motivo_cita` varchar(45) NOT NULL,
  `cedula_titular` int(11) NOT NULL,
  `clave` int(11) DEFAULT NULL,
  `tipo_cita` enum('1','2') NOT NULL,
  `estatus_cit` enum('1','2','3','4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`cita_id`, `paciente_id`, `medico_id`, `seguro_id`, `especialidad_id`, `fecha_cita`, `motivo_cita`, `cedula_titular`, `clave`, `tipo_cita`, `estatus_cit`) VALUES
(1, 18, 6, 1, 1, '2023-09-22 18:50:00', 'dolor de cabeza', 28321333, NULL, '2', '3'),
(9, 18, 6, 0, 1, '2023-09-23 12:50:00', 'dolor de cabeza', 28321333, NULL, '1', '1'),
(10, 18, 6, 1, 1, '2023-08-23 12:50:00', 'dolor de cabeza', 28321333, 312321, '2', '4'),
(11, 18, 6, 0, 1, '2023-01-25 12:50:00', 'dolor de cabeza', 28321333, NULL, '1', '1'),
(12, 18, 1, 3, 1, '2023-01-24 12:52:00', 'random', 28321333, NULL, '1', '4'),
(13, 18, 1, 1, 1, '2023-01-26 14:48:00', 'dolor muscular', 28321333, NULL, '1', '1'),
(14, 18, 1, 1, 1, '2023-01-27 14:50:00', 'molestia', 28321333, NULL, '1', '1'),
(15, 18, 1, 1, 1, '2023-01-28 14:55:00', 'asdd', 28321333, NULL, '1', '1'),
(16, 18, 1, 1, 1, '2023-01-29 14:56:00', 'idiotizado', 28321333, NULL, '1', '4'),
(17, 18, 6, 0, 1, '2023-01-24 12:50:00', 'dolor de cabeza', 28321333, NULL, '1', '1'),
(18, 18, 6, 1, 1, '2023-01-28 12:50:00', 'dolor de cabeza', 28321333, 12, '2', '1'),
(19, 18, 6, 1, 1, '2023-01-29 12:50:00', 'dolor de cabeza', 28321333, NULL, '', '1'),
(20, 18, 7, 1, 1, '2023-01-27 01:38:00', 'ultimaprueba', 28321333, NULL, '1', '1'),
(21, 28, 7, 0, 1, '2023-09-30 18:50:00', 'dolor de cabeza', 32123321, NULL, '1', '1'),
(22, 28, 7, 1, 1, '2023-01-31 10:55:00', 'Perdida de la memoria', 32123321, NULL, '1', '4'),
(23, 28, 7, 0, 1, '2023-01-31 18:50:00', 'dolor de cabeza', 32123321, NULL, '1', '4'),
(24, 28, 1, 1, 1, '2023-02-07 08:08:00', 'sd', 32123321, NULL, '1', '1'),
(25, 1, 1, 1, 1, '2023-03-10 22:25:00', 'asd', 21429271, NULL, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_insumo`
--

CREATE TABLE `compra_insumo` (
  `compra_insumo_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `factura_compra_id` int(11) NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_unit` float NOT NULL,
  `precio_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compra_insumo`
--

INSERT INTO `compra_insumo` (`compra_insumo_id`, `insumo_id`, `factura_compra_id`, `unidades`, `precio_unit`, `precio_total`) VALUES
(1, 4, 1, 8, 1, 0),
(2, 4, 2, 8, 1, 0),
(3, 3, 2, 8, 1, 0),
(4, 4, 3, 8, 1, 5),
(5, 3, 3, 8, 1, 5),
(6, 4, 4, 10, 5, 50),
(7, 3, 5, 8, 1, 0),
(8, 4, 5, 8, 1, 0),
(9, 4, 6, 12, 12, 100),
(10, 3, 6, 12, 12, 100),
(11, 2, 7, 10, 10, 0),
(12, 1, 8, 10, 10, 116),
(13, 4, 8, 10, 2, 23.2),
(14, 4, 9, 10, 10, 116),
(15, 3, 9, 10, 2, 23.2),
(16, 1, 9, 2, 2, 4),
(17, 4, 10, 1, 10, 11.6),
(18, 2, 10, 50, 10, 580),
(19, 1, 11, 12, 10, 120),
(20, 4, 11, 1, 5, 5.8),
(21, 4, 12, 12, 10, 139.2),
(22, 1, 12, 1, 1, 1.16),
(63, 3, 49, 8, 1, 5),
(64, 3, 50, 8, 1, 5),
(65, 3, 51, 8, 1, 5),
(66, 1, 52, 1, 12, 13.92),
(67, 3, 52, 11, 10, 127.6),
(68, 4, 53, 10, 10, 116),
(69, 1, 53, 1, 1, 1.16),
(70, 1, 54, 175, 10, 2030),
(71, 1, 55, 175, 10, 2030);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `peso` float NOT NULL,
  `altura` float NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `fecha_consulta` date NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`consulta_id`, `paciente_id`, `medico_id`, `especialidad_id`, `cita_id`, `peso`, `altura`, `observaciones`, `fecha_consulta`, `estatus_con`) VALUES
(2, 18, 6, 1, 10, 12.4, 12.6, 'dolor de cabeza', '2023-02-09', '1'),
(3, 18, 1, 1, 12, 12.4, 12.6, 'dolor de cabeza', '2023-02-16', '1'),
(4, 18, 1, 1, 16, 21, 12, NULL, '2023-03-03', '1'),
(6, 28, 7, 2, 22, 12, 21, NULL, '2023-02-16', '1'),
(9, 28, 7, 1, 22, 12.4, 12.6, 'dolor de cabeza', '2023-02-01', '1'),
(10, 28, 7, 2, 23, 12.4, 12.6, 'dolor de cabeza', '2023-02-01', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_examen`
--

CREATE TABLE `consulta_examen` (
  `consulta_examen_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta_examen`
--

INSERT INTO `consulta_examen` (`consulta_examen_id`, `consulta_id`, `examen_id`, `estatus_con`) VALUES
(2, 2, 1, '1'),
(3, 3, 1, '1'),
(4, 4, 1, '1'),
(5, 4, 2, '1'),
(8, 6, 1, '1'),
(14, 9, 1, '1'),
(16, 10, 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_insumo`
--

CREATE TABLE `consulta_insumo` (
  `consulta_insumo_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta_insumo`
--

INSERT INTO `consulta_insumo` (`consulta_insumo_id`, `insumo_id`, `consulta_id`, `estatus_con`) VALUES
(1, 3, 2, '1'),
(2, 3, 3, '1'),
(3, 4, 2, '1'),
(4, 4, 4, '1'),
(6, 3, 9, '1'),
(7, 4, 6, '1'),
(8, 3, 10, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `rif` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `estatus_emp` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`empresa_id`, `nombre`, `rif`, `direccion`, `estatus_emp`) VALUES
(1, 'caja1', 'J-16443533', '23 de enero', '1'),
(2, 'Caja Random', 'J-987654321', 'I wont be the one, be the one to live thisss ', '1'),
(4, 'Last Dance', 'J-123456781', 'Impro', '1'),
(5, 'First Dance', 'J-321423221', 'Anyway', '2'),
(7, 'First', 'J-123456777', 'Adds', '1'),
(8, 'caja', 'J-16443531', '23 de enero', '1'),
(9, 'ASd', 'J-123456798', 'dsal', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `especialidad_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estatus_esp` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`especialidad_id`, `nombre`, `estatus_esp`) VALUES
(1, 'Insomnio', '1'),
(2, 'Insomnia', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `examen_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`examen_id`, `nombre`, `tipo`, `estatus_exa`) VALUES
(1, 'Mamografía', '', '1'),
(2, 'Mamografías', '', '1'),
(3, 'holtser', 'sadsad', '1'),
(4, 'random', '', '1'),
(5, 'lol', '', '1'),
(6, 'asd', '', '1'),
(7, 'lolxd', 'dsa', '1'),
(8, 'holter', 'dsaaa', '1'),
(9, 'Mamografísa', '', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE `factura_compra` (
  `factura_compra_id` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `total_productos` int(11) NOT NULL,
  `monto_con_iva` float NOT NULL,
  `monto_sin_iva` float NOT NULL,
  `excento` float DEFAULT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura_compra`
--

INSERT INTO `factura_compra` (`factura_compra_id`, `proveedor_id`, `fecha_compra`, `total_productos`, `monto_con_iva`, `monto_sin_iva`, `excento`, `estatus_fac`) VALUES
(1, 3, '2022-12-12 00:00:00', 10, 10.54, 7.54, NULL, '1'),
(2, 3, '2022-12-12 00:00:00', 10, 10.54, 7.54, NULL, '1'),
(3, 3, '2022-12-12 00:00:00', 10, 10.54, 7.54, NULL, '1'),
(4, 3, '2023-01-16 00:00:00', 10, 10.2, 10.45, NULL, '1'),
(5, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '2'),
(6, 3, '2023-01-18 00:00:00', 12, 10, 10, NULL, '1'),
(7, 2, '2023-02-02 00:00:00', 0, 0, 0, NULL, '2'),
(8, 3, '2023-02-09 00:00:00', 20, 139.2, 120, 19.2, '1'),
(9, 3, '2023-02-01 00:00:00', 22, 143.2, 124, 19.2, '1'),
(10, 3, '2023-02-02 00:00:00', 51, 591.6, 510, 81.6, '1'),
(11, 3, '2023-01-31 00:00:00', 13, 125.8, 125, 0.8, '2'),
(12, 3, '2023-02-02 00:00:00', 13, 140.36, 121, 19.36, '2'),
(13, 1, '2023-03-03 00:00:00', 21, 269.12, 232, 37.12, '1'),
(14, 1, '2023-03-03 00:00:00', 21, 269.12, 232, 37.12, '1'),
(15, 1, '2023-03-03 00:00:00', 21, 269.12, 232, 37.12, '1'),
(16, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(17, 1, '2023-03-03 00:00:00', 21, 269.12, 232, 37.12, '1'),
(18, 1, '2023-03-02 00:00:00', 11, 117.16, 101, 16.16, '1'),
(19, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(20, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(21, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(22, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(23, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(24, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(25, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(26, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(27, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(28, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(29, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(30, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(31, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(32, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(33, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(34, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(35, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(36, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(37, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(38, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(39, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(40, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(41, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(42, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(43, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(44, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(45, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(46, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(47, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(48, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(49, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(50, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(51, 1, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(52, 1, '2023-03-01 00:00:00', 12, 141.52, 122, 19.52, '1'),
(53, 2, '2023-03-05 00:00:00', 11, 117.16, 101, 16.16, '1'),
(54, 1, '2023-03-20 00:00:00', 175, 2030, 1750, 280, '1'),
(55, 1, '2023-03-20 00:00:00', 175, 2030, 1750, 280, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_consulta`
--

CREATE TABLE `factura_consulta` (
  `factura_consulta_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `monto_con_iva` float NOT NULL,
  `monto_sin_iva` float NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura_consulta`
--

INSERT INTO `factura_consulta` (`factura_consulta_id`, `consulta_id`, `paciente_id`, `metodo_pago`, `monto_con_iva`, `monto_sin_iva`, `estatus_fac`) VALUES
(1, 4, 18, 'debito', 400, 400, '1'),
(2, 4, 18, 'debito', 400, 400, '1'),
(3, 4, 14, 'efectivo', 0, 211, '1'),
(4, 4, 18, 'debito', 321, 123, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_medico`
--

CREATE TABLE `factura_medico` (
  `factura_medico_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `acumulado_seguro_total` float DEFAULT NULL,
  `acumulado_consulta_total` float DEFAULT NULL,
  `pago_total` float DEFAULT NULL,
  `fecha_pago` date NOT NULL,
  `pacientes_seguro` int(11) DEFAULT NULL,
  `pacientes_consulta` int(11) DEFAULT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura_medico`
--

INSERT INTO `factura_medico` (`factura_medico_id`, `medico_id`, `acumulado_seguro_total`, `acumulado_consulta_total`, `pago_total`, `fecha_pago`, `pacientes_seguro`, `pacientes_consulta`, `estatus_fac`) VALUES
(15, 7, 0, 0, 0, '2023-02-05', 0, 0, '1'),
(16, 7, 0, 0, 0, '2023-02-05', 0, 0, '1'),
(17, 6, 0, 0, 0, '2023-01-25', 0, 0, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_seguro`
--

CREATE TABLE `factura_seguro` (
  `factura_seguro_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `tipo_servicio` varchar(50) NOT NULL,
  `autorizacion` varchar(45) NOT NULL,
  `nombre_paciente` varchar(45) NOT NULL,
  `nombre_titular` varchar(45) NOT NULL,
  `nombre_especialidad` varchar(45) NOT NULL,
  `fecha_ocurrencia` date NOT NULL,
  `fecha_pago_limite` date NOT NULL,
  `monto` float NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura_seguro`
--

INSERT INTO `factura_seguro` (`factura_seguro_id`, `consulta_id`, `seguro_id`, `tipo_servicio`, `autorizacion`, `nombre_paciente`, `nombre_titular`, `nombre_especialidad`, `fecha_ocurrencia`, `fecha_pago_limite`, `monto`, `estatus_fac`) VALUES
(1, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(2, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(3, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(4, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(5, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(6, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(7, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(8, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(9, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(10, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(11, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(12, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 200, '1'),
(13, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 400, '1'),
(14, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 400, '2'),
(15, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 400, '1'),
(16, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 400, '1'),
(17, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 4321, '1'),
(18, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 100, '2'),
(19, 4, 1, 'consulta', '', 'randms', 'randms', '', '2023-03-03', '2023-04-02', 100, '2'),
(20, 2, 1, 'consulta', '', 'randms', 'randms', '', '2023-02-09', '2023-03-11', 112, '1'),
(21, 10, 0, 'laboratorio', '', 'Last Time I checked', 'Last Time I checked', '', '2023-02-01', '2023-03-03', 321, '1'),
(22, 10, 0, 'laboratorio', '', 'Last Time I checked', 'Last Time I checked', '', '2023-02-01', '2023-03-03', 321, '2'),
(23, 10, 0, 'laboratorio', '', 'Last Time I checked', 'Last Time I checked', '', '2023-02-01', '2023-03-03', 1, '2'),
(24, 6, 1, 'laboratorio', '', 'Last Time I checked', 'Last Time I checked', '', '2023-02-16', '2023-03-18', 1, '1'),
(25, 3, 3, 'laboratorio', '', 'randms', 'randms', 'Insomnio', '2023-02-16', '2023-03-18', 1, '1'),
(26, 2, 1, 'laboratorio', '', 'randms', 'randms', 'Insomnio', '2023-02-09', '2023-03-11', 1, '1'),
(27, 3, 3, 'laboratorio', '', 'randms', 'randms', 'Insomnio', '2023-02-16', '2023-03-18', 1, '1'),
(28, 3, 3, 'laboratorio', '', 'randms', 'randms', 'Insomnio', '2023-02-16', '2023-03-18', 1, '2'),
(29, 3, 3, 'laboratorio', '', 'randms', 'randms', 'Insomnio', '2023-02-16', '2023-03-18', 1, '1'),
(30, 3, 3, 'laboratorio', '', 'randms', 'randms', 'Insomnio', '2023-02-16', '2023-03-18', 1, '1'),
(31, 3, 3, 'laboratorio', '', 'randms', 'randms', 'Insomnio', '2023-02-16', '2023-03-18', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `horario_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `dias_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado') NOT NULL,
  `estatus_hor` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`horario_id`, `medico_id`, `dias_semana`, `estatus_hor`) VALUES
(1, 2, 'lunes', '1'),
(2, 2, 'martes', '1'),
(3, 2, 'miercoles', '1'),
(4, 3, 'jueves', '1'),
(5, 3, 'viernes', '1'),
(6, 4, 'lunes', '1'),
(7, 4, 'miercoles', '1'),
(8, 5, 'lunes', '1'),
(9, 5, 'miercoles', '1'),
(10, 6, 'lunes', '1'),
(11, 6, 'miercoles', '1'),
(12, 7, 'jueves', '1'),
(13, 7, 'viernes', '1'),
(14, 8, 'jueves', '1'),
(15, 8, 'viernes', '1'),
(16, 9, 'lunes', '1'),
(17, 9, 'martes', '1'),
(18, 9, 'miercoles', '1'),
(19, 10, 'lunes', '1'),
(20, 10, 'martes', '1'),
(21, 11, 'martes', '1'),
(22, 11, 'miercoles', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `insumo_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL,
  `cantidad_min` int(11) NOT NULL,
  `precio` float NOT NULL,
  `estatus_ins` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`insumo_id`, `nombre`, `cantidad`, `stock`, `cantidad_min`, `precio`, `estatus_ins`) VALUES
(1, 'inyecciones', 0, 387, 0, 10.54, '1'),
(2, 'inyeccioness', 22, 60, 0, 10.54, '1'),
(3, 'Voto latino', 40, 304, 5, 12.32, '1'),
(4, 'Vitamina C', 40, 77, 5, 12.32, '1'),
(5, 'a', 10, 10, 2, 12, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE `medico` (
  `medico_id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`medico_id`, `cedula`, `nombre`, `apellidos`, `telefono`, `direccion`, `estatus_med`) VALUES
(1, 29527505, 'Enrique', 'Chacón', '04242941451', 'ASDASD', '1'),
(2, 29527111, 'Random', 'Radnom', '04122941451', 'Random', '1'),
(3, 10402129, 'Enrique', 'Chacón', '04125005556', 'Barrio Bolívar', '1'),
(4, 21299123, 'Maite', 'icanttakebackk', '04142941451', 'asdddd', '1'),
(5, 32123321, 'Lmao', 'lmao', '04122941451', '12333', '1'),
(6, 29527750, 'Franci', 'Baloa', '04122941451', 'ASDDD', '1'),
(7, 10402129, 'Enrique', 'Chacón', '04125005556', 'Barrio Bolívar', '1'),
(9, 1233214, 'asd', 'Chacón', '04123123211', 'asss', '1'),
(10, 2941232, 'lasttime', 'asd', '04142934212', 'asd', '1'),
(11, 23123213, 'asdas', 'asdasd', '04122132312', 'asdasw', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_especialidad`
--

CREATE TABLE `medico_especialidad` (
  `medico_especialidad_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `medico_especialidad`
--

INSERT INTO `medico_especialidad` (`medico_especialidad_id`, `medico_id`, `especialidad_id`, `estatus_med`) VALUES
(1, 3, 1, '1'),
(2, 6, 1, '1'),
(3, 6, 2, '1'),
(4, 7, 1, '1'),
(6, 1, 1, '1'),
(7, 9, 2, '1'),
(8, 10, 1, '1'),
(9, 10, 2, '1'),
(10, 11, 2, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `paciente_id` int(11) NOT NULL,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) NOT NULL,
  `tipo_paciente` enum('1','2','3','4') NOT NULL,
  `estatus_pac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`paciente_id`, `cedula`, `nombre`, `apellidos`, `fecha_nacimiento`, `edad`, `telefono`, `direccion`, `tipo_paciente`, `estatus_pac`) VALUES
(1, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(3, 21429272, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(4, 21429275, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(5, 22429275, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(6, 1234567, 'Random', 'Random', '2022-01-10', 1, '04122941451', 'random x', '2', '1'),
(7, 21321222, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(8, 23212321, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(9, 26212321, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(10, 12343213, 'Random', 'Random', '2022-01-05', 1, '04142941451', 'random x', '2', '1'),
(13, 3211231, 'Randoms', 'Randoms', '2002-08-15', 20, '04142941452', 'random xs', '2', '1'),
(14, 23123321, 'rcick', 'rick', '2021-06-09', 1, '04162941451', 'icanttakebackk', '2', '1'),
(15, 8321221, 'rcick', 'rick', '2021-06-09', 1, '04162941451', 'icanttakebackk', '2', '1'),
(16, 28232123, 'rcick', 'rick', '2021-06-09', 1, '04162941451', 'icanttakebackk', '2', '1'),
(18, 28321333, 'randms', 'Random', '2020-06-09', 2, '04242941451', 'random x', '2', '1'),
(19, 26612321, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '3', '1'),
(20, 26652321, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '1', '1'),
(21, 26615321, 'Orianas', 'Blancos', '2016-01-05', 7, '04123353781', 'Probando el data scapess', '1', '1'),
(22, 28321322, 'Oriana', 'Blanco', '2021-12-24', 1, '04123353781', 'Probando el data scape', '2', '1'),
(28, 32123321, 'Last Time I checked', 'Random', '2018-06-20', 4, '04242941451', 'Calle x', '2', '1'),
(29, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '', '1'),
(30, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '', '1'),
(31, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '', '1'),
(32, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '1', '1'),
(33, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '4', '1'),
(34, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(35, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '4', '1'),
(36, 12321322, 'Enrique', 'Prueba', '2018-07-18', 4, '04162941422', 'random2', '4', '1'),
(37, 21429271, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '2', '1'),
(38, 29412943, 'qas', 'Sánchez Perdomo', '2021-02-09', 2, '04122300912', 'asd213', '4', '1'),
(39, 21429261, 'dsa', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '4', '1'),
(40, 21429262, 'Oriana', 'Blanco', '2021-12-24', 24, '04123353781', 'Probando el data scape', '4', '1'),
(41, 29412943, 'www', 'Sánchez Perdomo', '2021-02-09', 2, '04122300912', 'asd213', '4', '1'),
(42, 29527504, 'Enrique', 'Random', '2011-06-22', 11, '04124142942', 'Random', '4', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_beneficiado`
--

CREATE TABLE `paciente_beneficiado` (
  `paciente_beneficiado_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_pac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente_beneficiado`
--

INSERT INTO `paciente_beneficiado` (`paciente_beneficiado_id`, `paciente_id`, `estatus_pac`) VALUES
(1, 29, '1'),
(2, 30, '1'),
(3, 31, '1'),
(4, 33, '1'),
(5, 35, '1'),
(6, 35, '1'),
(7, 36, '1'),
(8, 36, '1'),
(9, 38, '1'),
(10, 38, '1'),
(11, 38, '1'),
(12, 39, '1'),
(13, 39, '1'),
(14, 40, '1'),
(15, 40, '1'),
(16, 41, '1'),
(17, 41, '1'),
(18, 41, '1'),
(19, 42, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_seguro`
--

CREATE TABLE `paciente_seguro` (
  `paciente_seguro_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `tipo_seguro` enum('1','2') NOT NULL,
  `cobertura_general` float NOT NULL,
  `fecha_contra` date NOT NULL,
  `saldo_disponible` float NOT NULL,
  `estatus_pac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente_seguro`
--

INSERT INTO `paciente_seguro` (`paciente_seguro_id`, `paciente_id`, `seguro_id`, `empresa_id`, `tipo_seguro`, `cobertura_general`, `fecha_contra`, `saldo_disponible`, `estatus_pac`) VALUES
(1, 1, 1, 1, '1', 2000, '2002-07-22', 2000, '1'),
(2, 3, 1, 1, '1', 2000, '2002-07-22', 2000, '1'),
(3, 4, 1, 1, '1', 2000, '2002-07-22', 2000, '1'),
(4, 5, 1, 1, '1', 2000, '2002-07-22', 2000, '1'),
(5, 8, 1, 1, '1', 2000, '2002-07-22', 2000, '1'),
(6, 8, 2, 4, '2', 2000, '2002-07-22', 4000, '1'),
(7, 9, 1, 1, '1', 2000, '2002-07-22', 2000, '1'),
(8, 9, 2, 4, '2', 2000, '2002-07-22', 4000, '1'),
(9, 10, 1, 1, '2', 0, '2023-01-17', 4000, '1'),
(10, 13, 1, 1, '2', 0, '2021-05-04', 2111, '1'),
(11, 14, 1, 1, '2', 999, '2023-01-04', 999, '1'),
(12, 15, 1, 1, '2', 999, '2023-01-04', 999, '1'),
(13, 16, 1, 1, '2', 999, '2023-01-04', 999, '1'),
(14, 18, 1, 1, '2', 999, '2023-01-03', 1787, '1'),
(15, 21, 1, 1, '1', 2000, '2002-07-22', 2000, '1'),
(16, 21, 2, 4, '2', 2000, '2002-07-22', 4000, '1'),
(21, 28, 1, 1, '1', 2000, '2023-01-18', 1999, '1'),
(22, 28, 2, 1, '1', 2000, '2023-01-18', 2000, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_seguridad`
--

CREATE TABLE `pregunta_seguridad` (
  `pregunta_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  `estatus_pre` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pregunta_seguridad`
--

INSERT INTO `pregunta_seguridad` (`pregunta_id`, `usuario_id`, `pregunta`, `respuesta`, `estatus_pre`) VALUES
(1, 7, '1', 'a', '1'),
(2, 7, '1', 'a', '1'),
(3, 7, '1', 'a', '1'),
(4, 16, '1', 'rojo', '1'),
(5, 16, '1', 'leon', '1'),
(6, 16, '1', 'leon', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estatus_pro` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_id`, `nombre`, `ubicacion`, `estatus_pro`) VALUES
(1, 'sobre c.a', 'barrio lourdes', '1'),
(2, 'paca csasaa', 'barrio asd', '1'),
(3, 'Enriquexx', 'Calle X', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro`
--

CREATE TABLE `seguro` (
  `seguro_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `rif` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `tipo_seguro` enum('1','2') NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `seguro`
--

INSERT INTO `seguro` (`seguro_id`, `nombre`, `rif`, `direccion`, `telefono`, `tipo_seguro`, `estatus_seg`) VALUES
(0, 'amaioquierooo', 'J-5678912', 'Aragua', '04145053781', '2', '1'),
(1, 'amaio', 'J-567893132', 'Aragua', '04142941452', '1', '1'),
(2, 'amaioquiero', 'J-5678932', 'Aragua', '2147483647', '1', '1'),
(3, 'Seguro X', 'J-123456789', 'icanttakebackk', '04142941451', '2', '1'),
(4, 'caracaa', 'J-122321231', 'Aragua', '04145053781', '2', '1'),
(7, 'Enrique', 'J-129321232', 'casaidk', '04122984145', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro_empresa`
--

CREATE TABLE `seguro_empresa` (
  `seguro_empresa_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `seguro_empresa`
--

INSERT INTO `seguro_empresa` (`seguro_empresa_id`, `empresa_id`, `seguro_id`, `estatus_seg`) VALUES
(1, 1, 2, '1'),
(2, 1, 1, '1'),
(3, 4, 2, '1'),
(7, 5, 2, '1'),
(8, 7, 3, '1'),
(9, 7, 4, '1'),
(10, 8, 2, '1'),
(11, 8, 1, '1'),
(12, 9, 7, '1'),
(13, 9, 1, '1'),
(14, 9, 3, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titular_beneficiado`
--

CREATE TABLE `titular_beneficiado` (
  `titular_beneficiado_id` int(11) NOT NULL,
  `paciente_beneficiado_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_tit` enum('1','2') NOT NULL DEFAULT '1',
  `tipo_relacion` enum('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `titular_beneficiado`
--

INSERT INTO `titular_beneficiado` (`titular_beneficiado_id`, `paciente_beneficiado_id`, `paciente_id`, `estatus_tit`, `tipo_relacion`) VALUES
(1, 1, 1, '1', '1'),
(2, 2, 1, '1', '3'),
(3, 3, 1, '1', '3'),
(4, 4, 8, '1', '3'),
(5, 5, 1, '1', '3'),
(6, 6, 8, '1', '3'),
(7, 7, 1, '1', '2'),
(8, 8, 7, '1', '3'),
(9, 9, 1, '1', '1'),
(10, 10, 4, '1', '1'),
(11, 11, 8, '1', '2'),
(12, 12, 1, '1', '3'),
(13, 13, 8, '1', '3'),
(14, 14, 1, '1', '3'),
(15, 15, 8, '1', '3'),
(16, 16, 1, '1', '1'),
(17, 17, 4, '1', '1'),
(18, 18, 8, '1', '2'),
(19, 19, 1, '1', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(16) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `tokken` varchar(10) DEFAULT NULL,
  `rol` int(11) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `estatus_usu` enum('1','2') NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nombre`, `clave`, `tokken`, `rol`, `pin`, `estatus_usu`, `fecha_creacion`) VALUES
(2, 'enrique', '$2y$10$jKtDbh23B3poFYK2HNEBIeMyH5iQ4wZYjHiqk3bxETk5pgcj66aqu', '16ff81373c', 2, '', '1', '2023-01-21 04:19:57'),
(3, 'enriquex', '$2y$10$0sS69SBknvgnx8APT5u0t.4PKagsRm.jGXOkHl4y5z6Awx7jH8dDO', NULL, 1, '', '1', '2023-01-22 01:12:30'),
(4, 'enriquexx', '$2y$10$V5tQxzsTptiynIdLOIf70.wRCV1Wy6XslXHlEFBKBGNvwxTBM.hUK', NULL, 1, '', '1', '2023-01-22 01:13:30'),
(5, 'enrique1', '$2y$10$7Wbo8I8wXk2tGVqXkvd60elcxt8oX1hNj6pXVVx18eiQjsfShAyMK', NULL, 1, '$2y$10$NKBAP5FBzE6dK7Uvcgb3uudlvfRM4hoNRlAEtETRLc0ctjYZiefEi', '1', '2023-02-05 09:22:41'),
(6, 'pregunta', '$2y$10$F3Z3XnL6WZIuElVApSyxXuBek3IsDxFctZTcG193cEylTL9lj/d3i', NULL, 1, '$2y$10$XtzLdlg9x9cHsLWtoRXFj.Q6D16A4FneXSlfaYS8XXKwOmEuMC8fu', '1', '2023-02-05 10:26:36'),
(7, 'paciente1', '$2y$10$DIPNvWpLagXliH0sHsJedOBhunTkJuSq2Uusf2NDVyyhOE8VUo.Xe', '2486d51656', 1, '$2y$10$v5OojamXyGJzuIIHerE14.YsXNirQeDiYC7jIyWHFFHJpamjPIX5O', '1', '2023-02-06 01:02:07'),
(8, 'asd', '$2y$10$qWy5NmVnhmCyRNvAKp1ytOBr.Gt5raj5xhf4vJ//y.gCNEdfk.fmK', NULL, 1, '$2y$10$FV/HdBHK5mY9m.9sjQ2cT.2SaLGESxv61DatDScdjxU.P6rDdgigq', '1', '2023-03-12 12:16:20'),
(9, 'prueba4', '$2y$10$8wYYvKGJeJ9HSe8bB/eMoOzGbd0t3wm5cgo73lPOV55rsHx5218r', NULL, 2, '$2y$10$wVG3r6X4pJ9OC/N7KOAGbebDL8.XLAGgeYaSrEd/YghfsEXu3zXfS', '1', '2023-03-12 12:19:15'),
(10, 'prueba5', '$2y$10$283sHD25lf0P.9NomlDxVeC./sswDLNVwzva1UL4yHWA6qS8iP3LS', NULL, 2, '$2y$10$zzS12M5VAiSM2w82r2UhxOLbgFjhcOgmHkQHIbL8XvSgBCcM1VmW', '1', '2023-03-12 12:20:45'),
(11, 'prueba7', '$2y$10$V2c4BKi930rzhXHjwzVNW..75HyeH6/sorbtkENtJW/GqKSdXKTPi', NULL, 2, '$2y$10$fONpNS9YJs9iwJqKAriqmOKDEV4g7.W1a8O8QwIHgObxOYJ9jjlCy', '1', '2023-03-12 12:23:51'),
(12, 'prueba8', '$2y$10$ZT6uYZ8roiOHTyZj8fr/Q.9O5K2jWVXQApHqiZcsnVIpRldLWX5w6', NULL, 2, '$2y$10$ealbx/paU.5dFz5gbkdZguaqXPA4JfO/nz.UsBWXlxoNbw.zIxwyy', '1', '2023-03-12 12:24:57'),
(13, 'prueba9', '$2y$10$R5GmMHu4WSr4VYm3k4d18OXTkqAi.FNBiRguTcHUxpAUXrRDAG2lm', NULL, 2, '$2y$10$ZC/myXwFogw/tvBbueNuQO6eLdyAkHal2X6T1l3tGuzF0B5GQGL/y', '1', '2023-03-12 12:25:02'),
(14, 'prueba19', '$2y$10$yTM5hFVbhnStf3H4zZl6mOX7am.hqcbuE3fZpapM5Glh9j4ufEe', NULL, 2, '$2y$10$VaShynWn0ufEghqLSVKt8u/D6t30xyyGn65JyjmmFAEY2xIwA/MwO', '1', '2023-03-12 12:30:00'),
(15, 'prueba20', '$2y$10$M7z.9vhmvOMvy3Uc0BpeXuXS6Y354zf.HefqPjpQp1ojG8m8X3xx', NULL, 2, '$2y$10$CBtM.a5KEAyeIQzphYwrlunvHVvmRIrOslwi5/mM4uG0IH7W5JvCi', '1', '2023-03-12 12:31:06'),
(16, 'prueba21', '$2y$10$W4Zh1g1nIH4RAjIws/pXZOohX7JhME64sAZmjJwQBF.nb0.X6F/ce', NULL, 2, '$2y$10$ijDkjr8kV6fpVgPfg29lfu/DFByHz6igGrgChdJUQltZZ75NedX0e', '1', '2023-03-12 12:31:35');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`auditoria_id`),
  ADD KEY `fk_auditoria_usuario` (`usuario_id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`cita_id`),
  ADD KEY `fk_cita_paciente` (`paciente_id`),
  ADD KEY `fk_cita_medico` (`medico_id`),
  ADD KEY `fk_cita_seguro` (`seguro_id`),
  ADD KEY `fk_cita_especialidad` (`especialidad_id`);

--
-- Indices de la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  ADD PRIMARY KEY (`compra_insumo_id`),
  ADD KEY `fk_compra_insumo_insumo` (`insumo_id`),
  ADD KEY `fk_compra_insumo_factura_compra` (`factura_compra_id`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`consulta_id`),
  ADD KEY `fk_consulta_medico` (`medico_id`),
  ADD KEY `fk_consulta_paciente` (`paciente_id`),
  ADD KEY `fk_consulta_especialidad` (`especialidad_id`),
  ADD KEY `fk_consulta_cita` (`cita_id`);

--
-- Indices de la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  ADD PRIMARY KEY (`consulta_examen_id`),
  ADD KEY `fk_consulta_examen_consulta` (`consulta_id`),
  ADD KEY `fk_consulta_examen_examen` (`examen_id`);

--
-- Indices de la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  ADD PRIMARY KEY (`consulta_insumo_id`),
  ADD KEY `fk_consulta_insumo_insumo` (`insumo_id`),
  ADD KEY `fk_consulta_insumo_consulta` (`consulta_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`especialidad_id`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`examen_id`);

--
-- Indices de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD PRIMARY KEY (`factura_compra_id`),
  ADD KEY `fk_proveedor_insumo` (`proveedor_id`);

--
-- Indices de la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  ADD PRIMARY KEY (`factura_consulta_id`),
  ADD KEY `fk_factura_consulta_consulta` (`consulta_id`),
  ADD KEY `fk_factura_consulta_paciente` (`paciente_id`);

--
-- Indices de la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  ADD PRIMARY KEY (`factura_medico_id`),
  ADD KEY `fk_factura_medico_medico` (`medico_id`);

--
-- Indices de la tabla `factura_seguro`
--
ALTER TABLE `factura_seguro`
  ADD PRIMARY KEY (`factura_seguro_id`),
  ADD KEY `fk_factura_seguro_consulta` (`consulta_id`),
  ADD KEY `fk_factura_seguro_seguro` (`seguro_id`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`horario_id`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`insumo_id`);

--
-- Indices de la tabla `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`medico_id`);

--
-- Indices de la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD PRIMARY KEY (`medico_especialidad_id`),
  ADD KEY `fk_medico_especialidad_medico` (`medico_id`),
  ADD KEY `fk_medico_especialidad_especialidad` (`especialidad_id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`paciente_id`);

--
-- Indices de la tabla `paciente_beneficiado`
--
ALTER TABLE `paciente_beneficiado`
  ADD PRIMARY KEY (`paciente_beneficiado_id`),
  ADD KEY `fk_pacienteBeneficiado_paciente` (`paciente_id`);

--
-- Indices de la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  ADD PRIMARY KEY (`paciente_seguro_id`),
  ADD KEY `fk_paciente_seguro_paciente` (`paciente_id`),
  ADD KEY `fk_paciente_seguro_seguro` (`seguro_id`),
  ADD KEY `fk_paciente_seguro_empresa` (`empresa_id`);

--
-- Indices de la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  ADD PRIMARY KEY (`pregunta_id`),
  ADD KEY `fk_pregunta_usuario` (`usuario_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`proveedor_id`);

--
-- Indices de la tabla `seguro`
--
ALTER TABLE `seguro`
  ADD PRIMARY KEY (`seguro_id`);

--
-- Indices de la tabla `seguro_empresa`
--
ALTER TABLE `seguro_empresa`
  ADD PRIMARY KEY (`seguro_empresa_id`),
  ADD KEY `fk_seguro_empresa_empresa` (`empresa_id`),
  ADD KEY `fk_seguro_empresa_seguro` (`seguro_id`);

--
-- Indices de la tabla `titular_beneficiado`
--
ALTER TABLE `titular_beneficiado`
  ADD PRIMARY KEY (`titular_beneficiado_id`),
  ADD KEY `fk_titular_beneficiado` (`paciente_beneficiado_id`),
  ADD KEY `fk_titular_paciente` (`paciente_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `tokken` (`tokken`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `auditoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  MODIFY `compra_insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `consulta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  MODIFY `consulta_examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  MODIFY `consulta_insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `factura_compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  MODIFY `factura_consulta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  MODIFY `factura_medico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `factura_seguro`
--
ALTER TABLE `factura_seguro`
  MODIFY `factura_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `horario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `medico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  MODIFY `medico_especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `paciente_beneficiado`
--
ALTER TABLE `paciente_beneficiado`
  MODIFY `paciente_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  MODIFY `paciente_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `seguro`
--
ALTER TABLE `seguro`
  MODIFY `seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `seguro_empresa`
--
ALTER TABLE `seguro_empresa`
  MODIFY `seguro_empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `titular_beneficiado`
--
ALTER TABLE `titular_beneficiado`
  MODIFY `titular_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `fk_auditoria_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  ADD CONSTRAINT `fk_compra_insumo_factura_compra` FOREIGN KEY (`factura_compra_id`) REFERENCES `factura_compra` (`factura_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_insumo_insumo` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `fk_consulta_cita` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  ADD CONSTRAINT `fk_consulta_examen_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_examen_examen` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  ADD CONSTRAINT `fk_consulta_insumo_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_insumo_insumo` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD CONSTRAINT `fk_proveedor_insumo` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  ADD CONSTRAINT `fk_factura_consulta_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_consulta_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  ADD CONSTRAINT `fk_factura_medico_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_seguro`
--
ALTER TABLE `factura_seguro`
  ADD CONSTRAINT `fk_factura_seguro_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_seguro_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD CONSTRAINT `fk_medico_especialidad_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_medico_especialidad_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paciente_beneficiado`
--
ALTER TABLE `paciente_beneficiado`
  ADD CONSTRAINT `fk_pacienteBeneficiado_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  ADD CONSTRAINT `fk_paciente_seguro_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paciente_seguro_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_paciente_seguro_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  ADD CONSTRAINT `fk_pregunta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seguro_empresa`
--
ALTER TABLE `seguro_empresa`
  ADD CONSTRAINT `fk_seguro_empresa_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seguro_empresa_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `titular_beneficiado`
--
ALTER TABLE `titular_beneficiado`
  ADD CONSTRAINT `fk_titular_beneficiado` FOREIGN KEY (`paciente_beneficiado_id`) REFERENCES `paciente_beneficiado` (`paciente_beneficiado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_titular_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
