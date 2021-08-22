/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.14-MariaDB : Database - ecis
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ecis` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `ecis`;

/*Table structure for table `appointments` */

DROP TABLE IF EXISTS `appointments`;

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recordID` int(11) DEFAULT NULL,
  `appointmentDate` date DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `deletedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recordId` (`recordID`),
  KEY `appointments_ibfk_2` (`createdBy`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`recordID`) REFERENCES `records` (`id`),
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`createdBy`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `appointments` */

/*Table structure for table `banks` */

DROP TABLE IF EXISTS `banks`;

CREATE TABLE `banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bankcode` varchar(10) DEFAULT NULL,
  `bankDescription` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `banks` */

insert  into `banks`(`id`,`bankcode`,`bankDescription`) values (1,'LBP','Landbank of the Philippines'),(2,'UBP','Union bank of the Philippines');

/*Table structure for table `designation` */

DROP TABLE IF EXISTS `designation`;

CREATE TABLE `designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `designation` */

insert  into `designation`(`id`,`code`,`description`) values (1,'MEMBER','MEMBER'),(2,'LIAISON','LIAISON OFFICER'),(3,'AAO','AGENCY AUTHORIZE OFFICER'),(4,'HO','HOME OFFICE'),(5,'OTHER BO','OTHER BRANCH');

/*Table structure for table `ecardstatus` */

DROP TABLE IF EXISTS `ecardstatus`;

CREATE TABLE `ecardstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `ecardstatus` */

insert  into `ecardstatus`(`id`,`description`) values (1,'Released'),(2,'Pending');

/*Table structure for table `ecardtypes` */

DROP TABLE IF EXISTS `ecardtypes`;

CREATE TABLE `ecardtypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `ecardtypes` */

insert  into `ecardtypes`(`id`,`code`,`description`) values (1,'EMVEPLUS','EMV ECARD PLUS'),(2,'EMVTEMP','EMV TEMPORARY'),(3,'EMVUMID','EMV UMID');

/*Table structure for table `gsisemployees` */

DROP TABLE IF EXISTS `gsisemployees`;

CREATE TABLE `gsisemployees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `gsisemployees` */

insert  into `gsisemployees`(`id`,`fullName`) values (1,'CASTELO, LEILANI MARIANA G'),(2,'DULDULAO, ELOISA '),(3,'DULDULAO, JESSIE'),(4,'PLATA, ARNEL S'),(5,'ALEJANDRO, JESUS JR A'),(6,'LIME, JOEDERSON L'),(7,'IBARRA, DARWIN'),(8,'SANTOS, ROSARIO'),(9,'LAGGUI, CELSO JR G');

/*Table structure for table `levels_of_importance` */

DROP TABLE IF EXISTS `levels_of_importance`;

CREATE TABLE `levels_of_importance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `important_label` varchar(10) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `levels_of_importance` */

insert  into `levels_of_importance`(`id`,`important_label`,`color`) values (1,'Urgent','danger'),(2,'Normal','primary');

/*Table structure for table `membertypes` */

DROP TABLE IF EXISTS `membertypes`;

CREATE TABLE `membertypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `membertypes` */

insert  into `membertypes`(`id`,`description`) values (1,'ACTIVE'),(2,'PENSIONER');

/*Table structure for table `queries` */

DROP TABLE IF EXISTS `queries`;

CREATE TABLE `queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastName` varchar(15) DEFAULT NULL,
  `firstName` varchar(30) DEFAULT NULL,
  `middleName` varchar(15) DEFAULT NULL,
  `agency` varchar(50) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `requestedBy` int(11) DEFAULT NULL,
  `levelOfImportancy` int(11) DEFAULT NULL,
  `isDone` tinyint(1) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `accomplishedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `requestedBy` (`requestedBy`),
  KEY `levelOfImportancy` (`levelOfImportancy`),
  CONSTRAINT `queries_ibfk_1` FOREIGN KEY (`requestedBy`) REFERENCES `gsisemployees` (`id`),
  CONSTRAINT `queries_ibfk_2` FOREIGN KEY (`levelOfImportancy`) REFERENCES `levels_of_importance` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `queries` */

/*Table structure for table `recordaccessibility` */

DROP TABLE IF EXISTS `recordaccessibility`;

CREATE TABLE `recordaccessibility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberType` int(11) DEFAULT NULL,
  `usertype` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`),
  KEY `recordaccessibility_ibfk_1` (`memberType`),
  CONSTRAINT `recordaccessibility_ibfk_1` FOREIGN KEY (`memberType`) REFERENCES `membertypes` (`id`),
  CONSTRAINT `recordaccessibility_ibfk_2` FOREIGN KEY (`usertype`) REFERENCES `usertype` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `recordaccessibility` */

insert  into `recordaccessibility`(`id`,`memberType`,`usertype`,`status`) values (1,1,1,0),(2,2,1,0),(3,1,2,0),(4,2,2,0),(5,1,3,1),(6,2,3,1);

/*Table structure for table `records` */

DROP TABLE IF EXISTS `records`;

CREATE TABLE `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gsisIDNO` varchar(11) DEFAULT NULL,
  `bpNo` varchar(11) DEFAULT NULL,
  `lastName` varchar(20) DEFAULT NULL,
  `middleName` varchar(20) DEFAULT NULL,
  `firstName` varchar(20) DEFAULT NULL,
  `contactNumber` varchar(11) DEFAULT NULL,
  `agency` varchar(255) DEFAULT NULL,
  `memberType` int(11) DEFAULT NULL,
  `eCardType` int(11) DEFAULT NULL,
  `bank` int(11) DEFAULT NULL,
  `dateRecieved` date DEFAULT NULL,
  `eCardStatus` int(11) DEFAULT NULL,
  `releaseBy` int(11) DEFAULT NULL,
  `releaseTo` int(11) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `soft_delete` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `isNotified` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `records_ibfk_1` (`memberType`),
  KEY `records_ibfk_2` (`bank`),
  KEY `records_ibfk_3` (`eCardType`),
  KEY `releaseTo` (`releaseTo`),
  KEY `eCardStatus` (`eCardStatus`),
  KEY `releaseBy` (`releaseBy`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `records_ibfk_1` FOREIGN KEY (`memberType`) REFERENCES `membertypes` (`id`),
  CONSTRAINT `records_ibfk_2` FOREIGN KEY (`bank`) REFERENCES `banks` (`id`),
  CONSTRAINT `records_ibfk_3` FOREIGN KEY (`eCardType`) REFERENCES `ecardtypes` (`id`),
  CONSTRAINT `records_ibfk_4` FOREIGN KEY (`releaseTo`) REFERENCES `designation` (`id`),
  CONSTRAINT `records_ibfk_5` FOREIGN KEY (`eCardStatus`) REFERENCES `ecardstatus` (`id`),
  CONSTRAINT `records_ibfk_6` FOREIGN KEY (`releaseBy`) REFERENCES `users` (`id`),
  CONSTRAINT `records_ibfk_7` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `records` */

/*Table structure for table `uploadedfiles` */

DROP TABLE IF EXISTS `uploadedfiles`;

CREATE TABLE `uploadedfiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileName` varchar(100) DEFAULT NULL,
  `uploadedBy` int(11) DEFAULT NULL,
  `dateUpload` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploadedBy` (`uploadedBy`),
  CONSTRAINT `uploadedfiles_ibfk_1` FOREIGN KEY (`uploadedBy`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `uploadedfiles` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(155) DEFAULT NULL,
  `userType` int(11) DEFAULT NULL,
  `userName` varchar(30) DEFAULT NULL,
  `userPassword` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userType` (`userType`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`userType`) REFERENCES `usertype` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`fullName`,`userType`,`userName`,`userPassword`,`status`) values (1,'LAGGUI JR, CELSO G.',3,'cglagguijr','25d55ad283aa400af464c76d713c07ad',1),(3,'ALEJANDRO, JESUS JR. E',1,'jealejandrojr','25d55ad283aa400af464c76d713c07ad',1),(13,'PUBLICO, EDRALIN JR G.',3,'egpublicojr','dff6ebbfbfd4eba7c42108b1c1673029',1),(14,'IBARRA, DARWIN L.',1,'dlibarra','25d55ad283aa400af464c76d713c07ad',1),(15,'DULDULAO, MA. ELOISA A',2,'meaduldulao','25d55ad283aa400af464c76d713c07ad',1),(16,'DULDULAO, JESSIE R',2,'jrduldulao','25d55ad283aa400af464c76d713c07ad',0),(17,'FERRER, JUAN CARLOS',3,'jc','25d55ad283aa400af464c76d713c07ad',1),(18,'PLATA, ARNEL S',1,'asplata','25d55ad283aa400af464c76d713c07ad',1),(19,'Nen',3,'glimmertear02','13e30faf20547b40b601e7ca80249a53',1),(20,'OCAMPO, CHRISTINE JOY A',1,'cjaocampo','02629166d8351aec030848b4829c3006',1),(21,'JUAN, SHAINA BRITNEY',3,'shaina','25d55ad283aa400af464c76d713c07ad',1);

/*Table structure for table `usertype` */

DROP TABLE IF EXISTS `usertype`;

CREATE TABLE `usertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `usertype` */

insert  into `usertype`(`id`,`description`) values (1,'LESU'),(2,'OBM'),(3,'SuperUser');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
