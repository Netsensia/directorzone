# Netsensia Zend Framework 2 Skeleton

## Overview

This is the skeleton I use to create new PDO-based ZF2 applications.  

It provides me with a working website scaffold with user registration and authentication plus various helper functions and base classes that make getting up-and-running with a new project considerably easier for me (e.g. email sending, model persistence, exception logging, locale/translation helpers).

It is based on the [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication) which was my primary source of learning when beginning with the framework.

* [Demo site](http://zf2.netsensia.com/)
* [Travis CI build](https://travis-ci.org/Netsensia/netsensia-zf2-skeleton) [![Build Status](https://travis-ci.org/Netsensia/netsensia-zf2-skeleton.png)](http://travis-ci.org/Netsensia/netsensia-zf2-skeleton)
* [Jenkins build with code coverage and static analysis](http://ci.netsensia.com/job/NETSENSIA-ZF2-SKELETON/)

It makes use the following external services:

* [reCAPTCHA](http://www.google.com/recaptcha/captcha)
* [MaxMind](http://www.maxmind.com/en/geolocation_landing)
* [Sentry](https://getsentry.com/welcome/)

Todo next

* User administration
* Inbound parse code for [SendGrid](http://sendgrid.com/docs/API_Reference/Webhooks/parse.html) SMTP accounts
* Feedback management
 
Todo later

* Forums - perhaps from an existing ZF2 module
* User-to-user messaging infrastructure
* MIS dashboard

## Setting up

### Set up virtual host

This setup ensures that that .htaccess file is used in the public folder to redirect all requests through index.php
so that the output can be constructed by the framework by calling the appropriate action on the appropriate controller
and passing any parameters that are extracted from the URL path.

    <VirtualHost *:80>
        ServerName netsensia-zf2-skeleton.local
        DocumentRoot "/path/to/netsensia-zf2-skeleton\public"
        SetEnv APPLICATION_ENV development
        
        <Directory "/path/to/netsensia-zf2-skeleton\public">
            Options ExecCGI FollowSymLinks Includes MultiViews
            AllowOverride all
            Order Allow,Deny
            Allow from all
    	</Directory>
    </VirtualHost>

### Run composer

Go to root directory of project

    php composer.phar self-update
    php composer.phar install --dev
   
This installs the Zend Framework and other dependencies specified in composer.json.  It will also set up all the autoloading logic within the vendor/autoload.php file, which is included by default by ZF2.

### Create and configure database

#### Create project database

Locate the *travis/db_create.sql* script.

Change the database name to one of your choosing, then run the script against MySQL.

You should then create a user and password to be used by your application to connect.

    grant all on yourdatabasename.* to yourusername@localhost identified by 'yourpassword';

### Create config files

Copy config/autoload/netsensia.local.php.dist to config/autoload/netsensia.local.php and fill in the values where there are block capital placeholders.

Where you do not have details, please remove the placeholder and leave an empty string in its place.

#### Run the unit tests

To make sure everything is working, go into the tests/ directory and run the test suite

    cd tests
    phpunit (or php phpunit.phar if phpunit not installed)
    
    
