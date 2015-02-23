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
            ),
        ),
    ),
);
