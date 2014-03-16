ALTER TABLE `directorzone_zf2`.`companydirectory` ADD COLUMN `isaccelerator` CHAR(1) DEFAULT 'N' NULL AFTER `canusefeedcache`;
ALTER TABLE `directorzone_zf2`.`companydirectory` CHANGE `isaccelerator` `companytypeid` INT NULL;
ALTER TABLE `directorzone_zf2`.`companydirectory` CHANGE `companytypeid` `companytypeid` INT(11) DEFAULT 1 NULL;
CREATE TABLE `directorzone_zf2`.`companytype`( `companytypeid` INT NOT NULL AUTO_INCREMENT, `companytype` VARCHAR(100), PRIMARY KEY (`companytypeid`) );
/*[18:57:35][3 ms]*/ INSERT INTO `directorzone_zf2`.`companytype` (`companytype`) VALUES ('Standard'); 
/*[18:58:00][2 ms]*/ INSERT INTO `directorzone_zf2`.`companytype` (`companytype`) VALUES ('Accelerator'); 
/*[18:58:05][3 ms]*/ INSERT INTO `directorzone_zf2`.`companytype` (`companytype`) VALUES ('Both'); 
UPDATE companydirectory SET companytypeid = 1 WHERE companytypeid = 0
