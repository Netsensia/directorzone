/* 16:39:57 root@192.168.40.52 */ ALTER TABLE `usertargetrole` DROP FOREIGN KEY `usertargetrole_ibfk_7`;
/* 16:39:58 root@192.168.40.52 */ ALTER TABLE `usertargetrole` DROP FOREIGN KEY `usertargetrole_ibfk_6`;
/* 16:39:59 root@192.168.40.52 */ ALTER TABLE `usertargetrole` DROP FOREIGN KEY `usertargetrole_ibfk_5`;
/* 16:39:59 root@192.168.40.52 */ ALTER TABLE `usertargetrole` DROP FOREIGN KEY `usertargetrole_ibfk_4`;
/* 16:41:24 root@192.168.40.52 */ ALTER TABLE `usertargetrole` CHANGE `usertargetroleid` `usertargetroleid` INT(11)  NOT NULL  AUTO_INCREMENT;
