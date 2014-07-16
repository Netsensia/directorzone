DROP TABLE IF EXISTS gn_geoname;

CREATE TABLE gn_geoname ( 
geonameid int PRIMARY KEY, 
name varchar(200), 
asciiname varchar(200), 
alternatenames varchar(4000), 
latitude decimal(10,7), 
longitude decimal(10,7), 
fclass char(1), 
fcode varchar(10), 
country varchar(2), 
cc2 varchar(60), 
admin1 varchar(20), 
admin2 varchar(80), 
admin3 varchar(20), 
admin4 varchar(20), 
population int, 
elevation int, 
gtopo30 int, 
timezone varchar(40), 
moddate date 
) CHARACTER SET utf8; 

DROP TABLE IF EXISTS gn_alternatename;

CREATE TABLE gn_alternatename ( 
alternatenameId int PRIMARY KEY, 
geonameid int, 
isoLanguage varchar(7), 
alternateName varchar(200), 
isPreferredName boolean, 
isShortName boolean, 
isColloquial boolean, 
isHistoric boolean 
) CHARACTER SET utf8; 

DROP TABLE IF EXISTS gn_countryInfo;

DROP TABLE IF EXISTS gn_countryInfo;

CREATE TABLE gn_countryInfo ( 
iso_alpha2 char(2), 
iso_alpha3 char(3), 
iso_numeric integer, 
fips_code character varying(3), 
name character varying(200), 
capital character varying(200), 
areainsqkm double precision, 
population integer, 
continent char(2), 
tld char(3), 
currency char(3), 
currencyName char(20), 
Phone char(10), 
postalCodeFormat char(20), 
postalCodeRegex char(20), 
geonameId int,
languages character varying(200), 
neighbours char(20), 
equivalentFipsCode char(10) 
) CHARACTER SET utf8; 


DROP TABLE IF EXISTS gn_iso_languagecodes;

CREATE TABLE gn_iso_languagecodes( 
iso_639_3 CHAR(4), 
iso_639_2 VARCHAR(50), 
iso_639_1 VARCHAR(50), 
language_name VARCHAR(200) 
) CHARACTER SET utf8; 

DROP TABLE IF EXISTS gn_admin1Codes;

CREATE TABLE gn_admin1Codes ( 
code CHAR(6), 
name TEXT 
) CHARACTER SET utf8; 

DROP TABLE IF EXISTS gn_admin1CodesAscii;

CREATE TABLE gn_admin1CodesAscii ( 
code CHAR(6), 
name TEXT, 
nameAscii TEXT, 
geonameid int 
) CHARACTER SET utf8; 

DROP TABLE IF EXISTS gn_featureCodes;

CREATE TABLE gn_featureCodes ( 
code CHAR(7), 
name VARCHAR(200), 
description TEXT 
) CHARACTER SET utf8; 

DROP TABLE IF EXISTS gn_timeZones;

CREATE TABLE gn_timeZones ( 
timeZoneId VARCHAR(200), 
GMT_offset DECIMAL(3,1), 
DST_offset DECIMAL(3,1) 
) CHARACTER SET utf8; 

DROP TABLE IF EXISTS gn_continentCodes;

CREATE TABLE gn_continentCodes ( 
code CHAR(2), 
name VARCHAR(20), 
geonameid INT 
) CHARACTER SET utf8; 


LOAD DATA LOCAL INFILE '/Users/chris/git/geography/allCountries.txt' INTO TABLE gn_geoname (geonameid,name,asciiname,alternatenames,latitude,longitude,fclass,fcode,country,cc2, admin1,admin2,admin3,admin4,population,elevation,gtopo30,timezone,moddate); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/alternateNames.txt' INTO TABLE gn_alternatename (alternatenameid,geonameid,isoLanguage,alternateName,isPreferredName,isShortName,isColloquial,isHistoric); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/iso-languagecodes.txt' INTO TABLE gn_iso_languagecodes (iso_639_3, iso_639_2, iso_639_1, language_name); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/admin1Codes.txt' INTO TABLE gn_admin1CodesASCII (code, name); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/admin1CodesAscii.txt' INTO TABLE gn_admin1CodesAscii (code, name, nameAscii, geonameid); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/featureCodes_en.txt' INTO TABLE gn_featureCodes (code, name, description); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/timeZones.txt' INTO TABLE gn_timeZones IGNORE 1 LINES (timeZoneId, GMT_offset, DST_offset); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/countryInfo-n.txt' INTO TABLE gn_countryInfo IGNORE 1 LINES (iso_alpha2,iso_alpha3,iso_numeric,fips_code,name,capital,areaInSqKm,population,continent,languages,currency,geonameId); 
LOAD DATA LOCAL INFILE '/Users/chris/git/geography/continentCodes.txt' INTO TABLE gn_continentCodes FIELDS TERMINATED BY ',' (code, name, geonameId); 

/* 10:52:16 root@directorzone.local */ ALTER TABLE `gn_geoname` ADD INDEX (`country`, `admin1`);

