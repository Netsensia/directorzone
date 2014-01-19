#!/bin/bash

cp config/autoload/netsensia.local.php.dist config/autoload/netsensia.local.php

sed -i 's/MAXMIND_USERID/76230/g' config/autoload/netsensia.local.php
sed -i 's/MAXMIND_LICENSEKEY/CC6U2jxgftOA/g' config/autoload/netsensia.local.php

sed -i 's/DB_SOURCE/mysql:host=localhost;dbname=directorzone_zf2/g' config/autoload/netsensia.local.php
sed -i 's/DB_USERNAME/skelly/g' config/autoload/netsensia.local.php
sed -i 's/DB_PASSWORD/password/g' config/autoload/netsensia.local.php

sed -i 's/SMTP_HOSTNAME/smtp.sendgrid.net/g' config/autoload/netsensia.local.php
sed -i 's/SMTP_PORT/587/g' config/autoload/netsensia.local.php
sed -i 's/SMTP_HOST/smtp.sendgrid.net/g' config/autoload/netsensia.local.php
sed -i 's/SMTP_USERNAME/opglpa/g' config/autoload/netsensia.local.php
sed -i 's/SMTP_PASSWORD/opglpadog90987/g' config/autoload/netsensia.local.php
sed -i 's/EMAIL_SENDER_NAME/Directorzone/g' config/autoload/netsensia.local.php
sed -i 's/EMAIL_SENDER_ADDRESS/directorzone@netsensia.com/g' config/autoload/netsensia.local.php

sed -i 's/CAPTCHA_PRIVATE_KEY/6Lcmv9wSAAAAAF2kwRoHIspudnUJY4pxiVjHUwzj/g' config/autoload/netsensia.local.php
sed -i 's/CAPTCHA_PUBLIC_KEY/6Lcmv9wSAAAAABQTxbhjX5KpT-W8jrz0bO87tZw0/g' config/autoload/netsensia.local.php

sed -i 's/SENTRY_URI/https:\/\/8b8171bf0a5848a096b707e0af62193a:390e9a57f9864254bd98636ec5b38755@app.getsentry.com\/11087/g' config/autoload/netsensia.local.php

cp config/autoload/local.php.dist config/autoload/local.php
sed -i 's/CH_SENDER_ID/55929018299358273807663349255503/g' config/autoload/local.php
sed -i 's/CH_PASSWORD/8beehnuxsbwlucey3gq84qt1871hisw9/g' config/autoload/local.php
sed -i 's/CH_EMAIL/rbryan@city-zone.com/g' config/autoload/local.php




