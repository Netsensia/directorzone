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
use Directorzone\Service\CompanyOwnersService;
use Directorzone\Service\AddressService;
use Directorzone\Model\CompanyDirectory;
use Directorzone\Form\Company\CompanyOwnersForm;
use Directorzone\Service\ExperienceService;
use Directorzone\Model\PeopleDirectory;
use Directorzone\Model\WhosWho;
use Directorzone\Service\WhosWhoService;
use Zend\Stdlib\ArrayUtils;
use Directorzone\Service\PeopleThisIsMeService;
use Directorzone\Form\People\PeopleThisIsMeForm;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    }

    public function getConfig()
    {
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/module.console.php',
            __DIR__ . '/config/module.routes.ajax.php',
            __DIR__ . '/config/module.routes.directories.php',
            __DIR__ . '/config/module.routes.directories.whoswho.php',
            __DIR__ . '/config/module.routes.directories.talentpool.php',
            __DIR__ . '/config/module.routes.directories.company.php',
            __DIR__ . '/config/module.routes.api.php',
            __DIR__ . '/config/module.routes.admin.php',
            __DIR__ . '/config/module.routes.articles.php',
            __DIR__ . '/config/module.routes.account.php',
            __DIR__ . '/config/module.routes.php',
        ];
        
        //---
        
        $config = array();
        
        // Merge all module config options
        foreach($configFiles as $configFile) {
            $config = ArrayUtils::merge( $config, include($configFile) );
        }
        
        return $config;
        
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
            	'ArticleFields' => 'Directorzone\View\Helper\ArticleFields',
                'ArticleAuthor' => 'Directorzone\View\Helper\ArticleAuthor',
                'Address' => 'Directorzone\View\Helper\Address',
            )
        );
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
                            $cm->getServiceLocator()->get('ElasticService'),
                            $cm->getServiceLocator()->get('CompanyUploadService')
                        );
                    },
                'Directorzone\Controller\Ajax\People' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\PeopleController(
                            $cm->getServiceLocator()->get('PeopleService')
                        );
                    },
                'Directorzone\Controller\Ajax\WhosWho' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\WhosWhoController();
                    },
                'Directorzone\Controller\Ajax\Experience' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\ExperienceController(
                            $cm->getServiceLocator()->get('ExperienceService')
                        );
                    },
                'Directorzone\Controller\Ajax\CompanyOwners' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\CompanyOwnersController(
                            $cm->getServiceLocator()->get('CompanyOwnersService')
                        );
                    },
                'Directorzone\Controller\Ajax\ThisIsMeClaims' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\ThisIsMeClaimsController(
                            $cm->getServiceLocator()->get('PeopleThisIsMeService')
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
                'Directorzone\Controller\Ajax\Filter' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Ajax\FilterController(
                            $cm->getServiceLocator()->get('FilterService')
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
                            $cm->getServiceLocator()->get('MessagingService'),
                            $cm->getServiceLocator()->get('TalentPoolService'),
                            $cm->getServiceLocator()->get('ExperienceService')
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
                'CompanyOwners' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\Company\CompanyOwnersController(
                            $cm->getServiceLocator()->get('CompanyOwnersService'),
                            $cm->getServiceLocator()->get('CompanyService')
                        );
                    },
                'PeopleThisIsMe' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\People\PeopleThisIsMeController(
                            $cm->getServiceLocator()->get('PeopleThisIsMeService'),
                            $cm->getServiceLocator()->get('WhosWhoService')
                        );
                    },
                'PeopleView' =>
                    function (ControllerManager $cm) {
                        $twitterService = $cm->getServiceLocator()->get('TwitterService');
                        $bingService = $cm->getServiceLocator()->get('BingService');
                        
                        return new \Directorzone\Controller\Directory\People\PeopleViewController(
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
            'UserProfessionalQualification',
            'UserQualification',
            'UserLanguage',
            'ArticleSector',
            'ArticleCategory',
            'ArticleGeography',
            'ArticleKeyEvent',
            'UserWhosWhoSector',
            'UserTargetRole',
            'ArticleJobArea',
            'UserCompany',
            'UserWhosWho',
            'CompanySector',
            'CompanyImportMarket',
            'CompanyExportMarket',
        	'CompanyRelationship',
            'CompanyPastName',        
            'CompanyPatent',
            'CompanyKeyword',
        ];
        
        $tableGateways = array_merge(
            $modelsAndGateways,
            [
            'Country',
            'Address',
            'CompanyDirectory',
            'User',
            'CompanyOfficer',
            'CompanySicCode',
            'CompanyUpload',
            'CompanyImportMarket',
            'CompanyExportMarket',
            'CompaniesHouse',
            'Sector',
            'SectorParent',
            'KeyEvent',
            'JobArea',
            'Relationship',
            'UserExperience',
            'WhosWho',
            ]
        );
        
        $models = array_merge(
            $modelsAndGateways,
            [
            ]
        );
        
        $forms = [
            'CompanyContactForm',
            'CompanyFeeds',
            'CompanyFinancials',
            'CompanyOfficers',
            'CompanyOverview',
            'CompanyNewCompany',
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
            'PeopleOverview',
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
                    $sm->get('ArticleTableGateway'),
                    $sm->get('AddressService')
                );
                
                return $instance;
            },
            'CompanyService' => function ($sm) {
                $instance = new CompanyService(
                    $sm->get('CompanyUploadTableGateway'),
                    $sm->get('CompaniesHouseTableGateway'),
                    $sm->get('CompanyDirectoryTableGateway'),
                    $sm->get('CompanySicCodeTableGateway'),
                    $sm->get('CompanySectorTableGateway'),
                    $sm->get('CompanyOfficerTableGateway'),
                    $sm->get('CompanyRelationshipTableGateway'),
                    $sm->get('CompanyPastNameTableGateway'),
                    $sm->get('CompanyKeywordTableGateway'),
                    $sm->get('CompanyPatentTableGateway'),
                    $sm->get('CompanyImportMarketTableGateway'),
                    $sm->get('CompanyExportMarketTableGateway'),
                    $sm->get('UserCompanyTableGateway'),
                    $sm->get('WhosWhoService'),
                    $sm->get('AddressService'),
                    $sm->get('NetsensiaCompanies\Request\CompanyAppointmentsRequest')
                );
                return $instance;
            },
            'PeopleService' => function ($sm) {
                $instance = new PeopleService(
                    $sm->get('CompanyOfficerTableGateway'),
                    $sm->get('AddressService')
                );
                return $instance;
            },
            'WhosWhoService' => function ($sm) {
                $instance = new WhosWhoService(
                    $sm->get('WhosWhoTableGateway'),
                    $sm->get('AddressService')
                );
                return $instance;
            },
            'CompanyOwnersService' => function ($sm) {
                $instance = new CompanyOwnersService(
                    $sm->get('UserCompanyTableGateway')
                );
                return $instance;
            },
            'PeopleThisIsMeService' => function ($sm) {
                $instance = new PeopleThisIsMeService(
                    $sm->get('UserWhosWhoTableGateway')
                );
                return $instance;
            },
            'FilterService' => function ($sm) {
                $instance = new FilterService(
                    $sm->get('GeographyTableGateway'),
                    $sm->get('SectorTableGateway'),
                    $sm->get('JobAreaTableGateway'),
                    $sm->get('KeyEventTableGateway')
                );
                return $instance;
            },
            'TalentPoolService' => function ($sm) {
                $instance = new TalentPoolService(
                    $sm->get('UserTableGateway'),
                    $sm->get('UserTargetRoleTableGateway'),
                    $sm->get('UserCompanyTableGateway')
                );
                return $instance;
            },
            'ArticleService' => function ($sm) {
                $instance = new ArticleService(
                    $sm->get('CommentsService'),
                    $sm->get('CompanyService'),
                    $sm->get('TalentPoolService'),
                    $sm->get('ArticleTableGateway'),
                    $sm->get('ArticleSectorTableGateway'),
                    $sm->get('ArticleGeographyTableGateway'),
                    $sm->get('ArticleKeyEventTableGateway'),
                    $sm->get('ArticleJobAreaTableGateway'),
                    $sm->get('ArticleCategoryTableGateway')
                );
                return $instance;
            },
            'AddressService' => function ($sm) {
                $instance = new AddressService(
                    $sm->get('AddressTableGateway'),
                    $sm->get('CountryTableGateway')
                );
                return $instance;
            },
            'ExperienceService' => function ($sm) {
                $instance = new ExperienceService(
                    $sm->get('CompanyService'),
                    $sm->get('UserExperienceTableGateway')
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
                $authService = $sm->get('Zend\Authentication\AuthenticationService');
                $identity = $authService->getIdentity();
                $userId = $identity->getUserId();
                $userModel = $sm->get('UserModel')->init($identity->getUserId());
                $form = new AccountPublishForm('accountPublishForm');
                $form->setUserModel($userModel);
                $form->setTranslator($sm->get('translator'));
                $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                return $form;
            },
            'CompanyOwnersForm' =>  function ($sm) {
                $authService = $sm->get('Zend\Authentication\AuthenticationService');
                $identity = $authService->getIdentity();
                $userId = $identity->getUserId();
                $userModel = $sm->get('UserModel')->init($identity->getUserId());
                $router = $sm->get('Router');
                $routeMatch = $router->match($sm->get('Request'));
                $params = $routeMatch->getParams();
                $companyId = $params['id'];
                $companyModel = $sm->get('CompanyDirectoryModel')->init($companyId);
                $companyService = $sm->get('CompanyService');
                $form = new CompanyOwnersForm('companyOwnersForm');
                $form->setUserModel($userModel);
                $form->setCompanyModel($companyModel);
                $form->setCompanyService($companyService);
                $form->setTranslator($sm->get('translator'));
                $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                return $form;
            },
            'PeopleThisIsMeForm' =>  function ($sm) {
                $authService = $sm->get('Zend\Authentication\AuthenticationService');
                $identity = $authService->getIdentity();
                $userId = $identity->getUserId();
                $userModel = $sm->get('UserModel')->init($identity->getUserId());
                $router = $sm->get('Router');
                $routeMatch = $router->match($sm->get('Request'));
                $params = $routeMatch->getParams();
                $whosWhoId = $params['id'];
                $whosWhoModel = $sm->get('WhosWhoModel')->init($whosWhoId);
                $whosWhoService = $sm->get('WhosWhoService');
                $form = new PeopleThisIsMeForm('peopleThisIsMeForm');
                $form->setUserModel($userModel);
                $form->setWhosWhoModel($whosWhoModel);
                $form->setWhosWhoService($whosWhoService);
                $form->setTranslator($sm->get('translator'));
                $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                return $form;
            },
            'WhosWhoModel' => function (\Zend\ServiceManager\ServiceLocatorInterface $sl) {
                $instance = new WhosWho();
                $instance->setServiceLocator($sl);
                
                $instance->setRelation('addressid', 'address');
                
                return $instance;
            },
            'PeopleDirectoryModel' => function (\Zend\ServiceManager\ServiceLocatorInterface $sl) {
                $instance = new PeopleDirectory();
                $instance->setServiceLocator($sl);
                
                $instance->setRelation('addressid', 'address');
                
                return $instance;
            },
            'CompanyDirectoryModel' => function (\Zend\ServiceManager\ServiceLocatorInterface $sl) {
                $instance = new CompanyDirectory();
                $instance->setServiceLocator($sl);
            
                $instance->setRelation('registeredaddressid', 'address');
                $instance->setRelation('tradingaddressid', 'address');
            
                return $instance;
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
