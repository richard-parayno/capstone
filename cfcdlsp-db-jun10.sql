-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: cfcdlsp
-- ------------------------------------------------------
-- Server version	5.7.12-log

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
-- Table structure for table `carbrand_ref`
--

DROP TABLE IF EXISTS `carbrand_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carbrand_ref` (
  `carBrandID` int(6) NOT NULL AUTO_INCREMENT,
  `carBrandName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`carBrandID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carbrand_ref`
--

LOCK TABLES `carbrand_ref` WRITE;
/*!40000 ALTER TABLE `carbrand_ref` DISABLE KEYS */;
INSERT INTO `carbrand_ref` VALUES (1,'Toyota'),(2,'Mitsubishi'),(3,'Subaru'),(4,'Ford'),(5,'Honda'),(6,'Hyundai');
/*!40000 ALTER TABLE `carbrand_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cartype_ref`
--

DROP TABLE IF EXISTS `cartype_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cartype_ref` (
  `carTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `carTypeName` varchar(45) DEFAULT NULL,
  `mpg` decimal(8,2) NOT NULL,
  PRIMARY KEY (`carTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cartype_ref`
--

LOCK TABLES `cartype_ref` WRITE;
/*!40000 ALTER TABLE `cartype_ref` DISABLE KEYS */;
INSERT INTO `cartype_ref` VALUES (1,'Car',23.41),(2,'Bus',6.30),(3,'Van',21.64);
/*!40000 ALTER TABLE `cartype_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deptsperinstitution`
--

DROP TABLE IF EXISTS `deptsperinstitution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deptsperinstitution` (
  `deptID` int(6) NOT NULL AUTO_INCREMENT,
  `institutionID` int(6) NOT NULL,
  `deptName` varchar(90) DEFAULT NULL,
  `motherDeptID` int(6) DEFAULT NULL,
  PRIMARY KEY (`deptID`),
  KEY `fk_DEPARTMENTSPERINSTITUTION_INSTITUTIONS1_idx` (`institutionID`),
  KEY `fk_DEPARTMENTSPERINSTITUTION_DEPARTMENTSPERINSTITUTION1_idx` (`motherDeptID`),
  CONSTRAINT `fk_DEPARTMENTSPERINSTITUTION_DEPARTMENTSPERINSTITU1` FOREIGN KEY (`motherDeptID`) REFERENCES `deptsperinstitution` (`deptID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_DEPARTMENTSPERINSTITUTION_INSTITUTIO` FOREIGN KEY (`institutionID`) REFERENCES `institutions` (`institutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deptsperinstitution`
--

LOCK TABLES `deptsperinstitution` WRITE;
/*!40000 ALTER TABLE `deptsperinstitution` DISABLE KEYS */;
INSERT INTO `deptsperinstitution` VALUES (1,1,'Office of Sports Development',NULL),(2,1,'Brothers Community',NULL),(3,1,'Procurement Office',NULL),(4,1,'College of Computer Studies',NULL),(5,1,'College of Liberal Arts',NULL),(6,1,'College of Science',NULL),(7,1,'Ramon V. del Rosario College of Business',NULL),(8,1,'Br. Andrew Gonzales College of Education',NULL),(9,1,'School of Economics',NULL),(10,1,'Gokongwei College of Engineering',NULL),(11,1,'Information Technology',4),(12,1,'Computer Technology',4),(13,1,'Software Technology',4),(14,1,'Accounting',7),(15,1,'Civil Engineering',10),(16,1,'Central Administration Office',NULL),(17,1,'Integrated Office of the President and Chancellor',16),(18,1,'Office of the Vice Chancellor for Academics',16),(19,1,'Office of the President and Chancellor',17),(20,1,'Office of the Vice President for Finance',17),(21,1,'Office for the Dean of Student Affairs',NULL),(22,1,'Cultural Arts Office',21),(23,1,'Student Discipline Formation Office',21),(24,1,'Student Media Office',21),(25,1,'College of Law',NULL),(26,1,'College of Laravel',11),(27,1,'Health Services Office',NULL),(28,1,'OPC',NULL),(29,1,'Office of the Former President',NULL),(30,1,'OAVCFM',NULL),(31,1,'La Sallian Center',NULL),(32,1,'VCA',NULL),(33,1,'Libraries',NULL),(34,1,'VCRI',NULL),(35,1,'VPLM',NULL),(36,1,'OVC Admin',NULL),(37,1,'VPERIO',NULL),(38,1,'Biology',NULL),(39,2,'Office of the President',NULL),(40,2,'High School Department',NULL),(41,2,'Administrative Services',NULL),(42,2,'Lasallian Mission Office',NULL),(43,2,'Institutional Student Services',NULL),(44,2,'Grade School Department',NULL),(45,2,'Financial Resource Development',NULL);
/*!40000 ALTER TABLE `deptsperinstitution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fueltype_ref`
--

DROP TABLE IF EXISTS `fueltype_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fueltype_ref` (
  `fuelTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `fuelTypeName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fuelTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fueltype_ref`
--

LOCK TABLES `fueltype_ref` WRITE;
/*!40000 ALTER TABLE `fueltype_ref` DISABLE KEYS */;
INSERT INTO `fueltype_ref` VALUES (1,'Diesel'),(2,'Gasoline');
/*!40000 ALTER TABLE `fueltype_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutionbatchplant`
--

DROP TABLE IF EXISTS `institutionbatchplant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutionbatchplant` (
  `batchPlantID` int(6) NOT NULL AUTO_INCREMENT,
  `institutionID` int(6) NOT NULL,
  `numOfPlantedTrees` int(7) DEFAULT NULL,
  `datePlanted` date DEFAULT NULL,
  PRIMARY KEY (`batchPlantID`),
  KEY `fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1_idx` (`institutionID`),
  CONSTRAINT `fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1` FOREIGN KEY (`institutionID`) REFERENCES `institutions` (`institutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutionbatchplant`
--

LOCK TABLES `institutionbatchplant` WRITE;
/*!40000 ALTER TABLE `institutionbatchplant` DISABLE KEYS */;
INSERT INTO `institutionbatchplant` VALUES (1,1,5,'2018-03-20'),(3,1,20,'2018-04-10'),(19,1,100,'2018-04-09');
/*!40000 ALTER TABLE `institutionbatchplant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutions`
--

DROP TABLE IF EXISTS `institutions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutions` (
  `institutionID` int(11) NOT NULL AUTO_INCREMENT,
  `institutionName` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schoolTypeID` int(11) NOT NULL,
  `location` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`institutionID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutions`
--

LOCK TABLES `institutions` WRITE;
/*!40000 ALTER TABLE `institutions` DISABLE KEYS */;
INSERT INTO `institutions` VALUES (1,'De La Salle University',1,'Taft Avenue'),(2,'La Salle Green Hills',3,'Mandaluyong');
/*!40000 ALTER TABLE `institutions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (37,'2018_02_01_105716_create_carbrand_ref_table',0),(38,'2018_02_01_105716_create_cartype_ref_table',0),(39,'2018_02_01_105716_create_deptsperinstitution_table',0),(40,'2018_02_01_105716_create_fueltype_ref_table',0),(41,'2018_02_01_105716_create_institutionbatchplant_table',0),(42,'2018_02_01_105716_create_institutions_table',0),(43,'2018_02_01_105716_create_monthlyemissions_table',0),(44,'2018_02_01_105716_create_monthlyemissionsperschool_table',0),(45,'2018_02_01_105716_create_schooltype_ref_table',0),(46,'2018_02_01_105716_create_trips_table',0),(47,'2018_02_01_105716_create_users_table',0),(48,'2018_02_01_105716_create_usertypes_ref_table',0),(49,'2018_02_01_105716_create_vehicles_mv_table',0),(50,'2018_02_01_105717_add_foreign_keys_to_deptsperinstitution_table',0),(51,'2018_02_01_105717_add_foreign_keys_to_institutionbatchplant_table',0),(52,'2018_02_01_105717_add_foreign_keys_to_monthlyemissionsperschool_table',0),(53,'2018_02_01_105717_add_foreign_keys_to_trips_table',0),(54,'2018_02_01_105717_add_foreign_keys_to_users_table',0),(55,'2018_02_01_105717_add_foreign_keys_to_vehicles_mv_table',0),(56,'2018_02_01_105855_change-dept-name',1),(57,'2018_02_06_095558_update_user_password_length',2),(58,'2018_02_06_100825_add_remember_token_to_users',3),(59,'2018_02_06_102443_add_status_to_user',4),(60,'2018_02_07_115151_change_remember_token_to_nullable',5),(61,'2018_02_15_095545_add_created_at_and_updated_at_in_user',6),(62,'2018_02_15_105902_change_user_i_d_to_id',7),(63,'2018_02_20_152836_add_mpg_to_cartype_ref',8),(64,'2018_02_27_154856_add_emissions_to_trips',9),(67,'2018_03_01_113934_remove_emissions',10),(72,'2018_03_01_115235_add_emissions_but_now_double',11),(73,'2018_03_07_131832_add_tripdate_to_trips',11),(74,'2018_03_20_095726_add_triptime_to_trips',11),(75,'2018_03_20_175059_change_kilometerreading_to_decimal',12),(76,'2018_03_23_182228_add_audit_trail_to_trips',13);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthlyemissions`
--

DROP TABLE IF EXISTS `monthlyemissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monthlyemissions` (
  `MONTHYEAR` date NOT NULL,
  `emission` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`MONTHYEAR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthlyemissions`
--

LOCK TABLES `monthlyemissions` WRITE;
/*!40000 ALTER TABLE `monthlyemissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthlyemissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthlyemissionsperschool`
--

DROP TABLE IF EXISTS `monthlyemissionsperschool`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monthlyemissionsperschool` (
  `monthYear` date NOT NULL,
  `institutionID` int(6) NOT NULL,
  `emission` double NOT NULL,
  PRIMARY KEY (`monthYear`),
  KEY `fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1_idx` (`institutionID`),
  CONSTRAINT `fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1` FOREIGN KEY (`institutionID`) REFERENCES `institutions` (`institutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthlyemissionsperschool`
--

LOCK TABLES `monthlyemissionsperschool` WRITE;
/*!40000 ALTER TABLE `monthlyemissionsperschool` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthlyemissionsperschool` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schooltype_ref`
--

DROP TABLE IF EXISTS `schooltype_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schooltype_ref` (
  `schoolTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `schoolTypeName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`schoolTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schooltype_ref`
--

LOCK TABLES `schooltype_ref` WRITE;
/*!40000 ALTER TABLE `schooltype_ref` DISABLE KEYS */;
INSERT INTO `schooltype_ref` VALUES (1,'University'),(2,'College'),(3,'High School'),(4,'Grade School'),(5,'Pre-School');
/*!40000 ALTER TABLE `schooltype_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thresholds_ref`
--

DROP TABLE IF EXISTS `thresholds_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `thresholds_ref` (
  `name` varchar(45) NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thresholds_ref`
--

LOCK TABLES `thresholds_ref` WRITE;
/*!40000 ALTER TABLE `thresholds_ref` DISABLE KEYS */;
INSERT INTO `thresholds_ref` VALUES ('GREEN',1.5),('ORANGE',0.7),('RED',0.4),('YELLOW',1);
/*!40000 ALTER TABLE `thresholds_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trips`
--

DROP TABLE IF EXISTS `trips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trips` (
  `tripID` int(6) NOT NULL AUTO_INCREMENT,
  `deptID` int(6) NOT NULL,
  `plateNumber` varchar(7) NOT NULL,
  `kilometerReading` decimal(6,2) DEFAULT NULL,
  `remarks` varchar(45) DEFAULT NULL,
  `emissions` decimal(65,30) NOT NULL,
  `tripDate` date NOT NULL,
  `tripTime` time NOT NULL,
  `batch` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tripID`),
  KEY `fk_TRIPS_VEHICLES_MV1_idx` (`plateNumber`),
  KEY `fk_TRIPS_DEPTSPERINSTITUTION1_idx` (`deptID`),
  CONSTRAINT `fk_TRIPS_DEPTSPERINSTITUTION1` FOREIGN KEY (`deptID`) REFERENCES `deptsperinstitution` (`deptID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_TRIPS_VEHICLES_MV1` FOREIGN KEY (`plateNumber`) REFERENCES `vehicles_mv` (`plateNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trips`
--

LOCK TABLES `trips` WRITE;
/*!40000 ALTER TABLE `trips` DISABLE KEYS */;
/*!40000 ALTER TABLE `trips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `userTypeID` int(6) NOT NULL,
  `accountName` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(90) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` varchar(60) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `institutionID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`username`),
  KEY `fk_USERS_USERTYPES_REF1_idx` (`userTypeID`),
  KEY `fk_instiID_idx` (`institutionID`),
  CONSTRAINT `fk_USERS_USERTYPES_REF1` FOREIGN KEY (`userTypeID`) REFERENCES `usertypes_ref` (`userTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_instiID` FOREIGN KEY (`institutionID`) REFERENCES `institutions` (`institutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'richard.parayno',1,'Richard Lance Parayno','richard.parayno@dlsu.edu.ph','$2y$10$4DaYOaLE.bD0.2V6OcXFpuGfdkjMWMAfI5HCYJ7A3Ftmqih/s/xVS','QpecTPelWdtQwF20awNvmDSETEIPOWFyFmUU89Hmmmx88Y4xRCjZm8KoQnId','Active',NULL,'2018-02-26 07:32:51',NULL),(2,'life',2,'DLSP LIFE','life@dlsu.edu.ph','$2y$10$XL1B/ik1.vnzXseqslR1ouTVqlv1vZLu4m/ev1i9UlMqMEvGigNzq','4gVPaPv64x7rsmlLhHGY8V7DxZXbWBZpNo1sbfYuJT6Aq9GdmJwIf82oyw41','Active',NULL,NULL,NULL),(5,'dlsu_champion',3,'DLSU Champion','dlsuc@dlsu.edu.ph','$2y$10$BG5yUpyJ3oTffWkunWxAcuCZ0d8sAbhFXn4U9wkXwsHzYx.Mo1.se','hD5CAIVvpM5728nAdqVTr0eLyiOqJKbD6eGcxeiSNZBevlPg8hEKTfTXH6su','Active','2018-02-15 02:12:26','2018-03-26 07:49:06',1),(6,'dlsu_dispatch',4,'DLSU Dispatch','dlsud@dlsu.edu.ph','$2y$10$64gHQhJYHV9L.zPJ6JlUoukcyryY.95fEvwcevR5NGlBEhM9S5vza','hA0Ig8fJAlhHd33fFLsWrhp3vSlxxIceE6EmqfC42UgwFtz96jLyP3saobpH','Active','2018-02-15 02:23:56','2018-03-26 07:50:14',1),(8,'dlsu_sao',5,'DLSU Social Action Office','dlsus@dlsu.edu.ph','$2y$10$bC48Z1CYSyNwBVinovdmFexh0.R83wInmF8UVWX/9ggU6bbSGIYnW','q74ELvlIoMsCYihPKPeADy2XfutXLsiadG4RBqyGDUGxWlQqIsdW1TZxi3YS','Active','2018-02-20 04:46:26','2018-03-26 07:53:06',1),(9,'gh_sao',5,'LSGH Social Action Office','ghsao@lgsh.edu.ph','$2y$10$UBo/dPdxFOu0Anb0zZRLO.gVs0BvEUtUK.MJ4a0HhbnlkIi7.YqPS',NULL,'Active','2018-02-26 07:20:25','2018-03-26 07:55:37',2),(10,'gh_dispatch',4,'LSGH Dispatch','ghd@lsgh.edu.ph','$2y$10$1wkIJO6ngB.zOzOQNnsvcu8GI4oMrJ/FTez3EMUXV9IjpL1Z49JjS',NULL,'Active','2018-03-26 07:55:04','2018-03-26 07:55:04',2),(11,'gh_champion',3,'LSGH Champion','ghc@lsgh.edu.ph','$2y$10$UrzIPRDUOL8axOVc97plxe3DytN.ETz0orfsgRmIpcadi46wVR3j6',NULL,'Active','2018-03-26 07:56:22','2018-03-26 07:56:22',2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertypes_ref`
--

DROP TABLE IF EXISTS `usertypes_ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertypes_ref` (
  `userTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `userTypeName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertypes_ref`
--

LOCK TABLES `usertypes_ref` WRITE;
/*!40000 ALTER TABLE `usertypes_ref` DISABLE KEYS */;
INSERT INTO `usertypes_ref` VALUES (1,'System Admin'),(2,'LIFE-DLSP'),(3,'Champion'),(4,'Dispatching Office'),(5,'Social Action Office'),(6,'Special User');
/*!40000 ALTER TABLE `usertypes_ref` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles_mv`
--

DROP TABLE IF EXISTS `vehicles_mv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles_mv` (
  `plateNumber` varchar(7) NOT NULL,
  `institutionID` int(6) NOT NULL,
  `carTypeID` int(6) NOT NULL,
  `carBrandID` int(6) NOT NULL,
  `fuelTypeID` int(6) NOT NULL,
  `modelName` varchar(45) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  PRIMARY KEY (`plateNumber`),
  KEY `fk_VEHICLES_MV_FUELTYPE_REF1_idx` (`fuelTypeID`),
  KEY `fk_VEHICLES_MV_CARTYPE_REF1_idx` (`carTypeID`),
  KEY `fk_VEHICLES_MV_CARBRAND_REF1_idx` (`carBrandID`),
  KEY `fk_VEHICLES_MV_INSTITUTIONS1_idx` (`institutionID`),
  CONSTRAINT `fk_VEHICLES_MV_CARBRAND_REF1` FOREIGN KEY (`carBrandID`) REFERENCES `carbrand_ref` (`carBrandID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_VEHICLES_MV_CARTYPE_REF1` FOREIGN KEY (`carTypeID`) REFERENCES `cartype_ref` (`carTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_VEHICLES_MV_FUELTYPE_REF1` FOREIGN KEY (`fuelTypeID`) REFERENCES `fueltype_ref` (`fuelTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_VEHICLES_MV_INSTITUTIONS1` FOREIGN KEY (`institutionID`) REFERENCES `institutions` (`institutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles_mv`
--

LOCK TABLES `vehicles_mv` WRITE;
/*!40000 ALTER TABLE `vehicles_mv` DISABLE KEYS */;
INSERT INTO `vehicles_mv` VALUES ('AAQ682',1,1,1,2,'Corolla',1),('ASQ274',2,2,2,2,'Bus',1),('ATQ485',2,3,1,1,'HI-Ace',1),('DT0288',1,1,5,2,'Accord',1),('NXI569',1,3,2,1,'L300 Versa Van',1),('PBO525',1,1,1,2,'Camry 2.4G',1),('PIK982',1,2,1,1,'FM657N CC 7.5L',1),('TNM935',2,3,1,1,'Grandia',1),('USQ254',1,3,1,1,'Hiace S Grandia',1),('USQ274',1,2,1,1,'Coaster 30 Seat',1),('UTQ465',1,3,1,1,'Hiace S Grandia',1),('UTQ485',1,3,1,1,'Coastser 30 Seat',1),('XEX949',1,3,3,1,'Passenger',1),('YEY949',1,1,6,1,'Starex',1),('YY5242',1,3,1,1,'Hiace GL Grandia',1),('ZNM935',1,1,5,2,'Civic',1),('ZPZ543',1,1,1,1,'Camry 2.0',1);
/*!40000 ALTER TABLE `vehicles_mv` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-10 15:36:04
