-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: shenque_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB-log

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `antecedentes_medicos`
--

LOCK TABLES `antecedentes_medicos` WRITE;
/*!40000 ALTER TABLE `antecedentes_medicos` DISABLE KEYS */;
INSERT INTO `antecedentes_medicos` VALUES (1,93,9,'Adicción a la loratadina','1','2024-06-08 20:20:32'),(2,93,2,'Depresión','2','2024-06-08 20:31:59'),(4,94,2,'Posible TDHA','1','2024-06-10 19:24:22');
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
  `modulo` varchar(30) NOT NULL,
  PRIMARY KEY (`auditoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria`
--

LOCK TABLES `auditoria` WRITE;
/*!40000 ALTER TABLE `auditoria` DISABLE KEYS */;
INSERT INTO `auditoria` VALUES (1,'2024-06-10 14:38:10',7,'inserción','enrique123 ha insertado un nuevo elemento asdasds en el módulo proveedores','proveedores'),(2,'2024-06-10 14:38:14',7,'eliminación','enrique123 ha eliminado al elemento id 1 en el módulo proveedores','proveedores'),(3,'2024-06-10 14:38:21',7,'actualización','enrique123 ha actualizado al elemento id 24 los campos estatus_usu en el módulo usuarios','usuarios'),(4,'2024-06-10 14:38:26',7,'actualización','enrique123 ha actualizado al elemento id 24 los campos clave, rol en el módulo usuarios','usuarios'),(5,'2024-06-10 14:38:33',1,'inserción','Francis ha insertado un nuevo elemento Dermatologia en el módulo especialidad','especialidad'),(6,'2024-06-10 14:38:39',1,'inserción','Francis ha insertado un nuevo elemento Perfil 20 en el módulo exámenes','exámenes'),(7,'2024-06-10 14:38:42',1,'inserción','Francis ha insertado un nuevo elemento Perfil hepatico en el módulo exámenes','exámenes'),(8,'2024-06-10 14:38:46',1,'inserción','Francis ha insertado un nuevo elemento Aura en el módulo médicos','médicos'),(9,'2024-06-10 14:38:52',1,'inserción','Francis ha insertado un nuevo elemento Angela en el módulo pacientes','pacientes'),(10,'2024-06-10 14:38:56',1,'eliminación','Francis ha eliminado al elemento id 2 en el módulo exámenes','exámenes'),(11,'2024-06-10 14:39:00',1,'eliminación','Francis ha eliminado al elemento id 1 en el módulo exámenes','exámenes'),(12,'2024-06-10 14:39:05',1,'inserción','Francis ha insertado un nuevo elemento Fisioterapia en el módulo especialidad','especialidad'),(13,'2024-06-10 14:39:11',1,'inserción','Francis ha insertado un nuevo elemento Medicina interna en el módulo especialidad','especialidad'),(14,'2024-06-10 14:39:14',1,'inserción','Francis ha insertado un nuevo elemento Pediatria en el módulo especialidad','especialidad'),(15,'2024-06-10 14:39:18',1,'inserción','Francis ha insertado un nuevo elemento Perfil 20 en el módulo exámenes','exámenes'),(16,'2024-06-10 14:39:20',1,'inserción','Francis ha insertado un nuevo elemento Analisis de orina en el módulo exámenes','exámenes'),(17,'2024-06-10 14:39:21',1,'inserción','Francis ha insertado un nuevo elemento Eco de mama en el módulo exámenes','exámenes'),(18,'2024-06-10 14:39:26',1,'inserción','Francis ha insertado un nuevo elemento Jose en el módulo médicos','médicos'),(19,'2024-06-10 14:39:30',1,'inserción','Francis ha insertado un nuevo elemento Gustabo en el módulo médicos','médicos'),(20,'2024-06-10 14:39:34',1,'eliminación','Francis ha eliminado al elemento id 4 en el módulo exámenes','exámenes'),(21,'2024-06-10 15:02:52',1,'inserción','El usuario Francis insertó la orden de médico con id 1','recibo de médico'),(22,'2024-06-10 15:02:58',1,'inserción','Francis ha insertado un nuevo elemento Gastrologia en el módulo especialidad','especialidad'),(23,'2024-06-10 15:03:11',1,'actualización','Francis ha actualizado al elemento id 5 los campos nombre en el módulo especialidad','especialidad'),(24,'2024-06-10 15:03:12',1,'actualización','Francis ha actualizado al elemento id 5 los campos nombre en el módulo especialidad','especialidad'),(25,'2024-06-10 15:03:17',1,'inserción','Francis ha insertado un nuevo elemento Panda en el módulo especialidad','especialidad'),(26,'2024-06-10 15:03:29',1,'eliminación','Francis ha eliminado al elemento id 6 en el módulo especialidad','especialidad'),(27,'2024-06-10 15:03:35',1,'inserción','Francis ha insertado un nuevo elemento Carol en el módulo médicos','médicos'),(28,'2024-06-10 15:03:39',1,'inserción','Francis ha insertado un nuevo elemento Juan en el módulo médicos','médicos'),(29,'2024-06-10 15:03:59',1,'inserción','Francis ha insertado un nuevo elemento Ana en el módulo médicos','médicos'),(30,'2024-06-10 15:04:03',1,'inserción','Francis ha insertado un nuevo elemento Batman  en el módulo pacientes','pacientes'),(31,'2024-06-10 15:04:07',1,'inserción','Francis ha insertado un nuevo elemento Njjjhh en el módulo proveedores','proveedores'),(32,'2024-06-10 15:04:11',1,'inserción','Francis ha insertado un nuevo elemento Jjjjhh en el módulo proveedores','proveedores'),(33,'2024-06-10 15:04:16',1,'eliminación','Francis ha eliminado al elemento id 2 en el módulo proveedores','proveedores'),(34,'2024-06-10 15:04:20',1,'eliminación','Francis ha eliminado al elemento id 3 en el módulo proveedores','proveedores'),(35,'2024-06-10 15:04:24',1,'inserción','Francis ha insertado un nuevo elemento Bhhhhj en el módulo insumos','insumos'),(36,'2024-06-10 15:04:29',1,'inserción','Francis ha insertado un nuevo elemento Hjjjj en el módulo insumos','insumos'),(37,'2024-06-10 15:04:35',1,'inserción','Francis ha insertado un nuevo elemento Hkkjh en el módulo insumos','insumos'),(38,'2024-06-10 15:04:38',1,'inserción','Francis ha insertado un nuevo elemento Kiko en el módulo insumos','insumos'),(39,'2024-06-10 15:04:44',1,'eliminación','Francis ha eliminado al elemento id 1 en el módulo insumos','insumos'),(40,'2024-06-10 15:04:47',1,'eliminación','Francis ha eliminado al elemento id 2 en el módulo insumos','insumos'),(41,'2024-06-10 15:04:50',1,'eliminación','Francis ha eliminado al elemento id 3 en el módulo insumos','insumos'),(42,'2024-06-10 15:04:53',1,'eliminación','Francis ha eliminado al elemento id 4 en el módulo insumos','insumos'),(43,'2024-06-10 15:04:59',1,'inserción','Francis ha insertado un nuevo elemento Jsjskwjqj en el módulo insumos','insumos'),(44,'2024-06-10 15:05:02',1,'eliminación','Francis ha eliminado al elemento id 5 en el módulo insumos','insumos'),(45,'2024-06-10 15:05:07',1,'actualización','Francis ha actualizado al elemento id 6 los campos direccion en el módulo médicos','médicos'),(46,'2024-06-10 15:05:11',1,'eliminación','Francis ha eliminado al elemento id 6 en el módulo médicos','médicos'),(47,'2024-06-10 15:05:15',1,'eliminación','Francis ha eliminado al elemento id 5 en el módulo médicos','médicos'),(48,'2024-06-10 15:05:19',1,'eliminación','Francis ha eliminado al elemento id 4 en el módulo médicos','médicos'),(49,'2024-06-10 15:05:34',1,'inserción','El usuario Francis insertó la consulta natural del paciente con cédula 55657555','consultas'),(50,'2024-06-10 15:06:33',1,'actualización','Francis ha actualizado al elemento id 92 los campos nombre, tipo_paciente, pacientePoseeTitulares en el módulo pacientes','pacientes'),(51,'2024-06-10 15:06:39',1,'eliminación','Francis ha eliminado al elemento id 92 en el módulo pacientes','pacientes'),(52,'2024-06-10 15:06:55',1,'inserción','El usuario Francis insertó un nuevo medicamento de tipo 3 llamado Perfil 20','medicamentos'),(53,'2024-06-10 15:06:59',1,'actualización','Francis ha actualizado al elemento id 1 los campos nombre_medicamento en el módulo insumos','medicamentos'),(54,'2024-06-10 15:07:04',1,'eliminación','Francis ha eliminado al elemento id 1 en el módulo insumos','insumos'),(55,'2024-06-10 15:07:07',1,'inserción','Francis ha insertado un nuevo elemento Loratadina en el módulo insumos','insumos'),(56,'2024-06-10 15:07:11',1,'inserción','Francis ha insertado un nuevo elemento Acetominofen  en el módulo insumos','insumos'),(57,'2024-06-10 15:07:15',1,'actualización','Francis ha actualizado al elemento id 2 los campos clave en el módulo usuarios','usuarios'),(58,'2024-06-10 15:07:20',1,'actualización','Francis ha actualizado al elemento id 4 los campos clave en el módulo usuarios','usuarios'),(59,'2024-06-10 15:07:36',1,'inserción','Francis ha insertado un nuevo elemento Urologia en el módulo especialidad','especialidad'),(60,'2024-06-10 15:07:39',1,'eliminación','Francis ha eliminado al elemento id 5 en el módulo especialidad','especialidad'),(61,'2024-06-10 15:07:43',1,'inserción','El usuario Francis insertó un nuevo medicamento de tipo 1 llamado Parecetamol','medicamentos'),(62,'2024-06-10 15:07:48',1,'eliminación','Francis ha eliminado al elemento id 2 en el módulo insumos','insumos'),(63,'2024-06-10 15:07:52',1,'eliminación','Francis ha eliminado al elemento id 3 en el módulo exámenes','exámenes'),(64,'2024-06-10 15:08:12',1,'actualización','El usuario Francis cambio a pagada la orden de médico con id 00000001','recibo de médico'),(65,'2024-06-10 15:08:16',1,'eliminación','Francis ha eliminado al elemento id 6 en el módulo insumos','insumos'),(66,'2024-06-10 15:08:19',1,'eliminación','Francis ha eliminado al elemento id 3 en el módulo especialidad','especialidad'),(67,'2024-06-10 15:08:21',1,'inserción','Francis ha insertado un nuevo elemento Odontología  en el módulo especialidad','especialidad'),(68,'2024-06-10 15:08:24',1,'eliminación','Francis ha eliminado al elemento id 3 en el módulo horarios','horarios'),(69,'2024-06-10 15:08:56',1,'eliminación','Francis ha eliminado al elemento id 3 en el módulo médicos','médicos'),(70,'2024-06-10 15:09:03',1,'inserción','Francis ha insertado un nuevo elemento Carolina en el módulo médicos','médicos'),(71,'2024-06-10 15:10:02',1,'eliminación','Francis ha eliminado al elemento id 1 en el módulo pacientes','pacientes'),(72,'2024-06-10 15:10:06',1,'inserción','Francis ha insertado un nuevo elemento Calrissian en el módulo pacientes','pacientes'),(73,'2024-06-10 15:10:14',1,'actualización','Francis ha actualizado al elemento id 93 los campos apellidos, tipo_paciente, pacientePoseeTitulares en el módulo pacientes','pacientes'),(74,'2024-06-10 15:12:13',1,'inserción','El usuario Francis insertó un nuevo antecedente médico de tipo 9 al paciente Calrissian con cédula 26666955','antecedentes'),(75,'2024-06-10 15:12:12',1,'inserción','El usuario Francis insertó un nuevo antecedente médico de tipo 2 al paciente Calrissian con cédula 26666955','antecedentes'),(76,'2024-06-10 15:12:19',1,'actualización','El usuario Francis actualizó el antecedente_id 2 al paciente Calrissian con cédula 26666955','antecedentes'),(77,'2024-06-10 15:12:21',1,'eliminación','El usuario Francis eliminó el antecedente_id 2 al paciente Calrissian con cédula 26666955','antecedentes'),(78,'2024-06-10 15:13:12',1,'actualización','Francis ha actualizado al elemento id 93 los campos tipo_paciente, cedula, pacientePoseeTitulares en el módulo pacientes','pacientes'),(79,'2024-06-10 15:13:33',1,'actualización','Francis ha actualizado al elemento id 93 los campos tipo_paciente, cedula, pacientePoseeTitulares en el módulo pacientes','pacientes'),(80,'2024-06-10 15:13:35',1,'eliminación','Francis ha eliminado al elemento id 93 en el módulo pacientes','pacientes'),(81,'2024-06-10 15:13:47',1,'inserción','El usuario Francis insertó un nuevo medicamento de tipo 1 llamado Analgésicos ','medicamentos'),(82,'2024-06-10 15:13:40',1,'actualización','Francis ha actualizado al elemento id 3 los campos tipo_medicamento en el módulo insumos','medicamentos'),(83,'2024-06-10 15:13:44',1,'eliminación','Francis ha eliminado al elemento id 3 en el módulo insumos','insumos'),(84,'2024-06-10 15:13:53',1,'inserción','Francis ha insertado un nuevo elemento Anatomía  en el módulo exámenes','exámenes'),(85,'2024-06-10 15:13:59',1,'actualización','Francis ha actualizado al elemento id 6 los campos precio_examen en el módulo exámenes','exámenes'),(86,'2024-06-10 15:14:02',1,'eliminación','Francis ha eliminado al elemento id 6 en el módulo exámenes','exámenes'),(87,'2024-06-10 15:14:06',1,'eliminación','Francis ha eliminado al elemento id 5 en el módulo exámenes','exámenes'),(88,'2024-06-10 15:43:08',7,'inserción','enrique123 ha insertado un nuevo elemento Panorámica en el módulo exámenes','exámenes'),(89,'2024-06-10 16:32:29',1,'inserción','Francis ha insertado un nuevo elemento Perfil 20 en el módulo exámenes','exámenes'),(90,'2024-06-10 16:33:06',1,'inserción','Francis ha insertado un nuevo elemento Eco de Mama en el módulo exámenes','exámenes'),(91,'2024-06-10 16:33:45',1,'inserción','Francis ha insertado un nuevo elemento Eco pélvico  en el módulo exámenes','exámenes'),(92,'2024-06-10 18:58:43',2,'inserción','Maria ha insertado un nuevo elemento MiFresita C.A en el módulo proveedores','proveedores'),(93,'2024-06-10 19:05:53',2,'inserción','Maria ha insertado un nuevo elemento Ibuprofeno 500ml en el módulo insumos','insumos'),(94,'2024-06-10 19:08:59',2,'eliminación','Maria ha eliminado al elemento id 7 en el módulo insumos','insumos'),(95,'2024-06-10 19:09:01',2,'eliminación','Maria ha eliminado al elemento id 8 en el módulo insumos','insumos'),(96,'2024-06-10 19:10:06',2,'inserción','Maria ha insertado un nuevo elemento Solución en el módulo insumos','insumos'),(97,'2024-06-10 19:10:44',2,'inserción','El usuario Maria insertó la orden de compra con id 1','recibo de compra'),(98,'2024-06-10 19:13:33',7,'inserción','enrique123 ha insertado un nuevo elemento Seguros Miaranda en el módulo seguros','seguros'),(99,'2024-06-10 19:14:57',7,'inserción','enrique123 ha insertado un nuevo elemento Cuadrado C.A en el módulo empresas','empresas'),(100,'2024-06-10 19:16:19',7,'inserción','enrique123 ha insertado un nuevo elemento Piramides en el módulo empresas','empresas'),(101,'2024-06-10 19:19:56',7,'inserción','enrique123 ha insertado un nuevo elemento Genfica Lab C.A en el módulo empresas','empresas'),(102,'2024-06-10 19:20:35',7,'actualización','enrique123 ha actualizado al elemento id 1 los campos nombre en el módulo seguros','seguros'),(103,'2024-06-10 19:22:46',7,'inserción','enrique123 ha insertado un nuevo elemento Oriana en el módulo pacientes','pacientes'),(104,'2024-06-10 19:23:11',7,'actualización','enrique123 ha actualizado al elemento id 94 los campos tipo_paciente, fecha_nacimiento, pacientePoseeTitulares, edad en el módulo pacientes','pacientes'),(105,'2024-06-10 19:23:50',7,'actualización','enrique123 ha actualizado al elemento id 94 los campos tipo_paciente, fecha_nacimiento, pacientePoseeTitulares, edad en el módulo pacientes','pacientes'),(106,'2024-06-10 19:24:22',7,'inserción','El usuario enrique123 insertó un nuevo antecedente médico de tipo 2 al paciente Oriana con cédula 28317069','antecedentes'),(107,'2024-06-10 19:49:28',2,'inserción','Maria ha insertado un nuevo elemento Vendaje en el módulo insumos','insumos'),(108,'2024-06-10 19:50:30',2,'inserción','Maria ha insertado un nuevo elemento Vendaje Térmico en el módulo insumos','insumos'),(109,'2024-06-10 19:50:41',2,'eliminación','Maria ha eliminado al elemento id 10 en el módulo insumos','insumos'),(110,'2024-06-10 19:53:04',2,'inserción','Maria ha insertado un nuevo elemento San Fernando C.A en el módulo proveedores','proveedores'),(111,'2024-06-10 19:53:12',2,'eliminación','Maria ha eliminado al elemento id 5 en el módulo proveedores','proveedores'),(112,'2024-06-10 19:53:19',2,'actualización','Maria ha actualizado al elemento id 4 los campos nombre en el módulo proveedores','proveedores'),(113,'2024-06-10 19:53:25',2,'actualización','Maria ha actualizado al elemento id 4 los campos nombre en el módulo proveedores','proveedores'),(114,'2024-06-10 19:57:30',2,'inserción','El usuario Maria insertó la orden de compra con id 2','recibo de compra'),(115,'2024-06-10 20:09:19',7,'inserción','El usuario enrique123 insertó la consulta asegurada del paciente con cédula 28317069','consultas'),(116,'2024-06-10 20:10:07',7,'inserción','El usuario enrique123 insertó la consulta por emergencia del paciente con cédula 28317069','consultas'),(117,'2024-06-10 20:11:23',7,'inserción','El usuario enrique123 insertó la consulta por emergencia del paciente con cédula 28317069','consultas'),(118,'2024-06-10 20:24:58',2,'inserción','El usuario Maria insertó la orden de asegurada con id 1','recibo de asegurada'),(119,'2024-06-10 22:10:54',4,'inserción','El usuario Oriana insertó la orden de asegurada con id 2','recibo de asegurada');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita`
--

LOCK TABLES `cita` WRITE;
/*!40000 ALTER TABLE `cita` DISABLE KEYS */;
INSERT INTO `cita` VALUES (1,1,1,1,'2024-06-11','08:30:00','08:00:00','Dolor de hueso',9099557,0,'1','2',' 5'),(2,1,3,3,'2024-06-24','13:30:00','13:00:00','Esquizofrénico',9099557,0,'1','2',' 5'),(3,1,3,3,'2024-06-17','16:00:00','13:00:00','Esquizofrénico',9099557,0,'1','2',' 5'),(4,1,3,3,'2024-06-10','17:00:00','13:00:00','Esquizofrénico',9099557,0,'1','2','1'),(5,1,1,1,'2024-06-28','09:00:00','08:00:00','Dolor de hueso',9099557,0,'1','2','1'),(6,94,7,8,'2024-06-19','12:45:00','12:15:00','Cita por seguro, dolor de muela',28317069,69,'2','2','4'),(7,94,1,1,'2024-06-25','08:30:00','08:00:00','Paciente con dermatitis',28317069,60,'2','2','1');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita_examen`
--

LOCK TABLES `cita_examen` WRITE;
/*!40000 ALTER TABLE `cita_examen` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cita_seguro`
--

LOCK TABLES `cita_seguro` WRITE;
/*!40000 ALTER TABLE `cita_seguro` DISABLE KEYS */;
INSERT INTO `cita_seguro` VALUES (1,6,1,'D3331'),(2,7,1,'A3122');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra_insumo`
--

LOCK TABLES `compra_insumo` WRITE;
/*!40000 ALTER TABLE `compra_insumo` DISABLE KEYS */;
INSERT INTO `compra_insumo` VALUES (000000001,9,000000001,10,10,116,0.27,3.18),(000000002,9,000000002,20,20,464,0.55,12.72);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta`
--

LOCK TABLES `consulta` WRITE;
/*!40000 ALTER TABLE `consulta` DISABLE KEYS */;
INSERT INTO `consulta` VALUES (1,66,66,NULL,'2024-06-05',0,'1','1'),(2,60,1.7,'Caries y cordales','2024-06-19',0,'2','1'),(3,70,1.7,'Motivo por dolor de muela','2024-06-10',1,'1','3'),(4,70,1.7,'Chequeo General','2024-06-10',1,'1','4');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_cita`
--

LOCK TABLES `consulta_cita` WRITE;
/*!40000 ALTER TABLE `consulta_cita` DISABLE KEYS */;
INSERT INTO `consulta_cita` VALUES (1,6,2,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_emergencia`
--

LOCK TABLES `consulta_emergencia` WRITE;
/*!40000 ALTER TABLE `consulta_emergencia` DISABLE KEYS */;
INSERT INTO `consulta_emergencia` VALUES (1,3,94,28317069,1,0,0,50,0,1,20,0,0,0,0,10,0,10,0,10,0,20,0,120,0,120,0,0,'AAA12332'),(2,4,94,28317069,1,0,0,50,0,0,0,0,0,0,0,10,0,30,0,0,0,4,0,94,0,40,0,0,'10');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_examen`
--

LOCK TABLES `consulta_examen` WRITE;
/*!40000 ALTER TABLE `consulta_examen` DISABLE KEYS */;
INSERT INTO `consulta_examen` VALUES (1,2,7,0,20,'1','1',0,0,0),(2,3,7,0,20,'1','1',0,0,0),(3,3,8,0,20,'1','1',0,0,0),(4,4,9,0,4,'1','1',0,0,0);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_indicaciones`
--

LOCK TABLES `consulta_indicaciones` WRITE;
/*!40000 ALTER TABLE `consulta_indicaciones` DISABLE KEYS */;
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
  `cantidad` float NOT NULL,
  `estatus_con` enum('1','2') NOT NULL DEFAULT '1',
  `precio_insumo_bs` float NOT NULL,
  `precio_insumo_usd` float NOT NULL,
  PRIMARY KEY (`consulta_insumo_id`),
  KEY `insumo_id` (`insumo_id`),
  KEY `consulta_id` (`consulta_id`),
  CONSTRAINT `consulta_insumo_ibfk_1` FOREIGN KEY (`insumo_id`) REFERENCES `insumo` (`insumo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `consulta_insumo_ibfk_2` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`consulta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_insumo`
--

LOCK TABLES `consulta_insumo` WRITE;
/*!40000 ALTER TABLE `consulta_insumo` DISABLE KEYS */;
INSERT INTO `consulta_insumo` VALUES (1,9,3,1,'1',0,10);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_recipe`
--

LOCK TABLES `consulta_recipe` WRITE;
/*!40000 ALTER TABLE `consulta_recipe` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_referidos`
--

LOCK TABLES `consulta_referidos` WRITE;
/*!40000 ALTER TABLE `consulta_referidos` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_seguro`
--

LOCK TABLES `consulta_seguro` WRITE;
/*!40000 ALTER TABLE `consulta_seguro` DISABLE KEYS */;
INSERT INTO `consulta_seguro` VALUES (000000001,4,1,'','2024-06-10 20:24:58',94,'1',0,40),(000000002,3,1,'','2024-06-10 22:10:54',120,'1',0,120);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_sin_cita`
--

LOCK TABLES `consulta_sin_cita` WRITE;
/*!40000 ALTER TABLE `consulta_sin_cita` DISABLE KEYS */;
INSERT INTO `consulta_sin_cita` VALUES (1,1,4,2,92,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'Cuadrado C.A','J-183718382','Maracay','1'),(2,'Piramides','J-414414141','Cagua','1'),(3,'Genfica Lab C.A','J-414131222','Maracay','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
INSERT INTO `especialidad` VALUES (1,'Dermatologia','1'),(2,'Fisioterapia','1'),(3,'Medicina interna','2'),(4,'Pediatria','1'),(5,'Gastrologia','2'),(6,'Panda','2'),(7,'Urologia','1'),(8,'Odontología','1');
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
  `estatus_exa` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`examen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examen`
--

LOCK TABLES `examen` WRITE;
/*!40000 ALTER TABLE `examen` DISABLE KEYS */;
INSERT INTO `examen` VALUES (1,'Perfil 20',3,'','2'),(2,'Perfil hepatico',5,'','2'),(3,'Perfil 20',5,'2','2'),(4,'Analisis de orina',8,'2','2'),(5,'Eco de mama',9,'1','2'),(6,'Anatomía',66,'2','2'),(7,'Panorámica',20,'1','1'),(8,'Perfil 20',5,'2','1'),(9,'Eco de Mama',4,'1','1'),(10,'Eco pélvico',6,'3','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examen_especialidad`
--

LOCK TABLES `examen_especialidad` WRITE;
/*!40000 ALTER TABLE `examen_especialidad` DISABLE KEYS */;
INSERT INTO `examen_especialidad` VALUES (1,1,1,'1'),(2,2,1,'1'),(3,3,3,'1'),(4,4,4,'1'),(5,5,3,'1'),(6,6,2,'1'),(7,7,8,'1'),(8,8,1,'1'),(9,9,4,'1'),(10,10,2,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_compra`
--

LOCK TABLES `factura_compra` WRITE;
/*!40000 ALTER TABLE `factura_compra` DISABLE KEYS */;
INSERT INTO `factura_compra` VALUES (000000001,4,'2024-06-10 00:00:00',10,116,100,3.18,16,NULL,'1'),(000000002,4,'2024-06-09 00:00:00',20,464,400,12.72,64,NULL,'1');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_consulta`
--

LOCK TABLES `factura_consulta` WRITE;
/*!40000 ALTER TABLE `factura_consulta` DISABLE KEYS */;
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
INSERT INTO `factura_medico` VALUES (00000001,2,0,0,0,0,0,0,0,'2024-06-06','2024-06-06 13:23:52',0,0,'3');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_mensajeria`
--

LOCK TABLES `factura_mensajeria` WRITE;
/*!40000 ALTER TABLE `factura_mensajeria` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_mensajeria_consultas`
--

LOCK TABLES `factura_mensajeria_consultas` WRITE;
/*!40000 ALTER TABLE `factura_mensajeria_consultas` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_seguro`
--

LOCK TABLES `factura_seguro` WRITE;
/*!40000 ALTER TABLE `factura_seguro` DISABLE KEYS */;
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
INSERT INTO `global` VALUES (1,'porcentaje_medico','40'),(2,'cambio_divisa','36.48'),(3,'porcentaje_insumo','5');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
INSERT INTO `horario` VALUES (1,1,'martes','13:06:00','08:00:00','1'),(2,2,'viernes','15:00:00','10:20:00','1'),(3,3,'lunes','14:00:00','13:00:00','2'),(4,4,'martes','14:30:00','10:46:00','1'),(5,5,'martes','15:15:00','11:14:00','1'),(6,6,'martes','16:29:00','14:29:00','1'),(7,7,'miercoles','14:30:00','12:15:00','1');
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
  `cantidad_min` float NOT NULL,
  `cantidad_unidad` float NOT NULL DEFAULT 0,
  `capacidad_unidad` float NOT NULL,
  `cantidad_capacidad` float NOT NULL,
  `precio` float NOT NULL DEFAULT 0,
  `tipo_medida` enum('1','2','3','4') NOT NULL,
  `es_cobrado` enum('0','1') NOT NULL,
  `tipo_insumo` enum('1','2') DEFAULT '1',
  `estatus_ins` enum('1','2','3') NOT NULL DEFAULT '1',
  PRIMARY KEY (`insumo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insumo`
--

LOCK TABLES `insumo` WRITE;
/*!40000 ALTER TABLE `insumo` DISABLE KEYS */;
INSERT INTO `insumo` VALUES (1,'Bhhhhj',6,6,3,18,0,'1','0','1','2'),(2,'Hjjjj',6,6,6,36,0,'1','0','1','2'),(3,'Hkkjh',5,6,6,36,0,'1','0','1','2'),(4,'Kiko',95596700,888,9888,8780540,0,'1','0','1','2'),(5,'Jsjskwjqj',6,6,6,36,0,'1','0','1','2'),(6,'Loratadina',2,1,20,20,0,'1','0','1','2'),(7,'Acetominofen',1,2,5,10,20,'1','1','1','2'),(8,'Ibuprofeno 500ml',20,0,10,0,100,'2','1','2','2'),(9,'Solución',10,29.9667,30,899,10,'1','1','1','1'),(10,'Vendaje',20,0,10,0,0,'3','0','1','2'),(11,'Vendaje Térmico',20,0,10,0,10,'3','1','1','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicamento`
--

LOCK TABLES `medicamento` WRITE;
/*!40000 ALTER TABLE `medicamento` DISABLE KEYS */;
INSERT INTO `medicamento` VALUES (1,2,'Perfil 2','3','2'),(2,3,'Parecetamol','1','2'),(3,8,'Analgésicos','4','2');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico`
--

LOCK TABLES `medico` WRITE;
/*!40000 ALTER TABLE `medico` DISABLE KEYS */;
INSERT INTO `medico` VALUES (1,89897678,'Aura','Mendoza','04162304098','Calle prolomgacion',0,'1'),(2,83838839,'Jose','Martinez','04248798789','Calle triangular',0,'1'),(3,99982839,'Gustabo','Jose','04149398839','Prados de la Encrucijada',0,'2'),(4,270368,'Carol','Sánchez','04168899191','U',0,'2'),(5,31136494,'Juan','Alfonso','04128899191','K',0,'2'),(6,66515484,'Ana','Sofia','04268282828','Hjjj',0,'2'),(7,96619494,'Carolina','Hernández','04168899191','Avenida Páez',0,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medico_especialidad`
--

LOCK TABLES `medico_especialidad` WRITE;
/*!40000 ALTER TABLE `medico_especialidad` DISABLE KEYS */;
INSERT INTO `medico_especialidad` VALUES (1,1,1,60,'1'),(2,2,4,80,'1'),(3,3,3,70,'1'),(4,4,3,60,'1'),(5,5,4,39,'1'),(6,6,4,65,'1'),(7,7,8,69,'1');
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
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) NOT NULL,
  `tipo_paciente` enum('1','2','3','4') NOT NULL,
  `estatus_pac` enum('1','2') NOT NULL DEFAULT '1',
  PRIMARY KEY (`paciente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente`
--

LOCK TABLES `paciente` WRITE;
/*!40000 ALTER TABLE `paciente` DISABLE KEYS */;
INSERT INTO `paciente` VALUES (1,'9099557','Angela','Sanchez','1967-03-23',57,'04243310758','Ciudad Jardin','1','2'),(90,'27849585','David Domingo','Suárez Delgado','2000-01-20',24,'04124568787','Barrio El Milagro','3','1'),(91,'1-27849585','Luis Miguel','Delgado Sánchez','2010-02-17',14,'04124568787','Barrio El Milagro','4','1'),(92,'55657555','Batmita','Juanito','2002-06-05',22,'02438283837','H','1','2'),(93,'266666','Calrissian','Blancos','1881-06-08',143,'04128899191','Calle 4-9_D','1','2'),(94,'28317069','Oriana','Blanco','2001-02-09',23,'04241212122','Cagua','3','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente_beneficiado`
--

LOCK TABLES `paciente_beneficiado` WRITE;
/*!40000 ALTER TABLE `paciente_beneficiado` DISABLE KEYS */;
INSERT INTO `paciente_beneficiado` VALUES (11,91,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paciente_seguro`
--

LOCK TABLES `paciente_seguro` WRITE;
/*!40000 ALTER TABLE `paciente_seguro` DISABLE KEYS */;
INSERT INTO `paciente_seguro` VALUES (1,94,1,3,'1',0,'2024-06-02',0,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pregunta_seguridad`
--

LOCK TABLES `pregunta_seguridad` WRITE;
/*!40000 ALTER TABLE `pregunta_seguridad` DISABLE KEYS */;
INSERT INTO `pregunta_seguridad` VALUES (1,6,'1','amarillo','1'),(2,6,'3','perez','1'),(3,6,'4','guayaba','1'),(4,7,'1','azul','1'),(5,7,'2','roberto','1'),(6,7,'3','lucia','1'),(7,20,'1','negro','1'),(8,20,'2','mimi','1'),(9,20,'4','carol','1'),(10,21,'1','negro','1'),(11,21,'2','mimi','1'),(12,21,'4','carol','1'),(13,22,'1','negro','1'),(14,22,'4','kiki','1'),(15,22,'7','los amigos imaginarios de la mancion fosther','1'),(16,23,'1','amarillo','1'),(17,23,'3','perez','1'),(18,23,'2','rocky','1'),(19,24,'1','root','1'),(20,24,'2','root','1'),(21,24,'3','root','1'),(22,1,'1','amarillo','1'),(23,1,'3','perez','1'),(24,1,'4','guayaba','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'asdasds','a','2'),(2,'Njjjhh','N','2'),(3,'Jjjjhh','N','2'),(4,'MiFresita C.A','Cagua','1'),(5,'San Fernando C.A','Maracay','2');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro`
--

LOCK TABLES `seguro` WRITE;
/*!40000 ALTER TABLE `seguro` DISABLE KEYS */;
INSERT INTO `seguro` VALUES (1,'Seguros Miranda','J-413123123','Cagua','04164131313',20,20,15,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro_empresa`
--

LOCK TABLES `seguro_empresa` WRITE;
/*!40000 ALTER TABLE `seguro_empresa` DISABLE KEYS */;
INSERT INTO `seguro_empresa` VALUES (1,3,1,'1');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguro_examen`
--

LOCK TABLES `seguro_examen` WRITE;
/*!40000 ALTER TABLE `seguro_examen` DISABLE KEYS */;
INSERT INTO `seguro_examen` VALUES (1,1,'7,8','10,20','1');
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
INSERT INTO `tipo_antecedente` VALUES (1,'Antecedentes Patológicos','2023-05-28 23:51:47','1'),(2,'Antecedentes Psicológicos','2023-05-28 23:51:47','1'),(3,'Antecedentes médicos familiares','2023-05-28 23:51:47','1'),(4,'Cirugías o traumatismos','2023-05-28 23:51:47','1'),(5,'Alergias','2023-05-28 23:51:47','1'),(6,'Reacción a medicamentos','2023-05-28 23:51:47','1'),(7,'Enfermedades Padecidas','2023-05-28 23:51:47','1'),(8,'Tratamientos','2023-05-28 23:51:47','1'),(9,'Hábitos de salud','2023-05-28 00:00:00','1');
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `titular_beneficiado`
--

LOCK TABLES `titular_beneficiado` WRITE;
/*!40000 ALTER TABLE `titular_beneficiado` DISABLE KEYS */;
INSERT INTO `titular_beneficiado` VALUES (23,11,90,'1','1','1');
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
  `nombres` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `nombre` varchar(16) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `tokken` varchar(10) DEFAULT NULL,
  `rol` int(11) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `estatus_usu` enum('1','2') NOT NULL DEFAULT '2',
  `fecha_creacion` datetime NOT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'','','Francis','$2y$10$wEEGqUfoLfoNt5LAGf.bbueWg4yKYzFAWYKSgYHOUcCWrfHQYrLka','476e6b1ca8',1,'$2y$10$VdmseZ1c7eMINwubw0aY7ulFN681iD7un5W2g.73LmPav5pP8IAGm','1','2023-10-14 11:29:39'),(2,'','','Maria','$2y$10$CQAslw2wTPHgG08rA8jj4OvICcHORklidC/V7TC1fHsDp5jvXHu9G','e281584c4b',3,'$2y$10$lIL/kC5QKpnrBFIhxpUOSeaFtM2qOkOz5IVfkRN7niMgufkqy.xxW','1','2023-10-14 11:30:03'),(3,'','','Juan','$2y$10$y2nP.bNOXOv7D9MBaA.0cOXcQ6qSnevvkae.vuqcbWbhjy.rZFpfy',NULL,4,'$2y$10$P5UN5gCK8i9z6y.80uofx.k4HMtC.Q3Rh3ZJowSzUJccEXkA2nYdK','1','2023-10-14 11:34:17'),(4,'','','Oriana','$2y$10$Ts29vTHuUk9yQdelCZaOvOJNN.dDteAPHD6bl4z0I4aPgk2cG0x0C','912efb219c',2,'$2y$10$mqrXDImYH4GcA5RNxoYFXepssHuWpELbEC8PPNaHrn16axVfhFFLS','1','2024-04-05 04:12:53'),(5,'','','Enrique','$2y$10$CgS7tzG4SiwxA0/x8qUC9uU/qIsuaPXPu/IqwBG2X2E9ELUXbhPEe',NULL,2,'$2y$10$MzpZREpNfO6cXEkzUA/BTedpK2PVVQrHeco3QINS/I3JYpmw2sI3S','1','2024-04-05 04:27:49'),(6,'','','Enrik','$2y$10$Tga3ZTyx/sDVLEXe/Gu6ieOtG/qYtCCv2XP4ioDnP1Jpd4DrZlx7e','151a398084',2,'$2y$10$4Pe1r6fR4A4zRJQ8Tgg9/.rM1VtQ9vonmDaF/L7h16zb5ugxKdlQu','1','2024-05-28 12:51:50'),(7,'','','enrique123','$2y$10$Rwwi2ixKgEAP8v0SNgI7qOf0JA45GoFLsAphVAPXyOxj8B6i.COHq','b5081aa1d8',1,'$2y$10$6AVqfnp6Obs3Tz1qkN.a9u88oFX.Yl9tFZXque1EtN.mvfrAcnu8S','1','2024-05-29 01:30:13'),(8,'','','Uriahs','$2y$10$i1Qg/m5jd623iiGZZ3mj2eMs1ttjc2HE80iwSKDoLJF4Bgk7NqaNC',NULL,2,'$2y$10$HpDYixGrYtaNnw1OPVVwkefSiaO6QhhFMyTvfb3DSINgMk1wqL9Ja','2','2024-05-29 05:27:20'),(9,'','','Uriahs','$2y$10$ihtfH7vefJ5LPSC1vlz2ve9zaqKktZbM28ad4ktAhP36OXCU.XY.G',NULL,2,'$2y$10$e.nxswSoobAEiIlgoA395uAVbWPOrHMLCIDXBuktxX8ITBg7Y6Y5m','2','2024-05-29 05:27:33'),(10,'','','Uriahs','$2y$10$4qTD.oXLz5XhxBUTLe/3O.qEMdbqv4P1qVJqPNZlfX.t2DtDygtta',NULL,2,'$2y$10$U2S3ApLYM/Gi2LKwcEfO3eN3b7o1qCV2H/LnY2q6OdRdg7keejc7e','2','2024-05-29 05:27:34'),(11,'','','Uriahs','$2y$10$Y9IB3WPDcuVaeLlJY5/GfeCIxk5kjQ8eNQ01IcJ06tY9EL7kYIT5O',NULL,2,'$2y$10$sfD8LAc96xTQJq80MzAK8eYpVDHmxsu5D07FCCKetwHkx3oAZhg22','2','2024-05-29 05:28:54'),(12,'','','Uriahs','$2y$10$PAFyfH6TyOYxhlH.uZIcUeGG28ZLPTPEn13iPfskEDx7dJUxqympq',NULL,2,'$2y$10$cIF6Ig9FAO9BPVKhW6ShFOE3Y8S//15R24B8QFV6JifWRic1K3Jj','2','2024-05-29 05:28:56'),(13,'','','Uriahs','$2y$10$cEWYil5pgs6VfVIUTLNAvek..AjOHHck.qq6IGsrdwkesquWiY1EW',NULL,2,'$2y$10$Qg5pYUVATlOtxMUWHOGJG.It6Z8SAcWt0Ge/jLBARYUJqAGxfwLee','2','2024-05-29 05:28:57'),(14,'','','Uriahs','$2y$10$qtYf7KomDh5OJYy9X1m0hejEHJtfGOjBG4NI/6AtjC7cyYf2F3.n',NULL,2,'$2y$10$Xel2C1FDBOpB9G8vF7BN1uOeDnbpJPXD2NfKtvFlRraWYpVClDKHa','2','2024-05-29 05:31:26'),(15,'','','Ori','$2y$10$9w3gJ7YhEnHJ7B66IGvEh.smjsvnd9hdvr1oL9MdlJ895ATupSqQC',NULL,2,'$2y$10$RupOA69HUxg.LUicdpXIh.l4Jy4XvralJgA0J/XQTFC6Dz6A8z5oG','2','2024-05-29 05:40:58'),(16,'','','mason','$2y$10$mSExPgAKLYwATz4mFHhKZ.vw/1Yb7G4Ior/m12wpxB8qKnFU7xT3S',NULL,2,'$2y$10$h3s67aCVrSfdZXlNtYQ1BOtTdYxCAZKydIRAf5fD71olvz07w1Yle','2','2024-05-29 05:41:32'),(17,'','','mason','$2y$10$RTF/ZF73exkQPmqSvhdjLuFR8TrCYrkPZgyyhOSQg0l/sZ5SoXmAC',NULL,5,'$2y$10$xjEsamlW4BobpmrNp2Ayduz4Ct85pv89.4wDzcHFEv0R7/L4/PYgu','2','2024-05-29 05:42:45'),(18,'','','Ori','$2y$10$esFYSzCpOgnLFZpG5eTV/OU28ApD/ulH6wS01tHuAboc/lW0OXxku',NULL,2,'$2y$10$WT0oRJObsTo8BdBiZgG4XOgoxSjp2e02mayDvckysagw3hT9SoDyy','2','2024-05-29 05:46:42'),(19,'','','rike','$2y$10$ePFhHM2WSNi5lyJIyu7uMulFk9IVxU9EerVPuZSOe7znkkK8w42fi',NULL,5,'$2y$10$J5ku79mKzU/nHMKlTDLXG.HFgBqAWWxV3T4op.CAd7clTFY2IyZB2','2','2024-05-29 05:52:03'),(20,'Uriahs','Calrissian','Uriahs','$2y$10$RvjUzKNzMa/oM.USuwFLIO4pm2gMBXPC8guntc.OKocKBo2YZiMWS',NULL,2,'$2y$10$kq6.TNJFu48agoZwHDQyG.sJ1RqNpYmzaOaqf7bJKkaBpRS/EKGg2','2','2024-05-31 04:16:21'),(21,'rike','rike','riki','$2y$10$N4sBBfVVYScugdURIr//gutTW2sYkAkk28lcvYI6LdZfV68sjtsz6',NULL,2,'$2y$10$XP8Pfph7w1QuaHeuLlVw0OjM6YKylxYSs8ReyUbklVJ0Aiwr8iY9u','2','2024-05-31 04:25:56'),(22,'Marley','Yoggu','Marley','$2y$10$9Q8XZ10lHJnoqh92baAOqutqXsHoC7kdzL6VKRgiIprlMEYnXgzhu',NULL,3,'$2y$10$wlLx4momF.tKY1fHXplVg.do6OYm0C5OKEdi6ou6.Q/CmB27vhOLa','2','2024-05-31 11:42:24'),(23,'Luis','Alba','Luis','$2y$10$3E0Li86p1kP5lgvg1uVL4eKk29x3UihT4eerfehNgZ74Y7snIJVYi','9e2dc3cac7',2,'$2y$10$Ix7cCfQOnTO7rF5wLHM8SevEJtOttznq3sMm9P3NPEHRW2AFtlHu','1','2024-06-02 04:38:35'),(24,'root','root','root','$2y$10$/G6z9WYkg3573WGcIP690O8oBLcKpIdsn2kQID8fEsKsn/lfyPZmK',NULL,1,'$2y$10$gFgAXmtfP4nfIs6dPy2Yfue9sjBl//Z/Xf.AaniC1g0MiLFoVCDVm','1','2024-06-04 02:42:36');
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

-- Dump completed on 2024-06-10 18:12:49
