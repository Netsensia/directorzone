<?php

namespace Directorzone\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ProcessForm extends AbstractPlugin
{
    public function __invoke($formName) 
    {
        $form = $this->controller->getServiceLocator()->get($formName);
        $form->prepare();
        
        $controller = $this->getController();
        
        $request = $controller->getRequest();
        
        $sl = $this->controller->getServiceLocator();
        $userModel = $sl->get('UserModel');
        $userModel->init($id);
        
        if ($request->isPost()) {
            $formData = $request->getPost()->toArray();
        
            $form->setData($formData);
        
            if ($form->isValid()) {
        
                $prefix = $form->getFieldPrefix();
                $data = array_merge(
                    $userModel->getData(),
                    [
                        'titleid'   => $formData[$prefix . 'title'],
                        'forenames' => $formData[$prefix . 'forenames'],
                        'surname'   => $formData[$prefix . 'surname']
                    ]
                );
                $userModel->setData($data);
        
                $userModel->save();
            }
        
        } else {
        
        }        
        
        return $form;
        
    }
}
