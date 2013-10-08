<?php

namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\EventManager\EventManagerInterface;
use Directorzone\Model\User as UserModel;

class AccountController extends NetsensiaActionController
{
    
    public function indexAction()
    {
        $this->redirect()->toRoute('account-profile');
    }
    
    public function profileAction()
    {
        return array(
            "form" => $this->processForm(
                'AccountProfileForm',
                'User'
            )
        );        
    }

    public function contactAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function membershipAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function accountAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function publishAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function inboxAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function preferencesAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function experienceAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
    
    public function companyAction()
    {
        return [
        'flashMessages' => $this->getFlashMessages(),
        ];
    }
}
