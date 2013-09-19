create database directorzone_zf2;
use directorzone_zf2;

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
`examplecolumn` char(20) DEFAULT NULL,
PRIMARY KEY (`userid`),
UNIQUE KEY `emailidx` (`email`)
);

CREATE TABLE feedback (
feedbackid int(11) NOT NULL AUTO_INCREMENT,
title varchar(50) DEFAULT NULL,
message text,
name varchar(50) DEFAULT NULL,
email varchar(50) DEFAULT NULL,
created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
replyto int(11) DEFAULT NULL,
status char(1) NOT NULL DEFAULT '',
feedbackcode int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (feedbackid)
);
