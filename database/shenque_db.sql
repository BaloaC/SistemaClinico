/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shenque_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS  `usuario` (
    `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(16) NOT NULL,
    `clave` varchar(100) NOT NULL,
    `tokken` varchar(10) DEFAULT NULL,
    `rol` int(11) NOT NULL,
    `pin` varchar(100) NOT NULL,
    `estatus_usu` enum('1','2') NOT NULL DEFAULT '1',
    `fecha_creacion` datetime NOT NULL,
    PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
--
-- Indices de la tabla `global`
--
CREATE TABLE IF NOT EXISTS `global` (
    `global_id` int(11) NOT NULL AUTO_INCREMENT,
    `key` text NOT NULL,
    `value` text NOT NULL,
    PRIMARY KEY (`global_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `global` (`global_id`, `key`, `value`) VALUES
(1, 'porcentaje_medico', '60'),
(2, 'cambio_divisa', '32.59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE IF NOT EXISTS `auditoria` (
    `auditoria_id` int(11) NOT NULL AUTO_INCREMENT,
    `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `usuario_id` int(11) NOT NULL,
    `accion` varchar(45) NOT NULL,
    `descripcion` varchar(45) NOT NULL,
    PRIMARY KEY (`auditoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_seguridad`
--

CREATE TABLE IF NOT EXISTS `pregunta_seguridad` (
    `pregunta_id` int(11) NOT NULL AUTO_INCREMENT,
    `usuario_id` int(11) NOT NULL,
    `pregunta` varchar(100) NOT NULL,
    `respuesta` varchar(100) NOT NULL,
    `estatus_pre` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`pregunta_id`),
    FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_antecedente`
--

CREATE TABLE IF NOT EXISTS `tipo_antecedente` (
    `tipo_antecedente_id` int(11) NOT NULL,
    `nombre` varchar(50) NOT NULL,
    `fecha_creacion` datetime NOT NULL,
    `estatus_tip` enum('1','2') NOT NULL,
    PRIMARY KEY (`tipo_antecedente_id`)
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
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
    `empresa_id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    `rif` varchar(45) NOT NULL,
    `direccion` varchar(45) NOT NULL,
    `estatus_emp` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`empresa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro`
--

CREATE TABLE IF NOT EXISTS `seguro` (
    `seguro_id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    `rif` varchar(45) NOT NULL,
    `direccion` varchar(45) NOT NULL,
    `telefono` varchar(13) NOT NULL,
    `porcentaje` int(11) NOT NULL,
    `costo_consulta` int(11) NOT NULL,
    `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`seguro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro_empresa`
--

CREATE TABLE IF NOT EXISTS `seguro_empresa` (
    `seguro_empresa_id` int(11) NOT NULL AUTO_INCREMENT,
    `empresa_id` int(11) NOT NULL,
    `seguro_id` int(11) NOT NULL,
    `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`seguro_empresa_id`),
    FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguro_examen`
--

CREATE TABLE IF NOT EXISTS `seguro_examen` (
    `seguro_examen_id` int(11) NOT NULL AUTO_INCREMENT,
    `seguro_id` int(11) NOT NULL,
    `examenes` text NOT NULL,
    `costos` text NOT NULL,
    `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`seguro_examen_id`),
    FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE  IF NOT EXISTS `proveedor` (
    `proveedor_id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    `ubicacion` varchar(255) NOT NULL,
    `estatus_pro` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`proveedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

CREATE TABLE  IF NOT EXISTS `insumo` (
    `insumo_id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    `cantidad` int(11) NOT NULL,
    `stock` int(10) UNSIGNED NOT NULL,
    `cantidad_min` int(11) NOT NULL,
    `precio` float NOT NULL,
    `estatus_ins` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`insumo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE  IF NOT EXISTS `factura_compra` (
    `factura_compra_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    `proveedor_id` int(11) NOT NULL,
    `fecha_compra` datetime NOT NULL,
    `total_productos` int(11) NOT NULL,
    `monto_con_iva` float NOT NULL,
    `monto_sin_iva` float NOT NULL,
    `monto_usd` float NOT NULL,
    `excento` float DEFAULT NULL,
    `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
    PRIMARY KEY (`factura_compra_id`),
    FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_insumo`
--

CREATE TABLE  IF NOT EXISTS `compra_insumo` (
    `compra_insumo_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    `insumo_id` int(11) NOT NULL,
    `factura_compra_id` int(9) UNSIGNED ZEROFILL NOT NULL,
    `unidades` int(11) NOT NULL,
    `precio_unit_bs` float NOT NULL,
    `precio_total_bs` float NOT NULL,
    `precio_unit_usd` float NOT NULL,
    `precio_total_usd` float NOT NULL,
    PRIMARY KEY (`compra_insumo_id`),
    FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`factura_compra_id`) REFERENCES `factura_compra` (`factura_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE  IF NOT EXISTS `especialidad` (
    `especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    `estatus_esp` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`especialidad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico`
--

CREATE TABLE  IF NOT EXISTS `medico` (
    `medico_id` int(11) NOT NULL AUTO_INCREMENT,
    `cedula` int(11) NOT NULL,
    `nombre` varchar(45) NOT NULL,
    `apellidos` varchar(45) NOT NULL,
    `telefono` varchar(45) DEFAULT NULL,
    `direccion` varchar(45) NOT NULL,
    `acumulado` int(11) NOT NULL,
    `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`medico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medico_especialidad`
--

CREATE TABLE  IF NOT EXISTS `medico_especialidad` (
    `medico_especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
    `medico_id` int(11) NOT NULL,
    `especialidad_id` int(11) NOT NULL,
    `costo_especialidad` int(11) NOT NULL,
    `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`medico_especialidad_id`),
    FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE  IF NOT EXISTS `horario` (
    `horario_id` int(11) NOT NULL AUTO_INCREMENT,
    `medico_id` int(11) NOT NULL,
    `dias_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado') NOT NULL,
    `hora_salida` time NOT NULL,
    `hora_entrada` time NOT NULL,
    `estatus_hor` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`horario_id`),
    FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE  IF NOT EXISTS `paciente` (
    `paciente_id` int(11) NOT NULL AUTO_INCREMENT,
    `cedula` int(11) NOT NULL,
    `nombre` varchar(45) NOT NULL,
    `apellidos` varchar(45) NOT NULL,
    `fecha_nacimiento` date NOT NULL,
    `edad` int(11) NOT NULL,
    `telefono` varchar(45) DEFAULT NULL,
    `direccion` varchar(45) NOT NULL,
    `tipo_paciente` enum('1','2','3','4') NOT NULL,
    `estatus_pac` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`paciente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_beneficiado`
--

CREATE TABLE  IF NOT EXISTS `paciente_beneficiado` (
    `paciente_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT,
    `paciente_id` int(11) NOT NULL,
    `estatus_pac` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`paciente_beneficiado_id`),
    FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titular_beneficiado`
--

CREATE TABLE  IF NOT EXISTS `titular_beneficiado` (
    `titular_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT,
    `paciente_beneficiado_id` int(11) NOT NULL,
    `paciente_id` int(11) NOT NULL,
    `estatus_tit` enum('1','2') NOT NULL DEFAULT '1',
    `tipo_relacion` enum('1','2') NOT NULL,
    `tipo_familiar` enum('1','2','3','4',' 5','6') NOT NULL,
    PRIMARY KEY (`titular_beneficiado_id`),
    FOREIGN KEY (`paciente_beneficiado_id`) REFERENCES `paciente_beneficiado` (`paciente_beneficiado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente_seguro`
--

CREATE TABLE  IF NOT EXISTS `paciente_seguro` (
    `paciente_seguro_id` int(11) NOT NULL AUTO_INCREMENT,
    `paciente_id` int(11) NOT NULL,
    `seguro_id` int(11) NOT NULL,
    `empresa_id` int(11) NOT NULL,
    `tipo_seguro` enum('1','2') NOT NULL,
    `cobertura_general` float NOT NULL,
    `fecha_contra` date NOT NULL,
    `saldo_disponible` float NOT NULL,
    `estatus_pac` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`paciente_seguro_id`),
    FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE  IF NOT EXISTS `examen` (
    `examen_id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(45) NOT NULL,
    `precio_examen` int(11) DEFAULT NULL,
    `tipo` enum('1','2','3') NOT NULL,
    `hecho_aqui` tinyint(1) NOT NULL DEFAULT 0,
    `estatus_exa` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`examen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE  IF NOT EXISTS `consulta` (
    `consulta_id` int(11) NOT NULL AUTO_INCREMENT,
    `peso` float DEFAULT NULL,
    `altura` float DEFAULT NULL,
    `observaciones` varchar(255) DEFAULT NULL,
    `fecha_consulta` date NOT NULL,
    `es_emergencia` tinyint(1) NOT NULL DEFAULT 0,
    `estatus_con` enum('1','2','3') NOT NULL DEFAULT '1',
    PRIMARY KEY (`consulta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE  IF NOT EXISTS `cita` (
    `cita_id` int(11) NOT NULL AUTO_INCREMENT,
    `paciente_id` int(11) NOT NULL,
    `medico_id` int(11) NOT NULL,
    `especialidad_id` int(11) NOT NULL,
    `fecha_cita` date NOT NULL,
    `hora_salida` time NOT NULL,
    `hora_entrada` time NOT NULL,
    `motivo_cita` varchar(45) NOT NULL,
    `cedula_titular` int(11) NOT NULL,
    `tipo_cita` enum('1','2') NOT NULL,
    `estatus_cit` enum('1','2','3','4',' 5') NOT NULL,
    PRIMARY KEY (`cita_id`),
    FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_seguro`
--

CREATE TABLE  IF NOT EXISTS `cita_seguro` (
    `cita_seguro_id` int(11) NOT NULL AUTO_INCREMENT,
    `cita_id` int(11) NOT NULL,
    `seguro_id` int(11) NOT NULL,
    `clave` varchar(15) DEFAULT NULL,
    PRIMARY KEY (`cita_seguro_id`),
    FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_cita`
--

CREATE TABLE  IF NOT EXISTS `consulta_cita` (
    `consulta_cita_id` int(11) NOT NULL AUTO_INCREMENT,
    `cita_id` int(11) NOT NULL,
    `consulta_id` int(11) NOT NULL,
    `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`consulta_cita_id`),
    FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_emergencia`
--

CREATE TABLE  IF NOT EXISTS `consulta_emergencia` (
    `consulta_emergencia_id` int(11) NOT NULL AUTO_INCREMENT,
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
    `total_insumos` int(11) NOT NULL,
    `total_insumos_bs` float NOT NULL,
    `total_examenes` int(11) NOT NULL,
    `total_examenes_bs` float NOT NULL,
    `total_consulta` int(11) NOT NULL,
    `total_consulta_bs` float NOT NULL,
    PRIMARY KEY (`consulta_emergencia_id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_examen`
--

CREATE TABLE  IF NOT EXISTS `consulta_examen` (
    `consulta_examen_id` int(11) NOT NULL AUTO_INCREMENT,
    `consulta_id` int(11) NOT NULL,
    `examen_id` int(11) NOT NULL,
    `precio_examen_bs` float NOT NULL,
    `precio_examen_usd` float NOT NULL,
    `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`consulta_examen_id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_indicaciones`
--

CREATE TABLE  IF NOT EXISTS `consulta_indicaciones` (
    `consulta_indicaciones_id` int(11) NOT NULL AUTO_INCREMENT,
    `consulta_id` int(11) NOT NULL,
    `descripcion` text NOT NULL,
    PRIMARY KEY (`consulta_indicaciones_id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_insumo`
--

CREATE TABLE  IF NOT EXISTS `consulta_insumo` (
    `consulta_insumo_id` int(11) NOT NULL AUTO_INCREMENT,
    `insumo_id` int(11) NOT NULL,
    `consulta_id` int(11) NOT NULL,
    `cantidad` int(8) NOT NULL,
    `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
    `precio_insumo_bs` float NOT NULL,
    `precio_insumo_usd` float NOT NULL,
    PRIMARY KEY (`consulta_insumo_id`),
    FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE  IF NOT EXISTS `medicamento` (
    `medicamento_id` int(11) NOT NULL AUTO_INCREMENT,
    `especialidad_id` int(11) NOT NULL,
    `nombre_medicamento` varchar(45) NOT NULL,
    `tipo_medicamento` enum('1','2','3', '4') DEFAULT NULL,
    `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`medicamento_id`),
    FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_recipe`
--

CREATE TABLE  IF NOT EXISTS `consulta_recipe` (
    `consulta_recipe_id` int(11) NOT NULL AUTO_INCREMENT,
    `consulta_id` int(11) NOT NULL,
    `medicamento_id` int(11) NOT NULL,
    `uso` text NOT NULL,
    PRIMARY KEY (`consulta_recipe_id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`medicamento_id`) REFERENCES `medicamento` (`medicamento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_seguro`
--

CREATE TABLE  IF NOT EXISTS `consulta_seguro` (
    `consulta_seguro_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    `consulta_id` int(11) NOT NULL,
    `seguro_id` int(11) NOT NULL,
    `tipo_servicio` varchar(50) NOT NULL,
    `fecha_ocurrencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `monto_consulta_usd` float NOT NULL,
    `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
    `monto_consulta_bs` float NOT NULL,
    PRIMARY KEY (`consulta_seguro_id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta_sin_cita`
--

CREATE TABLE  IF NOT EXISTS `consulta_sin_cita` (
    `consulta_sin_cita_id` int(11) NOT NULL AUTO_INCREMENT,
    `consulta_id` int(11) NOT NULL,
    `especialidad_id` int(11) NOT NULL,
    `medico_id` int(11) NOT NULL,
    `paciente_id` int(11) NOT NULL,
    `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
    PRIMARY KEY (`consulta_sin_cita_id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `antecedentes_medicos`
--

CREATE TABLE  IF NOT EXISTS `antecedentes_medicos` (
    `antecedentes_medicos_id` int(11) NOT NULL AUTO_INCREMENT,
    `paciente_id` int(11) NOT NULL,
    `tipo_antecedente_id` int(11) NOT NULL,
    `descripcion` text NOT NULL,
    `estatus_ant` enum('1','2') NOT NULL DEFAULT '1',
    `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (antecedentes_medicos_id),
    FOREIGN KEY (paciente_id)
        REFERENCES paciente (paciente_id) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (tipo_antecedente_id)
        REFERENCES tipo_antecedente (tipo_antecedente_id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_consulta`
--

CREATE TABLE  IF NOT EXISTS `factura_consulta` (
    `factura_consulta_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    `consulta_id` int(11) NOT NULL,
    `paciente_id` int(11) NOT NULL,
    `metodo_pago` varchar(20) NOT NULL,
    `monto_consulta_bs` float NOT NULL,
    `estatus_fac` enum('1','2') NOT NULL DEFAULT '1',
    `monto_consulta_usd` float NOT NULL,
    PRIMARY KEY (`factura_consulta_id`),
    FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_medico`
--

CREATE TABLE  IF NOT EXISTS `factura_medico` (
    `factura_medico_id` int(8) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    `medico_id` int(11) NOT NULL,
    `acumulado_seguro_total` float DEFAULT NULL,
    `acumulado_consulta_total` float DEFAULT NULL,
    `pago_total` float DEFAULT NULL,
    `fecha_pago` date NOT NULL,
    `pacientes_seguro` int(11) DEFAULT NULL,
    `pacientes_consulta` int(11) DEFAULT NULL,
    `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
    PRIMARY KEY (`factura_medico_id`),
    FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_seguro`
--

CREATE TABLE  IF NOT EXISTS `factura_seguro` (
    `factura_seguro_id` int(8) UNSIGNED ZEROFILL NOT NULL,
    `seguro_id` int(11) NOT NULL,
    `mes` varchar(10) NOT NULL,
    `fecha_ocurrencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `fecha_vencimiento` date NOT NULL,
    `monto_usd` float NOT NULL,
    `monto_bs` float NOT NULL,
    `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
    PRIMARY KEY (`factura_seguro_id`),
    FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -------------------------------------------------------

-- Indices de la talba `factura_mensajería`

CREATE TABLE IF NOT EXISTS `factura_mensajeria` (
    `factura_mensajeria_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    `fecha_mensajeria` DATETIME NOT NULL,
    `seguro_id` int(11) NOT NULL,
    `total_mensajeria_bs` float NOT NULL,
    `total_mensajeria_usd` float NOT NULL,
    PRIMARY KEY (`factura_mensajeria_id`),
    KEY `fk_mensajeria_seguro` (`seguro_id`),
    CONSTRAINT `fk_mensajeria_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- -------------------------------------------------------

-- Indices de la talba `factura_mensajeria_consultas`

CREATE TABLE IF NOT EXISTS `factura_mensajeria_consultas` (
    `factura_mensajeria_consultas_id` int(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
    `factura_mensajeria_id` int(9) UNSIGNED ZEROFILL NOT NULL,
    `consulta_seguro_id` int(9) UNSIGNED ZEROFILL NOT NULL,
    `fecha_mensajeria_consultas` DATETIME NOT NULL,
    PRIMARY KEY (`factura_mensajeria_consultas_id`),
    KEY `fk_mensajeria_consultas` (`consulta_seguro_id`),
    FOREIGN KEY (`consulta_seguro_id`) REFERENCES `consulta_seguro` (`consulta_seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`factura_mensajeria_id`) REFERENCES `factura_mensajeria` (`factura_mensajeria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
