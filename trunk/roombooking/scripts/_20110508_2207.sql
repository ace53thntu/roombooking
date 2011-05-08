-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.0.77-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema booking
--

CREATE DATABASE IF NOT EXISTS booking;
USE booking;

--
-- Definition of table `booking`.`booking`
--

DROP TABLE IF EXISTS `booking`.`booking`;
CREATE TABLE  `booking`.`booking` (
  `id` int(11) NOT NULL,
  `from_hotel` int(11) NOT NULL,
  `to_hotel` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `action_user` int(11) default NULL,
  `room_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `number_of_person` smallint(6) NOT NULL,
  `status` enum('pending','accepted') NOT NULL default 'pending',
  `rate_id` int(11) NOT NULL,
  `calendar_id` int(11) default NULL,
  `discount_id` int(11) default NULL,
  `arrival_time` datetime NOT NULL,
  `created` datetime NOT NULL,
  KEY `booking_fk_constraint1` (`from_hotel`),
  KEY `booking_fk_constraint2` (`to_hotel`),
  KEY `booking_fk_constraint3` (`from_user`),
  KEY `booking_fk_constraint4` (`action_user`),
  KEY `booking_fk_constraint5` (`room_id`),
  KEY `booking_fk_constraint6` (`customer_id`),
  KEY `booking_fk_constraint8` (`rate_id`),
  KEY `booking_fk_constraint9` (`calendar_id`),
  KEY `booking_fk_constraint10` (`discount_id`),
  CONSTRAINT `booking_fk_constraint1` FOREIGN KEY (`from_hotel`) REFERENCES `hotel` (`id`),
  CONSTRAINT `booking_fk_constraint10` FOREIGN KEY (`discount_id`) REFERENCES `discount` (`id`),
  CONSTRAINT `booking_fk_constraint2` FOREIGN KEY (`to_hotel`) REFERENCES `hotel` (`id`),
  CONSTRAINT `booking_fk_constraint3` FOREIGN KEY (`from_user`) REFERENCES `user` (`id`),
  CONSTRAINT `booking_fk_constraint4` FOREIGN KEY (`action_user`) REFERENCES `user` (`id`),
  CONSTRAINT `booking_fk_constraint5` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
  CONSTRAINT `booking_fk_constraint6` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `booking_fk_constraint8` FOREIGN KEY (`rate_id`) REFERENCES `rate` (`id`),
  CONSTRAINT `booking_fk_constraint9` FOREIGN KEY (`calendar_id`) REFERENCES `calendar` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`booking`
--

/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
LOCK TABLES `booking` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;


--
-- Definition of table `booking`.`calendar`
--

DROP TABLE IF EXISTS `booking`.`calendar`;
CREATE TABLE  `booking`.`calendar` (
  `id` int(11) NOT NULL auto_increment,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `rate_id` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `calendar_fk_constraint` (`rate_id`),
  CONSTRAINT `calendar_fk_constraint` FOREIGN KEY (`rate_id`) REFERENCES `rate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='hotel room calendar price';

--
-- Dumping data for table `booking`.`calendar`
--

/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
LOCK TABLES `calendar` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;


--
-- Definition of table `booking`.`customer`
--

DROP TABLE IF EXISTS `booking`.`customer`;
CREATE TABLE  `booking`.`customer` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `social_security_number` varchar(12) NOT NULL,
  `phone` varchar(20) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `customer_unique` (`social_security_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`customer`
--

/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
LOCK TABLES `customer` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;


--
-- Definition of table `booking`.`discount`
--

DROP TABLE IF EXISTS `booking`.`discount`;
CREATE TABLE  `booking`.`discount` (
  `id` int(11) NOT NULL auto_increment,
  `room_id` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `discount_fk_constraint` (`room_id`),
  CONSTRAINT `discount_fk_constraint` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='extra discount based on rate and calendar';

--
-- Dumping data for table `booking`.`discount`
--

/*!40000 ALTER TABLE `discount` DISABLE KEYS */;
LOCK TABLES `discount` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `discount` ENABLE KEYS */;


--
-- Definition of table `booking`.`hotel`
--

DROP TABLE IF EXISTS `booking`.`hotel`;
CREATE TABLE  `booking`.`hotel` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) character set latin1 NOT NULL,
  `description` mediumtext character set latin1 NOT NULL,
  `rating` varchar(100) character set latin1 NOT NULL,
  `address` varchar(100) character set latin1 NOT NULL,
  `post_address` varchar(100) character set latin1 NOT NULL,
  `post_code` varchar(20) character set latin1 NOT NULL,
  `city` int(11) NOT NULL,
  `city_part` enum('north','center','south','east','west') character set latin1 NOT NULL default 'center',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`hotel`
--

/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
LOCK TABLES `hotel` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `hotel` ENABLE KEYS */;


--
-- Definition of table `booking`.`hotel_user`
--

DROP TABLE IF EXISTS `booking`.`hotel_user`;
CREATE TABLE  `booking`.`hotel_user` (
  `id` int(11) NOT NULL auto_increment,
  `hotel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `hotel_user_unique` (`hotel_id`,`user_id`,`permission_id`),
  KEY `hotel_user_fk_constraint2` (`user_id`),
  KEY `hotel_user_fk_constraint3` (`permission_id`),
  CONSTRAINT `hotel_user_fk_constraint1` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`),
  CONSTRAINT `hotel_user_fk_constraint2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `hotel_user_fk_constraint3` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`hotel_user`
--

/*!40000 ALTER TABLE `hotel_user` DISABLE KEYS */;
LOCK TABLES `hotel_user` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `hotel_user` ENABLE KEYS */;


--
-- Definition of table `booking`.`permission`
--

DROP TABLE IF EXISTS `booking`.`permission`;
CREATE TABLE  `booking`.`permission` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `permission_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`permission`
--

/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
LOCK TABLES `permission` WRITE;
INSERT INTO `booking`.`permission` VALUES  (1,'administrator');
UNLOCK TABLES;
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;


--
-- Definition of table `booking`.`rate`
--

DROP TABLE IF EXISTS `booking`.`rate`;
CREATE TABLE  `booking`.`rate` (
  `id` int(11) NOT NULL auto_increment,
  `room_id` int(11) NOT NULL,
  `person_number` smallint(6) default NULL COMMENT 'can be different price, for same room, but different number of persons live in',
  `rate_name` int(11) NOT NULL,
  `price` double NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `rate_unique` (`room_id`,`person_number`,`rate_name`),
  KEY `rate_fk_constraint` (`rate_name`),
  CONSTRAINT `rate_fk_constraint` FOREIGN KEY (`rate_name`) REFERENCES `rate_name` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`rate`
--

/*!40000 ALTER TABLE `rate` DISABLE KEYS */;
LOCK TABLES `rate` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `rate` ENABLE KEYS */;


--
-- Definition of table `booking`.`rate_name`
--

DROP TABLE IF EXISTS `booking`.`rate_name`;
CREATE TABLE  `booking`.`rate_name` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) character set latin1 NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `rate_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`rate_name`
--

/*!40000 ALTER TABLE `rate_name` DISABLE KEYS */;
LOCK TABLES `rate_name` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `rate_name` ENABLE KEYS */;


--
-- Definition of table `booking`.`room`
--

DROP TABLE IF EXISTS `booking`.`room`;
CREATE TABLE  `booking`.`room` (
  `id` int(11) NOT NULL auto_increment,
  `type_id` int(11) NOT NULL,
  `total` smallint(6) NOT NULL,
  `max_person` smallint(6) NOT NULL,
  `description` text,
  `available` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `room_type_fk_constraint` (`type_id`),
  CONSTRAINT `room_type_fk_constraint` FOREIGN KEY (`type_id`) REFERENCES `room_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`room`
--

/*!40000 ALTER TABLE `room` DISABLE KEYS */;
LOCK TABLES `room` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `room` ENABLE KEYS */;


--
-- Definition of table `booking`.`room_type`
--

DROP TABLE IF EXISTS `booking`.`room_type`;
CREATE TABLE  `booking`.`room_type` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `room_type_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`room_type`
--

/*!40000 ALTER TABLE `room_type` DISABLE KEYS */;
LOCK TABLES `room_type` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `room_type` ENABLE KEYS */;


--
-- Definition of table `booking`.`user`
--

DROP TABLE IF EXISTS `booking`.`user`;
CREATE TABLE  `booking`.`user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `title` varchar(50) default NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_login_unique` (`username`,`password`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`user`
--

/*!40000 ALTER TABLE `user` DISABLE KEYS */;
LOCK TABLES `user` WRITE;
INSERT INTO `booking`.`user` VALUES  (1,'lhj1982','670b14728ad9902aecba32e22fa4f6bd','James','Lee','','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
