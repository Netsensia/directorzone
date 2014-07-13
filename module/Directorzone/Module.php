<?php

namespace Directorzone;

use Zend\Mvc\MvcEvent;

use Directorzone\Form\Account\AccountPublishForm;
use Elasticsearch\Client as ElasticClient;
use Zend\Db\TableGateway\TableGateway;
use \Zend\Mvc\Controller\ControllerManager;
use Directorzone\Service\CompanyService;
use Directorzone\Service\Admin\CompanyUploadService;
use Directorzone\Service\PeopleService;
use Directorzone\Service\TwitterService;
use Directorzone\Service\BingService;
use Directorzone\Service\ArticleService;
use Directorzone\Service\TalentPoolService;
use Directorzone\Service\FilterService;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'AjaxImageUpload' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\ImageUploadController(
            	            $cm->getServiceLocator()->get('ImageService')
                        );
                    },
                'Directorzone\Controller\Admin\Admin' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Admin\AdminController(
                            $cm->getServiceLocator()->get('CompanyService'),
                            $cm->getServiceLocator()->get('PeopleService')
                        );
                    },
                'Directorzone\Controller\Ajax\Company' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\CompanyController(
                            $cm->getServiceLocator()->get('CompanyService'),
                            $cm->getServiceLocator()->get('ElasticService')
                        );
                    },
                'Directorzone\Controller\Ajax\People' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\PeopleController(
                            $cm->getServiceLocator()->get('PeopleService')
                        );
                    },
                'Directorzone\Controller\Ajax\TalentPool' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\TalentPoolController(
                            $cm->getServiceLocator()->get('TalentPoolService')
                        );
                },
                'Directorzone\Controller\Ajax\Messaging' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\MessagingController(
                            $cm->getServiceLocator()->get('MessagingService')
                        );
                    },
                'Directorzone\Controller\Ajax\Comments' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\CommentsController(
                            $cm->getServiceLocator()->get('CommentsService')
                        );
                    },
                'Directorzone\Controller\Ajax\Article' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\ArticleController(
                            $cm->getServiceLocator()->get('ArticleService'),
                            $cm->getServiceLocator()->get('ElasticService')
                        );
                    },
                'Directory' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\DirectoryController(
                            $cm->getServiceLocator()->get('CompanyService')
                        );
                    },
                'Article' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Article\ArticleController(
                            $cm->getServiceLocator()->get('ArticleService'),
                            $cm->getServiceLocator()->get('FilterService')
                        );
                    },
                'Directorzone\Controller\Account\Account' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Account\AccountController(
                            $cm->getServiceLocator()->get('MessagingService')
                        );
                    },                    
                'CompanyView' =>
                    function (ControllerManager $cm) {
                        $companyService = $cm->getServiceLocator()->get('CompanyService');
                        $twitterService = $cm->getServiceLocator()->get('TwitterService');
                        $bingService = $cm->getServiceLocator()->get('BingService');
                        
                        return new \Directorzone\Controller\Directory\Company\CompanyViewController(
                            $companyService,
                            $twitterService,
                            $bingService
                        );
                    },
                'CompanyEdit' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\Company\CompanyEditController(
                            $cm->getServiceLocator()->get('CompanyService')
                        );
                    },
                'PeopleView' =>
                    function (ControllerManager $cm) {
                        $peopleService = $cm->getServiceLocator()->get('PeopleService');
                        $twitterService = $cm->getServiceLocator()->get('TwitterService');
                        $bingService = $cm->getServiceLocator()->get('BingService');
                        
                        return new \Directorzone\Controller\Directory\People\PeopleViewController(
                            $peopleService,
                            $twitterService,
                            $bingService
                        );
                    },
                'PeopleEdit' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\People\PeopleEditController(
                            $cm->getServiceLocator()->get('PeopleService')
                        );
                    },    
                'TalentPoolView' =>
                    function (ControllerManager $cm) {                    
                        return new \Directorzone\Controller\Directory\TalentPool\TalentPoolViewController(
                            $cm->getServiceLocator()->get('TalentPoolService')
                        );
                    },                                
                'TalentPoolEdit' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\TalentPool\TalentPoolEditController(
                            $cm->getServiceLocator()->get('TalentPoolService')
                        );
                    },
                'AjaxSearch' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\SearchController(
                            $cm->getServiceLocator()->get('ElasticService')
                        );
                    },
                'Search' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Search\SearchController();
                    },
                'Event' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Event\EventController();
                    },
            ),
        );
    }
    
    public function getServiceConfig()
    {
        $modelsAndGateways = [
            'Article',
            'CompanyDirectory',
            'UserProfessionalQualification',
            'UserCompany',
            'UserQualification',
            'UserLanguage',
            'ArticleSector',
            'ArticleGeography',
            'ArticleKeyEvent',
            'UserWhosWhoSector',
            'UserTargetRole',
            'ArticleJobArea',
        ];
        
        $tableGateways = array_merge(
            $modelsAndGateways,
            [
            'User',
            'CompanyOfficer',
            'CompanySicCode',
            'CompanyUpload',
            'CompaniesHouse',
            'Sector',
            'SectorParent',
            'Geography',
            'GeographyParent',
            'KeyEvent',
            'JobArea',
            ]
        );
        
        $models = array_merge(
            $modelsAndGateways,
            [
            'PeopleDirectory',
            ]
        );
        
        $forms = [
            'CompanyContactForm',
            'CompanyFeedsForm',
            'CompanyFinancials',
            'CompanyOfficers',
            'CompanyOverview',
            'CompanyNewCompany',
            'CompanyOwners',
            'CompanyRelationships',
            'CompanySectors',
            'AccountAccount',
            'AccountCompany',
            'AccountContact',
            'AccountExperience',
            'AccountInbox',
            'AccountMembership',
            'AccountPersonal',
            'AccountPreferences',
            'AccountProfile',
            'AccountDirectory',
            'PeopleFeeds',
        ];
        
        $tableGatewayFactories = [];
        
        foreach ($tableGateways as $tableGateway) {
            $tableName = strtolower($tableGateway);
            $tableGatewayFactories[$tableGateway . 'TableGateway'] = function ($sm) use ($tableName) {
                $instance = new TableGateway(
                    $tableName,
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
                return $instance;
            };    
        }
        
        $modelFactories = [];
        
        foreach ($models as $model) {
            $modelFactories[$model . 'Model'] = function ($sm) use ($model) {
                $className = "\\Directorzone\\Model\\$model";
                $instance = new $className();
                $instance->setServiceLocator($sm);
                return $instance;
            };
        }
        
        $formFactories = [];
        
        foreach ($forms as $form) {
            $formFactories[$form . 'Form'] = function ($sm) use ($form) {
                $parts = preg_split('/(?=[A-Z])/', lcfirst($form));
                $className = $form . 'Form';
                $classPath = '\\Directorzone\\Form\\' . ucfirst($parts[0]) . '\\' . $className;
                $form = new $classPath(lcfirst($className));
                $form->setTranslator($sm->get('translator'));
                $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                return $form;
            };
        }
        
        $otherFactories = array(
            'ZendCache' => function () {
                return \Zend\Cache\StorageFactory::factory(
                    array(
                        'adapter' => array(
                            'name' => 'filesystem',
                            'options' => array(
                                'dirLevel' => 2,
                                'cacheDir' => '/tmp',
                                'ttl' => 7200,
                                'dirPermission' => 0755,
                                'filePermission' => 0666,
                                'namespace' => 'directorzone',
                                'namespaceSeparator' => '-db-'
                            ),
                        ),
                        'plugins' => array('serializer'),
                    )
                );
            },
            'TwitterService' => function($sm) {
                $settings = $sm->get('config')['twitter'];
                $twitterApiExchange = new \TwitterAPIExchange($settings);
                return new TwitterService($twitterApiExchange);
            },
            'BingService' => function($sm) {
                $settings = $sm->get('config')['bing'];
                $bingClient = new \Bing\Client($settings['key'], 'json');
                return new BingService($bingClient);
            },
            'ElasticService' => function ($sm) {
                $elasticClient = new ElasticClient();
                
                $instance = new \Directorzone\Service\ElasticService(
                    $elasticClient,
                    $sm->get('CompaniesHouseTableGateway'),
                    $sm->get('CompanyOfficerTableGateway'),
                    $sm->get('CompanyDirectoryTableGateway'),
                    $sm->get('ArticleTableGateway')
                );
                
                return $instance;
            },
            'CompanyService' => function ($sm) {
                $instance = new CompanyService(
                    $sm->get('CompanyUploadTableGateway'),
                    $sm->get('CompaniesHouseTableGateway'),
                    $sm->get('CompanyDirectoryTableGateway'),
                    $sm->get('CompanySicCodeTableGateway'),
                    $sm->get('CompanyOfficerTableGateway'),
                    $sm->get('NetsensiaCompanies\Request\CompanyAppointmentsRequest')
                );
                return $instance;
            },
            'PeopleService' => function ($sm) {
                $instance = new PeopleService(
                    $sm->get('CompanyOfficerTableGateway')
                );
                return $instance;
            },
            'FilterService' => function ($sm) {
                $instance = new FilterService();
                return $instance;
            },
            'TalentPoolService' => function ($sm) {
                $instance = new TalentPoolService(
                    $sm->get('UserTableGateway')
                );
                return $instance;
            },
            'ArticleService' => function ($sm) {
                $instance = new ArticleService(
                    $sm->get('CommentsService'),
                    $sm->get('ArticleTableGateway'),
                    $sm->get('ArticleSectorTableGateway'),
                    $sm->get('ArticleGeographyTableGateway'),
                    $sm->get('ArticleKeyEventTableGateway'),
                    $sm->get('ArticleJobAreaTableGateway')
                );
                return $instance;
            },
            'CompanyUploadService' => function ($sm) {
                $instance = new CompanyUploadService(
                    $sm->get('CompanyUploadTableGateway')
                );
                return $instance;
            },
            'AccountPublishForm' =>  function ($sm) {
                $form = new AccountPublishForm('accountPublishForm');
                $authService = $sm->get('Zend\Authentication\AuthenticationService');
                $identity = $authService->getIdentity();
                $userId = $identity->getUserId();
                $userModel = $sm->get('UserModel')->init($identity->getUserId());
                $form->setUserModel($userModel);
                $form->setTranslator($sm->get('translator'));
                $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                return $form;
            },
        );
        
        $services = array(
        	'factories' => array_merge(
        	    $tableGatewayFactories,
        	    $modelFactories,
        	    $formFactories,
        	    $otherFactories
            )
        );
        
        return $services;
    }
}
