<?php
/**
 * 
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Http\PhpEnvironment\Request;
use Zend\Session\Container as SessionContainer;
use Netsensia\Model\Exception\KeyNotFoundException;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $request = new Request();
        $serverParams = $request->getServer();
        
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        
        $moduleRouteListener->attach($eventManager);
        
        $translator  = $e->getApplication()->getServiceManager()
                                           ->get('translator');
        
        $authService = $e->getApplication()->getServiceManager()
                                           ->get("AuthenticationService");
        
        if ($authService->hasIdentity()) {
            $userModel = $e->getApplication()->getServiceManager()
                                             ->get('UserModel')
                                             ->init($authService->getIdentity()->getUserId());

            try {
                $translator->setLocale($userModel->get('locale'));
            } catch (KeyNotFoundException $e) {
                // Something's not right - possibly the user row is no longer in
                // the database.  Clear the identity, this will trigger
                // logged-out behaviour
                // in the handling controller, and stop this code being executed
                // until a new login is performed.
                $authService->clearIdentity();
            }
        } else {
            
            $this->session = new SessionContainer('locale');

            if (isset($this->session->locale)) {
                $translator->setLocale($this->session->locale);
            } else {
                $acceptLanguage = $serverParams->get('HTTP_ACCEPT_LANGUAGE');
                if ($acceptLanguage == '') {
                    $locale = 'en_GB';
                } else {
                    $locale = \Locale::acceptFromHttp($acceptLanguage);
                }
                $translator->setLocale($locale);
            }
            $translator->setFallbackLocale('en_GB');
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
