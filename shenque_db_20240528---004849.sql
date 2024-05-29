-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: shenque_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `antecedentes_medicos`
--

DROP TABLE IF EXISTS `antecedentes_medicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `antecedentes_medicos` (
  `antecedentes_medicos_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `tipo_antecedente_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estatus_ant` enum('1','2') NOT NULL DEFAULT '1',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`antecedentes_medicos_id`),
  KEY `paciente_id` (`paciente_id`),
  KEY `tipo_antecedente_id` (`tipo_antecedente_id`),
  CONSTRAINT `antecedentes_medicos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `antecedentes_medicos_ibfk_2` FOREIGN KEY (`tipo_antecedente_id`) REFERENCES `tipo_antecedente` (`tipo_antecedente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `antecedentes_medicos`
--

LOCK TABLES `antecedentes_medicos` WRITE;
/*!40000 ALTER TABLE `antecedentes_medicos` DISABLE KEYS */;
INSERT INTO `antecedentes_medicos` VALUES (1,1,2,'Reacción alérgica a la amoxicilina','2','2024-05-26 18:12:49'),(2,1,2,'Alergia a la amoxicilina','2','2024-05-26 18:18:34'),(3,1,2,'Alergia a la amoxicilina','2','2024-05-26 19:00:02');
/*!40000 ALTER TABLE `antecedentes_medicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditoria`
--

DROP TABLE IF EXISTS `auditoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auditoria` (
  `auditoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_id` int(11) NOT NULL,
  `accion` varchar(45) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`auditoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria`
--

LOCK TABLES `auditoria` WRITE;
/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */;
INSERT INTO `auditoria` VALUES (1,'2024-05-21 01:01:06',1,'inserción','Francis ha insertado un nuevo elemento Juan en el módulo pacientes'),(2,'2024-05-22 02:49:27',1,'inserción','El usuario Francis insertó la consulta por emergencia del paciente con cédula 17564745'),(3,'2024-05-25 23:18:49',1,'inserción','El usuario Francis insertó la consulta asegurada del paciente con cédula 17564745'),(4,'2024-05-26 18:12:39',1,'inserción','El usuario Francis insertó un nuevo antecedente médico de tipo 2 al paciente Juan con cédula 17564745'),(5,'2024-05-26 18:17:23',1,'inserción','El usuario Francis insertó un nuevo antecedente médico de tipo 2 al paciente Juan con cédula 17564745'),(6,'2024-05-26 18:19:26',1,'inserción','El usuario Francis insertó un nuevo antecedente médico de tipo 2 al paciente Juan con cédula 17564745'),(7,'2024-05-26 18:42:44',1,'eliminación','El usuario Francis eliminó el antecedente_id 3 al paciente  con cédula '),(8,'2024-05-26 18:44:03',1,'eliminación','El usuario Francis eliminó el antecedente_id 3 al paciente  con cédula '),(9,'2024-05-26 18:50:11',1,'eliminación','El usuario Francis eliminó el antecedente_id 3 al paciente Juan con cédula 17564745'),(10,'2024-05-26 18:59:41',1,'eliminación','El usuario Francis eliminó el antecedente_id 3 al paciente Juan con cédula 17564745'),(11,'2024-05-26 19:00:02',1,'eliminación','El usuario Francis eliminó el antecedente_id 3 al paciente Juan con cédula 17564745'),(12,'2024-05-27 18:34:03',1,'inserción','Francis ha insertado un nuevo elemento Gabriel en el módulo pacientes'),(13,'2024-05-27 18:37:05',1,'inserción','El usuario Francis insertó la consulta por emergencia del paciente con cédula 17564745'),(14,'2024-05-27 18:44:33',1,'inserción','El usuario Francis insertó la consulta por emergencia del paciente con cédula 17564745'),(15,'2024-05-27 18:46:20',1,'inserción','El usuario Francis insertó la consulta por emergencia del paciente con cédula 17564745'),(16,'2024-05-27 18:53:53',1,'inserción','Francis ha insertado un nuevo elemento Juan en el módulo pacientes'),(17,'2024-05-27 18:59:21',1,'inserción','Francis ha insertado un nuevo elemento Miguel en el módulo pacientes'),(18,'2024-05-27 19:00:24',1,'inserción','El usuario Francis insertó la consulta natural del paciente con cédula 12343546'),(19,'2024-05-27 19:04:13',1,'inserción','Francis ha insertado un nuevo elemento Juan en el módulo pacientes'),(20,'2024-05-27 19:04:47',1,'inserción','El usuario Francis insertó la consulta natural del paciente con cédula 28236343'),(21,'2024-05-27 19:09:42',1,'inserción','Francis ha insertado un nuevo elemento Inyectadora 15ml en el módulo insumos'),(22,'2024-05-27 19:27:15',1,'inserción','El usuario Francis insertó la consulta natural del paciente con cédula 10876895'),(23,'2024-05-27 19:38:43',1,'inserción','Francis ha insertado un nuevo elemento Gonza en el módulo pacientes'),(24,'2024-05-27 19:41:36',1,'inserción','El usuario Francis insertó la consulta natural del paciente con cédula 2145654'),(25,'2024-05-27 20:07:26',1,'inserción','El usuario Francis insertó la consulta asegurada del paciente con cédula 13213123'),(26,'2024-05-27 21:23:13',1,'actualización','El usuario Francis cambio a pagada la orden de médico con id 00000001'),(27,'2024-05-27 21:40:34',1,'actualización','El usuario Francis cambio a pagada la orden de médico con id 00000001'),(28,'2024-05-27 21:42:48',1,'actualización','El usuario Francis cambio a pagada la orden de médico con id 00000001'),(29,'2024-05-27 21:46:22',1,'actualización','El usuario Francis cambio a pagada la orden de médico con id 00000001'),(30,'2024-05-27 21:46:58',1,'actualización','El usuario Francis cambio a pagada la orden de médico con id 00000001'),(31,'2024-05-27 21:58:47',1,'inserción','Francis ha insertado un nuevo elemento Industrias INC en el módulo proveedores'),(32,'2024-05-27 22:02:35',1,'inserción','Francis ha insertado un nuevo elemento Inyectadora 20ml en el módulo insumos'),(33,'2024-05-27 22:04:22',1,'inserción','Francis ha insertado un nuevo elemento Banditas en el módulo insumos'),(34,'2024-05-27 22:12:13',1,'inserción','Francis ha insertado un nuevo elemento Verizonn en el módulo empresas'),(35,'2024-05-27 22:13:26',1,'inserción','Francis ha insertado un nuevo elemento Seguros Cuadrado C.A en el módulo seguros'),(36,'2024-05-27 22:14:27',1,'actualización','Francis ha actualizado al elemento id 15 los campos nombre en el módulo seguros'),(37,'2024-05-27 22:15:35',1,'inserción','El usuario Francis insertó un nuevo medicamento de tipo 1 llamado Loratadina'),(38,'2024-05-27 22:19:32',1,'inserción','Francis ha insertado un nuevo elemento GCH en el módulo exámenes'),(39,'2024-05-27 22:24:41',1,'inserción','Francis ha insertado un nuevo elemento Oriana en el módulo pacientes'),(40,'2024-05-27 22:29:48',1,'inserción','El usuario Francis insertó la consulta natural del paciente con cédula 12343546'),(41,'2024-05-27 22:33:31',1,'inserción','El usuario Francis insertó la consulta asegurada del paciente con cédula 13213123'),(42,'2024-05-27 22:37:48',1,'inserción','El usuario Francis insertó la consulta por emergencia del paciente con cédula 2145654'),(43,'2024-05-27 22:40:05',1,'inserción','El usuario Francis insertó la consulta por emergencia del paciente con cédula 29765768');
/*!40000 ALTER TABLE `auditoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cita` (
  `cita_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `estatus_cit` enum('1','2','3','4',' 5') NOT NULL,
  PRIMARY KEY (`cita_id`),
  KEY `especialidad_id` (`especialidad_id`),
  KEY `medico_id` (`medico_id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (1,1,4,10,'2024-05-29','09:30:00','09:00:00','control',17564745,20,'2','2','4'),(3,1,4,10,'2024-05-31','11:30:00','11:00:00','test 1',17564745,50,'2','2','1'),(4,2,3,1,'2024-05-28','10:40:00','10:10:00','Control',12343546,0,'1','2','4'),(5,3,3,6,'2024-06-26','07:40:00','07:10:00','Control',2145654,0,'2','2','3'),(6,4,4,10,'2024-05-31','12:05:00','11:35:00','Control',10876895,0,'1','2','4'),(7,3,1,2,'2024-06-05','09:10:00','08:40:00','Motivo asegurado',2145654,0,'1','2','4'),(8,6,1,2,'2024-05-30','13:30:00','13:00:00','Posible tdah',13213123,25,'2','2','4'),(9,3,3,1,'2024-05-29','07:40:00','07:10:00','Control',2145654,0,'2','2','3'),(10,6,3,1,'2024-05-29','08:15:00','07:45:00','control',13213123,25,'2','2','4');
/*!40000 ALTER TABLE `cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita_examen`
--

DROP TABLE IF EXISTS `cita_examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cita_examen` (
  `cita_examen_id` int(11) NOT NULL AUTO_INCREMENT,
  `cita_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `precio_examen_bs` float NOT NULL,
  `precio_examen_usd` float NOT NULL,
  `cubierto_por` enum('1','2','3') NOT NULL DEFAULT '1',
  `monto_cubierto_bs` float NOT NULL DEFAULT 0,
  `monto_cubierto_usd` float NOT NULL DEFAULT 0,
  `monto_cubierto` float NOT NULL DEFAULT 0,
  `estatus_cit` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`cita_examen_id`),
  KEY `cita_id` (`cita_id`),
  KEY `examen_id` (`examen_id`),
  CONSTRAINT `cita_examen_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cita_examen_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita_examen`
--

LOCK TABLES `cita_examen` WRITE;
/*!40000 ALTER TABLE `cita_examen` DISABLE KEYS */;
INSERT INTO `cita_examen` VALUES (1,1,3,0,25,'3',162.95,5,0,'1'),(2,3,3,0,30,'1',0,0,0,'1'),(3,9,17,0,20,'1',0,0,0,'1');
/*!40000 ALTER TABLE `cita_examen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cita_seguro`
--

DROP TABLE IF EXISTS `cita_seguro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cita_seguro` (
  `cita_seguro_id` int(11) NOT NULL AUTO_INCREMENT,
  `cita_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `clave` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`cita_seguro_id`),
  KEY `cita_id` (`cita_id`),
  KEY `seguro_id` (`seguro_id`),
  CONSTRAINT `cita_seguro_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cita_seguro_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita_seguro`
--

LOCK TABLES `cita_seguro` WRITE;
/*!40000 ALTER TABLE `cita_seguro` DISABLE KEYS */;
INSERT INTO `cita_seguro` VALUES (1,1,1,'hdghdg2342'),(2,3,1,'clave1'),(3,5,8,NULL),(4,8,1,'A3213'),(5,9,8,NULL),(6,10,2,'clave2');
/*!40000 ALTER TABLE `cita_seguro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra_insumo`
--

DROP TABLE IF EXISTS `compra_insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compra_insumo` (
  `compra_insumo_id` int(9) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `insumo_id` int(11) NOT NULL,
  `factura_compra_id` int(9) unsigned zerofill NOT NULL,
  `unidades` int(11) NOT NULL,
  `precio_unit_bs` float NOT NULL,
  `precio_total_bs` float NOT NULL,
  `precio_unit_usd` float NOT NULL,
  `precio_total_usd` float NOT NULL,
  PRIMARY KEY (`compra_insumo_id`),
  KEY `insumo_id` (`insumo_id`),
  KEY `factura_compra_id` (`factura_compra_id`),
  CONSTRAINT `compra_insumo_ibfk_1` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `compra_insumo_ibfk_2` FOREIGN KEY (`factura_compra_id`) REFERENCES `factura_compra` (`factura_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra_insumo`
--

LOCK TABLES `compra_insumo` WRITE;
/*!40000 ALTER TABLE `compra_insumo` DISABLE KEYS */;
INSERT INTO `compra_insumo` VALUES (000000001,4,000000001,10,10,116,0.31,3.56),(000000002,1,000000001,10,10,116,0.31,3.56),(000000003,4,000000002,10,10,116,0.31,3.56),(000000004,1,000000002,10,10,116,0.31,3.56),(000000005,8,000000003,35,35,1421,1.07,43.6),(000000006,10,000000004,40,40,1856,1.23,56.95),(000000007,1,000000005,40,40,1856,1.23,56.95);
/*!40000 ALTER TABLE `compra_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta`
--

DROP TABLE IF EXISTS `consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta` (
  `consulta_id` int(11) NOT NULL AUTO_INCREMENT,
  `peso` float DEFAULT NULL,
  `altura` float DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `fecha_consulta` date NOT NULL,
  `es_emergencia` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_servicio` enum('1','2') NOT NULL DEFAULT '1',
  `estatus_con` enum('1','2','3','4') NOT NULL DEFAULT '1',
  PRIMARY KEY (`consulta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta`
--

LOCK TABLES `consulta` WRITE;
/*!40000 ALTER TABLE `consulta` DISABLE KEYS */;
INSERT INTO `consulta` VALUES (1,54,1.6,NULL,'2024-05-21',1,'1','3'),(2,65,1.54,'control perfecto','2024-05-29',0,'2','3'),(5,56,1.56,NULL,'2024-05-27',1,'1','1'),(6,80,1.65,NULL,'2024-05-27',0,'1','1'),(7,68,1.68,NULL,'2024-05-27',0,'1','1'),(8,60,1.3,'Control aprobado','2024-05-31',0,'2','3'),(9,70,1.68,'Esta consulta es asegurada','2024-06-05',0,'2','1'),(10,50,1.7,'Consulta con cita asegurada','2024-05-30',0,'2','3'),(11,60,1.6,'Todo en perfecto estado','2024-05-28',0,'2','1'),(12,56,1.56,'Sin obsevaciones','2024-05-29',0,'2','3'),(13,70,1.7,NULL,'2024-05-27',1,'1','1'),(14,56,1.56,NULL,'2024-05-27',1,'1','1');
/*!40000 ALTER TABLE `consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_cita`
--

DROP TABLE IF EXISTS `consulta_cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_cita` (
  `consulta_cita_id` int(11) NOT NULL AUTO_INCREMENT,
  `cita_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`consulta_cita_id`),
  KEY `cita_id` (`cita_id`),
  KEY `consulta_id` (`consulta_id`),
  CONSTRAINT `consulta_cita_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`cita_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_cita_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_cita`
--

LOCK TABLES `consulta_cita` WRITE;
/*!40000 ALTER TABLE `consulta_cita` DISABLE KEYS */;
INSERT INTO `consulta_cita` VALUES (1,1,2,'1'),(2,6,8,'1'),(3,7,9,'1'),(4,8,10,'1'),(5,4,11,'1'),(6,10,12,'1');
/*!40000 ALTER TABLE `consulta_cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_emergencia`
--

DROP TABLE IF EXISTS `consulta_emergencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_emergencia` (
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
  `total_insumos` float NOT NULL,
  `total_insumos_bs` float NOT NULL,
  `total_examenes` float NOT NULL,
  `total_examenes_bs` float NOT NULL,
  `total_consulta` float NOT NULL,
  `total_consulta_bs` float NOT NULL,
  `monto_aprobado` float NOT NULL DEFAULT 0,
  `monto_cubierto_usd` float NOT NULL DEFAULT 0,
  `monto_cubierto_bs` float NOT NULL DEFAULT 0,
  `autorizacion` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`consulta_emergencia_id`),
  KEY `consulta_id` (`consulta_id`),
  KEY `paciente_id` (`paciente_id`),
  KEY `seguro_id` (`seguro_id`),
  CONSTRAINT `consulta_emergencia_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_emergencia_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_emergencia_ibfk_3` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_emergencia`
--

LOCK TABLES `consulta_emergencia` WRITE;
/*!40000 ALTER TABLE `consulta_emergencia` DISABLE KEYS */;
INSERT INTO `consulta_emergencia` VALUES (1,1,1,17564745,1,0,0,15,488.85,0,0,0,0,4.5,146.66,20,651.8,15,488.85,128.4,4184.56,15,488.85,197.9,0,150,47.9,1561.06,'gaf3243'),(4,5,1,17564745,1,0,0,0,0,0,0,0,0,0,0,0,0,10,0,0,0,0,0,10,0,10,0,0,'auth'),(5,13,3,2145654,8,0,0,5,0,0,0,0,0,4.5,0,8,0,10,0,0,0,0,0,27.5,0,27.5,0,0,'auth'),(6,14,7,29765768,1,0,0,10,0,0,0,0,0,0,0,10,0,10,0,0,0,0,0,30,0,30,0,0,'auth');
/*!40000 ALTER TABLE `consulta_emergencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_examen`
--

DROP TABLE IF EXISTS `consulta_examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_examen` (
  `consulta_examen_id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL,
  `precio_examen_bs` float NOT NULL,
  `precio_examen_usd` float NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  `cubierto_por` enum('1','2','3') NOT NULL DEFAULT '1',
  `monto_cubierto_bs` float NOT NULL DEFAULT 0,
  `monto_cubierto_usd` float NOT NULL DEFAULT 0,
  `monto_cubierto` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`consulta_examen_id`),
  KEY `consulta_id` (`consulta_id`),
  KEY `examen_id` (`examen_id`),
  CONSTRAINT `consulta_examen_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_examen_ibfk_2` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_examen`
--

LOCK TABLES `consulta_examen` WRITE;
/*!40000 ALTER TABLE `consulta_examen` DISABLE KEYS */;
INSERT INTO `consulta_examen` VALUES (1,1,12,0,15,'1','1',0,0,0),(3,8,3,977.7,30,'1','1',0,0,0);
/*!40000 ALTER TABLE `consulta_examen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_indicaciones`
--

DROP TABLE IF EXISTS `consulta_indicaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_indicaciones` (
  `consulta_indicaciones_id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`consulta_indicaciones_id`),
  KEY `consulta_id` (`consulta_id`),
  CONSTRAINT `consulta_indicaciones_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_indicaciones`
--

LOCK TABLES `consulta_indicaciones` WRITE;
/*!40000 ALTER TABLE `consulta_indicaciones` DISABLE KEYS */;
INSERT INTO `consulta_indicaciones` VALUES (1,2,'Tomar awa'),(2,8,'Todo chido'),(3,9,'Debe tener preocupación'),(4,10,'1 dia');
/*!40000 ALTER TABLE `consulta_indicaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_insumo`
--

DROP TABLE IF EXISTS `consulta_insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_insumo` (
  `consulta_insumo_id` int(11) NOT NULL AUTO_INCREMENT,
  `insumo_id` int(11) NOT NULL,
  `consulta_id` int(11) NOT NULL,
  `cantidad` int(8) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  `precio_insumo_bs` float NOT NULL,
  `precio_insumo_usd` float NOT NULL,
  PRIMARY KEY (`consulta_insumo_id`),
  KEY `insumo_id` (`insumo_id`),
  KEY `consulta_id` (`consulta_id`),
  CONSTRAINT `consulta_insumo_ibfk_1` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_insumo_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_insumo`
--

LOCK TABLES `consulta_insumo` WRITE;
/*!40000 ALTER TABLE `consulta_insumo` DISABLE KEYS */;
INSERT INTO `consulta_insumo` VALUES (1,27,1,2,'1',73.33,2.25),(2,28,1,120,'1',34.87,1.07),(3,27,13,2,'1',0,2.25),(4,28,14,2,'1',0,1.07);
/*!40000 ALTER TABLE `consulta_insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_recipe`
--

DROP TABLE IF EXISTS `consulta_recipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_recipe` (
  `consulta_recipe_id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `medicamento_id` int(11) NOT NULL,
  `uso` text NOT NULL,
  PRIMARY KEY (`consulta_recipe_id`),
  KEY `consulta_id` (`consulta_id`),
  KEY `medicamento_id` (`medicamento_id`),
  CONSTRAINT `consulta_recipe_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_recipe_ibfk_2` FOREIGN KEY (`medicamento_id`) REFERENCES `medicamento` (`medicamento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_recipe`
--

LOCK TABLES `consulta_recipe` WRITE;
/*!40000 ALTER TABLE `consulta_recipe` DISABLE KEYS */;
INSERT INTO `consulta_recipe` VALUES (1,8,5,'1 diaria'),(2,9,5,'20'),(3,10,25,'Dia'),(4,11,28,'1 tableta diaria durante 7 dias');
/*!40000 ALTER TABLE `consulta_recipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_referidos`
--

DROP TABLE IF EXISTS `consulta_referidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_referidos` (
  `consulta_referidos_id` int(9) NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`consulta_referidos_id`),
  KEY `consulta_id` (`consulta_id`),
  KEY `especialidad_id` (`especialidad_id`),
  CONSTRAINT `consulta_referidos_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_referidos_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_referidos`
--

LOCK TABLES `consulta_referidos` WRITE;
/*!40000 ALTER TABLE `consulta_referidos` DISABLE KEYS */;
INSERT INTO `consulta_referidos` VALUES (1,8,1,'1'),(2,9,5,'1'),(3,10,1,'1'),(4,11,7,'1');
/*!40000 ALTER TABLE `consulta_referidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_seguro`
--

DROP TABLE IF EXISTS `consulta_seguro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_seguro` (
  `consulta_seguro_id` int(9) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `tipo_servicio` varchar(50) NOT NULL,
  `fecha_ocurrencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `monto_consulta_usd` float NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  `monto_consulta_bs` float NOT NULL,
  `cobertura_seguro` float NOT NULL,
  PRIMARY KEY (`consulta_seguro_id`),
  KEY `consulta_id` (`consulta_id`),
  KEY `seguro_id` (`seguro_id`),
  CONSTRAINT `consulta_seguro_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_seguro_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_seguro`
--

LOCK TABLES `consulta_seguro` WRITE;
/*!40000 ALTER TABLE `consulta_seguro` DISABLE KEYS */;
INSERT INTO `consulta_seguro` VALUES (000000001,1,1,'','2024-05-22 04:54:04',197.9,'',6449.56,150),(000000002,2,1,'','2024-05-26 00:05:13',0,'1',0,20),(000000003,10,1,'','2024-05-27 20:36:32',25,'',814.75,25),(000000004,12,2,'','2024-05-27 22:34:58',25,'',814.75,25);
/*!40000 ALTER TABLE `consulta_seguro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_sin_cita`
--

DROP TABLE IF EXISTS `consulta_sin_cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_sin_cita` (
  `consulta_sin_cita_id` int(11) NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`consulta_sin_cita_id`),
  KEY `consulta_id` (`consulta_id`),
  KEY `especialidad_id` (`especialidad_id`),
  KEY `medico_id` (`medico_id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `consulta_sin_cita_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_sin_cita_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_sin_cita_ibfk_3` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_sin_cita_ibfk_4` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_sin_cita`
--

LOCK TABLES `consulta_sin_cita` WRITE;
/*!40000 ALTER TABLE `consulta_sin_cita` DISABLE KEYS */;
INSERT INTO `consulta_sin_cita` VALUES (1,1,9,4,1,'1'),(2,6,1,3,2,'1'),(3,7,10,4,5,'1');
/*!40000 ALTER TABLE `consulta_sin_cita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `empresa_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `rif` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `estatus_emp` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`empresa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'Selva','J-233412455','Campo Alegre','1'),(2,'Grupo Farmacos','J-243343414','Montaña Fresca','1'),(4,'Manpa','J-164112513','23 de enero','1'),(5,'Hilados Flexilón','J-243543214','23 de enero','1'),(6,'Sambil','J-234234234','Caracas','1'),(7,'Los Andes','J-298389123','Aragua','1'),(8,'Cantv C.A','J-122434234','Caracas','1'),(9,'Kellogs','J-234342342','Maracay','1'),(10,'Empresas Diana','J-214123423','Miranda','1'),(11,'Groisleña','J-356453453','Vargas','1'),(12,'Coca Cola','J-121231231','San Juan','1'),(13,'Grupo Orinoco','J-213231231','Maracaibo','1'),(14,'Crystallex','J-141234141','Monagas','1'),(15,'Banco de Venezuela','J-232312783','Caracas','1'),(16,'Sincor','J-465646546','Trujillo','1'),(17,'La Farge','J-567567567','Táchira','1'),(18,'Rojo TV C.A','J-876234767','Carabobo','1'),(19,'Empresa de auditoría','J-453236545','San Vicente','2'),(20,'Verizonn','J-312312444','Cagua','1');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidad`
--

DROP TABLE IF EXISTS `especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especialidad` (
  `especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `estatus_esp` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`especialidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES (1,'Traumatología','1'),(2,'Psicología','1'),(3,'Pediatría','1'),(4,'Oncología','2'),(5,'Otorrinolaringología','1'),(6,'Oftamología','1'),(7,'Cardiología','1'),(8,'Dermatología','1'),(9,'Endocrinología','1'),(10,'Gastroenterología','1'),(11,'Geriatría','1'),(12,'Hematología','1'),(13,'Infectología','1'),(14,'Inmunología','1'),(15,'Nefrología','1'),(16,'Neumonología','1'),(17,'Neurología','1'),(18,'Nutriología','1'),(19,'Oncología','1'),(20,'Ortopedia','1'),(21,'Oncología Radioterápica','1'),(22,'Patología','1'),(23,'Proctología','1'),(24,'Psiquiatría','1'),(25,'Rehabilitación','1'),(26,'Reumatología','1'),(27,'Toxicología','1'),(28,'Urología','1'),(29,'Acupuntura','1'),(30,'Alergología','1'),(31,'Andrología','1'),(32,'Angiología','1'),(33,'Bioquímica Clínica','1'),(34,'Cirugía','1'),(35,'Cirugía Cardiovascular','1'),(36,'Cirugía General','1'),(37,'Cirugía Plástica','1'),(38,'Cirugía Torácica','1'),(39,'Cirugía Vascular','1'),(40,'Dietética y Nutrición','1'),(41,'Ecografía','1'),(42,'Epidemiología','1'),(43,'Fisioterapia','1'),(44,'Genética Médica','1'),(45,'Ginecología','1'),(46,'Homeopatía','1'),(47,'Inmunología Clínica','1'),(48,'Logopedia','1'),(49,'Medicina Deportiva','1'),(50,'Medicina Familiar','1'),(51,'Medicina Física y Rehabilitación','1'),(52,'Medicina Nuclear','1'),(53,'Medicina Preventiva','1'),(54,'Microbiología y Parasitología','1'),(55,'Naturopatía','2'),(56,'Medicina General','1'),(57,'Traumato','1'),(84,'Neurocirugía','1'),(85,'Gatroenterología pediátrica','2');
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examen`
--

DROP TABLE IF EXISTS `examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examen` (
  `examen_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `precio_examen` int(11) DEFAULT NULL,
  `tipo` enum('1','2','3') NOT NULL,
  `hecho_aqui` tinyint(1) NOT NULL DEFAULT 0,
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`examen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examen`
--

LOCK TABLES `examen` WRITE;
/*!40000 ALTER TABLE `examen` DISABLE KEYS */;
INSERT INTO `examen` VALUES (1,'Perfil 20',21,'2',1,'1'),(2,'Hematología completas',15,'2',1,'1'),(3,'Perfil Hepático',30,'2',1,'1'),(4,'Perfil Lípidico',56,'2',0,'1'),(5,'a',21,'2',1,'2'),(6,'Ecocardiograma',65,'1',1,'1'),(7,'a',21,'1',1,'2'),(8,'Ecografía Renal',15,'1',0,'1'),(9,'Análisis de Sangre Completo',25,'2',1,'1'),(10,'Ultrasonido Abdominal',20,'3',1,'1'),(11,'Ultrasonido Obstétrico',22,'3',0,'1'),(12,'Ecografía de Tiroides',15,'1',1,'1'),(13,'Hemograma',12,'2',0,'1'),(14,'Ultrasonido Doppler Vascular',25,'3',1,'1'),(15,'Ecografía Muscular',18,'1',0,'1'),(16,'E',18,'1',0,'2'),(17,'Radiografía de Torax',20,'1',1,'1'),(18,'Examen de Orina Completo',12,'2',0,'1'),(19,'Resonancia Magnética Cerebral',50,'3',1,'1'),(20,'Tomografía Computarizada Abdominal',30,'1',0,'1'),(21,'Biopsia de Hígado',40,'2',1,'1'),(22,'Ecografía Ocular',25,'3',0,'1'),(23,'Prueba de Coagulación Sanguínea',15,'1',1,'1'),(24,'Examen de Glucosa en Sangre',10,'2',0,'1'),(25,'Ecocardiografía Fetal',35,'3',1,'1'),(26,'Densitometría Ósea',28,'1',0,'1'),(27,'Análisis de Tiroides',18,'2',0,'1'),(28,'Ecografía Articular',20,'3',1,'1'),(29,'Tomografía de Columna Vertebral',30,'1',0,'1'),(30,'Perfil de Enzimas Hepáticas',15,'2',1,'1'),(31,'Ultrasonido Mamario',28,'3',0,'1'),(32,'Electrocardiograma',12,'1',1,'1'),(33,'Examen de Sangre Oculta en Heces',20,'2',0,'1'),(34,'Ecografía Renal y Vesical',22,'3',1,'1'),(35,'Prueba de Función Pulmonar',35,'1',0,'1'),(36,'exaneb de prueba',23,'1',1,'2'),(38,'mamografía',45,'2',0,'1'),(39,'Escala de ansiedad de Hamilton',23,'3',1,'2'),(40,'examen prueba 1',35,'1',0,'1'),(41,'Examen de prueba 2',35,'1',0,'1'),(42,'Examen de prueba 3',35,'1',0,'1'),(43,'GCH',20,'2',0,'1');
/*!40000 ALTER TABLE `examen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examen_especialidad`
--

DROP TABLE IF EXISTS `examen_especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examen_especialidad` (
  `examen_especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `examen_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`examen_especialidad_id`),
  KEY `examen_id` (`examen_id`),
  KEY `especialidad_id` (`especialidad_id`),
  CONSTRAINT `examen_especialidad_ibfk_1` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`examen_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `examen_especialidad_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examen_especialidad`
--

LOCK TABLES `examen_especialidad` WRITE;
/*!40000 ALTER TABLE `examen_especialidad` DISABLE KEYS */;
INSERT INTO `examen_especialidad` VALUES (1,42,1,'1'),(2,42,2,'2'),(3,40,3,'1'),(4,8,15,'1'),(5,6,7,'1'),(6,6,35,'1'),(7,3,10,'1'),(8,4,7,'1'),(9,4,35,'1'),(10,10,56,'1'),(11,11,45,'1'),(12,12,56,'1'),(13,12,9,'1'),(14,13,35,'1'),(15,14,35,'1'),(16,14,56,'1'),(17,14,7,'1'),(18,14,53,'1'),(19,18,56,'1'),(20,17,1,'1'),(21,15,1,'1'),(22,43,56,'1');
/*!40000 ALTER TABLE `examen_especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_compra`
--

DROP TABLE IF EXISTS `factura_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_compra` (
  `factura_compra_id` int(9) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `total_productos` int(11) NOT NULL,
  `monto_con_iva` float NOT NULL,
  `monto_sin_iva` float NOT NULL,
  `monto_usd` float NOT NULL,
  `excento` float DEFAULT NULL,
  `motivo_cancelacion` text DEFAULT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_compra_id`),
  KEY `proveedor_id` (`proveedor_id`),
  CONSTRAINT `factura_compra_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_compra`
--

LOCK TABLES `factura_compra` WRITE;
/*!40000 ALTER TABLE `factura_compra` DISABLE KEYS */;
INSERT INTO `factura_compra` VALUES (000000001,1,'2024-05-22 00:00:00',20,232,200,7.12,32,NULL,'1'),(000000002,1,'2024-05-22 00:00:00',20,232,200,7.12,32,NULL,'1'),(000000003,2,'2024-05-22 00:00:00',35,1421,1225,43.6,196,NULL,'1'),(000000004,1,'2024-05-27 00:00:00',40,1856,1600,56.95,256,NULL,'1'),(000000005,1,'2024-05-15 00:00:00',40,1856,1600,56.95,256,NULL,'1');
/*!40000 ALTER TABLE `factura_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_consulta`
--

DROP TABLE IF EXISTS `factura_consulta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_consulta` (
  `factura_consulta_id` int(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `consulta_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `monto_consulta_bs` float NOT NULL,
  `monto_consulta_usd` float NOT NULL,
  `tipo_consulta` enum('1','2') NOT NULL,
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_consulta_id`),
  KEY `consulta_id` (`consulta_id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `factura_consulta_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `factura_consulta_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_consulta`
--

LOCK TABLES `factura_consulta` WRITE;
/*!40000 ALTER TABLE `factura_consulta` DISABLE KEYS */;
INSERT INTO `factura_consulta` VALUES (00000002,1,1,'debito',1561.06,47.9,'1','1'),(00000003,2,1,'efectivo',162.95,5,'1','1'),(00000004,8,4,'efectivo',814.75,25,'1','1');
/*!40000 ALTER TABLE `factura_consulta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_medico`
--

DROP TABLE IF EXISTS `factura_medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_medico` (
  `factura_medico_id` int(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
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
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_medico_id`),
  KEY `medico_id` (`medico_id`),
  CONSTRAINT `factura_medico_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_medico`
--

LOCK TABLES `factura_medico` WRITE;
/*!40000 ALTER TABLE `factura_medico` DISABLE KEYS */;
INSERT INTO `factura_medico` VALUES (00000001,1,8.5,0,25,0,0,8.5,0,'2024-05-27','2024-05-27 21:46:58',1,0,'3');
/*!40000 ALTER TABLE `factura_medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_mensajeria`
--

DROP TABLE IF EXISTS `factura_mensajeria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_mensajeria` (
  `factura_mensajeria_id` int(9) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `fecha_mensajeria` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `seguro_id` int(11) NOT NULL,
  `total_mensajeria_bs` float NOT NULL,
  `total_mensajeria_usd` float NOT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_mensajeria_id`),
  KEY `fk_mensajeria_seguro` (`seguro_id`),
  CONSTRAINT `fk_mensajeria_seguro` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_mensajeria`
--

LOCK TABLES `factura_mensajeria` WRITE;
/*!40000 ALTER TABLE `factura_mensajeria` DISABLE KEYS */;
INSERT INTO `factura_mensajeria` VALUES (000000003,'2024-05-22 04:54:04',1,4823.32,148,'1'),(000000004,'2024-05-27 20:36:32',1,814.75,25,'1'),(000000005,'2024-05-27 22:34:58',2,814.75,25,'1');
/*!40000 ALTER TABLE `factura_mensajeria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_mensajeria_consultas`
--

DROP TABLE IF EXISTS `factura_mensajeria_consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_mensajeria_consultas` (
  `factura_mensajeria_consultas_id` int(9) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `factura_mensajeria_id` int(9) unsigned zerofill NOT NULL,
  `consulta_seguro_id` int(9) unsigned zerofill NOT NULL,
  `fecha_mensajeria_consultas` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estatus_fac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_mensajeria_consultas_id`),
  KEY `fk_mensajeria_consultas` (`consulta_seguro_id`),
  KEY `factura_mensajeria_id` (`factura_mensajeria_id`),
  CONSTRAINT `factura_mensajeria_consultas_ibfk_1` FOREIGN KEY (`consulta_seguro_id`) REFERENCES `consulta_seguro` (`consulta_seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `factura_mensajeria_consultas_ibfk_2` FOREIGN KEY (`factura_mensajeria_id`) REFERENCES `factura_mensajeria` (`factura_mensajeria_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_mensajeria_consultas`
--

LOCK TABLES `factura_mensajeria_consultas` WRITE;
/*!40000 ALTER TABLE `factura_mensajeria_consultas` DISABLE KEYS */;
INSERT INTO `factura_mensajeria_consultas` VALUES (000000003,000000003,000000001,'2024-05-22 04:54:04','1'),(000000004,000000004,000000003,'2024-05-27 20:36:32','1'),(000000005,000000005,000000004,'2024-05-27 22:34:58','1');
/*!40000 ALTER TABLE `factura_mensajeria_consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_seguro`
--

DROP TABLE IF EXISTS `factura_seguro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_seguro` (
  `factura_seguro_id` int(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `seguro_id` int(11) NOT NULL,
  `nro_control` int(11) DEFAULT NULL,
  `mes` varchar(10) NOT NULL,
  `fecha_ocurrencia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_vencimiento` date NOT NULL,
  `monto_usd` float NOT NULL,
  `monto_bs` float NOT NULL,
  `estatus_fac` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`factura_seguro_id`),
  KEY `seguro_id` (`seguro_id`),
  CONSTRAINT `factura_seguro_ibfk_1` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_seguro`
--

LOCK TABLES `factura_seguro` WRITE;
/*!40000 ALTER TABLE `factura_seguro` DISABLE KEYS */;
INSERT INTO `factura_seguro` VALUES (00000001,1,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',222.9,7264.31,'1'),(00000002,2,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000003,3,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000004,4,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000005,8,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000006,9,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000007,10,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000008,11,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000009,12,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000010,13,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1'),(00000011,14,NULL,'mayo','2024-05-27 20:41:22','2024-06-01',0,0,'1');
/*!40000 ALTER TABLE `factura_seguro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `global`
--

DROP TABLE IF EXISTS `global`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global` (
  `global_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`global_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `global`
--

LOCK TABLES `global` WRITE;
/*!40000 ALTER TABLE `global` DISABLE KEYS */;
INSERT INTO `global` VALUES (1,'porcentaje_medico','60'),(2,'cambio_divisa','32.59'),(3,'porcentaje_insumo','5');
/*!40000 ALTER TABLE `global` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario` (
  `horario_id` int(11) NOT NULL AUTO_INCREMENT,
  `medico_id` int(11) NOT NULL,
  `dias_semana` enum('lunes','martes','miercoles','jueves','viernes','sabado') NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_entrada` time NOT NULL,
  `estatus_hor` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`horario_id`),
  KEY `medico_id` (`medico_id`),
  CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` VALUES (1,1,'lunes','21:30:00','20:30:00','1'),(2,1,'miercoles','12:30:00','08:30:00','1'),(3,2,'lunes','17:55:00','03:55:00','1'),(4,2,'jueves','14:58:00','05:56:00','1'),(5,2,'martes','19:02:00','05:00:00','1'),(6,3,'lunes','20:10:00','08:10:00','1'),(7,3,'martes','18:10:00','10:10:00','1'),(8,3,'miercoles','16:10:00','07:10:00','1'),(9,4,'lunes','18:00:00','10:00:00','1'),(10,4,'miercoles','14:00:00','09:00:00','1'),(11,4,'viernes','16:00:00','11:00:00','1'),(12,5,'martes','14:00:00','08:00:00','1'),(13,5,'jueves','13:00:00','09:00:00','1'),(14,5,'sabado','15:00:00','10:00:00','1'),(15,6,'martes','17:00:00','09:00:00','1'),(16,6,'jueves','13:00:00','08:00:00','1'),(17,7,'lunes','19:00:00','14:00:00','1'),(18,7,'miercoles','12:00:00','08:00:00','1'),(19,8,'miercoles','16:00:00','10:00:00','1'),(20,8,'viernes','14:00:00','09:00:00','1'),(21,9,'jueves','15:00:00','09:00:00','1'),(22,9,'sabado','12:00:00','08:00:00','1'),(23,10,'martes','12:00:00','08:00:00','1'),(24,10,'jueves','18:00:00','13:00:00','1'),(25,10,'sabado','14:00:00','09:00:00','1'),(26,11,'lunes','17:00:00','11:00:00','1'),(27,11,'miercoles','15:00:00','10:00:00','1'),(28,12,'miercoles','14:00:00','09:00:00','1'),(29,12,'viernes','18:00:00','12:00:00','1'),(30,13,'jueves','16:00:00','10:00:00','1'),(31,13,'sabado','13:00:00','08:00:00','1'),(32,14,'lunes','15:00:00','09:00:00','1'),(33,14,'miercoles','14:00:00','10:00:00','1'),(34,14,'viernes','12:00:00','08:00:00','1'),(35,15,'martes','13:00:00','08:00:00','1'),(36,15,'jueves','14:00:00','09:00:00','1'),(37,15,'sabado','15:00:00','10:00:00','1'),(38,16,'lunes','16:00:00','11:00:00','1'),(39,16,'miercoles','18:00:00','12:00:00','1'),(40,17,'martes','15:00:00','10:00:00','1'),(41,17,'jueves','17:00:00','11:00:00','1'),(42,18,'miercoles','14:00:00','09:00:00','1'),(43,18,'viernes','13:00:00','08:00:00','1'),(44,19,'jueves','12:00:00','08:00:00','1'),(45,19,'sabado','13:00:00','09:00:00','1'),(46,20,'lunes','14:00:00','09:00:00','1'),(47,20,'miercoles','15:00:00','10:00:00','1'),(48,20,'viernes','16:00:00','11:00:00','1'),(49,21,'martes','13:00:00','08:00:00','1'),(50,21,'jueves','14:00:00','09:00:00','1'),(51,21,'sabado','15:00:00','10:00:00','1'),(52,22,'lunes','15:00:00','10:00:00','1'),(53,22,'miercoles','16:00:00','11:00:00','1'),(54,23,'jueves','13:00:00','08:00:00','1'),(55,23,'sabado','14:00:00','09:00:00','1'),(56,24,'lunes','14:00:00','08:00:00','1'),(57,24,'miercoles','15:00:00','09:00:00','1'),(58,24,'viernes','16:00:00','10:00:00','1'),(59,25,'martes','17:00:00','11:00:00','1'),(60,25,'jueves','18:00:00','12:00:00','1'),(61,26,'lunes','13:00:00','07:00:00','1'),(62,26,'miercoles','14:00:00','08:00:00','1'),(63,26,'viernes','15:00:00','09:00:00','1'),(64,27,'martes','14:00:00','09:00:00','1'),(65,27,'jueves','15:00:00','10:00:00','1'),(66,28,'miercoles','16:00:00','11:00:00','1'),(67,28,'viernes','17:00:00','12:00:00','1'),(68,29,'jueves','15:00:00','10:00:00','1'),(69,29,'sabado','16:00:00','11:00:00','1'),(70,30,'lunes','17:00:00','12:00:00','1'),(71,30,'miercoles','18:00:00','13:00:00','1'),(72,30,'viernes','19:00:00','14:00:00','1'),(73,31,'martes','13:00:00','08:00:00','1'),(74,31,'jueves','14:00:00','09:00:00','1'),(75,31,'sabado','15:00:00','10:00:00','1'),(76,32,'lunes','14:00:00','09:00:00','1'),(77,32,'miercoles','15:00:00','10:00:00','1'),(78,32,'viernes','16:00:00','11:00:00','1'),(79,33,'martes','17:00:00','12:00:00','1'),(80,33,'jueves','18:00:00','13:00:00','1'),(81,33,'sabado','19:00:00','14:00:00','1'),(82,38,'martes','17:00:00','12:00:00','1'),(83,39,'lunes','12:00:00','09:00:00','1'),(84,39,'martes','12:00:00','09:00:00','1');
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insumo`
--

DROP TABLE IF EXISTS `insumo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insumo` (
  `insumo_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL DEFAULT '0',
  `cantidad_min` int(11) NOT NULL,
  `cantidad_unidad` int(11) NOT NULL DEFAULT 0,
  `capacidad_unidad` int(11) NOT NULL,
  `cantidad_capacidad` int(11) NOT NULL,
  `precio` float NOT NULL DEFAULT 0,
  `tipo_medida` enum('1','2','3','4') NOT NULL,
  `es_cobrado` enum('0','1') NOT NULL,
  `tipo_insumo` enum('1','2') DEFAULT '1',
  `estatus_ins` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`insumo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (1,'Inyectadora 5ml',20,74,1,74,1.29,'1','1','1','1'),(2,'Inyectadora 10ml',20,0,0,0,2,'1','1','1','1'),(3,'inyéñ',1,0,0,0,1,'1','1','1','2'),(4,'Esparadrapo Estéril',20,20,0,0,0.33,'1','1','1','1'),(5,'Guantes Quirúrgicos',30,0,0,0,5,'1','1','1','1'),(6,'Venda Elástica 5cm',15,0,0,0,3,'1','1','1','1'),(7,'Algodón Hidrófilo',10,0,0,0,1.8,'1','1','1','1'),(8,'Termómetro Clínico',50,35,0,0,8.5,'1','1','1','1'),(9,'Sonda Foley 16Fr',15,0,0,0,12,'1','1','1','1'),(10,'Apósito Adhesivo Estéril',8,40,0,0,4.2,'1','1','1','1'),(11,'Gasas Estériles',25,0,0,0,2,'1','1','1','1'),(12,'Juego de Pinzas Quirúrgicas',5,0,0,0,15,'1','1','1','1'),(13,'Mascarilla Quirúrgica',40,0,0,0,1.2,'1','1','1','1'),(14,'Jabón Antiséptico',12,0,0,0,4.8,'1','1','1','1'),(15,'Bisturí Descartable',6,0,0,0,7.5,'1','1','1','1'),(16,'Silla de Ruedas Plegable',20,0,0,0,120,'1','1','1','1'),(17,'Cánula Nasal de Oxígeno',18,0,0,0,6.5,'1','1','1','1'),(18,'Lámpara de Examínación Médica',30,0,0,0,35,'1','1','1','1'),(19,'Compresa Fría/Caliente',8,0,0,0,3.5,'1','1','1','1'),(20,'Tensiómetro Digital',25,0,0,0,22,'1','1','1','1'),(21,'Vaso Nebulizador',10,0,0,0,9,'1','1','1','1'),(22,'Bata Quirúrgica Desechable',15,0,0,0,5.8,'1','1','1','1'),(23,'Martillo de Reflejos',5,0,0,0,14,'1','1','1','1'),(24,'sonda nrñ',54,0,0,0,21,'1','1','1','2'),(25,'inyectadora de auditoría',2,0,0,0,12,'1','1','1','2'),(26,'Insumo de prueba',5,0,0,0,10,'1','1','1','1'),(27,'Gaza',4,15,1,15,2.25,'1','1','2','1'),(28,'Alcohol',4,34,250,8624,1.07,'2','1','1','1'),(29,'Inyectadora 15ml',10,10,10,100,20,'1','1','1','1'),(30,'Inyectadora 20ml',10,10,10,100,0,'1','1','1','1'),(31,'Banditas',20,1,1,1,0,'1','1','1','1');
/*!40000 ALTER TABLE `insumo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicamento`
--

DROP TABLE IF EXISTS `medicamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicamento` (
  `medicamento_id` int(11) NOT NULL AUTO_INCREMENT,
  `especialidad_id` int(11) NOT NULL,
  `nombre_medicamento` varchar(45) NOT NULL,
  `tipo_medicamento` enum('1','2','3','4') DEFAULT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`medicamento_id`),
  KEY `especialidad_id` (`especialidad_id`),
  CONSTRAINT `medicamento_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento`
--

LOCK TABLES `medicamento` WRITE;
/*!40000 ALTER TABLE `medicamento` DISABLE KEYS */;
INSERT INTO `medicamento` VALUES (1,56,'Paracetamol','1','1'),(2,56,'Ibuprofeno','1','1'),(3,13,'Amoxicilina','1','1'),(4,10,'Omeprazol','1','1'),(5,2,'Diazepam','2','1'),(6,36,'Morfina','3','1'),(7,30,'Ciprofloxacino','2','1'),(8,30,'Codeína','2','1'),(9,9,'Insulina','3','1'),(10,56,'Aspirina','1','1'),(11,56,'Vitamina C','1','1'),(12,9,'Furosemida','1','1'),(13,8,'Cetirizina','1','1'),(14,15,'Warfarina','2','1'),(15,30,'Warfarina','3','1'),(16,30,'Loratadina','1','1'),(17,9,'Metformina','1','1'),(18,15,'Heparina','3','1'),(19,7,'Atenolol','1','1'),(20,7,'Atenolol','1','1'),(21,7,'Atenolol','1','1'),(22,30,'Dipirona','1','1'),(23,30,'Dipirona','1','1'),(24,45,'Anticonceptivo 85gr','1','1'),(25,5,'Nafasol','4','1'),(27,2,'venlafaxina','1','2'),(28,56,'Loratadina','1','1');
/*!40000 ALTER TABLE `medicamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico`
--

DROP TABLE IF EXISTS `medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medico` (
  `medico_id` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) NOT NULL,
  `acumulado` int(11) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`medico_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES (1,29528456,'Juan','Vazquez','04124859636','Maracay',0,'1'),(2,29527750,'abimael','a','04124528584','2',0,'2'),(3,25678987,'Daniela','Mandez','04127859696','Barrio Bolívar sur',0,'1'),(4,11502130,'Beatriz','López','04125005557','Barrio Miranda',75,'1'),(5,11502178,'María','García','04125005789','Barrio Sucre',0,'1'),(6,11502131,'Carolina','González','04125005558','Barrio Urdaneta',0,'1'),(7,11502132,'Daniel','Martínez','04125005559','Barrio Sucre',0,'1'),(8,11502133,'Elena','Pérez','04125005560','Barrio Zamora',0,'1'),(9,11502134,'Fernando','Gutiérrez','04125005561','Barrio Bolívar',0,'1'),(10,11502135,'Gabriela','Rojas','04125005562','Barrio Miranda',0,'1'),(11,11502136,'Hugo','Sánchez','04125005563','Barrio Urdaneta',0,'1'),(12,11502137,'Isabel','Torres','04125005564','Barrio Sucre',0,'1'),(13,11502138,'Javier','Mendoza','04125005565','Barrio Zamora',0,'1'),(14,11502139,'Luis','Fernández','04125005566','Barrio Bolívar',0,'1'),(15,11502140,'Marta','Santos','04125005567','Barrio Miranda',0,'1'),(16,11502141,'Natalia','Castillo','04125005568','Barrio Urdaneta',0,'1'),(17,11502142,'Óscar','Gómez','04125005569','Barrio Sucre',0,'1'),(18,11502143,'Pablo','Ramos','04125005570','Barrio Zamora',0,'1'),(19,11502144,'Querubín','Rojas','04125005571','Barrio Bolívar',0,'1'),(20,11502145,'Rosa','Sánchez','04125005572','Barrio Miranda',0,'1'),(21,11502146,'Sergio','Luna','04125005573','Barrio Urdaneta',0,'1'),(22,11502147,'Teresa','Gutiérrez','04125005574','Barrio Sucre',0,'1'),(23,11502148,'Ulises','Fuentes','04125005575','Barrio Zamora',0,'1'),(24,11502149,'Valentina','Hernández','04125005576','Barrio Bolívar',0,'1'),(25,11502150,'Walter','Iglesias','04125005577','Barrio Miranda',0,'1'),(26,11502151,'Ximena','Jiménez','04125005578','Barrio Urdaneta',0,'1'),(27,11502152,'Yanet','Kumar','04125005579','Barrio Sucre',0,'1'),(28,11502153,'Zoe','López','04125005580','Barrio Zamora',0,'1'),(29,11502154,'Abel','Mendoza','04125005581','Barrio Bolívar',0,'1'),(30,11502155,'Bárbara','Nieves','04125005582','Barrio Miranda',34,'1'),(31,11502156,'Carlos','Orozco','04125005583','Barrio Urdaneta',0,'1'),(32,11502157,'Diana','Paredes','04125005584','Barrio Sucre',0,'1'),(33,11502158,'Eduardo','Quintero','04125005585','Barrio Zamora',0,'1'),(38,234564456,'Manuel','Quintero','04125005585','Barrio Zamora',0,'1'),(39,24354678,'Medico de prueba','prueba','04128594658','San Vicente',0,'1');
/*!40000 ALTER TABLE `medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medico_especialidad`
--

DROP TABLE IF EXISTS `medico_especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medico_especialidad` (
  `medico_especialidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `medico_id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `costo_especialidad` int(11) NOT NULL,
  `estatus_med` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`medico_especialidad_id`),
  KEY `medico_id` (`medico_id`),
  KEY `especialidad_id` (`especialidad_id`),
  CONSTRAINT `medico_especialidad_ibfk_1` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`medico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `medico_especialidad_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`especialidad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico_especialidad`
--

LOCK TABLES `medico_especialidad` WRITE;
/*!40000 ALTER TABLE `medico_especialidad` DISABLE KEYS */;
INSERT INTO `medico_especialidad` VALUES (1,1,2,25,'1'),(2,2,2,25,'1'),(3,3,1,25,'1'),(4,3,3,25,'1'),(5,3,6,25,'1'),(6,4,9,25,'1'),(7,4,10,25,'1'),(8,5,21,25,'1'),(9,5,22,25,'1'),(10,5,23,25,'1'),(11,6,11,25,'1'),(12,6,12,25,'1'),(13,7,13,25,'1'),(14,8,14,25,'1'),(15,8,15,25,'1'),(16,9,16,25,'1'),(17,10,17,25,'1'),(18,10,18,25,'1'),(19,10,19,25,'1'),(20,11,20,25,'1'),(21,12,21,25,'1'),(22,12,22,25,'1'),(23,13,23,25,'1'),(24,13,24,25,'1'),(25,13,25,25,'1'),(26,14,26,25,'1'),(27,14,27,25,'1'),(28,15,28,25,'1'),(29,16,29,25,'1'),(30,16,30,25,'1'),(31,17,31,25,'1'),(32,18,32,25,'1'),(33,18,33,25,'1'),(34,19,34,25,'1'),(35,19,35,25,'1'),(36,20,36,25,'1'),(37,21,37,25,'1'),(38,21,38,25,'1'),(39,22,39,25,'1'),(40,23,40,25,'1'),(41,23,41,25,'1'),(42,23,42,25,'1'),(43,24,43,25,'1'),(44,24,44,25,'1'),(45,25,45,25,'1'),(46,26,46,25,'1'),(47,26,47,25,'1'),(48,27,48,25,'1'),(49,28,49,25,'1'),(50,28,50,25,'1'),(51,29,51,25,'1'),(52,30,52,25,'1'),(53,30,53,25,'1'),(54,31,54,25,'1'),(55,32,55,25,'1'),(62,38,55,25,'1'),(63,38,54,25,'1'),(64,38,53,25,'1'),(65,39,2,25,'1'),(66,39,8,25,'1');
/*!40000 ALTER TABLE `medico_especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente` (
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (1,17564745,'Juan','Pérez','1990-10-02',33,'04125644332','23 de enero','3','1'),(2,12343546,'Gabriel','Figueroa','1993-05-10',31,'04121234343','23 de Enero','1','1'),(3,2145654,'Juan','Delgado','1995-05-10',29,'04122123342','Urb. La Fundación Mendoza','3','1'),(4,10876895,'Miguel','Cordero','1980-08-10',43,'04121823212','La Coromoto','1','1'),(5,28236343,'Juan','Lopez','2000-07-10',23,'04122113281','Barrio Bolivar','1','1'),(6,13213123,'Gonza','Gonzalez','1993-06-16',30,'04120414231','Cagua','3','1'),(7,29765768,'Oriana','Blanco','2002-01-10',22,'04121322131','Cagua','3','1');
/*!40000 ALTER TABLE `paciente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente_beneficiado`
--

DROP TABLE IF EXISTS `paciente_beneficiado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente_beneficiado` (
  `paciente_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_id` int(11) NOT NULL,
  `estatus_pac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`paciente_beneficiado_id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `paciente_beneficiado_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente_beneficiado`
--

LOCK TABLES `paciente_beneficiado` WRITE;
/*!40000 ALTER TABLE `paciente_beneficiado` DISABLE KEYS */;
/*!40000 ALTER TABLE `paciente_beneficiado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paciente_seguro`
--

DROP TABLE IF EXISTS `paciente_seguro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paciente_seguro` (
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
  KEY `paciente_id` (`paciente_id`),
  KEY `seguro_id` (`seguro_id`),
  KEY `empresa_id` (`empresa_id`),
  CONSTRAINT `paciente_seguro_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `paciente_seguro_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `paciente_seguro_ibfk_3` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente_seguro`
--

LOCK TABLES `paciente_seguro` WRITE;
/*!40000 ALTER TABLE `paciente_seguro` DISABLE KEYS */;
INSERT INTO `paciente_seguro` VALUES (1,1,1,1,'1',2000,'2021-11-26',2000,'1'),(2,3,8,8,'1',2000,'2024-05-02',2000,'1'),(3,6,1,1,'1',2000,'2024-05-19',2000,'1'),(4,6,2,1,'1',2000,'2024-05-19',2000,'1'),(5,7,1,1,'1',2000,'2024-05-01',2000,'1');
/*!40000 ALTER TABLE `paciente_seguro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pregunta_seguridad`
--

DROP TABLE IF EXISTS `pregunta_seguridad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pregunta_seguridad` (
  `pregunta_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `pregunta` varchar(100) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  `estatus_pre` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`pregunta_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `pregunta_seguridad_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregunta_seguridad`
--

LOCK TABLES `pregunta_seguridad` WRITE;
/*!40000 ALTER TABLE `pregunta_seguridad` DISABLE KEYS */;
/*!40000 ALTER TABLE `pregunta_seguridad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estatus_pro` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`proveedor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'Industrias Modernas S.A','San Rafael','1'),(2,'Comercial del Sur C.A','Santa Clara','1'),(3,'Tecnologías Avanzadas Ltda','Los Pinos','1'),(4,'Servicios Empresariales Unidos','El Bosque','1'),(5,'Productos Innovadores S.R.L','La Estrella','1'),(6,'Constructora del Valle C.A','Valle Hermoso','1'),(7,'Importadora Internacional S.A','Ciudad del Este','1'),(8,'Consultores Asociados C.A','Miraflores','1'),(9,'Inversiones del Caribe Ltda','Bahía Azul','1'),(10,'Distribuidora Nacional C.A','Villa Nueva','1'),(11,'Innovatech Solutions Inc','Nuevo Horizonte','1'),(12,'Logística Integrada C.A','El Rosal','1'),(13,'Automotores del Norte C.A','Ciudad Real','1'),(14,'Inversiones Santa Fe Ltda','Santa Fe','1'),(15,'Mega Alimentos S.A','La Granja','1'),(16,'Construcciones Metropolitanas C.A','Metropolis','1'),(17,'Textiles del Sur S.R.L','Villa del Sur','1'),(18,'Almacenes Express C.A','Expressville','1'),(19,'Exportaciones del Caribe Ltda','Caribe Plaza','1'),(20,'Servicios Tecnológicos Globales','Global City','1'),(21,'Proveedores Médicos C.A','Cagua','1'),(22,'proveedor de prueba a','prueba a','2'),(23,'proveedor de prueba b','prueba b','2'),(24,'proveedor de prueba c','prueba c','2'),(25,'Proveedor de auditoría','23 e enero','2'),(26,'Industrias INC','Maracay','1');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguro`
--

DROP TABLE IF EXISTS `seguro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguro` (
  `seguro_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `rif` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `porcentaje` int(11) NOT NULL,
  `costo_consulta` int(11) NOT NULL,
  `maximo_dias` int(11) NOT NULL DEFAULT 15,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`seguro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro`
--

LOCK TABLES `seguro` WRITE;
/*!40000 ALTER TABLE `seguro` DISABLE KEYS */;
INSERT INTO `seguro` VALUES (1,'Seguros Qualitas','J-234235543','Caracas','04124567654',34,25,15,'1'),(2,'Seguros Ramires','J-233424321','23 de enero','04121234653',25,32,15,'1'),(3,'Seguros del Valle','J-232131231','Brisas del Lago','04121321231',20,30,15,'1'),(4,'Seguros Pirámide','J-123412312','Caracas','04122123442',50,20,15,'1'),(8,'Mercantil Seguros','J-85496258','Caracas','04125473945',40,17,15,'1'),(9,'Caracas C.A','J-231231231','Distrito Federal D.F','04123242351',25,12,15,'1'),(10,'Mapfre C.A','J-214234124','Valencia','04161414123',18,15,15,'1'),(11,'Estar Seguros C.A','J-155641814','Cagua','04243278432',15,18,15,'1'),(12,'Seguros Constitución','J-234523524','Maracay','04145158483',30,25,15,'1'),(13,'Hispana de Seguros','J-893457893','Maracaibo','04121234423',20,20,15,'1'),(14,'Seguro de test','J-324345554','23 de enero','04127874565',15,25,15,'1'),(15,'Seguros Cuadrado S.A','E-123333333','San Juan de los Morros','04244112322',20,20,15,'1');
/*!40000 ALTER TABLE `seguro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguro_empresa`
--

DROP TABLE IF EXISTS `seguro_empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguro_empresa` (
  `seguro_empresa_id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `seguro_id` int(11) NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`seguro_empresa_id`),
  KEY `empresa_id` (`empresa_id`),
  KEY `seguro_id` (`seguro_id`),
  CONSTRAINT `seguro_empresa_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`empresa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `seguro_empresa_ibfk_2` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro_empresa`
--

LOCK TABLES `seguro_empresa` WRITE;
/*!40000 ALTER TABLE `seguro_empresa` DISABLE KEYS */;
INSERT INTO `seguro_empresa` VALUES (1,1,1,'1'),(2,1,2,'1'),(3,2,1,'1'),(7,4,2,'1'),(8,5,2,'1'),(9,5,4,'1'),(10,6,9,'1'),(11,6,12,'1'),(12,7,3,'1'),(13,7,9,'1'),(14,8,8,'1'),(15,8,9,'1'),(16,8,10,'1'),(17,9,1,'1'),(18,9,3,'1'),(19,9,8,'1'),(20,10,2,'1'),(21,10,4,'1'),(22,10,10,'1'),(23,11,9,'1'),(24,11,12,'1'),(25,11,13,'1'),(26,12,1,'1'),(27,12,9,'1'),(28,12,13,'1'),(29,13,1,'1'),(30,13,3,'1'),(31,13,13,'1'),(32,14,2,'1'),(33,14,4,'1'),(34,14,10,'1'),(35,15,8,'1'),(36,15,10,'1'),(37,15,13,'1'),(38,16,1,'1'),(39,16,2,'1'),(40,16,8,'1'),(41,17,2,'1'),(42,17,4,'1'),(43,17,12,'1'),(44,18,1,'1'),(45,18,8,'1'),(46,18,9,'1'),(47,18,13,'1'),(48,11,4,'1'),(49,19,3,'1'),(50,20,1,'1');
/*!40000 ALTER TABLE `seguro_empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguro_examen`
--

DROP TABLE IF EXISTS `seguro_examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seguro_examen` (
  `seguro_examen_id` int(11) NOT NULL AUTO_INCREMENT,
  `seguro_id` int(11) NOT NULL,
  `examenes` text NOT NULL,
  `costos` text NOT NULL,
  `estatus_seg` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`seguro_examen_id`),
  KEY `seguro_id` (`seguro_id`),
  CONSTRAINT `seguro_examen_ibfk_1` FOREIGN KEY (`seguro_id`) REFERENCES `seguro` (`seguro_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro_examen`
--

LOCK TABLES `seguro_examen` WRITE;
/*!40000 ALTER TABLE `seguro_examen` DISABLE KEYS */;
INSERT INTO `seguro_examen` VALUES (1,1,'1,2,3,6,19,17,10','30,20,25,15,45,28,13','1'),(2,2,'1,2,9,17,21,23,34','25,24,35,18,28,18,18','1'),(3,3,'1,2,12,9,15','25,25,23,15,27','1'),(4,4,'1,3,2','28,12,12','1'),(7,8,'14,25,9','25,35,25','1'),(8,9,'3,9,12,10,17,19,23,28,32,1,2','20,20,15,28,30,50,35,40,28,16,20','1'),(9,10,'6,14,19,9,23,34,34','25,26,28,25,13,17,14','1'),(10,11,'3,9,23','15,18,17','1'),(11,12,'6,19,25,30,28','23,28,23,26,17','1'),(12,13,'32,10,17,23,28','17,16,15,18,15','1'),(13,14,'3,6','12,12','1'),(14,15,'1,6,2','10,100,10','1');
/*!40000 ALTER TABLE `seguro_examen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_antecedente`
--

DROP TABLE IF EXISTS `tipo_antecedente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_antecedente` (
  `tipo_antecedente_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `estatus_tip` enum('1','2') NOT NULL,
  PRIMARY KEY (`tipo_antecedente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_antecedente`
--

LOCK TABLES `tipo_antecedente` WRITE;
/*!40000 ALTER TABLE `tipo_antecedente` DISABLE KEYS */;
INSERT INTO `tipo_antecedente` VALUES (1,'Antecedentes Patológicos','2023-05-28 23:51:47','1'),(2,'Antecedentes Psicológicos','2023-05-28 23:51:47','1'),(3,'Antecedentes médicos familiares','2023-05-28 23:51:47','1'),(4,'Cirugías o traumatismos','2023-05-28 23:51:47','1'),(5,'Alergias','2023-05-28 23:51:47','1'),(6,'Reacción a medicamentos','2023-05-28 23:51:47','1'),(7,'Enfermedades Padecidas','2023-05-28 23:51:47','1'),(8,'Tratamientos','2023-05-28 23:51:47','1'),(9,'Hábitos de salud','2023-05-28 23:51:47','1');
/*!40000 ALTER TABLE `tipo_antecedente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `titular_beneficiado`
--

DROP TABLE IF EXISTS `titular_beneficiado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `titular_beneficiado` (
  `titular_beneficiado_id` int(11) NOT NULL AUTO_INCREMENT,
  `paciente_beneficiado_id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `estatus_tit` enum('1','2') NOT NULL DEFAULT '1',
  `tipo_relacion` enum('1','2') NOT NULL,
  `tipo_familiar` enum('1','2','3','4',' 5','6') NOT NULL,
  PRIMARY KEY (`titular_beneficiado_id`),
  KEY `paciente_beneficiado_id` (`paciente_beneficiado_id`),
  KEY `paciente_id` (`paciente_id`),
  CONSTRAINT `titular_beneficiado_ibfk_1` FOREIGN KEY (`paciente_beneficiado_id`) REFERENCES `paciente_beneficiado` (`paciente_beneficiado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `titular_beneficiado_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `paciente` (`paciente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `titular_beneficiado`
--

LOCK TABLES `titular_beneficiado` WRITE;
/*!40000 ALTER TABLE `titular_beneficiado` DISABLE KEYS */;
/*!40000 ALTER TABLE `titular_beneficiado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(16) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `tokken` varchar(10) DEFAULT NULL,
  `rol` int(11) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `estatus_usu` enum('1','2') NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Francis','$2y$10$qUQbE.PKDVs2yt618RZrXeHzyII58wj040wI943WS8Bw8H/KqYxOm','c2bce8ef60',1,'$2y$10$VdmseZ1c7eMINwubw0aY7ulFN681iD7un5W2g.73LmPav5pP8IAGm','1','2023-10-14 11:29:39'),(2,'Maria','$2y$10$JzsAaRD3HjqWmQuhgJCoheZwKBOwvW1/QxhKT1ienyVo1itr/qSGy',NULL,3,'$2y$10$lIL/kC5QKpnrBFIhxpUOSeaFtM2qOkOz5IVfkRN7niMgufkqy.xxW','1','2023-10-14 11:30:03'),(3,'Juan','$2y$10$y2nP.bNOXOv7D9MBaA.0cOXcQ6qSnevvkae.vuqcbWbhjy.rZFpfy',NULL,4,'$2y$10$P5UN5gCK8i9z6y.80uofx.k4HMtC.Q3Rh3ZJowSzUJccEXkA2nYdK','1','2023-10-14 11:34:17'),(4,'Oriana','$2y$10$mM1EP2DjJb0rWFddt97V/Oxe1FG75XCTu9KcffW7ipOd2QXFWRwFe',NULL,2,'$2y$10$mqrXDImYH4GcA5RNxoYFXepssHuWpELbEC8PPNaHrn16axVfhFFLS','1','2024-04-05 04:12:53'),(5,'Enrique','$2y$10$CgS7tzG4SiwxA0/x8qUC9uU/qIsuaPXPu/IqwBG2X2E9ELUXbhPEe',NULL,2,'$2y$10$MzpZREpNfO6cXEkzUA/BTedpK2PVVQrHeco3QINS/I3JYpmw2sI3S','1','2024-04-05 04:27:49');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-27 18:48:51
