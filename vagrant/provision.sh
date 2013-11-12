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
apt-get -y install mysql-server mysql-client git apache2 libapache2-mod-php5 curl php5-curl php5-mcrypt php5-xsl php5-ldap php5-mysql php5-gd php5-intl php5-json zip build-essential libssl-dev dos2unix

#############################################################
# Enable required Apache modules
#############################################################
a2enmod rewrite php5

#############################################################
# Setup Apache virtual hosts
#############################################################
cp /vagrant/VirtualHost/*.conf /etc/apache2/sites-available
a2ensite directorzone.conf
sh -c 'echo "127.0.0.1 directorzone.local" >> /etc/hosts'
sh -c 'echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf'

#############################################################
# Make some modifications to php.ini file
#############################################################
sed -i 's/display_errors = Off/display_errors = On/g' /etc/php5/apache2/php.ini
sed -i 's/;date.timezone =/date.timezone = Europe\/London/g' /etc/php5/apache2/php.ini
sed -i 's/;date.timezone =/date.timezone = Europe\/London/g' /etc/php5/cli/php.ini

#############################################################
# Install Elastic Search
#############################################################
cd /home/vagrant
wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-0.90.5.deb
apt-get install -y openjdk-7-jre-headless
dpkg -i elasticsearch-0.90.5.deb

#############################################################
# Import database
#############################################################
cd /home/vagrant
wget https://dl.dropboxusercontent.com/u/63777076/VM/db_create.zip
unzip db_create.zip
mysql -uroot < db_create.sql
rm db_create.sql

#############################################################
# Some clean up
#############################################################
rm /var/www/index.html
service apache2 restart

