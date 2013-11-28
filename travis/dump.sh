mysqldump -uroot -p --add-drop-database --disable-keys --databases directorzone_zf2 > ../../db_create.sql
cd ../..
rm db_create.zip
zip db_create.zip db_create.sql
rm db_create.sql
mv db_create.zip /Users/chris/Dropbox/VM/db_create.zip


