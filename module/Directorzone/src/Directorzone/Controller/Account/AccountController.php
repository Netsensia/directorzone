<?php

namespace Directorzone\Controller\Account;

use Netsensia\Controller\NetsensiaActionController;
use Zend\Mvc\MvcEvent;

class AccountController extends NetsensiaActionController
{
    public function onDispatch(MvcEvent $e)
    {
        if (!$this->isLoggedOn()) {
            return $this->redirect()->toRoute('login');
        }
        
        parent::onDispatch($e);
    }

    public function indexAction()
    {
        $this->redirect()->toRoute('account-personal');
    }
    
    public function accountAction()
    {
        return $this->genericForm('AccountAccountForm', 'User');
    }
        
    public function companyAction()
    {
        return $this->genericForm('AccountCompanyForm', 'User');
    }
        
    public function contactAction()
    {
        return $this->genericForm('AccountContactForm', 'User');
    }
        
    public function experienceAction()
    {
        return $this->genericForm('AccountExperienceForm', 'User');
    }
    
    public function inboxAction()
    {
        return $this->genericForm('AccountInboxForm', 'User');
    }
    
    public function membershipAction()
    {
        return $this->genericForm('AccountMembershipForm', 'User');
    }
        
    public function preferencesAction()
    {
        return $this->genericForm('AccountPreferencesForm', 'User');
    }

    public function personalAction()
    {
        return $this->genericForm('AccountPersonalForm', 'User');
    }
    
    public function profileAction()
    {
        return $this->genericForm('AccountProfileForm', 'User');
    }

    public function directoryAction()
    {
        return $this->genericForm('AccountDirectoryForm', 'User');
    }
    
    public function publishAction()
    {
        return $this->genericForm('AccountPublishForm', 'Article');
    }
    
    private function genericForm($formName, $modelName)
    {
        return array(
            "form" => $this->processForm(
                $formName,
                $modelName,
                $this->getUserId()
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
}
