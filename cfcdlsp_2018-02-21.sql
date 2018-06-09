# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.19-0ubuntu0.16.04.1)
# Database: cfcdlsp
# Generation Time: 2018-02-21 13:37:24 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table carbrand_ref
# ------------------------------------------------------------

DROP TABLE IF EXISTS `carbrand_ref`;

CREATE TABLE `carbrand_ref` (
  `carBrandID` int(6) NOT NULL AUTO_INCREMENT,
  `carBrandName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`carBrandID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `carbrand_ref` WRITE;
/*!40000 ALTER TABLE `carbrand_ref` DISABLE KEYS */;

INSERT INTO `carbrand_ref` (`carBrandID`, `carBrandName`)
VALUES
	(1,'Toyota'),
	(2,'Mitsubishi'),
	(3,'Subaru'),
	(4,'Ford'),
	(5,'Honda');

/*!40000 ALTER TABLE `carbrand_ref` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cartype_ref
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cartype_ref`;

CREATE TABLE `cartype_ref` (
  `carTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `carTypeName` varchar(45) DEFAULT NULL,
  `mpg` decimal(8,2) NOT NULL,
  PRIMARY KEY (`carTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `cartype_ref` WRITE;
/*!40000 ALTER TABLE `cartype_ref` DISABLE KEYS */;

INSERT INTO `cartype_ref` (`carTypeID`, `carTypeName`, `mpg`)
VALUES
	(1,'Car',23.41),
	(2,'Bus',6.30),
	(3,'Van',21.64);

/*!40000 ALTER TABLE `cartype_ref` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table deptsperinstitution
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deptsperinstitution`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `deptsperinstitution` WRITE;
/*!40000 ALTER TABLE `deptsperinstitution` DISABLE KEYS */;

INSERT INTO `deptsperinstitution` (`deptID`, `institutionID`, `deptName`, `motherDeptID`)
VALUES
	(1,1,'Office of Sports Development',NULL),
	(2,1,'Brothers Community',NULL),
	(3,1,'Procurement Office',NULL),
	(4,1,'College of Computer Studies',NULL),
	(5,1,'College of Liberal Arts',NULL),
	(6,1,'College of Science',NULL),
	(7,1,'Ramon V. del Rosario College of Business',NULL),
	(8,1,'Br. Andrew Gonzales College of Education',NULL),
	(9,1,'School of Economics',NULL),
	(10,1,'Gokongwei College of Engineering',NULL),
	(11,1,'Information Technology',4),
	(12,1,'Computer Technology',4),
	(13,1,'Software Technology',4),
	(14,1,'Accounting',7),
	(15,1,'Civil Engineering',10),
	(16,1,'Central Administration Office',NULL),
	(17,1,'Integrated Office of the President and Chancellor',16),
	(18,1,'Office of the Vice Chancellor for Academics',16),
	(19,1,'Office of the President and Chancellor',17),
	(20,1,'Office of the Vice President for Finance',17),
	(21,1,'Office for the Dean of Student Affairs',NULL),
	(22,1,'Cultural Arts Office',21),
	(23,1,'Student Discipline Formation Office',21),
	(24,1,'Student Media Office',21),
	(25,1,'College of Law',NULL);

/*!40000 ALTER TABLE `deptsperinstitution` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fueltype_ref
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fueltype_ref`;

CREATE TABLE `fueltype_ref` (
  `fuelTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `fuelTypeName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fuelTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `fueltype_ref` WRITE;
/*!40000 ALTER TABLE `fueltype_ref` DISABLE KEYS */;

INSERT INTO `fueltype_ref` (`fuelTypeID`, `fuelTypeName`)
VALUES
	(1,'Diesel'),
	(2,'Gasoline');

/*!40000 ALTER TABLE `fueltype_ref` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table institutionbatchplant
# ------------------------------------------------------------

DROP TABLE IF EXISTS `institutionbatchplant`;

CREATE TABLE `institutionbatchplant` (
  `batchPlantID` int(6) NOT NULL AUTO_INCREMENT,
  `institutionID` int(6) NOT NULL,
  `numOfPlantedTrees` int(7) DEFAULT NULL,
  `datePlanted` date DEFAULT NULL,
  PRIMARY KEY (`batchPlantID`),
  KEY `fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1_idx` (`institutionID`),
  CONSTRAINT `fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1` FOREIGN KEY (`institutionID`) REFERENCES `institutions` (`institutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table institutions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `institutions`;

CREATE TABLE `institutions` (
  `institutionID` int(11) NOT NULL AUTO_INCREMENT,
  `institutionName` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schoolTypeID` int(11) NOT NULL,
  `location` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`institutionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `institutions` WRITE;
/*!40000 ALTER TABLE `institutions` DISABLE KEYS */;

INSERT INTO `institutions` (`institutionID`, `institutionName`, `schoolTypeID`, `location`)
VALUES
	(1,'De La Salle University - Manila',1,'Taft Avenue');

/*!40000 ALTER TABLE `institutions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(37,'2018_02_01_105716_create_carbrand_ref_table',0),
	(38,'2018_02_01_105716_create_cartype_ref_table',0),
	(39,'2018_02_01_105716_create_deptsperinstitution_table',0),
	(40,'2018_02_01_105716_create_fueltype_ref_table',0),
	(41,'2018_02_01_105716_create_institutionbatchplant_table',0),
	(42,'2018_02_01_105716_create_institutions_table',0),
	(43,'2018_02_01_105716_create_monthlyemissions_table',0),
	(44,'2018_02_01_105716_create_monthlyemissionsperschool_table',0),
	(45,'2018_02_01_105716_create_schooltype_ref_table',0),
	(46,'2018_02_01_105716_create_trips_table',0),
	(47,'2018_02_01_105716_create_users_table',0),
	(48,'2018_02_01_105716_create_usertypes_ref_table',0),
	(49,'2018_02_01_105716_create_vehicles_mv_table',0),
	(50,'2018_02_01_105717_add_foreign_keys_to_deptsperinstitution_table',0),
	(51,'2018_02_01_105717_add_foreign_keys_to_institutionbatchplant_table',0),
	(52,'2018_02_01_105717_add_foreign_keys_to_monthlyemissionsperschool_table',0),
	(53,'2018_02_01_105717_add_foreign_keys_to_trips_table',0),
	(54,'2018_02_01_105717_add_foreign_keys_to_users_table',0),
	(55,'2018_02_01_105717_add_foreign_keys_to_vehicles_mv_table',0),
	(56,'2018_02_01_105855_change-dept-name',1),
	(57,'2018_02_06_095558_update_user_password_length',2),
	(58,'2018_02_06_100825_add_remember_token_to_users',3),
	(59,'2018_02_06_102443_add_status_to_user',4),
	(60,'2018_02_07_115151_change_remember_token_to_nullable',5),
	(61,'2018_02_15_095545_add_created_at_and_updated_at_in_user',6),
	(62,'2018_02_15_105902_change_user_i_d_to_id',7),
	(63,'2018_02_20_152836_add_mpg_to_cartype_ref',8);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table monthlyemissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `monthlyemissions`;

CREATE TABLE `monthlyemissions` (
  `MONTHYEAR` date NOT NULL,
  `emission` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`MONTHYEAR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table monthlyemissionsperschool
# ------------------------------------------------------------

DROP TABLE IF EXISTS `monthlyemissionsperschool`;

CREATE TABLE `monthlyemissionsperschool` (
  `monthYear` date NOT NULL,
  `institutionID` int(6) NOT NULL,
  `emission` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`monthYear`),
  KEY `fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1_idx` (`institutionID`),
  CONSTRAINT `fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1` FOREIGN KEY (`institutionID`) REFERENCES `institutions` (`institutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table schooltype_ref
# ------------------------------------------------------------

DROP TABLE IF EXISTS `schooltype_ref`;

CREATE TABLE `schooltype_ref` (
  `schoolTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `schoolTypeName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`schoolTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `schooltype_ref` WRITE;
/*!40000 ALTER TABLE `schooltype_ref` DISABLE KEYS */;

INSERT INTO `schooltype_ref` (`schoolTypeID`, `schoolTypeName`)
VALUES
	(1,'University');

/*!40000 ALTER TABLE `schooltype_ref` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table trips
# ------------------------------------------------------------

DROP TABLE IF EXISTS `trips`;

CREATE TABLE `trips` (
  `tripID` int(6) NOT NULL AUTO_INCREMENT,
  `deptID` int(6) NOT NULL,
  `plateNumber` varchar(7) NOT NULL,
  `kilometerReading` int(6) DEFAULT NULL,
  `remarks` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tripID`),
  KEY `fk_TRIPS_VEHICLES_MV1_idx` (`plateNumber`),
  KEY `fk_TRIPS_DEPTSPERINSTITUTION1_idx` (`deptID`),
  CONSTRAINT `fk_TRIPS_DEPTSPERINSTITUTION1` FOREIGN KEY (`deptID`) REFERENCES `deptsperinstitution` (`deptID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_TRIPS_VEHICLES_MV1` FOREIGN KEY (`plateNumber`) REFERENCES `vehicles_mv` (`plateNumber`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

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
  PRIMARY KEY (`id`,`username`),
  KEY `fk_USERS_USERTYPES_REF1_idx` (`userTypeID`),
  CONSTRAINT `fk_USERS_USERTYPES_REF1` FOREIGN KEY (`userTypeID`) REFERENCES `usertypes_ref` (`userTypeID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `userTypeID`, `accountName`, `email`, `password`, `remember_token`, `status`, `created_at`, `updated_at`)
VALUES
	(1,'richard',1,'richard','Swt3it@dlsu.edu.ph','$2y$10$axzuKsUb6DY8zOkCSUCM.edkjHBnheILcybybuKq7oWU15jinbniC','ho8oJB04LJUvub9Etk1nJolssSBNO1WOe0MOlVjWYXq44EW9iOEiOPJD1NHr','Active',NULL,NULL),
	(2,'life',2,'DLSP LIFE','life@dlsu.edu.ph','$2y$10$XL1B/ik1.vnzXseqslR1ouTVqlv1vZLu4m/ev1i9UlMqMEvGigNzq','4gVPaPv64x7rsmlLhHGY8V7DxZXbWBZpNo1sbfYuJT6Aq9GdmJwIf82oyw41','Active',NULL,NULL),
	(5,'kurt',3,'Kurt Ebol','kurt_ebol@dlsu.edu.ph','$2y$10$lb6Hc5O/gkIXpofsqHSb3.9qTfDqZJn0iFNqX4iEopkIEAY5W8Bg.','JpLStjK6sp7xZl9XayGT5Y67SLH2qhnrzlrfLo0NeOpZFaZ5mnHIGhaFrtlk','Active','2018-02-15 10:12:26','2018-02-15 10:12:26'),
	(6,'yuri',4,'Yuri Banawa','yuri_banawa@dlsu.edu.ph','$2y$10$4seIhvZgPQ/xW/Sv7UnM5OdteNTRu5rkZicN5w4CxOhcg4Ab/eYmu','hA0Ig8fJAlhHd33fFLsWrhp3vSlxxIceE6EmqfC42UgwFtz96jLyP3saobpH','Active','2018-02-15 10:23:56','2018-02-15 10:23:56'),
	(8,'alex',5,'Alex Espiritu','alex_espiritu@dlsu.edu.ph','$2y$10$7QYHB1shKK4aNAWSn1t4b.oo5f4b05PWN5lStTpMMegW9Ng2PEVe.','GG8pVseAwS7v9DWol59vz52w5mlFwF0litrHz6GoLGtnSJdjTiujHg3xqpVh','Active','2018-02-20 12:46:26','2018-02-20 12:46:26');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table usertypes_ref
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usertypes_ref`;

CREATE TABLE `usertypes_ref` (
  `userTypeID` int(6) NOT NULL AUTO_INCREMENT,
  `userTypeName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usertypes_ref` WRITE;
/*!40000 ALTER TABLE `usertypes_ref` DISABLE KEYS */;

INSERT INTO `usertypes_ref` (`userTypeID`, `userTypeName`)
VALUES
	(1,'System Admin'),
	(2,'LIFE-DLSP'),
	(3,'Champion'),
	(4,'Dispatching Office'),
	(5,'Social Action Office'),
	(6,'Special User');

/*!40000 ALTER TABLE `usertypes_ref` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vehicles_mv
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vehicles_mv`;

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

LOCK TABLES `vehicles_mv` WRITE;
/*!40000 ALTER TABLE `vehicles_mv` DISABLE KEYS */;

INSERT INTO `vehicles_mv` (`plateNumber`, `institutionID`, `carTypeID`, `carBrandID`, `fuelTypeID`, `modelName`, `active`)
VALUES
	('AAQ659',1,2,4,1,'County',1),
	('DT0288',1,1,5,2,'Accord',1),
	('NXI569',1,3,2,1,'L300 Versa Van',1),
	('PBO525',1,1,1,2,'Camry 2.4G',1),
	('PIK982',1,2,1,1,'FM657N CC 7.5L',1),
	('USQ254',1,3,1,1,'Hiace S Grandia',1),
	('USQ274',1,2,1,1,'Coaster 30 Seat',1),
	('UTQ465',1,3,1,1,'Hiace S Grandia',1),
	('XEX949',1,3,3,1,'Passenger',1),
	('ZNM935',1,1,5,2,'Civic',1),
	('ZPZ543',1,1,1,1,'Camry 2.0',1);

/*!40000 ALTER TABLE `vehicles_mv` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
