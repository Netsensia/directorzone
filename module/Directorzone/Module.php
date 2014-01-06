<?php


namespace Directorzone;

use Zend\Mvc\MvcEvent;

use Directorzone\Form\Account\AccountAccountForm;
use Directorzone\Form\Account\AccountCompanyForm;
use Directorzone\Form\Account\AccountContactForm;
use Directorzone\Form\Account\AccountExperienceForm;
use Directorzone\Form\Account\AccountInboxForm;
use Directorzone\Form\Account\AccountMembershipForm;
use Directorzone\Form\Account\AccountPreferencesForm;
use Directorzone\Form\Account\AccountProfileForm;
use Directorzone\Form\Account\AccountPersonalForm;
use Directorzone\Form\Account\AccountPublishForm;
use Directorzone\Form\Account\AccountDirectoryForm;
use Elasticsearch\Client as ElasticClient;
use Zend\Db\TableGateway\TableGateway;
use \Zend\Mvc\Controller\ControllerManager;
use Directorzone\Service\CompanyService;
use Directorzone\Service\Admin\CompanyUploadService;
use Directorzone\Service\PeopleService;
use Directorzone\Form\Company\CompanyContactForm;

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
                'Directorzone\Controller\Admin\Admin' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Admin\AdminController(
                            $cm->getServiceLocator()->get('CompanyService')
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
                'Directorzone\Controller\Directory\CompanyDirectoryController' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\CompanyDirectoryController(
                            $cm->getServiceLocator()->get('CompanyService')
                        );
                    },
                'Directorzone\Controller\Directory\PeopleDirectoryController' =>
                    function (ControllerManager $cm) {
                        return new \Directorzone\Controller\Directory\PeopleDirectoryController(
                            $cm->getServiceLocator()->get('PeopleService')
                        );
                    },
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ElasticService' => function ($sm) {
                    $elasticClient = new ElasticClient();

                    $companyTableGateway = $sm->get('CompaniesHouseTableGateway');
                    
                    $instance = new \Directorzone\Service\ElasticService(
                        $elasticClient,
                        $companyTableGateway
                    );
                    
                    return $instance;
                },
                'CompanyDirectoryTableGateway' => function ($sm) {
                
                    $instance = new TableGateway(
                        'companydirectory',
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                    return $instance;
                },
                'CompaniesHouseTableGateway' => function ($sm) {
                    
                    $instance = new TableGateway(
                        'companieshouse',
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                    return $instance;
                },
                'CompanyUploadTableGateway' => function ($sm) {
                
                    $instance = new TableGateway(
                        'companyupload',
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                    return $instance;
                },
                'CompanySicCodeTableGateway' => function ($sm) {
                
                    $instance = new TableGateway(
                        'companysiccode',
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                    return $instance;
                },
                'CompanyOfficersTableGateway' => function ($sm) {
                    $instance = new TableGateway(
                        'companyofficer',
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                    return $instance;
                },
                'CompanyService' => function ($sm) {
                    $instance = new CompanyService(
                        $sm->get('CompanyUploadTableGateway'),
                        $sm->get('CompaniesHouseTableGateway'),
                        $sm->get('CompanyDirectoryTableGateway'),
                        $sm->get('CompanySicCodeTableGateway'),
                        $sm->get('CompanyOfficersTableGateway'),
                        $sm->get('NetsensiaCompanies\Request\CompanyAppointmentsRequest')
                    );
                    return $instance;
                },
                'PeopleService' => function ($sm) {
                    $instance = new PeopleService(
                        $sm->get('CompanyOfficersTableGateway')
                    );
                    return $instance;
                },
                'CompanyUploadService' => function ($sm) {
                    $instance = new CompanyUploadService(
                        $sm->get('CompanyUploadTableGateway')
                    );
                    return $instance;
                },
                'CompanyModel' => function ($sm) {
                    $instance = new \Directorzone\Model\Company();
                    $instance->setServiceLocator($sm);
                    return $instance;
                },
                'CompanyContactForm' => function ($sm) {
                    $form = new CompanyContactForm('companyContactForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountAccountForm' => function ($sm) {
                    $form = new AccountAccountForm('accountAccountForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountCompanyForm' => function ($sm) {
                    $form = new AccountCompanyForm('accountCompanyForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountContactForm' => function ($sm) {
                    $form = new AccountContactForm('accountContactForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountExperienceForm' => function ($sm) {
                    $form = new AccountExperienceForm('accountExperienceForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountInboxForm' => function ($sm) {
                    $form = new AccountInboxForm('accountInboxForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountMembershipForm' => function ($sm) {
                    $form = new AccountMembershipForm('accountMembershipForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountPersonalForm' => function ($sm) {
                    $form = new AccountPersonalForm('accountPersonalForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountPreferencesForm' => function ($sm) {
                    $form = new AccountPreferencesForm('accountPreferencesForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountProfileForm' => function ($sm) {
                    $form = new AccountProfileForm('accountProfileForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountPublishForm' =>  function ($sm) {
                    $form = new AccountPublishForm('accountPublishForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountDirectoryForm' =>  function ($sm) {
                    $form = new AccountDirectoryForm('accountDirectoryForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                
            ),
        );
    }
}
