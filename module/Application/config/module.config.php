<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 
                'Application\Controller\IndexController',
            'Application\Controller\Help' => 
                'Application\Controller\HelpController',
            'Application\Controller\Account' =>
                'Application\Controller\AccountController',            
        ),
    ),
    'router' => array(
        'routes' => array(
            
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            'myaccount' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/myaccount',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'index',
                    ),
                ),
            ),            

            'account-profile' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/profile',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'profile',
                    ),
                ),
            ),
            'account-contact' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/contact',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'contact',
                    ),
                ),
            ),
            'account-membership' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/membership',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'membership',
                    ),
                ),
            ),
            'account-account' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/account',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'account',
                    ),
                ),
            ),
            'account-publish' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/publish',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'publish',
                    ),
                ),
            ),
            'account-inbox' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/inbox',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'inbox',
                    ),
                ),
            ),
            'account-preferences' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/preferences',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'preferences',
                    ),
                ),
            ),
            'account-experience' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/experience',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'experience',
                    ),
                ),
            ),
            'account-company' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/company',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Account',
                        'action'     => 'company',
                    ),
                ),
            ),
        ),
    ),
    
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => array(
            
        ),
    ),
    
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout' => 
                __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => 
                __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => 
                __DIR__ . '/../view/error/404.phtml',
            'error/index'=> 
                __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'partial' => __DIR__ . '/../view/application/partials',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
