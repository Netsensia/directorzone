<?php

return array(
    'router' => array(
        'routes' => array(
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
            
        ),
    ),
);
