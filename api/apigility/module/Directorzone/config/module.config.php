<?php
return array(
    'router' => array(
        'routes' => array(
            'directorzone.rest.committeerole' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/committeerole[/:committeerole_id]',
                    'defaults' => array(
                        'controller' => 'Directorzone\\V1\\Rest\\Committeerole\\Controller',
                    ),
                ),
            ),
            'directorzone.rest.jobarea' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/jobarea[/:jobarea_id]',
                    'defaults' => array(
                        'controller' => 'Directorzone\\V1\\Rest\\Jobarea\\Controller',
                    ),
                ),
            ),
            'directorzone.rest.jobstatus' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/jobstatus[/:jobstatus_id]',
                    'defaults' => array(
                        'controller' => 'Directorzone\\V1\\Rest\\Jobstatus\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'directorzone.rest.committeerole',
            1 => 'directorzone.rest.jobarea',
            2 => 'directorzone.rest.jobstatus',
        ),
    ),
    'zf-rest' => array(
        'Directorzone\\V1\\Rest\\Committeerole\\Controller' => array(
            'listener' => 'Directorzone\\V1\\Rest\\Committeerole\\CommitteeroleResource',
            'route_name' => 'directorzone.rest.committeerole',
            'route_identifier_name' => 'committeerole_id',
            'collection_name' => 'committeerole',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Directorzone\\V1\\Rest\\Committeerole\\CommitteeroleEntity',
            'collection_class' => 'Directorzone\\V1\\Rest\\Committeerole\\CommitteeroleCollection',
            'service_name' => 'committeerole',
        ),
        'Directorzone\\V1\\Rest\\Jobarea\\Controller' => array(
            'listener' => 'Directorzone\\V1\\Rest\\Jobarea\\JobareaResource',
            'route_name' => 'directorzone.rest.jobarea',
            'route_identifier_name' => 'jobarea_id',
            'collection_name' => 'jobarea',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Directorzone\\V1\\Rest\\Jobarea\\JobareaEntity',
            'collection_class' => 'Directorzone\\V1\\Rest\\Jobarea\\JobareaCollection',
            'service_name' => 'jobarea',
        ),
        'Directorzone\\V1\\Rest\\Jobstatus\\Controller' => array(
            'listener' => 'Directorzone\\V1\\Rest\\Jobstatus\\JobstatusResource',
            'route_name' => 'directorzone.rest.jobstatus',
            'route_identifier_name' => 'jobstatus_id',
            'collection_name' => 'jobstatus',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Directorzone\\V1\\Rest\\Jobstatus\\JobstatusEntity',
            'collection_class' => 'Directorzone\\V1\\Rest\\Jobstatus\\JobstatusCollection',
            'service_name' => 'jobstatus',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Directorzone\\V1\\Rest\\Committeerole\\Controller' => 'HalJson',
            'Directorzone\\V1\\Rest\\Jobarea\\Controller' => 'HalJson',
            'Directorzone\\V1\\Rest\\Jobstatus\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Directorzone\\V1\\Rest\\Committeerole\\Controller' => array(
                0 => 'application/vnd.directorzone.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Directorzone\\V1\\Rest\\Jobarea\\Controller' => array(
                0 => 'application/vnd.directorzone.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Directorzone\\V1\\Rest\\Jobstatus\\Controller' => array(
                0 => 'application/vnd.directorzone.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Directorzone\\V1\\Rest\\Committeerole\\Controller' => array(
                0 => 'application/vnd.directorzone.v1+json',
                1 => 'application/json',
            ),
            'Directorzone\\V1\\Rest\\Jobarea\\Controller' => array(
                0 => 'application/vnd.directorzone.v1+json',
                1 => 'application/json',
            ),
            'Directorzone\\V1\\Rest\\Jobstatus\\Controller' => array(
                0 => 'application/vnd.directorzone.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Directorzone\\V1\\Rest\\Committeerole\\CommitteeroleEntity' => array(
                'entity_identifier_name' => 'committeeroleid',
                'route_name' => 'directorzone.rest.committeerole',
                'route_identifier_name' => 'committeerole_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Directorzone\\V1\\Rest\\Committeerole\\CommitteeroleCollection' => array(
                'entity_identifier_name' => 'committeeroleid',
                'route_name' => 'directorzone.rest.committeerole',
                'route_identifier_name' => 'committeerole_id',
                'is_collection' => true,
            ),
            'Directorzone\\V1\\Rest\\Jobarea\\JobareaEntity' => array(
                'entity_identifier_name' => 'jobareaid',
                'route_name' => 'directorzone.rest.jobarea',
                'route_identifier_name' => 'jobarea_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Directorzone\\V1\\Rest\\Jobarea\\JobareaCollection' => array(
                'entity_identifier_name' => 'jobareaid',
                'route_name' => 'directorzone.rest.jobarea',
                'route_identifier_name' => 'jobarea_id',
                'is_collection' => true,
            ),
            'Directorzone\\V1\\Rest\\Jobstatus\\JobstatusEntity' => array(
                'entity_identifier_name' => 'jobstatusid',
                'route_name' => 'directorzone.rest.jobstatus',
                'route_identifier_name' => 'jobstatus_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Directorzone\\V1\\Rest\\Jobstatus\\JobstatusCollection' => array(
                'entity_identifier_name' => 'jobstatusid',
                'route_name' => 'directorzone.rest.jobstatus',
                'route_identifier_name' => 'jobstatus_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-apigility' => array(
        'db-connected' => array(
            'Directorzone\\V1\\Rest\\Committeerole\\CommitteeroleResource' => array(
                'adapter_name' => 'Directorzone MySQL',
                'table_name' => 'committeerole',
                'hydrator_name' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
                'controller_service_name' => 'Directorzone\\V1\\Rest\\Committeerole\\Controller',
                'entity_identifier_name' => 'committeeroleid',
                'table_service' => 'Directorzone\\V1\\Rest\\Committeerole\\CommitteeroleResource\\Table',
            ),
            'Directorzone\\V1\\Rest\\Jobarea\\JobareaResource' => array(
                'adapter_name' => 'Directorzone MySQL',
                'table_name' => 'jobarea',
                'hydrator_name' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
                'controller_service_name' => 'Directorzone\\V1\\Rest\\Jobarea\\Controller',
                'entity_identifier_name' => 'jobareaid',
                'table_service' => 'Directorzone\\V1\\Rest\\Jobarea\\JobareaResource\\Table',
            ),
            'Directorzone\\V1\\Rest\\Jobstatus\\JobstatusResource' => array(
                'adapter_name' => 'Directorzone MySQL',
                'table_name' => 'jobstatus',
                'hydrator_name' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
                'controller_service_name' => 'Directorzone\\V1\\Rest\\Jobstatus\\Controller',
                'entity_identifier_name' => 'jobstatusid',
                'table_service' => 'Directorzone\\V1\\Rest\\Jobstatus\\JobstatusResource\\Table',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(),
    ),
);
