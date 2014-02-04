<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Directorzone\Controller\Account\Account' =>
                'Directorzone\Controller\Account\AccountController',
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
                        'controller' => 'Directorzone\Controller\Admin\Admin',
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
                    'people' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/people',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\People',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'action' => 'people-list',
                                    ),
                                )
                            ),
                        ),
                    ),
                    'article' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/article',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Article',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'action' => 'article-list',
                                    ),
                                )
                            ),
                        ),
                    ),
                    'search' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/search',
                            'defaults' => array(
                                'controller' => 'Search',
                                'action' => 'search',
                            ),
                        ),
                    ),
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
                            ),
                            'delete-uploaded' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/deleteuploaded',
                                    'defaults' => array(
                                        'action' => 'delete-uploaded',
                                    ),
                                )
                            ),
                            'make-live' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/makelive',
                                    'defaults' => array(
                                        'action' => 'make-live',
                                    ),
                                )
                            )
                        ),
                    )
                )
            ),
            'articles' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/article',
                    'defaults' => array(
                        'controller' => 'Article',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'article-details' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/:id',
                            'constraints' => ['id' => '[0-9]*'],
                            'defaults' => array(
                                'action' => 'index',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'article-list' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/list',
                            'defaults' => array(
                                'action' => 'list',
                            ),
                        ),
                   ),
                ),
            ),
            'directories' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/directories',
                    'defaults' => array(
                        'controller' => 'Directory',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'company-directory' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/company',
                            'defaults' => array(
                                'action' => 'company-list',
                                'controller' => 'Directory',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'company-details' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/:id',
                                    'constraints' => ['id' => '[0-9]*'],
                                    'defaults' => array(
                                        'action' => 'company-details',
                                        'controller' => 'CompanyView',
                                        'id' => 0,
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'company-contact' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/contact',
                                            'defaults' => array(
                                                'action' => 'contact',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                    'company-overview' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/overview',
                                            'defaults' => array(
                                                'action' => 'overview',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                    'company-feeds' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/feeds',
                                            'defaults' => array(
                                                'action' => 'feeds',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                    'company-financials' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/financials',
                                            'defaults' => array(
                                                'action' => 'financials',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                    'company-officers' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/officers',
                                            'defaults' => array(
                                                'action' => 'officers',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                    'company-owners' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/owners',
                                            'defaults' => array(
                                                'action' => 'owners',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                    'company-relationships' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/relationships',
                                            'defaults' => array(
                                                'action' => 'relationships',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                    'company-sectors' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/sectors',
                                            'defaults' => array(
                                                'action' => 'sectors',
                                                'controller' => 'CompanyEdit',
                                            ),
                                        ),
                                    ),
                                ),
                             ),
                          ),
                    ),
                    'people-directory' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/people',
                            'defaults' => array(
                                'controller' => 'Directory',
                                'action' => 'people-list',
                            ),
                        )
                    ),
                ),
            ),
            
            'admin-companies' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/companies',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'companies',
                    ),
                ),
            ),
            'admin-people' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/people',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'people',
                    ),
                ),
            ),
            'admin-users' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/users',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'users',
                    ),
                ),
            ),
            'admin-publishing' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/publishing',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'publishing',
                    ),
                ),
            ),
            'admin-data' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/data',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'data',
                    ),
                ),
            ),
            'admin-membership' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/membership',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'membership',
                    ),
                ),
            ),
            'admin-advertising' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/advertising',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'advertising',
                    ),
                ),
            ),
            'admin-pages' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/pages',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'pages',
                    ),
                ),
            ),
            'myaccount' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/myaccount',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'index',
                    ),
                ),
            ),
            'account-personal' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/personal',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'personal',
                    ),
                ),
            ),
            'account-profile' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/profile',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'profile',
                    ),
                ),
            ),
            'account-directory' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/directory',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'directory',
                    ),
                ),
            ),
            'account-contact' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/contact',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'contact',
                    ),
                ),
            ),
            'account-membership' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/membership',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'membership',
                    ),
                ),
            ),
            'account-account' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/account',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'account',
                    ),
                ),
            ),
            'account-publish' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/publish',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'publish',
                    ),
                ),
            ),
            'account-myarticles' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/myarticles',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'my-articles',
                    ),
                ),
            ),
            'account-inbox' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/inbox',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'inbox',
                    ),
                ),
            ),
            'account-preferences' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/preferences',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'preferences',
                    ),
                ),
            ),
            'account-experience' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/experience',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
                        'action'     => 'experience',
                    ),
                ),
            ),
            'account-company' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/myaccount/company',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Account\Account',
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
                'index-companies' => array(
                    'options' => array(
                        'route'    => 'index-companies',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-companies',
                        ),
                    ),
                ),
                'index-articles' => array(
                    'options' => array(
                        'route'    => 'index-articles',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-articles',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
