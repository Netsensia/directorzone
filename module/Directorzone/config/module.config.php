<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Directorzone\Controller\Console\Company' =>
                'Directorzone\Controller\Console\CompanyController',
            'Directorzone\Controller\Console\Geography' =>
                'Directorzone\Controller\Console\GeographyController',
            'Directorzone\Controller\Api' =>
                'Directorzone\Controller\Api\ApiController',
        ),
    ),
    
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            'Directorzone\Factory\AbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
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
            'directorzone/index/index' =>
                __DIR__ . '/../view/directorzone/index/index.phtml',
            'error/404' =>
                __DIR__ . '/../view/error/404.phtml',
            'error/index'=>
                __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
            'partial' => __DIR__ . '/../view/directorzone/partials',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
