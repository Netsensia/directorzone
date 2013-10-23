-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: directorzone_zf2
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu7

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
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `addressid` int(11) NOT NULL AUTO_INCREMENT,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `town` varchar(100) DEFAULT NULL,
  `county` varchar(100) DEFAULT NULL,
  `countryid` int(11) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`addressid`),
  KEY `country` (`countryid`),
  CONSTRAINT `address_ibfk_1` FOREIGN KEY (`countryid`) REFERENCES `country` (`countryid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'25 Raymond Road',NULL,'',NULL,'',NULL,''),(2,'25 Raymond Road',NULL,'','','',NULL,''),(3,'123123','',NULL,'','',1,''),(4,'25 Raymond Road','',NULL,'','',235,'SW194AD'),(5,'234234','',NULL,'','',1,''),(6,'','',NULL,'','',1,''),(7,'','',NULL,'','',1,''),(8,'','',NULL,'','',1,''),(9,'','',NULL,'','',1,''),(10,'123','','','','',1,''),(11,'123','','','','',1,''),(12,'Fukuppy Lane','Herts','','','',16,''),(13,'123123123','','','','',1,''),(14,'ASD','','','','',1,'');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availability`
--

DROP TABLE IF EXISTS `availability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability` (
  `availabilityid` int(11) NOT NULL,
  `availability` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`availabilityid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability`
--

LOCK TABLES `availability` WRITE;
/*!40000 ALTER TABLE `availability` DISABLE KEYS */;
/*!40000 ALTER TABLE `availability` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `countryid` int(5) NOT NULL AUTO_INCREMENT,
  `iso2` char(2) DEFAULT NULL,
  `country` varchar(80) NOT NULL DEFAULT '',
  `long_name` varchar(80) NOT NULL DEFAULT '',
  `iso3` char(3) DEFAULT NULL,
  `numcode` varchar(6) DEFAULT NULL,
  `un_member` varchar(12) DEFAULT NULL,
  `calling_code` varchar(8) DEFAULT NULL,
  `cctld` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`countryid`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'AF','Afghanistan','Islamic Republic of Afghanistan','AFG','004','yes','93','.af'),(2,'AX','Aland Islands','&Aring;land Islands','ALA','248','no','358','.ax'),(3,'AL','Albania','Republic of Albania','ALB','008','yes','355','.al'),(4,'DZ','Algeria','People\'s Democratic Republic of Algeria','DZA','012','yes','213','.dz'),(5,'AS','American Samoa','American Samoa','ASM','016','no','1+684','.as'),(6,'AD','Andorra','Principality of Andorra','AND','020','yes','376','.ad'),(7,'AO','Angola','Republic of Angola','AGO','024','yes','244','.ao'),(8,'AI','Anguilla','Anguilla','AIA','660','no','1+264','.ai'),(9,'AQ','Antarctica','Antarctica','ATA','010','no','672','.aq'),(10,'AG','Antigua and Barbuda','Antigua and Barbuda','ATG','028','yes','1+268','.ag'),(11,'AR','Argentina','Argentine Republic','ARG','032','yes','54','.ar'),(12,'AM','Armenia','Republic of Armenia','ARM','051','yes','374','.am'),(13,'AW','Aruba','Aruba','ABW','533','no','297','.aw'),(14,'AU','Australia','Commonwealth of Australia','AUS','036','yes','61','.au'),(15,'AT','Austria','Republic of Austria','AUT','040','yes','43','.at'),(16,'AZ','Azerbaijan','Republic of Azerbaijan','AZE','031','yes','994','.az'),(17,'BS','Bahamas','Commonwealth of The Bahamas','BHS','044','yes','1+242','.bs'),(18,'BH','Bahrain','Kingdom of Bahrain','BHR','048','yes','973','.bh'),(19,'BD','Bangladesh','People\'s Republic of Bangladesh','BGD','050','yes','880','.bd'),(20,'BB','Barbados','Barbados','BRB','052','yes','1+246','.bb'),(21,'BY','Belarus','Republic of Belarus','BLR','112','yes','375','.by'),(22,'BE','Belgium','Kingdom of Belgium','BEL','056','yes','32','.be'),(23,'BZ','Belize','Belize','BLZ','084','yes','501','.bz'),(24,'BJ','Benin','Republic of Benin','BEN','204','yes','229','.bj'),(25,'BM','Bermuda','Bermuda Islands','BMU','060','no','1+441','.bm'),(26,'BT','Bhutan','Kingdom of Bhutan','BTN','064','yes','975','.bt'),(27,'BO','Bolivia','Plurinational State of Bolivia','BOL','068','yes','591','.bo'),(28,'BQ','Bonaire, Sint Eustatius and Saba','Bonaire, Sint Eustatius and Saba','BES','535','no','599','.bq'),(29,'BA','Bosnia and Herzegovina','Bosnia and Herzegovina','BIH','070','yes','387','.ba'),(30,'BW','Botswana','Republic of Botswana','BWA','072','yes','267','.bw'),(31,'BV','Bouvet Island','Bouvet Island','BVT','074','no','NONE','.bv'),(32,'BR','Brazil','Federative Republic of Brazil','BRA','076','yes','55','.br'),(33,'IO','British Indian Ocean Territory','British Indian Ocean Territory','IOT','086','no','246','.io'),(34,'BN','Brunei','Brunei Darussalam','BRN','096','yes','673','.bn'),(35,'BG','Bulgaria','Republic of Bulgaria','BGR','100','yes','359','.bg'),(36,'BF','Burkina Faso','Burkina Faso','BFA','854','yes','226','.bf'),(37,'BI','Burundi','Republic of Burundi','BDI','108','yes','257','.bi'),(38,'KH','Cambodia','Kingdom of Cambodia','KHM','116','yes','855','.kh'),(39,'CM','Cameroon','Republic of Cameroon','CMR','120','yes','237','.cm'),(40,'CA','Canada','Canada','CAN','124','yes','1','.ca'),(41,'CV','Cape Verde','Republic of Cape Verde','CPV','132','yes','238','.cv'),(42,'KY','Cayman Islands','The Cayman Islands','CYM','136','no','1+345','.ky'),(43,'CF','Central African Republic','Central African Republic','CAF','140','yes','236','.cf'),(44,'TD','Chad','Republic of Chad','TCD','148','yes','235','.td'),(45,'CL','Chile','Republic of Chile','CHL','152','yes','56','.cl'),(46,'CN','China','People\'s Republic of China','CHN','156','yes','86','.cn'),(47,'CX','Christmas Island','Christmas Island','CXR','162','no','61','.cx'),(48,'CC','Cocos (Keeling) Islands','Cocos (Keeling) Islands','CCK','166','no','61','.cc'),(49,'CO','Colombia','Republic of Colombia','COL','170','yes','57','.co'),(50,'KM','Comoros','Union of the Comoros','COM','174','yes','269','.km'),(51,'CG','Congo','Republic of the Congo','COG','178','yes','242','.cg'),(52,'CK','Cook Islands','Cook Islands','COK','184','some','682','.ck'),(53,'CR','Costa Rica','Republic of Costa Rica','CRI','188','yes','506','.cr'),(54,'CI','Cote d\'ivoire (Ivory Coast)','Republic of C&ocirc;te D\'Ivoire (Ivory Coast)','CIV','384','yes','225','.ci'),(55,'HR','Croatia','Republic of Croatia','HRV','191','yes','385','.hr'),(56,'CU','Cuba','Republic of Cuba','CUB','192','yes','53','.cu'),(57,'CW','Curacao','Cura&ccedil;ao','CUW','531','no','599','.cw'),(58,'CY','Cyprus','Republic of Cyprus','CYP','196','yes','357','.cy'),(59,'CZ','Czech Republic','Czech Republic','CZE','203','yes','420','.cz'),(60,'CD','Democratic Republic of the Congo','Democratic Republic of the Congo','COD','180','yes','243','.cd'),(61,'DK','Denmark','Kingdom of Denmark','DNK','208','yes','45','.dk'),(62,'DJ','Djibouti','Republic of Djibouti','DJI','262','yes','253','.dj'),(63,'DM','Dominica','Commonwealth of Dominica','DMA','212','yes','1+767','.dm'),(64,'DO','Dominican Republic','Dominican Republic','DOM','214','yes','1+809, 8','.do'),(65,'EC','Ecuador','Republic of Ecuador','ECU','218','yes','593','.ec'),(66,'EG','Egypt','Arab Republic of Egypt','EGY','818','yes','20','.eg'),(67,'SV','El Salvador','Republic of El Salvador','SLV','222','yes','503','.sv'),(68,'GQ','Equatorial Guinea','Republic of Equatorial Guinea','GNQ','226','yes','240','.gq'),(69,'ER','Eritrea','State of Eritrea','ERI','232','yes','291','.er'),(70,'EE','Estonia','Republic of Estonia','EST','233','yes','372','.ee'),(71,'ET','Ethiopia','Federal Democratic Republic of Ethiopia','ETH','231','yes','251','.et'),(72,'FK','Falkland Islands (Malvinas)','The Falkland Islands (Malvinas)','FLK','238','no','500','.fk'),(73,'FO','Faroe Islands','The Faroe Islands','FRO','234','no','298','.fo'),(74,'FJ','Fiji','Republic of Fiji','FJI','242','yes','679','.fj'),(75,'FI','Finland','Republic of Finland','FIN','246','yes','358','.fi'),(76,'FR','France','French Republic','FRA','250','yes','33','.fr'),(77,'GF','French Guiana','French Guiana','GUF','254','no','594','.gf'),(78,'PF','French Polynesia','French Polynesia','PYF','258','no','689','.pf'),(79,'TF','French Southern Territories','French Southern Territories','ATF','260','no',NULL,'.tf'),(80,'GA','Gabon','Gabonese Republic','GAB','266','yes','241','.ga'),(81,'GM','Gambia','Republic of The Gambia','GMB','270','yes','220','.gm'),(82,'GE','Georgia','Georgia','GEO','268','yes','995','.ge'),(83,'DE','Germany','Federal Republic of Germany','DEU','276','yes','49','.de'),(84,'GH','Ghana','Republic of Ghana','GHA','288','yes','233','.gh'),(85,'GI','Gibraltar','Gibraltar','GIB','292','no','350','.gi'),(86,'GR','Greece','Hellenic Republic','GRC','300','yes','30','.gr'),(87,'GL','Greenland','Greenland','GRL','304','no','299','.gl'),(88,'GD','Grenada','Grenada','GRD','308','yes','1+473','.gd'),(89,'GP','Guadaloupe','Guadeloupe','GLP','312','no','590','.gp'),(90,'GU','Guam','Guam','GUM','316','no','1+671','.gu'),(91,'GT','Guatemala','Republic of Guatemala','GTM','320','yes','502','.gt'),(92,'GG','Guernsey','Guernsey','GGY','831','no','44','.gg'),(93,'GN','Guinea','Republic of Guinea','GIN','324','yes','224','.gn'),(94,'GW','Guinea-Bissau','Republic of Guinea-Bissau','GNB','624','yes','245','.gw'),(95,'GY','Guyana','Co-operative Republic of Guyana','GUY','328','yes','592','.gy'),(96,'HT','Haiti','Republic of Haiti','HTI','332','yes','509','.ht'),(97,'HM','Heard Island and McDonald Islands','Heard Island and McDonald Islands','HMD','334','no','NONE','.hm'),(98,'HN','Honduras','Republic of Honduras','HND','340','yes','504','.hn'),(99,'HK','Hong Kong','Hong Kong','HKG','344','no','852','.hk'),(100,'HU','Hungary','Hungary','HUN','348','yes','36','.hu'),(101,'IS','Iceland','Republic of Iceland','ISL','352','yes','354','.is'),(102,'IN','India','Republic of India','IND','356','yes','91','.in'),(103,'ID','Indonesia','Republic of Indonesia','IDN','360','yes','62','.id'),(104,'IR','Iran','Islamic Republic of Iran','IRN','364','yes','98','.ir'),(105,'IQ','Iraq','Republic of Iraq','IRQ','368','yes','964','.iq'),(106,'IE','Ireland','Ireland','IRL','372','yes','353','.ie'),(107,'IM','Isle of Man','Isle of Man','IMN','833','no','44','.im'),(108,'IL','Israel','State of Israel','ISR','376','yes','972','.il'),(109,'IT','Italy','Italian Republic','ITA','380','yes','39','.jm'),(110,'JM','Jamaica','Jamaica','JAM','388','yes','1+876','.jm'),(111,'JP','Japan','Japan','JPN','392','yes','81','.jp'),(112,'JE','Jersey','The Bailiwick of Jersey','JEY','832','no','44','.je'),(113,'JO','Jordan','Hashemite Kingdom of Jordan','JOR','400','yes','962','.jo'),(114,'KZ','Kazakhstan','Republic of Kazakhstan','KAZ','398','yes','7','.kz'),(115,'KE','Kenya','Republic of Kenya','KEN','404','yes','254','.ke'),(116,'KI','Kiribati','Republic of Kiribati','KIR','296','yes','686','.ki'),(117,'XK','Kosovo','Republic of Kosovo','---','---','some','381',''),(118,'KW','Kuwait','State of Kuwait','KWT','414','yes','965','.kw'),(119,'KG','Kyrgyzstan','Kyrgyz Republic','KGZ','417','yes','996','.kg'),(120,'LA','Laos','Lao People\'s Democratic Republic','LAO','418','yes','856','.la'),(121,'LV','Latvia','Republic of Latvia','LVA','428','yes','371','.lv'),(122,'LB','Lebanon','Republic of Lebanon','LBN','422','yes','961','.lb'),(123,'LS','Lesotho','Kingdom of Lesotho','LSO','426','yes','266','.ls'),(124,'LR','Liberia','Republic of Liberia','LBR','430','yes','231','.lr'),(125,'LY','Libya','Libya','LBY','434','yes','218','.ly'),(126,'LI','Liechtenstein','Principality of Liechtenstein','LIE','438','yes','423','.li'),(127,'LT','Lithuania','Republic of Lithuania','LTU','440','yes','370','.lt'),(128,'LU','Luxembourg','Grand Duchy of Luxembourg','LUX','442','yes','352','.lu'),(129,'MO','Macao','The Macao Special Administrative Region','MAC','446','no','853','.mo'),(130,'MK','Macedonia','The Former Yugoslav Republic of Macedonia','MKD','807','yes','389','.mk'),(131,'MG','Madagascar','Republic of Madagascar','MDG','450','yes','261','.mg'),(132,'MW','Malawi','Republic of Malawi','MWI','454','yes','265','.mw'),(133,'MY','Malaysia','Malaysia','MYS','458','yes','60','.my'),(134,'MV','Maldives','Republic of Maldives','MDV','462','yes','960','.mv'),(135,'ML','Mali','Republic of Mali','MLI','466','yes','223','.ml'),(136,'MT','Malta','Republic of Malta','MLT','470','yes','356','.mt'),(137,'MH','Marshall Islands','Republic of the Marshall Islands','MHL','584','yes','692','.mh'),(138,'MQ','Martinique','Martinique','MTQ','474','no','596','.mq'),(139,'MR','Mauritania','Islamic Republic of Mauritania','MRT','478','yes','222','.mr'),(140,'MU','Mauritius','Republic of Mauritius','MUS','480','yes','230','.mu'),(141,'YT','Mayotte','Mayotte','MYT','175','no','262','.yt'),(142,'MX','Mexico','United Mexican States','MEX','484','yes','52','.mx'),(143,'FM','Micronesia','Federated States of Micronesia','FSM','583','yes','691','.fm'),(144,'MD','Moldava','Republic of Moldova','MDA','498','yes','373','.md'),(145,'MC','Monaco','Principality of Monaco','MCO','492','yes','377','.mc'),(146,'MN','Mongolia','Mongolia','MNG','496','yes','976','.mn'),(147,'ME','Montenegro','Montenegro','MNE','499','yes','382','.me'),(148,'MS','Montserrat','Montserrat','MSR','500','no','1+664','.ms'),(149,'MA','Morocco','Kingdom of Morocco','MAR','504','yes','212','.ma'),(150,'MZ','Mozambique','Republic of Mozambique','MOZ','508','yes','258','.mz'),(151,'MM','Myanmar (Burma)','Republic of the Union of Myanmar','MMR','104','yes','95','.mm'),(152,'NA','Namibia','Republic of Namibia','NAM','516','yes','264','.na'),(153,'NR','Nauru','Republic of Nauru','NRU','520','yes','674','.nr'),(154,'NP','Nepal','Federal Democratic Republic of Nepal','NPL','524','yes','977','.np'),(155,'NL','Netherlands','Kingdom of the Netherlands','NLD','528','yes','31','.nl'),(156,'NC','New Caledonia','New Caledonia','NCL','540','no','687','.nc'),(157,'NZ','New Zealand','New Zealand','NZL','554','yes','64','.nz'),(158,'NI','Nicaragua','Republic of Nicaragua','NIC','558','yes','505','.ni'),(159,'NE','Niger','Republic of Niger','NER','562','yes','227','.ne'),(160,'NG','Nigeria','Federal Republic of Nigeria','NGA','566','yes','234','.ng'),(161,'NU','Niue','Niue','NIU','570','some','683','.nu'),(162,'NF','Norfolk Island','Norfolk Island','NFK','574','no','672','.nf'),(163,'KP','North Korea','Democratic People\'s Republic of Korea','PRK','408','yes','850','.kp'),(164,'MP','Northern Mariana Islands','Northern Mariana Islands','MNP','580','no','1+670','.mp'),(165,'NO','Norway','Kingdom of Norway','NOR','578','yes','47','.no'),(166,'OM','Oman','Sultanate of Oman','OMN','512','yes','968','.om'),(167,'PK','Pakistan','Islamic Republic of Pakistan','PAK','586','yes','92','.pk'),(168,'PW','Palau','Republic of Palau','PLW','585','yes','680','.pw'),(169,'PS','Palestine','State of Palestine (or Occupied Palestinian Territory)','PSE','275','some','970','.ps'),(170,'PA','Panama','Republic of Panama','PAN','591','yes','507','.pa'),(171,'PG','Papua New Guinea','Independent State of Papua New Guinea','PNG','598','yes','675','.pg'),(172,'PY','Paraguay','Republic of Paraguay','PRY','600','yes','595','.py'),(173,'PE','Peru','Republic of Peru','PER','604','yes','51','.pe'),(174,'PH','Phillipines','Republic of the Philippines','PHL','608','yes','63','.ph'),(175,'PN','Pitcairn','Pitcairn','PCN','612','no','NONE','.pn'),(176,'PL','Poland','Republic of Poland','POL','616','yes','48','.pl'),(177,'PT','Portugal','Portuguese Republic','PRT','620','yes','351','.pt'),(178,'PR','Puerto Rico','Commonwealth of Puerto Rico','PRI','630','no','1+939','.pr'),(179,'QA','Qatar','State of Qatar','QAT','634','yes','974','.qa'),(180,'RE','Reunion','R&eacute;union','REU','638','no','262','.re'),(181,'RO','Romania','Romania','ROU','642','yes','40','.ro'),(182,'RU','Russia','Russian Federation','RUS','643','yes','7','.ru'),(183,'RW','Rwanda','Republic of Rwanda','RWA','646','yes','250','.rw'),(184,'BL','Saint Barthelemy','Saint Barth&eacute;lemy','BLM','652','no','590','.bl'),(185,'SH','Saint Helena','Saint Helena, Ascension and Tristan da Cunha','SHN','654','no','290','.sh'),(186,'KN','Saint Kitts and Nevis','Federation of Saint Christopher and Nevis','KNA','659','yes','1+869','.kn'),(187,'LC','Saint Lucia','Saint Lucia','LCA','662','yes','1+758','.lc'),(188,'MF','Saint Martin','Saint Martin','MAF','663','no','590','.mf'),(189,'PM','Saint Pierre and Miquelon','Saint Pierre and Miquelon','SPM','666','no','508','.pm'),(190,'VC','Saint Vincent and the Grenadines','Saint Vincent and the Grenadines','VCT','670','yes','1+784','.vc'),(191,'WS','Samoa','Independent State of Samoa','WSM','882','yes','685','.ws'),(192,'SM','San Marino','Republic of San Marino','SMR','674','yes','378','.sm'),(193,'ST','Sao Tome and Principe','Democratic Republic of S&atilde;o Tom&eacute; and Pr&iacute;ncipe','STP','678','yes','239','.st'),(194,'SA','Saudi Arabia','Kingdom of Saudi Arabia','SAU','682','yes','966','.sa'),(195,'SN','Senegal','Republic of Senegal','SEN','686','yes','221','.sn'),(196,'RS','Serbia','Republic of Serbia','SRB','688','yes','381','.rs'),(197,'SC','Seychelles','Republic of Seychelles','SYC','690','yes','248','.sc'),(198,'SL','Sierra Leone','Republic of Sierra Leone','SLE','694','yes','232','.sl'),(199,'SG','Singapore','Republic of Singapore','SGP','702','yes','65','.sg'),(200,'SX','Sint Maarten','Sint Maarten','SXM','534','no','1+721','.sx'),(201,'SK','Slovakia','Slovak Republic','SVK','703','yes','421','.sk'),(202,'SI','Slovenia','Republic of Slovenia','SVN','705','yes','386','.si'),(203,'SB','Solomon Islands','Solomon Islands','SLB','090','yes','677','.sb'),(204,'SO','Somalia','Somali Republic','SOM','706','yes','252','.so'),(205,'ZA','South Africa','Republic of South Africa','ZAF','710','yes','27','.za'),(206,'GS','South Georgia and the South Sandwich Islands','South Georgia and the South Sandwich Islands','SGS','239','no','500','.gs'),(207,'KR','South Korea','Republic of Korea','KOR','410','yes','82','.kr'),(208,'SS','South Sudan','Republic of South Sudan','SSD','728','yes','211','.ss'),(209,'ES','Spain','Kingdom of Spain','ESP','724','yes','34','.es'),(210,'LK','Sri Lanka','Democratic Socialist Republic of Sri Lanka','LKA','144','yes','94','.lk'),(211,'SD','Sudan','Republic of the Sudan','SDN','729','yes','249','.sd'),(212,'SR','Suriname','Republic of Suriname','SUR','740','yes','597','.sr'),(213,'SJ','Svalbard and Jan Mayen','Svalbard and Jan Mayen','SJM','744','no','47','.sj'),(214,'SZ','Swaziland','Kingdom of Swaziland','SWZ','748','yes','268','.sz'),(215,'SE','Sweden','Kingdom of Sweden','SWE','752','yes','46','.se'),(216,'CH','Switzerland','Swiss Confederation','CHE','756','yes','41','.ch'),(217,'SY','Syria','Syrian Arab Republic','SYR','760','yes','963','.sy'),(218,'TW','Taiwan','Republic of China (Taiwan)','TWN','158','former','886','.tw'),(219,'TJ','Tajikistan','Republic of Tajikistan','TJK','762','yes','992','.tj'),(220,'TZ','Tanzania','United Republic of Tanzania','TZA','834','yes','255','.tz'),(221,'TH','Thailand','Kingdom of Thailand','THA','764','yes','66','.th'),(222,'TL','Timor-Leste (East Timor)','Democratic Republic of Timor-Leste','TLS','626','yes','670','.tl'),(223,'TG','Togo','Togolese Republic','TGO','768','yes','228','.tg'),(224,'TK','Tokelau','Tokelau','TKL','772','no','690','.tk'),(225,'TO','Tonga','Kingdom of Tonga','TON','776','yes','676','.to'),(226,'TT','Trinidad and Tobago','Republic of Trinidad and Tobago','TTO','780','yes','1+868','.tt'),(227,'TN','Tunisia','Republic of Tunisia','TUN','788','yes','216','.tn'),(228,'TR','Turkey','Republic of Turkey','TUR','792','yes','90','.tr'),(229,'TM','Turkmenistan','Turkmenistan','TKM','795','yes','993','.tm'),(230,'TC','Turks and Caicos Islands','Turks and Caicos Islands','TCA','796','no','1+649','.tc'),(231,'TV','Tuvalu','Tuvalu','TUV','798','yes','688','.tv'),(232,'UG','Uganda','Republic of Uganda','UGA','800','yes','256','.ug'),(233,'UA','Ukraine','Ukraine','UKR','804','yes','380','.ua'),(234,'AE','United Arab Emirates','United Arab Emirates','ARE','784','yes','971','.ae'),(235,'GB','United Kingdom','United Kingdom of Great Britain and Nothern Ireland','GBR','826','yes','44','.uk'),(236,'US','United States','United States of America','USA','840','yes','1','.us'),(237,'UM','United States Minor Outlying Islands','United States Minor Outlying Islands','UMI','581','no','NONE','NONE'),(238,'UY','Uruguay','Eastern Republic of Uruguay','URY','858','yes','598','.uy'),(239,'UZ','Uzbekistan','Republic of Uzbekistan','UZB','860','yes','998','.uz'),(240,'VU','Vanuatu','Republic of Vanuatu','VUT','548','yes','678','.vu'),(241,'VA','Vatican City','State of the Vatican City','VAT','336','no','39','.va'),(242,'VE','Venezuela','Bolivarian Republic of Venezuela','VEN','862','yes','58','.ve'),(243,'VN','Vietnam','Socialist Republic of Vietnam','VNM','704','yes','84','.vn'),(244,'VG','Virgin Islands, British','British Virgin Islands','VGB','092','no','1+284','.vg'),(245,'VI','Virgin Islands, US','Virgin Islands of the United States','VIR','850','no','1+340','.vi'),(246,'WF','Wallis and Futuna','Wallis and Futuna','WLF','876','no','681','.wf'),(247,'EH','Western Sahara','Western Sahara','ESH','732','no','212','.eh'),(248,'YE','Yemen','Republic of Yemen','YEM','887','yes','967','.ye'),(249,'ZM','Zambia','Republic of Zambia','ZMB','894','yes','260','.zm'),(250,'ZW','Zimbabwe','Republic of Zimbabwe','ZWE','716','yes','263','.zw');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiencearea`
--

DROP TABLE IF EXISTS `experiencearea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiencearea` (
  `experiencearea` int(11) NOT NULL,
  `experienceareaid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`experiencearea`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiencearea`
--

LOCK TABLES `experiencearea` WRITE;
/*!40000 ALTER TABLE `experiencearea` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiencearea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gender`
--

DROP TABLE IF EXISTS `gender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gender` (
  `genderid` int(11) NOT NULL AUTO_INCREMENT,
  `gender` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`genderid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gender`
--

LOCK TABLES `gender` WRITE;
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` VALUES (-1,'Please select...'),(1,'Male'),(2,'Female');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keyevent`
--

DROP TABLE IF EXISTS `keyevent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keyevent` (
  `keyeventid` int(11) NOT NULL,
  `keyevent` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`keyeventid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keyevent`
--

LOCK TABLES `keyevent` WRITE;
/*!40000 ALTER TABLE `keyevent` DISABLE KEYS */;
/*!40000 ALTER TABLE `keyevent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language` (
  `languageid` int(11) NOT NULL,
  `language` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`languageid`),
  CONSTRAINT `language_ibfk_1` FOREIGN KEY (`languageid`) REFERENCES `userlanguage` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language`
--

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;
/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marketgroup`
--

DROP TABLE IF EXISTS `marketgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marketgroup` (
  `marketgroupid` int(11) NOT NULL,
  `marketgroup` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`marketgroupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marketgroup`
--

LOCK TABLES `marketgroup` WRITE;
/*!40000 ALTER TABLE `marketgroup` DISABLE KEYS */;
/*!40000 ALTER TABLE `marketgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nationality`
--

DROP TABLE IF EXISTS `nationality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nationality` (
  `nationalityid` int(11) NOT NULL AUTO_INCREMENT,
  `nationality` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`nationalityid`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nationality`
--

LOCK TABLES `nationality` WRITE;
/*!40000 ALTER TABLE `nationality` DISABLE KEYS */;
INSERT INTO `nationality` VALUES (1,'Afghan'),(2,'Albanian'),(3,'Algerian'),(4,'American'),(5,'Andorran'),(6,'Angolan'),(7,'Antiguans'),(8,'Argentinean'),(9,'Armenian'),(10,'Australian'),(11,'Austrian'),(12,'Azerbaijani'),(13,'Bahamian'),(14,'Bahraini'),(15,'Bangladeshi'),(16,'Barbadian'),(17,'Barbudans'),(18,'Batswana'),(19,'Belarusian'),(20,'Belgian'),(21,'Belizean'),(22,'Beninese'),(23,'Bhutanese'),(24,'Bolivian'),(25,'Bosnian'),(26,'Brazilian'),(27,'British'),(28,'Bruneian'),(29,'Bulgarian'),(30,'Burkinabe'),(31,'Burmese'),(32,'Burundian'),(33,'Cambodian'),(34,'Cameroonian'),(35,'Canadian'),(36,'Cape Verdean'),(37,'Central African'),(38,'Chadian'),(39,'Chilean'),(40,'Chinese'),(41,'Colombian'),(42,'Comoran'),(43,'Congolese'),(44,'Costa Rican'),(45,'Croatian'),(46,'Cuban'),(47,'Cypriot'),(48,'Czech'),(49,'Danish'),(50,'Djibouti'),(51,'Dominican'),(52,'Dutch'),(53,'East Timorese'),(54,'Ecuadorean'),(55,'Egyptian'),(56,'Emirian'),(57,'Equatorial Guinean'),(58,'Eritrean'),(59,'Estonian'),(60,'Ethiopian'),(61,'Fijian'),(62,'Filipino'),(63,'Finnish'),(64,'French'),(65,'Gabonese'),(66,'Gambian'),(67,'Georgian'),(68,'German'),(69,'Ghanaian'),(70,'Greek'),(71,'Grenadian'),(72,'Guatemalan'),(73,'Guinea-Bissauan'),(74,'Guinean'),(75,'Guyanese'),(76,'Haitian'),(77,'Herzegovinian'),(78,'Honduran'),(79,'Hungarian'),(80,'I-Kiribati'),(81,'Icelander'),(82,'Indian'),(83,'Indonesian'),(84,'Iranian'),(85,'Iraqi'),(86,'Irish'),(87,'Israeli'),(88,'Italian'),(89,'Ivorian'),(90,'Jamaican'),(91,'Japanese'),(92,'Jordanian'),(93,'Kazakhstani'),(94,'Kenyan'),(95,'Kittian and Nevisian'),(96,'Kuwaiti'),(97,'Kyrgyz'),(98,'Laotian'),(99,'Latvian'),(100,'Lebanese'),(101,'Liberian'),(102,'Libyan'),(103,'Liechtensteiner'),(104,'Lithuanian'),(105,'Luxembourger'),(106,'Macedonian'),(107,'Malagasy'),(108,'Malawian'),(109,'Malaysian'),(110,'Maldivan'),(111,'Malian'),(112,'Maltese'),(113,'Marshallese'),(114,'Mauritanian'),(115,'Mauritian'),(116,'Mexican'),(117,'Micronesian'),(118,'Moldovan'),(119,'Monacan'),(120,'Mongolian'),(121,'Moroccan'),(122,'Mosotho'),(123,'Motswana'),(124,'Mozambican'),(125,'Namibian'),(126,'Nauruan'),(127,'Nepalese'),(128,'New Zealander'),(129,'Nicaraguan'),(130,'Nigerian'),(131,'Nigerien'),(132,'North Korean'),(133,'Northern Irish'),(134,'Norwegian'),(135,'Omani'),(136,'Pakistani'),(137,'Palauan'),(138,'Panamanian'),(139,'Papua New Guinean'),(140,'Paraguayan'),(141,'Peruvian'),(142,'Polish'),(143,'Portuguese'),(144,'Qatari'),(145,'Romanian'),(146,'Russian'),(147,'Rwandan'),(148,'Saint Lucian'),(149,'Salvadoran'),(150,'Samoan'),(151,'San Marinese'),(152,'Sao Tomean'),(153,'Saudi'),(154,'Scottish'),(155,'Senegalese'),(156,'Serbian'),(157,'Seychellois'),(158,'Sierra Leonean'),(159,'Singaporean'),(160,'Slovakian'),(161,'Slovenian'),(162,'Solomon Islander'),(163,'Somali'),(164,'South African'),(165,'South Korean'),(166,'Spanish'),(167,'Sri Lankan'),(168,'Sudanese'),(169,'Surinamer'),(170,'Swazi'),(171,'Swedish'),(172,'Swiss'),(173,'Syrian'),(174,'Taiwanese'),(175,'Tajik'),(176,'Tanzanian'),(177,'Thai'),(178,'Togolese'),(179,'Tongan'),(180,'Trinidadian or Tobagonian'),(181,'Tunisian'),(182,'Turkish'),(183,'Tuvaluan'),(184,'Ugandan'),(185,'Ukrainian'),(186,'Uruguayan'),(187,'Uzbekistani'),(188,'Venezuelan'),(189,'Vietnamese'),(190,'Welsh'),(191,'Yemenite'),(192,'Zambian'),(193,'Zimbabwean');
/*!40000 ALTER TABLE `nationality` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paylevel`
--

DROP TABLE IF EXISTS `paylevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paylevel` (
  `paylevelid` int(11) NOT NULL,
  `paylevel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`paylevelid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paylevel`
--

LOCK TABLES `paylevel` WRITE;
/*!40000 ALTER TABLE `paylevel` DISABLE KEYS */;
/*!40000 ALTER TABLE `paylevel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qualificationtype`
--

DROP TABLE IF EXISTS `qualificationtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qualificationtype` (
  `qualificationtypeid` int(11) NOT NULL,
  `qualificationtype` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`qualificationtypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qualificationtype`
--

LOCK TABLES `qualificationtype` WRITE;
/*!40000 ALTER TABLE `qualificationtype` DISABLE KEYS */;
/*!40000 ALTER TABLE `qualificationtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `roleid` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sector`
--

DROP TABLE IF EXISTS `sector`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sector` (
  `sectorid` int(11) NOT NULL,
  `sector` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sectorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sector`
--

LOCK TABLES `sector` WRITE;
/*!40000 ALTER TABLE `sector` DISABLE KEYS */;
/*!40000 ALTER TABLE `sector` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `statusid` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`statusid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suffix`
--

DROP TABLE IF EXISTS `suffix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suffix` (
  `suffixid` int(11) NOT NULL AUTO_INCREMENT,
  `suffix` varchar(20) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`suffixid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suffix`
--

LOCK TABLES `suffix` WRITE;
/*!40000 ALTER TABLE `suffix` DISABLE KEYS */;
INSERT INTO `suffix` VALUES (-1,'None',NULL),(1,'GBE ','Knight Grand Cross or Dame Grand Cross of the Most Excellent Order of the British Empire'),(2,'KBE ','Knight Commander of the Most Excellent Order of the British Empire'),(3,'DBE ','Dame Commander of the Most Excellent Order of the British Empire'),(4,'CBE ','Commander of the Most Excellent Order of the British Empire'),(5,'OBE ','Officer of the Most Excellent Order of the British Empire'),(6,'MBE ','Member of the Most Excellent Order of the British Empire'),(7,'Other',NULL);
/*!40000 ALTER TABLE `suffix` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `targetrole`
--

DROP TABLE IF EXISTS `targetrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `targetrole` (
  `userid` int(11) NOT NULL,
  `targetroleid` int(11) NOT NULL,
  `roleid` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `paylevelid` int(11) DEFAULT NULL,
  `primarysectorid` int(11) DEFAULT NULL,
  `titlesummary` varchar(50) DEFAULT NULL,
  `commentrequirement` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`userid`,`targetroleid`),
  KEY `primarysector` (`primarysectorid`),
  KEY `role` (`roleid`),
  KEY `paylevelid` (`paylevelid`),
  CONSTRAINT `targetrole_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  CONSTRAINT `targetrole_ibfk_4` FOREIGN KEY (`paylevelid`) REFERENCES `paylevel` (`paylevelid`),
  CONSTRAINT `targetrole_ibfk_5` FOREIGN KEY (`roleid`) REFERENCES `role` (`roleid`),
  CONSTRAINT `targetrole_ibfk_6` FOREIGN KEY (`primarysectorid`) REFERENCES `sector` (`sectorid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `targetrole`
--

LOCK TABLES `targetrole` WRITE;
/*!40000 ALTER TABLE `targetrole` DISABLE KEYS */;
/*!40000 ALTER TABLE `targetrole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `targetrolekeyevent`
--

DROP TABLE IF EXISTS `targetrolekeyevent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `targetrolekeyevent` (
  `userid` int(11) NOT NULL,
  `targetroleid` int(11) NOT NULL,
  `keyeventid` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`targetroleid`,`keyeventid`),
  KEY `keyevent` (`keyeventid`),
  CONSTRAINT `targetrolekeyevent_ibfk_1` FOREIGN KEY (`userid`, `targetroleid`) REFERENCES `targetrole` (`userid`, `targetroleid`),
  CONSTRAINT `targetrolekeyevent_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  CONSTRAINT `targetrolekeyevent_ibfk_4` FOREIGN KEY (`keyeventid`) REFERENCES `keyevent` (`keyeventid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `targetrolekeyevent`
--

LOCK TABLES `targetrolekeyevent` WRITE;
/*!40000 ALTER TABLE `targetrolekeyevent` DISABLE KEYS */;
/*!40000 ALTER TABLE `targetrolekeyevent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `title`
--

DROP TABLE IF EXISTS `title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `title` (
  `titleid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`titleid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `title`
--

LOCK TABLES `title` WRITE;
/*!40000 ALTER TABLE `title` DISABLE KEYS */;
INSERT INTO `title` VALUES (-1,'Please select...'),(1,'Dr'),(2,'Mr'),(3,'Mrs'),(4,'Ms'),(5,'Prof'),(6,'Other');
/*!40000 ALTER TABLE `title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `createddate` datetime DEFAULT NULL,
  `isocountryfromregip` varchar(5) DEFAULT NULL,
  `httpreferer` varchar(250) DEFAULT NULL,
  `emailverifycode` varchar(32) DEFAULT NULL,
  `passwordresetcode` varchar(32) DEFAULT NULL,
  `regipaddress` varchar(32) DEFAULT NULL,
  `locale` char(5) NOT NULL DEFAULT 'en_US',
  `activated` char(1) DEFAULT 'N',
  `titleid` int(11) DEFAULT NULL,
  `titleother` varchar(20) DEFAULT NULL,
  `forenames` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `suffixid` int(11) DEFAULT NULL,
  `suffixother` varchar(20) DEFAULT NULL,
  `genderid` int(11) DEFAULT NULL,
  `nationalityid` int(11) DEFAULT NULL,
  `profileimage` varchar(100) DEFAULT NULL,
  `pseudonym` varchar(20) DEFAULT NULL,
  `alternativeemail` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `mobile` varchar(100) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `addressid` int(11) DEFAULT NULL,
  `talentpoolsummary` text,
  `skills` text,
  `personalinterests` text,
  `whoswhosummary` text,
  `availabilityid` int(11) DEFAULT NULL,
  `marketgroupid` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `emailidx` (`email`),
  KEY `address` (`addressid`),
  KEY `marketgroup` (`marketgroupid`),
  KEY `speakeravailability` (`availabilityid`),
  KEY `nationality` (`nationalityid`),
  KEY `titleid` (`titleid`),
  KEY `genderid` (`genderid`),
  KEY `suffixid` (`suffixid`),
  CONSTRAINT `user_ibfk_10` FOREIGN KEY (`genderid`) REFERENCES `gender` (`genderid`),
  CONSTRAINT `user_ibfk_11` FOREIGN KEY (`suffixid`) REFERENCES `suffix` (`suffixid`),
  CONSTRAINT `user_ibfk_5` FOREIGN KEY (`titleid`) REFERENCES `title` (`titleid`),
  CONSTRAINT `user_ibfk_6` FOREIGN KEY (`availabilityid`) REFERENCES `availability` (`availabilityid`),
  CONSTRAINT `user_ibfk_7` FOREIGN KEY (`addressid`) REFERENCES `address` (`addressid`),
  CONSTRAINT `user_ibfk_8` FOREIGN KEY (`nationalityid`) REFERENCES `nationality` (`nationalityid`),
  CONSTRAINT `user_ibfk_9` FOREIGN KEY (`marketgroupid`) REFERENCES `marketgroup` (`marketgroupid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,'chris@netsensia.com','Chris','$2y$14$RaVPpqlkB.wHsa/o4zl3ROBFZzaH6nddOcfnay5QJSuhWlamr7f9q','2013-10-08 16:43:41',NULL,NULL,'LRjeDE1Y65zAko2g8oymapWisZcCqROT','0','127.0.0.1','en_US','Y',5,'','Chrismo','Moreton',NULL,-1,'',2,1,NULL,'','netadaptstorage@googlemail.com',NULL,NULL,NULL,14,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userexperience`
--

DROP TABLE IF EXISTS `userexperience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userexperience` (
  `userid` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `statusid` int(11) DEFAULT NULL,
  `experienceareaid` int(11) DEFAULT NULL,
  `committeerole` varchar(50) DEFAULT NULL,
  `fromdate` date DEFAULT NULL,
  `todate` date DEFAULT NULL,
  `userexperienceid` int(11) NOT NULL,
  PRIMARY KEY (`userexperienceid`),
  KEY `status` (`statusid`),
  KEY `area` (`experienceareaid`),
  KEY `userid` (`userid`),
  CONSTRAINT `userexperience_ibfk_3` FOREIGN KEY (`statusid`) REFERENCES `status` (`statusid`),
  CONSTRAINT `userexperience_ibfk_4` FOREIGN KEY (`experienceareaid`) REFERENCES `experiencearea` (`experiencearea`),
  CONSTRAINT `userexperience_ibfk_5` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userexperience`
--

LOCK TABLES `userexperience` WRITE;
/*!40000 ALTER TABLE `userexperience` DISABLE KEYS */;
/*!40000 ALTER TABLE `userexperience` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userlanguage`
--

DROP TABLE IF EXISTS `userlanguage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userlanguage` (
  `userid` int(11) NOT NULL,
  `languageid` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`languageid`),
  KEY `languageid` (`languageid`),
  CONSTRAINT `userlanguage_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userlanguage`
--

LOCK TABLES `userlanguage` WRITE;
/*!40000 ALTER TABLE `userlanguage` DISABLE KEYS */;
/*!40000 ALTER TABLE `userlanguage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userqualification`
--

DROP TABLE IF EXISTS `userqualification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userqualification` (
  `userid` int(11) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `qualificationtypeid` int(1) DEFAULT NULL,
  KEY `type` (`qualificationtypeid`),
  KEY `userid` (`userid`),
  CONSTRAINT `userqualification_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),
  CONSTRAINT `userqualification_ibfk_3` FOREIGN KEY (`qualificationtypeid`) REFERENCES `qualificationtype` (`qualificationtypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userqualification`
--

LOCK TABLES `userqualification` WRITE;
/*!40000 ALTER TABLE `userqualification` DISABLE KEYS */;
/*!40000 ALTER TABLE `userqualification` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-10-23 17:36:26
