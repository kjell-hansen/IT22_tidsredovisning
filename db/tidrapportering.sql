/*
SQLyog Community
MySQL - 8.0.28 : Database - tidrapportering
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `aktiviteter` */

DROP TABLE IF EXISTS `aktiviteter`;

CREATE TABLE `aktiviteter` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Namn` varchar(20) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UIX_Namn` (`Namn`)
) ENGINE=InnoDB AUTO_INCREMENT=584 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_swedish_ci;

/*Data for the table `aktiviteter` */

insert  into `aktiviteter`(`ID`,`Namn`) values 
(3,'Chillat'),
(2,'Halvsovit till HBO'),
(4,'Hoppsan'),
(1,'Slötittat på Netflix');

/*Table structure for table `uppgifter` */

DROP TABLE IF EXISTS `uppgifter`;

CREATE TABLE `uppgifter` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Datum` date NOT NULL,
  `Tid` time NOT NULL,
  `Beskrivning` varchar(100) COLLATE utf8_swedish_ci DEFAULT NULL,
  `AktivitetID` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `AktivitetID` (`AktivitetID`),
  CONSTRAINT `uppgifter_ibfk_1` FOREIGN KEY (`AktivitetID`) REFERENCES `aktiviteter` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_swedish_ci;

/*Data for the table `uppgifter` */

insert  into `uppgifter`(`ID`,`Datum`,`Tid`,`Beskrivning`,`AktivitetID`) values 
(1,'2024-01-02','01:00:00','Här skriver jag en lång text',1),
(2,'2023-12-31','05:00:00','Firat nyår',2),
(4,'2024-01-11','05:30:00','Gjort något viktigt',3),
(5,'2024-01-16','01:45:00','Hissat flagga',1),
(6,'2024-01-02','01:20:00','Gissat fel',1),
(8,'2024-01-05','01:30:00','',1),
(9,'2024-01-05','01:30:00','',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
