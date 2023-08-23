-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2023 a las 02:42:48
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
(4, 7, 4, 'Alergia al polvo, a la tierra y al amarillo #5', '1', '2023-05-28 23:20:31'),
(7, 7, 5, 'Alergia al polen', '1', '2023-05-30 01:20:09'),
(27, 7, 3, 'Alergia al ibuprofeno', '1', '2023-05-30 01:20:28'),
(30, 7, 2, 'Quimios', '1', '2023-05-30 01:20:49');

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
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`cita_id`, `paciente_id`, `medico_id`, `especialidad_id`, `fecha_cita`, `hora_salida`, `hora_entrada`, `motivo_cita`, `cedula_titular`, `tipo_cita`, `estatus_cit`) VALUES
(27, 11, 9, 9, '2023-06-22', '09:50:00', '08:50:00', 'dolor de cabeza', 18956458, '2', '3'),
(28, 7, 9, 9, '2023-06-22', '10:00:00', '09:51:00', 'dolor de cabeza', 18954458, '1', '1'),
(29, 14, 11, 11, '2023-07-17', '10:00:00', '09:51:00', 'dolor de webo', 25369123, '2', '4');

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
(5, 27, 5, 'clave'),
(6, 29, 5, 'sdawa3');

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
-- Volcado de datos para la tabla `compra_insumo`
--

INSERT INTO `compra_insumo` (`compra_insumo_id`, `insumo_id`, `factura_compra_id`, `unidades`, `precio_unit`, `precio_total`) VALUES
(000000013, 3, 9, 8, 1, 0),
(000000014, 4, 10, 2, 4, 0),
(000000015, 3, 10, 4, 2.5, 0),
(000000016, 5, 10, 1, 10, 0),
(000000017, 4, 11, 2, 4, 0),
(000000018, 3, 11, 4, 2.5, 0),
(000000019, 5, 11, 1, 10, 0),
(000000020, 4, 12, 2, 4, 0),
(000000021, 3, 12, 4, 2.5, 0),
(000000022, 5, 12, 1, 10, 0),
(000000023, 4, 14, 1, 2, 2);

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
  `estatus_con` enum('1','2','3') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`consulta_id`, `peso`, `altura`, `observaciones`, `fecha_consulta`, `es_emergencia`, `estatus_con`) VALUES
(60, 12.4, 12.6, 'dolor de cabeza', '2023-08-23', 0, '1'),
(61, 12.4, 12.6, 'dolor de cabeza', '2023-08-23', 0, '1'),
(65, 12.4, 12.6, NULL, '2023-08-23', 0, '1'),
(71, 12.4, 12.6, 'dolor de cabeza', '2023-08-23', 0, '1'),
(77, 72.4, 12.6, NULL, '2023-07-25', 0, '1'),
(80, 12.4, 12.6, 'dolor de cabeza', '2023-08-23', 0, '1'),
(81, 12.4, 12.6, 'dolor de cabeza', '2023-08-23', 0, '1'),
(90, 12.4, 12.6, 'dolor de cabeza', '2023-08-23', 0, '1');

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
(4, 28, 65, '1'),
(10, 29, 77, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_emergencia`
--

CREATE TABLE `consulta_emergencia` (
  `consulta_emergencia_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `consultas_medicas` float NOT NULL,
  `Laboratorios` float DEFAULT NULL,
  `medicamentos` float DEFAULT NULL,
  `area_observacion` float DEFAULT NULL,
  `enfermeria` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Volcado de datos para la tabla `consulta_examen`
--

INSERT INTO `consulta_examen` (`consulta_examen_id`, `consulta_id`, `examen_id`, `estatus_con`) VALUES
(7, 71, 4, '1'),
(8, 77, 4, '1'),
(9, 80, 4, '1'),
(10, 81, 4, '1');

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
(1, 51, 'Usar protector solar de 50 FPS'),
(2, 51, 'Usar jabón BIOS'),
(3, 50, 'Usar protector solar de 50 FPS'),
(4, 50, 'Usar jabón BIOS'),
(5, 52, 'Usar protector solar de 30 FPS'),
(6, 52, 'Usar jabón BIOS'),
(7, 71, 'Usar protector solar de 30 FPS'),
(8, 77, 'Usar protector solar de 30 FPS'),
(9, 80, 'Usar protector solar de 30 FPS'),
(10, 81, 'Usar protector solar de 30 FPS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_insumo`
--

CREATE TABLE `consulta_insumo` (
  `consulta_insumo_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `cantidad` int(8) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consulta_insumo`
--

INSERT INTO `consulta_insumo` (`consulta_insumo_id`, `insumo_id`, `consulta_id`, `cantidad`, `estatus_con`) VALUES
(4, 3, 77, 2, '1'),
(5, 3, 80, 1, '1'),
(6, 3, 81, 4, '1'),
(21, 3, 90, 1, '1'),
(22, 5, 90, 2, '1');

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
(2, 71, 5, '1 vez al día por 15 días'),
(3, 80, 5, '1 vez al día por 15 días'),
(4, 81, 5, '1 vez al día por 15 días');

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
-- Volcado de datos para la tabla `consulta_seguro`
--

INSERT INTO `consulta_seguro` (`consulta_seguro_id`, `consulta_id`, `seguro_id`, `tipo_servicio`, `fecha_ocurrencia`, `monto`, `estatus_con`) VALUES
(000000025, 77, 5, 'consulta', '2023-07-05 02:40:21', 800, '1');

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
(3, 60, 9, 9, 7, '1'),
(4, 61, 9, 9, 7, '1'),
(5, 71, 8, 10, 15, '1'),
(6, 80, 8, 10, 15, '1'),
(7, 81, 8, 10, 15, '1'),
(16, 90, 8, 10, 15, '1');

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
(3, 'Vasos Venezolanos', 'J-234242341', 'Complejo Industrial La Hamaca', '1'),
(4, 'Selva C.A', 'J-155465488', 'Complejo Industrial La Hamaca', '1'),
(5, 'Envasados Samír', 'J-256489158', 'Andrés Eloy Blanco', '1'),
(6, 'probando', 'J-123454312', 'probando', '1');

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
(7, 'Oftamología', '1'),
(8, 'Otorrinolaringología', '1'),
(9, 'Pediatría', '1'),
(10, 'Dermatología', '1'),
(11, 'Odontología', '1'),
(12, 'Medicina General', '1');

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
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`examen_id`, `nombre`, `tipo`, `hecho_aqui`, `estatus_exa`) VALUES
(3, 'Perfil 20', '', 0, '1'),
(4, 'Hemoglobina', '', 1, '1'),
(5, 'Colesterol', '', 1, '1'),
(6, 'Ecosonograma Tiroideo', '', 0, '1'),
(7, 'Preuab', '', 0, '2'),
(8, 'Cerebrologia', '', 1, '1'),
(9, 'Otorrinolaringología', '', 0, '1'),
(14, 'Dermatología', '', 1, '1');

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
-- Volcado de datos para la tabla `factura_compra`
--

INSERT INTO `factura_compra` (`factura_compra_id`, `proveedor_id`, `fecha_compra`, `total_productos`, `monto_con_iva`, `monto_sin_iva`, `excento`, `estatus_fac`) VALUES
(000000009, 3, '2022-12-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(000000010, 3, '2023-07-12 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(000000011, 3, '2023-07-25 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(000000012, 3, '2023-08-11 00:00:00', 13, 10.54, 7.54, NULL, '1'),
(000000014, 3, '2023-07-11 00:00:00', 13, 10.54, 7.54, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_consulta`
--

CREATE TABLE `factura_consulta` (
  `factura_consulta_id` int(8) UNSIGNED ZEROFILL NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `monto_consulta` float NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura_consulta`
--

INSERT INTO `factura_consulta` (`factura_consulta_id`, `consulta_id`, `paciente_id`, `metodo_pago`, `monto_consulta`, `estatus_fac`) VALUES
(00000004, 90, 15, 'debito', 400, '1'),
(00000005, 65, 7, 'debito', 200, '1');

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
-- Volcado de datos para la tabla `factura_medico`
--

INSERT INTO `factura_medico` (`factura_medico_id`, `medico_id`, `acumulado_seguro_total`, `acumulado_consulta_total`, `pago_total`, `fecha_pago`, `pacientes_seguro`, `pacientes_consulta`, `estatus_fac`) VALUES
(00000030, 9, 0, 0, 0, '2023-04-30', 0, 0, '1');

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
-- Volcado de datos para la tabla `factura_seguro`
--

INSERT INTO `factura_seguro` (`factura_seguro_id`, `seguro_id`, `mes`, `fecha_ocurrencia`, `fecha_vencimiento`, `monto`, `estatus_fac`) VALUES
(00000002, 0, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1'),
(00000003, 5, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 400, '1'),
(00000004, 6, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1'),
(00000005, 7, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1'),
(00000006, 8, 'mayo', '2023-05-26 02:34:40', '2023-06-26', 0, '1');

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
(33, 9, 'lunes', '12:00:00', '08:00:00', '1'),
(34, 9, 'martes', '09:00:00', '18:00:00', '1'),
(35, 9, 'jueves', '10:00:00', '07:00:00', '1'),
(36, 9, 'viernes', '00:00:00', '00:00:00', '1'),
(37, 10, 'lunes', '00:00:00', '00:00:00', '1'),
(38, 10, 'viernes', '00:00:00', '00:00:00', '1'),
(39, 11, 'lunes', '13:00:00', '06:00:00', '1'),
(40, 11, 'jueves', '00:00:00', '00:00:00', '1'),
(41, 11, 'sabado', '00:00:00', '00:00:00', '1'),
(42, 12, 'martes', '00:00:00', '00:00:00', '1'),
(43, 12, 'miercoles', '00:00:00', '00:00:00', '1'),
(44, 12, 'jueves', '00:00:00', '00:00:00', '1'),
(45, 18, 'jueves', '20:00:00', '15:00:00', '1'),
(46, 18, 'viernes', '12:00:00', '07:00:00', '1');

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
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`insumo_id`, `nombre`, `cantidad`, `stock`, `cantidad_min`, `precio`, `estatus_ins`) VALUES
(3, 'inyecciones', 13, 0, 5, 20, '1'),
(4, 'Gazas', 113, 0, 10, 50, '1'),
(5, 'Paletas', 129, 0, 15, 1, '1'),
(6, 'Unidad de Diclofenaco', 300, 0, 15, 3, '1'),
(7, 'Unidad de ibuprofeno', 200, 0, 10, 3, '2');

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
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`medicamento_id`, `especialidad_id`, `nombre_medicamento`, `tipo_medicamento`, `estatus_med`) VALUES
(5, 7, 'Diclofenac de 500 mg', '1', '1'),
(6, 7, 'diclofenaco de 500mg', '1', '1');

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
-- Volcado de datos para la tabla `medico`
--

INSERT INTO `medico` (`medico_id`, `cedula`, `nombre`, `apellidos`, `telefono`, `direccion`, `estatus_med`) VALUES
(9, 17589462, 'Noemí Alejandra', 'Torre Bolaños', '04124589623', 'Maracay', '1'),
(10, 15962347, 'Julia Lucia', 'Vendrell Acosta', '04124596589', 'Santa Rita', '1'),
(11, 17965238, 'Héctor Alejandro', 'Talavera Ibarra', '04244587965', 'Cagua', '1'),
(12, 24878989, 'María Hortensia', 'Yuste Sanjuan', '04164578965', 'Santa Inés', '1'),
(18, 11502129, 'Alberto', 'Chacón', '04125005556', 'Barrio Bolívar', '1'),
(19, 18596235, 'Juan', 'London', '04124589632', 'Maracay', '1');

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
(13, 9, 8, 0, '1'),
(14, 9, 9, 0, '1'),
(15, 10, 8, 0, '1'),
(16, 10, 9, 0, '1'),
(17, 11, 11, 0, '1'),
(18, 12, 9, 0, '1'),
(19, 17, 7, 0, '1'),
(20, 17, 8, 0, '1'),
(21, 18, 7, 0, '1'),
(22, 18, 8, 0, '1'),
(23, 19, 8, 0, '1'),
(24, 19, 9, 0, '1');

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
(7, 18954458, 'Violeta Jesusa', 'Cornejo Bonilla', '1993-12-12', 29, '04144548484', 'Santa Inés', '1', '1'),
(11, 18956458, 'Elena Concepción', 'Pavón Rondan', '1985-02-12', 38, '04128797855', 'Andres Eloy Blanco', '3', '1'),
(12, 25369123, 'Andrea', 'Gutierrez', '2001-12-24', 24, '04123353781', 'Maracay', '3', '1'),
(13, 25169123, 'Miguel', 'Gutierrez', '2001-12-24', 24, '04123353781', 'Maracay', '3', '1'),
(14, 24587962, 'Manuel', 'Rondón', '1998-05-12', 25, '5896231', 'Maracay', '4', '1'),
(15, 21169123, 'José', 'Londón', '2010-12-24', 24, '04123353781', 'Maracay', '4', '1'),
(18, 15962354, 'paciente', 'de prueba', '1986-10-22', 36, '04124585249', 'Maracay', '3', '2'),
(19, 15962354, 'paciente', 'de prueba', '2003-10-10', 19, '4565454', 'Cagua', '4', '1'),
(20, 12345234, 'Probando', 'Probando', '2010-12-12', 12, '04123353781', 'Probando', '4', '1'),
(21, 75631223, 'guayaba', 'guayaba', '1983-10-12', 39, '2345678', 'guayaba', '3', '1');

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
(4, 14, '1'),
(5, 15, '1'),
(6, 19, '1'),
(7, 20, '1');

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
(3, 12, 5, 3, '1', 2000, '2002-07-22', 400, '1'),
(4, 12, 6, 4, '1', 2000, '2002-07-22', 4000, '1'),
(5, 13, 6, 4, '1', 2000, '2002-07-22', 4000, '1'),
(6, 21, 5, 3, '1', 2000, '2012-10-10', 2000, '1');

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
(10, 4, '1', 'amarillo', '1'),
(11, 4, '2', 'rocky', '1'),
(12, 4, '2', 'rocky', '1'),
(13, 5, '1', 'amarillo', '1'),
(14, 5, '2', 'rocky', '1'),
(15, 5, '2', 'rocky', '1'),
(16, 6, '1', 'amarillo', '1'),
(17, 6, '2', 'rocky', '1'),
(18, 6, '2', 'rocky', '1');

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
(3, 'Proveedores Médicos C.A', 'Santa Rita', '1'),
(4, 'Proveedores Cagua', 'Cagua', '1'),
(5, 'Insumos médicos C.A', 'San Joaquín', '1'),
(6, 'Insumos Miranda', 'Miranda', '2'),
(7, 'Insumos Caracas', 'Distrido Capital', '1'),
(8, 'Proveedores Magic', 'San Vicente', '1');

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
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguro`
--

INSERT INTO `seguro` (`seguro_id`, `nombre`, `rif`, `direccion`, `telefono`, `porcentaje`, `costo_consulta`, `estatus_seg`) VALUES
(0, 'ninguno', '0', '0', '0', 0, 0, '1'),
(5, 'Seguros Miranda C.A', 'J-455848484', 'Miranda', '04124564545', 0, 0, '1'),
(6, 'Seguros Venezolanos C.A', 'J-458498451', 'Maracay', '04244589656', 0, 0, '1'),
(7, 'Seguros Qualitas', 'J-156148916', 'Distrito Federal', '04164548798', 0, 0, '1'),
(8, 'Seguros Pirámides', 'J-213412341', 'San Joaquín', '04121561848', 0, 0, '1'),
(12, 'verdecito', 'J-5628931', 'Aragua', '04145053781', 20, 0, '1'),
(13, 'moraito', 'J-5628431', 'Aragua', '04145053781', 20, 0, '1'),
(23, 'naranja', 'J-5621431', 'Aragua', '04145053781', 20, 0, '1'),
(25, 'purpura', 'J-5621422', 'Aragua', '04145053781', 20, 20, '1');

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
(5, 3, 5, '1'),
(6, 4, 6, '1'),
(7, 5, 5, '1');

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
(5, 12, '4,5,14,8', '20,3,20,15', '1'),
(6, 13, '4,5,8', '20,13,25', '1'),
(18, 23, '4,5,11,8', '20,13,12,12', '1'),
(20, 25, '4,5,8', '20,13,25', '1');

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
(4, 4, 12, '1', '1', '1'),
(5, 5, 12, '1', '2', '1'),
(6, 5, 13, '1', '2', '4'),
(7, 6, 12, '1', '1', '1'),
(8, 7, 12, '1', '1', '1');

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
(4, 'Francis', '$2y$10$6cnPzqlenP5878xUDF/gMu/1vI1W4lrfk4C6ggJFcrlG9zlBvMTRi', '7104d4f029', 2, '$2y$10$yDKhtd2MhxYC/9rbTYDoSevYCSJANGxBVJbU5VbTDSK.f1y9GXshq', '1', '2023-05-03 04:01:06'),
(5, 'guayaba', '$2y$10$Mo3Di1i0xWuRyTHTuHVGbuu/L1L3cQF3/qgx3/POEWeH9KJGZSfii', '7ace4b41a1', 1, '$2y$10$Ya6sB9ja4ZVRhe9vkLuBpOUb.mUzlVNgcB9MvE1s8yN73IJeItx86', '1', '2023-05-20 02:51:42'),
(6, 'Usuario', '$2y$10$dDTDR8PSBHK8tYDcXxL7Qeokj8pl3R3LuieZzjsojy1Y4X/MvMjxa', NULL, 2, '$2y$10$3Us1bxifY9nN5VZhEPcvjO8D7LVetjAB10L5Wy68uJGO/hqK1x6b6', '1', '2023-06-23 01:37:57');

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
  ADD KEY `fk_emergencia_seguro` (`seguro_id`);

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
-- Indices de la tabla `consulta_sin_cita`
--
ALTER TABLE `consulta_sin_cita`
  ADD PRIMARY KEY (`consulta_sin_cita_id`),
  ADD KEY `especialidad_id` (`especialidad_id`),
  ADD KEY `medico_id` (`medico_id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `fk_consulta_consulta` (`consulta_id`);

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
-- Indices de la tabla `seguro_examen`
--
ALTER TABLE `seguro_examen`
  ADD PRIMARY KEY (`seguro_examen_id`),
  ADD KEY `fk_seguro_examen_id_seguro` (`seguro_id`);

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
  MODIFY `auditoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `cita_seguro`
--
ALTER TABLE `cita_seguro`
  MODIFY `cita_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `compra_insumo`
--
ALTER TABLE `compra_insumo`
  MODIFY `compra_insumo_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `consulta`
--
ALTER TABLE `consulta`
  MODIFY `consulta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `consulta_cita`
--
ALTER TABLE `consulta_cita`
  MODIFY `consulta_cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `consulta_emergencia`
--
ALTER TABLE `consulta_emergencia`
  MODIFY `consulta_emergencia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `consulta_examen`
--
ALTER TABLE `consulta_examen`
  MODIFY `consulta_examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `consulta_indicaciones`
--
ALTER TABLE `consulta_indicaciones`
  MODIFY `consulta_indicaciones_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `consulta_insumo`
--
ALTER TABLE `consulta_insumo`
  MODIFY `consulta_insumo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  MODIFY `consulta_recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `consulta_seguro`
--
ALTER TABLE `consulta_seguro`
  MODIFY `consulta_seguro_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `consulta_sin_cita`
--
ALTER TABLE `consulta_sin_cita`
  MODIFY `consulta_sin_cita_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  MODIFY `factura_compra_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `factura_consulta`
--
ALTER TABLE `factura_consulta`
  MODIFY `factura_consulta_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura_medico`
--
ALTER TABLE `factura_medico`
  MODIFY `factura_medico_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `medicamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `medico`
--
ALTER TABLE `medico`
  MODIFY `medico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  MODIFY `medico_especialidad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `paciente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `paciente_beneficiado`
--
ALTER TABLE `paciente_beneficiado`
  MODIFY `paciente_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `paciente_seguro`
--
ALTER TABLE `paciente_seguro`
  MODIFY `paciente_seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pregunta_seguridad`
--
ALTER TABLE `pregunta_seguridad`
  MODIFY `pregunta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seguro`
--
ALTER TABLE `seguro`
  MODIFY `seguro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `seguro_empresa`
--
ALTER TABLE `seguro_empresa`
  MODIFY `seguro_empresa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `seguro_examen`
--
ALTER TABLE `seguro_examen`
  MODIFY `seguro_examen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tipo_antecedente`
--
ALTER TABLE `tipo_antecedente`
  MODIFY `tipo_antecedente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `titular_beneficiado`
--
ALTER TABLE `titular_beneficiado`
  MODIFY `titular_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Filtros para la tabla `consulta_cita`
--
ALTER TABLE `consulta_cita`
  ADD CONSTRAINT `consulta_cita_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_cita_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_emergencia`
--
ALTER TABLE `consulta_emergencia`
  ADD CONSTRAINT `fk_emergencia_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
  ADD CONSTRAINT `fk_emergencia_beneficiado` FOREIGN KEY (`paciente_beneficiado_id`) REFERENCES `paciente_beneficiado` (`paciente_beneficiado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_emergencia_titular` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION

ALTER TABLE `consulta_emergencia` ADD `fecha_emergencia` DATETIME NOT NULL AFTER `enfermeria`, ADD `estatus_con` ENUM('1', '2', '3') NOT NULL AFTER `fecha_emergencia`;

--
-- Filtros para la tabla `consulta_recipe`
--
ALTER TABLE `consulta_recipe`
  ADD CONSTRAINT `consulta_recipe_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_recipe_ibfk_2` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamento` (`medicamento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consulta_sin_cita`
--
ALTER TABLE `consulta_sin_cita`
  ADD CONSTRAINT `consulta_sin_cita_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_sin_cita_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `consulta_sin_cita_ibfk_3` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_consulta_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seguro_examen`
--
ALTER TABLE `seguro_examen`
  ADD CONSTRAINT `fk_seguro_examen_id_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;





-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_cita`
-- codigo original (no borrar)

-- CCREATE TABLE `consulta_cita` (
--   `consulta_cita_id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
--   `cita_id` int(11) NOT NULL,
--   `consulta_id` int(11) NOT NULL,
--   `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
--    PRIMARY KEY (consulta_cita_id),
--    FOREIGN KEY (cita_id)
--    	REFERENCES cita (cita_id)
--     ON DELETE NO ACTION ON UPDATE NO ACTION,
--     	FOREIGN KEY (consulta_id)
--         REFERENCES consulta (consulta_id)
--         ON DELETE NO ACTION ON UPDATE NO ACTION
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_sin_cita`
-- codigo original (no borrar)

-- CREATE TABLE `consulta_sin_cita` (
--   `consulta_sin_cita_id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
--   `especialidad_id` int(11) NOT NULL,
--   `medico_id` int(11) NOT NULL,
--   `paciente_id` int(11) NOT NULL,
--   `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
--    PRIMARY KEY (consulta_sin_cita_id),
--    FOREIGN KEY (especialidad_id)
--    	REFERENCES especialidad (especialidad_id)
--     ON DELETE NO ACTION ON UPDATE NO ACTION,
--         FOREIGN KEY (medico_id)
--         REFERENCES medico (medico_id)
--         ON DELETE NO ACTION ON UPDATE NO ACTION,
--             FOREIGN KEY (paciente_id)
--             REFERENCES paciente (paciente_id)
--             ON DELETE NO ACTION ON UPDATE NO ACTION
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro_examen`
--

-- CREATE TABLE IF NOT EXISTS `seguro_examen` (
--   `seguro_examen_id` int(11) NOT NULL AUTO_INCREMENT,
--   `seguro_id` int(11) NOT NULL,
--   `examenes` TEXT NOT NULL,
--   `costos` TEXT NOT NULL,
--   `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
--   PRIMARY KEY (`seguro_examen_id`),
--   KEY `fk_seguro_examen_id_seguro` (`seguro_id`),
--   CONSTRAINT `fk_seguro_examen_id_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
-- ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Indices de la tabla `consulta_emergencia`
--
-- CREATE TABLE IF NOT EXISTS `consulta_emergencia` (
--   `consulta_emergencia_id` int(11) NOT NULL AUTO_INCREMENT,
--   `paciente_id` int(11) NOT NULL,
--   `seguro_id` int(11) NOT NULL,
--   `consultas_medicas` float NOT NULL,
--   `Laboratorios` float NULL,
--   `medicamentos` float NULL,
--   `area_observacion` float NULL,
--   `enfermeria` float NULL,
--   PRIMARY KEY (`consulta_emergencia_id`),
--   KEY `fk_emergencia_seguro` (`seguro_id`),
--   CONSTRAINT `fk_emergencia_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
-- ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
--
-- Indices de la tabla `global`
--
-- CREATE TABLE IF NOT EXISTS `global` (
--   `global_id` int(11) NOT NULL AUTO_INCREMENT,
--   `key` text NOT NULL,
--   `value` text NOT NULL,
--   PRIMARY KEY (`global_id`)
-- ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- INSERT INTO `global` (`global_id`, `key`, `value`) VALUES (NULL, 'porcentaje_medicos', '60');
