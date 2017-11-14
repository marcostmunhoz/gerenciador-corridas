CREATE DATABASE  IF NOT EXISTS `heroku_de5dfc1975ecdc6` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `heroku_de5dfc1975ecdc6`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: us-cdbr-iron-east-05.cleardb.net    Database: heroku_de5dfc1975ecdc6
-- ------------------------------------------------------
-- Server version	5.6.36-log

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
-- Table structure for table `tb_corrida`
--

DROP TABLE IF EXISTS `tb_corrida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_corrida` (
  `id_corrida` int(11) NOT NULL AUTO_INCREMENT,
  `id_motorista` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_corrida`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_corrida`
--

LOCK TABLES `tb_corrida` WRITE;
/*!40000 ALTER TABLE `tb_corrida` DISABLE KEYS */;
INSERT INTO `tb_corrida` VALUES (4,17,10.00),(9,14,100.00),(10,10,50.00),(11,5,30.00),(21,14,100.92);
/*!40000 ALTER TABLE `tb_corrida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_corrida_passageiro`
--

DROP TABLE IF EXISTS `tb_corrida_passageiro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_corrida_passageiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_passageiro` int(11) NOT NULL,
  `id_corrida` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_passageiro` (`id_passageiro`),
  KEY `fk_corrida` (`id_corrida`),
  CONSTRAINT `fk_corrida` FOREIGN KEY (`id_corrida`) REFERENCES `tb_corrida` (`id_corrida`),
  CONSTRAINT `fk_passageiro` FOREIGN KEY (`id_passageiro`) REFERENCES `tb_passageiro` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_corrida_passageiro`
--

LOCK TABLES `tb_corrida_passageiro` WRITE;
/*!40000 ALTER TABLE `tb_corrida_passageiro` DISABLE KEYS */;
INSERT INTO `tb_corrida_passageiro` VALUES (1,16,4),(2,5,4),(3,8,9),(4,31,9),(5,3,9),(6,5,9),(7,24,10),(8,35,10),(11,8,11),(21,31,11),(31,31,21),(41,10,21),(51,40,21),(61,47,21);
/*!40000 ALTER TABLE `tb_corrida_passageiro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_motorista`
--

DROP TABLE IF EXISTS `tb_motorista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_motorista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` char(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `data_nasc` date NOT NULL,
  `modelo_veic` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sexo` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_motorista`
--

LOCK TABLES `tb_motorista` WRITE;
/*!40000 ALTER TABLE `tb_motorista` DISABLE KEYS */;
INSERT INTO `tb_motorista` VALUES (1,'96177008283','Timmie Uglow','1994-02-06','Xterra',0,'F'),(2,'94257497241','Inglebert Duigan','1983-04-06','Ram 2500 Club',0,'M'),(3,'13258318312','Birgitta Barrington','1981-11-15','Firebird Formula',0,'F'),(4,'56638003352','Justinian Whiff','1994-01-24','Vandura 2500',0,'M'),(5,'14472529259','Deerdre Blanckley','1983-04-27','300SD',1,'F'),(6,'06400129192','Inesita Yaus','1992-12-10','Sierra 3500',1,'M'),(7,'21933414882','Ethelin Swatheridge','1986-09-19','Voyager',0,'F'),(8,'54334073616','Inglis Keates','1989-05-11','T100',1,'F'),(9,'92614422532','Celestina Hedin','1988-12-28','CLK-Class',0,'M'),(10,'54573794453','Merrielle Reville','1988-01-24','H3',1,'F'),(11,'01414082135','Mattheus Pasley','1982-07-31','LX',0,'F'),(12,'72818286325','Cornie Marrill','1985-01-26','Sunbird',1,'F'),(13,'54964950687','Gene Simmons','1984-07-13','Versa',0,'M'),(14,'22184541876','Bron Allwright','1989-07-31','Grand Marquis',1,'M'),(15,'89563384375','Nesta Perrigo','1993-04-05','Cobalt',0,'F'),(16,'69224614236','Salaidh Stallan','1987-04-26','Fox',1,'M'),(17,'64002622066','Annamarie Puttick','1991-11-24','Rio',0,'M'),(18,'94062094471','Vasilis Szwandt','1992-10-26','S60',0,'F'),(19,'48217260654','Gretna Lenard','1980-05-13','Ram 1500',0,'M'),(20,'52264320835','Estrellita Taillant','1981-01-16','Passat',0,'M');
/*!40000 ALTER TABLE `tb_motorista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tb_passageiro`
--

DROP TABLE IF EXISTS `tb_passageiro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_passageiro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cpf` char(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_passageiro`
--

LOCK TABLES `tb_passageiro` WRITE;
/*!40000 ALTER TABLE `tb_passageiro` DISABLE KEYS */;
INSERT INTO `tb_passageiro` VALUES (1,'71160287938','Trent Crathern','1994-08-05','F'),(2,'83927197288','Darda Medlen','1983-01-11','M'),(3,'06672817638','Anabelle Skeffington','1981-04-01','F'),(4,'49453665766','Lelah Bellenie','1993-10-06','M'),(5,'00777073530','Andi Moulton','1985-05-24','M'),(6,'21475253942','Helenka Tweedlie','1982-06-21','M'),(7,'36697462995','Jacquette Carruthers','1992-01-12','F'),(8,'40976419177','Abra Hamly','1980-02-25','F'),(9,'51039496901','Fidole O\'Doghesty','1982-12-07','M'),(10,'31743191726','Arman Glendining','1992-10-15','F'),(11,'32925681710','Jewel Biskup','1986-12-23','M'),(12,'29234301077','Nicole Klimkov','1988-06-18','F'),(13,'51193408837','Yanaton De Witt','1994-04-24','F'),(14,'78424974319','Hillel Follos','1988-04-15','M'),(15,'26208311172','Garry Jarry','1990-12-29','M'),(16,'04454464294','Aundrea Culp','1993-09-27','F'),(17,'75057992371','Eric Blaxter','1994-09-21','F'),(18,'22155234973','Roobbie Neeves','1982-07-28','M'),(19,'09440953858','Clayson Nano','1989-12-14','F'),(20,'43407597458','Phip Gorner','1993-12-10','F'),(21,'12278370687','Carol-jean Hartshorne','1994-12-03','M'),(22,'69816554083','Penelope Bunnell','1988-07-29','F'),(23,'78672341328','Anna-diana Wisbey','1983-11-19','M'),(24,'66842308530','Shelbi Pavlishchev','1989-01-27','M'),(25,'26602023612','Gardie Bard','1992-04-06','M'),(26,'14477828894','Ricca Tripean','1987-06-04','M'),(27,'26645193836','Roarke Berrey','1986-03-04','F'),(28,'87423951563','Halie Woolager','1985-05-13','F'),(29,'24329773505','Devlen Brazur','1990-04-04','M'),(30,'32566412815','Iorgo McFie','1994-11-11','M'),(31,'25062859921','Adrianna Corday','1985-12-06','F'),(32,'08950371246','Tracie Brookesbie','1989-07-03','F'),(33,'16381111601','Bobette Bentzen','1987-05-25','F'),(34,'63121115367','Susann McTrustie','1985-10-30','F'),(35,'70937844305','Rusty Rehn','1985-01-27','M'),(36,'98734448400','Colet Kneale','1984-08-10','M'),(37,'32818397957','Sutton Cartlidge','1992-03-08','F'),(38,'03793733709','Johnnie Massenhove','1980-08-07','M'),(39,'23869775879','Rebe Coulthart','1980-07-01','F'),(40,'45744960151','Jessee Skeen','1994-10-20','M'),(41,'65854055044','Dawn Darko','1983-03-08','M'),(42,'58558440582','Lorilyn Mugleston','1982-12-12','F'),(43,'10360375550','Roger Trenam','1992-08-05','F'),(44,'08640295389','Veradis Parley','1993-08-09','M'),(45,'56878564357','Roshelle Beverage','1985-09-13','F'),(46,'63844023151','Lindon Pledger','1980-05-02','M'),(47,'46458228347','Tedra Pays','1983-08-21','F'),(48,'51019023350','Roda Strongitharm','1981-06-16','M'),(49,'04646730767','Corry Pitherick','1985-01-20','M'),(50,'15829146445','Rea Blandford','1987-04-10','M');
/*!40000 ALTER TABLE `tb_passageiro` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-13 23:46:07
