ALTER TABLE  `companyupload` ADD  `createdtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;
ALTER TABLE  `companieshouse` ADD  `createdtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

update `companyupload` set createdtime = DATE_SUB(NOW(), INTERVAL companyupload.companyuploadid SECOND);
update `companieshouse` set createdtime = DATE_SUB(NOW(), INTERVAL (companieshouse.companyid - 11901689) SECOND);
update `companydirectory` set createdtime = DATE_SUB(NOW(), INTERVAL companydirectory.companydirectoryid SECOND);
