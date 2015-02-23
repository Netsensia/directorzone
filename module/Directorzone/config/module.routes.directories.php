<?php

return array(
    'router' => array(
        'routes' => array(
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
        ),
    ),
);
