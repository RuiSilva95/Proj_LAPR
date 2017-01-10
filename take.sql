-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: take
-- ------------------------------------------------------
-- Server version	5.5.53-0+deb7u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `address` text,
  `email` text NOT NULL,
  `phone` int(9) NOT NULL,
  `private` int(1) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equip_problem`
--

DROP TABLE IF EXISTS `equip_problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equip_problem` (
  `id_equipment_problem` int(11) NOT NULL AUTO_INCREMENT,
  `problem_damage` text,
  `description(client)` text,
  `description(employee)` text,
  `service_provided` text,
  `material_suplied` text,
  PRIMARY KEY (`id_equipment_problem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equip_problem`
--

LOCK TABLES `equip_problem` WRITE;
/*!40000 ALTER TABLE `equip_problem` DISABLE KEYS */;
/*!40000 ALTER TABLE `equip_problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_status`
--

DROP TABLE IF EXISTS `equipment_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_status` (
  `id_equipment_status` int(11) NOT NULL AUTO_INCREMENT,
  `status` text,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `work_hours` text,
  PRIMARY KEY (`id_equipment_status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_status`
--

LOCK TABLES `equipment_status` WRITE;
/*!40000 ALTER TABLE `equipment_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipment_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `external`
--

DROP TABLE IF EXISTS `external`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `external` (
  `id_external` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_equipment_status` int(11) DEFAULT NULL,
  `description` text,
  `service_provided` text,
  `budget` text,
  PRIMARY KEY (`id_external`),
  KEY `external_ibfk_1` (`id_equipment_status`),
  CONSTRAINT `external_ibfk_1` FOREIGN KEY (`id_equipment_status`) REFERENCES `equipment_status` (`id_equipment_status`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `external`
--

LOCK TABLES `external` WRITE;
/*!40000 ALTER TABLE `external` DISABLE KEYS */;
/*!40000 ALTER TABLE `external` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internal`
--

DROP TABLE IF EXISTS `internal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `internal` (
  `id_internal` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_equipment_status` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `id_equipment_problem` int(11) DEFAULT NULL,
  `id_service_problem` int(11) DEFAULT NULL,
  `budget` text,
  PRIMARY KEY (`id_internal`),
  KEY `internal_ibfk_1` (`id_equipment_status`),
  KEY `internal_ibfk_2` (`id_product`),
  KEY `internal_ibfk_3` (`id_equipment_problem`),
  KEY `internal_ibfk_4` (`id_service_problem`),
  CONSTRAINT `internal_ibfk_1` FOREIGN KEY (`id_equipment_status`) REFERENCES `equipment_status` (`id_equipment_status`) ON DELETE CASCADE,
  CONSTRAINT `internal_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE,
  CONSTRAINT `internal_ibfk_3` FOREIGN KEY (`id_equipment_problem`) REFERENCES `equip_problem` (`id_equipment_problem`) ON DELETE CASCADE,
  CONSTRAINT `internal_ibfk_4` FOREIGN KEY (`id_service_problem`) REFERENCES `service_problem` (`id_service_problem`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internal`
--

LOCK TABLES `internal` WRITE;
/*!40000 ALTER TABLE `internal` DISABLE KEYS */;
/*!40000 ALTER TABLE `internal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `de` int(11) DEFAULT NULL,
  `para` int(11) DEFAULT NULL,
  `title` text,
  `message` text,
  `date` date DEFAULT NULL,
  `leu` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `equipment` text,
  `mark_models` text,
  `nSeries` text,
  `acessories` text,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `id_service` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `address` text,
  `email` text,
  `phone` int(9) NOT NULL,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_problem`
--

DROP TABLE IF EXISTS `service_problem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_problem` (
  `id_service_problem` int(11) NOT NULL AUTO_INCREMENT,
  `id_service` int(11) DEFAULT NULL,
  `check` text,
  `budget` text,
  `configuration` text,
  `report_problem` text,
  `sending_date` timestamp NULL DEFAULT NULL,
  `deliver_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_service_problem`),
  KEY `service_problem_ibfk_1` (`id_service`),
  CONSTRAINT `service_problem_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_problem`
--

LOCK TABLES `service_problem` WRITE;
/*!40000 ALTER TABLE `service_problem` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_problem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `status` int(1) NOT NULL,
  `data` mediumblob,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Rui','admin','$1$r1C0feSA$H3R.bZ53GoCA9oVCgaylN/','rmns95@gmail.com',1,''),(4,'Nuno','nuno','$1$r1C0feSA$H3R.bZ53GoCA9oVCgaylN/','nunoneto17@gmail.com',1,'');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-10 23:17:13
