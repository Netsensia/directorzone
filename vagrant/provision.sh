#############################################################
# Ensure that we don't get prompted for any manual input
#############################################################
export DEBIAN_FRONTEND=noninteractive

#############################################################
# Set up deployment key
#############################################################
apt-get -y install git
eval `ssh-agent -s`
ssh-agent bash
ssh-add /home/vagrant/keys/id_rsa
ssh -o "StrictHostKeyChecking no" git@github.com

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
apt-get -y install openjdk-7-jre-headless mysql-server mysql-client git apache2 libapache2-mod-php5 curl php5-curl php5-mcrypt php5-xsl php5-ldap php5-mysql php5-gd php5-intl php5-json zip build-essential libssl-dev dos2unix

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
sed -i 's/memory_limit = 128M/memory_limit = 2048M/g' /etc/php5/cli/php.ini

#############################################################
# Make some modifications to my.cnf file
#############################################################
sed -i 's/^bind-address/#bind-address/g' /etc/mysql/my.cnf


#############################################################
# Install Elastic Search
#############################################################
wget https://download.elasticsearch.org/elasticsearch/elasticsearch/elasticsearch-0.90.5.deb
dpkg -i elasticsearch-0.90.5.deb

#############################################################
# Import database
#############################################################
wget https://dl.dropboxusercontent.com/u/63777076/VM/db_create.zip
unzip db_create.zip
mysql -uroot < db_create.sql
rm db_create.sql
rm db_create.zip
mysql -uroot -e "grant all on *.* to root@'%'"
sudo service mysql restart

#############################################################
# Install developer tools
#############################################################
apt-get -y install ant php-pear phpunit php5-xsl php5-dev openjdk-7-jdk
pear channel-discover pear.phpqatools.org
pear config-set auto_discover 1
pear install pear.phpunit.de/phploc
pear channel-discover pear.pdepend.org
pear channel-discover pear.phpmd.org
#pear install --alldeps phpmd/PHP_PMD
pear install pear.phpunit.de/PHP_Timer
pear install pear.phpunit.de/phpcpd
pear install --alldeps phpqatools/PHP_CodeBrowser
pear install --force --alldeps pear.phpunit.de/PHP_CodeCoverage
pear install --force --alldeps pear.phpunit.de/PHPUnit_MockObject
pear install pear.phpunit.de/phpdcd-0.9.3
pear upgrade-all

git config --global user.name "Chris Moreton"
git config --global user.email "chris@netsensia.com"

#############################################################
# Some clean up
#############################################################
rm /var/www/index.html
service apache2 restart

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
php /var/www/directorzone/public/index.php search-index

