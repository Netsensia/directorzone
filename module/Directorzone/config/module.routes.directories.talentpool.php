<?php

return array(
    'router' => array(
        'routes' => array(
            'directories' => array(
                'child_routes' => array(
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
        ),
    ),
);
