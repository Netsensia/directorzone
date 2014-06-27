/* 14:30:38 root@192.168.40.52 */ CREATE TABLE `userprofessionalqualification` (   `userqualificationid` int(11) NOT NULL,   `userid` int(11) NOT NULL,   `qualification` varchar(100) DEFAULT NULL,   `subject` varchar(100) DEFAULT NULL,   `qualificationtypeid` int(1) DEFAULT NULL,   PRIMARY KEY (`userqualificationid`),   KEY `type` (`qualificationtypeid`),   KEY `userid` (`userid`),   FOREIGN KEY (`userid`) REFERENCES `user` (`userid`),   FOREIGN KEY (`qualificationtypeid`) REFERENCES `qualificationtype` (`qualificationtypeid`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/* 14:30:38 root@192.168.40.52 */ SET NAMES 'utf8';
/* 14:30:38 root@192.168.40.52 */ SHOW TABLE STATUS LIKE 'userprofessionalqualification';
/* 14:30:38 root@192.168.40.52 */ SHOW CREATE TABLE `userprofessionalqualification`;
/* 14:30:38 root@192.168.40.52 */ SET NAMES 'latin1';
/* 14:30:38 root@192.168.40.52 */ SELECT * FROM `userprofessionalqualification` LIMIT 0,1000;
/* 14:30:40 root@192.168.40.52 */ SHOW INDEX FROM `userprofessionalqualification`;
/* 14:30:40 root@192.168.40.52 */ SHOW VARIABLES LIKE 'collation_database';
/* 14:30:48 root@192.168.40.52 */ ALTER TABLE `userprofessionalqualification` CHANGE `userqualificationid` `userprofessionalqualificationid` INT(11)  NOT NULL;
