<?php

return array(
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
                        )
                    )
                )
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
            'admin-members' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/members',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'members',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'details' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/:id',
                            'constraints' => ['id' => '[0-9]*'],
                            'defaults' => array(
                                'action'     => 'member-details',
                                'id' => 0,
                            ),
                        ),
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
            'admin-this-is-me-claims' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/this-is-me-claims',
                    'defaults' => array(
                        'controller' => 'Directorzone\Controller\Admin\Admin',
                        'action'     => 'this-is-me-claims',
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
        ),
    ),
);
