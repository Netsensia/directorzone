<?php

return array(
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
        ),
    ),
);
