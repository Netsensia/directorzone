<?php

return array(
    'router' => array(
        'routes' => array(
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
        ),
    ),
);
