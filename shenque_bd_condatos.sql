-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.22-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para shenque_db
CREATE DATABASE IF NOT EXISTS `shenque_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `shenque_db`;

-- Volcando estructura para tabla shenque_db.auditoria
CREATE TABLE IF NOT EXISTS `auditoria` (
  `auditoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `accion` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`auditoria_id`),
  KEY `fk_auditoria_usuario` (`usuario_id`),
  CONSTRAINT `fk_auditoria_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.auditoria: ~28 rows (aproximadamente)
INSERT INTO `auditoria` (`auditoria_id`, `fecha_creacion`, `usuario_id`, `accion`, `descripcion`) VALUES
	(1, '2023-05-04 01:27:17', 1, 'insert', 'Inserto seguro Seguros Miranda'),
	(2, '2023-05-04 01:27:40', 1, 'insert', 'Inserto empresa Empresa X'),
	(3, '2023-05-04 01:28:07', 1, 'insert', 'Inserto especialidad Pediatría'),
	(4, '2023-05-04 01:30:31', 1, 'insert', 'Inserto especialidad Oftalmología'),
	(5, '2023-05-04 01:32:58', 1, 'insert', 'Inserto medico Francis'),
	(6, '2023-05-04 01:33:37', 1, 'insert', 'Inserto cita '),
	(7, '2023-05-04 02:13:44', 1, 'insert', 'Inserto cita '),
	(8, '2023-05-04 02:13:58', 1, 'insert', 'Inserto cita '),
	(9, '2023-05-04 02:19:39', 1, 'insert', 'Inserto insumo Vendas'),
	(10, '2023-05-04 02:21:18', 1, 'insert', 'Inserto insumo Vitamina B'),
	(11, '2023-05-04 02:23:49', 1, 'insert', 'Inserto proveedor Distribuidora SAS'),
	(12, '2023-05-04 02:26:54', 1, 'insert', 'Inserto examen Hematología completa'),
	(13, '2023-05-04 02:29:58', 1, 'insert', 'Inserto examen Perfil 21'),
	(14, '2023-05-04 02:30:51', 1, 'insert', 'Inserto consulta '),
	(15, '2023-05-04 02:30:51', 1, 'update', 'Actualizó cita '),
	(16, '2023-05-04 02:51:46', 1, 'insert', 'Inserto factura compra '),
	(17, '2023-05-04 02:51:46', 1, 'insert', 'Inserto compra insumo '),
	(18, '2023-05-04 02:51:46', 1, 'update', 'Actualizó insumo Vendas'),
	(19, '2023-05-04 02:51:46', 1, 'insert', 'Inserto compra insumo '),
	(20, '2023-05-04 02:51:46', 1, 'update', 'Actualizó insumo Vitamina B'),
	(21, '2023-05-04 05:25:11', 1, 'insert', 'Inserto factura consulta '),
	(22, '2023-05-04 05:25:58', 1, 'insert', 'Inserto factura medico '),
	(23, '2023-05-04 05:26:13', 1, 'insert', 'Inserto factura medico '),
	(24, '2023-05-04 05:26:16', 1, 'delete', 'Eliminó factura medico '),
	(25, '2023-05-04 05:26:18', 1, 'delete', 'Eliminó factura medico '),
	(26, '2023-05-04 05:30:20', 1, 'insert', 'Inserto factura medico '),
	(27, '2023-05-04 05:30:37', 1, 'insert', 'Inserto factura medico '),
	(28, '2023-05-04 10:26:17', 1, 'insert', 'Inserto cita '),
	(29, '2023-05-04 12:10:37', 1, 'insert', 'Inserto factura consulta '),
	(30, '2023-05-04 12:14:47', 1, 'insert', 'Inserto factura medico ');

-- Volcando estructura para tabla shenque_db.cita
CREATE TABLE IF NOT EXISTS `cita` (
  `cita_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL DEFAULT 0,
  `especialidad_id` int(11) NOT NULL,
  `fecha_cita` datetime NOT NULL,
  `motivo_cita` varchar(45) NOT NULL,
  `cedula_titular` int(11) NOT NULL,
  `clave` int(11) DEFAULT NULL,
  `tipo_cita` enum('1','2') NOT NULL,
  `estatus_cit` enum('1','2','3','4') NOT NULL,
  PRIMARY KEY (`cita_id`),
  KEY `fk_cita_paciente` (`paciente_id`),
  KEY `fk_cita_medico` (`medico_id`),
  KEY `fk_cita_seguro` (`seguro_id`),
  KEY `fk_cita_especialidad` (`especialidad_id`),
  CONSTRAINT `fk_cita_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cita_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.cita: ~1 rows (aproximadamente)
INSERT INTO `cita` (`cita_id`, `paciente_id`, `medico_id`, `seguro_id`, `especialidad_id`, `fecha_cita`, `motivo_cita`, `cedula_titular`, `clave`, `tipo_cita`, `estatus_cit`) VALUES
	(2, 1, 1, 1, 2, '2023-05-07 12:02:00', 'Mi primera cita', 29527505, NULL, '1', '4');

-- Volcando estructura para tabla shenque_db.compra_insumo
CREATE TABLE IF NOT EXISTS `compra_insumo` (
  `compra_insumo_id` int(11) NOT NULL AUTO_INCREMENT,
  `insumo_id` int(11) NOT NULL,
  `factura_compra_id` int(11) NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_unit` float NOT NULL,
  `precio_total` float NOT NULL,
  PRIMARY KEY (`compra_insumo_id`),
  KEY `fk_compra_insumo_insumo` (`insumo_id`),
  KEY `fk_compra_insumo_factura_compra` (`factura_compra_id`),
  CONSTRAINT `fk_compra_insumo_factura_compra` FOREIGN KEY (`factura_compra_id`) REFERENCES `factura_compra` (`factura_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_compra_insumo_insumo` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.compra_insumo: ~2 rows (aproximadamente)
INSERT INTO `compra_insumo` (`compra_insumo_id`, `insumo_id`, `factura_compra_id`, `unidades`, `precio_unit`, `precio_total`) VALUES
	(1, 1, 1, 1, 1, 1.16),
	(2, 2, 1, 2, 2, 4.64);

-- Volcando estructura para tabla shenque_db.consulta
CREATE TABLE IF NOT EXISTS `consulta` (
  `consulta_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `peso` float NOT NULL,
  `altura` float NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `fecha_consulta` date NOT NULL,
  `estatus_con` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`consulta_id`),
  KEY `fk_consulta_medico` (`medico_id`),
  KEY `fk_consulta_paciente` (`paciente_id`),
  KEY `fk_consulta_especialidad` (`especialidad_id`),
  KEY `fk_consulta_cita` (`cita_id`),
  CONSTRAINT `fk_consulta_cita` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.consulta: ~1 rows (aproximadamente)
INSERT INTO `consulta` (`consulta_id`, `paciente_id`, `medico_id`, `especialidad_id`, `cita_id`, `peso`, `altura`, `observaciones`, `fecha_consulta`, `estatus_con`) VALUES
	(1, 1, 1, 2, 2, 56.3, 1.74, NULL, '2023-05-03', '1');

-- Volcando estructura para tabla shenque_db.consulta_examen
CREATE TABLE IF NOT EXISTS `consulta_examen` (
  `consulta_examen_id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`consulta_examen_id`),
  KEY `fk_consulta_examen_consulta` (`consulta_id`),
  KEY `fk_consulta_examen_examen` (`examen_id`),
  CONSTRAINT `fk_consulta_examen_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_examen_examen` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.consulta_examen: ~2 rows (aproximadamente)
INSERT INTO `consulta_examen` (`consulta_examen_id`, `consulta_id`, `examen_id`, `estatus_con`) VALUES
	(1, 1, 1, '1'),
	(2, 1, 2, '1');

-- Volcando estructura para tabla shenque_db.consulta_insumo
CREATE TABLE IF NOT EXISTS `consulta_insumo` (
  `consulta_insumo_id` int(11) NOT NULL AUTO_INCREMENT,
  `insumo_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`consulta_insumo_id`),
  KEY `fk_consulta_insumo_insumo` (`insumo_id`),
  KEY `fk_consulta_insumo_consulta` (`consulta_id`),
  CONSTRAINT `fk_consulta_insumo_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_insumo_insumo` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.consulta_insumo: ~2 rows (aproximadamente)
INSERT INTO `consulta_insumo` (`consulta_insumo_id`, `insumo_id`, `consulta_id`, `estatus_con`) VALUES
	(1, 1, 1, '1'),
	(2, 2, 1, '1');

-- Volcando estructura para tabla shenque_db.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `empresa_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `rif` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `estatus_emp` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`empresa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.empresa: ~1 rows (aproximadamente)
INSERT INTO `empresa` (`empresa_id`, `nombre`, `rif`, `direccion`, `estatus_emp`) VALUES
	(1, 'Empresa X', 'J-323213213', 'Maracay', '1');

-- Volcando estructura para tabla shenque_db.especialidad
CREATE TABLE IF NOT EXISTS `especialidad` (
  `especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `estatus_esp` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`especialidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.especialidad: ~2 rows (aproximadamente)
INSERT INTO `especialidad` (`especialidad_id`, `nombre`, `estatus_esp`) VALUES
	(1, 'Pediatría', '1'),
	(2, 'Oftalmología', '1');

-- Volcando estructura para tabla shenque_db.examen
CREATE TABLE IF NOT EXISTS `examen` (
  `examen_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`examen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.examen: ~2 rows (aproximadamente)
INSERT INTO `examen` (`examen_id`, `nombre`, `tipo`, `estatus_exa`) VALUES
	(1, 'Hematología completa', 'Laboratorio', '1'),
	(2, 'Perfil 21', 'Laboratorio', '1');

-- Volcando estructura para tabla shenque_db.factura_compra
CREATE TABLE IF NOT EXISTS `factura_compra` (
  `factura_compra_id` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `total_productos` int(11) NOT NULL,
  `monto_con_iva` float NOT NULL,
  `monto_sin_iva` float NOT NULL,
  `excento` float DEFAULT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_compra_id`),
  KEY `fk_proveedor_insumo` (`proveedor_id`),
  CONSTRAINT `fk_proveedor_insumo` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.factura_compra: ~1 rows (aproximadamente)
INSERT INTO `factura_compra` (`factura_compra_id`, `proveedor_id`, `fecha_compra`, `total_productos`, `monto_con_iva`, `monto_sin_iva`, `excento`, `estatus_fac`) VALUES
	(1, 1, '2023-05-02 00:00:00', 3, 5.8, 5, 0.8, '1');

-- Volcando estructura para tabla shenque_db.factura_consulta
CREATE TABLE IF NOT EXISTS `factura_consulta` (
  `factura_consulta_id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `monto_con_iva` float NOT NULL,
  `monto_sin_iva` float NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_consulta_id`),
  KEY `fk_factura_consulta_consulta` (`consulta_id`),
  KEY `fk_factura_consulta_paciente` (`paciente_id`),
  CONSTRAINT `fk_factura_consulta_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_factura_consulta_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.factura_consulta: ~1 rows (aproximadamente)
INSERT INTO `factura_consulta` (`factura_consulta_id`, `consulta_id`, `paciente_id`, `metodo_pago`, `monto_con_iva`, `monto_sin_iva`, `estatus_fac`) VALUES
	(2, 1, 1, 'efectivo', 0, 122, '1');

-- Volcando estructura para tabla shenque_db.factura_medico
CREATE TABLE IF NOT EXISTS `factura_medico` (
  `factura_medico_id` int(11) NOT NULL AUTO_INCREMENT,
  `medico_id` int(11) NOT NULL,
  `acumulado_seguro_total` float DEFAULT NULL,
  `acumulado_consulta_total` float DEFAULT NULL,
  `pago_total` float DEFAULT NULL,
  `fecha_pago` date NOT NULL,
  `pacientes_seguro` int(11) DEFAULT NULL,
  `pacientes_consulta` int(11) DEFAULT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_medico_id`),
  KEY `fk_factura_medico_medico` (`medico_id`),
  CONSTRAINT `fk_factura_medico_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.factura_medico: ~1 rows (aproximadamente)
INSERT INTO `factura_medico` (`factura_medico_id`, `medico_id`, `acumulado_seguro_total`, `acumulado_consulta_total`, `pago_total`, `fecha_pago`, `pacientes_seguro`, `pacientes_consulta`, `estatus_fac`) VALUES
	(4, 1, 0, 116, 116, '2023-05-04', 0, 1, '1'),
	(5, 1, 0, 61, 61, '2023-05-04', 0, 1, '1');

-- Volcando estructura para tabla shenque_db.factura_seguro
CREATE TABLE IF NOT EXISTS `factura_seguro` (
  `factura_seguro_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_seguro_id`),
  KEY `fk_factura_seguro_consulta` (`consulta_id`),
  KEY `fk_factura_seguro_seguro` (`seguro_id`),
  CONSTRAINT `fk_factura_seguro_consulta` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_factura_seguro_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.factura_seguro: ~0 rows (aproximadamente)

-- Volcando estructura para tabla shenque_db.horario
CREATE TABLE IF NOT EXISTS `horario` (
  `horario_id` int(11) NOT NULL AUTO_INCREMENT,
  `medico_id` int(11) NOT NULL,
  `dias_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado') NOT NULL,
  `estatus_hor` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`horario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.horario: ~3 rows (aproximadamente)
INSERT INTO `horario` (`horario_id`, `medico_id`, `dias_semana`, `estatus_hor`) VALUES
	(1, 1, 'martes', '1'),
	(2, 1, 'miercoles', '1'),
	(3, 1, 'jueves', '1');

-- Volcando estructura para tabla shenque_db.insumo
CREATE TABLE IF NOT EXISTS `insumo` (
  `insumo_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock` int(10) unsigned NOT NULL,
  `cantidad_min` int(11) NOT NULL,
  `precio` float NOT NULL,
  `estatus_ins` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`insumo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.insumo: ~2 rows (aproximadamente)
INSERT INTO `insumo` (`insumo_id`, `nombre`, `cantidad`, `stock`, `cantidad_min`, `precio`, `estatus_ins`) VALUES
	(1, 'Vendas', 10, 0, 5, 12.3, '1'),
	(2, 'Vitamina B', 26, 0, 10, 30.4, '1');

-- Volcando estructura para tabla shenque_db.medico
CREATE TABLE IF NOT EXISTS `medico` (
  `medico_id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`medico_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.medico: ~1 rows (aproximadamente)
INSERT INTO `medico` (`medico_id`, `cedula`, `nombre`, `apellidos`, `telefono`, `direccion`, `estatus_med`) VALUES
	(1, 29527750, 'Francis', 'Baloa', '04124123213', 'Maracay', '1');

-- Volcando estructura para tabla shenque_db.medico_especialidad
CREATE TABLE IF NOT EXISTS `medico_especialidad` (
  `medico_especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`medico_especialidad_id`),
  KEY `fk_medico_especialidad_medico` (`medico_id`),
  KEY `fk_medico_especialidad_especialidad` (`especialidad_id`),
  CONSTRAINT `fk_medico_especialidad_especialidad` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_medico_especialidad_medico` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.medico_especialidad: ~2 rows (aproximadamente)
INSERT INTO `medico_especialidad` (`medico_especialidad_id`, `medico_id`, `especialidad_id`, `estatus_med`) VALUES
	(1, 1, 1, '1'),
	(2, 1, 2, '1');

-- Volcando estructura para tabla shenque_db.paciente
CREATE TABLE IF NOT EXISTS `paciente` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.paciente: ~2 rows (aproximadamente)
INSERT INTO `paciente` (`paciente_id`, `cedula`, `nombre`, `apellidos`, `fecha_nacimiento`, `edad`, `telefono`, `direccion`, `tipo_paciente`, `estatus_pac`) VALUES
	(1, 29527505, 'Enrique', 'Chacón', '2002-08-30', 20, '04121234123', 'Maracay', '1', '1'),
	(2, 28317069, 'Oriana', 'Blanco', '2001-09-28', 21, '04125134213', 'Cagua', '3', '1');

-- Volcando estructura para tabla shenque_db.paciente_beneficiado
CREATE TABLE IF NOT EXISTS `paciente_beneficiado` (
  `paciente_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `estatus_pac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`paciente_beneficiado_id`),
  KEY `fk_pacienteBeneficiado_paciente` (`paciente_id`),
  CONSTRAINT `fk_pacienteBeneficiado_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.paciente_beneficiado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla shenque_db.paciente_seguro
CREATE TABLE IF NOT EXISTS `paciente_seguro` (
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
  KEY `fk_paciente_seguro_paciente` (`paciente_id`),
  KEY `fk_paciente_seguro_seguro` (`seguro_id`),
  KEY `fk_paciente_seguro_empresa` (`empresa_id`),
  CONSTRAINT `fk_paciente_seguro_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_paciente_seguro_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_paciente_seguro_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.paciente_seguro: ~1 rows (aproximadamente)
INSERT INTO `paciente_seguro` (`paciente_seguro_id`, `paciente_id`, `seguro_id`, `empresa_id`, `tipo_seguro`, `cobertura_general`, `fecha_contra`, `saldo_disponible`, `estatus_pac`) VALUES
	(1, 2, 1, 1, '2', 3000, '2017-09-12', 3000, '1');

-- Volcando estructura para tabla shenque_db.pregunta_seguridad
CREATE TABLE IF NOT EXISTS `pregunta_seguridad` (
  `pregunta_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  `estatus_pre` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`pregunta_id`),
  KEY `fk_pregunta_usuario` (`usuario_id`),
  CONSTRAINT `fk_pregunta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.pregunta_seguridad: ~3 rows (aproximadamente)
INSERT INTO `pregunta_seguridad` (`pregunta_id`, `usuario_id`, `pregunta`, `respuesta`, `estatus_pre`) VALUES
	(1, 1, '1', 'azul', '1'),
	(2, 1, '1', 'azul', '1'),
	(3, 1, '1', 'azul', '1');

-- Volcando estructura para tabla shenque_db.proveedor
CREATE TABLE IF NOT EXISTS `proveedor` (
  `proveedor_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estatus_pro` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`proveedor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.proveedor: ~1 rows (aproximadamente)
INSERT INTO `proveedor` (`proveedor_id`, `nombre`, `ubicacion`, `estatus_pro`) VALUES
	(1, 'Distribuidora SAS', 'Cagua', '1');

-- Volcando estructura para tabla shenque_db.seguro
CREATE TABLE IF NOT EXISTS `seguro` (
  `seguro_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `rif` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `tipo_seguro` enum('1','2') NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`seguro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.seguro: ~1 rows (aproximadamente)
INSERT INTO `seguro` (`seguro_id`, `nombre`, `rif`, `direccion`, `telefono`, `tipo_seguro`, `estatus_seg`) VALUES
	(1, 'Seguros Miranda', 'J-323232312', 'Cagua', '04124123213', '2', '1');

-- Volcando estructura para tabla shenque_db.seguro_empresa
CREATE TABLE IF NOT EXISTS `seguro_empresa` (
  `seguro_empresa_id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`seguro_empresa_id`),
  KEY `fk_seguro_empresa_empresa` (`empresa_id`),
  KEY `fk_seguro_empresa_seguro` (`seguro_id`),
  CONSTRAINT `fk_seguro_empresa_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_seguro_empresa_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.seguro_empresa: ~1 rows (aproximadamente)
INSERT INTO `seguro_empresa` (`seguro_empresa_id`, `empresa_id`, `seguro_id`, `estatus_seg`) VALUES
	(1, 1, 1, '1');

-- Volcando estructura para tabla shenque_db.titular_beneficiado
CREATE TABLE IF NOT EXISTS `titular_beneficiado` (
  `titular_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_beneficiado_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_tit` enum('1','2') NOT NULL DEFAULT '1',
  `tipo_relacion` enum('1','2','3') NOT NULL,
  PRIMARY KEY (`titular_beneficiado_id`),
  KEY `fk_titular_beneficiado` (`paciente_beneficiado_id`),
  KEY `fk_titular_paciente` (`paciente_id`),
  CONSTRAINT `fk_titular_beneficiado` FOREIGN KEY (`paciente_beneficiado_id`) REFERENCES `paciente_beneficiado` (`paciente_beneficiado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_titular_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.titular_beneficiado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla shenque_db.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(16) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `tokken` varchar(10) DEFAULT NULL,
  `rol` int(11) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `estatus_usu` enum('1','2') NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `tokken` (`tokken`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla shenque_db.usuario: ~1 rows (aproximadamente)
INSERT INTO `usuario` (`usuario_id`, `nombre`, `clave`, `tokken`, `rol`, `pin`, `estatus_usu`, `fecha_creacion`) VALUES
	(1, 'enrique', '$2y$10$DRh0FnqwzdDS57UdXZtIu.VXUEbsf4nFAevWtTHSKCbiphgMG6Gn6', '0d40c7ec53', 2, '$2y$10$29d2/u4k4dBHW5sg0A2jkOS.2sKJtcy1Tkb8JooMi0qCCuk17MCxK', '1', '2023-05-04 03:21:43');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
