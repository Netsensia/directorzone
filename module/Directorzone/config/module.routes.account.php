<?php

return array(
    'router' => array(
        'routes' => array(
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
);
