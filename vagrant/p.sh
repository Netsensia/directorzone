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

