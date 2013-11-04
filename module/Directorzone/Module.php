<?php


namespace Directorzone;

use Zend\Mvc\MvcEvent;

use Directorzone\Form\AccountAccountForm;
use Directorzone\Form\AccountCompanyForm;
use Directorzone\Form\AccountContactForm;
use Directorzone\Form\AccountExperienceForm;
use Directorzone\Form\AccountInboxForm;
use Directorzone\Form\AccountMembershipForm;
use Directorzone\Form\AccountPreferencesForm;
use Directorzone\Form\AccountProfileForm;
use Directorzone\Form\AccountPersonalForm;
use Directorzone\Form\AccountPublishForm;
use Directorzone\Form\AccountDirectoryForm;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'CompanyModel' => function (\Zend\ServiceManager\ServiceLocatorInterface $sl) {
                    $instance = new \Directorzone\Model\Company();
                    $instance->setServiceLocator($sl);
                    return $instance;
                },
                'AccountAccountForm' => function($sm) {
                    $form = new AccountAccountForm('accountAccountForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },                
                'AccountCompanyForm' => function($sm) {
                    $form = new AccountCompanyForm('accountCompanyForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },                
                'AccountContactForm' => function($sm) {
                    $form = new AccountContactForm('accountContactForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountExperienceForm' => function($sm) {
                    $form = new AccountExperienceForm('accountExperienceForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountInboxForm' => function($sm) {
                    $form = new AccountInboxForm('accountInboxForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountMembershipForm' => function($sm) {
                    $form = new AccountMembershipForm('accountMembershipForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountPersonalForm' => function($sm) {
                    $form = new AccountPersonalForm('accountPersonalForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountPreferencesForm' => function($sm) {
                    $form = new AccountPreferencesForm('accountPreferencesForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountProfileForm' => function($sm) {
                    $form = new AccountProfileForm('accountProfileForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },                
                'AccountPublishForm' =>  function($sm) {
                    $form = new AccountPublishForm('accountPublishForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                'AccountDirectoryForm' =>  function($sm) {
                    $form = new AccountDirectoryForm('accountDirectoryForm');
                    $form->setTranslator($sm->get('translator'));
                    $form->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
                    return $form;
                },
                
            ),
        );
    }
}
