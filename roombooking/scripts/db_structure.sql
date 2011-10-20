CREATE DATABASE  IF NOT EXISTS `booking` /*!40100 DEFAULT CHARACTER SET utf8 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='rate table define all price rate of hotel rooms, every room can only have one rate ';
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
  `status` enum('pending','accepted','rejected','expired') NOT NULL DEFAULT 'pending',
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

ALTER TABLE `hotel`
    CHANGE COLUMN `chain` `chain` ENUM('None','Hilton','Elite','Sweden','First','Rica','Clarion','Nordic','Best Western','Other') NULL DEFAULT 'None' AFTER `city_part`;
    
    
ALTER TABLE `hotel` ADD COLUMN `contact_name` VARCHAR(100)  NOT NULL AFTER `website`,
 ADD COLUMN `contact_title` VARCHAR(50)  AFTER `contact_name`,
 ADD COLUMN `contact_phone` VARCHAR(50)  NOT NULL AFTER `contact_title`,
 ADD COLUMN `contact_email` VARCHAR(50)  NOT NULL AFTER `contact_phone`,
 ADD COLUMN `created` DATETIME  NOT NULL AFTER `contact_email`,
 ADD COLUMN `modified` DATETIME  NOT NULL AFTER `created`;
 
 
ALTER TABLE `room` CHANGE COLUMN `type_id` `key` VARCHAR(3)  NOT NULL COMMENT 'room category key, 3 chars',
 CHANGE COLUMN `max_person` `max_adults` SMALLINT(6)  NOT NULL,
 ADD COLUMN `name` VARCHAR(50)  NOT NULL AFTER `id`,
 ADD COLUMN `max_children` SMALLINT(6)  NOT NULL DEFAULT 0 AFTER `max_adults`,
 DROP INDEX `room_unique`,
 ADD UNIQUE INDEX `room_unique` USING BTREE(`hotel_id`, `key`)
, DROP INDEX `room_type_fk_constraint`,
 DROP FOREIGN KEY `room_type_fk_constraint`;
 
DROP TABLE room_type;

-- 2011-07-04
ALTER TABLE `booking` DROP FOREIGN KEY `booking_fk_constraint9` ;
ALTER TABLE `booking` CHANGE COLUMN `calendar_id` `calendar_price_id` INT(11) NULL DEFAULT NULL  , 
  ADD CONSTRAINT `booking_fk_constraint9`
  FOREIGN KEY (`calendar_price_id` )
  REFERENCES `calendar_price` (`id` )
, DROP INDEX `booking_fk_constraint9` 
, ADD INDEX `booking_fk_constraint9` (`calendar_price_id` ASC) ;



-- 2011-07-19
-- activity type
CREATE TABLE `activity_type` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(20) NOT NULL,
  `name` varchar(40) NOT NULL,
  `table_name` varchar(20) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `activity_type_unique` USING BTREE (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='activity type';

insert into activity_type (`key`, `name`, table_name) values ('SEND_BOOKING_REQUEST', 'Send booking request', 'booking');
insert into activity_type (`key`, `name`, table_name) values ('RESPOND_BOOKING_REQUEST', 'Response booking request', 'booking');

CREATE TABLE `activity` (
  `id` INTEGER  NOT NULL AUTO_INCREMENT,
  `type` INTEGER  NOT NULL,
  `user_id` INTEGER  NOT NULL,
  `object` INTEGER  NOT NULL,
  `created` DATETIME  NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `activity_type_fk_constraint` FOREIGN KEY `activity_type_fk_constraint` (`type`)
    REFERENCES `activity_type` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `activity_user_fk_constraint` FOREIGN KEY `activity_user_fk_constraint` (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
)
ENGINE = InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci
COMMENT = 'user actities';

CREATE TABLE  `mail_queue` (
  `id` int(11) NOT NULL auto_increment,
  `activity_type` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `recipients` text NOT NULL COMMENT 'recipients, separated by comma',
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  `sent` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `activity_type_key_fk_constraint` (`activity_type`),
  CONSTRAINT `activity_type_key_fk_constraint` FOREIGN KEY (`activity_type`) REFERENCES `activity_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2011-08-19
CREATE  TABLE `commission` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `room_id` INT NOT NULL ,
  `commission` VARCHAR(10) NULL ,
  `created` DATETIME NOT NULL ,
  `modified` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `commission_fk_constraint1` (`room_id` ASC) ,
  CONSTRAINT `commission_fk_constraint1`
    FOREIGN KEY (`room_id` )
    REFERENCES `room` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

-- 2011-08-21
ALTER TABLE `booking` CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT  
, ADD PRIMARY KEY (`id`) ;

-- 2011-08-28
ALTER TABLE `booking` ADD COLUMN `number_of_room` SMALLINT NOT NULL DEFAULT 1  AFTER `to_date` , ADD COLUMN `expired_date` DATETIME NULL  AFTER `arrival_time` ;

-- 2011-08-31
ALTER TABLE `calendar_price` CHANGE COLUMN `price` `discount` SMALLINT NOT NULL DEFAULT 0  , 
COMMENT = 'calendar price discount' , RENAME TO  `calendar_price_discount` ;

ALTER TABLE `rate` DROP FOREIGN KEY `rate_fk_constratint1` ;

ALTER TABLE `rate` ADD COLUMN `discount` SMALLINT NULL DEFAULT NULL COMMENT 'discount in percentage'  AFTER `price` , ADD COLUMN `calendar_price_discount` INT NULL DEFAULT NULL COMMENT 'calendar price discount in percentage'  AFTER `discount` , ADD COLUMN `comment` TEXT NULL DEFAULT NULL  AFTER `calendar_price_discount` , 
  ADD CONSTRAINT `rate_fk_constratnt1`
  FOREIGN KEY (`rate_name` )
  REFERENCES `rate_name` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION, 
  ADD CONSTRAINT `rate_fk_constraint2`
  FOREIGN KEY (`calendar_price_discount` )
  REFERENCES `calendar_price_discount` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, DROP INDEX `rate_unique` 
, ADD UNIQUE INDEX `rate_unique` (`room_id` ASC, `person_number` ASC, `rate_name` ASC, `discount` ASC, `calendar_price_discount` ASC) 
, ADD INDEX `rate_fk_constraint2` (`calendar_price_discount` ASC) ;

ALTER TABLE `rate` 
DROP INDEX `rate_unique` 
, ADD UNIQUE INDEX `rate_unique` (`room_id` ASC, `person_number` ASC, `rate_name` ASC) ;

-- 2011-09-02
ALTER TABLE `rate` ADD COLUMN `calendar_id` INT NULL DEFAULT NULL  AFTER `discount`;
ALTER TABLE `rate` DROP FOREIGN KEY `rate_fk_constraint2` ;
ALTER TABLE `rate` 
DROP INDEX `rate_fk_constraint2` ;

ALTER TABLE `rate` 
  ADD CONSTRAINT `rate_fk_constraint2`
  FOREIGN KEY (`calendar_id` )
  REFERENCES `calendar` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `rate_fk_constraint2` (`calendar_id` ASC) ;

drop table `calendar_price_discount`;

CREATE  TABLE `room_discount_rule` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `key` VARCHAR(20) NOT NULL ,
  `rule_name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(100) NULL DEFAULT NULL,
  `created` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `room_discount_rule_unique` (`key` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE  TABLE `room_discount` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `rule_id` INT NOT NULL ,
  `discount` SMALLINT NOT NULL DEFAULT 0 ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `room_discount_fk_constraint1` (`rule_id` ASC) ,
  UNIQUE INDEX `room_discount_unique` (`rule_id` ASC, `discount` ASC) ,
  CONSTRAINT `room_discount_fk_constraint1`
    FOREIGN KEY (`rule_id` )
    REFERENCES `room_discount_rule` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'room discount' ;

ALTER TABLE `rate` DROP FOREIGN KEY `rate_fk_constraint2` ;
ALTER TABLE `rate` DROP COLUMN `calendar_price_discount` , DROP COLUMN `calendar_id` , DROP COLUMN `discount` 
, DROP INDEX `rate_fk_constraint2` ;

ALTER TABLE `room_discount` ADD COLUMN `room_id` INT NOT NULL  AFTER `id` , 
  ADD CONSTRAINT `room_discount_fk_constraint2`
  FOREIGN KEY (`room_id` )
  REFERENCES `room` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, DROP INDEX `room_discount_unique` 
, ADD UNIQUE INDEX `room_discount_unique` (`rule_id` ASC, `room_id` ASC) 
, ADD INDEX `room_discount_fk_constraint2` (`room_id` ASC) ;


ALTER TABLE `booking` DROP FOREIGN KEY `booking_fk_constraint9` , DROP FOREIGN KEY `booking_fk_constraint8` ;
ALTER TABLE `booking` DROP COLUMN `discount` , CHANGE COLUMN `status` `status` ENUM('pending','accepted','rejected','expired','delived','confirmed') NOT NULL DEFAULT 'pending'  , CHANGE COLUMN `rate_id` `price` DOUBLE NOT NULL COMMENT 'mandatory field'  , CHANGE COLUMN `calendar_price_id` `discount` INT(11) NULL DEFAULT NULL  , CHANGE COLUMN `commission` `commission` INT NULL DEFAULT NULL  
, DROP INDEX `booking_fk_constraint8` 
, ADD INDEX `booking_fk_constraint8` (`price` ASC) 
, DROP INDEX `booking_fk_constraint9` 
, ADD INDEX `booking_fk_constraint9` (`discount` ASC) 
, DROP INDEX `booking_fk_constraint10` ;

ALTER TABLE `booking` CHANGE COLUMN `discount` `discount` DOUBLE NULL DEFAULT NULL  , CHANGE COLUMN `commission` `commission` DOUBLE NULL DEFAULT NULL  ;

ALTER TABLE `booking` CHANGE COLUMN `status` `status` ENUM('pending','accepted','rejected','expired','delivered','confirmed','cancelled') NOT NULL DEFAULT 'pending'  ;

