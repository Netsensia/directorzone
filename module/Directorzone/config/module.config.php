<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Directorzone\Controller\Account' =>
                'Directorzone\Controller\AccountController',
            'Directorzone\Controller\Content' =>
                'Directorzone\Controller\ContentController',
            'Directorzone\Controller\Directory' =>
                'Directorzone\Controller\DirectoryController',
            'Directorzone\Controller\Console\Company' =>
                'Directorzone\Controller\Console\CompanyController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'admin-upload' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/upload',
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'upload-companies' => array(
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route' => '/companies',
                                    'defaults' => array(
                                        'action' => 'upload-companies',
                                    ),
                                ),
                            )
                        )
                    )
                )
            ),
            'ajax' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ajax',
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'company' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/company',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Company',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'action' => 'company-list',
                                    ),
                                )
                            ),
                            'search' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/search',
                                    'defaults' => array(
                                        'action' => 'company-search',
                                    ),
                                )
                            ),
                            'update-status' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/updateuploadstatus',
                                    'defaults' => array(
                                        'action' => 'update-upload-status',
                                    ),
                                )
                            )
                        ),
                    )
                )

            ),
            'content' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/content',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Content',
                        'action'     => 'index',
                    ),
                ),
            ),
            'directories' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/myaccount',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Directory',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            'admin-companies' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/companies',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'companies',
                    ),
                ),
            ),
            'admin-people' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/people',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'people',
                    ),
                ),
            ),
            'admin-users' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/users',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'users',
                    ),
                ),
            ),
            'admin-publishing' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/publishing',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'publishing',
                    ),
                ),
            ),
            'admin-data' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/data',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'data',
                    ),
                ),
            ),
            'admin-membership' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/membership',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'membership',
                    ),
                ),
            ),
            'admin-advertising' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/advertising',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'advertising',
                    ),
                ),
            ),
            'admin-pages' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/pages',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin',
                        'action'     => 'pages',
                    ),
                ),
            ),
            'myaccount' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/myaccount',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'index',
                    ),
                ),
            ),
            'account-personal' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/personal',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'personal',
                    ),
                ),
            ),
            'account-profile' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/profile',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'profile',
                    ),
                ),
            ),
            'account-directory' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/directory',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'directory',
                    ),
                ),
            ),
            'account-contact' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/contact',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'contact',
                    ),
                ),
            ),
            'account-membership' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/membership',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'membership',
                    ),
                ),
            ),
            'account-account' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/account',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'account',
                    ),
                ),
            ),
            'account-publish' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/publish',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'publish',
                    ),
                ),
            ),
            'account-inbox' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/inbox',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'inbox',
                    ),
                ),
            ),
            'account-preferences' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/preferences',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'preferences',
                    ),
                ),
            ),
            'account-experience' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/experience',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
                        'action'     => 'experience',
                    ),
                ),
            ),
            'account-company' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/company',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account',
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
    
    'console' => array(
        'router' => array(
            'routes' => array(
                'ingest' => array(
                    'options' => array(
                        'route'    => 'ingest',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest',
                        ),
                    ),
                ),
                'ingest-officers' => array(
                    'options' => array(
                        'route'    => 'officers',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest-officers',
                        ),
                    ),
                ),
                'ingest-company-details' => array(
                    'options' => array(
                        'route'    => 'details',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest-company-details',
                        ),
                    ),
                ),
                'ingest-company-details-from-csv' => array(
                    'options' => array(
                        'route'    => 'csv',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest-from-csv',
                        ),
                    ),
                ),
                'search-index' => array(
                    'options' => array(
                        'route'    => 'search-index',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'search-index',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
