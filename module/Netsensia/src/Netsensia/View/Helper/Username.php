<?php
namespace Netsensia\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\HelperPluginManager as ServiceManager;

class Username extends AbstractHelper 
{
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager) {
        $this->serviceManager = $serviceManager;
    }

    public function __invoke()
    {
        $authService = $this->serviceManager->get('Zend\Authentication\AuthenticationService');
        $identity = $authService->getIdentity();
        return $identity->getName();
    }
}
