-- MySQL dump 10.13  Distrib 5.6.27, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: abrenet_admin
-- ------------------------------------------------------
-- Server version	5.6.27-0ubuntu0.14.04.1

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
-- Table structure for table `sa_aseguradora`
--

DROP TABLE IF EXISTS `sa_aseguradora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_aseguradora` (
  `id` int(21) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `activado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_aseguradora`
--

LOCK TABLES `sa_aseguradora` WRITE;
/*!40000 ALTER TABLE `sa_aseguradora` DISABLE KEYS */;
INSERT INTO `sa_aseguradora` VALUES (1414006201,'Alianza','AL',1),(1414006202,'Credinform','CR',1),(1414006203,'Bisa Seguros','BS',1),(1414006204,'Nacional Vida','NV',1),(1414006205,'Crediseguro','CS',1);
/*!40000 ALTER TABLE `sa_aseguradora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_departamento`
--

DROP TABLE IF EXISTS `sa_departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_departamento` (
  `id` int(21) NOT NULL,
  `departamento` varchar(140) NOT NULL,
  `codigo` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_departamento`
--

LOCK TABLES `sa_departamento` WRITE;
/*!40000 ALTER TABLE `sa_departamento` DISABLE KEYS */;
INSERT INTO `sa_departamento` VALUES (1414006201,'La Paz','LP'),(1414006202,'Oruro','OR'),(1414006203,'Potosi','PT'),(1414006204,'Cochabamba','CB'),(1414006205,'Chuquisaca','CH'),(1414006206,'Tarija','TJ'),(1414006207,'Santa Cruz','SC'),(1414006208,'Beni','BE'),(1414006209,'Pando','PA');
/*!40000 ALTER TABLE `sa_departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_ef_aseguradora`
--

DROP TABLE IF EXISTS `sa_ef_aseguradora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_ef_aseguradora` (
  `id` int(21) NOT NULL,
  `entidad_financiera` int(21) NOT NULL,
  `aseguradora` int(21) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entidad_financiera` (`entidad_financiera`),
  KEY `aseguradora` (`aseguradora`),
  CONSTRAINT `sa_ef_aseguradora_ibfk_1` FOREIGN KEY (`entidad_financiera`) REFERENCES `sa_entidad_financiera` (`id`),
  CONSTRAINT `sa_ef_aseguradora_ibfk_2` FOREIGN KEY (`aseguradora`) REFERENCES `sa_aseguradora` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_ef_aseguradora`
--

LOCK TABLES `sa_ef_aseguradora` WRITE;
/*!40000 ALTER TABLE `sa_ef_aseguradora` DISABLE KEYS */;
INSERT INTO `sa_ef_aseguradora` VALUES (1414006201,1414006207,1414006205),(1414006206,1414006204,1414006201),(1414006207,1414006205,1414006204),(1414006208,1414006206,1414006204),(1414006210,1414006202,1414006201),(1416930830,1414006203,1414006203),(1416930885,1414006201,1414006201),(1416930886,1414006201,1414006202),(1416930887,1414006201,1414006205);
/*!40000 ALTER TABLE `sa_ef_aseguradora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_ef_producto`
--

DROP TABLE IF EXISTS `sa_ef_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_ef_producto` (
  `id` int(21) NOT NULL,
  `entidad_financiera` int(21) NOT NULL,
  `producto` int(21) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `entidad_financiera` (`entidad_financiera`),
  KEY `producto` (`producto`),
  CONSTRAINT `sa_ef_producto_ibfk_1` FOREIGN KEY (`entidad_financiera`) REFERENCES `sa_entidad_financiera` (`id`),
  CONSTRAINT `sa_ef_producto_ibfk_2` FOREIGN KEY (`producto`) REFERENCES `sa_producto` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_ef_producto`
--

LOCK TABLES `sa_ef_producto` WRITE;
/*!40000 ALTER TABLE `sa_ef_producto` DISABLE KEYS */;
INSERT INTO `sa_ef_producto` VALUES (1414006204,1414006207,1414006201),(1414006205,1414006206,1414006201),(1414006206,1414006204,1414006201),(1414006207,1414006205,1414006201),(1414006210,1414006202,1414006201),(1416930829,1414006203,1414006202),(1416930830,1414006203,1414006203),(1416930884,1414006201,1414006201),(1416930885,1414006201,1414006202),(1416930886,1414006201,1414006203);
/*!40000 ALTER TABLE `sa_ef_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_ef_usuario`
--

DROP TABLE IF EXISTS `sa_ef_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_ef_usuario` (
  `id` int(21) NOT NULL,
  `usuario` int(21) NOT NULL,
  `entidad_financiera` int(21) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario` (`usuario`),
  KEY `entidad_financiera` (`entidad_financiera`),
  CONSTRAINT `sa_ef_usuario_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `sa_usuario` (`id`),
  CONSTRAINT `sa_ef_usuario_ibfk_2` FOREIGN KEY (`entidad_financiera`) REFERENCES `sa_entidad_financiera` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_ef_usuario`
--

LOCK TABLES `sa_ef_usuario` WRITE;
/*!40000 ALTER TABLE `sa_ef_usuario` DISABLE KEYS */;
INSERT INTO `sa_ef_usuario` VALUES (1414006201,1414006201,1414006201),(1414006202,1414006201,1414006202),(1414006203,1414006201,1414006203),(1414006204,1414006201,1414006204),(1414006205,1414006201,1414006205),(1414006206,1414006201,1414006206),(1414006207,1414006201,1414006207);
/*!40000 ALTER TABLE `sa_ef_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_entidad_financiera`
--

DROP TABLE IF EXISTS `sa_entidad_financiera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_entidad_financiera` (
  `id` int(21) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `dominio` varchar(140) NOT NULL,
  `db_host` varchar(140) NOT NULL,
  `db_database` varchar(140) NOT NULL,
  `db_user` varchar(140) NOT NULL,
  `db_password` varchar(140) NOT NULL,
  `activado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`,`dominio`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_entidad_financiera`
--

LOCK TABLES `sa_entidad_financiera` WRITE;
/*!40000 ALTER TABLE `sa_entidad_financiera` DISABLE KEYS */;
INSERT INTO `sa_entidad_financiera` VALUES (1414006201,'Ecofuturo','EC','ecofuturo','localhost','ecofuturo','root','',1),(1414006202,'Sembrar Sartawi','SS','sembrarsartawi','localhost','sartawi','root','',1),(1414006203,'Bisa Leasing','BL','bisaleasing','localhost','bisa','root','',1),(1414006204,'Emprender','EM','emprender','localhost','emprender','root','',1),(1414006205,'Paulo VI','PV','paulovi','localhost','paulo','root','',1),(1414006206,'Idepro','ID','idepro','localhost','idepro','root','',1),(1414006207,'Crecer','CR','crecer','localhost','crecer','root','',1);
/*!40000 ALTER TABLE `sa_entidad_financiera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_producto`
--

DROP TABLE IF EXISTS `sa_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_producto` (
  `id` int(21) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `activado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_producto`
--

LOCK TABLES `sa_producto` WRITE;
/*!40000 ALTER TABLE `sa_producto` DISABLE KEYS */;
INSERT INTO `sa_producto` VALUES (1414006201,'Desgravamen','DE',1),(1414006202,'Automotores','AU',1),(1414006203,'Todo Riesgo','TRD',1),(1414006204,'Ramos Tecnicos','TRM',0);
/*!40000 ALTER TABLE `sa_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_usuario`
--

DROP TABLE IF EXISTS `sa_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_usuario` (
  `id` int(21) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(140) NOT NULL,
  `email` varchar(140) NOT NULL,
  `departamento` int(21) NOT NULL,
  `permiso` int(21) NOT NULL,
  `fechsa_creacion` date NOT NULL,
  `activado` tinyint(1) DEFAULT '0',
  `actualizacion_password` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `departamento` (`departamento`),
  KEY `permiso` (`permiso`),
  CONSTRAINT `sa_usuario_ibfk_1` FOREIGN KEY (`departamento`) REFERENCES `sa_departamento` (`id`),
  CONSTRAINT `sa_usuario_ibfk_2` FOREIGN KEY (`permiso`) REFERENCES `sa_usuario_permiso` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_usuario`
--

LOCK TABLES `sa_usuario` WRITE;
/*!40000 ALTER TABLE `sa_usuario` DISABLE KEYS */;
INSERT INTO `sa_usuario` VALUES (1414006201,'admin','$2x$07$PdFU.UF9lzJ8dJtRrbqpr.PrYG4VIUT1sZL6ibd08moIr3Ou6uacm','Administrador','mmamani@coboser.com',1414006201,1414006201,'2014-10-23',1,1);
/*!40000 ALTER TABLE `sa_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sa_usuario_permiso`
--

DROP TABLE IF EXISTS `sa_usuario_permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sa_usuario_permiso` (
  `id` int(21) NOT NULL,
  `permiso` varchar(140) NOT NULL,
  `codigo` varchar(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sa_usuario_permiso`
--

LOCK TABLES `sa_usuario_permiso` WRITE;
/*!40000 ALTER TABLE `sa_usuario_permiso` DISABLE KEYS */;
INSERT INTO `sa_usuario_permiso` VALUES (1414006201,'Administrador','ROOT'),(1414006202,'Reportes Generales','RGR'),(1414006203,'Reportes Clientes','RCL'),(1414006204,'Reportes Generales/Clientes','RGC');
/*!40000 ALTER TABLE `sa_usuario_permiso` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-03-14 13:47:20
