<?php


namespace Directorzone;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Request;

use Zend\Session\Container as SessionContainer;
use Directorzone\Form\AccountProfileForm;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AccountProfileForm' =>  function($sm) {
                    $form = new AccountProfileForm('accountProfileForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
            ),
        );
    }    
}
