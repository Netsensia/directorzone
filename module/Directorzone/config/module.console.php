<?php

return array(
'console' => array(
        'router' => array(
            'routes' => array(
                'update-companies' => array(
                    'options' => array(
                        'route'    => 'update-companies',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'update-companies',
                        ),
                    ),
                ),
                'whos-who-init' => array(
                    'options' => array(
                        'route'    => 'whos-who-init',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'whos-who-init',
                        ),
                    ),
                ),
                'populate-geography' => array(
                    'options' => array(
                        'route'    => 'populate-geography',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Geography',
                            'action'     => 'populate-geography',
                        ),
                    ),
                ),
                'ingest' => array(
                    'options' => array(
                        'route'    => 'ingest',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest',
                        ),
                    ),
                ),
                'ingest-officers' => array(
                    'options' => array(
                        'route'    => 'officers',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest-officers',
                        ),
                    ),
                ),
                'ingest-company-details' => array(
                    'options' => array(
                        'route'    => 'details',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest-company-details',
                        ),
                    ),
                ),
                'ingest-company-details-from-csv' => array(
                    'options' => array(
                        'route'    => 'csv',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'ingest-from-csv',
                        ),
                    ),
                ),
                'index-companies' => array(
                    'options' => array(
                        'route'    => 'index-companies',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-companies',
                        ),
                    ),
                ),
                'index-company-directory' => array(
                    'options' => array(
                        'route'    => 'index-company-directory',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-company-directory',
                        ),
                    ),
                ),
                'index-company-officers' => array(
                    'options' => array(
                        'route'    => 'index-company-officers',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-company-officers',
                        ),
                    ),
                ),
                'index-articles' => array(
                    'options' => array(
                        'route'    => 'index-articles',
                        'defaults' => array(
                            'controller' => 'Directorzone\Controller\Console\Company',
                            'action'     => 'index-articles',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
