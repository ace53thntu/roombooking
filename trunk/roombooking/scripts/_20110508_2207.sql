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
-- Definition of table `booking`.`city`
--

DROP TABLE IF EXISTS `booking`.`city`;
CREATE TABLE  `booking`.`city` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `city_unique` (`name`,`country_id`),
  KEY `city_fk_constraint` (`country_id`),
  CONSTRAINT `city_fk_constraint` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`city`
--

/*!40000 ALTER TABLE `city` DISABLE KEYS */;
LOCK TABLES `city` WRITE;
INSERT INTO `booking`.`city` VALUES  (1,'Stockholm',209);
UNLOCK TABLES;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;


--
-- Definition of table `booking`.`country`
--

DROP TABLE IF EXISTS `booking`.`country`;
CREATE TABLE  `booking`.`country` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `code` varchar(4) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `country_unique` (`name`),
  UNIQUE KEY `code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`country`
--

/*!40000 ALTER TABLE `country` DISABLE KEYS */;
LOCK TABLES `country` WRITE;
INSERT INTO `booking`.`country` VALUES  (1,'Afghanistan','AF',0),
 (2,'Aland Islands','AX',0),
 (3,'Albania','AL',0),
 (4,'Algeria','DZ',0),
 (5,'American Samoa','AS',0),
 (6,'Andorra','AD',0),
 (7,'Angola','AO',0),
 (8,'Anguilla','AI',0),
 (9,'Antarctica','AQ',0),
 (10,'Antigua And Barbuda','AG',0),
 (11,'Argentina','AR',0),
 (12,'Armenia','AM',0),
 (13,'Aruba','AW',0),
 (14,'Australia','AU',0),
 (15,'Austria','AT',0),
 (16,'Azerbaijan','AZ',0),
 (17,'Bahamas','BS',0),
 (18,'Bahrain','BH',0),
 (19,'Bangladesh','BD',0),
 (20,'Barbados','BB',0),
 (21,'Belarus','BY',0),
 (22,'Belgium','BE',0),
 (23,'Belize','BZ',0),
 (24,'Benin','BJ',0),
 (25,'Bermuda','BM',0),
 (26,'Bhutan','BT',0),
 (27,'Bolivia','BO',0),
 (28,'Bosnia And Herzegovina','BA',0),
 (29,'Botswana','BW',0),
 (30,'Bouvet Island','BV',0),
 (31,'Brazil','BR',0),
 (32,'British Indian Ocean Territory','IO',0),
 (33,'Brunei Darussalam','BN',0),
 (34,'Bulgaria','BG',0),
 (35,'Burkina Faso','BF',0),
 (36,'Burundi','BI',0),
 (37,'Cambodia','KH',0),
 (38,'Cameroon','CM',0),
 (39,'Canada','CA',0),
 (40,'Cape Verde','CV',0),
 (41,'Cayman Islands','KY',0),
 (42,'Central African Republic','CF',0),
 (43,'Chad','TD',0),
 (44,'Chile','CL',0),
 (45,'China','CN',0),
 (46,'Christmas Island','CX',0),
 (47,'Cocos (Keeling) Islands','CC',0),
 (48,'Colombia','CO',0),
 (49,'Comoros','KM',0),
 (50,'Congo','CG',0),
 (51,'Congo, The Democratic Republic Of The','CD',0),
 (52,'Cook Islands','CK',0),
 (53,'Costa Rica','CR',0),
 (54,'Cote D\'Ivoire','CI',0),
 (55,'Croatia','HR',0),
 (56,'Cuba','CU',0),
 (57,'Cyprus','CY',0),
 (58,'Czech Republic','CZ',0),
 (59,'Denmark','DK',0),
 (60,'Djibouti','DJ',0),
 (61,'Dominica','DM',0),
 (62,'Dominican Republic','DO',0),
 (63,'Ecuador','EC',0),
 (64,'Egypt','EG',0),
 (65,'El Salvador','SV',0),
 (66,'Equatorial Guinea','GQ',0),
 (67,'Eritrea','ER',0),
 (68,'Estonia','EE',0),
 (69,'Ethiopia','ET',0),
 (70,'Falkland Islands (Malvinas)','FK',0),
 (71,'Faroe Islands','FO',0),
 (72,'Fiji','FJ',0),
 (73,'Finland','FI',0),
 (74,'France','FR',0),
 (75,'French Guiana','GF',0),
 (76,'French Polynesia','PF',0),
 (77,'French Southern Territories','TF',0),
 (78,'Gabon','GA',0),
 (79,'Gambia','GM',0),
 (80,'Georgia','GE',0),
 (81,'Germany','DE',0),
 (82,'Ghana','GH',0),
 (83,'Gibraltar','GI',0),
 (84,'Greece','GR',0),
 (85,'Greenland','GL',0),
 (86,'Grenada','GD',0),
 (87,'Guadeloupe','GP',0),
 (88,'Guam','GU',0),
 (89,'Guatemala','GT',0),
 (90,'Guernsey',' GG',0),
 (91,'Guinea','GN',0),
 (92,'Guinea-Bissau','GW',0),
 (93,'Guyana','GY',0),
 (94,'Haiti','HT',0),
 (95,'Heard Island And Mcdonald Islands','HM',0),
 (96,'Holy See (Vatican City State)','VA',0),
 (97,'Honduras','HN',0),
 (98,'Hong Kong','HK',0),
 (99,'Hungary','HU',0),
 (100,'Iceland','IS',0),
 (101,'India','IN',0),
 (102,'Indonesia','ID',0),
 (103,'Iran, Islamic Republic Of','IR',0),
 (104,'Iraq','IQ',0),
 (105,'Ireland','IE',0),
 (106,'Isle Of Man','IM',0),
 (107,'Israel','IL',0),
 (108,'Italy','IT',0),
 (109,'Jamaica','JM',0),
 (110,'Japan','JP',0),
 (111,'Jersey','JE',0),
 (112,'Jordan','JO',0),
 (113,'Kazakhstan','KZ',0),
 (114,'Kenya','KE',0),
 (115,'Kiribati','KI',0),
 (116,'Korea, Democratic People\'S Republic Of','KP',0),
 (117,'Korea, Republic Of','KR',0),
 (118,'Kuwait','KW',0),
 (119,'Kyrgyzstan','KG',0),
 (120,'Lao People\'S Democratic Republic','LA',0),
 (121,'Latvia','LV',0),
 (122,'Lebanon','LB',0),
 (123,'Lesotho','LS',0),
 (124,'Liberia','LR',0),
 (125,'Libyan Arab Jamahiriya','LY',0),
 (126,'Liechtenstein','LI',0),
 (127,'Lithuania','LT',0),
 (128,'Luxembourg','LU',0),
 (129,'Macao','MO',0),
 (130,'Macedonia, The Former Yugoslav Republic Of','MK',0),
 (131,'Madagascar','MG',0),
 (132,'Malawi','MW',0),
 (133,'Malaysia','MY',0),
 (134,'Maldives','MV',0),
 (135,'Mali','ML',0),
 (136,'Malta','MT',0),
 (137,'Marshall Islands','MH',0),
 (138,'Martinique','MQ',0),
 (139,'Mauritania','MR',0),
 (140,'Mauritius','MU',0),
 (141,'Mayotte','YT',0),
 (142,'Mexico','MX',0),
 (143,'Micronesia, Federated States Of','FM',0),
 (144,'Moldova, Republic Of','MD',0),
 (145,'Monaco','MC',0),
 (146,'Mongolia','MN',0),
 (147,'Montserrat','MS',0),
 (148,'Morocco','MA',0),
 (149,'Mozambique','MZ',0),
 (150,'Myanmar','MM',0),
 (151,'Namibia','NA',0),
 (152,'Nauru','NR',0),
 (153,'Nepal','NP',0),
 (154,'Netherlands','NL',0),
 (155,'Netherlands Antilles','AN',0),
 (156,'New Caledonia','NC',0),
 (157,'New Zealand','NZ',0),
 (158,'Nicaragua','NI',0),
 (159,'Niger','NE',0),
 (160,'Nigeria','NG',0),
 (161,'Niue','NU',0),
 (162,'Norfolk Island','NF',0),
 (163,'Northern Mariana Islands','MP',0),
 (164,'Norway','NO',0),
 (165,'Oman','OM',0),
 (166,'Pakistan','PK',0),
 (167,'Palau','PW',0),
 (168,'Palestinian Territory, Occupied','PS',0),
 (169,'Panama','PA',0),
 (170,'Papua New Guinea','PG',0),
 (171,'Paraguay','PY',0),
 (172,'Peru','PE',0),
 (173,'Philippines','PH',0),
 (174,'Pitcairn','PN',0),
 (175,'Poland','PL',0),
 (176,'Portugal','PT',0),
 (177,'Puerto Rico','PR',0),
 (178,'Qatar','QA',0),
 (179,'Reunion','RE',0),
 (180,'Romania','RO',0),
 (181,'Russian Federation','RU',0),
 (182,'Rwanda','RW',0),
 (183,'Saint Helena','SH',0),
 (184,'Saint Kitts And Nevis','KN',0),
 (185,'Saint Lucia','LC',0),
 (186,'Saint Pierre And Miquelon','PM',0),
 (187,'Saint Vincent And The Grenadines','VC',0),
 (188,'Samoa','WS',0),
 (189,'San Marino','SM',0),
 (190,'Sao Tome And Principe','ST',0),
 (191,'Saudi Arabia','SA',0),
 (192,'Senegal','SN',0),
 (193,'Serbia And Montenegro','CS',0),
 (194,'Seychelles','SC',0),
 (195,'Sierra Leone','SL',0),
 (196,'Singapore','SG',0),
 (197,'Slovakia','SK',0),
 (198,'Slovenia','SI',0),
 (199,'Solomon Islands','SB',0),
 (200,'Somalia','SO',0),
 (201,'South Africa','ZA',0),
 (202,'South Georgia And The South Sandwich Islands','GS',0),
 (203,'Spain','ES',0),
 (204,'Sri Lanka','LK',0),
 (205,'Sudan','SD',0),
 (206,'Suriname','SR',0),
 (207,'Svalbard And Jan Mayen','SJ',0),
 (208,'Swaziland','SZ',0),
 (209,'Sweden','SE',0),
 (210,'Switzerland','CH',0),
 (211,'Syrian Arab Republic','SY',0),
 (212,'Taiwan, Province Of China','TW',0),
 (213,'Tajikistan','TJ',0),
 (214,'Tanzania, United Republic Of','TZ',0),
 (215,'Thailand','TH',0),
 (216,'Timor-Leste','TL',0),
 (217,'Togo','TG',0),
 (218,'Tokelau','TK',0),
 (219,'Tonga','TO',0),
 (220,'Trinidad And Tobago','TT',0),
 (221,'Tunisia','TN',0),
 (222,'Turkey','TR',0),
 (223,'Turkmenistan','TM',0),
 (224,'Turks And Caicos Islands','TC',0),
 (225,'Tuvalu','TV',0),
 (226,'Uganda','UG',0),
 (227,'Ukraine','UA',0),
 (228,'United Arab Emirates','AE',0),
 (229,'United Kingdom','GB',0),
 (230,'United States','US',0),
 (231,'United States Minor Outlying Islands','UM',0),
 (232,'Uruguay','UY',0),
 (233,'Uzbekistan','UZ',0),
 (234,'Vanuatu','VU',0),
 (235,'Venezuela','VE',0),
 (236,'Viet Nam','VN',0),
 (237,'Virgin Islands, British','VG',0),
 (238,'Virgin Islands, U.S.','VI',0),
 (239,'Wallis And Futuna','WF',0),
 (240,'Western Sahara','EH',0),
 (241,'Yemen','YE',0),
 (242,'Zambia','ZM',0),
 (243,'Zimbabwe','ZW',0),
 (244,'(Not Specified)','ZZ',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `country` ENABLE KEYS */;


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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`hotel`
--

/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
LOCK TABLES `hotel` WRITE;
INSERT INTO `booking`.`hotel` VALUES  (1,'hotel1','hotel1','','test 1','stockholm','11147',1,'center');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`.`hotel_user`
--

/*!40000 ALTER TABLE `hotel_user` DISABLE KEYS */;
LOCK TABLES `hotel_user` WRITE;
INSERT INTO `booking`.`hotel_user` VALUES  (1,1,1,1);
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
  `hotel_id` int(11) NOT NULL,
  `total` smallint(6) NOT NULL,
  `max_person` smallint(6) NOT NULL,
  `description` text,
  `available` smallint(6) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `room_type_fk_constraint` (`type_id`),
  KEY `room_hotel_fk_constraint` (`hotel_id`),
  CONSTRAINT `room_hotel_fk_constraint` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`id`),
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
  `key` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `room_type_unique` (`key`)
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
