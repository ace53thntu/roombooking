CREATE DATABASE  IF NOT EXISTS `booking` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `booking`;
-- MySQL dump 10.13  Distrib 5.1.40, for Win32 (ia32)
--
-- Host: localhost    Database: booking
-- ------------------------------------------------------
-- Server version   5.1.36-community-log

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
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `social_security_number` varchar(12) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_unique` (`social_security_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='customer table saves customer infomation';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_unique` (`name`,`country_id`),
  KEY `city_fk_constraint` (`country_id`),
  CONSTRAINT `city_fk_constraint` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rate_name`
--

DROP TABLE IF EXISTS `rate_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(5) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rate_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `total` smallint(6) NOT NULL,
  `max_person` smallint(6) NOT NULL,
  `description` text,
  `available` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_unique` (`type_id`,`hotel_id`),
  KEY `room_type_fk_constraint` (`type_id`),
  KEY `room_hotel_fk_constraint` (`hotel_id`),
  CONSTRAINT `room_hotel_fk_constraint` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`),
  CONSTRAINT `room_type_fk_constraint` FOREIGN KEY (`type_id`) REFERENCES `room_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(4) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `country_unique` (`name`),
  UNIQUE KEY `code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `description` mediumtext CHARACTER SET latin1 NOT NULL,
  `rating` varchar(100) CHARACTER SET latin1 NOT NULL,
  `address` varchar(100) CHARACTER SET latin1 NOT NULL,
  `post_address` varchar(100) CHARACTER SET latin1 NOT NULL,
  `post_code` varchar(20) CHARACTER SET latin1 NOT NULL,
  `city` int(11) NOT NULL,
  `city_part` enum('north','center','south','east','west') CHARACTER SET latin1 NOT NULL DEFAULT 'center',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calendar_price`
--

DROP TABLE IF EXISTS `calendar_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calendar_price_unique` (`calendar_id`,`room_id`),
  KEY `calendar_price_fk_constraint1` (`calendar_id`),
  KEY `calendar_price_fk_constraint2` (`room_id`),
  CONSTRAINT `calendar_price_fk_constraint1` FOREIGN KEY (`calendar_id`) REFERENCES `calendar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `calendar_price_fk_constraint2` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='price list of calendar';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `discount` varchar(10) NOT NULL DEFAULT '0' COMMENT 'discount in percentage',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_fk_constraint1` (`room_id`),
  CONSTRAINT `discount_fk_constraint` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='extra discount based on rate and calendar. ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rate`
--

DROP TABLE IF EXISTS `rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `person_number` smallint(6) DEFAULT NULL COMMENT 'can be different price, for same room, but different number of persons live in',
  `rate_name` int(11) NOT NULL COMMENT 'reference to rate_name table',
  `price` double NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rate_unique` (`room_id`,`person_number`,`rate_name`),
  KEY `rate_fk_constratint1` (`rate_name`),
  CONSTRAINT `rate_fk_constratint1` FOREIGN KEY (`rate_name`) REFERENCES `rate_name` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='rate table define all price rate of hotel rooms, every room ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_login_unique` (`username`,`password`),
  UNIQUE KEY `user_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `name` varchar(20) NOT NULL COMMENT 'calendar name, for example, summer time, winter time, busy time and etc',
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calendar_unique` (`from`,`to`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='hotel room calendar definition.\nOne hotel will have several ';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room_type`
--

DROP TABLE IF EXISTS `room_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_type_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hotel_user`
--

DROP TABLE IF EXISTS `hotel_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hotel_user_unique` (`hotel_id`,`user_id`,`permission_id`),
  KEY `hotel_user_fk_constraint2` (`user_id`),
  KEY `hotel_user_fk_constraint3` (`permission_id`),
  CONSTRAINT `hotel_user_fk_constraint1` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`),
  CONSTRAINT `hotel_user_fk_constraint2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `hotel_user_fk_constraint3` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `from_hotel` int(11) NOT NULL COMMENT 'hotel which the booking comes from',
  `to_hotel` int(11) NOT NULL COMMENT 'hotel which the booking goes to',
  `from_user` int(11) NOT NULL COMMENT 'user that send request of this booking',
  `action_user` int(11) DEFAULT NULL COMMENT 'user who will take care of the booking in to_hotel part',
  `room_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `number_of_person` smallint(6) NOT NULL,
  `status` enum('pending','accepted') NOT NULL DEFAULT 'pending',
  `rate_id` int(11) NOT NULL COMMENT 'mandatory field',
  `calendar_id` int(11) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `commission` double DEFAULT NULL,
  `arrival_time` datetime NOT NULL COMMENT 'when the customer is supposed to arrive',
  `created` datetime NOT NULL,
  KEY `booking_fk_constraint1` (`from_hotel`),
  KEY `booking_fk_constraint2` (`to_hotel`),
  KEY `booking_fk_constraint3` (`from_user`),
  KEY `booking_fk_constraint4` (`action_user`),
  KEY `booking_fk_constraint5` (`room_id`),
  KEY `booking_fk_constraint6` (`customer_id`),
  KEY `booking_fk_constraint8` (`rate_id`),
  KEY `booking_fk_constraint9` (`calendar_id`),
  KEY `booking_fk_constraint10` (`discount`),
  CONSTRAINT `booking_fk_constraint1` FOREIGN KEY (`from_hotel`) REFERENCES `hotel` (`id`),
  CONSTRAINT `booking_fk_constraint2` FOREIGN KEY (`to_hotel`) REFERENCES `hotel` (`id`),
  CONSTRAINT `booking_fk_constraint3` FOREIGN KEY (`from_user`) REFERENCES `user` (`id`),
  CONSTRAINT `booking_fk_constraint4` FOREIGN KEY (`action_user`) REFERENCES `user` (`id`),
  CONSTRAINT `booking_fk_constraint8` FOREIGN KEY (`rate_id`) REFERENCES `rate` (`id`),
  CONSTRAINT `booking_fk_constraint5` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
  CONSTRAINT `booking_fk_constraint6` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `booking_fk_constraint9` FOREIGN KEY (`calendar_id`) REFERENCES `calendar` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='booking record';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-05-23 17:48:36



ALTER TABLE `hotel`
    ADD COLUMN `chain` VARCHAR(50) NULL DEFAULT NULL AFTER `city_part`,
    ADD COLUMN `phone1` VARCHAR(50) NOT NULL AFTER `chain`,
    ADD COLUMN `phone2` VARCHAR(50) NULL DEFAULT NULL AFTER `phone1`,
    ADD COLUMN `fax` VARCHAR(50) NOT NULL AFTER `phone2`,
    ADD COLUMN `email` VARCHAR(50) NOT NULL AFTER `fax`,
    ADD COLUMN `website` VARCHAR(100) NULL DEFAULT NULL AFTER `email`;
