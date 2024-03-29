/*!40000 ALTER TABLE `user` DISABLE KEYS */;
LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES  (1,'lhj1982','670b14728ad9902aecba32e22fa4f6bd','James','Lee','','');
INSERT INTO `user` VALUES  (2,'adelablue','670b14728ad9902aecba32e22fa4f6bd','Ningjing','Chen','','adelablue@gmail.com');
UNLOCK TABLES;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
LOCK TABLES `hotel` WRITE;
INSERT INTO `hotel` VALUES  (1,'hotel1','hotel1','','test 1','stockholm','11147',1,'center','none','', '', '', '' ,'', '','','','', now(), now());
UNLOCK TABLES;
/*!40000 ALTER TABLE `hotel` ENABLE KEYS */;

/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
LOCK TABLES `permission` WRITE;
INSERT INTO `permission` VALUES  (1,'administrator');
UNLOCK TABLES;
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;

/*!40000 ALTER TABLE `hotel_user` DISABLE KEYS */;
LOCK TABLES `hotel_user` WRITE;
INSERT INTO `hotel_user` VALUES  (1,1,1,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `hotel_user` ENABLE KEYS */;


-- INSERT INTO room_type (`key`, name) VALUES 
--    ("SIN", "Single Room"),
--    ("DBL", "Double Room");
    
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
LOCK TABLES `country` WRITE;
INSERT INTO `country` VALUES  (1,'Afghanistan','AF',0),
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
-- Dumping data for table `booking`.`city`
--

/*!40000 ALTER TABLE `city` DISABLE KEYS */;
LOCK TABLES `city` WRITE;
INSERT INTO `city` VALUES  (1,'Stockholm',209);
UNLOCK TABLES;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;


INSERT INTO rate_name (`key`, name) VALUES 
("STD", "Standard Rate"),
("SPE", "Special Rate"),
('SUM', 'Summer time');

/*
INSERT INTO calendar (id, `from`, `to`, name, description) VALUES 
(1, '2011-05-01 03:00:00', '2011-10-30 03:00:00', 'summer time', 'Summer time');

INSERT INTO calendar_price (id, calendar_id, room_id, price, created, modified) VALUES 
(1, 1, 1, 300, now(), now());
*/
INSERT INTO rate (id, room_id, person_number, rate_name, price, created, modified) VALUES 
(1, 1, 1, 3, 300, now(), now()),
(2, 1, 2, 3, 300, now(), now()),
(3, 1, 1, 4, 400, now(), now());

INSERT INTO `room_discount_rule` (`key`, `rule_name`, `created`) VALUES ('UNKNOWN', 'Unknown Reason', now());
INSERT INTO `room_discount_rule` (`key`, `rule_name`, `created`) VALUES ('SUMMER_TIME', 'Summer Time', now());
INSERT INTO `room_discount_rule` (`key`, `rule_name`, `created`) VALUES ('CHILD_DISCOUNT', 'Children discount', now());