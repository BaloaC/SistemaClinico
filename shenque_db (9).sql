-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2024 a las 19:26:51
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
-- Base de datos: `shenque_db`
--

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
-- Volcado de datos para la tabla `antecedentes_medicos`
--

INSERT INTO `antecedentes_medicos` (`antecedentes_medicos_id`, `paciente_id`, `tipo_antecedente_id`, `descripcion`, `estatus_ant`, `fecha_creacion`) VALUES
(1, 10, 2, 'episodios de depresión', '1', '2024-03-25 04:42:48'),
(2, 1, 1, 'Asma infantil', '1', '2024-04-21 03:33:06'),
(3, 1, 2, 'Dermatitis', '1', '2024-04-21 03:35:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE `auditoria` (
  `auditoria_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `accion` varchar(45) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`auditoria_id`, `fecha_creacion`, `usuario_id`, `accion`, `descripcion`) VALUES
(4, '2024-03-01 02:42:16', 1, 'insert', 'Francis ha insertado un nuevo elemento Neurocirugía en el módulo especialidad'),
(9, '2024-03-21 00:51:45', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Ana Maríca Gonzalez Perasa'),
(10, '2024-03-21 01:14:50', 1, 'inserción', 'El usuario Francis reprogramó la cita_id 46 del paciente Ana Maríca a la fecha 2024-03-30'),
(11, '2024-03-21 01:20:53', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Mariana Gonzalez'),
(12, '2024-03-21 01:22:15', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 51 del paciente Mariana Gonzalez'),
(14, '2024-03-22 02:44:12', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(15, '2024-03-22 02:48:33', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 22345321'),
(17, '2024-03-22 02:56:19', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 15849652'),
(18, '2024-03-24 23:12:35', 1, 'inserción', 'Francis ha insertado un nuevo elemento Gatroenterología pediátrica en el módulo especialidad'),
(21, '2024-03-24 23:41:12', 1, 'actualización', 'Francis ha actualizado al elemento id 85 los campos nombre, especialidad_id en el módulo especialidad'),
(22, '2024-03-24 23:45:01', 1, 'eliminación', 'Francis ha eliminado al elemento id 85 en el módulo especialidad'),
(23, '2024-03-24 23:56:16', 1, 'inserción', 'Francis ha insertado un nuevo elemento Escala de ansiedad de Hamilton en el módulo exámenes'),
(24, '2024-03-24 23:57:58', 1, 'eliminación', 'Francis ha eliminado al elemento id 39 en el módulo exámenes'),
(25, '2024-03-25 00:09:15', 1, 'inserción', 'Francis ha insertado un nuevo elemento  en el módulo medicamentos'),
(26, '2024-03-25 00:11:28', 1, 'inserción', 'Francis ha insertado un nuevo elemento con el nombre venlafaxina  en el módulo medicamentos'),
(27, '2024-03-25 00:18:17', 1, 'eliminación', 'Francis ha eliminado al elemento id 27 en el módulo insumos'),
(28, '2024-03-25 00:20:20', 1, 'inserción', 'Francis ha insertado un nuevo elemento con el nombre Roger Ojeda en el módulo pacientes'),
(29, '2024-03-25 00:25:49', 1, 'eliminación', 'Francis ha eliminado al elemento id 86 en el módulo pacientes'),
(30, '2024-03-25 00:27:57', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12345678'),
(31, '2024-03-25 00:31:10', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Miguel Cervanos'),
(32, '2024-03-25 00:33:55', 1, 'inserción', 'Francis ha insertado un nuevo elemento con el nombre Seguro de test en el módulo seguros'),
(33, '2024-03-25 00:36:30', 1, 'inserción', 'Francis ha insertado un nuevo elemento con el nombre Empresa de auditoría en el módulo empresas'),
(34, '2024-03-25 00:36:46', 1, 'eliminación', 'Francis ha eliminado al elemento id 19 en el módulo empresas'),
(35, '2024-03-25 00:37:36', 1, 'inserción', 'Francis ha insertado un nuevo elemento con el nombre inyectadora de auditoría en el módulo insumos'),
(36, '2024-03-25 00:37:49', 1, 'eliminación', 'Francis ha eliminado al elemento id 25 en el módulo insumos'),
(37, '2024-03-25 00:38:22', 1, 'inserción', 'Francis ha insertado un nuevo elemento con el nombre Proveedor de auditoría en el módulo proveedores'),
(38, '2024-03-25 00:38:34', 1, 'eliminación', 'Francis ha eliminado al elemento id 25 en el módulo proveedores'),
(39, '2024-03-25 00:42:49', 1, 'inserción', 'Francis ha insertado un nuevo elemento con el nombre  en el módulo antecedente médico'),
(40, '2024-03-25 00:48:25', 1, 'inserción', 'El usuario Francis insertó la orden de compra con id 15'),
(41, '2024-03-25 00:49:57', 1, 'inserción', 'El usuario Francis insertó la orden de compra con id 16'),
(42, '2024-03-25 00:51:55', 1, 'inserción', 'El usuario Francis insertó la orden de compra con id 17'),
(43, '2024-03-25 00:52:55', 1, 'inserción', 'El usuario Francis insertó la orden de compra con id 000000018'),
(44, '2024-03-25 00:53:13', 1, 'actualización', 'El usuario Francis cambio a cancelada la orden de compra con id 10'),
(45, '2024-03-25 00:54:16', 1, 'actualización', 'El usuario Francis cambio a cancelada la orden de compra con id 000000015'),
(46, '2024-03-25 00:55:43', 1, 'inserción', 'El usuario Francis ha insertado las ordenes de seguross del mes de March'),
(47, '2024-03-25 00:56:33', 1, 'inserción', 'El usuario Francis ha insertado las ordenes de seguross del mes de March'),
(48, '2024-03-25 00:57:19', 1, 'inserción', 'El usuario Francis ha insertado las ordenes de seguross del mes de marzo'),
(49, '2024-03-25 00:58:37', 1, 'inserción', 'El usuario Francis insertó la orden de consulta con id 000000001'),
(50, '2024-03-25 01:05:41', 1, 'inserción', 'El usuario Francis insertó la orden de médico con id 000000001'),
(51, '2024-04-05 02:12:53', 0, 'inserción', ' ha insertado un nuevo elemento Oriana en el módulo usuarios'),
(52, '2024-04-05 03:26:21', 1, 'inserción', 'Francis ha insertado un nuevo elemento  en el módulo medicamentos'),
(53, '2024-04-05 03:26:29', 1, 'inserción', 'Francis ha insertado un nuevo elemento  en el módulo medicamentos'),
(54, '2024-04-05 03:27:36', 1, 'inserción', 'El usuario Francis insertó un nuevo medicamento de tipo 1 llamado medicamento de prueba'),
(55, '2024-04-05 03:42:57', 1, 'actualización', 'Francis ha actualizado al elemento id 2 los campos nombre en el módulo exámenes'),
(56, '2024-04-20 23:33:06', 1, 'inserción', 'Francis ha insertado un nuevo elemento  en el módulo antecedente médico'),
(57, '2024-04-20 23:35:54', 1, 'inserción', 'El usuario Francis insertó un nuevo antecedente médico de tipo 2 al paciente Ana Maríca con cédula 24567567'),
(58, '2024-04-25 03:24:12', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Juan Martínez Pérez'),
(59, '2024-04-25 03:24:47', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Miguel Cervanos'),
(60, '2024-04-25 03:25:27', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Carolina Hernández'),
(61, '2024-04-25 03:50:06', 1, 'inserción', 'Francis ha insertado un nuevo elemento Insumo de prueba en el módulo insumos'),
(62, '2024-04-27 03:22:40', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 23454321'),
(63, '2024-04-27 04:52:31', 1, 'inserción', 'Francis ha insertado un nuevo elemento Gaza en el módulo insumos'),
(64, '2024-04-27 05:13:29', 1, 'inserción', 'Francis ha insertado un nuevo elemento Alcohol en el módulo insumos'),
(65, '2024-04-27 05:25:56', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 15849652'),
(66, '2024-04-27 05:28:04', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 15849652'),
(67, '2024-04-27 21:22:32', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 21345543'),
(68, '2024-04-28 00:59:38', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 22345321'),
(69, '2024-04-28 01:05:34', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(70, '2024-04-28 01:22:27', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(71, '2024-04-28 01:53:50', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(72, '2024-04-28 03:48:08', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(73, '2024-04-28 03:51:49', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(74, '2024-04-28 03:52:35', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(75, '2024-04-28 03:53:05', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(76, '2024-04-28 03:53:40', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(77, '2024-04-28 03:54:01', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(78, '2024-04-28 03:55:15', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12343211'),
(79, '2024-04-28 04:06:04', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Delia Milagros Olivares'),
(80, '2024-04-28 04:23:18', 1, 'inserción', 'El usuario Francis ha insertado las ordenes de compras del mes de April'),
(81, '2024-04-29 02:37:16', 1, 'inserción', 'El usuario Francis ha insertado las ordenes de compras del mes de April'),
(82, '2024-04-29 02:38:24', 1, 'inserción', 'El usuario Francis ha insertado las ordenes de compras del mes de April'),
(83, '2024-04-30 02:58:41', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 88887777'),
(84, '2024-04-30 03:13:04', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 88887777'),
(85, '2024-04-30 03:43:30', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(86, '2024-04-30 03:45:47', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(87, '2024-04-30 03:47:37', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(88, '2024-04-30 03:49:24', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(89, '2024-04-30 03:52:53', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(90, '2024-05-01 18:13:59', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(91, '2024-05-01 18:14:59', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(92, '2024-05-01 18:17:40', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 21224242'),
(93, '2024-05-02 03:23:03', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Juan Martínez Pérez'),
(94, '2024-05-02 03:23:47', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Juan Martínez Pérez'),
(95, '2024-05-02 03:24:25', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Juan Martínez Pérez'),
(96, '2024-05-02 04:39:37', 1, 'inserción', 'Francis ha insertado un nuevo elemento Examen de prueba en el módulo exámenes'),
(97, '2024-05-02 04:40:09', 1, 'inserción', 'Francis ha insertado un nuevo elemento Examen de prueba 2 en el módulo exámenes'),
(98, '2024-05-02 04:48:46', 1, 'actualización', 'Francis ha actualizado al elemento id 40 los campos nombre en el módulo exámenes'),
(99, '2024-05-02 04:49:22', 1, 'actualización', 'Francis ha actualizado al elemento id 40 los campos nombre en el módulo exámenes'),
(100, '2024-05-02 04:50:03', 1, 'actualización', 'Francis ha actualizado al elemento id 40 los campos nombre en el módulo exámenes'),
(101, '2024-05-02 04:50:25', 1, 'actualización', 'Francis ha actualizado al elemento id 40 los campos nombre en el módulo exámenes'),
(102, '2024-05-02 04:52:46', 1, 'inserción', 'Francis ha insertado un nuevo elemento Examen de prueba 3 en el módulo exámenes'),
(103, '2024-05-02 04:53:03', 1, 'actualización', 'Francis ha actualizado al elemento id 40 los campos nombre en el módulo exámenes'),
(104, '2024-05-02 04:55:12', 1, 'eliminación', 'Francis ha eliminado al elemento id 1 en el módulo exámenes'),
(105, '2024-05-03 03:36:20', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Alicia Rodriguez'),
(106, '2024-05-03 03:54:23', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Juan Miguel López'),
(107, '2024-05-03 04:02:42', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Eva Martinez'),
(108, '2024-05-03 04:38:46', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Eva Martinez'),
(109, '2024-05-05 03:16:02', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Sara Ramirez'),
(110, '2024-05-05 03:16:45', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 68 del paciente Sara Ramirez'),
(111, '2024-05-05 03:18:56', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 19876544'),
(112, '2024-05-05 15:54:32', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 23454321'),
(113, '2024-05-05 16:43:26', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 68 del paciente Sara Ramirez'),
(114, '2024-05-06 04:19:06', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 23454321'),
(115, '2024-05-10 03:36:21', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Ana Maríca Gonzalez Perasa'),
(116, '2024-05-10 03:57:00', 1, 'inserción', 'El usuario Francis reprogramó la cita_id 70 del paciente Ana Maríca Gonzalez Perasa a la fecha 2024-05-16'),
(117, '2024-05-10 04:09:54', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 44443333'),
(118, '2024-05-10 04:43:26', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 44443333'),
(119, '2024-05-11 02:53:46', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Juan Martínez Pérez'),
(120, '2024-05-11 02:58:37', 1, 'actualización', 'Francis ha actualizado al elemento id 8 los campos especialidades[] en el módulo exámenes'),
(121, '2024-05-11 02:58:56', 1, 'actualización', 'Francis ha actualizado al elemento id 6 los campos especialidades[] en el módulo exámenes'),
(122, '2024-05-11 02:59:21', 1, 'actualización', 'Francis ha actualizado al elemento id 3 los campos especialidades[] en el módulo exámenes'),
(123, '2024-05-11 03:00:01', 1, 'actualización', 'Francis ha actualizado al elemento id 4 los campos especialidades[] en el módulo exámenes'),
(124, '2024-05-11 03:01:42', 1, 'actualización', 'Francis ha actualizado al elemento id 4 los campos especialidades[] en el módulo exámenes'),
(125, '2024-05-11 03:02:04', 1, 'actualización', 'Francis ha actualizado al elemento id 10 los campos especialidades[] en el módulo exámenes'),
(126, '2024-05-11 03:02:12', 1, 'actualización', 'Francis ha actualizado al elemento id 11 los campos especialidades[] en el módulo exámenes'),
(127, '2024-05-11 03:02:37', 1, 'actualización', 'Francis ha actualizado al elemento id 12 los campos especialidades[] en el módulo exámenes'),
(128, '2024-05-11 03:02:57', 1, 'actualización', 'Francis ha actualizado al elemento id 13 los campos especialidades[] en el módulo exámenes'),
(129, '2024-05-11 03:03:18', 1, 'actualización', 'Francis ha actualizado al elemento id 14 los campos especialidades[] en el módulo exámenes'),
(130, '2024-05-11 03:03:27', 1, 'actualización', 'Francis ha actualizado al elemento id 18 los campos especialidades[] en el módulo exámenes'),
(131, '2024-05-11 03:03:32', 1, 'actualización', 'Francis ha actualizado al elemento id 17 los campos especialidades[] en el módulo exámenes'),
(132, '2024-05-11 03:03:36', 1, 'actualización', 'Francis ha actualizado al elemento id 15 los campos especialidades[] en el módulo exámenes'),
(133, '2024-05-11 03:11:48', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Maria Gonzalez'),
(134, '2024-05-11 03:18:53', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Gabriel Gutierrez'),
(135, '2024-05-11 03:20:38', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 12345678'),
(136, '2024-05-11 03:22:36', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 74 del paciente Gabriel Gutierrez'),
(137, '2024-05-11 03:28:25', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 11113333'),
(138, '2024-05-12 04:58:20', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Carolina Hernández'),
(139, '2024-05-12 05:04:00', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 98761234'),
(140, '2024-05-12 05:37:31', 1, 'inserción', 'El usuario Francis insertó cita normal para el paciente Carolina Hernández'),
(141, '2024-05-12 05:37:53', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 98761234'),
(142, '2024-05-12 05:45:45', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Juan Miguel López'),
(143, '2024-05-12 05:47:53', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 77 del paciente Juan Miguel López'),
(144, '2024-05-12 05:48:33', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 21224242'),
(145, '2024-05-12 19:56:21', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Sarah López'),
(146, '2024-05-12 20:02:11', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 78 del paciente Sarah López'),
(147, '2024-05-12 20:19:04', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 1985743'),
(148, '2024-05-12 21:13:41', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 1985743'),
(149, '2024-05-12 21:46:26', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 1985743'),
(150, '2024-05-12 23:11:09', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 20345345'),
(151, '2024-05-13 00:12:58', 1, 'inserción', 'El usuario Francis insertó la consulta natural del paciente con cédula 30234234'),
(152, '2024-05-13 00:43:02', 1, 'inserción', 'Francis ha insertado un nuevo elemento Medico de prueba en el módulo médicos'),
(153, '2024-05-13 01:34:48', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Jordan Perez'),
(154, '2024-05-13 01:45:20', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 79 del paciente Jordan Perez'),
(155, '2024-05-13 01:47:10', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 23454321'),
(156, '2024-05-19 00:50:15', 1, 'inserción', 'El usuario Francis insertó cita asegurada para el paciente Roberto Perez'),
(157, '2024-05-19 00:51:23', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 80 del paciente Roberto Perez'),
(158, '2024-05-19 00:55:10', 1, 'actualización', 'El usuario Francis insertó la clave de la cita_id 80 del paciente Roberto Perez'),
(159, '2024-05-19 01:10:35', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 55555555'),
(160, '2024-05-19 19:53:05', 1, 'actualización', 'Francis ha actualizado al elemento id 1 los campos costo_especialidad en el módulo médicos'),
(161, '2024-05-19 19:53:34', 1, 'actualización', 'Francis ha actualizado al elemento id 1 los campos costo_especialidad en el módulo médicos'),
(162, '2024-05-25 21:09:23', 1, 'actualización', 'Francis ha actualizado al elemento id 15 los campos costo-especialidad en el módulo médicos'),
(163, '2024-05-25 21:09:34', 1, 'eliminación', 'Francis ha eliminado al elemento id 39 en el módulo médicos'),
(164, '2024-05-25 21:21:55', 1, 'actualización', 'Francis ha actualizado al elemento id 2 los campos especialidades[] en el módulo exámenes'),
(165, '2024-05-25 21:28:45', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 65432198'),
(166, '2024-05-26 02:50:07', 1, 'inserción', 'El usuario Francis insertó la consulta asegurada del paciente con cédula 11113333'),
(167, '2024-05-26 04:06:33', 1, 'inserción', 'El usuario Francis insertó la consulta por emergencia del paciente con cédula 11113333'),
(168, '2024-05-26 20:02:51', 1, 'inserción', 'Francis ha insertado un nuevo elemento Recuento de glóbulos blancos en el módulo exámenes');

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
  `monto_aprobado` float NOT NULL,
  `tipo_cita` enum('1','2') NOT NULL,
  `tipo_servicio` enum('1','2') DEFAULT '1',
  `estatus_cit` enum('1','2','3','4',' 5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`cita_id`, `paciente_id`, `medico_id`, `especialidad_id`, `fecha_cita`, `hora_salida`, `hora_entrada`, `motivo_cita`, `cedula_titular`, `monto_aprobado`, `tipo_cita`, `tipo_servicio`, `estatus_cit`) VALUES
(2, 2, 5, 21, '2023-12-14', '10:00:00', '09:00:00', 'Dolor de cabeza', 21345543, 0, '1', '1', '4'),
(3, 59, 7, 13, '2023-12-20', '10:00:00', '09:00:00', 'Recomendado por especialista', 32109876, 0, '2', '1', '4'),
(4, 3, 5, 21, '2023-12-14', '11:00:00', '10:30:00', 'Posible cáncer de mamas', 12343211, 0, '1', '1', '4'),
(5, 4, 5, 21, '2023-12-14', '11:45:00', '11:01:00', 'Despistaje de cáncer de próstata', 13456736, 0, '1', '1', '4'),
(6, 61, 29, 51, '2023-12-14', '11:45:00', '11:00:00', 'Recomendado por traumátologo', 19876544, 0, '2', '1', '3'),
(7, 65, 7, 13, '2023-12-20', '08:45:00', '08:00:00', 'Control', 56789013, 0, '2', '1', '4'),
(8, 27, 5, 21, '2023-12-23', '11:00:00', '10:30:00', 'Despistaje', 22345321, 0, '2', '1', '4'),
(9, 77, 10, 17, '2023-12-23', '09:30:00', '09:00:00', 'Vómitos intensos', 32109879, 0, '2', '1', '4'),
(10, 83, 4, 9, '2023-12-29', '13:00:00', '12:00:00', 'Procesos hormonales anormales', 22345321, 0, '2', '1', '4'),
(11, 73, 7, 13, '2023-12-25', '15:15:00', '14:00:00', 'Alergia recurrente', 32109878, 0, '2', '1', '4'),
(12, 4, 6, 11, '2023-12-26', '11:15:00', '10:00:00', 'Control', 13456736, 0, '1', '1', '4'),
(13, 10, 25, 45, '2023-12-26', '13:30:00', '12:15:00', 'Dolor pélvico', 12345678, 0, '1', '1', '4'),
(14, 50, 4, 9, '2023-12-27', '12:00:00', '11:30:00', 'control', 28561234, 0, '2', '1', '4'),
(15, 78, 3, 1, '2023-12-26', '18:10:00', '17:10:00', 'Dolor de espaldo', 76543202, 0, '2', '1', '4'),
(16, 84, 6, 12, '2023-12-28', '12:15:00', '11:20:00', 'Mareos', 1985743, 0, '2', '1', '4'),
(17, 24, 7, 13, '2023-12-27', '09:45:00', '09:00:00', 'Aparente infección de estafilococos', 22345321, 0, '2', '1', '4'),
(18, 3, 5, 22, '2024-01-02', '11:00:00', '10:00:00', 'Referido por médico general', 12343211, 0, '1', '1', '4'),
(19, 85, 27, 48, '2024-01-11', '11:45:00', '11:15:00', 'Problemas del Habla', 12343211, 0, '1', '1', '4'),
(20, 10, 25, 45, '2024-01-11', '15:00:00', '14:00:00', 'Citología', 12345678, 0, '1', '1', '4'),
(21, 37, 23, 41, '2024-01-06', '11:45:00', '11:00:00', 'Eco Glandular', 44443333, 0, '2', '1', '4'),
(22, 60, 38, 53, '2024-01-16', '13:00:00', '12:00:00', 'control', 28561235, 0, '2', '1', '4'),
(46, 1, 1, 2, '2024-03-27', '08:45:00', '08:40:00', 'Dolor de cabeza', 24567567, 0, '1', '1', ' 5'),
(50, 1, 1, 2, '2024-03-30', '15:44:40', '14:44:48', 'Dolor de cabeza', 24567567, 0, '1', '1', '1'),
(51, 24, 7, 13, '2024-04-01', '15:30:00', '15:00:00', 'Dolor de cabeza', 22345321, 0, '2', '1', '4'),
(52, 5, 4, 9, '2024-04-05', '11:11:00', '11:00:00', 'Dolor de cabeza test', 19765765, 0, '1', '1', '1'),
(53, 2, 3, 1, '2024-04-24', '11:47:00', '11:24:00', 'Dolor de oído', 21345543, 0, '1', '1', '4'),
(54, 5, 3, 6, '2024-04-24', '08:36:00', '08:00:00', 'Dolor de nariz', 19765765, 0, '1', '1', '1'),
(55, 14, 11, 20, '2024-04-24', '11:30:00', '11:25:00', 'Malestar', 98761234, 0, '1', '1', '1'),
(56, 3, 3, 3, '2024-05-01', '18:05:00', '17:05:00', 'dolor test', 12343211, 0, '1', '1', '1'),
(59, 2, 3, 3, '2024-05-01', '08:30:00', '08:18:00', 'dolor', 21345543, 0, '1', '1', '1'),
(61, 2, 3, 3, '2024-05-01', '08:45:00', '08:31:00', 'dolor', 21345543, 0, '1', '1', '1'),
(62, 1, 3, 3, '2024-05-15', '08:40:00', '07:10:00', 'control', 24567567, 0, '1', '1', '1'),
(63, 21, 3, 1, '2024-05-15', '09:15:00', '08:45:00', 'control', 15956458, 0, '1', '1', '1'),
(64, 33, 1, 2, '2024-05-15', '09:00:00', '08:30:00', 'control', 21224242, 0, '2', '1', '3'),
(67, 81, 3, 6, '2024-05-15', '09:50:00', '09:20:00', 'control', 10987659, 0, '2', '1', '3'),
(68, 61, 3, 6, '2024-05-13', '12:50:00', '11:20:00', 'test', 19876544, 10, '2', '1', '1'),
(69, 1, 5, 21, '2024-05-16', '09:30:00', '09:00:00', 'testeando reprogramación', 24567567, 0, '1', '1', ' 5'),
(70, 1, 5, 21, '2024-05-23', '09:30:00', '09:00:00', 'testeando reprogramación', 24567567, 0, '1', '1', ' 5'),
(71, 1, 5, 21, '2024-05-16', '10:05:00', '09:35:00', 'testeando reprogramación', 24567567, 0, '1', '1', '1'),
(73, 10, 3, 1, '2024-05-29', '07:40:00', '07:10:00', 'testeando get de facturas', 12345678, 0, '1', '1', '4'),
(74, 43, 3, 1, '2024-05-29', '08:15:00', '07:45:00', 'testeando el get facturas s', 11113333, 15, '2', '1', '4'),
(75, 14, 3, 1, '2024-05-22', '07:40:00', '07:10:00', 'testeando consulta tipo servicio uno', 98761234, 0, '1', '1', '1'),
(76, 14, 3, 1, '2024-05-24', '00:05:00', '00:00:00', 'testeando los arreglos', 98761234, 0, '1', '1', '4'),
(77, 33, 3, 1, '2024-05-24', '00:40:00', '00:10:00', 'testeando solo examenes', 21224242, 30, '2', '1', '4'),
(78, 31, 9, 16, '2024-05-16', '09:20:00', '09:00:00', 'test cita tipo 2 con consulta', 1985743, 46, '2', '2', '4'),
(79, 30, 4, 10, '2024-05-24', '11:30:00', '11:00:00', 'Control', 23454321, 10, '2', '1', '4'),
(80, 35, 3, 1, '2024-05-24', '11:30:00', '11:00:00', 'testeando factura 2', 55555555, 20, '2', '2', '4'),
(81, 54, 15, 56, '2024-05-30', '09:30:00', '09:00:00', 'control', 65432198, 20, '2', '2', '4'),
(82, 43, 4, 10, '2024-05-31', '11:30:00', '11:00:00', 'test 1', 11113333, 28, '2', '2', '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_examen`
--

CREATE TABLE `cita_examen` (
  `cita_examen_id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `precio_examen_bs` float NOT NULL,
  `precio_examen_usd` float NOT NULL,
  `cubierto_por` enum('1','2','3') NOT NULL DEFAULT '1',
  `monto_cubierto_usd` float NOT NULL DEFAULT 0,
  `monto_cubierto_bs` float NOT NULL DEFAULT 0,
  `estatus_cit` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita_examen`
--

INSERT INTO `cita_examen` (`cita_examen_id`, `cita_id`, `examen_id`, `precio_examen_bs`, `precio_examen_usd`, `cubierto_por`, `monto_cubierto_usd`, `monto_cubierto_bs`, `estatus_cit`) VALUES
(1, 59, 1, 0, 0, '1', 0, 0, '1'),
(2, 59, 2, 0, 15, '3', 0, 0, '1'),
(3, 63, 1, 0, 21, '3', 0, 0, '1'),
(4, 63, 2, 0, 15, '1', 0, 0, '1'),
(5, 64, 2, 0, 20, '1', 0, 0, '1'),
(6, 64, 8, 0, 30, '1', 0, 0, '1'),
(7, 64, 6, 0, 15, '1', 0, 0, '1'),
(10, 67, 2, 0, 15, '1', 0, 0, '1'),
(11, 67, 6, 0, 25, '1', 0, 0, '1'),
(12, 68, 2, 0, 15, '1', 0, 0, '1'),
(13, 68, 6, 0, 23, '1', 0, 0, '1'),
(14, 73, 17, 0, 20, '1', 0, 0, '1'),
(15, 74, 15, 0, 27, '1', 0, 0, '1'),
(16, 75, 17, 0, 20, '1', 0, 0, '1'),
(17, 76, 17, 651.8, 20, '1', 0, 0, '1'),
(18, 77, 17, 912.52, 28, '1', 0, 0, '1'),
(19, 78, 1, 0, 30, '1', 0, 0, '1'),
(20, 79, 3, 0, 30, '1', 0, 0, '1'),
(21, 80, 3, 814.75, 25, '3', 17, 554.03, '1'),
(22, 81, 2, 782.16, 24, '1', 0, 0, '1'),
(23, 82, 3, 0, 30, '3', 2, 65.18, '1');

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
-- Volcado de datos para la tabla `cita_seguro`
--

INSERT INTO `cita_seguro` (`cita_seguro_id`, `cita_id`, `seguro_id`, `clave`) VALUES
(1, 3, 2, '5436463'),
(2, 6, 12, NULL),
(3, 7, 12, '232342'),
(4, 8, 3, '7689497'),
(5, 9, 2, '7678687'),
(6, 10, 3, '12414745753'),
(7, 11, 2, '878452'),
(8, 14, 2, '7855668'),
(9, 15, 2, '01920'),
(10, 16, 1, '12487652'),
(11, 17, 3, '2353453'),
(12, 21, 1, '21387648'),
(13, 22, 12, '235245'),
(14, 51, 3, 'sdawa3'),
(15, 64, 1, NULL),
(17, 67, 10, NULL),
(18, 68, 12, 'gdfg5454'),
(19, 74, 3, '5h4h5jkh'),
(20, 77, 1, 'jkhj5kh345'),
(21, 78, 1, 'sdawa3'),
(22, 79, 2, 'hjg53'),
(23, 80, 1, 'shsgfh5'),
(24, 81, 2, 'hgfh5h'),
(25, 82, 3, 'clave1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_insumo`
--

CREATE TABLE `compra_insumo` (
  `compra_insumo_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `factura_compra_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_unit_bs` float NOT NULL,
  `precio_total_bs` float NOT NULL,
  `precio_unit_usd` float NOT NULL,
  `precio_total_usd` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra_insumo`
--

INSERT INTO `compra_insumo` (`compra_insumo_id`, `insumo_id`, `factura_compra_id`, `unidades`, `precio_unit_bs`, `precio_total_bs`, `precio_unit_usd`, `precio_total_usd`) VALUES
(000000001, 1, 000000001, 2, 15, 34.8, 0.46, 1.07),
(000000002, 5, 000000001, 7, 5, 40.6, 0.15, 1.25),
(000000003, 7, 000000001, 2, 2, 3.71, 0.06, 0.11),
(000000004, 8, 000000001, 13, 0.5, 6.5, 0.02, 0.2),
(000000005, 4, 000000001, 6, 5, 30, 0.15, 0.92),
(000000006, 1, 000000002, 7, 0.3, 2.1, 0.01, 0.06),
(000000007, 7, 000000003, 2, 2.4, 4.8, 0.07, 0.15),
(000000008, 7, 000000004, 2, 2.4, 4.8, 0.07, 0.15),
(000000009, 4, 000000005, 1, 2, 2, 0.06, 0.06),
(000000010, 4, 000000006, 1, 2, 2, 0.06, 0.06),
(000000011, 4, 000000007, 1, 2, 2, 0.06, 0.06),
(000000012, 4, 000000008, 1, 2, 2, 0.06, 0.06),
(000000013, 4, 000000009, 1, 2, 2, 0.06, 0.06),
(000000014, 4, 000000010, 1, 2, 2, 0.06, 0.06),
(000000015, 4, 000000011, 10, 1.5, 15, 0.05, 0.46),
(000000016, 5, 000000012, 4, 2, 8, 0.06, 0.25),
(000000017, 9, 000000012, 13, 3, 39, 0.09, 1.2),
(000000018, 5, 000000013, 4, 2, 8, 0.06, 0.25),
(000000019, 9, 000000013, 13, 3, 39, 0.09, 1.2),
(000000020, 5, 000000014, 4, 2, 8, 0.06, 0.25),
(000000021, 9, 000000014, 13, 3, 39, 0.09, 1.2),
(000000022, 5, 000000015, 4, 2, 8, 0.06, 0.25),
(000000023, 9, 000000015, 13, 3, 39, 0.09, 1.2),
(000000024, 4, 000000016, 1, 1, 1, 0.03, 0.03),
(000000025, 4, 000000017, 1, 1, 1, 0.03, 0.03),
(000000026, 4, 000000018, 1, 1, 1, 0.03, 0.03),
(000000027, 26, 000000019, 5, 5, 25, 0.15, 0.77),
(000000028, 1, 000000020, 2, 40, 80, 1, 2),
(000000029, 1, 000000021, 2, 40, 80, 1, 2),
(000000030, 1, 000000022, 2, 40, 80, 1, 2),
(000000031, 1, 000000023, 2, 40, 80, 1, 2),
(000000032, 1, 000000024, 4, 40, 80, 1, 2),
(000000033, 1, 000000025, 4, 40, 80, 1, 2),
(000000034, 1, 000000026, 4, 40, 80, 1, 2),
(000000035, 28, 000000027, 4, 40, 160, 1, 4),
(000000036, 28, 000000028, 3, 3, 10.44, 0.08, 0.26),
(000000037, 27, 000000028, 2, 0.5, 1.16, 0.01, 0.03),
(000000038, 28, 000000029, 3, 3, 10.44, 0.08, 0.26),
(000000039, 27, 000000029, 2, 0.5, 1.16, 0.01, 0.03),
(000000040, 28, 000000030, 3, 3, 10.44, 0.08, 0.26),
(000000041, 27, 000000030, 2, 0.5, 1.16, 0.01, 0.03),
(000000042, 28, 000000031, 3, 3, 10.44, 0.08, 0.26),
(000000043, 27, 000000031, 2, 0.5, 1.16, 0.01, 0.03),
(000000044, 28, 000000032, 3, 3, 10.44, 0.08, 0.26),
(000000045, 27, 000000032, 2, 0.5, 1.16, 0.01, 0.03),
(000000046, 28, 000000033, 3, 5, 10.44, 0.13, 0.26),
(000000047, 27, 000000033, 2, 5, 1.16, 0.13, 0.03),
(000000048, 28, 000000034, 3, 5, 10.44, 0.13, 0.26),
(000000049, 27, 000000034, 2, 5, 1.16, 0.13, 0.03),
(000000050, 28, 000000035, 3, 5, 10.44, 0.13, 0.26),
(000000051, 27, 000000035, 2, 5, 1.16, 0.13, 0.03),
(000000052, 28, 000000036, 3, 5, 10.44, 0.13, 0.26),
(000000053, 27, 000000036, 2, 5, 1.16, 0.13, 0.03),
(000000054, 28, 000000037, 3, 5, 10.44, 0.13, 0.26),
(000000055, 27, 000000037, 2, 5, 1.16, 0.13, 0.03),
(000000056, 28, 000000038, 3, 5, 10.44, 0.13, 0.26),
(000000057, 27, 000000038, 2, 10, 1.16, 0.25, 0.03),
(000000058, 28, 000000039, 3, 40, 10.44, 1, 0.26),
(000000059, 27, 000000039, 2, 84, 1.16, 2.1, 0.03),
(000000060, 28, 000000040, 3, 40, 10.44, 1, 0.26),
(000000061, 27, 000000040, 2, 84, 1.16, 2.1, 0.03),
(000000062, 28, 000000041, 3, 1, 10.44, 0.03, 0.26),
(000000063, 27, 000000041, 2, 1, 1.16, 0.03, 0.03);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `consulta_id` int(11) NOT NULL,
  `peso` float DEFAULT NULL,
  `altura` float DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `fecha_consulta` date NOT NULL,
  `es_emergencia` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_servicio` enum('1','2') NOT NULL DEFAULT '1',
  `estatus_con` enum('1','2','3','4') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`consulta_id`, `peso`, `altura`, `observaciones`, `fecha_consulta`, `es_emergencia`, `tipo_servicio`, `estatus_con`) VALUES
(110, 87, 1.9, 'Sin rastros evidentes de un posible cáncer', '2023-12-14', 0, '1', '3'),
(111, 60, 1.78, 'Pequeña tumoración', '2023-12-20', 0, '1', '3'),
(114, 56, 1.62, 'Enrojecimiento en los pezones', '2023-12-14', 0, '1', '1'),
(115, 78, 1.8, 'Sin señales alarmantes', '2023-12-14', 0, '1', '1'),
(116, 56, 1.56, 'Rastros de mucosidad en las vías paranasales', '2023-12-20', 0, '1', '1'),
(117, 45, 1.63, 'Probable indigestión por comida callejera', '2023-12-23', 0, '1', '1'),
(118, 67, 1.56, NULL, '2023-12-23', 0, '1', '3'),
(119, 54, 1.76, 'Alergia normal, tal vez estacionaria', '2023-12-25', 0, '1', '1'),
(120, 60, 1.75, 'Desviación mínima, posible escoliosis', '2023-12-26', 0, '1', '1'),
(121, 45, 1.65, 'Poca masa muscular', '2023-12-26', 0, '1', '1'),
(122, 65, 1.65, 'Posible insuficiencia renal', '2023-12-26', 0, '1', '1'),
(123, 56, 1.54, 'Protuberancias en la pierna izquierda', '2023-12-27', 0, '1', '1'),
(124, 45, 1.54, NULL, '2023-12-27', 0, '1', '1'),
(125, 56, 1.65, 'Disminución significativa de los glóbulos rojos', '2023-12-28', 0, '1', '1'),
(126, 60, 1.8, 'Alteración en las glándulas tiroideas', '2023-12-29', 0, '1', '1'),
(127, 56, 1.7, NULL, '2024-01-06', 0, '1', '1'),
(128, 50, 1.58, NULL, '2024-01-02', 0, '1', '1'),
(129, 60, 1.65, 'Operación realizada exitosamente', '2023-12-29', 0, '1', '3'),
(130, 56, 1.62, 'Mareos repentinos', '2024-01-14', 0, '1', '1'),
(131, 60, 1.65, 'Control rutinario', '2024-01-08', 0, '1', '1'),
(133, 67, 1.67, 'Normal', '2024-01-11', 0, '1', '1'),
(134, 54, 1.73, 'Sin rastros de nada grave ', '2024-01-16', 0, '1', '1'),
(141, 54, 1.65, NULL, '2024-01-03', 1, '1', '1'),
(142, 78, 1.8, NULL, '2024-01-04', 1, '1', '3'),
(146, 56, 1.68, 'dolor de cabeza', '2024-03-21', 0, '1', '1'),
(147, 65, 1.45, 'testeando cita asegurada', '2024-03-21', 0, '1', '1'),
(149, NULL, NULL, 'testeando para consutla por emergencia', '2024-03-21', 1, '1', '1'),
(150, 75, 1.45, NULL, '2024-03-25', 0, '1', '1'),
(151, NULL, NULL, NULL, '2024-04-27', 1, '1', '1'),
(154, NULL, NULL, NULL, '2024-05-01', 1, '1', '1'),
(155, NULL, NULL, NULL, '2024-05-01', 1, '1', '1'),
(156, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(158, 54, 1.7, NULL, '2024-04-27', 1, '1', '1'),
(159, NULL, NULL, NULL, '2024-04-27', 1, '1', '1'),
(160, NULL, NULL, NULL, '2024-04-27', 1, '1', '1'),
(161, NULL, NULL, NULL, '2024-04-27', 1, '1', '1'),
(162, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(163, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(164, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(165, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(166, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(167, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(168, NULL, NULL, NULL, '2024-04-27', 0, '1', '1'),
(169, NULL, NULL, NULL, '2024-04-29', 1, '1', '1'),
(170, NULL, NULL, NULL, '2024-04-29', 1, '1', '1'),
(173, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(174, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(175, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(176, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(177, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(178, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(179, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(180, NULL, NULL, NULL, '2024-04-30', 1, '1', '1'),
(181, 54, 1.54, 'test test', '2024-05-04', 0, '1', '4'),
(182, NULL, NULL, NULL, '2024-05-05', 1, '1', '1'),
(183, NULL, NULL, NULL, '2024-05-06', 1, '1', '3'),
(184, NULL, NULL, NULL, '2024-05-10', 1, '1', '1'),
(185, NULL, NULL, NULL, '2024-05-10', 1, '1', '1'),
(186, 54, 1.64, 'Estoy testeando el get de facturas', '2024-05-29', 0, '1', '3'),
(187, 78, 1.85, 'testaendo el de seguros entonces', '2024-05-29', 0, '1', '3'),
(189, NULL, NULL, NULL, '2024-05-24', 0, '1', '3'),
(190, NULL, NULL, 'testando cita aseu', '2024-05-24', 0, '1', '3'),
(193, 54, 1.75, 'testeando tipo cita 2 y consulta', '2024-05-12', 0, '2', '3'),
(194, 58, 1.68, 'Control de traumatología', '2024-05-12', 0, '2', '3'),
(195, NULL, NULL, NULL, '2024-05-12', 0, '1', '3'),
(196, 58, 1.58, 'control 2', '2024-05-24', 0, '1', '3'),
(197, 54, 1.75, 'testeando factura 2', '2024-05-23', 0, '2', '3'),
(198, 54, 1.54, 'Control perfecto', '2024-05-30', 0, '2', '3'),
(199, 75, 1.65, 'test 1', '2024-05-31', 0, '2', '4'),
(200, 46, 1.58, 'test 2', '2024-05-25', 1, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_cita`
--

CREATE TABLE `consulta_cita` (
  `consulta_cita_id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_cita`
--

INSERT INTO `consulta_cita` (`consulta_cita_id`, `cita_id`, `consulta_id`, `estatus_con`) VALUES
(30, 2, 110, '1'),
(31, 3, 111, '1'),
(35, 4, 114, '1'),
(36, 5, 115, '1'),
(37, 7, 116, '1'),
(38, 9, 117, '1'),
(39, 8, 118, '1'),
(40, 11, 119, '1'),
(41, 15, 120, '1'),
(42, 12, 121, '1'),
(43, 13, 122, '1'),
(44, 17, 123, '1'),
(45, 14, 124, '1'),
(46, 16, 125, '1'),
(47, 10, 126, '1'),
(48, 21, 127, '1'),
(49, 18, 128, '1'),
(51, 19, 133, '1'),
(52, 22, 134, '1'),
(55, 51, 147, '1'),
(56, 20, 150, '1'),
(57, 53, 156, '1'),
(58, 68, 181, '1'),
(59, 73, 186, '1'),
(60, 74, 187, '1'),
(62, 76, 189, '1'),
(63, 77, 190, '1'),
(66, 78, 193, '1'),
(67, 79, 196, '1'),
(68, 80, 197, '1'),
(69, 81, 198, '1'),
(70, 82, 199, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_emergencia`
--

CREATE TABLE `consulta_emergencia` (
  `consulta_emergencia_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `cedula_beneficiado` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `clave_seguro` int(11) NOT NULL,
  `cantidad_consultas_medicas` int(11) NOT NULL DEFAULT 0,
  `consultas_medicas` float NOT NULL,
  `consultas_medicas_bs` float NOT NULL,
  `cantidad_laboratorios` int(11) NOT NULL DEFAULT 0,
  `laboratorios` float DEFAULT NULL,
  `laboratorios_bs` float NOT NULL,
  `cantidad_medicamentos` int(11) NOT NULL DEFAULT 0,
  `medicamentos` float DEFAULT NULL,
  `medicamentos_bs` float NOT NULL,
  `area_observacion` float DEFAULT NULL,
  `area_observacion_bs` float NOT NULL,
  `enfermeria` float DEFAULT NULL,
  `enfermeria_bs` float NOT NULL,
  `total_insumos` float NOT NULL,
  `total_insumos_bs` float NOT NULL,
  `total_examenes` float NOT NULL,
  `total_examenes_bs` float NOT NULL,
  `total_consulta` float NOT NULL,
  `total_consulta_bs` float NOT NULL,
  `monto_aprobado` float NOT NULL DEFAULT 0,
  `monto_cubierto_usd` float NOT NULL DEFAULT 0,
  `monto_cubierto_bs` float NOT NULL DEFAULT 0,
  `autorizacion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_emergencia`
--

INSERT INTO `consulta_emergencia` (`consulta_emergencia_id`, `consulta_id`, `paciente_id`, `cedula_beneficiado`, `seguro_id`, `clave_seguro`, `cantidad_consultas_medicas`, `consultas_medicas`, `consultas_medicas_bs`, `cantidad_laboratorios`, `laboratorios`, `laboratorios_bs`, `cantidad_medicamentos`, `medicamentos`, `medicamentos_bs`, `area_observacion`, `area_observacion_bs`, `enfermeria`, `enfermeria_bs`, `total_insumos`, `total_insumos_bs`, `total_examenes`, `total_examenes_bs`, `total_consulta`, `total_consulta_bs`, `monto_aprobado`, `monto_cubierto_usd`, `monto_cubierto_bs`, `autorizacion`) VALUES
(5, 141, 30, 23454321, 2, 0, 0, 20, 0, 0, 0, 0, 0, 10, 0, 15, 0, 18, 0, 25, 0, 15, 0, 63, 0, 0, 0, 0, ''),
(8, 149, 24, 15849652, 3, 0, 0, 200, 0, 0, 20, 0, 0, 100, 0, 0, 0, 20, 0, 0, 0, 0, 0, 340, 0, 0, 0, 0, ''),
(9, 151, 30, 23454321, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 0, 30, 0, 50, 0, 0, 0, 0, ''),
(10, 154, 24, 15849652, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
(11, 155, 24, 15849652, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
(12, 158, 24, 22345321, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 21, 0, 21, 0, 0, 0, 0, ''),
(13, 159, 33, 21224242, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 18, 0, 18, 0, 0, 0, 0, ''),
(14, 160, 33, 21224242, 1, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 18, 0, 28, 0, 0, 0, 0, ''),
(15, 161, 33, 21224242, 1, 0, 0, 10, 400, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 280, 18, 720, 35, 1400, 0, 0, 0, ''),
(16, 169, 40, 88887777, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, ''),
(17, 170, 40, 88887777, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0.14, 0, 0, 0, 1, 0, 0, 0, 0, ''),
(18, 173, 33, 21224242, 1, 0, 0, 0, 0, 2, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 71, 0, 71, 0, 0, 0, 0, ''),
(19, 174, 33, 21224242, 1, 0, 0, 0, 0, 2, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 71, 0, 71, 0, 0, 0, 0, ''),
(20, 175, 33, 21224242, 1, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 71, 0, 73, 0, 0, 0, 0, ''),
(21, 176, 33, 21224242, 1, 0, 0, 0, 0, 2, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 71, 0, 112, 0, 0, 0, 0, ''),
(22, 177, 33, 21224242, 1, 0, 0, 0, 0, 2, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 56, 0, 0, 0, 0, ''),
(23, 178, 33, 21224242, 1, 0, 0, 0, 0, 2, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 56, 0, 0, 0, 0, ''),
(24, 179, 33, 21224242, 1, 0, 0, 0, 0, 2, 41, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 15, 0, 56, 0, 0, 0, 0, ''),
(25, 180, 33, 21224242, 1, 0, 0, 0, 0, 2, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 56, 0, 0, 0, 0, ''),
(26, 182, 30, 23454321, 2, 0, 0, 0, 0, 0, 0, 0, 0, 6.75, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, ''),
(27, 183, 30, 23454321, 2, 0, 0, 15, 0, 1, 30, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 60, 0, 50, 0, 0, ''),
(28, 184, 37, 44443333, 1, 0, 0, 0, 0, 1, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 28, 0, 40, 0, 0, 0, 0, ''),
(31, 185, 37, 44443333, 1, 0, 0, 0, 0, 1, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 28, 0, 40, 0, 0, 0, 0, ''),
(32, 200, 43, 11113333, 3, 0, 0, 10, 0, 1, 25, 0, 0, 0, 0, 8, 0, 10, 0, 0, 0, 0, 0, 53, 0, 50, 0, 0, 'dfs32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_examen`
--

CREATE TABLE `consulta_examen` (
  `consulta_examen_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `precio_examen_bs` float NOT NULL,
  `precio_examen_usd` float NOT NULL,
  `cubierto_por` enum('1','2','3') NOT NULL DEFAULT '1',
  `monto_cubierto_usd` float NOT NULL DEFAULT 0,
  `monto_cubierto_bs` float NOT NULL DEFAULT 0,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_examen`
--

INSERT INTO `consulta_examen` (`consulta_examen_id`, `consulta_id`, `examen_id`, `precio_examen_bs`, `precio_examen_usd`, `cubierto_por`, `monto_cubierto_usd`, `monto_cubierto_bs`, `estatus_con`) VALUES
(17, 110, 1, 840, 21, '1', 0, 0, '1'),
(18, 111, 8, 488.85, 15, '1', 0, 0, '1'),
(19, 114, 38, 0, 45, '1', 0, 0, '1'),
(20, 115, 8, 0, 15, '1', 0, 0, '1'),
(21, 116, 1, 684.39, 21, '1', 0, 0, '1'),
(22, 117, 33, 651.8, 20, '1', 0, 0, '1'),
(23, 118, 10, 651.8, 20, '1', 0, 0, '1'),
(24, 120, 29, 977.7, 30, '1', 0, 0, '1'),
(25, 121, 26, 0, 28, '1', 0, 0, '1'),
(26, 122, 8, 0, 15, '1', 0, 0, '1'),
(27, 122, 34, 0, 22, '1', 0, 0, '1'),
(28, 125, 1, 684.39, 21, '1', 0, 0, '1'),
(29, 125, 2, 0, 20, '1', 0, 0, '1'),
(30, 126, 3, 977.7, 30, '1', 0, 0, '1'),
(31, 127, 8, 488.85, 15, '1', 0, 0, '1'),
(32, 128, 1, 0, 21, '1', 0, 0, '1'),
(33, 130, 1, 0, 21, '1', 0, 0, '1'),
(35, 133, 2, 0, 15, '1', 0, 0, '1'),
(36, 134, 8, 488.85, 15, '1', 0, 0, '1'),
(43, 141, 8, 488.85, 15, '1', 0, 0, '1'),
(44, 141, 8, 488.85, 15, '1', 0, 0, '1'),
(47, 150, 2, 0, 15, '1', 0, 0, '1'),
(48, 151, 29, 0, 30, '1', 0, 0, '1'),
(50, 158, 1, 0, 21, '1', 0, 0, '1'),
(51, 159, 15, 0, 18, '1', 0, 0, '1'),
(52, 160, 15, 0, 18, '1', 0, 0, '1'),
(53, 161, 15, 720, 18, '1', 0, 0, '1'),
(54, 162, 3, 0, 30, '1', 0, 0, '1'),
(55, 163, 3, 0, 30, '1', 0, 0, '1'),
(56, 164, 3, 0, 30, '1', 0, 0, '1'),
(57, 165, 3, 0, 30, '1', 0, 0, '1'),
(58, 166, 3, 0, 30, '1', 0, 0, '1'),
(59, 167, 3, 0, 30, '1', 0, 0, '1'),
(60, 168, 3, 0, 30, '1', 0, 0, '1'),
(61, 173, 1, 0, 21, '1', 0, 0, '1'),
(62, 173, 2, 0, 20, '1', 0, 0, '1'),
(63, 173, 8, 0, 15, '1', 0, 0, '1'),
(64, 174, 1, 0, 21, '1', 0, 0, '1'),
(65, 174, 2, 0, 20, '1', 0, 0, '1'),
(66, 174, 8, 0, 15, '1', 0, 0, '1'),
(67, 175, 1, 0, 21, '1', 0, 0, '1'),
(68, 175, 2, 0, 20, '1', 0, 0, '1'),
(69, 175, 8, 0, 15, '1', 0, 0, '1'),
(70, 176, 1, 0, 21, '1', 0, 0, '1'),
(71, 176, 2, 0, 20, '1', 0, 0, '1'),
(72, 176, 8, 0, 15, '1', 0, 0, '1'),
(73, 177, 1, 0, 21, '1', 0, 0, '1'),
(74, 177, 2, 0, 20, '1', 0, 0, '1'),
(75, 177, 8, 0, 15, '1', 0, 0, '1'),
(76, 178, 1, 0, 21, '1', 0, 0, '1'),
(77, 178, 2, 0, 20, '1', 0, 0, '1'),
(78, 178, 8, 0, 15, '1', 0, 0, '1'),
(79, 178, 1, 0, 21, '1', 0, 0, '1'),
(80, 178, 2, 0, 20, '1', 0, 0, '1'),
(81, 178, 8, 0, 15, '1', 0, 0, '1'),
(82, 179, 1, 0, 21, '1', 0, 0, '1'),
(83, 179, 2, 0, 20, '1', 0, 0, '1'),
(84, 179, 8, 0, 15, '1', 0, 0, '1'),
(85, 179, 1, 0, 21, '1', 0, 0, '1'),
(86, 179, 2, 0, 20, '1', 0, 0, '1'),
(87, 179, 8, 0, 15, '1', 0, 0, '1'),
(88, 180, 1, 0, 21, '1', 0, 0, '1'),
(89, 180, 2, 0, 20, '1', 0, 0, '1'),
(90, 180, 8, 0, 15, '1', 0, 0, '1'),
(91, 180, 1, 0, 21, '1', 0, 0, '1'),
(92, 180, 2, 0, 20, '1', 0, 0, '1'),
(93, 180, 8, 0, 15, '1', 0, 0, '1'),
(94, 181, 8, 600, 15, '1', 0, 0, '1'),
(95, 183, 3, 1200, 30, '1', 0, 0, '1'),
(96, 183, 3, 1200, 30, '1', 0, 0, '1'),
(103, 185, 10, 0, 13, '1', 0, 0, '1'),
(104, 185, 6, 0, 15, '1', 0, 0, '1'),
(105, 185, 13, 0, 12, '1', 0, 0, '1'),
(106, 186, 15, 586.62, 18, '1', 0, 0, '1'),
(107, 187, 17, 651.8, 20, '1', 0, 0, '1'),
(108, 189, 15, 586.62, 18, '1', 0, 0, '1'),
(109, 190, 15, 586.62, 18, '1', 0, 0, '1'),
(110, 194, 17, 651.8, 20, '1', 0, 0, '1'),
(111, 195, 3, 977.7, 30, '1', 0, 0, '1'),
(112, 197, 17, 651.8, 20, '1', 0, 0, '1'),
(113, 200, 2, 0, 25, '1', 0, 0, '1');

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
-- Volcado de datos para la tabla `consulta_indicaciones`
--

INSERT INTO `consulta_indicaciones` (`consulta_indicaciones_id`, `consulta_id`, `descripcion`) VALUES
(19, 110, 'No pasar situaciones de estrés'),
(23, 114, 'Evitar el consumo de azúcares, como refrescos y chocolates'),
(24, 116, 'Herví té de flores cada 7 días'),
(25, 117, 'Evitar la ingesta  de comida en la calle durante 3 meses'),
(26, 118, 'Tomar más alimentos con antioxidantes, como pasas'),
(27, 121, 'Aumentar la masa muscular mediante mejoración de la dieta'),
(28, 121, 'Caminar todos los días por la mañana'),
(29, 122, 'no aguantar ganas de ir al baño'),
(30, 123, 'Limpiar la zona con alcohol 3 veces al día'),
(31, 123, 'cambiar de gazas cada 2 días o cuando se llene mucho de sangre'),
(32, 125, 'Realizar exámenes especiales de sangre'),
(33, 126, 'Examen hormonal del perfil tiroideo'),
(34, 126, 'Ecografía tiroidea'),
(35, 127, 'Ecografía Renal realizada, sin problemas aparentes'),
(36, 130, 'Evitar el consumo de azúcares, como refrescos y chocolates'),
(38, 133, 'no llevar sereno'),
(39, 134, 'Lavar herida'),
(42, 141, 'Tomar awa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_insumo`
--

CREATE TABLE `consulta_insumo` (
  `consulta_insumo_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `cantidad` int(8) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  `precio_insumo_bs` float NOT NULL,
  `precio_insumo_usd` float NOT NULL,
  `cubierto_por` enum('1','2','3') NOT NULL DEFAULT '1',
  `monto_cubierto_usd` float NOT NULL DEFAULT 0,
  `monto_cubierto_bd` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_insumo`
--

INSERT INTO `consulta_insumo` (`consulta_insumo_id`, `insumo_id`, `consulta_id`, `cantidad`, `estatus_con`, `precio_insumo_bs`, `precio_insumo_usd`, `cubierto_por`, `monto_cubierto_usd`, `monto_cubierto_bd`) VALUES
(17, 5, 110, 3, '1', 200, 5, '1', 0, 0),
(18, 1, 116, 2, '1', 0, 2, '1', 0, 0),
(19, 5, 118, 1, '1', 0, 5, '1', 0, 0),
(20, 5, 119, 2, '1', 0, 5, '1', 0, 0),
(21, 5, 120, 1, '1', 0, 5, '1', 0, 0),
(22, 9, 122, 1, '1', 0, 12, '1', 0, 0),
(23, 5, 123, 1, '1', 0, 5, '1', 0, 0),
(24, 1, 123, 2, '1', 0, 2, '1', 0, 0),
(25, 7, 123, 2, '1', 0, 1.8, '1', 0, 0),
(26, 11, 123, 1, '1', 0, 2, '1', 0, 0),
(27, 5, 130, 2, '1', 0, 5, '1', 0, 0),
(29, 5, 133, 1, '1', 0, 5, '1', 0, 0),
(30, 7, 134, 4, '1', 0, 1.8, '1', 0, 0),
(35, 4, 141, 3, '1', 0, 2.5, '1', 0, 0),
(36, 7, 141, 4, '1', 0, 1.8, '1', 0, 0),
(37, 1, 150, 2, '1', 0, 2, '1', 0, 0),
(38, 8, 151, 1, '1', 0, 8.5, '1', 0, 0),
(41, 28, 154, 50, '1', 0, 1.5, '1', 0, 0),
(42, 28, 155, 50, '1', 0, 1.5, '1', 0, 0),
(45, 27, 158, 2, '1', 0, 0.5, '1', 0, 0),
(46, 28, 158, 50, '1', 0, 0.07, '1', 0, 0),
(47, 28, 159, 100, '1', 0, 0.07, '1', 0, 0),
(48, 28, 160, 100, '1', 0, 0.07, '1', 0, 0),
(49, 28, 161, 100, '1', 2.8, 0.07, '1', 0, 0),
(50, 27, 169, 2, '1', 0, 0.5, '1', 0, 0),
(51, 28, 169, 2, '1', 0, 0.07, '1', 0, 0),
(52, 27, 170, 2, '1', 0, 0.5, '1', 0, 0),
(53, 28, 170, 2, '1', 0, 0.07, '1', 0, 0),
(54, 27, 182, 3, '1', 0, 2.25, '1', 0, 0);

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
-- Volcado de datos para la tabla `consulta_recipe`
--

INSERT INTO `consulta_recipe` (`consulta_recipe_id`, `consulta_id`, `medicamento_id`, `uso`) VALUES
(98, 110, 1, 'Una diaria por una semana'),
(99, 111, 10, '2 diarias por 15 días'),
(106, 114, 11, 'Un diaria por 30 días'),
(107, 114, 24, '1 diario por 28 días, descansar por 5 días y volver a empezar'),
(108, 116, 25, '2 veces al día por una semana'),
(109, 117, 4, '1 cada 8 hrs durante 4 días'),
(110, 119, 25, 'Todos los días durante 7 días, dos gotas en cada fosa nasal'),
(111, 120, 11, 'Todos los días durante 30 días'),
(112, 123, 3, 'Una tableta diaria por 15 días'),
(113, 125, 10, 'una diaria por 30 días'),
(114, 126, 11, '1 cápsula diaria durante 30 días'),
(115, 131, 11, 'Un diaria por 30 días'),
(118, 141, 1, '1 diario por 15 días'),
(120, 198, 2, '2 tableta diaria durante 7 días');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_referidos`
--

CREATE TABLE `consulta_referidos` (
  `consulta_referidos_id` int(9) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_referidos`
--

INSERT INTO `consulta_referidos` (`consulta_referidos_id`, `consulta_id`, `especialidad_id`, `estatus_con`) VALUES
(1, 168, 57, '1'),
(2, 168, 84, '1');

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
  `monto_consulta_usd` float NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  `monto_consulta_bs` float NOT NULL,
  `cobertura_seguro` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_seguro`
--

INSERT INTO `consulta_seguro` (`consulta_seguro_id`, `consulta_id`, `seguro_id`, `tipo_servicio`, `fecha_ocurrencia`, `monto_consulta_usd`, `estatus_con`, `monto_consulta_bs`, `cobertura_seguro`) VALUES
(000000002, 161, 1, 'consulta', '2024-04-28 06:59:26', 35, '1', 1400, 0),
(000000010, 181, 12, 'consulta', '2024-05-06 02:09:28', 0, '1', 0, 10),
(000000011, 183, 2, 'consulta', '2024-05-06 08:37:53', 60, '1', 0, 0),
(000000012, 187, 3, 'consulta', '2024-05-11 04:51:32', 0, '1', 0, 15),
(000000013, 190, 1, 'consulta', '2024-05-12 05:51:32', 0, '1', 0, 30),
(000000022, 193, 1, '', '2024-05-12 21:48:36', 16, '1', 0, 46),
(000000023, 196, 2, 'consulta', '2024-05-13 01:51:50', 0, '1', 0, 10),
(000000024, 197, 1, '', '2024-05-19 02:56:45', 12, '', 391.08, 20),
(000000025, 198, 2, '', '2024-05-25 21:44:14', 0, '', 0, 20),
(000000028, 199, 3, '', '2024-05-26 03:12:04', 22, '1', 0, 28);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_sin_cita`
--

CREATE TABLE `consulta_sin_cita` (
  `consulta_sin_cita_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_sin_cita`
--

INSERT INTO `consulta_sin_cita` (`consulta_sin_cita_id`, `consulta_id`, `especialidad_id`, `medico_id`, `paciente_id`, `estatus_con`) VALUES
(80, 129, 37, 21, 1, '1'),
(81, 130, 53, 30, 24, '1'),
(82, 131, 30, 16, 12, '1'),
(84, 146, 9, 4, 3, '1'),
(86, 149, 9, 4, 24, '1'),
(87, 151, 1, 3, 30, '1'),
(90, 154, 10, 4, 24, '1'),
(91, 155, 10, 4, 24, '1'),
(93, 158, 10, 4, 24, '1'),
(94, 159, 20, 11, 33, '1'),
(95, 160, 20, 11, 33, '1'),
(96, 161, 20, 11, 33, '1'),
(97, 162, 1, 3, 3, '1'),
(98, 163, 1, 3, 3, '1'),
(99, 164, 1, 3, 3, '1'),
(100, 165, 1, 3, 3, '1'),
(101, 166, 1, 3, 3, '1'),
(102, 167, 1, 3, 3, '1'),
(103, 168, 1, 3, 3, '1'),
(104, 169, 20, 11, 40, '1'),
(105, 170, 20, 11, 40, '1'),
(108, 173, 10, 4, 33, '1'),
(109, 174, 10, 4, 33, '1'),
(110, 175, 10, 4, 33, '1'),
(111, 176, 10, 4, 33, '1'),
(112, 177, 10, 4, 33, '1'),
(113, 178, 10, 4, 33, '1'),
(114, 179, 10, 4, 33, '1'),
(115, 180, 10, 4, 33, '1'),
(116, 182, 1, 3, 30, '1'),
(117, 183, 9, 4, 30, '1'),
(118, 184, 1, 3, 37, '1'),
(121, 185, 1, 3, 37, '1'),
(122, 194, 1, 3, 9, '1'),
(123, 195, 10, 4, 8, '1');

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
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`empresa_id`, `nombre`, `rif`, `direccion`, `estatus_emp`) VALUES
(1, 'Selva', 'J-233412455', 'Campo Alegre', '1'),
(2, 'Grupo Farmacos', 'J-243343414', 'Montaña Fresca', '1'),
(4, 'Manpa', 'J-164112513', '23 de enero', '1'),
(5, 'Hilados Flexilón', 'J-243543214', '23 de enero', '1'),
(6, 'Sambil', 'J-234234234', 'Caracas', '1'),
(7, 'Los Andes', 'J-298389123', 'Aragua', '1'),
(8, 'Cantv C.A', 'J-122434234', 'Caracas', '1'),
(9, 'Kellogs', 'J-234342342', 'Maracay', '1'),
(10, 'Empresas Diana', 'J-214123423', 'Miranda', '1'),
(11, 'Groisleña', 'J-356453453', 'Vargas', '1'),
(12, 'Coca Cola', 'J-121231231', 'San Juan', '1'),
(13, 'Grupo Orinoco', 'J-213231231', 'Maracaibo', '1'),
(14, 'Crystallex', 'J-141234141', 'Monagas', '1'),
(15, 'Banco de Venezuela', 'J-232312783', 'Caracas', '1'),
(16, 'Sincor', 'J-465646546', 'Trujillo', '1'),
(17, 'La Farge', 'J-567567567', 'Táchira', '1'),
(18, 'Rojo TV C.A', 'J-876234767', 'Carabobo', '1'),
(19, 'Empresa de auditoría', 'J-453236545', 'San Vicente', '2');

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
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`especialidad_id`, `nombre`, `estatus_esp`) VALUES
(1, 'Traumatología', '1'),
(2, 'Psicología', '1'),
(3, 'Pediatría', '1'),
(4, 'Oncología', '2'),
(5, 'Otorrinolaringología', '1'),
(6, 'Oftamología', '1'),
(7, 'Cardiología', '1'),
(8, 'Dermatología', '1'),
(9, 'Endocrinología', '1'),
(10, 'Gastroenterología', '1'),
(11, 'Geriatría', '1'),
(12, 'Hematología', '1'),
(13, 'Infectología', '1'),
(14, 'Inmunología', '1'),
(15, 'Nefrología', '1'),
(16, 'Neumonología', '1'),
(17, 'Neurología', '1'),
(18, 'Nutriología', '1'),
(19, 'Oncología', '1'),
(20, 'Ortopedia', '1'),
(21, 'Oncología Radioterápica', '1'),
(22, 'Patología', '1'),
(23, 'Proctología', '1'),
(24, 'Psiquiatría', '1'),
(25, 'Rehabilitación', '1'),
(26, 'Reumatología', '1'),
(27, 'Toxicología', '1'),
(28, 'Urología', '1'),
(29, 'Acupuntura', '1'),
(30, 'Alergología', '1'),
(31, 'Andrología', '1'),
(32, 'Angiología', '1'),
(33, 'Bioquímica Clínica', '1'),
(34, 'Cirugía', '1'),
(35, 'Cirugía Cardiovascular', '1'),
(36, 'Cirugía General', '1'),
(37, 'Cirugía Plástica', '1'),
(38, 'Cirugía Torácica', '1'),
(39, 'Cirugía Vascular', '1'),
(40, 'Dietética y Nutrición', '1'),
(41, 'Ecografía', '1'),
(42, 'Epidemiología', '1'),
(43, 'Fisioterapia', '1'),
(44, 'Genética Médica', '1'),
(45, 'Ginecología', '1'),
(46, 'Homeopatía', '1'),
(47, 'Inmunología Clínica', '1'),
(48, 'Logopedia', '1'),
(49, 'Medicina Deportiva', '1'),
(50, 'Medicina Familiar', '1'),
(51, 'Medicina Física y Rehabilitación', '1'),
(52, 'Medicina Nuclear', '1'),
(53, 'Medicina Preventiva', '1'),
(54, 'Microbiología y Parasitología', '1'),
(55, 'Naturopatía', '2'),
(56, 'Medicina General', '1'),
(57, 'Traumato', '1'),
(84, 'Neurocirugía', '1'),
(85, 'Gatroenterología pediátrica', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `examen_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `precio_examen` int(11) DEFAULT NULL,
  `tipo` enum('1','2','3') NOT NULL,
  `hecho_aqui` tinyint(1) NOT NULL DEFAULT 0,
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`examen_id`, `nombre`, `precio_examen`, `tipo`, `hecho_aqui`, `estatus_exa`) VALUES
(1, 'Perfil 20', 21, '2', 1, '1'),
(2, 'Hematología completas', 15, '2', 1, '1'),
(3, 'Perfil Hepático', 30, '2', 1, '1'),
(4, 'Perfil Lípidico', 56, '2', 0, '1'),
(5, 'a', 21, '2', 1, '2'),
(6, 'Ecocardiograma', 65, '1', 1, '1'),
(7, 'a', 21, '1', 1, '2'),
(8, 'Ecografía Renal', 15, '1', 0, '1'),
(9, 'Análisis de Sangre Completo', 25, '2', 1, '1'),
(10, 'Ultrasonido Abdominal', 20, '3', 1, '1'),
(11, 'Ultrasonido Obstétrico', 22, '3', 0, '1'),
(12, 'Ecografía de Tiroides', 15, '1', 1, '1'),
(13, 'Hemograma', 12, '2', 0, '1'),
(14, 'Ultrasonido Doppler Vascular', 25, '3', 1, '1'),
(15, 'Ecografía Muscular', 18, '1', 0, '1'),
(16, 'E', 18, '1', 0, '2'),
(17, 'Radiografía de Torax', 20, '1', 1, '1'),
(18, 'Examen de Orina Completo', 12, '2', 0, '1'),
(19, 'Resonancia Magnética Cerebral', 50, '3', 1, '1'),
(20, 'Tomografía Computarizada Abdominal', 30, '1', 0, '1'),
(21, 'Biopsia de Hígado', 40, '2', 1, '1'),
(22, 'Ecografía Ocular', 25, '3', 0, '1'),
(23, 'Prueba de Coagulación Sanguínea', 15, '1', 1, '1'),
(24, 'Examen de Glucosa en Sangre', 10, '2', 0, '1'),
(25, 'Ecocardiografía Fetal', 35, '3', 1, '1'),
(26, 'Densitometría Ósea', 28, '1', 0, '1'),
(27, 'Análisis de Tiroides', 18, '2', 0, '1'),
(28, 'Ecografía Articular', 20, '3', 1, '1'),
(29, 'Tomografía de Columna Vertebral', 30, '1', 0, '1'),
(30, 'Perfil de Enzimas Hepáticas', 15, '2', 1, '1'),
(31, 'Ultrasonido Mamario', 28, '3', 0, '1'),
(32, 'Electrocardiograma', 12, '1', 1, '1'),
(33, 'Examen de Sangre Oculta en Heces', 20, '2', 0, '1'),
(34, 'Ecografía Renal y Vesical', 22, '3', 1, '1'),
(35, 'Prueba de Función Pulmonar', 35, '1', 0, '1'),
(36, 'exaneb de prueba', 23, '1', 1, '2'),
(38, 'mamografía', 45, '2', 0, '1'),
(39, 'Escala de ansiedad de Hamilton', 23, '3', 1, '2'),
(40, 'examen prueba 1', 35, '1', 0, '1'),
(41, 'Examen de prueba 2', 35, '1', 0, '1'),
(42, 'Examen de prueba 3', 35, '1', 0, '1'),
(43, 'Recuento de glóbulos blancos', 15, '2', 0, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_especialidad`
--

CREATE TABLE `examen_especialidad` (
  `examen_especialidad_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examen_especialidad`
--

INSERT INTO `examen_especialidad` (`examen_especialidad_id`, `examen_id`, `especialidad_id`, `estatus_exa`) VALUES
(1, 42, 1, '1'),
(2, 42, 2, '2'),
(3, 40, 3, '1'),
(4, 8, 15, '1'),
(5, 6, 7, '1'),
(6, 6, 35, '1'),
(7, 3, 10, '1'),
(8, 4, 7, '1'),
(9, 4, 35, '1'),
(10, 10, 56, '1'),
(11, 11, 45, '1'),
(12, 12, 56, '1'),
(13, 12, 9, '1'),
(14, 13, 35, '1'),
(15, 14, 35, '1'),
(16, 14, 56, '1'),
(17, 14, 7, '1'),
(18, 14, 53, '1'),
(19, 18, 56, '1'),
(20, 17, 1, '1'),
(21, 15, 1, '1'),
(22, 2, 56, '1'),
(23, 43, 12, '1');

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
  `monto_usd` float NOT NULL,
  `excento` float DEFAULT NULL,
  `motivo_cancelacion` text DEFAULT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_compra`
--

INSERT INTO `factura_compra` (`factura_compra_id`, `proveedor_id`, `fecha_compra`, `total_productos`, `monto_con_iva`, `monto_sin_iva`, `monto_usd`, `excento`, `motivo_cancelacion`, `estatus_fac`) VALUES
(000000001, 1, '2023-11-02 00:00:00', 29, 115.61, 104.7, 3.55, 10.91, NULL, '1'),
(000000002, 6, '2023-09-04 00:00:00', 7, 2.1, 2.1, 0.06, 0, NULL, '2'),
(000000003, 6, '2023-11-13 00:00:00', 2, 4.8, 4.8, 0.15, 0, NULL, '1'),
(000000004, 6, '2023-11-13 00:00:00', 2, 4.8, 4.8, 0.15, 0, NULL, '2'),
(000000005, 5, '2023-07-11 00:00:00', 5, 10.54, 7.54, 0.32, NULL, NULL, '1'),
(000000006, 5, '2023-07-11 00:00:00', 5, 10.54, 7.54, 0.32, NULL, NULL, '1'),
(000000007, 5, '2023-07-11 00:00:00', 5, 10.54, 7.54, 0.32, NULL, NULL, '1'),
(000000008, 5, '2023-07-11 00:00:00', 5, 10.54, 7.54, 0.32, NULL, NULL, '1'),
(000000009, 5, '2023-07-11 00:00:00', 5, 10.54, 7.54, 0.32, NULL, NULL, '1'),
(000000010, 5, '2023-07-11 00:00:00', 5, 10.54, 7.54, 0.32, NULL, NULL, '2'),
(000000011, 3, '2024-03-21 00:00:00', 10, 15, 15, 0.46, 0, NULL, '1'),
(000000012, 7, '2024-03-23 00:00:00', 17, 47, 47, 1.44, 0, NULL, '1'),
(000000013, 7, '2024-03-23 00:00:00', 17, 47, 47, 1.44, 0, NULL, '1'),
(000000014, 7, '2024-03-23 00:00:00', 17, 47, 47, 1.44, 0, NULL, '1'),
(000000015, 7, '2024-03-23 00:00:00', 17, 47, 47, 1.44, 0, NULL, '2'),
(000000016, 6, '2024-03-16 00:00:00', 1, 1, 1, 0.03, 0, NULL, '1'),
(000000017, 6, '2024-03-16 00:00:00', 1, 1, 1, 0.03, 0, NULL, '1'),
(000000018, 6, '2024-03-16 00:00:00', 1, 1, 1, 0.03, 0, NULL, '1'),
(000000019, 4, '2024-04-24 00:00:00', 5, 25, 25, 0.77, 0, NULL, '1'),
(000000020, 6, '2024-04-27 00:00:00', 1, 10.5, 10, 0.26, NULL, NULL, '1'),
(000000021, 6, '2024-04-27 00:00:00', 1, 10.5, 10, 0.26, NULL, NULL, '1'),
(000000022, 6, '2024-04-27 00:00:00', 1, 10.5, 10, 0.26, NULL, NULL, '1'),
(000000023, 6, '2024-04-27 00:00:00', 1, 10.5, 10, 0.26, NULL, NULL, '1'),
(000000024, 6, '2024-04-27 00:00:00', 1, 10.5, 10, 0.26, NULL, NULL, '1'),
(000000025, 6, '2024-04-27 00:00:00', 1, 10.5, 10, 0.26, NULL, NULL, '1'),
(000000026, 6, '2024-04-27 00:00:00', 1, 10.5, 10, 0.26, NULL, NULL, '1'),
(000000027, 7, '2024-04-27 00:00:00', 4, 160.5, 160, 4.01, NULL, NULL, '1'),
(000000028, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '2'),
(000000029, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '2'),
(000000030, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, 'me dio la gana', '2'),
(000000031, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000032, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000033, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000034, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000035, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000036, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000037, 2, '2024-04-28 00:00:00', 5, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000038, 2, '2024-04-28 00:00:00', 9, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000039, 2, '2024-04-28 00:00:00', 9, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000040, 2, '2024-04-28 00:00:00', 9, 11.6, 10, 0.29, 1.6, NULL, '1'),
(000000041, 2, '2024-04-28 00:00:00', 9, 11.6, 10, 0.29, 1.6, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_consulta`
--

CREATE TABLE `factura_consulta` (
  `factura_consulta_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `monto_consulta_bs` float NOT NULL,
  `monto_consulta_usd` float NOT NULL,
  `tipo_consulta` enum('1','2') NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_consulta`
--

INSERT INTO `factura_consulta` (`factura_consulta_id`, `consulta_id`, `paciente_id`, `metodo_pago`, `monto_consulta_bs`, `monto_consulta_usd`, `tipo_consulta`, `estatus_fac`) VALUES
(00000001, 129, 1, 'efectivo', 6518, 200, '1', '1'),
(00000002, 110, 2, 'efectivo', 600, 15, '1', '1'),
(00000003, 181, 61, 'efectivo', 1000, 25, '2', '1'),
(00000004, 183, 30, 'debito', 400, 10, '1', '1'),
(00000005, 186, 10, 'debito', 488.85, 15, '1', '1'),
(00000006, 187, 43, 'debito', 1042.88, 32, '1', '1'),
(00000008, 189, 14, 'debito', 0, 0, '1', '1'),
(00000010, 190, 33, 'debito', 521.44, 16, '1', '1'),
(00000011, 194, 9, 'debito', 391.08, 12, '1', '1'),
(00000012, 195, 8, 'debito', 0, 0, '1', '1'),
(00000013, 196, 30, 'efectivo', 651.8, 20, '1', '1'),
(00000026, 197, 35, 'efectivo', 1205.83, 37, '1', '1'),
(00000027, 198, 54, 'efectivo', 130.36, 4, '1', '1'),
(00000028, 199, 43, 'debito', 65.18, 2, '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_medico`
--

CREATE TABLE `factura_medico` (
  `factura_medico_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `medico_id` int(11) NOT NULL,
  `acumulado_seguro_total` float DEFAULT NULL,
  `acumulado_consulta_total` float DEFAULT NULL,
  `sumatoria_consultas_aseguradas` float NOT NULL,
  `sumatoria_consultas_naturales` float NOT NULL,
  `acumulado_medico` float NOT NULL,
  `pago_total` float DEFAULT NULL,
  `factura_medico` float NOT NULL,
  `fecha_pago` date DEFAULT NULL,
  `fecha_emision` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pacientes_seguro` int(11) DEFAULT NULL,
  `pacientes_consulta` int(11) DEFAULT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_medico`
--

INSERT INTO `factura_medico` (`factura_medico_id`, `medico_id`, `acumulado_seguro_total`, `acumulado_consulta_total`, `sumatoria_consultas_aseguradas`, `sumatoria_consultas_naturales`, `acumulado_medico`, `pago_total`, `factura_medico`, `fecha_pago`, `fecha_emision`, `pacientes_seguro`, `pacientes_consulta`, `estatus_fac`) VALUES
(00000001, 5, 0, 0, 0, 0, 0, 0, 0, NULL, '2024-04-03 04:00:00', 0, 0, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_mensajeria`
--

CREATE TABLE `factura_mensajeria` (
  `factura_mensajeria_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `fecha_mensajeria` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `seguro_id` int(11) NOT NULL,
  `total_mensajeria_bs` float NOT NULL,
  `total_mensajeria_usd` float NOT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_mensajeria`
--

INSERT INTO `factura_mensajeria` (`factura_mensajeria_id`, `fecha_mensajeria`, `seguro_id`, `total_mensajeria_bs`, `total_mensajeria_usd`, `estatus_fac`) VALUES
(000000003, '2024-04-28 06:59:26', 1, 2400, 60, '1'),
(000000004, '2024-05-19 02:56:45', 1, 1857.63, 57, '1'),
(000000005, '2024-05-25 21:44:14', 2, 782.16, 24, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_mensajeria_consultas`
--

CREATE TABLE `factura_mensajeria_consultas` (
  `factura_mensajeria_consultas_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `factura_mensajeria_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `consulta_seguro_id` int(9) UNSIGNED ZEROFILL NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1',
  `fecha_mensajeria_consultas` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_mensajeria_consultas`
--

INSERT INTO `factura_mensajeria_consultas` (`factura_mensajeria_consultas_id`, `factura_mensajeria_id`, `consulta_seguro_id`, `estatus_fac`, `fecha_mensajeria_consultas`) VALUES
(000000003, 000000003, 000000002, '1', '2024-04-28 06:59:26'),
(000000004, 000000004, 000000024, '1', '2024-05-19 02:56:45'),
(000000005, 000000005, 000000025, '1', '2024-05-25 21:44:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_seguro`
--

CREATE TABLE `factura_seguro` (
  `factura_seguro_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `nro_control` int(11) DEFAULT NULL,
  `mes` varchar(10) NOT NULL,
  `fecha_ocurrencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_vencimiento` date NOT NULL,
  `monto_usd` float NOT NULL,
  `monto_bs` float NOT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_seguro`
--

INSERT INTO `factura_seguro` (`factura_seguro_id`, `seguro_id`, `nro_control`, `mes`, `fecha_ocurrencia`, `fecha_vencimiento`, `monto_usd`, `monto_bs`, `estatus_fac`) VALUES
(00000001, 1, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000002, 2, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000003, 3, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000004, 4, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000005, 8, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000006, 9, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000007, 10, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000008, 11, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000009, 12, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000010, 13, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1'),
(00000011, 14, NULL, 'marzo', '2024-03-25 04:55:43', '2024-04-01', 0, 0, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `global`
--

CREATE TABLE `global` (
  `global_id` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `global`
--

INSERT INTO `global` (`global_id`, `key`, `value`) VALUES
(1, 'porcentaje_medico', '60'),
(2, 'cambio_divisa', '32.59'),
(3, 'porcentaje_insumo', '5');

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
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`horario_id`, `medico_id`, `dias_semana`, `hora_salida`, `hora_entrada`, `estatus_hor`) VALUES
(1, 1, 'lunes', '21:30:00', '20:30:00', '1'),
(2, 1, 'miercoles', '12:30:00', '08:30:00', '1'),
(3, 2, 'lunes', '17:55:00', '03:55:00', '1'),
(4, 2, 'jueves', '14:58:00', '05:56:00', '1'),
(5, 2, 'martes', '19:02:00', '05:00:00', '1'),
(6, 3, 'lunes', '20:10:00', '08:10:00', '1'),
(7, 3, 'martes', '18:10:00', '10:10:00', '1'),
(8, 3, 'miercoles', '16:10:00', '07:10:00', '1'),
(9, 4, 'lunes', '18:00:00', '10:00:00', '1'),
(10, 4, 'miercoles', '14:00:00', '09:00:00', '1'),
(11, 4, 'viernes', '16:00:00', '11:00:00', '1'),
(12, 5, 'martes', '14:00:00', '08:00:00', '1'),
(13, 5, 'jueves', '13:00:00', '09:00:00', '1'),
(14, 5, 'sabado', '15:00:00', '10:00:00', '1'),
(15, 6, 'martes', '17:00:00', '09:00:00', '1'),
(16, 6, 'jueves', '13:00:00', '08:00:00', '1'),
(17, 7, 'lunes', '19:00:00', '14:00:00', '1'),
(18, 7, 'miercoles', '12:00:00', '08:00:00', '1'),
(19, 8, 'miercoles', '16:00:00', '10:00:00', '1'),
(20, 8, 'viernes', '14:00:00', '09:00:00', '1'),
(21, 9, 'jueves', '15:00:00', '09:00:00', '1'),
(22, 9, 'sabado', '12:00:00', '08:00:00', '1'),
(23, 10, 'martes', '12:00:00', '08:00:00', '1'),
(24, 10, 'jueves', '18:00:00', '13:00:00', '1'),
(25, 10, 'sabado', '14:00:00', '09:00:00', '1'),
(26, 11, 'lunes', '17:00:00', '11:00:00', '1'),
(27, 11, 'miercoles', '15:00:00', '10:00:00', '1'),
(28, 12, 'miercoles', '14:00:00', '09:00:00', '1'),
(29, 12, 'viernes', '18:00:00', '12:00:00', '1'),
(30, 13, 'jueves', '16:00:00', '10:00:00', '1'),
(31, 13, 'sabado', '13:00:00', '08:00:00', '1'),
(32, 14, 'lunes', '15:00:00', '09:00:00', '1'),
(33, 14, 'miercoles', '14:00:00', '10:00:00', '1'),
(34, 14, 'viernes', '12:00:00', '08:00:00', '1'),
(35, 15, 'martes', '13:00:00', '08:00:00', '1'),
(36, 15, 'jueves', '14:00:00', '09:00:00', '1'),
(37, 15, 'sabado', '15:00:00', '10:00:00', '1'),
(38, 16, 'lunes', '16:00:00', '11:00:00', '1'),
(39, 16, 'miercoles', '18:00:00', '12:00:00', '1'),
(40, 17, 'martes', '15:00:00', '10:00:00', '1'),
(41, 17, 'jueves', '17:00:00', '11:00:00', '1'),
(42, 18, 'miercoles', '14:00:00', '09:00:00', '1'),
(43, 18, 'viernes', '13:00:00', '08:00:00', '1'),
(44, 19, 'jueves', '12:00:00', '08:00:00', '1'),
(45, 19, 'sabado', '13:00:00', '09:00:00', '1'),
(46, 20, 'lunes', '14:00:00', '09:00:00', '1'),
(47, 20, 'miercoles', '15:00:00', '10:00:00', '1'),
(48, 20, 'viernes', '16:00:00', '11:00:00', '1'),
(49, 21, 'martes', '13:00:00', '08:00:00', '1'),
(50, 21, 'jueves', '14:00:00', '09:00:00', '1'),
(51, 21, 'sabado', '15:00:00', '10:00:00', '1'),
(52, 22, 'lunes', '15:00:00', '10:00:00', '1'),
(53, 22, 'miercoles', '16:00:00', '11:00:00', '1'),
(54, 23, 'jueves', '13:00:00', '08:00:00', '1'),
(55, 23, 'sabado', '14:00:00', '09:00:00', '1'),
(56, 24, 'lunes', '14:00:00', '08:00:00', '1'),
(57, 24, 'miercoles', '15:00:00', '09:00:00', '1'),
(58, 24, 'viernes', '16:00:00', '10:00:00', '1'),
(59, 25, 'martes', '17:00:00', '11:00:00', '1'),
(60, 25, 'jueves', '18:00:00', '12:00:00', '1'),
(61, 26, 'lunes', '13:00:00', '07:00:00', '1'),
(62, 26, 'miercoles', '14:00:00', '08:00:00', '1'),
(63, 26, 'viernes', '15:00:00', '09:00:00', '1'),
(64, 27, 'martes', '14:00:00', '09:00:00', '1'),
(65, 27, 'jueves', '15:00:00', '10:00:00', '1'),
(66, 28, 'miercoles', '16:00:00', '11:00:00', '1'),
(67, 28, 'viernes', '17:00:00', '12:00:00', '1'),
(68, 29, 'jueves', '15:00:00', '10:00:00', '1'),
(69, 29, 'sabado', '16:00:00', '11:00:00', '1'),
(70, 30, 'lunes', '17:00:00', '12:00:00', '1'),
(71, 30, 'miercoles', '18:00:00', '13:00:00', '1'),
(72, 30, 'viernes', '19:00:00', '14:00:00', '1'),
(73, 31, 'martes', '13:00:00', '08:00:00', '1'),
(74, 31, 'jueves', '14:00:00', '09:00:00', '1'),
(75, 31, 'sabado', '15:00:00', '10:00:00', '1'),
(76, 32, 'lunes', '14:00:00', '09:00:00', '1'),
(77, 32, 'miercoles', '15:00:00', '10:00:00', '1'),
(78, 32, 'viernes', '16:00:00', '11:00:00', '1'),
(79, 33, 'martes', '17:00:00', '12:00:00', '1'),
(80, 33, 'jueves', '18:00:00', '13:00:00', '1'),
(81, 33, 'sabado', '19:00:00', '14:00:00', '1'),
(82, 38, 'martes', '17:00:00', '12:00:00', '1'),
(83, 39, 'lunes', '12:00:00', '09:00:00', '1'),
(84, 39, 'martes', '12:00:00', '09:00:00', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE `insumo` (
  `insumo_id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL DEFAULT '0',
  `cantidad_min` int(11) NOT NULL,
  `cantidad_unidad` int(11) NOT NULL DEFAULT 0,
  `capacidad_unidad` int(11) NOT NULL,
  `cantidad_capacidad` int(11) NOT NULL,
  `precio` float NOT NULL DEFAULT 0,
  `tipo_medida` enum('1','2','3','4') NOT NULL,
  `es_cobrado` enum('0','1') NOT NULL,
  `tipo_insumo` enum('1','2') DEFAULT '1',
  `estatus_ins` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`insumo_id`, `nombre`, `cantidad_min`, `cantidad_unidad`, `capacidad_unidad`, `cantidad_capacidad`, `precio`, `tipo_medida`, `es_cobrado`, `tipo_insumo`, `estatus_ins`) VALUES
(1, 'Inyectadora 5ml', 20, 14, 1, 14, 0.07, '1', '1', '1', '1'),
(2, 'Inyectadora 10ml', 20, 0, 0, 0, 2, '1', '', '1', '1'),
(3, 'inyéñ', 1, 0, 0, 0, 1, '1', '', '1', '2'),
(4, 'Esparadrapo Estéril', 20, 0, 0, 0, 2.5, '1', '', '1', '1'),
(5, 'Guantes Quirúrgicos', 30, 0, 0, 0, 5, '1', '', '1', '1'),
(6, 'Venda Elástica 5cm', 15, 0, 0, 0, 3, '1', '', '1', '1'),
(7, 'Algodón Hidrófilo', 10, 0, 0, 0, 1.8, '1', '', '1', '1'),
(8, 'Termómetro Clínico', 50, 0, 0, 0, 8.5, '1', '', '1', '1'),
(9, 'Sonda Foley 16Fr', 15, 0, 0, 0, 12, '1', '', '1', '1'),
(10, 'Apósito Adhesivo Estéril', 8, 0, 0, 0, 4.2, '1', '', '1', '1'),
(11, 'Gasas Estériles', 25, 0, 0, 0, 2, '1', '', '1', '1'),
(12, 'Juego de Pinzas Quirúrgicas', 5, 0, 0, 0, 15, '1', '', '1', '1'),
(13, 'Mascarilla Quirúrgica', 40, 0, 0, 0, 1.2, '1', '', '1', '1'),
(14, 'Jabón Antiséptico', 12, 0, 0, 0, 4.8, '1', '', '1', '1'),
(15, 'Bisturí Descartable', 6, 0, 0, 0, 7.5, '1', '', '1', '1'),
(16, 'Silla de Ruedas Plegable', 20, 0, 0, 0, 120, '1', '', '1', '1'),
(17, 'Cánula Nasal de Oxígeno', 18, 0, 0, 0, 6.5, '1', '', '1', '1'),
(18, 'Lámpara de Examínación Médica', 30, 0, 0, 0, 35, '1', '', '1', '1'),
(19, 'Compresa Fría/Caliente', 8, 0, 0, 0, 3.5, '1', '', '1', '1'),
(20, 'Tensiómetro Digital', 25, 0, 0, 0, 22, '1', '', '1', '1'),
(21, 'Vaso Nebulizador', 10, 0, 0, 0, 9, '1', '', '1', '1'),
(22, 'Bata Quirúrgica Desechable', 15, 0, 0, 0, 5.8, '1', '', '1', '1'),
(23, 'Martillo de Reflejos', 5, 0, 0, 0, 14, '1', '', '1', '1'),
(24, 'sonda nrñ', 54, 0, 0, 0, 21, '1', '', '1', '2'),
(25, 'inyectadora de auditoría', 2, 0, 0, 0, 12, '1', '', '1', '2'),
(26, 'Insumo de prueba', 5, 0, 0, 0, 10, '1', '0', '1', '1'),
(27, 'Gaza', 4, 19, 1, 19, 2.25, '1', '1', '2', '1'),
(28, 'Alcohol', 4, 35, 250, 8746, 1.07, '2', '1', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `medicamento_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `nombre_medicamento` varchar(45) NOT NULL,
  `tipo_medicamento` enum('1','2','3','4') DEFAULT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`medicamento_id`, `especialidad_id`, `nombre_medicamento`, `tipo_medicamento`, `estatus_med`) VALUES
(1, 56, 'Paracetamol', '1', '1'),
(2, 56, 'Ibuprofeno', '1', '1'),
(3, 13, 'Amoxicilina', '1', '1'),
(4, 10, 'Omeprazol', '1', '1'),
(5, 2, 'Diazepam', '2', '1'),
(6, 36, 'Morfina', '3', '1'),
(7, 30, 'Ciprofloxacino', '2', '1'),
(8, 30, 'Codeína', '2', '1'),
(9, 9, 'Insulina', '3', '1'),
(10, 56, 'Aspirina', '1', '1'),
(11, 56, 'Vitamina C', '1', '1'),
(12, 9, 'Furosemida', '1', '1'),
(13, 8, 'Cetirizina', '1', '1'),
(14, 15, 'Warfarina', '2', '1'),
(15, 30, 'Warfarina', '3', '1'),
(16, 30, 'Loratadina', '1', '1'),
(17, 9, 'Metformina', '1', '1'),
(18, 15, 'Heparina', '3', '1'),
(19, 7, 'Atenolol', '1', '1'),
(20, 7, 'Atenolol', '1', '1'),
(21, 7, 'Atenolol', '1', '1'),
(22, 30, 'Dipirona', '1', '1'),
(23, 30, 'Dipirona', '1', '1'),
(24, 45, 'Anticonceptivo 85gr', '1', '1'),
(25, 5, 'Nafasol', '4', '1'),
(27, 2, 'venlafaxina', '1', '2'),
(28, 1, 'medicamento de prueba', '1', '1'),
(29, 1, 'medicamento de prueba', '1', '1'),
(30, 1, 'medicamento de prueba', '1', '1');

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
  `acumulado` int(11) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`medico_id`, `cedula`, `nombre`, `apellidos`, `telefono`, `direccion`, `acumulado`, `estatus_med`) VALUES
(1, 29528456, 'Juan', 'Vazquez', '04124859636', 'Maracay', 0, '1'),
(2, 29527750, 'abimael', 'a', '04124528584', '2', 0, '2'),
(3, 25678987, 'Daniela', 'Mandez', '04127859696', 'Barrio Bolívar sur', 0, '1'),
(4, 11502130, 'Beatriz', 'López', '04125005557', 'Barrio Miranda', 75, '1'),
(5, 11502178, 'María', 'García', '04125005789', 'Barrio Sucre', 0, '1'),
(6, 11502131, 'Carolina', 'González', '04125005558', 'Barrio Urdaneta', 0, '1'),
(7, 11502132, 'Daniel', 'Martínez', '04125005559', 'Barrio Sucre', 0, '1'),
(8, 11502133, 'Elena', 'Pérez', '04125005560', 'Barrio Zamora', 0, '1'),
(9, 11502134, 'Fernando', 'Gutiérrez', '04125005561', 'Barrio Bolívar', 0, '1'),
(10, 11502135, 'Gabriela', 'Rojas', '04125005562', 'Barrio Miranda', 0, '1'),
(11, 11502136, 'Hugo', 'Sánchez', '04125005563', 'Barrio Urdaneta', 0, '1'),
(12, 11502137, 'Isabel', 'Torres', '04125005564', 'Barrio Sucre', 0, '1'),
(13, 11502138, 'Javier', 'Mendoza', '04125005565', 'Barrio Zamora', 0, '1'),
(14, 11502139, 'Luis', 'Fernández', '04125005566', 'Barrio Bolívar', 0, '1'),
(15, 11502140, 'Marta', 'Santos', '04125005567', 'Barrio Miranda', 0, '1'),
(16, 11502141, 'Natalia', 'Castillo', '04125005568', 'Barrio Urdaneta', 0, '1'),
(17, 11502142, 'Óscar', 'Gómez', '04125005569', 'Barrio Sucre', 0, '1'),
(18, 11502143, 'Pablo', 'Ramos', '04125005570', 'Barrio Zamora', 0, '1'),
(19, 11502144, 'Querubín', 'Rojas', '04125005571', 'Barrio Bolívar', 0, '1'),
(20, 11502145, 'Rosa', 'Sánchez', '04125005572', 'Barrio Miranda', 0, '1'),
(21, 11502146, 'Sergio', 'Luna', '04125005573', 'Barrio Urdaneta', 0, '1'),
(22, 11502147, 'Teresa', 'Gutiérrez', '04125005574', 'Barrio Sucre', 0, '1'),
(23, 11502148, 'Ulises', 'Fuentes', '04125005575', 'Barrio Zamora', 0, '1'),
(24, 11502149, 'Valentina', 'Hernández', '04125005576', 'Barrio Bolívar', 0, '1'),
(25, 11502150, 'Walter', 'Iglesias', '04125005577', 'Barrio Miranda', 0, '1'),
(26, 11502151, 'Ximena', 'Jiménez', '04125005578', 'Barrio Urdaneta', 0, '1'),
(27, 11502152, 'Yanet', 'Kumar', '04125005579', 'Barrio Sucre', 0, '1'),
(28, 11502153, 'Zoe', 'López', '04125005580', 'Barrio Zamora', 0, '1'),
(29, 11502154, 'Abel', 'Mendoza', '04125005581', 'Barrio Bolívar', 0, '1'),
(30, 11502155, 'Bárbara', 'Nieves', '04125005582', 'Barrio Miranda', 34, '1'),
(31, 11502156, 'Carlos', 'Orozco', '04125005583', 'Barrio Urdaneta', 0, '1'),
(32, 11502157, 'Diana', 'Paredes', '04125005584', 'Barrio Sucre', 0, '1'),
(33, 11502158, 'Eduardo', 'Quintero', '04125005585', 'Barrio Zamora', 0, '1'),
(38, 234564456, 'Manuel', 'Quintero', '04125005585', 'Barrio Zamora', 0, '1'),
(39, 24354678, 'Medico de prueba', 'prueba', '04128594658', 'San Vicente', 0, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_especialidad`
--

CREATE TABLE `medico_especialidad` (
  `medico_especialidad_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `costo_especialidad` int(11) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medico_especialidad`
--

INSERT INTO `medico_especialidad` (`medico_especialidad_id`, `medico_id`, `especialidad_id`, `costo_especialidad`, `estatus_med`) VALUES
(1, 1, 2, 20, '1'),
(2, 2, 2, 0, '1'),
(3, 3, 1, 12, '1'),
(4, 3, 3, 0, '1'),
(5, 3, 6, 0, '1'),
(6, 4, 9, 0, '1'),
(7, 4, 10, 22, '1'),
(8, 5, 21, 0, '1'),
(9, 5, 22, 0, '1'),
(10, 5, 23, 0, '1'),
(11, 6, 11, 0, '1'),
(12, 6, 12, 0, '1'),
(13, 7, 13, 0, '1'),
(14, 8, 14, 0, '1'),
(15, 8, 15, 0, '1'),
(16, 9, 16, 16, '1'),
(17, 10, 17, 0, '1'),
(18, 10, 18, 0, '1'),
(19, 10, 19, 0, '1'),
(20, 11, 20, 0, '1'),
(21, 12, 21, 0, '1'),
(22, 12, 22, 0, '1'),
(23, 13, 23, 0, '1'),
(24, 13, 24, 0, '1'),
(25, 13, 25, 0, '1'),
(26, 14, 26, 0, '1'),
(27, 14, 27, 0, '1'),
(28, 15, 28, 0, '1'),
(29, 16, 29, 0, '1'),
(30, 16, 30, 0, '1'),
(31, 17, 31, 0, '1'),
(32, 18, 32, 0, '1'),
(33, 18, 33, 0, '1'),
(34, 19, 34, 0, '1'),
(35, 19, 35, 0, '1'),
(36, 20, 36, 0, '1'),
(37, 21, 37, 0, '1'),
(38, 21, 38, 0, '1'),
(39, 22, 39, 0, '1'),
(40, 23, 40, 0, '1'),
(41, 23, 41, 0, '1'),
(42, 23, 42, 0, '1'),
(43, 24, 43, 0, '1'),
(44, 24, 44, 0, '1'),
(45, 25, 45, 0, '1'),
(46, 26, 46, 0, '1'),
(47, 26, 47, 0, '1'),
(48, 27, 48, 0, '1'),
(49, 28, 49, 0, '1'),
(50, 28, 50, 0, '1'),
(51, 29, 51, 0, '1'),
(52, 30, 52, 0, '1'),
(53, 30, 53, 0, '1'),
(54, 31, 54, 0, '1'),
(55, 32, 55, 0, '1'),
(62, 38, 55, 24, '1'),
(63, 38, 54, 24, '1'),
(64, 38, 53, 20, '1'),
(65, 39, 2, 20, '1'),
(66, 39, 8, 15, '1'),
(67, 15, 56, 18, '1');

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
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`paciente_id`, `cedula`, `nombre`, `apellidos`, `fecha_nacimiento`, `edad`, `telefono`, `direccion`, `tipo_paciente`, `estatus_pac`) VALUES
(1, 24567567, 'Ana Maríca', 'Gonzalez Perasa', '2000-02-12', 23, '04126344545', '23 de enero', '1', '1'),
(2, 21345543, 'Juan', 'Martínez Pérez', '1987-03-12', 36, '1231212', '23 de enero', '2', '1'),
(3, 12343211, 'Delia', 'Milagros Olivares', '1956-01-02', 67, '4564545', 'Santa Marta', '2', '1'),
(4, 13456736, 'Luis', 'Martínez Alfonso', '1980-09-24', 43, '3423456', 'Brisas del Lago', '1', '1'),
(5, 19765765, 'Miguel', 'Cervanos', '1990-12-12', 32, '2346565', '24354321', '1', '1'),
(6, 28765432, 'Adelaida', 'Flores Martínez', '2001-09-22', 22, '2345465', 'Campo Alegre', '1', '1'),
(7, 22345456, 'Julian', 'Morales', '2003-12-12', 19, '3454545', 'La Casona', '1', '1'),
(8, 30234234, 'John Erick', 'Gutierrez González', '2003-11-11', 19, '8259445', 'Urb. El Centro', '1', '1'),
(9, 20345345, 'Alejandra', 'Torres', '2001-10-12', 22, '2343434', 'Brisas del Lago', '1', '1'),
(10, 12345678, 'Maria', 'Gonzalez', '1990-05-10', 31, '04121234567', 'Caracas', '1', '1'),
(11, 87654321, 'Pedro', 'Martinez', '1985-09-15', 38, '04261234567', 'Valencia', '1', '1'),
(12, 98765432, 'Ana', 'Pérez', '1978-07-20', 45, '04121231234', 'Maracaibo', '1', '1'),
(13, 23456789, 'Luis', 'Rodríguez', '1982-03-05', 41, '04121112233', 'Barquisimeto', '1', '1'),
(14, 98761234, 'Carolina', 'Hernández', '1995-11-28', 27, '04126663377', 'Maracaibo', '1', '1'),
(15, 67891234, 'Andrés', 'Suarez', '1975-01-02', 48, '04262223344', 'Caracas', '1', '1'),
(16, 89123456, 'Laura', 'García', '1988-06-15', 35, '04129998877', 'Valencia', '1', '1'),
(17, 12378945, 'Rafael', 'Fernández', '1992-12-06', 30, '04269998877', 'Maracay', '1', '1'),
(18, 67894512, 'Gabriela', 'López', '1987-04-17', 36, '04125556699', 'Barquisimeto', '1', '1'),
(19, 45127896, 'Santiago', 'Díaz', '1999-08-10', 24, '04265554433', 'Maracaibo', '1', '1'),
(21, 15956458, 'Alicia', 'Rodriguez', '1987-11-04', 35, '04128495623', 'San Ignacio', '1', '1'),
(23, 25849652, 'Milagros', 'Rosales', '1999-11-04', 24, '04265456787', 'La Victoria', '1', '1'),
(24, 22345321, 'Mariana', 'Gonzalez', '2000-10-10', 23, '04125145646', 'San Juan', '3', '1'),
(27, 15849652, 'José', 'Ramón', '1987-10-04', 42, '0412364532', 'Caracas', '4', '1'),
(28, 23456432, 'Miguel', 'Flores', '2000-08-15', 23, '04128459962', 'Paraparal', '1', '1'),
(29, 23145654, 'Mónica', 'Guerrero', '2001-03-10', 22, '04125434545', '23 de enero', '1', '1'),
(30, 23454321, 'Jordan', 'Perez', '2002-10-06', 21, '04122123453', 'Montana Fresca', '3', '1'),
(31, 1985743, 'Sarah', 'López', '1995-05-03', 28, '04122312341', 'El Limon', '3', '1'),
(32, 12313123, 'María José', 'González Moraima', '2001-03-27', 22, '04125454548', 'C', '3', '1'),
(33, 21224242, 'Juan Miguel', 'López', '2001-02-13', 22, '04122141241', 'Montaña Fresca', '3', '1'),
(34, 9213827, 'Sofía', 'Reyes', '1967-07-22', 56, '04122381728', 'San Jacinto', '3', '1'),
(35, 55555555, 'Roberto', 'Perez', '1980-03-18', 42, '04162345678', 'Maracay', '3', '1'),
(36, 11112222, 'Isabella', 'Martinez', '2000-12-05', 22, '04261234567', 'Barquisimeto', '3', '1'),
(37, 44443333, 'Alejandro', 'Lopez', '1988-06-30', 34, '04121234567', 'San Cristobal', '3', '1'),
(38, 77778888, 'Ana', 'Ramirez', '1995-02-14', 27, '04265456787', 'Merida', '3', '1'),
(39, 66669999, 'Fernando', 'Hernandez', '1982-09-22', 40, '04121234567', 'Puerto La Cruz', '3', '1'),
(40, 88887777, 'Marina', 'Castillo', '1993-04-08', 29, '04261234567', 'Guayana', '3', '1'),
(41, 55554444, 'Elena', 'Ortega', '1991-01-25', 31, '04261234567', 'Porlamar', '3', '1'),
(42, 12349999, 'Luis', 'Sanchez', '1982-07-17', 40, '04162345678', 'Cumaná', '3', '1'),
(43, 11113333, 'Gabriel', 'Gutierrez', '1986-12-03', 35, '04121234567', 'Barquisimeto', '3', '1'),
(44, 22221111, 'Mariana', 'Lopez', '1988-05-20', 33, '04161234567', 'Caracas', '3', '1'),
(45, 33332222, 'Raul', 'Gomez', '1990-09-12', 31, '04261234567', 'Valencia', '3', '1'),
(46, 66665555, 'Ana', 'Ramirez', '1995-02-14', 27, '04265456787', 'Merida', '3', '1'),
(47, 77776666, 'Fernanda', 'Hernandez', '1987-09-22', 35, '04121234567', 'Puerto La Cruz', '3', '1'),
(48, 99998888, 'Luis', 'Sanchez', '1991-01-25', 31, '04261234567', 'Porlamar', '3', '1'),
(49, 12453321, 'Carlos', 'Fernandez', '1985-03-18', 37, '04162345678', 'Maracay', '3', '1'),
(50, 28561234, 'Carla', 'Gomez', '1990-06-15', 32, '04121234567', 'Caracas', '3', '1'),
(51, 19876543, 'Juan', 'Lopez', '1985-02-20', 37, '04231234567', 'Maracay', '3', '1'),
(52, 42123453, 'Luisa', 'Martinez', '1982-11-10', 41, '04141234567', 'Valencia', '3', '1'),
(53, 87654121, 'Pedro', 'Rodriguez', '1993-04-25', 29, '04221234567', 'Barquisimeto', '3', '1'),
(54, 65432198, 'Maria', 'Perez', '1998-09-18', 25, '04151234567', 'Merida', '3', '1'),
(55, 56789012, 'Carlos', 'Garcia', '1987-07-30', 34, '04251234567', 'San Cristobal', '3', '1'),
(56, 43210987, 'Ana', 'Hernandez', '1995-12-05', 27, '04161234567', 'Puerto Ordaz', '3', '1'),
(57, 10987654, 'Jorge', 'Fernandez', '1984-03-12', 38, '04261234567', 'Cumaná', '3', '1'),
(58, 76543210, 'Laura', 'Ramirez', '1991-08-22', 31, '04171234567', 'Maracaibo', '3', '1'),
(59, 32109876, 'Raul', 'Torres', '1996-05-14', 26, '04271234567', 'Trujillo', '3', '1'),
(60, 28561235, 'Andres', 'Gutierrez', '1988-04-10', 34, '04121234568', 'Los Teques', '3', '1'),
(61, 19876544, 'Sara', 'Ramirez', '1992-01-25', 30, '04231234568', 'Guarenas', '3', '1'),
(62, 12345679, 'Luis', 'Garcia', '1980-09-12', 41, '04141234568', 'Carabobo', '3', '1'),
(63, 87654322, 'Eva', 'Fernandez', '1994-07-18', 28, '04221234568', 'Maracay', '3', '1'),
(64, 65432199, 'Hector', 'Castro', '1997-03-05', 25, '04151234568', 'Barquisimeto', '3', '1'),
(65, 56789013, 'Ana', 'Martinez', '1986-11-30', 36, '04251234568', 'Los Teques', '3', '1'),
(66, 43210988, 'Jose', 'Gutierrez', '1999-04-22', 24, '04161234568', 'Puerto Cabello', '3', '1'),
(67, 10987655, 'Marta', 'Hernandez', '1983-05-15', 39, '04261234568', 'Guatire', '3', '1'),
(68, 76543211, 'Carlos', 'Perez', '1990-08-23', 32, '04171234568', 'Acarigua', '3', '1'),
(69, 32109877, 'Laura', 'Gomez', '1995-12-10', 27, '04271234568', 'Barinas', '3', '1'),
(70, 28561236, 'Gabriel', 'Perez', '1989-03-20', 33, '04121234569', 'Caracas', '3', '1'),
(71, 43210989, 'Carlos', 'Fernandez', '1992-03-28', 30, '04191234563', 'Maracay', '3', '1'),
(72, 10987656, 'Laura', 'Ramirez', '1985-08-15', 37, '04281234562', 'Caracas', '3', '1'),
(73, 32109878, 'Juan', 'Gutierrez', '1987-12-10', 35, '04171234561', 'Los Teques', '3', '1'),
(74, 76543201, 'Ana', 'Lopez', '1990-05-22', 32, '04271234560', 'San Antonio', '3', '1'),
(75, 43210990, 'Carlos', 'Fernandez', '1995-02-28', 27, '04191234567', 'Caracas', '3', '1'),
(76, 10987657, 'Eva', 'Martinez', '1983-12-15', 39, '04281234566', 'Los Teques', '3', '1'),
(77, 32109879, 'Luis', 'Gomez', '1988-06-25', 34, '04171234565', 'Maracay', '3', '1'),
(78, 76543202, 'Marta', 'Hernandez', '1991-09-12', 31, '04271234564', 'Valencia', '3', '1'),
(79, 76543204, 'Marta', 'Hernandez', '1991-09-12', 31, '04271234573', 'Valencia', '3', '1'),
(80, 32109881, 'Luis', 'Gomez', '1988-06-25', 34, '04171234574', 'Maracay', '3', '1'),
(81, 10987659, 'Eva', 'Martinez', '1983-12-15', 39, '04281234575', 'Los Teques', '3', '1'),
(82, 12343211, 'Julio', 'Antonio', '2010-10-12', 13, '4564545', '23 de Enero', '4', '1'),
(83, 22345321, 'Mariio', 'Carlos', '2017-06-17', 6, '2235544', 'campo alegre', '4', '1'),
(84, 12345645, 'Vanessa', 'Rodríguez', '2006-05-30', 17, '04122312341', 'Campo Alegre', '4', '1'),
(85, 12343211, 'Isabela', 'Carrasco', '2010-10-13', 13, '4564545', 'Campo Alegre', '4', '1'),
(86, 23454455, 'Roger Ojeda', 'Solozano Hernández', '1990-03-21', 34, '04122321234', 'San Vicente', '1', '2');

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
-- Volcado de datos para la tabla `paciente_beneficiado`
--

INSERT INTO `paciente_beneficiado` (`paciente_beneficiado_id`, `paciente_id`, `estatus_pac`) VALUES
(6, 27, '1'),
(7, 82, '1'),
(8, 83, '1'),
(9, 84, '1'),
(10, 85, '1');

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
-- Volcado de datos para la tabla `paciente_seguro`
--

INSERT INTO `paciente_seguro` (`paciente_seguro_id`, `paciente_id`, `seguro_id`, `empresa_id`, `tipo_seguro`, `cobertura_general`, `fecha_contra`, `saldo_disponible`, `estatus_pac`) VALUES
(9, 30, 2, 1, '1', 3000, '2021-10-10', 3000, '1'),
(10, 31, 1, 2, '1', 3000, '2021-02-02', 3000, '1'),
(12, 32, 9, 11, '1', 1000, '2023-05-31', 1000, '1'),
(13, 33, 1, 1, '1', 3500, '2019-07-25', 3500, '1'),
(14, 34, 1, 1, '1', 4680, '2021-01-11', 2100, '1'),
(15, 35, 1, 1, '1', 2200, '2023-08-10', 2000, '1'),
(16, 36, 1, 1, '1', 2000, '2023-10-20', 2500, '1'),
(17, 37, 1, 1, '1', 1600, '2023-09-05', 2100, '1'),
(18, 38, 1, 1, '1', 1900, '2023-09-15', 2300, '1'),
(19, 39, 1, 1, '1', 1700, '2023-11-03', 2000, '1'),
(20, 40, 1, 1, '1', 2100, '2023-10-05', 2400, '1'),
(21, 41, 1, 1, '1', 2100, '2023-10-05', 2400, '1'),
(22, 42, 3, 9, '1', 2100, '2022-12-15', 2000, '1'),
(23, 43, 3, 9, '1', 1800, '2023-09-15', 2100, '1'),
(24, 44, 8, 9, '1', 2000, '2023-08-10', 1800, '1'),
(25, 45, 8, 9, '1', 1900, '2023-11-02', 2200, '1'),
(26, 46, 8, 9, '1', 1700, '2023-09-20', 2200, '1'),
(27, 47, 8, 9, '1', 2000, '2023-10-30', 1900, '1'),
(28, 48, 8, 9, '1', 1800, '2023-09-15', 2100, '1'),
(29, 49, 2, 10, '1', 2200, '2023-10-20', 2000, '1'),
(30, 50, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(31, 51, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(32, 52, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(33, 53, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(34, 54, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(35, 55, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(36, 56, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(37, 57, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(38, 58, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(39, 59, 2, 10, '1', 1800, '2023-09-05', 2100, '1'),
(40, 60, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(41, 61, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(42, 62, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(43, 63, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(44, 64, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(45, 65, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(46, 66, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(47, 67, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(48, 68, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(49, 69, 12, 6, '1', 2000, '2023-10-15', 2200, '1'),
(50, 70, 10, 8, '1', 2200, '2023-11-01', 2300, '1'),
(51, 70, 9, 8, '1', 5200, '2023-11-01', 3300, '1'),
(52, 71, 2, 4, '1', 1800, '2023-09-05', 2100, '1'),
(53, 72, 2, 4, '1', 1800, '2023-09-05', 2100, '1'),
(54, 73, 2, 4, '1', 1800, '2023-09-05', 2100, '1'),
(55, 74, 2, 4, '1', 1800, '2023-09-05', 2100, '1'),
(56, 75, 2, 5, '1', 2200, '2023-11-01', 2300, '1'),
(57, 76, 2, 5, '1', 2200, '2023-11-01', 2300, '1'),
(58, 77, 2, 5, '1', 2200, '2023-11-01', 2300, '1'),
(59, 78, 2, 5, '1', 2200, '2023-11-01', 2300, '1'),
(60, 79, 10, 10, '1', 2200, '2023-11-01', 2300, '1'),
(61, 80, 10, 10, '1', 2200, '2023-11-01', 2300, '1'),
(62, 81, 10, 10, '1', 2200, '2023-11-01', 2300, '1'),
(63, 24, 3, 7, '1', 2500, '2023-11-27', 2500, '1');

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
-- Volcado de datos para la tabla `pregunta_seguridad`
--

INSERT INTO `pregunta_seguridad` (`pregunta_id`, `usuario_id`, `pregunta`, `respuesta`, `estatus_pre`) VALUES
(1, 1, '1', 'amarillo', '1'),
(2, 1, '3', 'perez', '1'),
(3, 1, '5', 'dibujar', '1'),
(4, 2, '1', 'amarillo', '1'),
(5, 2, '3', 'perez', '1'),
(6, 2, '5', 'dibujar', '1'),
(7, 3, '1', 'amarillo', '1'),
(8, 3, '3', 'perez', '1'),
(9, 3, '5', 'dibujar', '1'),
(10, 4, '1', 'amarillo', '1'),
(11, 4, '2', 'rocky', '1'),
(12, 4, '3', 'no tiene', '1'),
(13, 5, '1', 'amarillo', '1'),
(14, 5, '3', 'perez', '1'),
(15, 5, '2', 'rocky', '1');

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
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_id`, `nombre`, `ubicacion`, `estatus_pro`) VALUES
(1, 'Industrias Modernas S.A', 'San Rafael', '1'),
(2, 'Comercial del Sur C.A', 'Santa Clara', '1'),
(3, 'Tecnologías Avanzadas Ltda', 'Los Pinos', '1'),
(4, 'Servicios Empresariales Unidos', 'El Bosque', '1'),
(5, 'Productos Innovadores S.R.L', 'La Estrella', '1'),
(6, 'Constructora del Valle C.A', 'Valle Hermoso', '1'),
(7, 'Importadora Internacional S.A', 'Ciudad del Este', '1'),
(8, 'Consultores Asociados C.A', 'Miraflores', '1'),
(9, 'Inversiones del Caribe Ltda', 'Bahía Azul', '1'),
(10, 'Distribuidora Nacional C.A', 'Villa Nueva', '1'),
(11, 'Innovatech Solutions Inc', 'Nuevo Horizonte', '1'),
(12, 'Logística Integrada C.A', 'El Rosal', '1'),
(13, 'Automotores del Norte C.A', 'Ciudad Real', '1'),
(14, 'Inversiones Santa Fe Ltda', 'Santa Fe', '1'),
(15, 'Mega Alimentos S.A', 'La Granja', '1'),
(16, 'Construcciones Metropolitanas C.A', 'Metropolis', '1'),
(17, 'Textiles del Sur S.R.L', 'Villa del Sur', '1'),
(18, 'Almacenes Express C.A', 'Expressville', '1'),
(19, 'Exportaciones del Caribe Ltda', 'Caribe Plaza', '1'),
(20, 'Servicios Tecnológicos Globales', 'Global City', '1'),
(21, 'Proveedores Médicos C.A', 'Cagua', '1'),
(22, 'proveedor de prueba a', 'prueba a', '2'),
(23, 'proveedor de prueba b', 'prueba b', '2'),
(24, 'proveedor de prueba c', 'prueba c', '2'),
(25, 'Proveedor de auditoría', '23 e enero', '2');

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
  `porcentaje` int(11) NOT NULL,
  `costo_consulta` int(11) NOT NULL,
  `maximo_dias` int(11) NOT NULL DEFAULT 15,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguro`
--

INSERT INTO `seguro` (`seguro_id`, `nombre`, `rif`, `direccion`, `telefono`, `porcentaje`, `costo_consulta`, `maximo_dias`, `estatus_seg`) VALUES
(1, 'Seguros Qualitas', 'J-234235543', 'Caracas', '04124567654', 34, 25, 15, '1'),
(2, 'Seguros Ramires', 'J-233424321', '23 de enero', '04121234653', 25, 32, 15, '1'),
(3, 'Seguros del Valle', 'J-232131231', 'Brisas del Lago', '04121321231', 20, 30, 15, '1'),
(4, 'Seguros Pirámide', 'J-123412312', 'Caracas', '04122123442', 50, 20, 15, '1'),
(8, 'Mercantil Seguros', 'J-85496258', 'Caracas', '04125473945', 40, 17, 15, '1'),
(9, 'Caracas C.A', 'J-231231231', 'Distrito Federal D.F', '04123242351', 25, 12, 15, '1'),
(10, 'Mapfre C.A', 'J-214234124', 'Valencia', '04161414123', 18, 15, 15, '1'),
(11, 'Estar Seguros C.A', 'J-155641814', 'Cagua', '04243278432', 15, 18, 15, '1'),
(12, 'Seguros Constitución', 'J-234523524', 'Maracay', '04145158483', 30, 25, 15, '1'),
(13, 'Hispana de Seguros', 'J-893457893', 'Maracaibo', '04121234423', 20, 20, 15, '1'),
(14, 'Seguro de test', 'J-324345554', '23 de enero', '04127874565', 15, 25, 15, '1');

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
-- Volcado de datos para la tabla `seguro_empresa`
--

INSERT INTO `seguro_empresa` (`seguro_empresa_id`, `empresa_id`, `seguro_id`, `estatus_seg`) VALUES
(1, 1, 1, '1'),
(2, 1, 2, '1'),
(3, 2, 1, '1'),
(7, 4, 2, '1'),
(8, 5, 2, '1'),
(9, 5, 4, '1'),
(10, 6, 9, '1'),
(11, 6, 12, '1'),
(12, 7, 3, '1'),
(13, 7, 9, '1'),
(14, 8, 8, '1'),
(15, 8, 9, '1'),
(16, 8, 10, '1'),
(17, 9, 1, '1'),
(18, 9, 3, '1'),
(19, 9, 8, '1'),
(20, 10, 2, '1'),
(21, 10, 4, '1'),
(22, 10, 10, '1'),
(23, 11, 9, '1'),
(24, 11, 12, '1'),
(25, 11, 13, '1'),
(26, 12, 1, '1'),
(27, 12, 9, '1'),
(28, 12, 13, '1'),
(29, 13, 1, '1'),
(30, 13, 3, '1'),
(31, 13, 13, '1'),
(32, 14, 2, '1'),
(33, 14, 4, '1'),
(34, 14, 10, '1'),
(35, 15, 8, '1'),
(36, 15, 10, '1'),
(37, 15, 13, '1'),
(38, 16, 1, '1'),
(39, 16, 2, '1'),
(40, 16, 8, '1'),
(41, 17, 2, '1'),
(42, 17, 4, '1'),
(43, 17, 12, '1'),
(44, 18, 1, '1'),
(45, 18, 8, '1'),
(46, 18, 9, '1'),
(47, 18, 13, '1'),
(48, 11, 4, '1'),
(49, 19, 3, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro_examen`
--

CREATE TABLE `seguro_examen` (
  `seguro_examen_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `examenes` text NOT NULL,
  `costos` text NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguro_examen`
--

INSERT INTO `seguro_examen` (`seguro_examen_id`, `seguro_id`, `examenes`, `costos`, `estatus_seg`) VALUES
(1, 1, '1,2,3,6,19,17,10', '30,20,25,15,45,28,13', '1'),
(2, 2, '1,2,9,17,21,23,34', '25,24,35,18,28,18,18', '1'),
(3, 3, '1,2,12,9,15', '25,25,23,15,27', '1'),
(4, 4, '1,3,2', '28,12,12', '1'),
(7, 8, '14,25,9', '25,35,25', '1'),
(8, 9, '3,9,12,10,17,19,23,28,32,1,2', '20,20,15,28,30,50,35,40,28,16,20', '1'),
(9, 10, '6,14,19,9,23,34,34', '25,26,28,25,13,17,14', '1'),
(10, 11, '3,9,23', '15,18,17', '1'),
(11, 12, '6,19,25,30,28', '23,28,23,26,17', '1'),
(12, 13, '32,10,17,23,28', '17,16,15,18,15', '1'),
(13, 14, '3,6', '12,12', '1');

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
-- Volcado de datos para la tabla `tipo_antecedente`
--

INSERT INTO `tipo_antecedente` (`tipo_antecedente_id`, `nombre`, `fecha_creacion`, `estatus_tip`) VALUES
(1, 'Antecedentes Patológicos', '2023-05-28 23:51:47', '1'),
(2, 'Antecedentes Psicológicos', '2023-05-28 23:51:47', '1'),
(3, 'Antecedentes médicos familiares', '2023-05-28 23:51:47', '1'),
(4, 'Cirugías o traumatismos', '2023-05-28 23:51:47', '1'),
(5, 'Alergias', '2023-05-28 23:51:47', '1'),
(6, 'Reacción a medicamentos', '2023-05-28 23:51:47', '1'),
(7, 'Enfermedades Padecidas', '2023-05-28 23:51:47', '1'),
(8, 'Tratamientos', '2023-05-28 23:51:47', '1'),
(9, 'Hábitos de salud', '2023-05-28 23:51:47', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titular_beneficiado`
--

CREATE TABLE `titular_beneficiado` (
  `titular_beneficiado_id` int(11) NOT NULL,
  `paciente_beneficiado_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_tit` enum('1','2') NOT NULL DEFAULT '1',
  `tipo_relacion` enum('1','2') NOT NULL,
  `tipo_familiar` enum('1','2','3','4',' 5','6') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `titular_beneficiado`
--

INSERT INTO `titular_beneficiado` (`titular_beneficiado_id`, `paciente_beneficiado_id`, `paciente_id`, `estatus_tit`, `tipo_relacion`, `tipo_familiar`) VALUES
(18, 6, 24, '1', '2', '1'),
(19, 7, 3, '1', '2', '1'),
(20, 8, 24, '1', '2', '3'),
(21, 9, 31, '1', '2', '4'),
(22, 10, 3, '1', '2', '3');

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
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `nombre`, `clave`, `tokken`, `rol`, `pin`, `estatus_usu`, `fecha_creacion`) VALUES
(1, 'Francis', '$2y$10$qUQbE.PKDVs2yt618RZrXeHzyII58wj040wI943WS8Bw8H/KqYxOm', 'e0c48b3342', 1, '$2y$10$VdmseZ1c7eMINwubw0aY7ulFN681iD7un5W2g.73LmPav5pP8IAGm', '1', '2023-10-14 11:29:39'),
(2, 'Maria', '$2y$10$JzsAaRD3HjqWmQuhgJCoheZwKBOwvW1/QxhKT1ienyVo1itr/qSGy', NULL, 3, '$2y$10$lIL/kC5QKpnrBFIhxpUOSeaFtM2qOkOz5IVfkRN7niMgufkqy.xxW', '1', '2023-10-14 11:30:03'),
(3, 'Juan', '$2y$10$y2nP.bNOXOv7D9MBaA.0cOXcQ6qSnevvkae.vuqcbWbhjy.rZFpfy', NULL, 4, '$2y$10$P5UN5gCK8i9z6y.80uofx.k4HMtC.Q3Rh3ZJowSzUJccEXkA2nYdK', '1', '2023-10-14 11:34:17'),
(4, 'Oriana', '$2y$10$mM1EP2DjJb0rWFddt97V/Oxe1FG75XCTu9KcffW7ipOd2QXFWRwFe', NULL, 2, '$2y$10$mqrXDImYH4GcA5RNxoYFXepssHuWpELbEC8PPNaHrn16axVfhFFLS', '1', '2024-04-05 04:12:53'),
(5, 'Enrique', '$2y$10$CgS7tzG4SiwxA0/x8qUC9uU/qIsuaPXPu/IqwBG2X2E9ELUXbhPEe', NULL, 2, '$2y$10$MzpZREpNfO6cXEkzUA/BTedpK2PVVQrHeco3QINS/I3JYpmw2sI3S', '1', '2024-04-05 04:27:49');

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
  ADD PRIMARY KEY (`auditoria_id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`cita_id`),
  ADD KEY `especialidad_id` (`especialidad_id`),
  ADD KEY `medico_id` (`medico_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `cita_examen`
--
ALTER TABLE `cita_examen`
  ADD PRIMARY KEY (`cita_examen_id`),
  ADD KEY `cita_id` (`cita_id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indices de la tabla `cita_seguro`
--
ALTER TABLE `cita_seguro`
  ADD PRIMARY KEY (`cita_seguro_id`),
  ADD KEY `cita_id` (`cita_id`),
  ADD KEY `seguro_id` (`seguro_id`);

--
-- Indices de la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  ADD PRIMARY KEY (`compra_insumo_id`),
  ADD KEY `insumo_id` (`insumo_id`),
  ADD KEY `factura_compra_id` (`factura_compra_id`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`consulta_id`);

--
-- Indices de la tabla `consulta_cita`
--
ALTER TABLE `consulta_cita`
  ADD PRIMARY KEY (`consulta_cita_id`),
  ADD KEY `cita_id` (`cita_id`),
  ADD KEY `consulta_id` (`consulta_id`);

--
-- Indices de la tabla `consulta_emergencia`
--
ALTER TABLE `consulta_emergencia`
  ADD PRIMARY KEY (`consulta_emergencia_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `seguro_id` (`seguro_id`);

--
-- Indices de la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  ADD PRIMARY KEY (`consulta_examen_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `examen_id` (`examen_id`);

--
-- Indices de la tabla `consulta_indicaciones`
--
ALTER TABLE `consulta_indicaciones`
  ADD PRIMARY KEY (`consulta_indicaciones_id`),
  ADD KEY `consulta_id` (`consulta_id`);

--
-- Indices de la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  ADD PRIMARY KEY (`consulta_insumo_id`),
  ADD KEY `insumo_id` (`insumo_id`),
  ADD KEY `consulta_id` (`consulta_id`);

--
-- Indices de la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  ADD PRIMARY KEY (`consulta_recipe_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `medicamento_id` (`medicamento_id`);

--
-- Indices de la tabla `consulta_referidos`
--
ALTER TABLE `consulta_referidos`
  ADD PRIMARY KEY (`consulta_referidos_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `especialidad_id` (`especialidad_id`);

--
-- Indices de la tabla `consulta_seguro`
--
ALTER TABLE `consulta_seguro`
  ADD PRIMARY KEY (`consulta_seguro_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `seguro_id` (`seguro_id`);

--
-- Indices de la tabla `consulta_sin_cita`
--
ALTER TABLE `consulta_sin_cita`
  ADD PRIMARY KEY (`consulta_sin_cita_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `especialidad_id` (`especialidad_id`),
  ADD KEY `medico_id` (`medico_id`),
  ADD KEY `paciente_id` (`paciente_id`);

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
-- Indices de la tabla `examen_especialidad`
--
ALTER TABLE `examen_especialidad`
  ADD PRIMARY KEY (`examen_especialidad_id`),
  ADD KEY `examen_id` (`examen_id`),
  ADD KEY `especialidad_id` (`especialidad_id`);

--
-- Indices de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD PRIMARY KEY (`factura_compra_id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  ADD PRIMARY KEY (`factura_consulta_id`),
  ADD KEY `consulta_id` (`consulta_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  ADD PRIMARY KEY (`factura_medico_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Indices de la tabla `factura_mensajeria`
--
ALTER TABLE `factura_mensajeria`
  ADD PRIMARY KEY (`factura_mensajeria_id`),
  ADD KEY `fk_mensajeria_seguro` (`seguro_id`);

--
-- Indices de la tabla `factura_mensajeria_consultas`
--
ALTER TABLE `factura_mensajeria_consultas`
  ADD PRIMARY KEY (`factura_mensajeria_consultas_id`),
  ADD KEY `fk_mensajeria_consultas` (`consulta_seguro_id`),
  ADD KEY `factura_mensajeria_id` (`factura_mensajeria_id`);

--
-- Indices de la tabla `factura_seguro`
--
ALTER TABLE `factura_seguro`
  ADD PRIMARY KEY (`factura_seguro_id`),
  ADD KEY `seguro_id` (`seguro_id`);

--
-- Indices de la tabla `global`
--
ALTER TABLE `global`
  ADD PRIMARY KEY (`global_id`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`horario_id`),
  ADD KEY `medico_id` (`medico_id`);

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
  ADD KEY `medico_id` (`medico_id`),
  ADD KEY `especialidad_id` (`especialidad_id`);

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
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  ADD PRIMARY KEY (`paciente_seguro_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `seguro_id` (`seguro_id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  ADD PRIMARY KEY (`pregunta_id`),
  ADD KEY `usuario_id` (`usuario_id`);

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
  ADD KEY `empresa_id` (`empresa_id`),
  ADD KEY `seguro_id` (`seguro_id`);

--
-- Indices de la tabla `seguro_examen`
--
ALTER TABLE `seguro_examen`
  ADD PRIMARY KEY (`seguro_examen_id`),
  ADD KEY `seguro_id` (`seguro_id`);

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
  ADD KEY `paciente_beneficiado_id` (`paciente_beneficiado_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedentes_medicos`
--
ALTER TABLE `antecedentes_medicos`
  MODIFY `antecedentes_medicos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `auditoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `cita_examen`
--
ALTER TABLE `cita_examen`
  MODIFY `cita_examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `cita_seguro`
--
ALTER TABLE `cita_seguro`
  MODIFY `cita_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  MODIFY `compra_insumo_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `consulta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT de la tabla `consulta_cita`
--
ALTER TABLE `consulta_cita`
  MODIFY `consulta_cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `consulta_emergencia`
--
ALTER TABLE `consulta_emergencia`
  MODIFY `consulta_emergencia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  MODIFY `consulta_examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `consulta_indicaciones`
--
ALTER TABLE `consulta_indicaciones`
  MODIFY `consulta_indicaciones_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  MODIFY `consulta_insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  MODIFY `consulta_recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `consulta_referidos`
--
ALTER TABLE `consulta_referidos`
  MODIFY `consulta_referidos_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `consulta_seguro`
--
ALTER TABLE `consulta_seguro`
  MODIFY `consulta_seguro_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `consulta_sin_cita`
--
ALTER TABLE `consulta_sin_cita`
  MODIFY `consulta_sin_cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `examen_especialidad`
--
ALTER TABLE `examen_especialidad`
  MODIFY `examen_especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `factura_compra_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  MODIFY `factura_consulta_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  MODIFY `factura_medico_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `factura_mensajeria`
--
ALTER TABLE `factura_mensajeria`
  MODIFY `factura_mensajeria_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura_mensajeria_consultas`
--
ALTER TABLE `factura_mensajeria_consultas`
  MODIFY `factura_mensajeria_consultas_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura_seguro`
--
ALTER TABLE `factura_seguro`
  MODIFY `factura_seguro_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `global`
--
ALTER TABLE `global`
  MODIFY `global_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `horario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `medicamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `medico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  MODIFY `medico_especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `paciente_beneficiado`
--
ALTER TABLE `paciente_beneficiado`
  MODIFY `paciente_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  MODIFY `paciente_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `seguro`
--
ALTER TABLE `seguro`
  MODIFY `seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `seguro_empresa`
--
ALTER TABLE `seguro_empresa`
  MODIFY `seguro_empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `seguro_examen`
--
ALTER TABLE `seguro_examen`
  MODIFY `seguro_examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `titular_beneficiado`
--
ALTER TABLE `titular_beneficiado`
  MODIFY `titular_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita_examen`
--
ALTER TABLE `cita_examen`
  ADD CONSTRAINT `cita_examen_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cita_examen_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita_seguro`
--
ALTER TABLE `cita_seguro`
  ADD CONSTRAINT `cita_seguro_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cita_seguro_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  ADD CONSTRAINT `compra_insumo_ibfk_1` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `compra_insumo_ibfk_2` FOREIGN KEY (`factura_compra_id`) REFERENCES `factura_compra` (`factura_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_cita`
--
ALTER TABLE `consulta_cita`
  ADD CONSTRAINT `consulta_cita_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_cita_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_emergencia`
--
ALTER TABLE `consulta_emergencia`
  ADD CONSTRAINT `consulta_emergencia_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_emergencia_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_emergencia_ibfk_3` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  ADD CONSTRAINT `consulta_examen_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_examen_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_indicaciones`
--
ALTER TABLE `consulta_indicaciones`
  ADD CONSTRAINT `consulta_indicaciones_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  ADD CONSTRAINT `consulta_insumo_ibfk_1` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_insumo_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  ADD CONSTRAINT `consulta_recipe_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_recipe_ibfk_2` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamento` (`medicamento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_referidos`
--
ALTER TABLE `consulta_referidos`
  ADD CONSTRAINT `consulta_referidos_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_referidos_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_seguro`
--
ALTER TABLE `consulta_seguro`
  ADD CONSTRAINT `consulta_seguro_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_seguro_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_sin_cita`
--
ALTER TABLE `consulta_sin_cita`
  ADD CONSTRAINT `consulta_sin_cita_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_sin_cita_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_sin_cita_ibfk_3` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_sin_cita_ibfk_4` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `examen_especialidad`
--
ALTER TABLE `examen_especialidad`
  ADD CONSTRAINT `examen_especialidad_ibfk_1` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `examen_especialidad_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD CONSTRAINT `factura_compra_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  ADD CONSTRAINT `factura_consulta_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `factura_consulta_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  ADD CONSTRAINT `factura_medico_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_mensajeria`
--
ALTER TABLE `factura_mensajeria`
  ADD CONSTRAINT `fk_mensajeria_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_mensajeria_consultas`
--
ALTER TABLE `factura_mensajeria_consultas`
  ADD CONSTRAINT `factura_mensajeria_consultas_ibfk_1` FOREIGN KEY (`consulta_seguro_id`) REFERENCES `consulta_seguro` (`consulta_seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `factura_mensajeria_consultas_ibfk_2` FOREIGN KEY (`factura_mensajeria_id`) REFERENCES `factura_mensajeria` (`factura_mensajeria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_seguro`
--
ALTER TABLE `factura_seguro`
  ADD CONSTRAINT `factura_seguro_ibfk_1` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD CONSTRAINT `medico_especialidad_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `medico_especialidad_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paciente_beneficiado`
--
ALTER TABLE `paciente_beneficiado`
  ADD CONSTRAINT `paciente_beneficiado_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  ADD CONSTRAINT `paciente_seguro_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `paciente_seguro_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `paciente_seguro_ibfk_3` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  ADD CONSTRAINT `pregunta_seguridad_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seguro_empresa`
--
ALTER TABLE `seguro_empresa`
  ADD CONSTRAINT `seguro_empresa_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `seguro_empresa_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seguro_examen`
--
ALTER TABLE `seguro_examen`
  ADD CONSTRAINT `seguro_examen_ibfk_1` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `titular_beneficiado`
--
ALTER TABLE `titular_beneficiado`
  ADD CONSTRAINT `titular_beneficiado_ibfk_1` FOREIGN KEY (`paciente_beneficiado_id`) REFERENCES `paciente_beneficiado` (`paciente_beneficiado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `titular_beneficiado_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
