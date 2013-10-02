/*
SQLyog Trial v11.25 (64 bit)
MySQL - 5.5.23 : Database - directorzone_zf2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`directorzone_zf2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `directorzone_zf2`;

/*Table structure for table `feedback` */

DROP TABLE IF EXISTS `feedback`;

CREATE TABLE `feedback` (
  `feedbackid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `message` text,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `replyto` int(11) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '',
  `feedbackcode` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`feedbackid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `feedback` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `isocountry_fromregip` varchar(5) DEFAULT NULL,
  `httpreferer` varchar(250) DEFAULT NULL,
  `emailverifycode` varchar(32) DEFAULT NULL,
  `passwordresetcode` varchar(32) DEFAULT NULL,
  `regipaddress` varchar(32) DEFAULT NULL,
  `locale` char(5) NOT NULL DEFAULT 'en_US',
  `activated` char(1) DEFAULT 'N',
  `title` varchar(20) DEFAULT NULL,
  `forenames` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `nationality` int(11) DEFAULT NULL,
  `profileimage` varchar(100) DEFAULT NULL,
  `pseudonym` varchar(20) DEFAULT NULL,
  `alternativeemail` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `address` int(11) DEFAULT NULL,
  `talentpoolsummary` text,
  `experiencearea` text,
  `skills` text,
  `personalinterests` text,
  `whoswhosummary` text,
  `speakeravailability` int(11) DEFAULT NULL,
  `marketgroup` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `emailidx` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`userid`,`email`,`name`,`password`,`createddate`,`isocountry_fromregip`,`httpreferer`,`emailverifycode`,`passwordresetcode`,`regipaddress`,`locale`,`activated`,`title`,`forenames`,`surname`,`dob`,`suffix`,`gender`,`nationality`,`profileimage`,`pseudonym`,`alternativeemail`,`telephone`,`mobile`,`fax`,`address`,`talentpoolsummary`,`experiencearea`,`skills`,`personalinterests`,`whoswhosummary`,`speakeravailability`,`marketgroup`) values (1,'chris@netsensia.com','Chris','$2y$14$3cS1O1FNywjhCVXGX3L1UeLKEbJzTAicJbV4rFNLJNI7olBapbAvy','2013-10-02 20:13:05',NULL,NULL,'Z5YjijVG838KTQc5ir8bqTaDrguHJzgs',NULL,'127.0.0.1','en_US','Y','Example Value',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
