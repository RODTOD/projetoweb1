-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: localhost    Database: projetoweb1
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cargos`
--

DROP TABLE IF EXISTS `cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargos` (
  `idcargo` int NOT NULL AUTO_INCREMENT,
  `nome_cargo` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idcargo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargos`
--

LOCK TABLES `cargos` WRITE;
/*!40000 ALTER TABLE `cargos` DISABLE KEYS */;
INSERT INTO `cargos` VALUES (1,'Programador'),(6,'Analista de Sistemas');
/*!40000 ALTER TABLE `cargos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventos` (
  `idevento` int NOT NULL AUTO_INCREMENT,
  `codigo` char(10) DEFAULT NULL,
  `nome_evento` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idevento`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventos`
--

LOCK TABLES `eventos` WRITE;
/*!40000 ALTER TABLE `eventos` DISABLE KEYS */;
INSERT INTO `eventos` VALUES (13,'123','Vencimento');
/*!40000 ALTER TABLE `eventos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folha_pagamento`
--

DROP TABLE IF EXISTS `folha_pagamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `folha_pagamento` (
  `idfolha` int NOT NULL AUTO_INCREMENT,
  `ano` char(4) DEFAULT NULL,
  `mes` char(2) DEFAULT NULL,
  `idservidor` int DEFAULT NULL,
  `idevento` int DEFAULT NULL,
  `provento` decimal(10,2) DEFAULT NULL,
  `desconto_imposto` decimal(10,2) DEFAULT NULL,
  `desconto_previdencia` decimal(10,2) DEFAULT NULL,
  `valor_liquido` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idfolha`),
  KEY `idservidor` (`idservidor`),
  KEY `idevento` (`idevento`),
  CONSTRAINT `folha_pagamento_ibfk_1` FOREIGN KEY (`idservidor`) REFERENCES `servidores` (`idservidor`),
  CONSTRAINT `folha_pagamento_ibfk_2` FOREIGN KEY (`idevento`) REFERENCES `eventos` (`idevento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folha_pagamento`
--

LOCK TABLES `folha_pagamento` WRITE;
/*!40000 ALTER TABLE `folha_pagamento` DISABLE KEYS */;
INSERT INTO `folha_pagamento` VALUES (1,'2020','12',34,13,6000.00,599.14,660.00,4740.86),(2,'2020','1',34,13,6000.00,599.14,660.00,4740.86),(3,'2020','12',35,13,2500.00,24.08,275.00,2200.93);
/*!40000 ALTER TABLE `folha_pagamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_geral`
--

DROP TABLE IF EXISTS `log_geral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_geral` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome_tabela` varchar(120) DEFAULT NULL,
  `id_tabela` int NOT NULL,
  `info_registro` varchar(120) NOT NULL,
  `data_op` datetime DEFAULT NULL,
  `tipo_op` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_geral`
--

LOCK TABLES `log_geral` WRITE;
/*!40000 ALTER TABLE `log_geral` DISABLE KEYS */;
INSERT INTO `log_geral` VALUES (1,'pessoas',5,'Rodrigo SIlva','2020-12-07 22:19:54',NULL),(2,'pessoas',7,'Rodrigo SIlva','2020-12-07 22:30:41','Delete'),(3,'pessoas',6,'Rodrigo SIlva','2020-12-07 22:30:56','Delete'),(4,'pessoas',9,'rodrigo moura','2020-12-08 08:19:09','Delete'),(5,'pessoas',19,'dasd','2020-12-08 08:32:32','Delete'),(6,'pessoas',18,'sdasda','2020-12-08 08:32:33','Delete'),(7,'pessoas',17,'asdasda','2020-12-08 08:32:34','Delete'),(8,'pessoas',16,'asdasda','2020-12-08 08:32:35','Delete'),(9,'pessoas',15,'asdasda','2020-12-08 08:32:36','Delete'),(10,'pessoas',14,'asdasda','2020-12-08 08:32:37','Delete'),(11,'pessoas',13,'asdasda','2020-12-08 08:32:37','Delete'),(12,'pessoas',12,'adasdas','2020-12-08 08:32:37','Delete'),(13,'pessoas',11,'adasdas','2020-12-08 08:32:38','Delete'),(14,'pessoas',10,'adasdas','2020-12-08 08:32:38','Delete'),(15,'pessoas',8,'rodrigo moura','2020-12-08 08:32:40','Delete'),(16,'pessoas',5,'Rodrigo SIlva','2020-12-08 15:03:24','Delete'),(17,'pessoas',5,'Rodrigo SIlva','2020-12-08 18:17:42','Delete'),(18,'pessoas',5,'Rodrigo SIlva','2020-12-08 18:18:21','Delete'),(19,'pessoas',5,'Rodrigo SIlva','2020-12-08 18:18:22','Delete'),(20,'pessoas',5,'Rodrigo SIlva','2020-12-08 18:18:22','Delete'),(21,'pessoas',5,'Rodrigo SIlva','2020-12-08 18:18:22','Delete'),(22,'pessoas',5,'teste','2020-12-08 18:20:57','Delete'),(23,'pessoas',5,'teste','2020-12-08 18:26:32','Delete'),(24,'pessoas',5,'teste','2020-12-08 18:27:23','Delete'),(25,'pessoas',5,'teste','2020-12-08 18:27:24','Delete'),(26,'pessoas',5,'teste','2020-12-08 18:27:24','Delete'),(27,'pessoas',5,'teste','2020-12-08 18:27:41','Delete'),(28,'pessoas',5,'teste','2020-12-08 18:27:41','Delete'),(29,'pessoas',5,'teste','2020-12-08 18:27:42','Delete'),(30,'pessoas',5,'teste','2020-12-08 18:28:35','Delete'),(31,'pessoas',5,'teste','2020-12-08 18:28:36','Delete'),(32,'pessoas',5,'teste','2020-12-08 18:28:36','Delete'),(33,'pessoas',5,'teste','2020-12-08 18:28:36','Delete'),(34,'pessoas',5,'teste','2020-12-08 18:28:36','Delete'),(35,'pessoas',5,'teste','2020-12-08 18:28:37','Delete'),(36,'pessoas',5,'teste','2020-12-08 18:28:37','Delete'),(37,'pessoas',5,'teste','2020-12-08 18:28:37','Delete'),(38,'pessoas',5,'teste','2020-12-08 18:28:56','Delete'),(39,'pessoas',5,'teste','2020-12-08 18:29:43','Delete'),(40,'pessoas',5,'teste','2020-12-08 18:29:49','Delete'),(41,'pessoas',5,'teste','2020-12-08 18:31:50','Delete'),(42,'pessoas',5,'teste','2020-12-08 18:31:50','Delete'),(43,'pessoas',5,'teste','2020-12-08 18:31:51','Delete'),(44,'pessoas',5,'teste','2020-12-08 20:52:04','Delete'),(45,'pessoas',5,'teste','2020-12-08 20:57:51','Delete'),(46,'pessoas',5,'teste','2020-12-08 20:58:00','Delete'),(47,'pessoas',5,'testeeee','2020-12-08 20:58:05','Delete'),(48,'pessoas',5,'testeeee','2020-12-08 20:58:10','Delete'),(49,'pessoas',5,'testeeee','2020-12-08 20:58:13','Delete'),(50,'pessoas',5,'testeeee','2020-12-08 20:58:13','Delete'),(51,'pessoas',5,'testeeee','2020-12-08 20:59:39','Delete'),(52,'pessoas',5,'testeeee','2020-12-08 20:59:42','Delete'),(53,'pessoas',5,'testeeee','2020-12-08 20:59:44','Delete'),(54,'pessoas',5,'asdasd','2020-12-08 20:59:54','Delete'),(55,'pessoas',5,'asdasd','2020-12-08 20:59:57','Delete'),(56,'pessoas',5,'asdasd','2020-12-08 21:00:10','Delete'),(57,'pessoas',5,'asdasd','2020-12-08 21:02:06','Delete'),(58,'pessoas',5,'asdasd','2020-12-08 21:02:46','Delete'),(59,'pessoas',5,'asdasd','2020-12-08 21:02:53','Delete'),(60,'pessoas',5,'asdasd','2020-12-08 21:03:57','Delete'),(61,'pessoas',20,'Maria Silva','2020-12-08 21:04:02','Delete'),(62,'pessoas',5,'asdasd','2020-12-08 21:04:03','Delete'),(63,'pessoas',21,'Rodrigo MOura','2020-12-08 21:04:04','Delete'),(64,'pessoas',5,'asdasd','2020-12-08 21:04:05','Delete'),(65,'pessoas',21,'Rodrigo MOura','2020-12-08 21:04:06','Delete'),(66,'pessoas',21,'Rodrigo MOura','2020-12-08 21:04:07','Delete'),(67,'pessoas',21,'Rodrigo MOura','2020-12-08 21:04:07','Delete'),(68,'pessoas',5,'asdasd','2020-12-08 21:04:08','Delete'),(69,'pessoas',5,'asdasd','2020-12-08 21:04:11','Delete'),(70,'pessoas',5,'asdasd','2020-12-08 21:04:11','Delete'),(71,'pessoas',5,'asdasd','2020-12-08 21:04:11','Delete'),(72,'pessoas',5,'asdasd','2020-12-08 21:04:12','Delete'),(73,'pessoas',5,'asdasd','2020-12-08 21:04:12','Delete'),(74,'pessoas',5,'asdasd','2020-12-08 21:04:12','Delete'),(75,'pessoas',5,'asdasd','2020-12-08 21:04:12','Delete'),(76,'pessoas',5,'asdasd','2020-12-08 21:04:12','Delete'),(77,'pessoas',5,'asdasd','2020-12-08 21:04:24','Delete'),(78,'pessoas',5,'asdasd','2020-12-08 21:04:25','Delete'),(79,'pessoas',5,'asdasd','2020-12-08 21:04:25','Delete'),(80,'pessoas',5,'asdasd','2020-12-08 21:04:25','Delete'),(81,'pessoas',5,'asdasd','2020-12-08 21:04:27','Delete'),(82,'pessoas',5,'asdasd','2020-12-08 21:04:28','Delete'),(83,'pessoas',5,'asdasd','2020-12-08 21:04:29','Delete'),(84,'pessoas',5,'asdasd','2020-12-08 21:04:35','Delete'),(85,'pessoas',5,'asdasd','2020-12-08 21:04:36','Delete'),(86,'pessoas',5,'asdasd','2020-12-08 21:04:36','Delete'),(87,'pessoas',5,'asdasd','2020-12-08 21:04:48','Delete'),(88,'pessoas',5,'asdasd','2020-12-08 21:04:49','Delete'),(89,'pessoas',21,'Rodrigo MOura','2020-12-08 21:04:51','Delete'),(90,'pessoas',21,'Rodrigo MOura','2020-12-08 21:04:52','Delete'),(91,'pessoas',21,'Rodrigo MOura','2020-12-08 21:04:53','Delete'),(92,'pessoas',21,'Rodrigo MOura','2020-12-08 21:05:07','Delete'),(93,'pessoas',21,'Rodrigo MOura','2020-12-08 21:05:40','Delete'),(94,'pessoas',5,'asdasd','2020-12-08 21:05:41','Delete'),(95,'pessoas',5,'asdasd','2020-12-08 21:05:44','Delete'),(96,'pessoas',5,'asdasdsad','2020-12-08 21:05:47','Delete'),(97,'pessoas',21,'Rodrigo MOura','2020-12-08 21:05:49','Delete'),(98,'pessoas',21,'adasdadasdasda','2020-12-08 21:06:01','Delete'),(99,'pessoas',5,'asdasdsad','2020-12-08 21:06:22','Delete'),(100,'pessoas',5,'sdasdasdasdadadadadasdad','2020-12-08 21:06:27','Delete'),(101,'pessoas',5,'sdasdasdasdadadadadasdad','2020-12-08 21:06:32','Delete'),(102,'pessoas',5,'rodrigo','2020-12-08 21:06:36','Delete'),(103,'pessoas',5,'rodrigo','2020-12-08 21:47:29','Delete'),(104,'pessoas',5,'Rodrigo Silva Nascimento Moura','2020-12-08 21:47:55','Delete'),(105,'pessoas',5,'Rodrigo Silva Nascimento Moura','2020-12-08 23:56:12','Delete'),(106,'pessoas',5,'Rodrigo Silva Nascimento Moura','2020-12-09 00:29:03','Delete'),(107,'pessoas',5,'Rodrigo Silva Nascimennto Moura','2020-12-09 00:29:08','Delete'),(108,'pessoas',5,'Rodrigo Silva Nascimennto Moura','2020-12-09 00:31:06','Delete'),(109,'pessoas',5,'Rodrigo Silva Nascimennto Moura','2020-12-09 01:09:13','Delete'),(110,'pessoas',5,'Rodrigo Silva Nascimennnto Moura','2020-12-09 01:09:20','Delete'),(111,'pessoas',5,'Rodrigo Silva Nascimennnto Moura','2020-12-09 01:09:30','Delete'),(112,'pessoas',5,'Rrodrigo Silva Nascimennnto Moura','2020-12-09 01:09:37','Delete'),(113,'pessoas',5,'Rrodrigo Silva Nascimennnto Moura','2020-12-09 01:09:43','Delete'),(114,'pessoas',5,'Rrodrigo Silva Nascimennnto Moura','2020-12-09 01:17:34','Delete'),(115,'pessoas',5,'Rrodrigo Silva Nascimennnto Moura','2020-12-09 01:17:49','Delete'),(116,'servidores',34,'1234','2020-12-09 01:48:24','Update'),(117,'servidores',34,'12346','2020-12-09 01:48:38','Update'),(118,'servidores',34,'123467','2020-12-09 01:50:26','Update'),(119,'cargos',3,'Professor 2','2020-12-09 02:23:04','Delete'),(120,'cargos',2,'Vereador','2020-12-09 02:23:06','Delete'),(121,'cargos',1,'Programador 1','2020-12-09 02:23:08','Delete'),(122,'cargos',1,'Programador 1','2020-12-09 02:23:10','Delete'),(123,'cargos',1,'Programador 1','2020-12-09 02:23:11','Delete'),(124,'cargos',1,'Programador 1','2020-12-09 02:23:11','Delete'),(125,'cargos',1,'Programador 1','2020-12-09 02:23:22','Delete'),(126,'cargos',1,'Programador 1','2020-12-09 02:23:29','Delete'),(127,'cargos',1,'Programador','2020-12-09 02:23:53','Delete'),(128,'cargos',1,'Programador','2020-12-09 02:24:30','Delete'),(129,'cargos',1,'Programador','2020-12-09 02:24:31','Delete'),(130,'cargos',1,'Programador','2020-12-09 02:24:32','Delete'),(131,'cargos',1,'Programador','2020-12-09 02:24:33','Delete'),(132,'cargos',1,'Programador','2020-12-09 02:24:54','Delete'),(133,'cargos',1,'Programador','2020-12-09 02:24:54','Delete'),(134,'cargos',1,'Programador','2020-12-09 02:24:57','Delete'),(135,'cargos',1,'Programador','2020-12-09 02:25:06','Delete'),(136,'cargos',1,'Programador','2020-12-09 02:25:33','Delete'),(137,'cargos',1,'Programador','2020-12-09 02:25:33','Delete'),(138,'cargos',1,'Programador','2020-12-09 02:25:34','Delete'),(139,'cargos',1,'Programador','2020-12-09 02:25:57','Delete'),(140,'cargos',1,'Programador','2020-12-09 02:26:10','Delete'),(141,'cargos',1,'Programador','2020-12-09 02:26:11','Delete'),(142,'cargos',1,'Programador','2020-12-09 02:26:12','Delete'),(143,'cargos',1,'Programador','2020-12-09 02:26:12','Delete'),(144,'cargos',1,'Programador','2020-12-09 02:26:12','Delete'),(145,'cargos',1,'Programador','2020-12-09 02:26:12','Delete'),(146,'cargos',4,'Prefeito','2020-12-09 02:26:22','Delete'),(147,'cargos',1,'Programador','2020-12-09 02:26:23','Delete'),(148,'cargos',1,'Programador','2020-12-09 02:26:23','Delete'),(149,'cargos',1,'Programador','2020-12-09 02:26:24','Delete'),(150,'cargos',1,'Programador','2020-12-09 02:38:26','Delete'),(151,'cargos',1,'Programador','2020-12-09 02:38:27','Delete'),(152,'cargos',1,'Programador','2020-12-09 02:38:27','Delete'),(153,'cargos',1,'Programador','2020-12-09 02:38:28','Delete'),(154,'cargos',1,'Programador','2020-12-09 02:38:28','Delete'),(155,'cargos',1,'Programador','2020-12-09 02:38:28','Delete'),(156,'cargos',1,'Programador','2020-12-09 02:38:28','Delete'),(157,'cargos',1,'Programador','2020-12-09 02:38:29','Delete'),(158,'cargos',5,'TESTE','2020-12-09 02:38:33','Delete'),(159,'cargos',5,'TESTE','2020-12-09 02:38:33','Delete'),(160,'cargos',5,'TESTE','2020-12-09 02:38:34','Delete'),(161,'cargos',5,'TESTE','2020-12-09 02:38:34','Delete'),(162,'cargos',5,'TESTE','2020-12-09 02:39:12','Delete'),(163,'cargos',1,'Programador','2020-12-09 02:39:14','Delete'),(164,'cargos',1,'Programador','2020-12-09 02:39:14','Delete'),(165,'cargos',1,'Programador','2020-12-09 02:39:15','Delete'),(166,'orgaos',2,'Prefeitura Municipal de Joinville','2020-12-09 02:53:36','Delete'),(167,'eventos',10,'teste 1','2020-12-09 03:33:47','Delete'),(168,'eventos',9,'Teste','2020-12-09 03:33:49','Delete'),(169,'eventos',8,'2','2020-12-09 03:33:50','Delete'),(170,'eventos',7,'VEncimento','2020-12-09 03:33:51','Delete'),(171,'eventos',6,'VEncimentoo','2020-12-09 03:33:52','Delete'),(172,'eventos',11,'teste','2020-12-09 03:34:44','Delete'),(173,'eventos',12,'123213','2020-12-09 03:34:48','Delete'),(174,'servidores',34,'123467','2020-12-09 18:36:41','Update'),(175,'servidores',34,'123467','2020-12-09 19:02:06','Update');
/*!40000 ALTER TABLE `log_geral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orgaos`
--

DROP TABLE IF EXISTS `orgaos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orgaos` (
  `idorgao` int NOT NULL AUTO_INCREMENT,
  `nome_orgao` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idorgao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgaos`
--

LOCK TABLES `orgaos` WRITE;
/*!40000 ALTER TABLE `orgaos` DISABLE KEYS */;
INSERT INTO `orgaos` VALUES (1,'Prefeitura Municipal de Peixoto de Azevedo');
/*!40000 ALTER TABLE `orgaos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parametros` (
  `idparam` int NOT NULL AUTO_INCREMENT,
  `idorgao` int DEFAULT NULL,
  `missao` text,
  `visao` text,
  `valores` text,
  `endereco` varchar(120) DEFAULT NULL,
  `contato` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idparam`),
  KEY `idorgao` (`idorgao`),
  CONSTRAINT `parametros_ibfk_1` FOREIGN KEY (`idorgao`) REFERENCES `orgaos` (`idorgao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoas`
--

DROP TABLE IF EXISTS `pessoas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pessoas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) NOT NULL,
  `cpf` char(11) NOT NULL,
  `nome_mae` varchar(120) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoas`
--

LOCK TABLES `pessoas` WRITE;
/*!40000 ALTER TABLE `pessoas` DISABLE KEYS */;
INSERT INTO `pessoas` VALUES (5,'Rodrigo Silva Nascimento Moura','05797294192','Itaciethe Silva Nascimento','1999-10-02'),(23,'Maria da Silva','12345678910','Silva Maria','1990-01-01');
/*!40000 ALTER TABLE `pessoas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processo`
--

DROP TABLE IF EXISTS `processo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `processo` (
  `idprocesso` int NOT NULL AUTO_INCREMENT,
  `idservidor` int NOT NULL,
  `idTpProcesso` int NOT NULL,
  `dt_abertura` datetime DEFAULT NULL,
  `descricao_processo` text,
  PRIMARY KEY (`idprocesso`),
  KEY `idservidor` (`idservidor`),
  KEY `idTpProcesso` (`idTpProcesso`),
  CONSTRAINT `processo_ibfk_1` FOREIGN KEY (`idservidor`) REFERENCES `servidores` (`idservidor`),
  CONSTRAINT `processo_ibfk_2` FOREIGN KEY (`idTpProcesso`) REFERENCES `tipo_processo` (`idTpProcesso`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processo`
--

LOCK TABLES `processo` WRITE;
/*!40000 ALTER TABLE `processo` DISABLE KEYS */;
INSERT INTO `processo` VALUES (1,1,1,'2020-12-08 00:00:00','adasdsa'),(2,1,1,'2020-12-08 00:00:00','adasdsa'),(3,34,1,'2020-12-09 00:00:00','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id viverra metus. Nam non tellus metus. Vestibulum ut velit enim. Pellentesque egestas non eros a dictum. Nullam feugiat ligula in auctor tempus. Donec faucibus nisl in urna porta scelerisque. Nam non enim pulvinar, varius justo quis, ultrices tellus. Praesent feugiat, leo ut congue condimentum, ligula mi egestas enim, non posuere purus sapien vitae ipsum. Suspendisse vitae metus imperdiet, tempus est vel, cursus justo. Donec odio ligula, fermentum in tincidunt a, pellentesque ut nisi. Cras non enim consequat nibh scelerisque egestas. Pellentesque elementum tempus consequat.\r\n\r\nSed sed urna viverra lectus dignissim venenatis quis non nisl. Integer lacinia, orci et porttitor interdum, diam libero pretium justo, sed ornare tellus augue at nisi. Vivamus posuere et justo a sodales. Aenean congue turpis dui, eget feugiat diam pulvinar eu. Proin eleifend convallis lacinia. Fusce mi tortor, malesuada eu lacus vitae, viverra vestibulum mauris. Cras rutrum pulvinar dui sed gravida. Nulla imperdiet dui in nisi posuere, vel pulvinar est sodales. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam eu nisi eget ex tempor tincidunt in id arcu. Etiam ultricies nunc mauris, vitae cursus risus mollis eget. Aenean cursus congue odio. Maecenas pharetra vulputate turpis, eget sollicitudin velit condimentum ut. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aenean sed cursus nunc.');
/*!40000 ALTER TABLE `processo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servidores`
--

DROP TABLE IF EXISTS `servidores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servidores` (
  `idservidor` int NOT NULL AUTO_INCREMENT,
  `matricula` varchar(10) DEFAULT NULL,
  `idpessoa` int NOT NULL,
  `idcargo` int NOT NULL,
  `idorgao` int NOT NULL,
  `remuneracao` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idservidor`),
  KEY `idpessoa` (`idpessoa`),
  KEY `idcargo` (`idcargo`),
  KEY `idorgao` (`idorgao`),
  CONSTRAINT `servidores_ibfk_1` FOREIGN KEY (`idpessoa`) REFERENCES `pessoas` (`id`),
  CONSTRAINT `servidores_ibfk_2` FOREIGN KEY (`idcargo`) REFERENCES `cargos` (`idcargo`),
  CONSTRAINT `servidores_ibfk_3` FOREIGN KEY (`idorgao`) REFERENCES `orgaos` (`idorgao`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servidores`
--

LOCK TABLES `servidores` WRITE;
/*!40000 ALTER TABLE `servidores` DISABLE KEYS */;
INSERT INTO `servidores` VALUES (34,'123467',5,1,1,7000.00),(35,'321',23,6,1,2500.00);
/*!40000 ALTER TABLE `servidores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_processo`
--

DROP TABLE IF EXISTS `tipo_processo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_processo` (
  `idTpProcesso` int NOT NULL AUTO_INCREMENT,
  `nome_tipo_processo` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`idTpProcesso`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_processo`
--

LOCK TABLES `tipo_processo` WRITE;
/*!40000 ALTER TABLE `tipo_processo` DISABLE KEYS */;
INSERT INTO `tipo_processo` VALUES (1,'Processo Administrativo Padrão');
/*!40000 ALTER TABLE `tipo_processo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'projetoweb1'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-09 21:28:46
