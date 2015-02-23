<?php

return array(
    'router' => array(
        'routes' => array(
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
        ),
    ),
);
