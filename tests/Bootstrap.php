<?php 

namespace TestSuite;

define('DEVELOPMENT_ENVIRONMENT', true);
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', true);
ini_set('log_errors', false);

chdir(dirname(__DIR__));

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;
use RuntimeException;

class Bootstrap
{
    protected static $config;
    protected static $bootstrap;

    public static function init()
    {
        date_default_timezone_set('Europe/London');
        
        if (is_readable(__DIR__ . '/TestConfig.php')) {
            $testConfig = include __DIR__ . '/TestConfig.php';
        } else {
            $testConfig = include __DIR__ . '/TestConfig.php.dist';
        }
        
        $zfModulePaths = array();

        if (isset($testConfig['module_listener_options']['module_paths'])) {
            $modulePaths = $testConfig['module_listener_options']['module_paths'];
            foreach ($modulePaths as $modulePath) {
                if (($path = static::findParentPath($modulePath)) ) {
                    $zfModulePaths[] = $path;
                }
            }
        }

        $zfModulePaths  = implode(PATH_SEPARATOR, $zfModulePaths) . PATH_SEPARATOR;
        $zfModulePaths .= getenv('ZF2_MODULES_TEST_PATHS') ?: (defined('ZF2_MODULES_TEST_PATHS') ? ZF2_MODULES_TEST_PATHS : '');

        static::initAutoloader();

        $baseConfig = array(
            'module_listener_options' => array(
                'module_paths' => explode(PATH_SEPARATOR, $zfModulePaths),
            ),
        );
        
        $config = ArrayUtils::merge($baseConfig, $testConfig);

        static::$config = $config;
    }

    public static function initDatabase()
    {
        $serviceManager = self::getServiceManager();
        
        $userService = $serviceManager->get('Netsensia\Service\UserService');
        $testUserId = $userService->getUserIdFromEmail('test@netsensia.com');
        
        if ($testUserId) {
            $testUserModel = $serviceManager->get('UserModel')->init($testUserId);
            $testUserModel->set('password', '$2y$14$cBKJD3NnF6L4FuuEN7P1fOOepHEX5iN1XCA9U3.4SAIYGAUq5a6Iy');
            $testUserModel->save();
        } else {
            $testUserModel = $serviceManager->get('UserModel')->init();
            $testUserModel->setData(
                [
                    'email'=>'test@netsensia.com',
                    'password'=>'$2y$14$cBKJD3NnF6L4FuuEN7P1fOOepHEX5iN1XCA9U3.4SAIYGAUq5a6Iy',
                ]
            );
            $newUserId = $testUserModel->create();
        }
    }
    
    public static function getServiceManager()
    {
        $serviceManager = new ServiceManager(new ServiceManagerConfig(
            isset(static::$config['service_manager']) ? static::$config['service_manager'] : array()
        ));
        $serviceManager->setService('ApplicationConfig', static::$config);
        $serviceManager->setFactory('ServiceListener', 'Zend\Mvc\Service\ServiceListenerFactory');
    
        /** @var $moduleManager \Zend\ModuleManager\ModuleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();
    
        $serviceManager->setAllowOverride(true);
        return $serviceManager;
    }
    
    public static function getConfig()
    {
        return static::$config;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        if (is_readable($vendorPath . '/autoload.php')) {
            $loader = include $vendorPath . '/autoload.php';
        } else {
            $zf2Path = getenv('ZF2_PATH') ?: (defined('ZF2_PATH') ? ZF2_PATH : (is_dir($vendorPath . '/ZF2/library') ? $vendorPath . '/ZF2/library' : false));

            if (!$zf2Path) {
                throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
            }

            include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';

        }

        AutoloaderFactory::factory(array(
                'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) return false;
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
    
}

Bootstrap::init();
