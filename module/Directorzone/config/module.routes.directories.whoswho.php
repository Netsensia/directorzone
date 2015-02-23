<?php

return array(
    'router' => array(
        'routes' => array(
            'directories' => array(
                'child_routes' => array(
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
                                    'this-is-me' => array(
                                        'type' => 'literal',
                                        'options' => array(
                                            'route' => '/this-is-me',
                                            'defaults' => array(
                                                'action' => 'this-is-me',
                                                'controller' => 'PeopleThisIsMe',
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
