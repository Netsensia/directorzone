#############################################################
# Ensure that we don't get prompted for any manual input
#############################################################
export DEBIAN_FRONTEND=noninteractive

#############################################################
# Necessary system updates to get PHP 5.5 rather than default 5.3
#############################################################
apt-get -y update
apt-get -y install python-software-properties
add-apt-repository -y ppa:ondrej/php5
apt-get -y update
apt-get -y install php5

#############################################################
# Install other dependencies
#############################################################
apt-get -y install openjdk-7-jre-headless mysql-server mysql-client apache2 libapache2-mod-php5 curl php5-curl
apt-get -y install php5-mcrypt php5-xsl php5-ldap php5-mysql php5-gd php5-intl php5-json zip build-essential libssl-dev
apt-get -y install imagemagick php5-imagick npm

#############################################################
# Enable required Apache modules
#############################################################
a2enmod rewrite php5

#############################################################
# Make some modifications to php.ini file
#############################################################
sed -i 's/display_errors = Off/display_errors = On/g' /etc/php5/apache2/php.ini
sed -i 's/;date.timezone =/date.timezone = Europe\/London/g' /etc/php5/apache2/php.ini
sed -i 's/;date.timezone =/date.timezone = Europe\/London/g' /etc/php5/cli/php.ini
sed -i 's/disable_functions/;disable_functions/g' /etc/php5/cli/php.ini
sed -i 's/memory_limit = 128M/memory_limit = 512M/g' /etc/php5/cli/php.ini

#############################################################
# Make some modifications to my.cnf file
#############################################################
sed -i 's/^bind-address/#bind-address/g' /etc/mysql/my.cnf

#############################################################
# Install Elastic Search
#############################################################
wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-0.90.11.deb
dpkg -i elasticsearch-0.90.11.deb

#############################################################
# Import database
#############################################################
echo "Downloading database..."
wget https://dl.dropboxusercontent.com/u/63777076/VM/db_create.zip
echo "Unzipping..."
unzip db_create.zip
echo "Importing..."
mysql -uroot < db_create.sql
rm db_create.sql
rm db_create.zip
mysql -uroot -e "grant all on *.* to root@'%'"
echo "Restarting MySQL"
sudo service mysql restart

#############################################################
# Some clean up
#############################################################
rm /var/www/index.html
service apache2 restart

#############################################################
# Compile Node.js from source - package version is too old
#############################################################
cd /usr/local/src
mkdir node
cd node
wget http://nodejs.org/dist/v0.10.21/node-v0.10.21.tar.gz
tar -xzvf node-v0.10.21.tar.gz
cd node-v0.10.21
./configure
make
make install
ln -s /usr/bin/nodejs /usr/bin/node

#############################################################
# Install bootstrap calendar
#############################################################
cd /var/www/directorzone/public
apt-get -y install git
npm install -g bower
bower install bootstrap-calendar

#############################################################
# Setup Apache virtual hosts
#############################################################
cp /var/www/directorzone/vagrant/VirtualHost/*.conf /etc/apache2/sites-available
a2ensite directorzone.conf
service apache2 reload
sh -c 'echo "127.0.0.1 directorzone.local" >> /etc/hosts'
sh -c 'echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf'

#############################################################
# Set up phpmyadmin
#############################################################
apt-get -q -y install phpmyadmin
a2ensite phpmyadmin.conf
cp /var/www/directorzone/vagrant/VirtualHost/.htpasswd /var/www

#############################################################
# Set up search index
#############################################################
cd /var/www/directorzone
php public/index.php index-company-directory
php public/index.php index-articles
php public/index.php index-companies
php public/index.php index-company-officers

sh -c 'echo "echo 1 > /proc/sys/vm/drop_caches" >> /home/vagrant/drop_caches'
sudo chmod +x /home/vagrant/drop_caches

echo 100 > /proc/sys/vm/dirty_expire_centisecs
echo 100 > /proc/sys/vm/dirty_writeback_centisecs

