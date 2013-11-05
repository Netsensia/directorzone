<?php

date_default_timezone_set('Europe/London');
error_reporting(E_ALL|E_STRICT);
ini_set('log_errors', true);

/**
* Display all errors when APPLICATION_ENV is development.
*/
if (isset($_SERVER['APPLICATION_ENV'])) {
    if ($_SERVER['APPLICATION_ENV'] == 'development') {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }
}
    
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
