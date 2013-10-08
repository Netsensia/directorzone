<?php

namespace Directorzone\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class ProcessForm extends AbstractPlugin
{
    public function __invoke(
        $formName,
        $model
    ) 
    {

        $form = $this->controller->getServiceLocator()->get($formName);
        
        $form->prepare();
        
        $controller = $this->getController();
        
        $request = $controller->getRequest();
        
        $sl = $this->controller->getServiceLocator();
        $userModel = $sl->get($model . 'Model');
        
        $userModel->init($id);
        
        if ($request->isPost()) {
            $formData = $request->getPost()->toArray();
        
            $form->setData($formData);
        
            if ($form->isValid()) {
                $prefix = $form->getFieldPrefix();
                                
                $modelData = [];
                foreach ($formData as $key => $value) {
                    if ($key != 'form-submit') {
                        $modelField = preg_replace('/^' . $prefix . '/', '', $key);
                        $modelData[$modelField] = $value;
                    }
                }
                
                $data = array_merge(
                    $userModel->getData(),
                    $modelData
                );
                $userModel->setData($data);
        
                $userModel->save();
            }
        
        } else {
            $form->setDataFromModel($userModel);
        }        
        
        return $form;
        
    }
}
