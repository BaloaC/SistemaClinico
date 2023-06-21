-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2023 a las 03:43:26
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

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
CREATE DATABASE IF NOT EXISTS `shenque_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `shenque_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentes_medicos`
--

CREATE TABLE `antecedentes_medicos` (
  `antecedentes_medicos_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `tipo_antecedente_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estatus_ant` enum('1','2') NOT NULL DEFAULT '1',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `antecedentes_medicos`:
--   `paciente_id`
--       `paciente` -> `paciente_id`
--   `tipo_antecedente_id`
--       `tipo_antecedente` -> `tipo_antecedente_id`
--

--
-- Volcado de datos para la tabla `antecedentes_medicos`
--

INSERT INTO `antecedentes_medicos` VALUES(4, 7, 4, 'Alergia al polvo, a la tierra y al amarillo #5', '1', '2023-05-28 23:20:31');
INSERT INTO `antecedentes_medicos` VALUES(7, 7, 5, 'Alergia al polen', '1', '2023-05-30 01:20:09');
INSERT INTO `antecedentes_medicos` VALUES(27, 7, 3, 'Alergia al ibuprofeno', '1', '2023-05-30 01:20:28');
INSERT INTO `antecedentes_medicos` VALUES(30, 7, 2, 'Quimios', '1', '2023-05-30 01:20:49');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `auditoria`:
--   `usuario_id`
--       `usuario` -> `usuario_id`
--

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` VALUES(1, '2023-05-03 14:04:03', 4, 'insert', 'Inserto especialidad Oftamología');
INSERT INTO `auditoria` VALUES(2, '2023-05-03 14:04:09', 4, 'insert', 'Inserto especialidad Otorrinolaringología');
INSERT INTO `auditoria` VALUES(3, '2023-05-03 14:04:38', 4, 'insert', 'Inserto especialidad Pediatría');
INSERT INTO `auditoria` VALUES(4, '2023-05-03 14:04:56', 4, 'insert', 'Inserto especialidad Dermatología');
INSERT INTO `auditoria` VALUES(5, '2023-05-03 14:05:16', 4, 'insert', 'Inserto especialidad Odontología');
INSERT INTO `auditoria` VALUES(6, '2023-05-03 14:07:44', 4, 'update', 'Actualizó especialidad Traumatología');
INSERT INTO `auditoria` VALUES(7, '2023-05-03 14:09:22', 4, 'update', 'Actualizó especialidad Otorrinolaringología');
INSERT INTO `auditoria` VALUES(8, '2023-05-03 14:14:09', 4, 'insert', 'Inserto medico Noemí Alejandra');
INSERT INTO `auditoria` VALUES(9, '2023-05-03 14:18:18', 4, 'insert', 'Inserto medico Julia Lucia');
INSERT INTO `auditoria` VALUES(10, '2023-05-03 14:19:03', 4, 'insert', 'Inserto medico Héctor Alejandro');
INSERT INTO `auditoria` VALUES(11, '2023-05-03 14:20:37', 4, 'insert', 'Inserto medico María Hortensia');
INSERT INTO `auditoria` VALUES(12, '2023-05-03 14:31:04', 4, 'insert', 'Inserto proveedor Proveedores Médicos C.A');
INSERT INTO `auditoria` VALUES(13, '2023-05-03 14:41:20', 4, 'insert', 'Inserto proveedor Proveedores Cagua');
INSERT INTO `auditoria` VALUES(14, '2023-05-03 14:43:20', 4, 'insert', 'Inserto proveedor Insumos médicos C.A');
INSERT INTO `auditoria` VALUES(15, '2023-05-03 14:43:33', 4, 'insert', 'Inserto proveedor Insumos Miranda');
INSERT INTO `auditoria` VALUES(16, '2023-05-03 14:44:01', 4, 'update', 'Actualizó proveedor Insumos médicos S.A');
INSERT INTO `auditoria` VALUES(17, '2023-05-03 14:44:09', 4, 'update', 'Actualizó proveedor Insumos médicos C.A');
INSERT INTO `auditoria` VALUES(18, '2023-05-03 14:44:21', 4, 'delete', 'Eliminó proveedor Insumos Miranda');
INSERT INTO `auditoria` VALUES(19, '2023-05-03 14:44:33', 4, 'insert', 'Inserto proveedor Insumos Caracas');
INSERT INTO `auditoria` VALUES(20, '2023-05-03 14:49:58', 4, 'insert', 'Inserto insumo inyecciones');
INSERT INTO `auditoria` VALUES(21, '2023-05-03 14:51:31', 4, 'insert', 'Inserto proveedor Proveedores Magic');
INSERT INTO `auditoria` VALUES(22, '2023-05-03 14:52:51', 4, 'insert', 'Inserto insumo Gazas');
INSERT INTO `auditoria` VALUES(23, '2023-05-03 14:55:08', 4, 'insert', 'Inserto insumo Paletas');
INSERT INTO `auditoria` VALUES(24, '2023-05-03 14:56:01', 4, 'insert', 'Inserto insumo Unidad de Diclofenaco');
INSERT INTO `auditoria` VALUES(25, '2023-05-03 14:56:52', 4, 'insert', 'Inserto insumo Unidad de ibuprofeno');
INSERT INTO `auditoria` VALUES(26, '2023-05-03 14:56:55', 4, 'delete', 'Eliminó insumo Unidad de ibuprofeno');
INSERT INTO `auditoria` VALUES(27, '2023-05-03 15:00:53', 4, 'insert', 'Inserto seguro Seguros Miranda');
INSERT INTO `auditoria` VALUES(28, '2023-05-03 15:02:45', 4, 'insert', 'Inserto seguro Seguros Venezolanos');
INSERT INTO `auditoria` VALUES(29, '2023-05-03 15:03:56', 4, 'insert', 'Inserto seguro Seguros Qualitas');
INSERT INTO `auditoria` VALUES(30, '2023-05-03 15:04:41', 4, 'insert', 'Inserto seguro Seguros Pirámides');
INSERT INTO `auditoria` VALUES(31, '2023-05-03 15:05:25', 4, 'update', 'Actualizó seguro Seguros Venezolanos C.A');
INSERT INTO `auditoria` VALUES(32, '2023-05-03 15:06:58', 4, 'insert', 'Inserto empresa Vasos Venezolanos C.A');
INSERT INTO `auditoria` VALUES(33, '2023-05-03 15:07:17', 4, 'insert', 'Inserto empresa Selva C.A');
INSERT INTO `auditoria` VALUES(34, '2023-05-03 15:07:48', 4, 'insert', 'Inserto empresa Envasados Samír');
INSERT INTO `auditoria` VALUES(35, '2023-05-03 15:32:26', 4, 'update', 'Actualizó empresa Vasos Venezolanos');
INSERT INTO `auditoria` VALUES(36, '2023-05-03 16:31:47', 4, 'insert', 'Inserto examen Perfil 20');
INSERT INTO `auditoria` VALUES(37, '2023-05-03 16:33:08', 4, 'insert', 'Inserto examen Hemoglobina');
INSERT INTO `auditoria` VALUES(38, '2023-05-03 16:33:22', 4, 'insert', 'Inserto examen Colesterol');
INSERT INTO `auditoria` VALUES(39, '2023-05-03 16:33:42', 4, 'insert', 'Inserto examen Ecosonograma Pelvico');
INSERT INTO `auditoria` VALUES(40, '2023-05-03 16:35:42', 4, 'update', 'Actualizó examen Ecosonograma Tiroideo');
INSERT INTO `auditoria` VALUES(41, '2023-05-03 16:35:53', 4, 'insert', 'Inserto examen Preuab');
INSERT INTO `auditoria` VALUES(42, '2023-05-03 16:35:56', 4, 'delete', 'Eliminó examen Preuab');
INSERT INTO `auditoria` VALUES(43, '2023-05-03 17:18:55', 4, 'insert', 'Inserto factura compra ');
INSERT INTO `auditoria` VALUES(44, '2023-05-03 17:18:55', 4, 'insert', 'Inserto compra insumo ');
INSERT INTO `auditoria` VALUES(45, '2023-05-03 17:18:55', 4, 'update', 'Actualizó insumo Gazas');
INSERT INTO `auditoria` VALUES(46, '2023-05-03 17:18:55', 4, 'insert', 'Inserto compra insumo ');
INSERT INTO `auditoria` VALUES(47, '2023-05-03 17:18:55', 4, 'update', 'Actualizó insumo Paletas');
INSERT INTO `auditoria` VALUES(48, '2023-05-03 17:18:55', 4, 'insert', 'Inserto compra insumo ');
INSERT INTO `auditoria` VALUES(49, '2023-05-03 17:18:55', 4, 'update', 'Actualizó insumo Unidad de Diclofenaco');
INSERT INTO `auditoria` VALUES(50, '2023-05-03 17:21:29', 4, 'insert', 'Inserto factura compra ');
INSERT INTO `auditoria` VALUES(51, '2023-05-03 17:21:29', 4, 'insert', 'Inserto compra insumo ');
INSERT INTO `auditoria` VALUES(52, '2023-05-03 17:21:29', 4, 'update', 'Actualizó insumo Gazas');
INSERT INTO `auditoria` VALUES(53, '2023-05-03 17:54:31', 4, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(54, '2023-05-03 18:03:39', 4, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(55, '2023-05-03 18:03:39', 4, 'update', 'Actualizó cita ');
INSERT INTO `auditoria` VALUES(56, '2023-05-03 18:08:22', 4, 'insert', 'Inserto factura consulta ');
INSERT INTO `auditoria` VALUES(57, '2023-05-03 18:08:37', 4, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(58, '2023-05-20 13:01:01', 5, 'insert', 'Inserto factura compra ');
INSERT INTO `auditoria` VALUES(59, '2023-05-20 13:01:01', 5, 'insert', 'Inserto compra insumo ');
INSERT INTO `auditoria` VALUES(60, '2023-05-20 13:01:01', 5, 'update', 'Actualizó insumo Gazas');
INSERT INTO `auditoria` VALUES(61, '2023-05-20 13:18:56', 5, 'delete', 'Eliminó insumo ');
INSERT INTO `auditoria` VALUES(62, '2023-05-20 13:22:44', 5, 'delete', 'Eliminó insumo ');
INSERT INTO `auditoria` VALUES(63, '2023-05-20 13:22:54', 5, 'delete', 'Eliminó insumo ');
INSERT INTO `auditoria` VALUES(64, '2023-05-20 13:22:56', 5, 'delete', 'Eliminó insumo ');
INSERT INTO `auditoria` VALUES(65, '2023-05-20 13:22:58', 5, 'delete', 'Eliminó insumo ');
INSERT INTO `auditoria` VALUES(66, '2023-05-20 13:29:51', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(67, '2023-05-20 13:48:36', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(68, '2023-05-20 13:55:39', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(69, '2023-05-20 13:56:39', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(70, '2023-05-20 13:57:10', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(71, '2023-05-20 13:57:18', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(72, '2023-05-20 13:57:41', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(73, '2023-05-20 14:04:19', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(74, '2023-05-20 14:04:50', 5, 'update', 'Actualizó factura compra ');
INSERT INTO `auditoria` VALUES(75, '2023-05-20 14:05:30', 5, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(76, '2023-05-20 14:16:54', 5, 'update', 'Actualizó factura medico ');
INSERT INTO `auditoria` VALUES(77, '2023-05-20 14:17:49', 5, 'update', 'Actualizó factura medico ');
INSERT INTO `auditoria` VALUES(78, '2023-05-20 14:18:18', 5, 'delete', 'Eliminó factura medico ');
INSERT INTO `auditoria` VALUES(79, '2023-05-20 15:19:23', 5, 'delete', 'Eliminó factura consulta ');
INSERT INTO `auditoria` VALUES(80, '2023-05-20 15:19:34', 5, 'insert', 'Inserto factura consulta ');
INSERT INTO `auditoria` VALUES(81, '2023-05-20 16:52:34', 5, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(82, '2023-05-21 14:54:20', 5, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(83, '2023-05-21 15:22:29', 5, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(84, '2023-05-21 15:22:29', 5, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(85, '2023-05-21 15:22:29', 5, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(86, '2023-05-21 15:22:29', 5, 'insert', 'Inserto factura medico ');
INSERT INTO `auditoria` VALUES(87, '2023-05-21 16:00:22', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(88, '2023-05-21 16:13:27', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(89, '2023-05-21 16:13:27', 5, 'update', 'Actualizó cita ');
INSERT INTO `auditoria` VALUES(90, '2023-05-21 16:15:01', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(91, '2023-05-21 16:15:01', 5, 'update', 'Actualizó cita ');
INSERT INTO `auditoria` VALUES(92, '2023-05-21 17:06:09', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(93, '2023-05-21 17:09:05', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(94, '2023-05-21 17:09:05', 5, 'update', 'Actualizó cita ');
INSERT INTO `auditoria` VALUES(95, '2023-05-21 17:14:17', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(96, '2023-05-21 17:14:17', 5, 'update', 'Actualizó cita ');
INSERT INTO `auditoria` VALUES(97, '2023-05-21 17:22:21', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(98, '2023-05-21 18:18:44', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(99, '2023-05-26 00:47:46', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(100, '2023-05-26 02:25:32', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(101, '2023-05-26 02:28:45', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(102, '2023-05-26 02:34:40', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(103, '2023-05-26 02:34:40', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(104, '2023-05-26 02:34:40', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(105, '2023-05-26 02:34:40', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(106, '2023-05-26 02:34:40', 5, 'insert', 'Inserto factura seguro ');
INSERT INTO `auditoria` VALUES(107, '2023-05-26 02:37:30', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(108, '2023-05-26 02:40:57', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(109, '2023-05-27 20:43:19', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(110, '2023-05-27 20:54:49', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(111, '2023-05-27 20:54:59', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(112, '2023-05-27 21:04:13', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(113, '2023-05-28 18:59:52', 5, 'insert', 'Inserto consulta seguro ');
INSERT INTO `auditoria` VALUES(114, '2023-05-28 20:00:38', 5, 'insert', 'Inserto factura compra ');
INSERT INTO `auditoria` VALUES(115, '2023-05-28 20:00:38', 5, 'insert', 'Inserto compra insumo ');
INSERT INTO `auditoria` VALUES(116, '2023-05-28 20:00:38', 5, 'update', 'Actualizó insumo inyecciones');
INSERT INTO `auditoria` VALUES(117, '2023-05-28 22:54:41', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(118, '2023-05-28 22:55:36', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(119, '2023-05-28 23:00:09', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(120, '2023-05-28 23:06:39', 5, 'update', 'Actualizó antecedentes medicos ');
INSERT INTO `auditoria` VALUES(121, '2023-05-28 23:06:50', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(122, '2023-05-28 23:20:31', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(123, '2023-05-28 23:21:29', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(124, '2023-05-29 00:06:06', 5, 'update', 'Actualizó antecedentes medicos ');
INSERT INTO `auditoria` VALUES(125, '2023-05-29 00:13:59', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(126, '2023-05-29 00:14:29', 5, 'insert', 'Inserto antecedentes medicos ');
INSERT INTO `auditoria` VALUES(127, '2023-05-30 01:15:45', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(128, '2023-05-30 01:16:58', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(129, '2023-05-30 01:17:05', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(130, '2023-05-30 01:20:09', 5, 'update', 'Actualizó antecedentes medicos ');
INSERT INTO `auditoria` VALUES(131, '2023-05-30 01:20:28', 5, 'update', 'Actualizó antecedentes medicos ');
INSERT INTO `auditoria` VALUES(132, '2023-05-30 01:20:49', 5, 'update', 'Actualizó antecedentes medicos ');
INSERT INTO `auditoria` VALUES(133, '2023-05-30 01:23:00', 5, 'update', 'Actualizó antecedentes medicos ');
INSERT INTO `auditoria` VALUES(134, '2023-06-01 00:20:31', 5, 'insert', 'Inserto examen Cerebrologia');
INSERT INTO `auditoria` VALUES(135, '2023-06-01 00:21:25', 5, 'insert', 'Inserto examen Otorrinolaringología');
INSERT INTO `auditoria` VALUES(136, '2023-06-01 00:23:26', 5, 'insert', 'Inserto examen Dermatología');
INSERT INTO `auditoria` VALUES(137, '2023-06-01 00:27:09', 5, 'insert', 'Inserto examen Dermatologí');
INSERT INTO `auditoria` VALUES(138, '2023-06-01 00:27:09', 5, 'insert', 'Inserto examen Dermatologí');
INSERT INTO `auditoria` VALUES(139, '2023-06-01 00:39:19', 5, 'insert', 'Inserto examen Dermatología');
INSERT INTO `auditoria` VALUES(140, '2023-06-01 00:43:10', 5, 'insert', 'Inserto examen Dermatología');
INSERT INTO `auditoria` VALUES(141, '2023-06-02 20:24:25', 5, 'insert', 'Inserto medicamento ');
INSERT INTO `auditoria` VALUES(142, '2023-06-02 20:37:35', 5, 'update', 'Actualizó medicamento ');
INSERT INTO `auditoria` VALUES(143, '2023-06-02 20:38:08', 5, 'update', 'Actualizó medicamento ');
INSERT INTO `auditoria` VALUES(144, '2023-06-02 20:39:12', 5, 'update', 'Actualizó medicamento ');
INSERT INTO `auditoria` VALUES(145, '2023-06-02 20:48:27', 5, 'delete', 'Eliminó medicamento ');
INSERT INTO `auditoria` VALUES(146, '2023-06-02 20:48:40', 5, 'delete', 'Eliminó medicamento ');
INSERT INTO `auditoria` VALUES(147, '2023-06-02 20:48:44', 5, 'delete', 'Eliminó medicamento ');
INSERT INTO `auditoria` VALUES(148, '2023-06-02 23:42:25', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(149, '2023-06-02 23:45:32', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(150, '2023-06-02 23:46:57', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(151, '2023-06-02 23:47:08', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(152, '2023-06-02 23:48:35', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(153, '2023-06-02 23:49:17', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(154, '2023-06-02 23:49:39', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(155, '2023-06-02 23:49:59', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(156, '2023-06-02 23:50:31', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(157, '2023-06-02 23:50:58', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(158, '2023-06-02 23:51:12', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(159, '2023-06-02 23:51:44', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(160, '2023-06-02 23:52:37', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(161, '2023-06-02 23:53:06', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(162, '2023-06-02 23:53:06', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(163, '2023-06-02 23:53:17', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(164, '2023-06-02 23:53:17', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(165, '2023-06-02 23:53:31', 5, 'insert', 'Inserto consulta ');
INSERT INTO `auditoria` VALUES(166, '2023-06-08 01:15:38', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(167, '2023-06-08 01:36:24', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(168, '2023-06-08 01:44:43', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(169, '2023-06-08 01:46:36', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(170, '2023-06-08 23:09:21', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(171, '2023-06-08 23:09:29', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(172, '2023-06-10 22:19:13', 5, 'insert', 'Inserto medico ');
INSERT INTO `auditoria` VALUES(173, '2023-06-10 22:49:16', 5, 'insert', 'Inserto medico ');
INSERT INTO `auditoria` VALUES(174, '2023-06-10 23:01:22', 5, 'insert', 'Inserto medico ');
INSERT INTO `auditoria` VALUES(175, '2023-06-10 23:01:51', 5, 'insert', 'Inserto medico Alberto');
INSERT INTO `auditoria` VALUES(176, '2023-06-10 23:02:43', 5, 'insert', 'Inserto medico Alberto');
INSERT INTO `auditoria` VALUES(177, '2023-06-10 23:03:23', 5, 'insert', 'Inserto medico Alberto');
INSERT INTO `auditoria` VALUES(178, '2023-06-11 23:49:37', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(179, '2023-06-12 00:39:36', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(180, '2023-06-21 00:19:44', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(181, '2023-06-21 00:24:59', 5, 'insert', 'Inserto cita ');
INSERT INTO `auditoria` VALUES(182, '2023-06-21 00:26:24', 5, 'update', 'Actualizó cita seguro ');
INSERT INTO `auditoria` VALUES(183, '2023-06-21 00:49:34', 5, 'insert', 'Inserto cita ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `cita_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `fecha_cita` date NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_entrada` time NOT NULL,
  `motivo_cita` varchar(45) NOT NULL,
  `cedula_titular` int(11) NOT NULL,
  `tipo_cita` enum('1','2') NOT NULL,
  `estatus_cit` enum('1','2','3','4',' 5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `cita`:
--   `especialidad_id`
--       `especialidad` -> `especialidad_id`
--   `medico_id`
--       `medico` -> `medico_id`
--   `paciente_id`
--       `paciente` -> `paciente_id`
--

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` VALUES(27, 11, 9, 9, '2023-06-22', '09:50:00', '08:50:00', 'dolor de cabeza', 18956458, '2', '3');
INSERT INTO `cita` VALUES(28, 7, 9, 9, '2023-06-22', '10:00:00', '09:51:00', 'dolor de cabeza', 18954458, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_seguro`
--

CREATE TABLE `cita_seguro` (
  `cita_seguro_id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `clave` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `cita_seguro`:
--   `cita_id`
--       `cita` -> `cita_id`
--   `seguro_id`
--       `seguro` -> `seguro_id`
--

--
-- Volcado de datos para la tabla `cita_seguro`
--

INSERT INTO `cita_seguro` VALUES(5, 27, 5, 'clave');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_insumo`
--

CREATE TABLE `compra_insumo` (
  `compra_insumo_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `factura_compra_id` int(11) NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_unit` float NOT NULL,
  `precio_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `compra_insumo`:
--

--
-- Volcado de datos para la tabla `compra_insumo`
--

INSERT INTO `compra_insumo` VALUES(000000012, 0, 1, 0, 0, 0);
INSERT INTO `compra_insumo` VALUES(000000013, 3, 9, 8, 1, 0);

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
  `estatus_con` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `consulta`:
--   `cita_id`
--       `cita` -> `cita_id`
--   `especialidad_id`
--       `especialidad` -> `especialidad_id`
--   `medico_id`
--       `medico` -> `medico_id`
--   `paciente_id`
--       `paciente` -> `paciente_id`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_examen`
--

CREATE TABLE `consulta_examen` (
  `consulta_examen_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `consulta_examen`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_indicaciones`
--

CREATE TABLE `consulta_indicaciones` (
  `consulta_indicaciones_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `consulta_indicaciones`:
--

--
-- Volcado de datos para la tabla `consulta_indicaciones`
--

INSERT INTO `consulta_indicaciones` VALUES(1, 51, 'Usar protector solar de 50 FPS');
INSERT INTO `consulta_indicaciones` VALUES(2, 51, 'Usar jabón BIOS');
INSERT INTO `consulta_indicaciones` VALUES(3, 50, 'Usar protector solar de 50 FPS');
INSERT INTO `consulta_indicaciones` VALUES(4, 50, 'Usar jabón BIOS');
INSERT INTO `consulta_indicaciones` VALUES(5, 52, 'Usar protector solar de 30 FPS');
INSERT INTO `consulta_indicaciones` VALUES(6, 52, 'Usar jabón BIOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_insumo`
--

CREATE TABLE `consulta_insumo` (
  `consulta_insumo_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `consulta_insumo`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_recipe`
--

CREATE TABLE `consulta_recipe` (
  `consulta_recipe_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `medicamento_id` int(11) NOT NULL,
  `uso` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `consulta_recipe`:
--   `consulta_id`
--       `consulta` -> `consulta_id`
--   `medicamento_id`
--       `medicamento` -> `medicamento_id`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_seguro`
--

CREATE TABLE `consulta_seguro` (
  `consulta_seguro_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `tipo_servicio` varchar(50) NOT NULL,
  `fecha_ocurrencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `monto` float NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `consulta_seguro`:
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `empresa`:
--

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` VALUES(3, 'Vasos Venezolanos', 'J-234242341', 'Complejo Industrial La Hamaca', '1');
INSERT INTO `empresa` VALUES(4, 'Selva C.A', 'J-155465488', 'Complejo Industrial La Hamaca', '1');
INSERT INTO `empresa` VALUES(5, 'Envasados Samír', 'J-256489158', 'Andrés Eloy Blanco', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `especialidad_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estatus_esp` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `especialidad`:
--

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` VALUES(7, 'Oftamología', '1');
INSERT INTO `especialidad` VALUES(8, 'Otorrinolaringología', '1');
INSERT INTO `especialidad` VALUES(9, 'Pediatría', '1');
INSERT INTO `especialidad` VALUES(10, 'Dermatología', '1');
INSERT INTO `especialidad` VALUES(11, 'Odontología', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `examen_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `tipo` enum('1','2','3') NOT NULL,
  `hecho_aqui` tinyint(1) NOT NULL DEFAULT 0,
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `examen`:
--

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` VALUES(3, 'Perfil 20', '', 0, '1');
INSERT INTO `examen` VALUES(4, 'Hemoglobina', '', 0, '1');
INSERT INTO `examen` VALUES(5, 'Colesterol', '', 0, '1');
INSERT INTO `examen` VALUES(6, 'Ecosonograma Tiroideo', '', 0, '1');
INSERT INTO `examen` VALUES(7, 'Preuab', '', 0, '2');
INSERT INTO `examen` VALUES(8, 'Cerebrologia', '', 0, '1');
INSERT INTO `examen` VALUES(9, 'Otorrinolaringología', '', 0, '1');
INSERT INTO `examen` VALUES(14, 'Dermatología', '', 1, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE `factura_compra` (
  `factura_compra_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `total_productos` int(11) NOT NULL,
  `monto_con_iva` float NOT NULL,
  `monto_sin_iva` float NOT NULL,
  `excento` float DEFAULT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `factura_compra`:
--

--
-- Volcado de datos para la tabla `factura_compra`
--

INSERT INTO `factura_compra` VALUES(000000009, 3, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_consulta`
--

CREATE TABLE `factura_consulta` (
  `factura_consulta_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `monto_sin_iva` float NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `factura_consulta`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_medico`
--

CREATE TABLE `factura_medico` (
  `factura_medico_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `medico_id` int(11) NOT NULL,
  `acumulado_seguro_total` float DEFAULT NULL,
  `acumulado_consulta_total` float DEFAULT NULL,
  `pago_total` float DEFAULT NULL,
  `fecha_pago` date NOT NULL,
  `pacientes_seguro` int(11) DEFAULT NULL,
  `pacientes_consulta` int(11) DEFAULT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `factura_medico`:
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_seguro`
--

CREATE TABLE `factura_seguro` (
  `factura_seguro_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `mes` varchar(10) NOT NULL,
  `fecha_ocurrencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_vencimiento` date NOT NULL,
  `monto` float NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `factura_seguro`:
--

--
-- Volcado de datos para la tabla `factura_seguro`
--

INSERT INTO `factura_seguro` VALUES(00000002, 0, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1');
INSERT INTO `factura_seguro` VALUES(00000003, 5, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 400, '1');
INSERT INTO `factura_seguro` VALUES(00000004, 6, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1');
INSERT INTO `factura_seguro` VALUES(00000005, 7, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1');
INSERT INTO `factura_seguro` VALUES(00000006, 8, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `horario_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `dias_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado') NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_entrada` time NOT NULL,
  `estatus_hor` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `horario`:
--

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` VALUES(33, 9, 'lunes', '12:00:00', '08:00:00', '1');
INSERT INTO `horario` VALUES(34, 9, 'martes', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(35, 9, 'jueves', '10:00:00', '07:00:00', '1');
INSERT INTO `horario` VALUES(36, 9, 'viernes', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(37, 10, 'lunes', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(38, 10, 'viernes', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(39, 11, 'lunes', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(40, 11, 'jueves', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(41, 11, 'sabado', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(42, 12, 'martes', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(43, 12, 'miercoles', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(44, 12, 'jueves', '00:00:00', '00:00:00', '1');
INSERT INTO `horario` VALUES(45, 18, 'jueves', '20:00:00', '15:00:00', '1');
INSERT INTO `horario` VALUES(46, 18, 'viernes', '12:00:00', '07:00:00', '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `insumo`:
--

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` VALUES(3, 'inyecciones', 28, 0, 5, 20, '1');
INSERT INTO `insumo` VALUES(4, 'Gazas', 106, 0, 10, 50, '1');
INSERT INTO `insumo` VALUES(5, 'Paletas', 130, 0, 15, 1, '1');
INSERT INTO `insumo` VALUES(6, 'Unidad de Diclofenaco', 300, 0, 15, 3, '1');
INSERT INTO `insumo` VALUES(7, 'Unidad de ibuprofeno', 200, 0, 10, 3, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `medicamento_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `nombre_medicamento` varchar(45) NOT NULL,
  `tipo_medicamento` enum('1','2','3') DEFAULT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `medicamento`:
--   `especialidad_id`
--       `especialidad` -> `especialidad_id`
--

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` VALUES(5, 7, 'Diclofenac de 500 mg', '1', '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `medico`:
--

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` VALUES(9, 17589462, 'Noemí Alejandra', 'Torre Bolaños', '04124589623', 'Maracay', '1');
INSERT INTO `medico` VALUES(10, 15962347, 'Julia Lucia', 'Vendrell Acosta', '04124596589', 'Santa Rita', '1');
INSERT INTO `medico` VALUES(11, 17965238, 'Héctor Alejandro', 'Talavera Ibarra', '04244587965', 'Cagua', '1');
INSERT INTO `medico` VALUES(12, 24878989, 'María Hortensia', 'Yuste Sanjuan', '04164578965', 'Santa Inés', '1');
INSERT INTO `medico` VALUES(18, 11502129, 'Alberto', 'Chacón', '04125005556', 'Barrio Bolívar', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_especialidad`
--

CREATE TABLE `medico_especialidad` (
  `medico_especialidad_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `medico_especialidad`:
--

--
-- Volcado de datos para la tabla `medico_especialidad`
--

INSERT INTO `medico_especialidad` VALUES(13, 9, 8, '1');
INSERT INTO `medico_especialidad` VALUES(14, 9, 9, '1');
INSERT INTO `medico_especialidad` VALUES(15, 10, 8, '1');
INSERT INTO `medico_especialidad` VALUES(16, 10, 9, '1');
INSERT INTO `medico_especialidad` VALUES(17, 11, 11, '1');
INSERT INTO `medico_especialidad` VALUES(18, 12, 9, '1');
INSERT INTO `medico_especialidad` VALUES(19, 17, 7, '1');
INSERT INTO `medico_especialidad` VALUES(20, 17, 8, '1');
INSERT INTO `medico_especialidad` VALUES(21, 18, 7, '1');
INSERT INTO `medico_especialidad` VALUES(22, 18, 8, '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `paciente`:
--

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` VALUES(7, 18954458, 'Violeta Jesusa', 'Cornejo Bonilla', '1993-12-12', 29, '04144548484', 'Santa Inés', '1', '1');
INSERT INTO `paciente` VALUES(8, 15962962, 'Ezequiel David', 'Borrego Sans', '1993-12-12', 29, '04141235652', 'Maracay', '2', '1');
INSERT INTO `paciente` VALUES(9, 18956458, 'Jose Angel', 'Español Barros', '2010-12-12', 12, '04247845962', 'Maracay', '4', '1');
INSERT INTO `paciente` VALUES(11, 18956458, 'Elena Concepción', 'Pavón Rondan', '1985-02-12', 38, '04128797855', 'Andres Eloy Blanco', '3', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_beneficiado`
--

CREATE TABLE `paciente_beneficiado` (
  `paciente_beneficiado_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_pac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `paciente_beneficiado`:
--

--
-- Volcado de datos para la tabla `paciente_beneficiado`
--

INSERT INTO `paciente_beneficiado` VALUES(3, 9, '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `paciente_seguro`:
--

--
-- Volcado de datos para la tabla `paciente_seguro`
--

INSERT INTO `paciente_seguro` VALUES(2, 11, 5, 3, '2', 2000, '2023-02-03', 400, '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `pregunta_seguridad`:
--

--
-- Volcado de datos para la tabla `pregunta_seguridad`
--

INSERT INTO `pregunta_seguridad` VALUES(10, 4, '1', 'amarillo', '1');
INSERT INTO `pregunta_seguridad` VALUES(11, 4, '2', 'rocky', '1');
INSERT INTO `pregunta_seguridad` VALUES(12, 4, '2', 'rocky', '1');
INSERT INTO `pregunta_seguridad` VALUES(13, 5, '1', 'amarillo', '1');
INSERT INTO `pregunta_seguridad` VALUES(14, 5, '2', 'rocky', '1');
INSERT INTO `pregunta_seguridad` VALUES(15, 5, '2', 'rocky', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estatus_pro` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `proveedor`:
--

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` VALUES(3, 'Proveedores Médicos C.A', 'Santa Rita', '1');
INSERT INTO `proveedor` VALUES(4, 'Proveedores Cagua', 'Cagua', '1');
INSERT INTO `proveedor` VALUES(5, 'Insumos médicos C.A', 'San Joaquín', '1');
INSERT INTO `proveedor` VALUES(6, 'Insumos Miranda', 'Miranda', '2');
INSERT INTO `proveedor` VALUES(7, 'Insumos Caracas', 'Distrido Capital', '1');
INSERT INTO `proveedor` VALUES(8, 'Proveedores Magic', 'San Vicente', '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `seguro`:
--

--
-- Volcado de datos para la tabla `seguro`
--

INSERT INTO `seguro` VALUES(0, 'ninguno', '0', '0', '0', '1', '1');
INSERT INTO `seguro` VALUES(5, 'Seguros Miranda C.A', 'J-455848484', 'Miranda', '04124564545', '1', '1');
INSERT INTO `seguro` VALUES(6, 'Seguros Venezolanos C.A', 'J-458498451', 'Maracay', '04244589656', '2', '1');
INSERT INTO `seguro` VALUES(7, 'Seguros Qualitas', 'J-156148916', 'Distrito Federal', '04164548798', '2', '1');
INSERT INTO `seguro` VALUES(8, 'Seguros Pirámides', 'J-213412341', 'San Joaquín', '04121561848', '2', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro_empresa`
--

CREATE TABLE `seguro_empresa` (
  `seguro_empresa_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `seguro_empresa`:
--

--
-- Volcado de datos para la tabla `seguro_empresa`
--

INSERT INTO `seguro_empresa` VALUES(5, 3, 5, '1');
INSERT INTO `seguro_empresa` VALUES(6, 4, 6, '1');
INSERT INTO `seguro_empresa` VALUES(7, 5, 5, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_antecedente`
--

CREATE TABLE `tipo_antecedente` (
  `tipo_antecedente_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `estatus_tip` enum('1','2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `tipo_antecedente`:
--

--
-- Volcado de datos para la tabla `tipo_antecedente`
--

INSERT INTO `tipo_antecedente` VALUES(1, 'Antecedentes Patológicos', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(2, 'Antecedentes Psicológicos', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(3, 'Antecedentes médicos familiares', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(4, 'Cirugías o traumatismos', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(5, 'Alergias', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(6, 'Reacción a medicamentos', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(7, 'Enfermedades Padecidas', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(8, 'Tratamientos', '2023-05-28 23:51:47', '1');
INSERT INTO `tipo_antecedente` VALUES(9, 'Hábitos de salud', '2023-05-28 23:51:47', '1');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `titular_beneficiado`:
--

--
-- Volcado de datos para la tabla `titular_beneficiado`
--

INSERT INTO `titular_beneficiado` VALUES(3, 3, 7, '1', '3');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONES PARA LA TABLA `usuario`:
--

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` VALUES(4, 'Francis', '$2y$10$k.Q.Ph9Yyy1ogJB24Q03Wu56ar6TWstSg5Au0sL9Z/j.WzvI1dhC2', 'fabb51bcd6', 2, '$2y$10$yDKhtd2MhxYC/9rbTYDoSevYCSJANGxBVJbU5VbTDSK.f1y9GXshq', '1', '2023-05-03 04:01:06');
INSERT INTO `usuario` VALUES(5, 'guayaba', '$2y$10$Mo3Di1i0xWuRyTHTuHVGbuu/L1L3cQF3/qgx3/POEWeH9KJGZSfii', '6b45a6a154', 1, '$2y$10$Ya6sB9ja4ZVRhe9vkLuBpOUb.mUzlVNgcB9MvE1s8yN73IJeItx86', '1', '2023-05-20 02:51:42');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  ADD PRIMARY KEY (`antecedentes_medicos_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `tipo_antecedente_id` (`tipo_antecedente_id`);

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
  ADD KEY `fk_cita_especialidad` (`especialidad_id`);

--
-- Indices de la tabla `cita_seguro`
--
ALTER TABLE `cita_seguro`
  ADD PRIMARY KEY (`cita_seguro_id`),
  ADD KEY `fk_cita_cita` (`cita_id`),
  ADD KEY `fk_seguro_cita` (`seguro_id`);

--
-- Indices de la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  ADD PRIMARY KEY (`compra_insumo_id`),
  ADD KEY `fk_compra_insumo_factura_compra` (`factura_compra_id`),
  ADD KEY `fk_compra_insumo_insumo` (`insumo_id`);

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
-- Indices de la tabla `consulta_indicaciones`
--
ALTER TABLE `consulta_indicaciones`
  ADD PRIMARY KEY (`consulta_indicaciones_id`);

--
-- Indices de la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  ADD PRIMARY KEY (`consulta_insumo_id`),
  ADD KEY `fk_consulta_insumo_insumo` (`insumo_id`),
  ADD KEY `fk_consulta_insumo_consulta` (`consulta_id`);

--
-- Indices de la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  ADD PRIMARY KEY (`consulta_recipe_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `medicamento_id` (`medicamento_id`);

--
-- Indices de la tabla `consulta_seguro`
--
ALTER TABLE `consulta_seguro`
  ADD PRIMARY KEY (`consulta_seguro_id`),
  ADD KEY `fk_factura_seguro_consulta` (`consulta_id`),
  ADD KEY `fk_consulta_seguro` (`seguro_id`);

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
  ADD KEY `seguro_id` (`seguro_id`);

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
-- Indices de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`medicamento_id`),
  ADD KEY `especialidad_id` (`especialidad_id`);

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
-- Indices de la tabla `tipo_antecedente`
--
ALTER TABLE `tipo_antecedente`
  ADD PRIMARY KEY (`tipo_antecedente_id`);

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
-- AUTO_INCREMENT de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  MODIFY `antecedentes_medicos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `auditoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `cita_seguro`
--
ALTER TABLE `cita_seguro`
  MODIFY `cita_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  MODIFY `compra_insumo_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `consulta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  MODIFY `consulta_examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `consulta_indicaciones`
--
ALTER TABLE `consulta_indicaciones`
  MODIFY `consulta_indicaciones_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  MODIFY `consulta_insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  MODIFY `consulta_recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `consulta_seguro`
--
ALTER TABLE `consulta_seguro`
  MODIFY `consulta_seguro_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `factura_compra_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  MODIFY `factura_consulta_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  MODIFY `factura_medico_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `factura_seguro`
--
ALTER TABLE `factura_seguro`
  MODIFY `factura_seguro_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `horario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `medicamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `medico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  MODIFY `medico_especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `paciente_beneficiado`
--
ALTER TABLE `paciente_beneficiado`
  MODIFY `paciente_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  MODIFY `paciente_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seguro`
--
ALTER TABLE `seguro`
  MODIFY `seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `seguro_empresa`
--
ALTER TABLE `seguro_empresa`
  MODIFY `seguro_empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_antecedente`
--
ALTER TABLE `tipo_antecedente`
  MODIFY `tipo_antecedente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `titular_beneficiado`
--
ALTER TABLE `titular_beneficiado`
  MODIFY `titular_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  ADD CONSTRAINT `antecedentes_medicos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `antecedentes_medicos_ibfk_2` FOREIGN KEY (`tipo_antecedente_id`) REFERENCES `tipo_antecedente` (`tipo_antecedente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_cita_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita_seguro`
--
ALTER TABLE `cita_seguro`
  ADD CONSTRAINT `fk_cita_cita` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seguro_cita` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `fk_consulta_cita` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  ADD CONSTRAINT `consulta_recipe_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_recipe_ibfk_2` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamento` (`medicamento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
