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