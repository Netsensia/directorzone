<?php
namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;

class AccountController extends NetsensiaActionController
{
    public function indexAction()
    {
        $this->redirect()->toRoute('account-profile');
    }
        
    public function profileAction()
    {
        if (!$this->isLoggedOn()) {
            $this->redirect()->toRoute('home');
        }
        
        $form = $this->getServiceLocator()->get('AccountProfileForm');
        
        $form->prepare();
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $user = $this->loadModel('User', $this->getUserId());
            $formData = $request->getPost()->toArray();
            
            $form->setData($formData);
            
            if ($form->isValid()) {

                $prefix = $form->getFieldPrefix();
                $data = array_merge(
                    $user->getData(),
                    [
                        'titleid' => $formData[$prefix . 'title'],
                        'forenames' => $formData[$prefix . 'forenames'],
                        'surname' => $formData[$prefix . 'surname']
                    ]
                );                
                $user->setData($data);
                
                $user->save();
            } else {
                var_dump($form->getMessages()); die;
            }
            
        }
        
        return array(
            "form" => $form
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
