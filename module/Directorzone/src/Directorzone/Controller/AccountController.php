<?php
namespace Directorzone\Controller;

use Netsensia\Controller\NetsensiaActionController;
use Zend\EventManager\EventManagerInterface;
use Directorzone\Model\User as UserModel;

class AccountController extends NetsensiaActionController
{
    private $userModel;
    private $form;
    
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);
    
        $controller = $this;
        
        $events->attach('dispatch', function ($e) use ($controller) {
            if (!$controller->isLoggedOn()) {
                $controller->redirect()->toRoute('home');
            } else {
                $controller->setUserModel($controller->loadModel('User', $controller->getUserId()));
            }
        }, 100); // execute before executing action logic
    
        return $this;
    }
    
    public function indexAction()
    {
        $this->redirect()->toRoute('account-profile');
    }
    
    public function setUserModel(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }
    
    private function prepareForm($formName)
    {
        $this->form = $this->getServiceLocator()->get('AccountProfileForm');
        
        $this->form->prepare();
    }
        
    public function profileAction()
    {
        $this->prepareForm('AccountProfileForm');
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $formData = $request->getPost()->toArray();
            
            $this->form->setData($formData);
            
            if ($this->form->isValid()) {

                $prefix = $this->form->getFieldPrefix();
                $data = array_merge(
                    $this->userModel->getData(),
                    [
                        'titleid'   => $formData[$prefix . 'title'],
                        'forenames' => $formData[$prefix . 'forenames'],
                        'surname'   => $formData[$prefix . 'surname']
                    ]
                );                
                $this->userModel->setData($data);
                
                $this->userModel->save();
            }
            
        } else {
            
        }
        
        return array(
            "form" => $this->form
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
