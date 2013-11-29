#!/bin/bash

cp config/autoload/netsensia.local.php.dist config/autoload/netsensia.local.php

sed -i 's/PASSWORD_SALT/abcde/g' config/autoload/netsensia.local.php

sed -i 's/MAXMIND_USERID//g' config/autoload/netsensia.local.php
sed -i 's/MAXMIND_LICENSEKEY//g' config/autoload/netsensia.local.php

sed -i 's/DB_SOURCE/mysql:host=localhost;dbname=directorzone_zf2/g' config/autoload/netsensia.local.php
sed -i 's/DB_USERNAME/root/g' config/autoload/netsensia.local.php
sed -i 's/DB_PASSWORD//g' config/autoload/netsensia.local.php

sed -i 's/SMTP_HOSTNAME/smtp.sendgrid.net/g' config/autoload/netsensia.local.php
sed -i 's/SMTP_PORT/587/g' config/autoload/netsensia.local.php
sed -i 's/SMTP_HOST/smtp.sendgrid.net/g' config/autoload/netsensia.local.php
sed -i 's/SMTP_USERNAME//g' config/autoload/netsensia.local.php
sed -i 's/SMTP_PASSWORD//g' config/autoload/netsensia.local.php
sed -i 's/EMAIL_SENDER_NAME/Netsensia ZF2 Skeleton/g' config/autoload/netsensia.local.php
sed -i 's/EMAIL_SENDER_ADDRESS/zf2@netsensia.com/g' config/autoload/netsensia.local.php

sed -i 's/SENTRY_URI//g' config/autoload/netsensia.local.php

rm -rf vendor
php composer.phar self-update
php composer.phar install --dev --no-progress