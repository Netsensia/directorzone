<?php
namespace Application\Controller;

use Netsensia\Controller\NetsensiaActionController;

class AccountController extends NetsensiaActionController
{
    public function indexAction()
    {
        $this->redirect()->toRoute('account-profile');
    }
        
    public function profileAction()
    {
       return [
            'flashMessages' => $this->getFlashMessages(),
       ];
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
