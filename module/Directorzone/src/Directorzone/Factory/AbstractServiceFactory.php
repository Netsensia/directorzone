<?php
namespace Directorzone\Factory;
 
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LondonTennis\Api\Client\Client;
use Application\Service\ApiAwareService;
 
class AbstractServiceFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $className = 'Directorzone\Service\\' . $requestedName;
        
        if (class_exists($className)) {
            return true;
        }
 
        return false;
    }
 
    public function createServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName)
    {
        $className = 'Directorzone\Service\\' . $requestedName;
        $service = new $className;
        
        return $service;
    }

}