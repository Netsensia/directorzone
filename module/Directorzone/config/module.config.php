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
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/api',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Api',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'lookup' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/lookup[/:resource]',
                            'defaults' => array(
                                'action' => 'lookup',
                            ),
                        ),
                    ),
                ),
            ),
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
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/upload',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Admin\Admin',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'upload-companies' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/companies',
                                    'defaults' => array(
                                        'controller' => 'Directorzone\Controller\Admin\Admin',
                                        'action' => 'upload-companies',
                                    ),
                                ),
                            ),
                            'upload-people' => array(
                                'type' => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route' => '/people',
                                    'defaults' => array(
                                        'action' => 'admin-people',
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
                    'whoswho' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/whoswho',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\WhosWho',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'action' => 'whos-who-list',
                                    ),
                                )
                            ),
                        ),
                    ),
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
                    'experience' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/experience',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Experience',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'history' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/history',
                                    'defaults' => array(
                                        'action' => 'get-history',
                                    ),
                                ),
                                'may_terminate' => false,
                                'child_routes' => array (
                                    'set-history' => array(
                                        'type' => 'method',
                                        'options' => array(
                                            'verb' => 'post',
                                            'defaults' => array(
                                                'action' => 'set-history',
                                            ),
                                        )
                                    ),                                
                                    'get-history' => array(
                                        'type' => 'method',
                                        'options' => array(
                                            'verb' => 'get',
                                            'defaults' => array(
                                                'action' => 'get-history',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            
                        ),
                    ),
                    'company-owners' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/company-owners',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\CompanyOwners',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'action' => 'company-owners-list',
                                    ),
                                )
                            ),
                            'switch' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/switch/:requestid',
                                    'defaults' => array (
                                        'action' => 'switch',
                                    )
                                ),
                            ),
                        ),
                    ),
                    'publish-options' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/publish-options[/:articlecategoryid]',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Article',
                                'action' => 'publish-options',
                            ),
                        ),
                    ),
                    'upload-company' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/upload-company',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Company',
                                'action' => 'upload-company',
                            ),
                        ),
                    ),
                    'send-message' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/send-message/:id[/:type]',
                            'constraints' => [
                                'id' => '[0-9]*',
                                'type' => '[0-9]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Messaging',
                                'action' => 'send-message',
                                'id' => 0,
                                'type' => 0,
                            ),
                        ),
                    ),
                    'delete-message' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/delete-message/:id',
                            'constraints' => [
                                'id' => '[0-9]*',
                                'type' => '[0-9]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Messaging',
                                'action' => 'delete-message',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'archive-message' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/archive-message/:id',
                            'constraints' => [
                                'id' => '[0-9]*',
                                'type' => '[0-9]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Messaging',
                                'action' => 'archive-message',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'unarchive-message' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/unarchive-message/:id',
                            'constraints' => [
                                'id' => '[0-9]*',
                                'type' => '[0-9]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Messaging',
                                'action' => 'unarchive-message',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'flag-message' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/flag-message/:id',
                            'constraints' => [
                                'id' => '[0-9]*',
                                'type' => '[0-9]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Messaging',
                                'action' => 'flag-message',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'unflag-message' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/unflag-message/:id',
                            'constraints' => [
                                'id' => '[0-9]*',
                                'type' => '[0-9]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Messaging',
                                'action' => 'unflag-message',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'filter-search' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/filter/search/:type/:searchtext',
                            'constraints' => [
                            'type' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'searchtext' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Filter',
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'add-comment' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/add-comment/:id',
                            'constraints' => [
                            'id' => '[0-9]*',
                            ],
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Comments',
                                'action' => 'add-comment',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'inbox' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/inbox/list',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\Messaging',
                                'action' => 'inbox',
                            ),
                        ),
                    ),
                    'talent-pool' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/talent-pool',
                            'defaults' => array(
                                'controller' => 'Directorzone\Controller\Ajax\TalentPool',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        'action' => 'talent-pool-list',
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
                            'events' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/events',
                                    'defaults' => array(
                                        'controller' => 'Directorzone\Controller\Ajax\Article',
                                        'action' => 'events',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'search' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/search',
                            'defaults' => array(
                                'controller' => 'AjaxSearch',
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'image-upload' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/image-upload',
                            'defaults' => array(
                                'controller' => 'AjaxImageUpload',
                                'action' => 'image-upload',
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
                        'may_terminate' => true,
                        'child_routes' => array(
                            'article-edit' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/edit',
                                    'defaults' => array(
                                        'action' => 'publish',
                                        'controller' => 'Directorzone\Controller\Account\Account',
                                    ),
                                ),
                            ),
                            'article-delete' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/delete',
                                    'defaults' => array(
                                        'action' => 'delete',
                                        'controller' => 'Article',
                                    ),
                                ),
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
                        'may_terminate' => true,
                        'child_routes' => array(
                            'article-list-page' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/page[/:page]',
                                    'constraints' => ['page' => '[0-9]*'],
                                ),
                            ),
                        ),
                   ),
                ),
            ),
            'anonymous' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/anonymous',
                    'defaults' => array(
                        'controller' => 'Directory',
                        'action'     => 'anonymous',
                    ),
                ),
            ),
            'public' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/public',
                    'defaults' => array(
                        'controller' => 'Directory',
                        'action'     => 'public',
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
                    'accelerator-directory' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/accelerator',
                            'defaults' => array(
                                'action' => 'accelerator-list',
                                'controller' => 'Directory',
                            ),
                        ),
                    ),
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
                            'company-directory-page' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/page[/:page]',
                                    'constraints' => ['page' => '[0-9]*'],
                                    'defaults' => array(
                                        'action' => 'company-list',
                                        'controller' => 'Directory',
                                    ),
                                ),
                            ),
                            'add-new-company' => array(
                                'type' => 'literal',
                                'options' => array(
                                    'route' => '/new',
                                    'defaults' => array(
                                        'action' => 'new-company',
                                        'controller' => 'CompanyEdit',
                                    ),
                                ),
                            ),
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
                                    'company-delete' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/delete',
                                            'defaults' => array(
                                                'action' => 'delete',
                                                'controller' => 'CompanyView',
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
                                                'controller' => 'CompanyOwners',
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
                                ), // child routes
                             ), // company details
                          ), // child routes
                    ), // company-directory
                    'people-directory' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/people',
                            'defaults' => array(
                                'controller' => 'Directory',
                                'action' => 'people-list',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'people-directory-page' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/page[/:page]',
                                    'constraints' => ['page' => '[0-9]*'],
                                    'defaults' => array(
                                        'action' => 'people-list',
                                        'controller' => 'Directory',
                                    ),
                                ),
                            ),
                            'people-details' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/:id',
                                    'constraints' => ['id' => '[0-9]*'],
                                    'defaults' => array(
                                        'action' => 'people-details',
                                        'controller' => 'PeopleView',
                                        'id' => 0,
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes' => array(
                                    'people-feeds' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/feeds',
                                            'defaults' => array(
                                                'action' => 'feeds',
                                                'controller' => 'PeopleEdit',
                                            ),
                                        ),
                                    ),
                                    'people-overview' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/overview',
                                            'defaults' => array(
                                                'action' => 'overview',
                                                'controller' => 'PeopleEdit',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'talent-pool' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/talent-pool',
                            'defaults' => array(
                                'controller' => 'Directory',
                                'action' => 'talent-pool-list',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'talent-pool-directory-page' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/page[/:page]',
                                    'constraints' => ['page' => '[0-9]*'],
                                    'defaults' => array(
                                        'action' => 'talent-pool-list',
                                        'controller' => 'Directory',
                                    ),
                                ),
                            ),
                            'talent-pool-details' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => '/:id',
                                    'constraints' => ['id' => '[0-9]*'],
                                    'defaults' => array(
                                        'action' => 'talent-pool-details',
                                        'controller' => 'TalentPoolView',
                                        'id' => 0,
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'events-calendar' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/events-calendar',
                    'defaults' => array(
                        'controller' => 'Event',
                        'action'     => 'calendar',
                    ),
                ),
            ),
            'search' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/search',
                    'defaults' => array(
                        'controller' => 'Search',
                        'action'     => 'search',
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
            'admin-company-owners' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/company-owners',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'company-owners',
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
                'may_terminate' => true,
                'child_routes' => array(
                    'my-articles-list-page' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/page[/:page]',
                            'constraints' => ['page' => '[0-9]*'],
                        ),
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
                'may_terminate' => true,
                'child_routes' => array(
                    'view-message' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/:id',
                            'constraints' => ['id' => '[0-9]*'],
                            'defaults' => array(
                                'action' => 'view-message',
                                'id' => 0,
                            ),
                        ),
                    ),
                    'inbox-page' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/page[/:page]',
                            'constraints' => ['page' => '[0-9]*'],
                        ),
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
                'whos-who-init' => array(
                    'options' => array(
                        'route'    => 'whos-who-init',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'whos-who-init',
                        ),
                    ),
                ),
                'populate-geography' => array(
                    'options' => array(
                        'route'    => 'populate-geography',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Geography',
                            'action'     => 'populate-geography',
                        ),
                    ),
                ),
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
                'index-company-directory' => array(
                    'options' => array(
                        'route'    => 'index-company-directory',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-company-directory',
                        ),
                    ),
                ),
                'index-company-officers' => array(
                    'options' => array(
                        'route'    => 'index-company-officers',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-company-officers',
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
