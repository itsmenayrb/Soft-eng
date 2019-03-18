/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 10.1.37-MariaDB : Database - salitraniisystem
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`salitraniisystem` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `salitraniisystem`;

/*Table structure for table `appointment_tbl` */

DROP TABLE IF EXISTS `appointment_tbl`;

CREATE TABLE `appointment_tbl` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `appointment_username` varchar(255) NOT NULL,
  `appointment_fullname` varchar(255) NOT NULL,
  `appointment_email` varchar(255) NOT NULL,
  `appointment_contactnumber` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_purpose` varchar(255) NOT NULL,
  `appointment_daterequested` datetime NOT NULL,
  `appointment_status` varchar(255) NOT NULL,
  `appointment_decision` varchar(255) DEFAULT NULL,
  `appointment_dateaccomplished` datetime DEFAULT NULL,
  PRIMARY KEY (`appointment_id`,`appointment_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `appointment_tbl` */

/*Table structure for table `residents_tbl` */

DROP TABLE IF EXISTS `residents_tbl`;

CREATE TABLE `residents_tbl` (
  `residents_id` int(11) NOT NULL AUTO_INCREMENT,
  `residents_prefix` varchar(255) NOT NULL,
  `residents_first_name` varchar(255) NOT NULL,
  `residents_middle_name` varchar(255) NOT NULL,
  `residents_last_name` varchar(255) NOT NULL,
  `residents_suffix` varchar(255) NOT NULL,
  `residents_age` int(11) NOT NULL,
  `residents_gender` varchar(255) NOT NULL,
  `residents_birthday` date NOT NULL,
  `residents_birthplace` varchar(255) NOT NULL,
  `residents_home_address` varchar(255) NOT NULL,
  `residents_first_contact_number` int(11) DEFAULT NULL,
  `residents_second_contact_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`residents_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `residents_tbl` */

insert  into `residents_tbl`(`residents_id`,`residents_prefix`,`residents_first_name`,`residents_middle_name`,`residents_last_name`,`residents_suffix`,`residents_age`,`residents_gender`,`residents_birthday`,`residents_birthplace`,`residents_home_address`,`residents_first_contact_number`,`residents_second_contact_number`) values 
(1,'Mr','Bryan','Villanueva','Balaga','',12,'Male','0000-00-00','asdasd','asd asd s',NULL,NULL);

/*Table structure for table `useraccount_tbl` */

DROP TABLE IF EXISTS `useraccount_tbl`;

CREATE TABLE `useraccount_tbl` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_mobile_number` varchar(15) NOT NULL,
  `user_status` varchar(255) NOT NULL,
  `user_mobile_number_token` varchar(255) DEFAULT NULL,
  `user_email_token` varchar(255) DEFAULT NULL,
  `user_date_created` datetime NOT NULL,
  `user_date_deactivated` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `useraccount_tbl` */

insert  into `useraccount_tbl`(`user_id`,`user_name`,`user_email`,`user_password`,`user_mobile_number`,`user_status`,`user_mobile_number_token`,`user_email_token`,`user_date_created`,`user_date_deactivated`) values 
(1,'bryan','bryan.balaga@gmail.com','$2y$10$JsPxa/AUckrTL//gqKLB9OjZalVcQwibE5KD59p2ZXg1aPKvDBtOm','+639070680221','Verified',NULL,'ruq4k','2019-03-05 02:38:02',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
