<?php

namespace Directorzone\Controller;

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
        return array(
            "form" => $this->processForm(
                'AccountAccountForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );
    }
        
    public function companyAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountCompanyForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );
    }
        
    public function contactAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountContactForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );
    }
        
    public function experienceAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountExperienceForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function inboxAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountInboxForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );
    }    
    
    public function membershipAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountMembershipForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );
    }
        
    public function preferencesAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountPreferencesForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );
    }

    public function personalAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountPersonalForm',
                'User',
                $this->getUserId()
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function profileAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountProfileForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );        
    }

    public function directoryAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountDirectoryForm',
                'User',
                $this->getUserId()
            ),
            'flashMessages' => $this->getFlashMessages(),
        );
    }
    
    public function publishAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountPublishForm',
                'User',
                $this->getUserId()
            ),
        	'flashMessages' => $this->getFlashMessages(),
        );  
    }
}
